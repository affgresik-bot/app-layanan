<?php

namespace App\Filament\Resources\RehabilitationCases\Pages;

use App\Filament\Resources\RehabilitationCases\RehabilitationCaseResource;
use App\Models\NumberSequence;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateRehabilitationCase extends CreateRecord
{
    protected static string $resource = RehabilitationCaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['case_number'])) {
            $data['case_number'] = NumberSequence::next('RHS');
        }

        if (empty($data['received_at'])) {
            $data['received_at'] = Carbon::now();
        }

        return $data;
    }
}
