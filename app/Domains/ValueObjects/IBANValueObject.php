<?php

namespace App\Domains\ValueObjects;

use Illuminate\Support\Facades\Validator;

class IBANValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        $validator = Validator::make(
            ['iban' => $value], 
            ['iban' => 'iban']
        );

        if ($validator->fails()) {
            throw new \DomainException("Invalid IBAN '{$value}'.");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function isEqualTo(self $iban): bool
    {
        return $this->value === $iban->value;
    }
}
