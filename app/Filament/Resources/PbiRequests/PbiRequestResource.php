<?php

namespace App\Filament\Resources\PbiRequests;

use App\Filament\Resources\PbiRequests\Pages\CreatePbiRequest;
use App\Filament\Resources\PbiRequests\Pages\EditPbiRequest;
use App\Filament\Resources\PbiRequests\Pages\ListPbiRequests;
use App\Filament\Resources\PbiRequests\Pages\ViewPbiRequest;
use App\Filament\Resources\PbiRequests\Schemas\PbiRequestForm;
use App\Filament\Resources\PbiRequests\Tables\PbiRequestsTable;
use App\Models\ServiceRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PbiRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static string|UnitEnum|null $navigationGroup = 'Layanan PBI-JK';

    protected static ?string $modelLabel = 'Pengajuan Reaktivasi PBI-JK';

    protected static ?string $pluralModelLabel = 'Pengajuan Reaktivasi PBI-JK';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    public static function form(Schema $schema): Schema
    {
        return PbiRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PbiRequestsTable::configure($table);
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
            'index' => ListPbiRequests::route('/'),
            'create' => CreatePbiRequest::route('/create'),
            'view' => ViewPbiRequest::route('/{record}'),
            'edit' => EditPbiRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('serviceType', fn (Builder $query) => $query->where('handler', 'pbi'));
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
