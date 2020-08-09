# Documentation

## Initialization

To initialize a Magpie instance you have to provide a set of keys
```php
$pk = 'pk_test_';
$sk = 'sk_test_';
$magpie = new Magpie\Magpie($pk, $sk);
```

## Customer

### Create Customer
```php
$pk = 'pk_test_';
$sk = 'sk_test_';
$magpie = new Magpie\Magpie($pk, $sk);
$params = [
    'email' => 'test@gmail.com',
    'description' => 'Person Name'
];
$customer = $magpie->customer->create($params);
```

### Get Customer
```php
$pk = 'pk_test_';
$sk = 'sk_test_';
$magpie = new Magpie\Magpie($pk, $sk);
$customerId = 'cus_';
$customer = $magpie->customer->get($customerId);
```

### Delete Customer
```php
$pk = 'pk_test_';
$sk = 'sk_test_';
$magpie = new Magpie\Magpie($pk, $sk);
$customerId = 'cus_';
$customer = $magpie->customer->delete($customerId);
```

## Token

### Create Token

```php
$token = $magpie->token->create([
    'card' => [
        'number' => '4242424242424242',
        'name' => 'Mark',
        'exp_month' => '02',
        'exp_year' => '2023',
        'cvc' => '2023',
    ]
]);
```

## Retrieve token
```php
$id = 'tok_';
$cardToken = $magpie->token->get($id);
```

## Charge

### Create Charge
```php
$params = [
    "amount" => 50000,
    "currency" => "php",
    "source" => $token,
    "description" => "Pet food and other supplies",
    "statement_descriptor" => "Pet Shop Inc",
    "capture" => true
];
$charge = $magpie->charge->create($params);
```

### Retrieve Charge

```php
$chargeId = 'ch_'
$charge = $magpie->charge->get($chargeId);
```

### Capture Charge

```php
$captureCharge = $magpie->charge->capture($chargeId, [
    'amount' => 50000
]);
```

### Void Charge

```php
$magpie->charge->void($chargeId);
```

### Refund Charge

```php
$magpie->charge->refund($chargeId, ['amount' => 50000]);
```