<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('clientCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->placeholder('Belum ada NIK'),
                TextColumn::make('gender')
                    ->label('JK')
                    ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-laki' : ($state === 'P' ? 'Perempuan' : $state)),
                TextColumn::make('village.district.name')
                    ->label('Kecamatan')
                    ->sortable(),
                TextColumn::make('village.name')
                    ->label('Desa/Kelurahan'),
                TextColumn::make('phone')
                    ->label('Telepon/Wali')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('client_category_id')
                    ->label('Kategori Klien')
                    ->relationship('clientCategory', 'name'),
                SelectFilter::make('district')
                    ->label('Kecamatan')
                    ->relationship('village.district', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
