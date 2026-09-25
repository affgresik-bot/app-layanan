<?php

namespace App\Filament\Resources\Complaints\Schemas;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\User;
use App\Models\Village;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan Pengaduan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('complaint_number')
                            ->label('Nomor Pengaduan')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Otomatis dibuat saat disimpan'),
                        Select::make('complaint_category_id')
                            ->label('Kategori Permasalahan Sosial')
                            ->options(ComplaintCategory::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->label('Status Pengaduan')
                            ->options(collect(ComplaintStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->default(ComplaintStatus::Received->value)
                            ->required(),
                        DateTimePicker::make('reported_at')
                            ->label('Waktu Pelaporan')
                            ->default(Carbon::now())
                            ->required(),
                    ]),

                Section::make('Data Pelapor')
                    ->columns(2)
                    ->schema([
                        TextInput::make('reporter_name')
                            ->label('Nama Lengkap Pelapor')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('reporter_phone')
                            ->label('Nomor WhatsApp / HP')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ]),

                Section::make('Lokasi & Deskripsi Permasalahan')
                    ->columns(2)
                    ->schema([
                        Select::make('district_id')
                            ->label('Kecamatan Kejadian')
                            ->options(District::pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('village_id', null))
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Select $component, $state, ?Complaint $record) {
                                if ($record && $record->village) {
                                    $component->state($record->village->district_id);
                                }
                            }),
                        Select::make('village_id')
                            ->label('Desa / Kelurahan')
                            ->options(function (Get $get) {
                                $districtId = $get('district_id');
                                if (! $districtId) {
                                    return Village::pluck('name', 'id');
                                }

                                return Village::where('district_id', $districtId)->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),
                        Textarea::make('location_detail')
                            ->label('Detail Alamat / Patokan Lokasi')
                            ->placeholder('Contoh: Dekat jembatan Desa Talun RT 02 RW 01')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Uraian Permasalahan Sosial')
                            ->placeholder('Jelaskan secara rinci permasalahan sosial yang dilaporkan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Verifikasi & Penanganan')
                    ->columns(2)
                    ->schema([
                        Select::make('officer_id')
                            ->label('Petugas yang Menangani')
                            ->options(User::pluck('name', 'id'))
                            ->searchable(),
                        Select::make('duplicate_of_id')
                            ->label('Laporan Induk (Bila Duplikat)')
                            ->options(Complaint::pluck('complaint_number', 'id'))
                            ->searchable(),
                        Textarea::make('verification_result')
                            ->label('Hasil Verifikasi Awal Petugas')
                            ->columnSpanFull(),
                        Textarea::make('action_taken')
                            ->label('Tindakan Penanganan yang Dilakukan')
                            ->placeholder('Wajib diisi sebelum pengaduan dinyatakan Selesai')
                            ->columnSpanFull(),
                        DateTimePicker::make('resolved_at')
                            ->label('Waktu Penyelesaian'),
                    ]),
            ]);
    }
}
