<?php

namespace App\Filament\Resources\DtsenRequests\Pages;

use App\Enums\ServiceRequestStatus;
use App\Filament\Resources\DtsenRequests\DtsenRequestResource;
use App\Models\NumberSequence;
use App\Models\ServiceType;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateDtsenRequest extends CreateRecord
{
    protected static string $resource = DtsenRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $dtsenType = ServiceType::where('handler', 'dtsen')->first();
        if ($dtsenType) {
            $data['service_type_id'] = $dtsenType->id;
        }

        if (empty($data['request_number'])) {
            $data['request_number'] = NumberSequence::next('DTSEN');
        }

        if (empty($data['submitted_at'])) {
            $data['submitted_at'] = Carbon::now();
        }

        if (empty($data['status'])) {
            $data['status'] = ServiceRequestStatus::Submitted;
        }

        if (auth()->check()) {
            $data['submitter_id'] = auth()->id();
        }

        return $data;
    }
}
