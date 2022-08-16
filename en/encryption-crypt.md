---
layout: default
language: 'en'
version: '5.0'
title: 'Crypt'
upgrade: '#encryption'
keywords: 'crypt, encryption, decryption, ciphers'
---
# Crypt Component
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

> **NOTE**: Requires PHP's [openssl][openssl] extension to be present in the system
{: .alert .alert-info }

> **DOES NOT** support insecure algorithms with modes: 
>
>`des*`, `rc2*`, `rc4*`, `des*`, `*ecb`
{: .alert .alert-danger }

Phalcon provides encryption facilities via the [Phalcon\Encryption\Crypt][crypt] component. This class offers simple object-oriented wrappers to the [openssl][openssl] PHP's encryption library.

By default, this component utilizes the `AES-256-CFB` cipher.

The cipher AES-256 is used among other places in SSL/TLS across the Internet. It's considered among the top ciphers. In theory, it is not crackable since the combinations of keys are massive. Although NSA has categorized this in [Suite B][suite_b], they have also recommended using higher than 128-bit keys for encryption.

> **NOTE**: You must use a key length corresponding to the current algorithm. For the default algorithm `aes-256-cfb` the default key length is 32 bytes.
{: .alert .alert-warning }

## Basic Usage
This component is designed to be very simple to use:

```php
<?php

use Phalcon\Encryption\Crypt;

$key = "12345";

$crypt     = new Crypt();
$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

If no parameters are passed in the constructor, the component will use the `aes-256-cfb` cipher with signing by default. You can always change the cipher as well as disable signing.

> **NOTE**: The constructor also accepts a parameter for signing requests. For v5, the default value for this parameter has changed to `true`
{: .alert .alert-warning }

> **NOTE**: The constructor accepts now a [Phalcon\Encryption\Crypt\PadFactory][pad-factory] as a third parameter. If not specified, a [Phalcon\Encryption\Crypt\PadFactory][pad-factory] object will be created for you
{: .alert .alert-info }

```php
<?php

use Phalcon\Encryption\Crypt;
use Phalcon\Encryption\Crypt\PadFactory;

$key = "12345";

$padFactory = new PadFactory();
$crypt      = new Crypt("aes-256-cfb", true, $padFactory);

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

```php
<?php

use Phalcon\Encryption\Crypt;

$key   = "12345";
$crypt = new Crypt();

$crypt
    ->setCipher('aes256')
    ->useSigning(false)
;

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

## Encrypt
The `encrypt()` method encrypts a string. The component will use the previously set cipher, which has been set in the constructor or explicitly. If no `key` is passed in the parameter, the previously set key will be used.

```php
<?php

use Phalcon\Encryption\Crypt;

$key   = "12345"; 
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text);
```

or using the key as the second parameter

```php
<?php

use Phalcon\Encryption\Crypt;

$key       = "12345"; 
$crypt     = new Crypt();
$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);
```

The method will also internally use signing by default. You can always use `useSigning(false)` prior to the method call to disable it.

> **NOTE: If you choose `ccm` or `gcm` related ciphers, you must also supply `authData` for them. An exception will be thrown otherwise.
{: .alert .alert-warning }

## Decrypt
The `decrypt()` method decrypts a string. Similar to `encrypt()` the component will use the previously set cipher, which has been set in the constructor or explicitly. If no `key` is passed in the parameter, the previously set key will be used.

```php
<?php

use Phalcon\Encryption\Crypt;

$key   = "12345"; 
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3';
$encrypted = $crypt->decrypt($text);
```

or using the key as the second parameter

```php
<?php

use Phalcon\Encryption\Crypt;

$key   = "12345"; 
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3';
$encrypted = $crypt->decrypt($text, $key);
```

The method will also internally use signing by default. You can always use `useSigning(false)` prior to the method call to disable it.

## Base64 Encrypt
The `encryptBase64()` can be used to encrypt a string in a URL friendly way. It uses `encrypt()` internally and accepts the `text` and optionally the `key` of the element to encrypt. There is also a third parameter `safe` (defaults to `false`) which will perform string replacements for non URL _friendly_ characters such as `+` or `/`.

## Base64 Decrypt
The `decryptBase64()` can be used to decrypt a string in a URL friendly way. Similar to `encryptBase64()` it uses `decrypt()` internally and accepts the `text` and optionally the `key` of the element to encrypt. There is also a third parameter `safe` (defaults to `false`) which will perform string replacements for previously replaced non URL _friendly_  characters such as `+` or `/`.

## Exceptions
Exceptions thrown in the [Phalcon\Encryption\Crypt][crypt] component will be of type [Phalcon\Encryption\Crypt\Exception][config-exception]. If however you are using signing and the calculated hash for `decrypt()` does not match, [Phalcon\Encryption\Crypt\Mismatch][crypt-mismatch] will be thrown. You can use these exceptions to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Encryption\Crypt\Mismatch;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Get some configuration values
            $this->crypt->decrypt('hello');
        } catch (Mismatch $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Functionality
### Ciphers
The getter `getCipher()` returns the currently selected cipher. If none has been explicitly defined either by the setter `setCipher()` or the constructor of the object the `aes-256-cfb` is selected by default. The `aes-256-gcm` is the preferable cipher.

You can always get an array of all the available ciphers for your system by calling  `getAvailableCiphers()`.

### Hash Algorithm
The getter `getHashAlgo()` returns the hashing algorithm use by the component. If none has been explicitly defined by the setter `setHashAlgo()` the `sha256` will be used. If the hash algorithm defined is not available in the system or is wrong, a [Phalcon\Encryption\Crypt\Exception][crypt=exception] will be thrown.
   
You can always get an array of all the available hashing algorithms for your system by calling  `getAvailableHashAlgos()`.

### Keys
The component offers a getter and a setter for the key to be used. Once the key is set, it will be used for any encrypting or decrypting operation (provided that the `key` parameter is not defined when using these methods).

* `getKey()`: Returns the encryption key.
* `setKey()` Sets the encryption key.

> You should always create as secure keys as possible. `12345` might be good for your luggage combination, or `password1` for your email, but for your application you should try something a lot more complex. The longer and more random the key is the better. The length of course depends on the chosen cipher. 
>
>Several online services can generate a random and strong text that can be used for a key. Alternatively you can always use the `hash()` methods from the [Phalcon\Security](encryption-security) component, which can offer a strong key by hashing a string.
{: .alert .alert-danger }

### Signing
To instruct the component to use signing or not, `useSigning` is available. It accepts a boolean which sets a flag internally, specifying whether signing will be used or not.

### Auth Data
If the cipher selected is of type `gcm` or `ccm` (what the cipher name ends with), auth data is required for the component to correctly encrypt or decrypt data. The methods available for this operation are:

* `setAuthTag()`
* `setAuthData()`
* `setAuthTagLength()` - (`16`)

### Padding
You can also set the padding used by the component by using `setPadding()`. By default, the component will use `PADDING_DEFAULT`. The available padding constants are:

* `PADDING_ANSI_X_923`
* `PADDING_DEFAULT`
* `PADDING_ISO_10126`
* `PADDING_ISO_IEC_7816_4`
* `PADDING_PKCS7`
* `PADDING_SPACE`
* `PADDING_ZERO`

## Dependency Injection
As with most Phalcon components, you can store the [Phalcon\Encryption\Crypt][crypt] object in your [Phalcon\Di](di) container. By doing so, you will be able to access your configuration object from controllers, models, views and any component that implements `Injectable`.

An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Encryption\Crypt;

// Create a container
$container = new FactoryDefault();

$container->set(
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

The component is now available in your controllers using the `crypt` key

```php
<?php

use MyApp\Models\Secrets;
use Phalcon\Encryption\Crypt;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * @property Crypt   $crypt
 * @property Request $request
 */
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

## Constants
Two constants are available:

* `DEFAULT_ALGORITHM = "sha256"`
* `DEFAULT_CIPHER    = "aes-256-cfb"`

* `PADDING_ANSI_X_923`     = 1
* `PADDING_DEFAULT`        = 0
* `PADDING_ISO_10126`      = 3
* `PADDING_ISO_IEC_7816_4` = 4
* `PADDING_PKCS7`          = 2
* `PADDING_SPACE`          = 6
* `PADDING_ZERO`           = 5

You can use them in your project or override them if you want to implement your own class.

## Methods

```php
public function __construct(string $cipher = self::DEFAULT_CIPHER, bool $useSigning = true, PadFactory $padFactory = null)
```
Constructor

```php
public function decrypt(string $input, string $key = null): string
```
Decrypt an encrypted text

```php
public function decryptBase64(string $input, string $key = null, bool $safe = false): string
```
Decrypt a text that is coded as a `base64` string

```php
public function encrypt(string $input, string $key = null): string
```
Encrypt a text

```php
public function encryptBase64(string $input, string $key = null, bool $safe = false
): string
```
Encrypts a text returning the result as a `base64` string

```php
public function getAvailableCiphers(): array
```
Return a list of available ciphers

```php
public function getAuthData(): string
```
Return the auth data

```php
public function getAuthTag(): string
```
Return the auth tag

```php
public function getAuthTagLength(): int
```
Return the auth tag length

```php
public function getAvailableHashAlgorithms(): array
```
Return a list of registered hashing algorithms suitable for `hash_hmac`

```php
public function getHashAlgorithm(): string
```
Get the name of hashing algorithm.

```php
public function getCipher(): string
```
Returns the current cipher

```php
public function getKey(): string
```
Returns the encryption key

```php
public function isValidDecryptLength(string $input): bool
```
Returns if the input length for decryption is valid or not (number of bytes required by the cipher)

```php
public function setAuthData(string $data): CryptInterface
```
Set the auth data

```php
public function setAuthTag(string $tag): CryptInterface
```
Set the auth tag

```php
public function setAuthTagLength(int $length): CryptInterface
```
Set the auth tag length

```php
public function setCipher(string $cipher): CryptInterface
```
Set the cipher algorithm for data encryption and decryption

```php
public function setKey(string $key): CryptInterface
```

```php
public function setHashAlgorithm(string $hashAlgorithm): CryptInterface
```
Set the name of hashing algorithm.

```php
public function setPadding(int $scheme): CryptInterface
```
Set the padding scheme

```php
public function useSigning(bool $useSigning): CryptInterface
```
Use a message digest (signing) to be used or not

## PadFactory
The [Phalcon\Encryption\Crypt\PadFactory][pad-factory] is an object that instantiates classes to be used for padding and unpadding data during encryption or decryption.

| Name       | Class                                       |
|------------|---------------------------------------------|
| `ansi`     | `Phalcon\Encryption\Crypt\Padding\Ansi`     |
| `iso10126` | `Phalcon\Encryption\Crypt\Padding\Iso10126` |
| `isoiek`   | `Phalcon\Encryption\Crypt\Padding\IsoIek`   |
| `noop`     | `Phalcon\Encryption\Crypt\Padding\Noop`     |
| `pjcs7`    | `Phalcon\Encryption\Crypt\Padding\Pkcs7`    |
| `space`    | `Phalcon\Encryption\Crypt\Padding\Space`    |
| `zero`     | `Phalcon\Encryption\Crypt\Padding\Zero`     |

[Phalcon\Encryption\Crypt\Padding\PadInterface][pad-interface] is also available, should you need to create your own padding strategy. Note that you will need to register the new padding class in the [Phalcon\Encryption\Crypt\PadFactory][pad-factory] and inject it to the constructor of the [Phalcon\Encryption\Crypt][crypt] component.

## Links

* [Advanced Encryption Standard (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [What is block cipher](https://en.wikipedia.org/wiki/Block_cipher)
* [Introduction to Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encryption](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recommendation for Block Cipher Modes of Operation: Methods and Techniques](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Counter (CTR) mode](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)

[base64]: https://www.php.net/manual/en/function.base64-encode.php
[cipher_methods]: https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
[openssl]: https://www.php.net/manual/en/book.openssl.php
[suite_b]: https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography
[crypt]: api/phalcon_encryption#crypt
[crypt-cryptinterface]: api/phalcon_encryption#crypt-cryptinterface
[crypt-exception]: api/phalcon_encryption#crypt-exception
[crypt-mismatch]: api/phalcon_encryption#crypt-mismatch
[pad-factory]: api/phalcon_encryption#encryption-crypt-padfactory
[pad-interface]: api/phalcon_encryption#encryption-crypt-padding-padinterface
