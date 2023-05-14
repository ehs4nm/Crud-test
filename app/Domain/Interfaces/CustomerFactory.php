<?php

namespace App\Domains\Interfaces;

use App\Domains\Models\Customer;

interface CustomerFactory
{
    public function create(array $data): Customer;
}
