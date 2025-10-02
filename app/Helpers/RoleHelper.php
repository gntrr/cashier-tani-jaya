<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    public const ROLE_KASIR = 0;
    public const ROLE_ADMIN = 1;

    public static function isAdmin(?\App\Models\User $user = null): bool
    {
        $user = $user ?: Auth::user();
        return $user && (int)$user->role === self::ROLE_ADMIN;
    }

    public static function isKasir(?\App\Models\User $user = null): bool
    {
        $user = $user ?: Auth::user();
        return $user && (int)$user->role === self::ROLE_KASIR;
    }
}
