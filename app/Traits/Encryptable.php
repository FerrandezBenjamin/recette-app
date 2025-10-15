<?php

namespace App\Traits;

use App\Casts\EncryptCast;

trait Encryptable
{
    protected $encryptable = ['dishes_description'];

    protected function initializeEncryptable(): void
    {
        if (empty($this->encryptable) || !is_array($this->encryptable)) {
            return;
        }

        foreach ($this->encryptable as $field) {
            $this->casts[$field] = EncryptCast::class;
        }
    }
}