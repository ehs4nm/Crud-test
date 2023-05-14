<?php

namespace App\Domains\Interfaces;

use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;

interface CustomerEntityInterface
{
    public function getId(): int;

    public function getFirstName(): string;

    public function setFirstName(string $firstName): void;

    public function getLastName(): string;

    public function setLastName(string $lastName): void;

    public function getDateOfBirth(): ?\DateTime;

    public function setDateOfBirth(?\DateTime $dateOfBirth): void;

    public function getPhoneNumber(): PhoneValueObject;

    public function setPhoneNumber(string $phoneNumber): void;

    public function getEmail(): EmailValueObject;

    public function setEmail(string $email): void;

    public function getBankAccountNumber(): string;

    public function setBankAccountNumber(string $bankAccountNumber): void;
}