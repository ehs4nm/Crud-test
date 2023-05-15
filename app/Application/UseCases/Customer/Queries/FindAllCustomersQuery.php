<?php

namespace App\Application\UseCases\Customer\Queries;

use App\Domains\Interfaces\CustomerRepositoryInterface;

class FindAllCustomersQuery
{
    private CustomerRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(CustomerRepositoryInterface::class);
    }

    public function handle(): array
    {
        return $this->repository->findAll();
    }
}
