* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Encriptado / Desencriptado

Phalcon provides encryption facilities via the [Phalcon\Crypt](api/Phalcon_Crypt) component. This class offers simple object-oriented wrappers to the [openssl](https://www.php.net/manual/en/book.openssl.php) PHP's encryption library.

De forma predeterminada, este componente proporciona cifrado seguro utilizando AES-256-CFB.

El algoritmo de cifrado AES-256 es utilizado entre otros en SSL/TLS a través de Internet. Se considera entre los mejores cifradores. En teoría no es manipulable ya que las combinaciones de claves son enormes. Aunque la NSA la ha categorizado en la [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), también ha recomendado el uso de claves de encriptación de 128-bit y superiores.

<h5 class='alert alert-warning'>You must use a key length corresponding to the current algorithm. For the algorithm used by default it is 32 bytes.</h5>

<a name='usage'></a>

## Uso básico

Este componente está diseñado para ser muy fácil de usar:

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

También puede establecer el algoritmo y si se debe calcular un resumen del mensaje (firma) durante la construcción del objeto. Esto elimina la necesidad de llamar a `setCipher()` y `useSigning()`:

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

Para mayor seguridad, puede indicar al componente que calcule un resumen del mensaje basado en uno de los algoritmos admitidos devueltos por `getAvailableHashAlgos`. Como puede verse, este algoritmo se puede establecer durante la instanciación del objecto pero también se puede establecer después.

**NOTA** Calculando el resumen del mensajes (firma) estará activado por defecto a partir de Phalcon 4.0.0 o superior.

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

Si desea cmoprobar los algoritmos disponibles en su sistema, puede llamar al método `getAvailableHashAlgos()`.

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