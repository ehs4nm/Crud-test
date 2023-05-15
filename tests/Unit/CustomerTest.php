<?php

namespace Tests\Unit\Domains\Models;

use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use App\Domains\Models\User;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Test class for Customer domain model, which tests various functionalities such as creation, validation, updating, and deletion of customer records using App\Repositories\CustomerRepository.
 */


class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testCanFindAllCustomer()
    {
        // Create two customers
        $customer1Data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1980-01-01',
            'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
            'email' => new EmailValueObject('john.doe@example.com'),
            'bank_account_number' => '12345678901234',
        ];

        $customer2Data = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'date_of_birth' => '1990-02-02',
            'phone_number' => new PhoneValueObject('+1 (987) 654-3210'),
            'email' => new EmailValueObject('jane.smith@example.com'),
            'bank_account_number' => '98765432109876',
        ];

        $customerRepository = new CustomerRepository();
        $customerRepository->create(new Customer($customer1Data));
        $customerRepository->create(new Customer($customer2Data));
        // Retrieve all customers
        $customers = $customerRepository->findAll();

        // Assert that there are two customers
        $this->assertCount(2, $customers);

        // Assert that the retrieved customers match the created customers (returned object is an array of Customers)
        $this->assertEquals($customer1Data['first_name'], $customers[0]->first_name);
        $this->assertEquals($customer1Data['last_name'], $customers[0]->last_name);
        $this->assertEquals($customer1Data['date_of_birth'], $customers[0]->date_of_birth);
        $this->assertEquals($customer1Data['phone_number'], $customers[0]->phone_number);
        $this->assertEquals($customer1Data['email'], $customers[0]->email);
        $this->assertEquals($customer1Data['bank_account_number'], $customers[0]->bank_account_number);

        $this->assertEquals($customer2Data['first_name'], $customers[1]->first_name);
        $this->assertEquals($customer2Data['last_name'], $customers[1]->last_name);
        $this->assertEquals($customer2Data['date_of_birth'], $customers[1]->date_of_birth);
        $this->assertEquals($customer2Data['phone_number'], $customers[1]->phone_number);
        $this->assertEquals($customer2Data['email'], $customers[1]->email);
        $this->assertEquals($customer2Data['bank_account_number'], $customers[1]->bank_account_number);
    }


    public function testCanCreateCustomer()
    {
        // Create a new customer
        $customerData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1980-01-01',
            'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
            'email' => new EmailValueObject('john.doe@example.com'),
            'bank_account_number' => '12345678901234',
        ];

        $customer = new Customer($customerData);

        $this->assertInstanceOf(Customer::class, $customer);

        $this->assertEquals($customerData['first_name'], $customer->getFirstName());
        $this->assertEquals($customerData['last_name'], $customer->getLastName());
        $this->assertEquals($customerData['date_of_birth'], $customer->getDateOfBirth()->format('Y-m-d'));
        $this->assertEquals($customerData['phone_number'], $customer->getPhoneNumber());
        $this->assertEquals($customerData['email'], $customer->getEmail());
        $this->assertEquals($customerData['bank_account_number'], $customer->getBankAccountNumber());


        $customerRepository = new CustomerRepository();

        $customerRepository->create($customer);
        
       $this->assertDatabaseHas('customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1980-01-01',
            'phone_number' => '+11234567890',
            'email' => 'john.doe@example.com',
            'bank_account_number' => '12345678901234'
        ]);

    }

    public function testCanReadCustomer()
    {
        // Create a new customer
        $customerData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
            'email' => new EmailValueObject('john.doe@example.com'),
            'bank_account_number' => '123456789',
        ];

        $customer = new Customer($customerData);
        
        $customerRepository = new CustomerRepository();

        $customerRepository->create($customer);
        
        // Retrieve the customer
        $retrievedCustomer = $customerRepository->getById($customer->getId());

        // Check that the retrieved customer matches the original customer
        $this->assertInstanceOf(Customer::class, $retrievedCustomer);

        $this->assertEquals($customerData['first_name'], $retrievedCustomer->getFirstName());
        $this->assertEquals($customerData['last_name'], $retrievedCustomer->getLastName());
        $this->assertEquals($customerData['date_of_birth'], $retrievedCustomer->getDateOfBirth()->format('Y-m-d'));
        $this->assertEquals($customerData['phone_number'], $retrievedCustomer->getPhoneNumber());
        $this->assertEquals($customerData['email'], $retrievedCustomer->getEmail());
        $this->assertEquals($customerData['bank_account_number'], $retrievedCustomer->getBankAccountNumber());
    }


    public function testCanUpdateCustomer()
    {
        $customerData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1980-01-01',
            'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
            'email' => new EmailValueObject('john.doe@example.com'),
            'bank_account_number' => '12345678901234',
        ];

        $customer = new Customer($customerData);

        $customerRepository = new CustomerRepository();

        $customerRepository->create($customer);

        $newData = [
            'first_name' => 'ehsan',
            'last_name' => 'mohiti',
            'date_of_birth' => '1990-09-09',
            'phone_number' => new PhoneValueObject('+1 (123) 456-0000'),
            'email' => new EmailValueObject('mohiti.ehsan@gmail.com'),
            'bank_account_number' => '44445678901234',
        ];

        $customer->update($newData);
        
        // dd($customer->id,$customer->exists, $customer->update($newData));

        $customerRepository->update($customer);

        $this->assertDatabaseHas('customers', [
            'first_name' => 'ehsan',
            'last_name' => 'mohiti',
            'date_of_birth' => '1990-09-09',
            'phone_number' => '+11234560000',
            'email' => 'mohiti.ehsan@gmail.com',
            'bank_account_number' => '44445678901234'
        ]);

    }

    public function testCanDeleteCustomer()
    {
        // Create a new customer
        $customerData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1980-01-01',
            'phone_number' => new PhoneValueObject('+1 (123) 456-7890'),
            'email' => new EmailValueObject('john.doe@example.com'),
            'bank_account_number' => '123456789',
        ];
        $customer = new Customer($customerData);

        $customerRepository = new CustomerRepository();

        $customerRepository->create($customer);

        // Delete the customer
        $this->assertTrue($customerRepository->delete($customer->getId()));

        // Attempt to retrieve the deleted customer
        $retrievedCustomer = $customerRepository->getById($customer->getId());
        $this->assertNull($retrievedCustomer);
    }


}

