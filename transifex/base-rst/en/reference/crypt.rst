%{crypt_f360a3a20fa1a3c3b28ba77a0a8d84be}%
=====================
%{crypt_61a86bea91a553c0ef46ff2d3ce32f88|:doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`}%

%{crypt_957df3c33bcabdc3862c027235e7ad7b}%

%{crypt_b0320f4a950d93f7f09a91c29ce5132b}%
-----------
%{crypt_3fa9f2edea33b150c507a3a7430d6b2e}%

.. code-block:: php

    <?php

    //{%crypt_caffa55d2bb1f88d35912a062b63800b%}
    $crypt = new Phalcon\Crypt();

    $key = 'le password';
    $text = 'This is a secret text';

    $encrypted = $crypt->encrypt($text, $key);

    echo $crypt->decrypt($encrypted, $key);


%{crypt_6f4a10bd7455ec95763a6e294e8cf725}%

.. code-block:: php

    <?php

    //{%crypt_caffa55d2bb1f88d35912a062b63800b%}
    $crypt = new Phalcon\Crypt();

    $texts = array(
        'my-key' => 'This is a secret text',
        'other-key' => 'This is a very secret'
    );

    foreach ($texts as $key => $text) {

        //{%crypt_993e5016bd265574d5e74141770259ab%}
        $encrypted = $crypt->encrypt($text, $key);

        //{%crypt_1072447f72a215872c6300026fa6591d%}
        echo $crypt->decrypt($encrypted, $key);
    }


%{crypt_c6a0e7ea1b497e531e4c2b9ba931ff03}%
------------------
%{crypt_36fc07ecbfdf209582225327af389134}%

+------------+---------------------------------------------------------------------------------------------------+
| Name       | Description                                                                                       |
+============+===================================================================================================+
| Cipher     | The cipher is one of the encryption algorithms supported by libmcrypt. You can see a list here_   |
+------------+---------------------------------------------------------------------------------------------------+
| Mode       | One of the encryption modes supported by libmcrypt (ecb, cbc, cfb, ofb)                           |
+------------+---------------------------------------------------------------------------------------------------+


%{crypt_74d36f46f78c5347bb7efc53be29b2dd}%

.. code-block:: php

    <?php

    //{%crypt_caffa55d2bb1f88d35912a062b63800b%}
    $crypt = new Phalcon\Crypt();

    //{%crypt_b6e3cbdc85ac9e9ac40e8eac65a8e9c6%}
    $crypt->setCipher('blowfish');

    $key = 'le password';
    $text = 'This is a secret text';

    echo $crypt->encrypt($text, $key);


%{crypt_347c782d992d779c9a8704504648d478}%
--------------
%{crypt_8e9cfbbc7197e914936752480dcdb981}%

.. code-block:: php

    <?php

    //{%crypt_caffa55d2bb1f88d35912a062b63800b%}
    $crypt = new Phalcon\Crypt();

    $key = 'le password';
    $text = 'This is a secret text';

    $encrypt = $crypt->encryptBase64($text, $key);

    echo $crypt->decryptBase64($text, $key);


%{crypt_7f46562c8af18fea5e1b5163c2f327e4}%
--------------------------------
%{crypt_2c1201ff75b1d531fdb8dd633c1904cb}%

.. code-block:: php

    <?php

    $di->set('crypt', function() {

        $crypt = new Phalcon\Crypt();

        //{%crypt_2281785d8b824849f017e6f3db8a07c8%}
        $crypt->setKey('%31.1e$i86e$f!8jz');

        return $crypt;
    }, true);


%{crypt_603c20f1dddc4539dfd9fed082276775}%

