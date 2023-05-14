<?php

namespace App\Domains\Interfaces;

use App\Domains\Models\Customer;

interface CustomerFactoryInterface
{
    public function create(array $data): CustomerEntityInterface;
}
