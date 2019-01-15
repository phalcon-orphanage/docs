* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Encryption/Decryption

Phalcon provides encryption facilities via the [Phalcon\Crypt](api/Phalcon_Crypt) component. This class offers simple object-oriented wrappers to the [openssl](https://www.php.net/manual/en/book.openssl.php) PHP's encryption library.

By default, this component provides secure encryption using AES-256-CFB.

The cipher AES-256 is used among other places in SSL/TLS across the Internet. It's considered among the top ciphers. In theory it's not crackable since the combinations of keys are massive. Although NSA has categorized this in [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), they have also recommended using higher than 128-bit keys for encryption.

<h5 class='alert alert-warning'>You must use a key length corresponding to the current algorithm. For the algorithm used by default it is 32 bytes.</h5>

<a name='usage'></a>

## 基本的な使い方

This component is designed be very simple to use:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

/**
 * Set the cipher algorithm.
 *
 * The `aes-256-gcm' is the preferable cipher, but it is not usable until the
 * openssl library is upgraded, which is available in PHP 7.1.
 *
 * The `aes-256-ctr' is arguably the best choice for cipher
 * algorithm in these days.
 */
$crypt->setCipher('aes-256-ctr');

/**
 * Set the encryption key.
 *
 * The `$key' should have been previously generated in a cryptographically safe way.
 *
 * Bad key:
 * "le password"
 *
 * Better (but still unsafe):
 * "#1dj8$=dp?.ak//j1V$~%*0X"
 *
 * Good key:
 * "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
 *
 * Use your own key. この例の鍵をコピーペーストしないでください。
 */
$key = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'This is the text that you want to encrypt.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

You can also set the algorithm and whether to calculate a digest of the message (signing) during the object construction. This removes the need to call `setCipher()` and `useSigning()`:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt('aes-256-ctr', true);

$key = "T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'This is the text that you want to encrypt.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

You can use the same instance to encrypt/decrypt several times:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');

// Use your own keys!
$texts = [
    "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c" => 'This is a secret text',
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3" => 'This is a very secret',
];

foreach ($texts as $key => $text) {
    // Perform the encryption
    $encrypted = $crypt->encrypt($text, $key);

    // Now decrypt
    echo $crypt->decrypt($encrypted, $key);
}
```

For better security, you can instruct the component to calculate a message digest based on one of the supported algorithms returned by `getAvailableHashAlgos`. As seen above this algorithm can be set during the object instantiation but can also be set afterwards.

**NOTE** Calculating the message digest (signing) will be enabled by default in Phalcon 4.0.0 or greater.

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');
$crypt->setHashAlgo('aes-256-cfb');

// Force calculation of a digest of the message based on the Hash algorithm
$crypt->useSigning(true);

$key  = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\x5c";
$text = 'This is a secret text';

// Perform the encryption
$encrypted = $crypt->encrypt($text, $key);

// Now decrypt
echo $crypt->decrypt($encrypted, $key);
```

<a name='options'></a>

## Encryption Options

The following options are available to change the encryption behavior:

| Name   | Description                                                                                                                                                           |
| ------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | The cipher is one of the encryption algorithms supported by openssl. You can see a list [here](https://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Example:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use blowfish
$crypt->setCipher('bf-cbc');

// Use your own key!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'This is a secret text';

echo $crypt->encrypt($text, $key);
```

If you wish to check the available algorithms that your system supports you can call the `getAvailableHashAlgos()` method.

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Get the supported algorithms
$algorithms = $crypt->getAvailableHashAlgos();

var_dump($algorithms);
```

<a name='base64'></a>

## Base64 Support

In order for encryption to be properly transmitted (emails) or displayed (browsers) [base64](https://www.php.net/manual/en/function.base64-encode.php) encoding is usually applied to encrypted texts:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use your own key!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'This is a secret text';

$encrypt = $crypt->encryptBase64($text, $key);

echo $crypt->decryptBase64($encrypt, $key);
```

<a name='service'></a>

## Setting up an Encryption service

You can set up the encryption component in the services container in order to use it from any part of the application:

```php
<?php

use Phalcon\Crypt;

$di->set(
    'crypt',
    function () {
        $crypt = new Crypt();

        // Set a global encryption key
        $crypt->setKey(
            "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
        );

        return $crypt;
    },
    true
);
```

Then, for example, in a controller you can use it as follows:

```php
<?php

use Phalcon\Mvc\Controller;

class SecretsController extends Controller
{
    public function saveAction()
    {
        $secret = new Secrets();

        $text = $this->request->getPost('text');

        $secret->content = $this->crypt->encrypt($text);

        if ($secret->save()) {
            $this->flash->success(
                'Secret was successfully created!'
            );
        }
    }
}
```

<a name='links'></a>

## Links

* [Advanced Encryption Standard (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [What is block cipher](https://en.wikipedia.org/wiki/Block_cipher)
* [Introduction to Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encryption](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recommendation for Block Cipher Modes of Operation: Methods and Techniques](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Counter (CTR) mode](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)