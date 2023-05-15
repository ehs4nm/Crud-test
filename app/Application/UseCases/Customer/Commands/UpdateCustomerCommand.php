<?php

namespace App\Application\UseCases\Customer\Commands;

use App\Application\DTO\CustomerDTO;
use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Domains\Models\Customer;

class UpdateCustomerCommand
{
    private CustomerRepositoryInterface $repository;

    public function __construct(private readonly CustomerDTO $customer)
    {
        $this->repository = app()->make(CustomerRepositoryInterface::class);
    }

    public function execute(): void
    {
        $this->repository->update($this->customer);
    }
}
