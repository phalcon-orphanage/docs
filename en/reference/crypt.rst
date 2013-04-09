Encryption/Decryption
=====================

Phalcon provides encryption facilities via the :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt` component.
This class offers easy object-oriented wrappers to the mcrypt_ php's library.

By default, this component provides secure encryption using AES-256 (rijndael-256-cbc).

Basic Usage
-----------
This component is designed to provide a very simple usage:

.. code-block:: php

    <?php

	//Create an instance
	$encryption = new Phalcon\Crypt();

	$key = 'le password';
	$text = 'This is a secret text';

	$encrypted = $encryption->encrypt($text, $key);

	echo $encryption->decrypt($encrypted, $key);

You can use the same instance to encrypt/decrypt several times:

.. code-block:: php

    <?php

	//Create an instance
	$encryption = new Phalcon\Crypt();

	$texts = array(
		'my-key' => 'This is a secret text',
		'other-key' => 'This is a very secret'
	);

	foreach ($texts as $key => $text) {

		//Perform the encryption
		$encrypted = $encryption->encrypt($text, $key);

		//Now decrypt
		echo $encryption->decrypt($encrypted, $key);
	}

Encryption Options
------------------
The following options are available to change the encryption behavior:

+------------+---------------------------------------------------------------------------------------------------+
| Name       | Description                                                                                       |
+============+===================================================================================================+
| Cipher     | The cipher is one of the encryption algorithms supported by libmcrypt. You can see a list here_   |
+------------+---------------------------------------------------------------------------------------------------+
| Mode       | One of the encryption modes supported by libmcrypt (ecb, cbc, cfb, ofb)                           |
+------------+---------------------------------------------------------------------------------------------------+

Example:

.. code-block:: php

    <?php

	//Create an instance
	$encryption = new Phalcon\Crypt();

	//Use blowfish
	$encryption->setCipher('blowfish');

	$key = 'le password';
	$text = 'This is a secret text';

	echo $encryption->encrypt($text, $key);

Base64 Support
--------------
In order that encryption is properly transmited (emails) or displayed (browsers) base64_ encoding is usually applied to encrypted texts:

.. code-block:: php

    <?php

	//Create an instance
	$encryption = new Phalcon\Crypt();

	$key = 'le password';
	$text = 'This is a secret text';

	$encrypt = $encryption->encryptBase64($text, $key);

	echo $encryption->decryptBase64($text, $key);

.. _mcrypt: http://www.php.net/manual/en/book.mcrypt.php
.. _here: http://www.php.net/manual/en/mcrypt.ciphers.php
.. _base64: http://www.php.net/manual/en/function.base64-encode.php
