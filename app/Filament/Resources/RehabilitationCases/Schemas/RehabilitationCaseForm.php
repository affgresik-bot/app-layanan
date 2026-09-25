<?php

namespace App\Filament\Resources\RehabilitationCases\Schemas;

use App\Enums\HandlingType;
use App\Enums\RehabilitationCaseStatus;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class RehabilitationCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kasus & Klien')
                    ->columns(2)
                    ->schema([
                        TextInput::make('case_number')
                            ->label('Nomor Kasus')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Otomatis dibuat saat disimpan'),
                        Select::make('client_id')
                            ->label('Klien PPKS')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('handling_type')
                            ->label('Rencana Penanganan')
                            ->options(collect(HandlingType::cases())->mapWithKeys(fn ($case) => [$case->value => match ($case) {
                                HandlingType::Direct => 'Pelayanan Langsung oleh Dinsos',
                                HandlingType::Referral => 'Rujukan ke Lembaga Mitra/Panti/RS',
                                HandlingType::Both => 'Pelayanan Langsung dan Rujukan',
                            }]))
                            ->default(HandlingType::Direct->value)
                            ->required(),
                        Select::make('status')
                            ->label('Status Kasus')
                            ->options(collect(RehabilitationCaseStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->default(RehabilitationCaseStatus::Received->value)
                            ->required(),
                        Select::make('officer_id')
                            ->label('Petugas Penanggung Jawab (Peksos)')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->default(fn () => auth()->id())
                            ->required(),
                        DateTimePicker::make('received_at')
                            ->label('Waktu Penerimaan Kasus')
                            ->default(Carbon::now())
                            ->required(),
                    ]),

                Section::make('Sumber Rujukan / Asal Kasus')
                    ->description('Jika kasus berasal dari pengajuan masyarakat atau laporan pengaduan')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Select::make('service_request_id')
                            ->label('Berasal dari Pengajuan Layanan (Tiket)')
                            ->options(ServiceRequest::pluck('request_number', 'id'))
                            ->searchable(),
                        Select::make('complaint_id')
                            ->label('Berasal dari Laporan Pengaduan')
                            ->options(Complaint::pluck('complaint_number', 'id'))
                            ->searchable(),
                    ]),

                Section::make('Hasil Akhir & Penutupan Kasus')
                    ->columns(2)
                    ->schema([
                        Textarea::make('handling_result')
                            ->label('Catatan Hasil Penanganan Akhir')
                            ->placeholder('Wajib diisi sebelum status diubah ke Kasus Ditutup / Selesai')
                            ->columnSpanFull(),
                        DateTimePicker::make('closed_at')
                            ->label('Waktu Penutupan Kasus'),
                    ]),
            ]);
    }
}
