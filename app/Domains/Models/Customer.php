<?php

namespace App\Domains\Models;

use App\Application\Events\Customer\CustomerCreated;
use App\Application\Events\Customer\CustomerDeleted;
use App\Application\Events\Customer\CustomerUpdated;
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
        $attributes['uuid'] = (string) Uuid::uuid4();

        event(new CustomerCreated($attributes));

        return static::uuid($attributes['uuid']);
    }

    public function UpdateWithAttributes(array $attributes): void
    {
        $this->fill($attributes);

        $this->save();

        event(new CustomerUpdated($this->toArray()));
    }

    public function delete(): void
    {
        $customerId = $this->getKey();
        
        parent::delete();
        
        event(new CustomerDeleted($customerId));
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

        /*
     * A helper method to quickly retrieve an account by uuid.
     */
    public static function uuid(string $uuid): ?Customer
    {
        return static::where('uuid', $uuid)->first();
    }
}
