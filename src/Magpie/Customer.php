<?php

namespace Magpie;

use Rakit\Validation\Validator;
use Magpie\Exceptions\InvalidArgumentException;

class Customer extends BaseClass
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
    public function create($params)
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
    public function get($id)
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

    /**
     * Update customer given id and data
     * 
     * @param string $id
     * @param array $data
     */
    public function update($id, $data)
    {
        try {
            $response = $this->client->put("/customers/{$id}", [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic " . \base64_encode($this->secretKey)
                ]
            ]);
            $body = $response->getBody();
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

    /**
     * Delete customer using id
     * 
     * @param string $id
     */
    public function delete($id)
    {
        try {
            $response = $this->client->delete("/customers/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic " . \base64_encode($this->secretKey)
                ]
            ]);
            $body = $response->getBody();
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
