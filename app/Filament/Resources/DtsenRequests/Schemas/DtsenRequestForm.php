<?php

namespace App\Filament\Resources\DtsenRequests\Schemas;

use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\DtsenPurpose;
use App\Models\ServiceRequest;
use App\Models\User;
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

class DtsenRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tiket & Status')
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
                            ->label('Tandai Prioritas')
                            ->inline(false),
                    ]),

                Section::make('Data Pemohon')
                    ->description('Identitas warga yang mengajukan surat keterangan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('applicant_name')
                            ->label('Nama Lengkap Pemohon')
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
                            ->label('Nomor Kartu Keluarga (KK)')
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
                            ->label('Alamat Lengkap (RT/RW/Dusun)')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Data yang Diterangkan & Tujuan SK DTSEN')
                    ->description('Data orang yang diterangkan dalam surat (misal anak/calon siswa)')
                    ->relationship('dtsenCertificate')
                    ->columns(2)
                    ->schema([
                        TextInput::make('subject_name')
                            ->label('Nama Orang yang Diterangkan')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('subject_nik')
                            ->label('NIK Orang yang Diterangkan')
                            ->required()
                            ->length(16)
                            ->numeric(),
                        TextInput::make('relationship_to_applicant')
                            ->label('Hubungan dengan Pemohon')
                            ->placeholder('Contoh: Anak Kandung, Kepala Keluarga, Istri')
                            ->required()
                            ->maxLength(100),
                        Select::make('dtsen_purpose_id')
                            ->label('Tujuan Penggunaan Surat')
                            ->options(DtsenPurpose::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Textarea::make('purpose_description')
                            ->label('Keterangan Tambahan / Instansi Tujuan')
                            ->placeholder('Contoh: Untuk persyaratan pendaftaran SPMB SMAN 1 Talun')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pemeriksaan SIKS-NG & Penerbitan Surat')
                    ->description('Diisi oleh Petugas Dinsos setelah memeriksa basis data SIKS-NG')
                    ->relationship('dtsenCertificate')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_registered')
                            ->label('Terdaftar di SIKS-NG / DTSEN')
                            ->default(false),
                        Select::make('decile')
                            ->label('Peringkat Desil')
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
                            ]),
                        DateTimePicker::make('checked_at')
                            ->label('Waktu Pengecekan SIKS-NG'),
                        Select::make('checker_id')
                            ->label('Petugas Pengecek')
                            ->options(User::pluck('name', 'id'))
                            ->searchable(),
                        TextInput::make('certificate_number')
                            ->label('Nomor Surat Keterangan')
                            ->placeholder('Diterbitkan otomatis saat disetujui'),
                        DatePicker::make('valid_until')
                            ->label('Berlaku Sampai Tanggal'),
                    ]),

                Section::make('Catatan & Hasil Pelayanan')
                    ->columns(2)
                    ->schema([
                        Textarea::make('officer_notes')
                            ->label('Catatan Petugas Pelayanan')
                            ->placeholder('Catatan internal hasil verifikasi berkas'),
                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan (bila tidak memenuhi syarat)')
                            ->placeholder('Tuliskan alasan penolakan jika tidak sesuai batas desil'),
                        Textarea::make('service_result')
                            ->label('Hasil Layanan / Keterangan Penutupan Tiket')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
