<?php

namespace App\Application\DTO;

use App\Domains\Models\Customer;
use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use Illuminate\Http\Request;

class CustomerDTO
{
    private $id;
    private $firstName;
    private $lastName;
    private $dateOfBirth;
    private $phoneNumber;
    private $email;
    private $bankAccountNumber;

    public function __construct(
        ?int $id,
        string $firstName,
        string $lastName,
        ?\DateTime $dateOfBirth,
        PhoneValueObject $phoneNumber,
        EmailValueObject $email,
        string $bankAccountNumber
    ) 
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->bankAccountNumber = $bankAccountNumber;
    }
    
    public static function fromRequest(Request $request, ?int $company_id = null): CustomerDTO
    {
        return new self(
            $company_id,
            $request->input('first_name'),
            $request->input('last_name'),
            new \DateTime($request->input('date_of_birth')),
            new PhoneValueObject($request->input('phone_number')),
            new EmailValueObject($request->input('email')),
            $request->input('bank_account_number')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'date_of_birth' => $this->dateOfBirth ? $this->dateOfBirth->format('Y-m-d') : null,
            'phone_number' => $this->phoneNumber,
            'email' => $this->email,
            'bank_account_number' => $this->bankAccountNumber,
        ];
    }

    public static function fromArray(array $data): CustomerDTO
    {
        return new self(
            $data['id'] ?? null,
            $data['first_name'],
            $data['last_name'],
            isset($data['date_of_birth']) ? new \DateTime($data['date_of_birth']) : null,
            new PhoneValueObject($data['phone_number']),
            new EmailValueObject($data['email']),
            $data['bank_account_number']
        );
    }

    public static function fromEloquent(Customer $customer): self
    {
        return new self(
            $customer->getId(),
            $customer->getFirstName(),
            $customer->getLastName(),
            $customer->getDateOfBirth(),
            $customer->getPhoneNumber(),
            $customer->getEmail(),
            $customer->getBankAccountNumber()
        );
    }
    
     // Add some getter methods here

     public function getId(): ?int
     {
         return $this->id;
     }
 
     public function getFirstName(): string
     {
         return $this->firstName;
     }
 
     public function getLastName(): string
     {
         return $this->lastName;
     }
 
     public function getDateOfBirth(): ?\DateTime
     {
         return $this->dateOfBirth;
     }
 
     public function getPhoneNumber(): PhoneValueObject
     {
         return $this->phoneNumber;
     }
 
     public function getEmail(): EmailValueObject
     {
         return $this->email;
     }
 
     public function getBankAccountNumber(): string
     {
         return $this->bankAccountNumber;
     }
}