<?php

use App\Domains\ValueObjects\EmailValueObject;
use App\Domains\ValueObjects\IBANValueObject;
use App\Domains\ValueObjects\PhoneValueObject;
use Tests\TestCase;

class ValueObjectTest extends TestCase
{
    public function testPhoneValueObject()
    {
        // Valid phone number
        $validPhoneNumber = '+18026872706';
        $phone = new PhoneValueObject($validPhoneNumber);
        $this->assertEquals($validPhoneNumber, $phone->__toString());

        // Invalid phone number
        $invalidPhoneNumber = '12345';
        $this->expectException(\DomainException::class);
        // $this->expectExceptionMessage("Invalid phone number '{$invalidPhoneNumber}'.");
        new PhoneValueObject($invalidPhoneNumber);
    }

    public function testEmailValueObject()
    {
        // Valid email
        $validEmail = 'test@example.com';
        $email = new EmailValueObject($validEmail);
        $this->assertEquals($validEmail, $email->__toString());

        // Invalid email
        $invalidEmail = 'invalidemail';
        $this->expectException(\DomainException::class);
        new EmailValueObject($invalidEmail);
    }
    
    public function testIbanValueObject()
    {
        // Valid IBAN
        $validIBAN = 'GB82WEST12345698765432';

        $ibanValueObject = new IBANValueObject($validIBAN);
        // $this->assertInstanceOf(IBANValueObject::class, $ibanValueObject);

        // Test string representation
        $this->assertEquals($validIBAN, (string)$ibanValueObject);

        // Invalid IBAN
        $invalidIBAN = 'GB82WEST12345';

        // Test instantiation with invalid IBAN
        $this->expectException(\DomainException::class);
        new IBANValueObject($invalidIBAN);
    }

}
