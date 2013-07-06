Class **Phalcon\\Crypt**
========================

*implements* :doc:`Phalcon\\CryptInterface <Phalcon_CryptInterface>`

Provides encryption facilities to phalcon applications  

.. code-block:: php

    <?php

    $crypt = new Phalcon\Crypt();
    
    $key = 'le password';
    $text = 'This is a secret text';
    
    $encrypted = $crypt->encrypt($text, $key);
    
    echo $crypt->decrypt($encrypted, $key);



Methods
---------

public *Phalcon\\Encrypt*  **setCipher** (*string* $cipher)

Sets the cipher algorithm



public *string*  **getCipher** ()

Returns the current cipher



public *Phalcon\\Encrypt*  **setMode** (*unknown* $mode)

Sets the encrypt/decrypt mode



public *string*  **getMode** ()

Returns the current encryption mode



public *Phalcon\\Encrypt*  **setKey** (*string* $key)

Sets the encryption key



public *string*  **getKey** ()

Returns the encryption key



public *string*  **encrypt** (*string* $text, [*string* $key])

Encrypts a text 

.. code-block:: php

    <?php

    $encrypted = $crypt->encrypt("Ultra-secret text", "encrypt password");




public *string*  **decrypt** (*string* $text, [*string* $key])

Decrypts an encrypted text 

.. code-block:: php

    <?php

    echo $crypt->decrypt($encrypted, "decrypt password");




public *string*  **encryptBase64** (*string* $text, [*string* $key])

Encrypts a text returning the result as a base64 string



public *string*  **decryptBase64** (*string* $text, [*string* $key])

Decrypt a text that is coded as a base64 string



public *array*  **getAvailableCiphers** ()

Returns a list of available cyphers



public *array*  **getAvailableModes** ()

Returns a list of available modes



