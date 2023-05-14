<?php

namespace App\Domains\Models;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();

        try {
            $phoneNumber = $phoneNumberUtil->parse($value, 'US'); 
            $this->value = $phoneNumberUtil->format($phoneNumber, PhoneNumberFormat::E164);
        } catch (NumberParseException $e) {
            throw new \DomainException("Invalid phone number '{$value}'.");
        }
    }

    // public function __toString()
    // {
    //     return $this->value;
    // }

    // public function isEqualTo(self $phone): bool
    // {
    //     return $this->value === $phone->value;
    // }
}
