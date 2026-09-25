<?php

namespace App\Filament\Resources\DtsenRequests\Tables;

use App\Enums\ServiceRequestStatus;
use App\Models\ServiceRequest;
use App\Models\StatusHistory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DtsenRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('request_number')
                    ->label('No. Tiket')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('applicant_name')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('applicant_nik')
                    ->label('NIK')
                    ->searchable(),
                TextColumn::make('village.district.name')
                    ->label('Kecamatan')
                    ->sortable(),
                TextColumn::make('village.name')
                    ->label('Desa/Kelurahan'),
                TextColumn::make('dtsenCertificate.dtsenPurpose.name')
                    ->label('Tujuan SK')
                    ->badge()
                    ->color('info')
                    ->placeholder('-'),
                TextColumn::make('dtsenCertificate.decile')
                    ->label('Desil')
                    ->badge()
                    ->color(fn ($state) => match ((int) $state) {
                        1, 2 => 'danger',
                        3, 4 => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state ? "Desil {$state}" : '-')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ServiceRequestStatus|string $state): string => match ($state instanceof ServiceRequestStatus ? $state : ServiceRequestStatus::tryFrom($state)) {
                        ServiceRequestStatus::Submitted => 'gray',
                        ServiceRequestStatus::DocumentCheck, ServiceRequestStatus::Verification => 'warning',
                        ServiceRequestStatus::RevisionRequested => 'danger',
                        ServiceRequestStatus::DataVerification, ServiceRequestStatus::Assessment => 'info',
                        ServiceRequestStatus::AwaitingApproval => 'warning',
                        ServiceRequestStatus::Issued, ServiceRequestStatus::Completed => 'success',
                        ServiceRequestStatus::Rejected => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn ($state) => $state instanceof ServiceRequestStatus ? $state->label() : (ServiceRequestStatus::tryFrom($state)?->label() ?? $state))
                    ->sortable(),
                IconColumn::make('is_priority')
                    ->label('Prioritas')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-circle')
                    ->falseIcon('')
                    ->trueColor('danger'),
                TextColumn::make('submitted_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(collect(ServiceRequestStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
                SelectFilter::make('district')
                    ->label('Kecamatan')
                    ->relationship('village.district', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('verifyDocument')
                    ->label('Periksa Berkas')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->color('warning')
                    ->visible(fn (ServiceRequest $record) => $record->status === ServiceRequestStatus::Submitted)
                    ->action(function (ServiceRequest $record) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => ServiceRequestStatus::DocumentCheck,
                            'officer_id' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::DocumentCheck->value,
                            'notes' => 'Petugas mulai memeriksa berkas persyaratan',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Status diubah ke Pemeriksaan Berkas')
                            ->success()
                            ->send();
                    }),
                Action::make('checkSiksNg')
                    ->label('Cek SIKS-NG')
                    ->icon('heroicon-o-check-badge')
                    ->color('info')
                    ->visible(fn (ServiceRequest $record) => in_array($record->status, [ServiceRequestStatus::DocumentCheck, ServiceRequestStatus::RevisionRequested]))
                    ->schema([
                        Select::make('decile')
                            ->label('Hasil Cek Desil SIKS-NG')
                            ->options([
                                1 => 'Desil 1 (Sangat Miskin)',
                                2 => 'Desil 2 (Miskin)',
                                3 => 'Desil 3 (Hampir Miskin)',
                                4 => 'Desil 4 (Rentan Miskin)',
                                5 => 'Desil 5 (Menengah Bawah)',
                                6 => 'Desil 6 (Menengah)',
                                7 => 'Desil 7 (Menengah)',
                                8 => 'Desil 8 (Menengah)',
                                9 => 'Desil 9 (Menengah Atas)',
                                10 => 'Desil 10 (Mampu)',
                            ])
                            ->required(),
                        Textarea::make('verification_result')
                            ->label('Catatan Hasil Verifikasi')
                            ->default('Terdaftar aktif pada pangkalan data DTSEN / SIKS-NG Kabupaten Blitar'),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;

                        if ($record->dtsenCertificate) {
                            $record->dtsenCertificate->update([
                                'is_registered' => true,
                                'decile' => $data['decile'],
                                'checked_at' => Carbon::now(),
                                'checker_id' => auth()->id(),
                            ]);
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::DataVerification,
                            'verification_result' => $data['verification_result'],
                            'officer_id' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::DataVerification->value,
                            'notes' => "Hasil cek SIKS-NG: Desil {$data['decile']}",
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Hasil verifikasi SIKS-NG berhasil disimpan')
                            ->success()
                            ->send();
                    }),
                Action::make('approveAndIssue')
                    ->label('Setujui & Terbitkan Surat')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (ServiceRequest $record) => in_array($record->status, [ServiceRequestStatus::DataVerification, ServiceRequestStatus::AwaitingApproval]))
                    ->schema([
                        TextInput::make('certificate_number')
                            ->label('Nomor Surat Keterangan')
                            ->default(fn () => '400.9/'.rand(100, 999).'/409.105/'.date('Y'))
                            ->required(),
                        DatePicker::make('valid_until')
                            ->label('Masa Berlaku Surat')
                            ->default(Carbon::now()->addMonths(6))
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;

                        if ($record->dtsenCertificate) {
                            $record->dtsenCertificate->update([
                                'certificate_number' => $data['certificate_number'],
                                'issued_at' => Carbon::now(),
                                'valid_until' => $data['valid_until'],
                                'signer_id' => auth()->id(),
                                'verification_code' => Str::random(12),
                            ]);
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::Issued,
                            'service_result' => 'Surat Keterangan DTSEN telah disetujui dan diterbitkan.',
                            'completed_at' => Carbon::now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::Issued->value,
                            'notes' => "Surat Keterangan diterbitkan dengan nomor {$data['certificate_number']}",
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Surat Keterangan berhasil diterbitkan')
                            ->success()
                            ->send();
                    }),
                Action::make('rejectRequest')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (ServiceRequest $record) => ! in_array($record->status, [ServiceRequestStatus::Completed, ServiceRequestStatus::Issued, ServiceRequestStatus::Rejected]))
                    ->schema([
                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->placeholder('Contoh: Desil melebihi batas ketentuan SPMB afirmasi (Maksimal Desil 5)')
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => ServiceRequestStatus::Rejected,
                            'rejection_reason' => $data['rejection_reason'],
                            'completed_at' => Carbon::now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::Rejected->value,
                            'notes' => 'Alasan: '.$data['rejection_reason'],
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pengajuan ditolak')
                            ->danger()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
