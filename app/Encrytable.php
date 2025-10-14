<?php

namespace App\Traits;

trait Encryptable
{
    protected $encryptable = [];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && !is_null($value)) {
            $value = encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptable) && !is_null($value)) {
            $value = decrypt($value);
        }

        return $value;
    }
}
