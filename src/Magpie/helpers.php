<?php

function throwErrorBasedOnMagpieErrorCode($code, $message) 
{
    switch($code) {
        case 'invalid_request_error':
            throw new \Magpie\Exceptions\InvalidRequestException($message);
            break;
        default:
            throw new \Exception($message);
            break;
    }
}