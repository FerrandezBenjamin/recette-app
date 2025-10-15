<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class EncryptCast implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        return is_null($value) ? null : Crypt::decryptString($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return is_null($value) ? null : Crypt::encryptString($value);
    }
}
