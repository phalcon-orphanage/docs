---
layout: default
title: 'Crypt'
keywords: 'crypt, encriptación, desencriptación, cifrados'
---

# Componente Crypt
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

> **NOTE**: Requires PHP's [openssl][openssl] extension to be present in the system 
> 
> {: .alert .alert-info }

> **DOES NOT** support insecure algorithms with modes: 
> 
> `des*`, `rc2*`, `rc4*`, `des*`, `*ecb` 
> 
> {: .alert .alert-danger }

Phalcon provides encryption facilities via the [Phalcon\Crypt][crypt] component. This class offers simple object-oriented wrappers to the [openssl][openssl] PHP's encryption library.

Por defecto, este componente usa el cifrado `AES-256-CFB`.

El cifrado AES-256 se usa, entre otros lugares, en SSL/TLS a través de Internet. Se considera de los mejores cifrados. En teoría no es *crackeable* ya que las combinaciones de claves son masivas. Although NSA has categorized this in [Suite B][suite_b], they have also recommended using higher than 128-bit keys for encryption.

> **NOTE**: You must use a key length corresponding to the current algorithm. Para el algoritmo predeterminado `aes-256-cfb` el tamaño de clave predeterminado es de 32 bytes. 
> 
> {: .alert .alert-warning }

## Uso básico
Este componente se ha diseñado para ser muy simple de usar:

```php
<?php

use Phalcon\Crypt;

$key = "12345"; // Your luggage combination

$crypt     = new Crypt();
$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

Si no se pasan parámetros en el constructor, el componente usará el cifrado `aes-256-cfb` con la firma por defecto. Siempre puede cambiar el cifrado así como desactivar al firma.

```php
<?php

use Phalcon\Crypt;

$key   = "12345"; // Your luggage combination
$crypt = new Crypt();

$crypt
    ->setCipher('aes256')
    ->useSigning(false)
;

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

## Encriptar
El método `encrypt()` encripta una cadena. El componente usará el cifrado establecido previamente, que se ha establecido en el constructor o explícitamente. Si no se pasa `key` en el parámetro, se usará la clave previamente configurada.

```php
<?php

use Phalcon\Crypt;

$key   = "12345"; // Your luggage combination
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text);
```

o usando la clave como segundo parámetro

```php
<?php

use Phalcon\Crypt;

$key       = "12345"; // Your luggage combination
$crypt     = new Crypt();
$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);
```

El método también usará internamente la firma por defecto. Siempre puede usar `useSigning(false)` antes de la llamada al método para deshabilitarla.

> **NOTA: Si elige cifrados relativos a `ccm` o `gcm`, debe también proporcionar `authData` para ellos. De lo contrario se lanzará una excepción. 
> 
> {: .alert .alert-warning }

## Desencriptar
El método `decrypt()` desencripta una cadena. Similar a `encrypt()` el componente usará el cifrado previamente configurado, que puede haber sido establecido en el constructor o explícitamente. Si no se pasa `key` en el parámetro, se usará la clave previamente configurada.

```php
<?php

use Phalcon\Crypt;

$key   = "12345"; // Your luggage combination
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3';
$encrypted = $crypt->decrypt($text);
```

o usando la clave como segundo parámetro

```php
<?php

use Phalcon\Crypt;

$key   = "12345"; // Your luggage combination
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3';
$encrypted = $crypt->decrypt($text, $key);
```

El método también usará internamente la firma por defecto. Siempre puede usar `useSigning(false)` antes de la llamada al método para deshabilitarla.

## Encriptar en Base64
Se puede usar `encryptBase64()` para encriptar una cadena de una manera amigable con URL. Internamente usa `encrypt()` y acepta `text` y opcionalmente la `key` del elemento a encriptar. There is also a third parameter `safe` (defaults to `false`) which will perform string replacements for non URL _friendly_ characters such as `+` or `/`.

## Desencriptar en Base64
Se puede usar `decryptBase64()` para desencriptar una cadena de una manera amigable con URL. De forma similar a `encryptBase64()` usa `decrypt()` internamente y acepta el `text` y opcionalmente la `key` del elemento a desencriptar. There is also a third parameter `safe` (defaults to `false`) which will perform string replacements for previously replaced non URL _friendly_  characters such as `+` or `/`.

## Excepciones
Exceptions thrown in the [Phalcon\Crypt][crypt] component will be of type \[Phalcon\Crypt\Exception\]\[config-exception\]. If however you are using signing and the calculated hash for `decrypt()` does not match, [Phalcon\Crypt\Mismatch][crypt-mismatch] will be thrown. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Crypt\Mismatch;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Get some configuration values
            $this->crypt->decrypt('hello');
        } catch (Mismatch $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Funcionalidad
### Cifrados
`getCipher()` devuelve el cifrado seleccionado actualmente. Si no se ha definido ninguno explícitamente mediante `setCipher()` o el constructor del objeto se seleccionará `aes-256-cfb` por defecto. `aes-256-gcm` es el cifrado preferido.

Siempre puede obtener un vector con todos los cifrados disponibles en su sistema llamando a `getAvailableCiphers()`.

### Algoritmo Hash
`getHashAlgo()` devuelve el algoritmo de *hash* que usa el componente. Si no se ha definido ninguno explícitamente mediante `setHashAlgo()` se usará `sha256`. Si no está disponible en el sistema el algoritmo de *hash* definido o es incorrecto, se lanzará \[Phalcon\Crypt\Exception\]\[crypt=exception\].

Siempre puede obtener un vector con todos los algoritmos de *hash* disponibles en su sistema llamando a `getAvailableHashAlgos()`.

### Claves
El componente ofrece un *getter* y un *setter* para la clave a usar. Una vez configurada la clave, se usará para cualquier operación de encriptado o desencriptado (siempre que no se defina el parámetro `key` cuando use estos métodos).

* `getKey()`: Devuelve la clave de encriptación.
* `setKey()` Establece la clave de encriptación.

> Siempre debería crear las claves lo más seguras posible. `12345` podría ser buena para su combinación de equipaje, o `password1` para su email, pero para su aplicación debería intentar algo mucho más complejo. Cuanto más larga y más aleatoria sea la clave, mejor. Por supuesto, el tamaño depende del cifrado elegido. 
> 
> Varios servicios online pueden generar un texto aleatorio y fuerte que se puede usar como clave. Alternativamente, siempre puede usar los métodos `hash()` del componente [Phalcon\Security](security), que pueden ofrecer una clave fuerte al hacer *hash* de una cadena. 
> 
> {: .alert .alert-danger }

### Firma
Para indicar al componente que use la firma o no, está disponible `useSigning`. Acepta un booleano que establece un parámetro internamente, que indica si la firma se debe usar o no.

### Datos de Autenticación
Si el cifrado seleccionado es del tipo `gcm` o `ccm` (como termina el nombre del cifrado), se necesitan datos de autenticación para el componente para encriptar y desencriptar correctamente los datos. Los métodos disponibles para esa operación son:

* `setAuthTag()`
* `setAuthData()`
* `setAuthTagLength()` - por defecto `16`

### Relleno
Puede establecer el relleno a usar por el componente usando `setPadding()`. Por defecto, el componente usará `PADDING_DEFAULT`. Las constantes de rellenos disponibles son:

* `PADDING_ANSI_X_923`
* `PADDING_DEFAULT`
* `PADDING_ISO_10126`
* `PADDING_ISO_IEC_7816_4`
* `PADDING_PKCS7`
* `PADDING_SPACE`
* `PADDING_ZERO`

## Inyección de Dependencias
As with most Phalcon components, you can store the [Phalcon\Crypt][crypt] object in your [Phalcon\Di](di) container. Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Crypt;

// Create a container
$container = new FactoryDefault();

$container->set(
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

El componente está ahora disponible en sus controladores usando la clave `crypt`

```php
<?php

use MyApp\Models\Secrets;
use Phalcon\Crypt;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * @property Crypt   $crypt
 * @property Request $request
 */
class SecretsController extends Controller
{
    public function saveAction()
    {
        $secret = new Secrets();

        $text = $this->request->getPost('text');

        $secret->content = $this->crypt->encrypt($text);

        if ($secret->save()) {
            $this->flash->success(
                'Secret was successfully created!'
            );
        }
    }
}
```

## Enlaces

* [Estándar de Encriptación Avanzado (AES)](https://es.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [Qué es un cifrado de bloque](https://es.wikipedia.org/wiki/Cifrado_por_bloques)
* [Introducción a Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [Modo de Encriptación CTR](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recomendación para Modos Cifrado de Bloque de Operación: Métodos y Técnicas](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Modo contador (CTR)](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)

[openssl]: https://www.php.net/manual/en/book.openssl.php
[suite_b]: https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography
[crypt]: api/phalcon_crypt#crypt
[crypt-mismatch]: api/phalcon_crypt#crypt-mismatch
