<?php

namespace App\Filament\Resources\RehabilitationCases\Tables;

use App\Enums\HandlingType;
use App\Enums\RehabilitationCaseStatus;
use App\Models\RehabilitationCase;
use App\Models\StatusHistory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class RehabilitationCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('case_number')
                    ->label('No. Kasus')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('client.name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.clientCategory.name')
                    ->label('Kategori Klien')
                    ->badge()
                    ->color('info'),
                TextColumn::make('handling_type')
                    ->label('Penanganan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state instanceof HandlingType ? $state : HandlingType::tryFrom($state)) {
                        HandlingType::Direct => 'Langsung',
                        HandlingType::Referral => 'Rujukan',
                        HandlingType::Both => 'Kombinasi',
                        default => $state,
                    }),
                TextColumn::make('status')
                    ->label('Status Kasus')
                    ->badge()
                    ->color(fn (RehabilitationCaseStatus|string $state): string => match ($state instanceof RehabilitationCaseStatus ? $state : RehabilitationCaseStatus::tryFrom($state)) {
                        RehabilitationCaseStatus::Received => 'gray',
                        RehabilitationCaseStatus::Assessment => 'warning',
                        RehabilitationCaseStatus::ServicePlanning => 'info',
                        RehabilitationCaseStatus::InService => 'primary',
                        RehabilitationCaseStatus::Monitoring => 'warning',
                        RehabilitationCaseStatus::Closed => 'success',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn ($state) => $state instanceof RehabilitationCaseStatus ? $state->label() : (RehabilitationCaseStatus::tryFrom($state)?->label() ?? $state))
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Petugas (Peksos)')
                    ->searchable(),
                TextColumn::make('received_at')
                    ->label('Diterima')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('received_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(collect(RehabilitationCaseStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
                SelectFilter::make('handling_type')
                    ->label('Jenis Penanganan')
                    ->options([
                        HandlingType::Direct->value => 'Langsung',
                        HandlingType::Referral->value => 'Rujukan',
                        HandlingType::Both->value => 'Kombinasi',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('startAssessment')
                    ->label('Mulai Asesmen')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->color('warning')
                    ->visible(fn (RehabilitationCase $record) => $record->status === RehabilitationCaseStatus::Received)
                    ->action(function (RehabilitationCase $record) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => RehabilitationCaseStatus::Assessment,
                            'officer_id' => auth()->id(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => RehabilitationCase::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => RehabilitationCaseStatus::Assessment->value,
                            'notes' => 'Petugas memulai tahapan asesmen kondisi dan kebutuhan klien',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Status diubah ke Asesmen Klien')
                            ->success()
                            ->send();
                    }),
                Action::make('planService')
                    ->label('Rencana Pelayanan')
                    ->icon('heroicon-o-map')
                    ->color('info')
                    ->visible(fn (RehabilitationCase $record) => $record->status === RehabilitationCaseStatus::Assessment)
                    ->action(function (RehabilitationCase $record) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => RehabilitationCaseStatus::ServicePlanning,
                        ]);

                        StatusHistory::create([
                            'statusable_type' => RehabilitationCase::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => RehabilitationCaseStatus::ServicePlanning->value,
                            'notes' => 'Penyusunan rencana intervensi pelayanan klien',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Status diubah ke Rencana Pelayanan')
                            ->info()
                            ->send();
                    }),
                Action::make('startService')
                    ->label('Mulai Pelayanan')
                    ->icon('heroicon-o-play')
                    ->color('primary')
                    ->visible(fn (RehabilitationCase $record) => $record->status === RehabilitationCaseStatus::ServicePlanning)
                    ->action(function (RehabilitationCase $record) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => RehabilitationCaseStatus::InService,
                        ]);

                        StatusHistory::create([
                            'statusable_type' => RehabilitationCase::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => RehabilitationCaseStatus::InService->value,
                            'notes' => 'Pelaksanaan intervensi pelayanan rehabilitasi',
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Status diubah ke Dalam Pelayanan')
                            ->success()
                            ->send();
                    }),
                Action::make('closeCase')
                    ->label('Tutup Kasus')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (RehabilitationCase $record) => in_array($record->status, [RehabilitationCaseStatus::InService, RehabilitationCaseStatus::Monitoring]))
                    ->schema([
                        Textarea::make('handling_result')
                            ->label('Catatan Hasil Penanganan / Evaluasi Akhir')
                            ->placeholder('Jelaskan kondisi akhir klien dan tindak lanjut')
                            ->required(),
                    ])
                    ->action(function (RehabilitationCase $record, array $data) {
                        $oldStatus = $record->status->value;
                        $record->update([
                            'status' => RehabilitationCaseStatus::Closed,
                            'handling_result' => $data['handling_result'],
                            'closed_at' => Carbon::now(),
                        ]);

                        StatusHistory::create([
                            'statusable_type' => RehabilitationCase::class,
                            'statusable_id' => $record->id,
                            'from_status' => $oldStatus,
                            'to_status' => RehabilitationCaseStatus::Closed->value,
                            'notes' => 'Kasus ditutup. Hasil: '.$data['handling_result'],
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Kasus rehabilitasi sosial berhasil ditutup')
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
