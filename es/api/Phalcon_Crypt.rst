Class **Phalcon\\Crypt**
========================

*implements* :doc:`Phalcon\\CryptInterface <Phalcon_CryptInterface>`

Provides encryption facilities to phalcon applications  

.. code-block:: php

    <?php

    $crypt = new \Phalcon\Crypt();
    
    $key = 'le password';
    $text = 'This is a secret text';
    
    $encrypted = $crypt->encrypt($text, $key);
    
    echo $crypt->decrypt($encrypted, $key);



Constants
---------

*integer* **PADDING_DEFAULT**

*integer* **PADDING_ANSI_X_923**

*integer* **PADDING_PKCS7**

*integer* **PADDING_ISO_10126**

*integer* **PADDING_ISO_IEC_7816_4**

*integer* **PADDING_ZERO**

*integer* **PADDING_SPACE**

Methods
-------

public  **setPadding** (*unknown* $scheme)





public  **setCipher** (*unknown* $cipher)

Sets the cipher algorithm



public  **getCipher** ()

Returns the current cipher



public  **setMode** (*unknown* $mode)

Sets the encrypt/decrypt mode



public  **getMode** ()

Returns the current encryption mode



public  **setKey** (*unknown* $key)

Sets the encryption key



public  **getKey** ()

Returns the encryption key



protected  **_cryptPadText** (*unknown* $text, *unknown* $mode, *unknown* $blockSize, *unknown* $paddingType)





protected  **_cryptUnpadText** (*unknown* $text, *unknown* $mode, *unknown* $blockSize, *unknown* $paddingType)

If the function detects that the text was not padded, it will return it unmodified



public  **encrypt** (*unknown* $text, [*unknown* $key])

Encrypts a text 

.. code-block:: php

    <?php

    $encrypted = $crypt->encrypt("Ultra-secret text", "encrypt password");




public  **decrypt** (*unknown* $text, [*unknown* $key])

Decrypts an encrypted text 

.. code-block:: php

    <?php

    echo $crypt->decrypt($encrypted, "decrypt password");




public  **encryptBase64** (*unknown* $text, [*unknown* $key], [*unknown* $safe])

Encrypts a text returning the result as a base64 string



public  **decryptBase64** (*unknown* $text, [*unknown* $key], [*unknown* $safe])

Decrypt a text that is coded as a base64 string



public  **getAvailableCiphers** ()

Returns a list of available cyphers



public  **getAvailableModes** ()

Returns a list of available modes



