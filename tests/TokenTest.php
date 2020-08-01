<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Magpie\Token;
use Magpie\Exceptions\InvalidArgumentException;
use Magpie\Exceptions\InvalidRequestException;

class TokenTest extends TestCase
{
    private $pk;
    private $sk;
    private $token;

    public function setUp(): void
    {
        $this->pk = 'pk_test_HCZZXNHxaTLMg3aL2kWg3w';
        $this->sk = 'sk_test_kQPamE4klJnNnHb1bclOYA';
        $this->token = new Token($this->pk, $this->sk);
    }

    /** @test */
    public function it_can_be_initialized(): void
    {
        $this->token = new Token($this->pk, $this->sk);
        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_return_exception_on_invalid_params_in_create_token(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $params = [
            'card' => [
                'number' => '4242424242424242',
                'name' => 'Mark',
            ]
        ];
        $response = $this->token->create($params);
    }

    /** @test */
    public function it_should_create_card_token(): void
    {
        $params = [
            'card' => [
                'number' => '4242424242424242',
                'name' => 'Mark',
                'exp_month' => '02',
                'exp_year' => '2023',
                'cvc' => '2023',
            ]
        ];
        $cardToken = $this->token->create($params);
        $this->assertArrayHasKey('id', $cardToken);
    }

    /** @test */
    public function it_should_retrieve_token(): void
    {
        $id = 'tok_R429YV9uAu9UH5DzhWGs';
        $cardToken = $this->token->get($id);
        $this->assertArrayHasKey('id', $cardToken);
    }

    /** @test */
    public function it_should_return_exception_if_id_is_not_valid_in_retrieve_token(): void
    {
        $this->expectException(InvalidRequestException::class);
        $id = 'tok_R429YV9uAu9UH5DzhWGsxxxxxxxxx';
        $cardToken = $this->token->get($id);
        $this->assertArrayHasKey('id', $cardToken);
    }
}
