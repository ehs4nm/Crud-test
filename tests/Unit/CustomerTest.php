<?php

namespace Tests\Unit\Domains\Models;

use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use App\Domains\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class CustomerTest extends TestCase
{
    public function testCanCreateCustomer()
    {
        $customerData = [
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1980-01-01',
            'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
            'email' => new EmailValueObject('john.doe@example.com'),
            'bank_account_number' => '123456789',
        ];

        $customer = new Customer($customerData);
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($customerData['id'], $customer->getId());
        $this->assertEquals($customerData['first_name'], $customer->getFirstName());
        $this->assertEquals($customerData['last_name'], $customer->getLastName());
        $this->assertEquals($customerData['date_of_birth'], $customer->getDateOfBirth()->format('Y-m-d'));
        $this->assertEquals($customerData['phone_number'], $customer->getPhoneNumber());
        $this->assertEquals($customerData['email'], $customer->getEmail());
        $this->assertEquals($customerData['bank_account_number'], $customer->getBankAccountNumber());
    }

    // public function testCanUpdateCustomer()
    // {
    //     $customerData = [
    //         'id' => 1,
    //         'first_name' => 'John',
    //         'last_name' => 'Doe',
    //         'date_of_birth' => '1980-01-01',
    //         'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
    //         'email' => new EmailValueObject('john.doe@example.com'),
    //         'bank_account_number' => '123456789',
    //     ];

    //     $customer = new Customer($customerData);

    //     $newData = [
    //         'first_name' => 'ehsan',
    //         'last_name' => 'mohiti',
    //         'date_of_birth' => '1990-09-09',
    //         'phone_number' => new PhoneValueObject('+1 (123) 456-0000'),
    //         'email' => new EmailValueObject('mohiti.ehsan@gmail.com'),
    //         'bank_account_number' => '987654321',
    //     ];

    //     $customer->update($newData);

    //     $this->assertEquals($customerData['id'], $customer->getId());
    //     $this->assertEquals($newData['first_name'], $customer->getFirstName());
    //     $this->assertEquals($newData['last_name'], $customer->getLastName());
    //     $this->assertEquals($newData['date_of_birth'], $customer->getDateOfBirth()->format('Y-m-d'));
    //     $this->assertEquals($newData['phone_number'], $customer->getPhoneNumber());
    //     $this->assertEquals($newData['email'], $customer->getEmail());
    //     $this->assertEquals($newData['bank_account_number'], $customer->getBankAccountNumber());
    // }
}

