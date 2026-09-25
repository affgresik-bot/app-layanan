<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintPolicy
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
        return $user->hasAnyRole(['petugas_dinsos', 'pimpinan', 'operator_daerah']);
    }

    public function view(User $user, Complaint $complaint): bool
    {
        if ($user->hasAnyRole(['petugas_dinsos', 'pimpinan'])) {
            return true;
        }

        if ($user->hasRole('operator_daerah')) {
            if ($user->village_id && $complaint->village_id === $user->village_id) {
                return true;
            }
            if ($user->district_id && $complaint->village?->district_id === $user->district_id) {
                return true;
            }

            return false;
        }

        return $complaint->reporter_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Complaint $complaint): bool
    {
        return $user->hasRole('petugas_dinsos');
    }

    public function delete(User $user, Complaint $complaint): bool
    {
        return $user->hasRole('administrator');
    }
}
