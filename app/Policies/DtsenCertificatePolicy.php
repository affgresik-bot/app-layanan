<?php

namespace App\Policies;

use App\Models\DtsenCertificate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DtsenCertificatePolicy
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

    public function view(User $user, DtsenCertificate $certificate): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan', 'pimpinan']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('petugas_dinsos');
    }

    public function update(User $user, DtsenCertificate $certificate): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'pejabat_penandatangan']);
    }

    public function delete(User $user, DtsenCertificate $certificate): bool
    {
        return $user->hasRole('administrator');
    }
}
