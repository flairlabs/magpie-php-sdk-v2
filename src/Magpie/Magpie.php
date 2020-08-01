<?php

namespace Magpie;

class Magpie
{
    /**
     *
     * @var Magpie\Customer
     */
    public $customer;

    /**
     *
     * @var Magpie\Charge
     */
    public $charge;

    /**
     *
     * @var Magpie\Token
     */
    public $token;

    /**
     *
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct($publicKey, $secretKey)
    {
        $this->customer = new Customer($publicKey, $secretKey);
        $this->charge = new Charge($publicKey, $secretKey);
        $this->token = new Token($publicKey, $secretKey);
    }
}
