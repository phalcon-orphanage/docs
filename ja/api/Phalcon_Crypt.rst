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

public :doc:`Phalcon\\CryptInterface <Phalcon_CryptInterface>`  **setPadding** (*unknown* $scheme)





public :doc:`Phalcon\\Crypt <Phalcon_Crypt>`  **setCipher** (*unknown* $cipher)

Sets the cipher algorithm



public *string*  **getCipher** ()

Returns the current cipher



public :doc:`Phalcon\\Crypt <Phalcon_Crypt>`  **setMode** (*unknown* $mode)

Sets the encrypt/decrypt mode



public *string*  **getMode** ()

Returns the current encryption mode



public :doc:`Phalcon\\Crypt <Phalcon_Crypt>`  **setKey** (*unknown* $key)

Sets the encryption key



public *string*  **getKey** ()

Returns the encryption key



private  **_cryptPadText** (*unknown* $text, *unknown* $mode, *unknown* $blockSize, *unknown* $paddingType)





private  **_cryptUnpadText** (*unknown* $text, *unknown* $mode, *unknown* $blockSize, *unknown* $paddingType)

If the function detects that the text was not padded, it will return it unmodified



public *string*  **encrypt** (*unknown* $text, [*unknown* $key])

Encrypts a text 

.. code-block:: php

    <?php

    $encrypted = $crypt->encrypt("Ultra-secret text", "encrypt password");




public *string*  **decrypt** (*unknown* $text, [*unknown* $key])

Decrypts an encrypted text 

.. code-block:: php

    <?php

    echo $crypt->decrypt($encrypted, "decrypt password");




public *string*  **encryptBase64** (*unknown* $text, [*unknown* $key], [*unknown* $safe])

Encrypts a text returning the result as a base64 string



public *string*  **decryptBase64** (*unknown* $text, [*unknown* $key], [*unknown* $safe])

Decrypt a text that is coded as a base64 string



public *array*  **getAvailableCiphers** ()

Returns a list of available cyphers



public *array*  **getAvailableModes** ()

Returns a list of available modes



