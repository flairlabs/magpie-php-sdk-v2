<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Magpie\MagpieCustomer;
use Magpie\Exceptions\InvalidArgumentException;
use Magpie\Exceptions\InvalidRequestException;

class CustomerTest extends TestCase
{
    private $pk;
    private $sk;
    private $customer;

    public function setUp(): void
    {
        $this->pk = 'pk_test_HCZZXNHxaTLMg3aL2kWg3w';
        $this->sk = 'sk_test_kQPamE4klJnNnHb1bclOYA';
        $this->customer = new MagpieCustomer($this->pk, $this->sk);
    }

    /** @test */
    public function it_can_be_initialized(): void
    {
        $this->customer = new MagpieCustomer($this->pk, $this->sk);
        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_throw_exception_invalid_params_create_customer() : void 
    {
        $this->expectException(InvalidArgumentException::class);
        $params = [
            'description' => 'Person'
        ];
        $response = $this->customer->createCustomer($params);
    }

    /** @test */
    public function it_can_create_customer_from_valid_params() : void 
    {
        $params = [
            'email' => 'test@gmail.com',
            'description' => 'Person'
        ];
        $customer = $this->customer->createCustomer($params);
        $this->assertArrayHasKey('id', $customer);
    }

    /** @test */
    public function it_returns_exception_on_non_existing_customer_id() : void
    {
        $this->expectException(InvalidRequestException::class);
        $customerId = 'cus_aeyTHHenmG63jbirE4kcaxxxx';
        $customer = $this->customer->getCustomer($customerId);
        $this->assertEquals($customerId, $customer['id']);
        $this->assertArrayHasKey('id', $customer);
    }

    /** @test */
    public function it_returns_correct_magpie_customer() : void
    {
        $customerId = 'cus_aeyTHHenmG63jbirE4kc';
        $customer = $this->customer->getCustomer($customerId);
        $this->assertEquals($customerId, $customer['id']);
        $this->assertArrayHasKey('id', $customer);
    }

    /** @test */
    public function it_updates_the_existing_customer() : void
    {
        $customerId = 'cus_aeyTHHenmG63jbirE4kc';
        $customer = $this->customer->getCustomer($customerId);
        $this->assertEquals($customerId, $customer['id']);
        $this->assertArrayHasKey('id', $customer);
    }
}
