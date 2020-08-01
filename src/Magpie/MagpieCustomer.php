<?php

namespace Magpie;

use GuzzleHttp\Client;
use Rakit\Validation\Validator;
use Magpie\Exceptions\InvalidArgumentException;

class MagpieCustomer extends BaseClass
{
    /** 
     * 
     * @var Rakit\Validation\Validator;
     */
    private $validator;

    /**
     *
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct($publicKey, $secretKey)
    {
        parent::__construct($publicKey, $secretKey);

        $this->validator = new Validator;
    }

    /**
     * Create Mapgie Customer
     * 
     * @param array $params
     * @return array $customer
     */
    public function createCustomer($params)
    {
        $validation = $this->validator->validate($params, [
            'email' => 'required|email',
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            throw new InvalidArgumentException($errors->all()[0]);
            return;
        }

        $data = $validation->getValidData();

        $response = $this->client->post('/customers', [
            'json' =>  $data,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Basic " . \base64_encode($this->secretKey)
            ]
        ]);

        $body = $response->getBody();
        return (array) json_decode($body, true);
    }

    /**
     * Get customer object using customer id
     * 
     * @param string $id
     */
    public function getCustomer($id)
    {
        try {
            $response = $this->client->get("/customers/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic " . \base64_encode($this->secretKey)
                ]
            ]);
            $body = $response->getBody();
            var_dump($response->getBody());

            return (array) json_decode($body, true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody();
            $errorData = (array) json_decode($body, true);

            $code = $errorData['error']['type'];
            $message = $errorData['error']['message'];
            throwErrorBasedOnMagpieErrorCode($code, $message);
        }
    }
}
