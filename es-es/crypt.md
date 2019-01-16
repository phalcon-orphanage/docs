* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Encriptado / Desencriptado

Phalcon provides encryption facilities via the [Phalcon\Crypt](api/Phalcon_Crypt) component. This class offers simple object-oriented wrappers to the [openssl](https://www.php.net/manual/en/book.openssl.php) PHP's encryption library.

By default, this component provides secure encryption using AES-256-CFB.

The cipher AES-256 is used among other places in SSL/TLS across the Internet. It's considered among the top ciphers. In theory it's not crackable since the combinations of keys are massive. Although NSA has categorized this in [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), they have also recommended using higher than 128-bit keys for encryption.

<h5 class='alert alert-warning'>You must use a key length corresponding to the current algorithm. For the algorithm used by default it is 32 bytes.</h5>

<a name='usage'></a>

## Uso básico

This component is designed be very simple to use:

```php
<?php

use Phalcon\Crypt;

// Crear una instancia
$crypt = new Crypt();

/**
 * Establecer el algoritmo de cifrado.
 *
 * El cifrado `aes-256-gcm' es el preferido, pero no se puede utilizar
 * hasta que la librería openssl este actualizada. Disponible desde PHP 7.1.
 *
 * El `aes-256-ctr' es posiblemente la mejor opción de algoritmo de cifrado
 * en estos días.
 */
$crypt->setCipher('aes-256-ctr');

/**
 * Establecer la clave de encriptación.
 *
 * El `$key' debe ser generado previamente de una manera criptográficamente segura.
 *
 * Clave insegura:
 * "mi password"
 *
 * Mejor (pero aún insegura):
 * "#1dj8$=dp?.ak//j1V$~%*0X"
 *
 * Clave segura:
 * "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
 *
 * Utiliza tu propia clave. No copiar y pegar esta clave de ejemplo.
 */
$key = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'Este es el texto que deseas encriptar.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

You can also set the algorithm and whether to calculate a digest of the message (signing) during the object construction. This removes the need to call `setCipher()` and `useSigning()`:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt('aes-256-ctr', true);

$key = "T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'This is the text that you want to encrypt.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

You can use the same instance to encrypt/decrypt several times:

```php
<?php

use Phalcon\Crypt;

// Crear una instancia
$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');

// ¡Utilice sus propias claves!
$texts = [
    "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c" => 'Este es un texto secreto',
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3" => 'Esto es muy secreto',
];

foreach ($texts as $key => $text) {
    // Realizar la encriptación
    $encrypted = $crypt->encrypt($text, $key);

    // Ahora descencriptar
    echo $crypt->decrypt($encrypted, $key);
}
```

For better security, you can instruct the component to calculate a message digest based on one of the supported algorithms returned by `getAvailableHashAlgos`. As seen above this algorithm can be set during the object instantiation but can also be set afterwards.

**NOTE** Calculating the message digest (signing) will be enabled by default in Phalcon 4.0.0 or greater.

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');
$crypt->setHashAlgo('aes-256-cfb');

// Force calculation of a digest of the message based on the Hash algorithm
$crypt->useSigning(true);

$key  = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\x5c";
$text = 'This is a secret text';

// Perform the encryption
$encrypted = $crypt->encrypt($text, $key);

// Now decrypt
echo $crypt->decrypt($encrypted, $key);
```

<a name='options'></a>

## Opciones de encriptado

The following options are available to change the encryption behavior:

| Nombre | Descripción                                                                                                                                                           |
| ------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | The cipher is one of the encryption algorithms supported by openssl. You can see a list [here](https://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Example:

```php
<?php

use Phalcon\Crypt;

// Crear una instancia
$crypt = new Crypt();

// Usar blowfish
$crypt->setCipher('bf-cbc');

// ¡Usar tu propia clave!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'Este es un texto secreto';

echo $crypt->encrypt($text, $key);
```

If you wish to check the available algorithms that your system supports you can call the `getAvailableHashAlgos()` method.

```php
<?php

use Phalcon\Crypt;

// Crear una instancia
$crypt = new Crypt();

// Obtener algoritmos disponibles
$algorithms = $crypt->getAvailableHashAlgos();

var_dump($algorithms);
```

<a name='base64'></a>

## Soporte Base64

In order for encryption to be properly transmitted (emails) or displayed (browsers) [base64](https://www.php.net/manual/en/function.base64-encode.php) encoding is usually applied to encrypted texts:

```php
<?php

use Phalcon\Crypt;

// Crear una instancia
$crypt = new Crypt();

// ¡Usar tu propia clave!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'Este es un texto secreto';

$encrypt = $crypt->encryptBase64($text, $key);

echo $crypt->decryptBase64($encrypt, $key);
```

<a name='service'></a>

## Configurando el servicio de encriptación

You can set up the encryption component in the services container in order to use it from any part of the application:

```php
<?php

use Phalcon\Crypt;

$di->set(
    'crypt',
    function () {
        $crypt = new Crypt();

        // Establecer una clave de encriptación global
        $crypt->setKey(
            "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
        );

        return $crypt;
    },
    true
);
```

Then, for example, in a controller you can use it as follows:

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
* [Introducción a Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encriptado](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recomendación para modos de operación de cifrado en bloque: métodos y técnicas](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Modo de contador (CTR)](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)