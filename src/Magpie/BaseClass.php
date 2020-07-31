<?php

namespace Magpie;

abstract class BaseClass
{
    /**
     * Magpie Merchant Public Key
     *
     * @var string
     */
    private $publicKey;

    /**
     * Magpie Merchant Secret Key
     *
     * @var string
     */
    private $secretKey;

    /**
     *
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct($publicKey, $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }
}
