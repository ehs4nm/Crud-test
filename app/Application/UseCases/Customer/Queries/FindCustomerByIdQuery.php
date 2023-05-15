<?php

namespace App\Application\UseCases\Customer\Queries;

use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Domains\Models\Customer;

class FindCustomerByIdQuery
{
    private CustomerRepositoryInterface $repository;

    public function __construct(private readonly int $id)
    {
        $this->repository = app()->make(CustomerRepositoryInterface::class);
    }

    public function handle(): Customer
    {
        $customer = $this->repository->getById($this->id);
        $customer->date_of_birth = $customer->date_of_birth->format('Y-m-d');
        $customer->phone_number = $customer->phone_number->__toString();
        $customer->email = $customer->email->__toString();

        return $customer;
    }
}
