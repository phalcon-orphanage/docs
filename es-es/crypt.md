---
layout: default
language: 'es-es'
version: '4.0'
title: 'Crypt'
---

# Componente Crypt

* * *

## Encriptación y desencriptación

Phalcon provee el servicio de encriptación mediante el componente [Phalcon\Crypt](api/Phalcon_Crypt). Esta clase ofrece una envoltura simple orientada a objetos de la biblioteca de cifrado [OpenSSL](https://secure.php.net/manual/es/book.openssl.php) de PHP.

El componente ofrece encriptación segura utilizando AES-256-CFB por defecto.

El cifrado AES-256 es de uso común en las comunicaciones SSL/TLS, entre otros, en Internet y se considera como uno de los mejores. En teoría no es fácil romperlo puesto que la combinación de claves es ingente. La NSA lo ha catalogado en la [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography) de criptografía, si bien recomienda utilizar claves de más de 128-bit para encriptar.

> Se debe utilizar una llave con la longitud correspondiente al algoritmo utilizado. El algoritmo predeterminado emplea 32 bytes.
{: .alert .alert-warning }

## Uso básico

El componente está diseñado para ser usado de manera sencilla:

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

Al instanciar el objeto es posible tanto definir el algoritmo como solicitar un resumen del mensaje (firma). De esta manera no es necesario llamar `setCipher()` o `useSigning()`:

```php
<?php

use Phalcon\Crypt;

// Crear instancia
$crypt = new Crypt('aes-256-ctr', true);

$key = "T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'Este es un texto que debe ser encriptado.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

La misma instancia se puede utilizar varias veces para encriptar y desencriptar:

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

Para mayor seguridad, se puede ordenar al componente que calcule un resumen empleando alguno de los algoritmos que se encuentran en `getAvailableHashAlgos`. Como se mostró en un ejemplo anterior, esta opción se puede configurar al instanciar el objeto o, si se prefiere, después de hacerlo.

**Nota:** A partir de Phalcon 4.0.0 o superior, el cálculo del resumen (firma) estará activo de manera predeterminada.

```php
<?php

use Phalcon\Crypt;

// Crear instancia
$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');
$crypt->setHashAlgo('aes-256-cfb');

// Exigir el cálculo del resumen basado en el hash del algoritmo
$crypt->useSigning(true);

$key  = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\x5c";
$text = 'Este es un mensaje secreto';

// Realizar el encriptado
$encrypted = $crypt->encrypt($text, $key);

// Ahora desencriptar
echo $crypt->decrypt($encrypted, $key);
```

## Opciones de encriptación

Las opciones para configurar la encriptación son las siguientes:

| Nombre | Descripción                                                                                                                                                                            |
| ------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | Cipher es uno de los algoritmos de encriptación aceptados por OpenSSL. La lista completa se encuentra [aquí](https://secure.php.net/manual/es/function.openssl-get-cipher-methods.php) |

Ejemplo:

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

Se puede utilizar el método `getAvailableHashAlgos()` para saber cuáles algoritmos están disponibles en el sistema.

```php
<?php

use Phalcon\Crypt;

// Crear una instancia
$crypt = new Crypt();

// Obtener algoritmos disponibles
$algorithms = $crypt->getAvailableHashAlgos();

var_dump($algorithms);
```

## Soporte Base64

Para que el cifrado se transmita correctamente (correo electrónico) o se muestre (navegadores), generalmente se aplica el cifrado [base64](https://secure.php.net/manual/es/function.base64-encode.php) a los textos a encriptar:

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

## Configuración del servicio de encriptación

El componente de encriptación se puede incluir en el contenedor de servicios de tal manera que esté disponible en cualquier momento para la aplicación:

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

Luego, por ejemplo, se puede utilizar en un controlador de la siguiente manera:

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

## Enlaces

* [Estándar de cifrado avanzado (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [Qué es el bloque Cipher](https://en.wikipedia.org/wiki/Block_cipher)
* [Introducción a Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encriptado](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recomendación para modos de operación de cifrado en bloque: métodos y técnicas](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Modo de contador (CTR)](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)