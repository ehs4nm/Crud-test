<?php

namespace App\Application\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CustomerCreated extends ShouldBeStored
{
    /** @var array */
    public $customerAttributes;

    public function __construct(array $customerAttributes)
    {
        $this->customerAttributes = $customerAttributes;
    }
}
