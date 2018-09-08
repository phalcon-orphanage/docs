<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Encryption/Decryption</a> <ul>
        <li>
          <a href="#usage">Basic Usage</a>
        </li>
        <li>
          <a href="#options">Encryption Options</a>
        </li>
        <li>
          <a href="#base64">Base64 Support</a>
        </li>
        <li>
          <a href="#service">Setting up an Encryption service</a>
        </li>
        <li>
          <a href="#links">Links</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Encryption/Decryption

Phalcon provides encryption facilities via the `Phalcon\Crypt` component. This class offers simple object-oriented wrappers to the [openssl](http://www.php.net/manual/en/book.openssl.php) PHP's encryption library.

By default, this component provides secure encryption using AES-256-CFB.

<div class="alert alert-warning">
    <p>
        You must use a key length corresponding to the current algorithm. For the algorithm used by default it is 32 bytes.
    </p>
</div>

<a name='usage'></a>

## Basic Usage

This component is designed to provide a very simple usage:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

$key  = 'This is a secret key (32 bytes).';
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

$texts = [
    'my-key'    => 'This is a secret text',
    'other-key' => 'This is a very secret',
];

foreach ($texts as $key => $text) {
    // Perform the encryption
    $encrypted = $crypt->encrypt($text, $key);

    // Now decrypt
    echo $crypt->decrypt($encrypted, $key);
}
```

<a name='options'></a>

## Encryption Options

The following options are available to change the encryption behavior:

| Name   | Description                                                                                                                                                          |
| ------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | The cipher is one of the encryption algorithms supported by openssl. You can see a list [here](http://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Example:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use blowfish
$crypt->setCipher('bf-cbc');

$key  = 'le password';
$text = 'This is a secret text';

echo $crypt->encrypt($text, $key);
```

<a name='base64'></a>

## Base64 Support

In order for encryption to be properly transmitted (emails) or displayed (browsers) [base64](http://www.php.net/manual/en/function.base64-encode.php) encoding is usually applied to encrypted texts:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

$key  = 'le password';
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
            '%31.1e$i86e$f!8jz'
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
* [Introduction to Blowfish](http://www.splashdata.com/splashid/blowfish.htm)