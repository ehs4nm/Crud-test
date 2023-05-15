<?php

namespace App\Application\UseCases\Customer\Queries;

use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;

class FindCustomerByEmailQuery
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct( private readonly EmailValueObject $email)
    {
        $this->customerRepository = app()->make(CustomerRepositoryInterface::class);
    }

    public function execute(): Customer
    {
        // validation, data manipulation, etc.

        return $this->customerRepository->getByEmail($this->email);
    }
}
