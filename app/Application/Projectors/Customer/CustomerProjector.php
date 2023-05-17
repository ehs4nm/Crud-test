<?php

namespace App\Application\Projectors\Customer;

use App\Application\Events\Customer\CustomerCreated;
use App\Application\Events\Customer\CustomerDeleted;
use App\Application\Events\Customer\CustomerUpdated;
use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Domains\Models\Customer;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CustomerProjector extends Projector
{
    private $customerRepository;

    public function __construct()
    {
        $this->customerRepository = app()->make(CustomerRepositoryInterface::class);
    }

    public function onCustomerCreated(CustomerCreated $event): void
    {
        $customer = new Customer();
        $customer->setId($event->customerAttributes['id']);
        $customer->setFirstName($event->customerAttributes['getFirstName']);
        $customer->setLastName($event->customerAttributes['lastName']);
        $customer->setDateOfBirth($event->customerAttributes['dateOfBirth']);
        $customer->setPhoneNumber($event->customerAttributes['phoneNumber']);
        $customer->setEmail($event->customerAttributes['email']);
        $customer->setBankAccountNumber($event->customerAttributes['bankAccountNumber']);

        $this->customerRepository->create($customer);
    }

    public function onCustomerUpdated(CustomerUpdated $event): void
    {
        $customer = Customer::find($event->customerAttributes['id']);
        if (!$customer) return;

        $customer->setFirstName($event->customerAttributes['firstName']);
        $customer->setLastName($event->customerAttributes['lastName']);
        $customer->setDateOfBirth($event->customerAttributes['dateOfBirth']);
        $customer->setPhoneNumber($event->customerAttributes['phoneNumber']);
        $customer->setEmail($event->customerAttributes['email']);
        $customer->setBankAccountNumber($event->customerAttributes['bankAccountNumber']);

        $this->customerRepository->update($customer);
    }

    public function onCustomerDeleted(CustomerDeleted $event): void
    {
        $customer = Customer::find($event->customerId);
        if ($customer) {
            $this->customerRepository->delete($customer);
        }
    }
}