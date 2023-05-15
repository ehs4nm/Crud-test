<?php

namespace App\Application\Mappers;

use App\Domains\Models\Customer;
use Illuminate\Http\Request;

class CustomerMapper
{
    public static function fromRequest(Request $request, ?int $customer_id = null): Customer
    {
        $customer = new Customer([
            'id'=> $customer_id,
            'first_name'=> $request->string('first_name'),
            'last_name'=> $request->string('last_name'),
            'date_of_birth'=> $request->string('date_of_birth'),
            'phone_number'=> $request->string('phone_number'),
            'email'=> $request->string('email'),
            'bank_account_number'=> $request->string('bank_account_number'),
            ]
        );
        return $customer;
    }
}