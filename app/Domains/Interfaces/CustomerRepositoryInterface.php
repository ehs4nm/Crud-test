<?php

namespace App\Domains\Interfaces;

use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;

interface CustomerRepositoryInterface
{
    public function create(Customer $customer): Customer;

    public function getById(int $id): ?Customer;

    public function update(Customer $customer): bool;

    public function delete(int $id): bool;

    public function getByEmail(EmailValueObject $email): ?Customer;

    public function getByPhone(PhoneValueObject $phone): ?Customer;

    public function findAll(): Array;
}