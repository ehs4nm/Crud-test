<?php

namespace App\Domains\Interfaces;

use App\Domains\Models\EmailValueObject;
use App\Domains\Models\PhoneValueObject;

interface CustomerRepository
{
    public function create(CustomerEntity  $customer): void;

    public function getById(int $id): ?CustomerEntity ;

    public function update(CustomerEntity  $customer): void;

    public function delete(CustomerEntity  $customer): void;

    public function getByEmail(EmailValueObject $email): ?CustomerEntity ;

    public function getByPhone(PhoneValueObject $phone): ?CustomerEntity ;
}