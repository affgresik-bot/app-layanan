<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\District;
use App\Models\Village;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Klien')
                    ->description('Data diri klien pemerlu pelayanan kesejahteraan sosial (PPKS)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap Klien')
                            ->required()
                            ->maxLength(255),
                        Select::make('client_category_id')
                            ->label('Kategori Klien')
                            ->relationship('clientCategory', 'name')
                            ->options(ClientCategory::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('nik')
                            ->label('NIK (Boleh kosong jika belum punya/terlantar)')
                            ->length(16)
                            ->numeric(),
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir'),
                        TextInput::make('phone')
                            ->label('Nomor Telepon / Wali')
                            ->tel()
                            ->maxLength(20),
                    ]),

                Section::make('Domisili / Lokasi Penemuan')
                    ->columns(2)
                    ->schema([
                        Select::make('district_id')
                            ->label('Kecamatan')
                            ->options(District::pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('village_id', null))
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Select $component, $state, ?Client $record) {
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
                            ->label('Alamat Lengkap / Keterangan Lokasi')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
