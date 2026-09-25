<?php

namespace App\Filament\Resources\PbiRequests\Schemas;

use App\Enums\MinistryDecision;
use App\Enums\PbiReason;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\ServiceRequest;
use App\Models\Village;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PbiRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tiket & Status Reaktivasi')
                    ->columns(3)
                    ->schema([
                        TextInput::make('request_number')
                            ->label('Nomor Tiket')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Otomatis dibuat saat disimpan'),
                        Select::make('status')
                            ->label('Status Pengajuan')
                            ->options(collect(ServiceRequestStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->default(ServiceRequestStatus::Submitted->value)
                            ->required(),
                        Toggle::make('is_priority')
                            ->label('Tandai Prioritas / Darurat Medis')
                            ->inline(false),
                    ]),

                Section::make('Data Pemohon')
                    ->columns(2)
                    ->schema([
                        TextInput::make('applicant_name')
                            ->label('Nama Pemohon')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Nomor WhatsApp / HP')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('applicant_nik')
                            ->label('NIK Pemohon')
                            ->required()
                            ->length(16)
                            ->numeric(),
                        TextInput::make('family_card_number')
                            ->label('Nomor KK')
                            ->required()
                            ->length(16)
                            ->numeric(),
                        Select::make('district_id')
                            ->label('Kecamatan')
                            ->options(District::pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('village_id', null))
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Select $component, $state, ?ServiceRequest $record) {
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
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Kepesertaan & Alasan Reaktivasi KIS/PBI-JK')
                    ->description('Data peserta penerima bantuan iuran yang dinonaktifkan')
                    ->relationship('pbiReactivation')
                    ->columns(2)
                    ->schema([
                        TextInput::make('participant_name')
                            ->label('Nama Peserta BPJS')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('participant_nik')
                            ->label('NIK Peserta')
                            ->required()
                            ->length(16)
                            ->numeric(),
                        TextInput::make('bpjs_card_number')
                            ->label('Nomor Kartu BPJS/KIS')
                            ->required()
                            ->maxLength(50),
                        DatePicker::make('deactivated_date')
                            ->label('Perkiraan Tanggal Nonaktif'),
                        Select::make('reason')
                            ->label('Alasan Reaktivasi')
                            ->options(collect(PbiReason::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($state === PbiReason::Emergency->value) {
                                    $set('../../is_priority', true);
                                }
                            }),
                        TextInput::make('health_facility_name')
                            ->label('Nama Fasilitas Kesehatan (RS/Puskesmas)')
                            ->placeholder('Wajib diisi bila alasan darurat medis/kronis'),
                        TextInput::make('health_letter_number')
                            ->label('Nomor Surat Keterangan Medis/Faskes'),
                        Textarea::make('eligibility_notes')
                            ->label('Catatan Verifikasi Kelayakan Dinsos')
                            ->columnSpanFull(),
                    ]),

                Section::make('Proses SIKS-NG & Tindak Lanjut Kemensos / BPJS')
                    ->description('Pencatatan alur pengusulan ke Kementerian Sosial RI')
                    ->relationship('pbiReactivation')
                    ->columns(2)
                    ->schema([
                        TextInput::make('recommendation_number')
                            ->label('Nomor Surat Rekomendasi Dinsos'),
                        DateTimePicker::make('proposed_to_ministry_at')
                            ->label('Tanggal Usulan Input ke SIKS-NG'),
                        Select::make('ministry_decision')
                            ->label('Keputusan Kemensos RI')
                            ->options(collect(MinistryDecision::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
                        DateTimePicker::make('ministry_decided_at')
                            ->label('Tanggal Keputusan Kemensos'),
                        DatePicker::make('reactivated_date')
                            ->label('Tanggal Konfirmasi Aktif Kembali di BPJS'),
                    ]),

                Section::make('Hasil Pelayanan & Penutupan')
                    ->columns(2)
                    ->schema([
                        Textarea::make('officer_notes')
                            ->label('Catatan Petugas Layanan'),
                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan (bila ditolak)'),
                        Textarea::make('service_result')
                            ->label('Hasil Layanan Akhir')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
