<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Magpie\MagpieCustomer;

class CustomerTest extends TestCase
{
    private $pk;
    private $sk;

    public function setUp(): void
    {
        $this->pk = 'pk_test_HCZZXNHxaTLMg3aL2kWg3w';
        $this->sk = 'sk_test_kQPamE4klJnNnHb1bclOYA';
    }

    public function testCanBeInitialized(): void
    {
        $customer = new MagpieCustomer($this->pk, $this->sk);
    }
}
