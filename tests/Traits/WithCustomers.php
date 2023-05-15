<?php

namespace Tests\Traits;

use App\Domains\Factories\CustomerFactory;
use App\Domains\Models\Customer;
use Illuminate\Foundation\Testing\WithFaker;

trait WithCustomers
{
    use WithFaker;

    public function newCustomer(array $attributes = []): Customer
    {
        return CustomerFactory::createNew($attributes);
    }

    public function createRandomUsers($customersNumber = 1)
    {
        return CustomerFactory::times($customersNumber)->create();
    }
}