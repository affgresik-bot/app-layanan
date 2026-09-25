<?php

namespace App\Filament\Resources\PbiRequests\Pages;

use App\Filament\Resources\PbiRequests\PbiRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPbiRequest extends EditRecord
{
    protected static string $resource = PbiRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
