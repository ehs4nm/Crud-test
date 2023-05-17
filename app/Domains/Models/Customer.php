<?php

namespace App\Domains\Models;

use App\Application\Events\Customer\CustomerCreated;
use App\Domains\Interfaces\CustomerEntityInterface;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Customer extends Model implements CustomerEntityInterface
{
    use HasFactory;

    protected $fillable = [
       'first_name', 'last_name', 'date_of_birth', 'phone_number', 'email', 'bank_account_number'
    ];
    
    public static function createWithAttributes(array $attributes): Customer
    {
        /*
         * Let's generate a uuid.
         */
        $attributes['uuid'] = (string) Uuid::uuid4();

        /*
         * The account will be created inside this event using the generated uuid.
         */
        event(new CustomerCreated($attributes));

        /*
         * The uuid will be used the retrieve the created account.
         */
        return static::uuid($attributes['uuid']);
    }

    
    public function getId(): ?int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): ?int
    {
        return $this->attributes['id'] = $id;
    }

    public function getFirstName(): string
    {
        return $this->attributes['first_name'];
    }

    public function setFirstName(string $firstName): void
    {
        $this->attributes['first_name'] = $firstName;
    }

    public function getLastName(): string
    {
        return $this->attributes['last_name'];
    }

    public function setLastName(string $lastName): void
    {
        $this->attributes['last_name'] = $lastName;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        if($this->attributes['date_of_birth'] === null) return null;

        if(! $this->attributes['date_of_birth'] instanceof \DateTime){
            return \DateTime::createFromFormat('Y-m-d', $this->attributes['date_of_birth']);
        }

        return $this->attributes['date_of_birth'];
    }

    public function setDateOfBirth(?\DateTime $dateOfBirth): void
    {
        $this->attributes['date_of_birth'] = $dateOfBirth;
    }

    public function getPhoneNumber(): PhoneValueObject
    {
        return new PhoneValueObject($this->attributes['phone_number']);
        // return $this->attributes['phone_number'];
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->attributes['phone_number'] = $phoneNumber;
    }

    public function getEmail(): EmailValueObject
    {
        return new EmailValueObject($this->attributes['email']);
        // return $this->attributes['email'];
    }

    public function setEmail(EmailValueObject $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getBankAccountNumber(): string
    {
        return $this->attributes['bank_account_number'];
    }

    public function setBankAccountNumber(string $bankAccountNumber): void
    {
        $this->attributes['bank_account_number'] = $bankAccountNumber;
    }

}
