<?php

namespace App\Domains\Factories;

use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date,
            'phone_number' => new PhoneValueObject($this->faker->phoneNumber),
            'email' => new EmailValueObject($this->faker->safeEmail),
            'bank_account_number' => $this->faker->bankAccountNumber,
        ];
    }
    
    public static function createNew(array $attributes = []): Customer
    {
        $faker = FakerFactory::create();
        
        $attributes = $attributes ?: [];
        
        $defaults = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'date_of_birth' => $faker->date('Y-m-d'),
            'phone_number' => $faker->phoneNumber,
            'email' => $faker->email,
            'bank_account_number' => $faker->iban('NL'),
        ];
        
        $attributes = array_replace($defaults, $attributes);
        
        $customer = new Customer([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'date_of_birth' => \DateTime::createFromFormat('Y-m-d', $attributes['date_of_birth']),
            'phone_number' => new PhoneValueObject($attributes['phone_number']),
            'email' => new EmailValueObject($attributes['email']),
            'bank_account_number' => $attributes['bank_account_number']
        ]);

        return $customer;
    }
}
