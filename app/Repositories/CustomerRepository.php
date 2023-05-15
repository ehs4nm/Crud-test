<?php

namespace App\Repositories;

use App\Domains\Interfaces\CustomerRepositoryInterface;
use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function findAll(): array
    {
        $customers = DB::table('customers')->get()->toArray();
        return $customers;
    }

    public function create(Customer $customer): Customer
    {
        $id = DB::table('customers')->insertGetId([
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'date_of_birth' => $customer->getDateOfBirth() ? $customer->getDateOfBirth()->format('Y-m-d') : null,
            'phone_number' => (string) $customer->getPhoneNumber(),
            'email' => (string) $customer->getEmail(),
            'bank_account_number' => $customer->getBankAccountNumber(),
        ]);

        $customer->setId($id);
        $customer->exists = true;

        return $customer;
    }

    public function update(Customer $customer): bool
    {
        $result = DB::table('customers')->where('id', $customer->getId())->update([
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'date_of_birth' => $customer->getDateOfBirth() ? $customer->getDateOfBirth()->format('Y-m-d') : null,
            'phone_number' => (string) $customer->getPhoneNumber(),
            'email' => (string) $customer->getEmail(),
            'bank_account_number' => $customer->getBankAccountNumber(),
        ]);

        return (bool) $result;
    }

    public function delete(int $id): bool
    {
        $result = DB::table('customers')->where('id', $id)->delete();

        return (bool) $result;
    }

    public function getByPhone(PhoneValueObject $phone): ?Customer
    {
        $data = DB::table('customers')->where('phone_number', (string) $phone)->first();

        if (!$data) {
            return null;
        }

        return $this->mapToCustomer($data);
    }

    public function getById(int $id): ?Customer
    {
        $data = DB::table('customers')->find($id);

        if (!$data) {
            return null;
        }

        return $this->mapToCustomer($data);
    }

    public function getByEmail(EmailValueObject $email): ?Customer
    {
        $data = DB::table('customers')->where('email', $email);

        if (!$data) {
            return null;
        }

        return $this->mapToCustomer($data);
    }


    private function mapToCustomer($data): Customer
    {
        return new Customer(
           [
            'id' => $data->id,
            'first_name' =>    $data->first_name,
            'last_name' =>   $data->last_name,
            'date_of_birth' =>   $data->date_of_birth ? new \DateTime($data->date_of_birth) : null,
            'phone_number' =>  new PhoneValueObject($data->phone_number),
            'email' =>  new EmailValueObject($data->email),
            'bank_account_number' => $data->bank_account_number]
        );
    }
}
