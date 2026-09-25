<?php

namespace App\Filament\Resources\PbiRequests\Pages;

use App\Filament\Resources\PbiRequests\PbiRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPbiRequest extends ViewRecord
{
    protected static string $resource = PbiRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
