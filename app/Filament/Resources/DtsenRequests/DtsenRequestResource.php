<?php

namespace App\Filament\Resources\DtsenRequests;

use App\Filament\Resources\DtsenRequests\Pages\CreateDtsenRequest;
use App\Filament\Resources\DtsenRequests\Pages\EditDtsenRequest;
use App\Filament\Resources\DtsenRequests\Pages\ListDtsenRequests;
use App\Filament\Resources\DtsenRequests\Pages\ViewDtsenRequest;
use App\Filament\Resources\DtsenRequests\Schemas\DtsenRequestForm;
use App\Filament\Resources\DtsenRequests\Tables\DtsenRequestsTable;
use App\Models\ServiceRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class DtsenRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static string|UnitEnum|null $navigationGroup = 'Layanan DTSEN';

    protected static ?string $modelLabel = 'Pengajuan SK DTSEN';

    protected static ?string $pluralModelLabel = 'Pengajuan SK DTSEN';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    public static function form(Schema $schema): Schema
    {
        return DtsenRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DtsenRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDtsenRequests::route('/'),
            'create' => CreateDtsenRequest::route('/create'),
            'view' => ViewDtsenRequest::route('/{record}'),
            'edit' => EditDtsenRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('serviceType', fn (Builder $query) => $query->where('handler', 'dtsen'));
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
