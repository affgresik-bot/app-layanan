<?php

namespace App\Filament\Resources\Complaints\Pages;

use App\Filament\Resources\Complaints\ComplaintResource;
use App\Models\NumberSequence;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateComplaint extends CreateRecord
{
    protected static string $resource = ComplaintResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['complaint_number'])) {
            $data['complaint_number'] = NumberSequence::next('ADU');
        }

        if (empty($data['reported_at'])) {
            $data['reported_at'] = Carbon::now();
        }

        if (auth()->check() && empty($data['reporter_id'])) {
            $data['reporter_id'] = auth()->id();
        }

        return $data;
    }
}
