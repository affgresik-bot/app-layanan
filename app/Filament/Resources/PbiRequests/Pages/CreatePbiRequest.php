<?php

namespace App\Filament\Resources\PbiRequests\Pages;

use App\Enums\ServiceRequestStatus;
use App\Filament\Resources\PbiRequests\PbiRequestResource;
use App\Models\NumberSequence;
use App\Models\ServiceType;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreatePbiRequest extends CreateRecord
{
    protected static string $resource = PbiRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $pbiType = ServiceType::where('handler', 'pbi')->first();
        if ($pbiType) {
            $data['service_type_id'] = $pbiType->id;
        }

        if (empty($data['request_number'])) {
            $data['request_number'] = NumberSequence::next('PBI');
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
