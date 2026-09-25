<?php

namespace App\Policies;

use App\Models\PbiReactivation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PbiReactivationPolicy
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
        return $user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan', 'pimpinan']);
    }

    public function view(User $user, PbiReactivation $pbi): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan', 'pimpinan']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('petugas_dinsos');
    }

    public function update(User $user, PbiReactivation $pbi): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan']);
    }

    public function delete(User $user, PbiReactivation $pbi): bool
    {
        return $user->hasRole('administrator');
    }
}
