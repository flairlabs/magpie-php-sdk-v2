<?php

namespace Magpie;

use GuzzleHttp\Client;

abstract class BaseClass
{
    /**
     * 
     * @var GuzzleHttp\Client;
     */
    protected $client;

    /**
     * Magpie Merchant Public Key
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Magpie Merchant Secret Key
     *
     * @var string
     */
    protected $secretKey;

    /**
     *
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct($publicKey, $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;

        $this->client = new Client([
            'base_uri' => 'https://api.magpie.im',
            'timeout'  => 10.0,
        ]);
    }
}
