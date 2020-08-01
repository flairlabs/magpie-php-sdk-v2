<?php

namespace Magpie;

class Magpie
{
    /**
     *
     * @var Magpie\Customer
     */
    private $customer;

    /**
     *
     * @var Magpie\Charge
     */
    private $charge;

    /**
     *
     * @var Magpie\Token
     */
    private $token;

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
