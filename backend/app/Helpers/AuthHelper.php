<?php

namespace App\Helpers;

class AuthHelper
{
    public static function fingerprint(): string
    {
        $authToken = request()->header('Authorization');
        $ip = request()->ip();
        return hash('sha256', $authToken . $ip);
    }
}
