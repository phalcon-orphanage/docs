Interface **Phalcon\\CryptInterface**
=====================================

Phalcon\\CryptInterface initializer


Methods
-------

abstract public *Phalcon\\EncryptInterface*  **setCipher** (*string* $cipher)

Sets the cipher algorithm



abstract public *string*  **getCipher** ()

Returns the current cipher



abstract public *Phalcon\\EncryptInterface*  **setMode** (*unknown* $mode)

Sets the encrypt/decrypt mode



abstract public *string*  **getMode** ()

Returns the current encryption mode



abstract public *Phalcon\\EncryptInterface*  **setKey** (*string* $key)

Sets the encryption key



abstract public *string*  **getKey** ()

Returns the encryption key



abstract public *string*  **encrypt** (*string* $text, [*string* $key])

Encrypts a text



abstract public *string*  **decrypt** (*string* $text, [*string* $key])

Decrypts a text



abstract public *string*  **encryptBase64** (*string* $text, [*string* $key])

Encrypts a text returning the result as a base64 string



abstract public *string*  **decryptBase64** (*string* $text, [*string* $key])

Decrypt a text that is coded as a base64 string



abstract public *array*  **getAvailableCiphers** ()

Returns a list of available cyphers



abstract public *array*  **getAvailableModes** ()

Returns a list of available modes



