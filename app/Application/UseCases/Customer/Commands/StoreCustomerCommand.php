<?php

namespace App\Application\UseCases\Customer\Commands;

use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Domains\Models\Customer;

class StoreCustomerCommand
{
    private CustomerRepositoryInterface $repository;

    public function __construct(private readonly Customer $customer)
    {
        $this->repository = app()->make(CustomerRepositoryInterface::class);
    }

    public function execute(): Customer
    {
        return $this->repository->create($this->customer);
    }
}
