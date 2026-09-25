<?php

namespace App\Filament\Resources\DtsenRequests\Pages;

use App\Filament\Resources\DtsenRequests\DtsenRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDtsenRequest extends ViewRecord
{
    protected static string $resource = DtsenRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
