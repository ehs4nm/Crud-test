<?php

namespace App\Application\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CustomerDeleted extends ShouldBeStored
{
    /** @var int */
    public $customerId;

    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }
}