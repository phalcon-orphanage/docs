---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Phalcon\Crypt'
---

* [Phalcon\Crypt](#crypt)
* [Phalcon\Crypt\CryptInterface](#crypt-cryptinterface)
* [Phalcon\Crypt\Exception](#crypt-exception)
* [Phalcon\Crypt\Mismatch](#crypt-mismatch)

<h1 id="crypt">Class Phalcon\Crypt</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Crypt.zep)

| Namespace | Phalcon | | Uses | Phalcon\Crypt\CryptInterface, Phalcon\Crypt\Exception, Phalcon\Crypt\Mismatch | | Implements | CryptInterface |

Provides encryption capabilities to Phalcon applications.

```php
use Phalcon\Crypt;

$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');

$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = "The message to be encrypted";

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

## Constants

```php
const PADDING_ANSI_X_923 = 1;
const PADDING_DEFAULT = 0;
const PADDING_ISO_10126 = 3;
const PADDING_ISO_IEC_7816_4 = 4;
const PADDING_PKCS7 = 2;
const PADDING_SPACE = 6;
const PADDING_ZERO = 5;
```

## Properties

```php
/**
 * @var string
 */
protected authTag;

/**
 * @var string
 */
protected authData = ;

/**
 * @var int
 */
protected authTagLength = 16;

/**
 * @var string
 */
protected key;

/**
 * @var int
 */
protected padding = 0;

/**
 * @var string
 */
protected cipher = aes-256-cfb;

/**
 * Available cipher methods.
 * @var array
 */
protected availableCiphers;

/**
 * The cipher iv length.
 * @var int
 */
protected ivLength = 16;

/**
 * The name of hashing algorithm.
 * @var string
 */
protected hashAlgo = sha256;

/**
 * Whether calculating message digest enabled or not.
 *
 * @var bool
 */
protected useSigning = true;

```

## Methods

Phalcon\Crypt constructor.

```php
public function __construct( string $cipher = string, bool $useSigning = bool );
```

Decrypts an encrypted text.

```php
$encrypted = $crypt->decrypt(
    $encrypted,
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```

```php
public function decrypt( string $text, string $key = null ): string;
```

Decrypt a text that is coded as a base64 string.

@throws \Phalcon\Crypt\Mismatch

```php
public function decryptBase64( string $text, mixed $key = null, bool $safe = bool ): string;
```

Encrypts a text.

```php
$encrypted = $crypt->encrypt(
    "Top secret",
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```

```php
public function encrypt( string $text, string $key = null ): string;
```

Encrypts a text returning the result as a base64 string.

```php
public function encryptBase64( string $text, mixed $key = null, bool $safe = bool ): string;
```

```php
public function getAuthData(): string
```

```php
public function getAuthTag(): string
```

```php
public function getAuthTagLength(): int
```

Returns a list of available ciphers.

```php
public function getAvailableCiphers(): array;
```

Return a list of registered hashing algorithms suitable for hash_hmac.

```php
public function getAvailableHashAlgos(): array;
```

Returns the current cipher

```php
public function getCipher(): string;
```

Get the name of hashing algorithm.

```php
public function getHashAlgo(): string;
```

Returns the encryption key

```php
public function getKey(): string;
```

```php
public function setAuthData( string $data ): CryptInterface;
```

```php
public function setAuthTag( string $tag ): CryptInterface;
```

```php
public function setAuthTagLength( int $length ): CryptInterface;
```

Sets the cipher algorithm for data encryption and decryption.

The `aes-256-gcm' is the preferable cipher, but it is not usable until the openssl library is upgraded, which is available in PHP 7.1.

The `aes-256-ctr' is arguably the best choice for cipher algorithm for current openssl library version.

```php
public function setCipher( string $cipher ): CryptInterface;
```

Set the name of hashing algorithm.

@throws \Phalcon\Crypt\Exception

```php
public function setHashAlgo( string $hashAlgo ): CryptInterface;
```

Sets the encryption key.

The `$key' should have been previously generated in a cryptographically safe way.

Bad key: "le password"

Better (but still unsafe): "#1dj8$=dp?.ak//j1V$~%*0X"

Good key: "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"

```php
public function setKey( string $key ): CryptInterface;
```

Changes the padding scheme used.

```php
public function setPadding( int $scheme ): CryptInterface;
```

Sets if the calculating message digest must used.

```php
public function useSigning( bool $useSigning ): CryptInterface;
```

Assert the cipher is available.

```php
protected function assertCipherIsAvailable( string $cipher ): void;
```

Assert the hash algorithm is available.

```php
protected function assertHashAlgorithmAvailable( string $hashAlgo ): void;
```

Pads texts before encryption. See [cryptopad](http://www.di-mgt.com.au/cryptopad.html)

```php
protected function cryptPadText( string $text, string $mode, int $blockSize, int $paddingType ): string;
```

Removes a padding from a text.

If the function detects that the text was not padded, it will return it unmodified.

```php
protected function cryptUnpadText( string $text, string $mode, int $blockSize, int $paddingType );
```

Initialize available cipher algorithms.

```php
protected function getIvLength( string $cipher ): int;
```

Initialize available cipher algorithms.

```php
protected function initializeAvailableCiphers(): void;
```

<h1 id="crypt-cryptinterface">Interface Phalcon\Crypt\CryptInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Crypt/CryptInterface.zep)

| Namespace | Phalcon\Crypt |

Interface for Phalcon\Crypt

## Methods

Decrypts a text

```php
public function decrypt( string $text, string $key = null ): string;
```

Decrypt a text that is coded as a base64 string

```php
public function decryptBase64( string $text, mixed $key = null ): string;
```

Encrypts a text

```php
public function encrypt( string $text, string $key = null ): string;
```

Encrypts a text returning the result as a base64 string

```php
public function encryptBase64( string $text, mixed $key = null ): string;
```

Returns authentication data

```php
public function getAuthData(): string;
```

Returns the authentication tag

```php
public function getAuthTag(): string;
```

Returns the authentication tag length

```php
public function getAuthTagLength(): int;
```

Returns a list of available cyphers

```php
public function getAvailableCiphers(): array;
```

Returns the current cipher

```php
public function getCipher(): string;
```

Returns the encryption key

```php
public function getKey(): string;
```

Sets authentication data

```php
public function setAuthData( string $data ): CryptInterface;
```

Sets the authentication tag

```php
public function setAuthTag( string $tag ): CryptInterface;
```

Sets the authentication tag length

```php
public function setAuthTagLength( int $length ): CryptInterface;
```

Sets the cipher algorithm

```php
public function setCipher( string $cipher ): CryptInterface;
```

Sets the encryption key

```php
public function setKey( string $key ): CryptInterface;
```

Changes the padding scheme used.

```php
public function setPadding( int $scheme ): CryptInterface;
```

<h1 id="crypt-exception">Class Phalcon\Crypt\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Crypt/Exception.zep)

| Namespace | Phalcon\Crypt | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Crypt use this class

<h1 id="crypt-mismatch">Class Phalcon\Crypt\Mismatch</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Crypt/Mismatch.zep)

| Namespace | Phalcon\Crypt | | Extends | Exception |

Exceptions thrown in Phalcon\Crypt will use this class.