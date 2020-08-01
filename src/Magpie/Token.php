<?php

namespace Magpie;

use Rakit\Validation\Validator;
use Magpie\Exceptions\InvalidArgumentException;

class Token extends BaseClass
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
            'card' => 'required',
            'card.name' => 'required',
            'card.number' => 'required|digits:16',
            'card.exp_month' => 'required|digits:2',
            'card.exp_year' => 'required|digits:4',
            'card.cvc' => 'required|digits_between:3,4',
        ]);

        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            throw new InvalidArgumentException($errors->all()[0]);
            return;
        }

        $data = $validation->getValidData();

        try {
            $response = $this->client->post('/tokens', [
                'json' =>  $data,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic " . \base64_encode($this->publicKey)
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
     * Get card token
     * 
     * @param string $id
     * @return array $token
     */
    public function get($id)
    {
        try {
            $response = $this->client->get("/tokens/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic " . \base64_encode($this->publicKey)
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
