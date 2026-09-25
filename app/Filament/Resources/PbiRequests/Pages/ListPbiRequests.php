<?php

namespace App\Filament\Resources\PbiRequests\Pages;

use App\Filament\Resources\PbiRequests\PbiRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPbiRequests extends ListRecords
{
    protected static string $resource = PbiRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
