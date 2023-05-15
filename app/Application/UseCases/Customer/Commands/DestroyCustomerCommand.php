<?php

namespace App\Application\UseCases\Customer\Commands;

use App\Domains\Interfaces\CustomerRepositoryInterface;

class DestroyCustomerCommand 
{
    private CustomerRepositoryInterface $repository;

    public function __construct( private readonly int $customer_id)
    {
        $this->repository =  app()->make(CustomerRepositoryInterface::class);
    }

    public function execute(): void
    {
        $this->repository->delete($this->customer_id);
    }
}