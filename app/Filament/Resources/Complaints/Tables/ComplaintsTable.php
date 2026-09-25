<?php

namespace App\Filament\Resources\Complaints\Tables;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\Disposition;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\WorkUnit;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('complaint_number')
                    ->label('No. Pengaduan')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('reporter_name')
                    ->label('Pelapor')
                    ->searchable(),
                TextColumn::make('reporter_phone')
                    ->label('No. HP')
                    ->searchable(),
                TextColumn::make('complaintCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('village.district.name')
                    ->label('Kecamatan')
                    ->sortable(),
                TextColumn::make('village.name')
                    ->label('Desa/Kelurahan'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ComplaintStatus|string $state): string => match ($state instanceof ComplaintStatus ? $state : ComplaintStatus::tryFrom($state)) {
                        ComplaintStatus::Received => 'gray',
                        ComplaintStatus::Verification => 'warning',
                        ComplaintStatus::ClarificationRequested => 'danger',
                        ComplaintStatus::Dispatched, ComplaintStatus::InHandling => 'info',
                        ComplaintStatus::Resolved => 'success',
                        ComplaintStatus::Duplicate, ComplaintStatus::Invalid => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn ($state) => $state instanceof ComplaintStatus ? $state->label() : (ComplaintStatus::tryFrom($state)?->label() ?? $state))
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Petugas')
                    ->placeholder('-'),
                TextColumn::make('reported_at')
                    ->label('Tanggal Lapor')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('reported_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(collect(ComplaintStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
                SelectFilter::make('complaint_category_id')
                    ->label('Kategori')
                    ->relationship('complaintCategory', 'name'),
                SelectFilter::make('district')
                    ->label('Kecamatan')
                    ->relationship('village.district', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('verifyComplaint')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('warning')
                    ->visible(fn (Complaint $record) => $record->status === ComplaintStatus::Received)
                    ->schema([
                        Textarea::make('verification_result')
                            ->label('Hasil Verifikasi Lapangan / Dokumen')
                            ->default('Laporan valid dan perlu penanganan lebih lanjut.')
                            ->required(),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => ComplaintStatus::Verification,
                            'verification_result' => $data['verification_result'],
                            'officer_id' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => Complaint::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ComplaintStatus::Verification->value,
                            'notes' => $data['verification_result'],
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Laporan pengaduan berhasil diverifikasi')
                            ->success()
                            ->send();
                    }),
                Action::make('dispatchComplaint')
                    ->label('Disposisi')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->color('info')
                    ->visible(fn (Complaint $record) => in_array($record->status, [ComplaintStatus::Received, ComplaintStatus::Verification]))
                    ->schema([
                        Select::make('to_work_unit_id')
                            ->label('Disposisi ke Unit Kerja / Bidang')
                            ->options(WorkUnit::where('is_active', true)->pluck('name', 'id'))
                            ->required(),
                        Select::make('to_user_id')
                            ->label('Tugaskan ke Petugas Spesifik (Opsional)')
                            ->options(User::pluck('name', 'id'))
                            ->searchable(),
                        Textarea::make('instructions')
                            ->label('Instruksi Penanganan')
                            ->placeholder('Contoh: Segera lakukan asesmen ke lokasi')
                            ->required(),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $oldStatus = $record->status->value;

                        Disposition::create([
                            'dispositionable_type' => Complaint::class,
                            'dispositionable_id' => $record->id,
                            'from_user_id' => auth()->id(),
                            'to_work_unit_id' => $data['to_work_unit_id'],
                            'to_user_id' => $data['to_user_id'] ?? null,
                            'instructions' => $data['instructions'],
                            'disposed_at' => Carbon::now(),
                        ]);

                        $record->update([
                            'status' => ComplaintStatus::Dispatched,
                            'officer_id' => $data['to_user_id'] ?? $record->officer_id,
                        ]);

                        StatusHistory::create([
                            'statusable_type' => Complaint::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ComplaintStatus::Dispatched->value,
                            'notes' => 'Disposisi: '.$data['instructions'],
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pengaduan berhasil didisposisikan')
                            ->success()
                            ->send();
                    }),
                Action::make('resolveComplaint')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Complaint $record) => in_array($record->status, [ComplaintStatus::Dispatched, ComplaintStatus::InHandling]))
                    ->schema([
                        Textarea::make('action_taken')
                            ->label('Tindakan / Hasil Penanganan')
                            ->placeholder('Jelaskan tindakan nyata yang telah dilaksanakan')
                            ->required(),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => ComplaintStatus::Resolved,
                            'action_taken' => $data['action_taken'],
                            'resolved_at' => Carbon::now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => Complaint::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ComplaintStatus::Resolved->value,
                            'notes' => 'Tindakan: '.$data['action_taken'],
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pengaduan dinyatakan Selesai')
                            ->success()
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
