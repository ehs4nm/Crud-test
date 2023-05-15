<?php
namespace Tests\Unit;

use App\Application\UseCases\Customer\Commands\StoreCustomerCommand;
use App\Domains\Factories\CustomerFactory;
use App\Domains\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\WithCustomers;

class CustomerTest extends TestCase
{
    use RefreshDatabase, WithCustomers;

    public function test_can_create_customer()
    {
        $customer = $this->newCustomer();

        $this->assertInstanceOf(Customer::class, $customer);
        $response = $this->post(route('customers.store'), [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'date_of_birth' => ($customer->date_of_birth)->format('Y-m-d'),
            'email' => $customer->email,
            'phone_number' => $customer->phone_number,
            'bank_account_number' => $customer->bank_account_number,
        ]);
        
        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'date_of_birth' => $customer->date_of_birth->format('Y-m-d'),
            'phone_number' => $customer->phone_number,
            'email' => $customer->email,
            'bank_account_number' => $customer->bank_account_number,
        ]);
    }

    public function test_can_read_customer()
    {
        $customer = $this->newCustomer();

        $customer = (new StoreCustomerCommand($customer))->execute();

        $this->assertDatabaseHas('customers', [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'date_of_birth' => $customer->date_of_birth->format('Y-m-d'),
            'phone_number' => $customer->phone_number,
            'email' => $customer->email,
            'bank_account_number' => $customer->bank_account_number,
        ]);

        $response = $this->get(route('customers.show', ['customer' => $customer->id]));
        $response->assertStatus(200)           
            ->assertJson([
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'date_of_birth' => $customer->date_of_birth->format('Y-m-d'),
                'phone_number' => $customer->phone_number->__toString(),
                'email' => $customer->email->__toString(),
                'bank_account_number' => $customer->bank_account_number,
            ]);
    }

    public function test_can_update_customer()
    {
        $customer = $this->newCustomer();

        $customer = (new StoreCustomerCommand($customer))->execute();

        $this->assertDatabaseHas('customers', [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'date_of_birth' => $customer->date_of_birth->format('Y-m-d'),
            'phone_number' => $customer->phone_number,
            'email' => $customer->email,
            'bank_account_number' => $customer->bank_account_number,
        ]);

        $updatedData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1985-10-15',
            'email' => 'johndoe@example.com',
            'phone_number' => '+1234567890',
            'bank_account_number' => '9876543210',
        ];

        $response = $this->put(route('customers.update', ['customer' => $customer->id]), [
            'first_name' => $updatedData['first_name'],
            'last_name' => $updatedData['last_name'],
            'date_of_birth' => $updatedData['date_of_birth'],
            'email' => $updatedData['email'],
            'phone_number' => $updatedData['phone_number'],
            'bank_account_number' => $updatedData['bank_account_number'],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'first_name' => $updatedData['first_name'],
            'last_name' => $updatedData['last_name'],
            'date_of_birth' => $updatedData['date_of_birth'],
            'phone_number' => $updatedData['phone_number'],
            'email' => $updatedData['email'],
            'bank_account_number' => $updatedData['bank_account_number'],
        ]);
    }

    public function test_can_delete_customer()
    {
        $customer = $this->newCustomer();

        $customer = (new StoreCustomerCommand($customer))->execute();

        $response = $this->delete(route('customers.destroy', ['customer' => $customer->id]));
    
        $response->assertStatus(204);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }
}
