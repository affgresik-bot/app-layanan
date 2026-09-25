<?php

namespace App\Filament\Resources\DtsenRequests\Pages;

use App\Filament\Resources\DtsenRequests\DtsenRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDtsenRequest extends EditRecord
{
    protected static string $resource = DtsenRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
