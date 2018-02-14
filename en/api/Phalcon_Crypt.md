# Class **Phalcon\\Crypt**

*implements* [Phalcon\CryptInterface](/en/3.1.2/api/Phalcon_CryptInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/crypt.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Provides encryption facilities to phalcon applications

```php
<?php

$crypt = new \Phalcon\Crypt();

$key  = "le password";
$text = "This is a secret text";

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);

```

## Constants
*integer* **PADDING_DEFAULT**

*integer* **PADDING_ANSI_X_923**

*integer* **PADDING_PKCS7**

*integer* **PADDING_ISO_10126**

*integer* **PADDING_ISO_IEC_7816_4**

*integer* **PADDING_ZERO**

*integer* **PADDING_SPACE**

## Methods
public  **setPadding** (*mixed* $scheme)

Changes the padding scheme used

public  **setCipher** (*mixed* $cipher)

Sets the cipher algorithm

public  **getCipher** ()

Returns the current cipher

public  **setKey** (*mixed* $key)

Sets the encryption key

public  **getKey** ()

Returns the encryption key

protected  **_cryptPadText** (*mixed* $text, *mixed* $mode, *mixed* $blockSize, *mixed* $paddingType)

Pads texts before encryption

protected  **_cryptUnpadText** (*mixed* $text, *mixed* $mode, *mixed* $blockSize, *mixed* $paddingType)

If the function detects that the text was not padded, it will return it unmodified

public  **encrypt** (*mixed* $text, [*mixed* $key])

Encrypts a text

```php
<?php

$encrypted = $crypt->encrypt("Ultra-secret text", "encrypt password");

```

public  **decrypt** (*mixed* $text, [*mixed* $key])

Decrypts an encrypted text

```php
<?php

echo $crypt->decrypt($encrypted, "decrypt password");

```

public  **encryptBase64** (*mixed* $text, [*mixed* $key], [*mixed* $safe])

Encrypts a text returning the result as a base64 string

public  **decryptBase64** (*mixed* $text, [*mixed* $key], [*mixed* $safe])

Decrypt a text that is coded as a base64 string

public  **getAvailableCiphers** ()

Returns a list of available ciphers

