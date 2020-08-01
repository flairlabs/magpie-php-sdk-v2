<?php

namespace Magpie;

use Rakit\Validation\Validator;
use Magpie\Exceptions\InvalidArgumentException;

class Charge extends BaseClass
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
     * Create Card Token
     * 
     * @param array $params
     * @return array $token
     */
    public function create($params)
    {
        $validation = $this->validator->validate($params, [
            "amount" => 'required|numeric',
            "currency" => "required",
            "source" => "required",
            "description" => "required",
            "statement_descriptor" => "required",
            "capture" => "required"
        ]);

        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            throw new InvalidArgumentException($errors->all()[0]);
            return;
        }

        $data = $validation->getValidData();

        try {
            $response = $this->client->post('/charges', [
                'json' =>  $data,
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
     * Get charge
     * 
     * @param string $id
     * @return array $charge
     */
    public function get($id)
    {
        try {
            $response = $this->client->get("/charges/{$id}", [
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
     * Capture given charge
     * 
     * @param string $id
     * @param array $params
     * @return array $charge
     */
    public function capture($id, $params)
    {
        $validation = $this->validator->validate($params, [
            "amount" => 'required|numeric',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new InvalidArgumentException($errors->all()[0]);
            return;
        }

        $data = $validation->getValidData();

        try {
            $response = $this->client->post("/charges/{$id}/capture", [
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
     * Void charge
     * 
     * @param string $id
     * @param array $params
     * @return array $charge
     */
    public function void($id)
    {
        try {
            $response = $this->client->post("/charges/{$id}/void", [
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
     * Refund charge
     * 
     * @param string $id
     * @param array $params
     * @return array $charge
     */
    public function refund($id, $params)
    {
        $validation = $this->validator->validate($params, [
            "amount" => 'required|numeric',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new InvalidArgumentException($errors->all()[0]);
            return;
        }

        $data = $validation->getValidData();

        try {
            $response = $this->client->post("/charges/{$id}/refund", [
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
}
