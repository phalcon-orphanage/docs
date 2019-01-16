* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Crypt'

* * *

# Class **Phalcon\Crypt**

*implements* [Phalcon\CryptInterface](Phalcon_CryptInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/crypt.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Provides encryption facilities to phalcon applications

```php
<?php

$crypt = new \Phalcon\Crypt();

$key  = "le password";
$text = "This is a secret text";

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);

```

## Constantes

*integer* **PADDING_ANSI_X_923**

*integer* **PADDING_DEFAULT**

*integer* **PADDING_ISO_10126**

*integer* **PADDING_ISO_IEC_7816_4**

*integer* **PADDING_PKCS7**

*integer* **PADDING_SPACE**

*integer* **PADDING_ZERO**

## Properties

### Protected

*string* **$_key**;

*integer* **$_padding** = 0;

*string* **$_cipher** = "aes-256-cfb";

*array* **$availableCiphers**;

Available cipher methods.

*integer* **$ivLength** = 16; The cipher iv length.

*string* **$hashAlgo** = "sha256";

The name of hashing algorithm.

*boolean* **$useSigning** = false; Whether calculating message digest enabled or not **NOTE**: This feature will be enabled by default in Phalcon 4.0.0

## Métodos

### Public

public **__construct**(*string* $cipher = "aes-256-cfb", *boolean* $useSigning = false)

Class constructor. Allows the user to set the algorithm used to calculate a digest of the message (signing) and to force signing or not.

public **decrypt** (*mixed* $text [, *mixed* $key = null]): *string*

Decrypts an encrypted text

Throws [Phalcon\Crypt\Mismatch](Phalcon_Crypt_Mismatch)

```php
<?php

$encrypted = $crypt->decrypt(
    $encrypted,
    "T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);

```

public **decryptBase64** (*string* $text [,*mixed* $key = null [,*boolean* $safe = false]]): *string*

Decrypt a text that is coded as a base64 string

Throws [Phalcon\Crypt\Mismatch](Phalcon_Crypt_Mismatch)

public **encrypt** (*mixed* $text [, *mixed* $key = null]): *string*

Encrypts a text

```php
<?php

$encrypted = $crypt->encrypt(
    "Top secret",
    "T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```

public **encryptBase64** (*string* $text [,*mixed* $key = null [,*boolean* $safe = false]]): *string*

Encrypts a text returning the result as a base64 string

public **getAvailableCiphers** (): *array*

Returns a list of available ciphers

public **getAvailableHashAlgos** (): *array*

Return a list of registered hashing algorithms suitable for [hash_hmac](https://secure.php.net/manual/en/function.hash-hmac.php).

public **getCipher** ()

Returns the current cipher

public **getHashAlgo** (): *string*

Return the name of hashing algorithm.

public **getKey** (): *string*

Returns the encryption key

public **setCipher** (*mixed* $cipher): *[Phalcon\Crypt](Phalcon_Crypt)*

Sets the cipher algorithm for data encryption and decryption. The `aes-256-gcm` is the preferable cipher, but it is not usable until the openssl library is upgraded, which is available in PHP 7.1. The `aes-256-ctr` is arguably the best choice for cipher algorithm for current openssl library version.

Throws: [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception)

public **setHashAlgo** (*string* $hashAlgo): *[Phalcon\Crypt](Phalcon_Crypt)*

Set the name of hashing algorithm to calculate the message digest. Throws [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception) if the algorithm is not supported by the system

public **setKey** (*mixed* $key): *[Phalcon\Crypt](Phalcon_Crypt)*

Sets the encryption key. The `$key` should have been previously generated in a cryptographically safe way.

Bad key: `le password`

Better (but still unsafe): `#1dj8$=dp?.ak//j1V$~%*0X`

Good key: `T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3`

See also: : [Phalcon\Security\Random](Phalcon_Security_Random)

public **setPadding** (*mixed* $scheme): *[Phalcon\Crypt](Phalcon_Crypt)*

Changes the padding scheme used

public **useSigning** (*boolean* $useSigning): *[Phalcon\Crypt](Phalcon_Crypt)*

Sets if the calculating message digest must used (signing). **NOTE**: This feature will be enabled by default in Phalcon 4.0.0 or greater

### Protected

protected **_cryptPadText** (*mixed* $text, *mixed* $mode, *mixed* $blockSize, *mixed* $paddingType)

Pads texts before encryption.

See: <https://www.di-mgt.com.au/cryptopad.html>

protected **_cryptUnpadText** (*mixed* $text, *mixed* $mode, *mixed* $blockSize, *mixed* $paddingType)

Removes a padding from a text. If the function detects that the text was not padded, it will return it unmodified

| Tipo   | Nombre       | Descripción                                                   |
| ------ | ------------ | ------------------------------------------------------------- |
| string | $text        | Message to be unpadded                                        |
| string | $mode        | Encryption mode; unpadding is applied only in CBC or ECB mode |
| int    | $blockSize   | Cipher block size                                             |
| int    | $paddingType | Padding scheme                                                |

protected **assertCipherIsAvailable** (*string* $cipher)

Assert the cipher is available.

Throws [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception)

protected **assertHashAlgorithmAvailable** (*string* $hashAlgo)

Assert the hash algorithm is available.

Throws [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception)

protected **getIvLength** (*string* $cipher): *int*

Initialize available cipher algorithms.

Throws [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception)

protected **initializeAvailableCiphers** ()

Initialize available cipher algorithms.

Throws [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception)