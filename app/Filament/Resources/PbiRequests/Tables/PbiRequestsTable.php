<?php

namespace App\Filament\Resources\PbiRequests\Tables;

use App\Enums\MinistryDecision;
use App\Enums\PbiReason;
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

class PbiRequestsTable
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
                    ->label('Pemohon')
                    ->searchable(),
                TextColumn::make('pbiReactivation.participant_name')
                    ->label('Nama Peserta BPJS')
                    ->searchable(),
                TextColumn::make('pbiReactivation.reason')
                    ->label('Alasan')
                    ->badge()
                    ->color(fn ($state) => match ($state instanceof PbiReason ? $state : PbiReason::tryFrom($state)) {
                        PbiReason::Emergency => 'danger',
                        PbiReason::Chronic, PbiReason::Catastrophic => 'warning',
                        PbiReason::Newborn => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state instanceof PbiReason ? $state->label() : (PbiReason::tryFrom($state)?->label() ?? $state)),
                TextColumn::make('pbiReactivation.bpjs_card_number')
                    ->label('No. Kartu BPJS')
                    ->copyable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ServiceRequestStatus|string $state): string => match ($state instanceof ServiceRequestStatus ? $state : ServiceRequestStatus::tryFrom($state)) {
                        ServiceRequestStatus::Submitted => 'gray',
                        ServiceRequestStatus::DocumentCheck, ServiceRequestStatus::EligibilityVerification => 'warning',
                        ServiceRequestStatus::RecommendationIssued => 'primary',
                        ServiceRequestStatus::ProposedToMinistry => 'info',
                        ServiceRequestStatus::MinistryApproved, ServiceRequestStatus::Reactivated, ServiceRequestStatus::Completed => 'success',
                        ServiceRequestStatus::Rejected, ServiceRequestStatus::MinistryRejected => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn ($state) => $state instanceof ServiceRequestStatus ? $state->label() : (ServiceRequestStatus::tryFrom($state)?->label() ?? $state))
                    ->sortable(),
                IconColumn::make('is_priority')
                    ->label('Darurat')
                    ->boolean()
                    ->trueIcon('heroicon-o-fire')
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
                Action::make('verifyEligibility')
                    ->label('Verifikasi Kelayakan')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('warning')
                    ->visible(fn (ServiceRequest $record) => in_array($record->status, [ServiceRequestStatus::Submitted, ServiceRequestStatus::DocumentCheck]))
                    ->schema([
                        Textarea::make('eligibility_notes')
                            ->label('Catatan Verifikasi Kelayakan')
                            ->default('Berkas lengkap dan memenuhi kriteria reaktivasi PBI-JK.')
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;

                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'eligibility_notes' => $data['eligibility_notes'],
                            ]);
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::EligibilityVerification,
                            'officer_id' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::EligibilityVerification->value,
                            'notes' => $data['eligibility_notes'],
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Kelayakan berhasil diverifikasi')
                            ->success()
                            ->send();
                    }),
                Action::make('issueRecommendation')
                    ->label('Terbitkan Rekomendasi')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->visible(fn (ServiceRequest $record) => in_array($record->status, [ServiceRequestStatus::EligibilityVerification, ServiceRequestStatus::AwaitingApproval]))
                    ->schema([
                        TextInput::make('recommendation_number')
                            ->label('Nomor Surat Rekomendasi')
                            ->default(fn () => '400.9.1/'.rand(100, 999).'/REK-PBI/'.date('Y'))
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;

                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'recommendation_number' => $data['recommendation_number'],
                                'recommendation_issued_at' => Carbon::now(),
                                'signer_id' => auth()->id(),
                            ]);
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::RecommendationIssued,
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::RecommendationIssued->value,
                            'notes' => "Rekomendasi diterbitkan: {$data['recommendation_number']}",
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Surat Rekomendasi Reaktivasi diterbitkan')
                            ->success()
                            ->send();
                    }),
                Action::make('proposeToMinistry')
                    ->label('Input ke SIKS-NG')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (ServiceRequest $record) => $record->status === ServiceRequestStatus::RecommendationIssued)
                    ->action(function (ServiceRequest $record) {
                        $oldStatus = $record->status->value;

                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'proposed_to_ministry_at' => Carbon::now(),
                            ]);
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::ProposedToMinistry,
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::ProposedToMinistry->value,
                            'notes' => 'Usulan telah diinput ke aplikasi SIKS-NG Kemensos',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Status diubah ke Diusulkan ke Kemensos')
                            ->info()
                            ->send();
                    }),
                Action::make('recordMinistryDecision')
                    ->label('Keputusan Kemensos')
                    ->icon('heroicon-o-building-library')
                    ->color('secondary')
                    ->visible(fn (ServiceRequest $record) => $record->status === ServiceRequestStatus::ProposedToMinistry)
                    ->schema([
                        Select::make('ministry_decision')
                            ->label('Keputusan Kemensos RI')
                            ->options([
                                MinistryDecision::Approved->value => 'Disetujui Kemensos',
                                MinistryDecision::Rejected->value => 'Ditolak Kemensos',
                            ])
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;
                        $isApproved = $data['ministry_decision'] === MinistryDecision::Approved->value;
                        $nextStatus = $isApproved ? ServiceRequestStatus::MinistryApproved : ServiceRequestStatus::MinistryRejected;

                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'ministry_decision' => $data['ministry_decision'],
                                'ministry_decided_at' => Carbon::now(),
                            ]);
                        }

                        $record->update([
                            'status' => $nextStatus,
                            'completed_at' => $isApproved ? null : Carbon::now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => $nextStatus->value,
                            'notes' => $isApproved ? 'Usulan disetujui Kemensos RI' : 'Usulan ditolak Kemensos RI',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title($isApproved ? 'Kemensos menyetujui usulan' : 'Kemensos menolak usulan')
                            ->color($isApproved ? 'success' : 'danger')
                            ->send();
                    }),
                Action::make('confirmActive')
                    ->label('Konfirmasi Aktif BPJS')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (ServiceRequest $record) => $record->status === ServiceRequestStatus::MinistryApproved)
                    ->schema([
                        DatePicker::make('reactivated_date')
                            ->label('Tanggal Aktif Kembali di BPJS')
                            ->default(Carbon::now())
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $oldStatus = $record->status->value;

                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'reactivated_date' => $data['reactivated_date'],
                            ]);
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::Completed,
                            'service_result' => "Kepesertaan PBI-JK telah aktif kembali di BPJS Kesehatan per tanggal {$data['reactivated_date']}.",
                            'completed_at' => Carbon::now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => ServiceRequest::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => ServiceRequestStatus::Completed->value,
                            'notes' => "Kepesertaan aktif kembali di BPJS per {$data['reactivated_date']}",
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Kepesertaan PBI-JK aktif kembali dan tiket selesai!')
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
