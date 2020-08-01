<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Magpie\Charge;
use Magpie\Token;
use Magpie\Exceptions\InvalidArgumentException;
use Magpie\Exceptions\InvalidRequestException;

class ChargeTest extends TestCase
{
    private $pk;
    private $sk;
    private $charge;
    private $token;

    public function setUp(): void
    {
        $this->pk = 'pk_test_HCZZXNHxaTLMg3aL2kWg3w';
        $this->sk = 'sk_test_kQPamE4klJnNnHb1bclOYA';
        $this->charge = new Charge($this->pk, $this->sk);
        $this->token = new Token($this->pk, $this->sk);
    }

    /** @test */
    public function it_can_be_initialized(): void
    {
        $this->charge = new Charge($this->pk, $this->sk);
        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_throw_exception_invalid_params_create_charge(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $params = [
            'description' => 'Person'
        ];
        $response = $this->charge->create($params);
    }

    /** @test */
    public function it_should_create_charge(): void
    {
        $token = $this->token->create([
            'card' => [
                'number' => '4242424242424242',
                'name' => 'Mark',
                'exp_month' => '02',
                'exp_year' => '2023',
                'cvc' => '2023',
            ]
        ]);

        $params = [
            "amount" => 50000,
            "currency" => "php",
            "source" => $token['id'],
            "description" => "Pet food and other supplies",
            "statement_descriptor" => "Pet Shop Inc",
            "capture" => true
        ];
        $charge = $this->charge->create($params);
        $this->assertArrayHasKey('id', $charge);
    }

    /** @test */
    public function it_should_retrieve_charge(): void
    {
        $id = 'ch_CnRzDrYxWnOQBD1mp9qNw';
        $charge = $this->charge->get($id);
        $this->assertArrayHasKey('id', $charge);
    }

    /** @test */
    public function it_should_return_exception_if_id_is_not_valid_in_retrieve_charge(): void
    {
        $this->expectException(InvalidRequestException::class);
        $id = 'ch_CnRzDrYxWnOQBD1mp9qNwxxx';
        $charge = $this->charge->get($id);
        $this->assertArrayHasKey('id', $charge);
    }

    /** @test */
    public function it_should_capture_charge(): void
    {
        $token = $this->token->create([
            'card' => [
                'number' => '4242424242424242',
                'name' => 'Mark',
                'exp_month' => '02',
                'exp_year' => '2023',
                'cvc' => '2023',
            ]
        ]);

        $params = [
            "amount" => 50000,
            "currency" => "php",
            "source" => $token['id'],
            "description" => "Pet food and other supplies",
            "statement_descriptor" => "Pet Shop Inc",
            "capture" => false
        ];
        $charge = $this->charge->create($params);
        $this->assertEquals(false, $charge['captured']);

        $captureCharge = $this->charge->capture($charge['id'], [
            'amount' => 50000
        ]);
        $this->assertEquals(true, $captureCharge['captured']);
    }

    /** @test */
    public function it_should_void_charge(): void
    {
        $token = $this->token->create([
            'card' => [
                'number' => '4242424242424242',
                'name' => 'Mark',
                'exp_month' => '02',
                'exp_year' => '2023',
                'cvc' => '2023',
            ]
        ]);

        $params = [
            "amount" => 50000,
            "currency" => "php",
            "source" => $token['id'],
            "description" => "Pet food and other supplies",
            "statement_descriptor" => "Pet Shop Inc",
            "capture" => true
        ];
        $charge = $this->charge->create($params);
        $this->assertEquals(0, count($charge['refunds']));

        $voidCharge = $this->charge->void($charge['id']);
        $this->assertEquals(1, count($voidCharge['refunds']));
    }

    /** @test */
    public function it_should_refund_charge(): void
    {
        $token = $this->token->create([
            'card' => [
                'number' => '4242424242424242',
                'name' => 'Mark',
                'exp_month' => '02',
                'exp_year' => '2023',
                'cvc' => '2023',
            ]
        ]);

        $params = [
            "amount" => 50000,
            "currency" => "php",
            "source" => $token['id'],
            "description" => "Pet food and other supplies",
            "statement_descriptor" => "Pet Shop Inc",
            "capture" => true
        ];
        $charge = $this->charge->create($params);
        $this->assertEquals(0, count($charge['refunds']));

        $voidCharge = $this->charge->refund($charge['id'], ['amount' => 50000]);
        $this->assertEquals(1, count($voidCharge['refunds']));
    }
}
