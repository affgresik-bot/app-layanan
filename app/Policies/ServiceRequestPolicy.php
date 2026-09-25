<?php

namespace App\Policies;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceRequestPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('administrator')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan', 'pimpinan', 'operator_daerah']);
    }

    public function view(User $user, ServiceRequest $serviceRequest): bool
    {
        if ($user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan', 'pimpinan'])) {
            return true;
        }

        if ($user->hasRole('operator_daerah')) {
            if ($user->village_id && $serviceRequest->village_id === $user->village_id) {
                return true;
            }
            if ($user->district_id && $serviceRequest->village?->district_id === $user->district_id) {
                return true;
            }

            return false;
        }

        return $serviceRequest->submitter_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'operator_daerah', 'masyarakat']);
    }

    public function update(User $user, ServiceRequest $serviceRequest): bool
    {
        if ($user->hasRole('petugas_dinsos')) {
            return true;
        }

        if ($user->hasRole('operator_daerah')) {
            // Operator can only edit draft / revision_requested in their area
            if (in_array($serviceRequest->status->value, ['submitted', 'revision_requested'])) {
                if ($user->village_id && $serviceRequest->village_id === $user->village_id) {
                    return true;
                }
                if ($user->district_id && $serviceRequest->village?->district_id === $user->district_id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function delete(User $user, ServiceRequest $serviceRequest): bool
    {
        return $user->hasRole('administrator');
    }
}
