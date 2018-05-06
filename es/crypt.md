<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Encriptado / Desencriptado</a> <ul>
        <li>
          <a href="#usage">Uso básico</a>
        </li>
        <li>
          <a href="#options">Opciones de encriptado</a>
        </li>
        <li>
          <a href="#base64">Soporte Base64</a>
        </li>
        <li>
          <a href="#service">Configurando el servicio de encriptación</a>
        </li>
        <li>
          <a href="#links">Enlaces</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Encriptado / Desencriptado

Phalcon proporciona un servicio de cifrado mediante el componente `Phalcon\Crypt`. Esta clase ofrece una envoltura simple orientada a objetos a la biblioteca de cifrado [openssl](http://www.php.net/manual/en/book.openssl.php) de PHP.

De forma predeterminada, este componente proporciona cifrado seguro utilizando AES-256-CFB.

The cipher AES-256 is used among other places in SSL/TLS across the Internet. It's considered among the top ciphers. In theory it's not crackable since the combinations of keys are massive. Although NSA has categorized this in [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), they have also recommended using higher than 128-bit keys for encryption.

<div class="alert alert-warning">
    <p>
        Se debe utilizar una longitud de clave que corresponda con el algoritmo actual. El algoritmo usado por defecto es 32 bytes.
    </p>
</div>

<a name='usage'></a>

## Uso básico

Este componente está diseñado para proporcionar un uso muy sencillo:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

/**
 * Set the cipher algorithm.
 *
 * The `aes-256-gcm' is the preferable cipher, but it is not usable until the
 * openssl library is upgraded, which is available in PHP 7.1.
 *
 * The `aes-256-ctr' is arguably the best choice for cipher
 * algorithm in these days.
 */
$crypt->setCipher('aes-256-ctr');

/**
 * Set the encryption key.
 *
 * The `$key' should have been previously generated in a cryptographically safe way.
 *
 * Bad key:
 * "le password"
 *
 * Better (but still unsafe):
 * "#1dj8$=dp?.ak//j1V$~%*0X"
 *
 * Good key:
 * "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
 *
 * Use your own key. Do not copy and paste this example key.
 */
$key = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'This is the text that you want to encrypt.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

Puede utilizar la misma instancia para encriptar/desencriptar varias veces:

```php
<?php

use Phalcon\Crypt;

$crypt->setCipher('aes-256-ctr');

// Create an instance
$crypt = new Crypt();

// Use your own keys!
$texts = [
    "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c" => 'This is a secret text',
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3" => 'This is a very secret',
];

foreach ($texts as $key => $text) {
    // Perform the encryption
    $encrypted = $crypt->encrypt($text, $key);

    // Now decrypt
    echo $crypt->decrypt($encrypted, $key);
}
```

<a name='options'></a>

## Opciones de encriptado

Las siguientes opciones están disponibles para cambiar el comportamiento de cifrado:

| Nombre | Descripción                                                                                                                                                                     |
| ------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | Cipher es uno de los algoritmos de encriptación soportados por openssl. Usted puede ver una lista [ aquí](http://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Ejemplo:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use blowfish
$crypt->setCipher('bf-cbc');

// Use your own key!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'This is a secret text';

echo $crypt->encrypt($text, $key);
```

<a name='base64'></a>

## Soporte Base64

Para que el cifrado se transmita correctamente (correos electrónicos) o se muestre (navegadores), generalmente se aplica el cifrado [base64](http://www.php.net/manual/en/function.base64-encode.php) a textos:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use your own key!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'This is a secret text';

$encrypt = $crypt->encryptBase64($text, $key);

echo $crypt->decryptBase64($encrypt, $key);
```

<a name='service'></a>

## Configurando el servicio de encriptación

Puede configurar el componente de encriptación en un contenedor de servicios para su uso desde cualquier parte de la aplicación:

```php
<?php

use Phalcon\Crypt;

$di->set(
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

Entonces, por ejemplo, en un controller usted puede utilizarlo de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Controller;

class SecretsController extends Controller
{
    public function saveAction()
    {
        $secret = new Secrets();

        $text = $this->request->getPost('text');

        $secret->content = $this->crypt->encrypt($text);

        if ($secret->save()) {
            $this->flash->success(
                '¡Secreto creado correctamente!'
            );
        }
    }
}
```

<a name='links'></a>

## Enlaces

* [Estándar de cifrado avanzado (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [Qué es el bloque Cipher](https://en.wikipedia.org/wiki/Block_cipher)
* [Introducción a Blowfish](http://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encryption](http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recommendation for Block Cipher Modes of Operation: Methods and Techniques](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Counter (CTR) mode](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)