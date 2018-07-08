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

El algoritmo de cifrado AES-256 es utilizado entre otros en SSL/TLS a través de Internet. Se considera entre los mejores cifradores. En teoría no es manipulable ya que las combinaciones de claves son enormes. Aunque la NSA la ha categorizado en la [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), también ha recomendado el uso de claves de encriptación de 128-bit y superiores.

<div class="alert alert-warning">
    <p>
        Debe utilizar una clave del largo correspondiente al algoritmo actual. Por defecto, para el algoritmo utilizado es 32 bytes.
    </p>
</div>

<a name='usage'></a>

## Uso básico

Este componente está diseñado para proporcionar un uso muy sencillo:

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

Puede utilizar la misma instancia para encriptar/desencriptar varias veces:

```php
<?php

use Phalcon\Crypt;

$crypt->setCipher('aes-256-ctr');

// Crear una instancia
$crypt = new Crypt();

// ¡Utilizar tu propia clave!
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

<a name='options'></a>

## Opciones de encriptado

Las siguientes opciones están disponibles para cambiar el comportamiento de cifrado:

| Nombre | Descripción                                                                                                                                                        |
| ------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Cipher | Cipher es uno de los algoritmos de encriptación soportados por openssl. Ver una lista [aquí](http://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

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

<a name='base64'></a>

## Soporte Base64

Para que el cifrado se transmita correctamente (correos electrónicos) o se muestre (navegadores), generalmente se aplica el cifrado [base64](http://www.php.net/manual/en/function.base64-encode.php) a textos:

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

Puede configurar el componente de encriptación en un contenedor de servicios para su uso desde cualquier parte de la aplicación:

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
* [CTR-Mode Encriptado](http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recomendación para modos de operación de cifrado en bloque: métodos y técnicas](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Modo de contador (CTR)](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)