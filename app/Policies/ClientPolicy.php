<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
        return $user->hasAnyRole(['petugas_dinsos', 'pimpinan']);
    }

    public function view(User $user, Client $client): bool
    {
        return $user->hasAnyRole(['petugas_dinsos', 'pimpinan']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('petugas_dinsos');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->hasRole('petugas_dinsos');
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->hasRole('administrator');
    }
}
