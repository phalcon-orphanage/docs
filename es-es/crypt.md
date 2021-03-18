---
layout: default
language: 'es-es'
version: '4.0'
title: 'Crypt'
keywords: 'crypt, encriptación, desencriptación, cifrados'
---

# Componente Crypt

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen

> **NOTA**: Requiere que la extensión PHP [openssl](https://secure.php.net/manual/en/book.openssl.php) esté presente en el sistema
{: .alert .alert-info }

> 
> **NO** soporta algoritmos inseguros con modos:
> 
> `des*`, `rc2*`, `rc4*`, `des*`, `*ecb`
{: .alert .alert-danger }

Phalcon proporciona servicios de encriptación vía componente [Phalcon\Crypt](api/phalcon_crypt#crypt). Esta clase ofrece envolturas simples orientadas a objeto a la librería de encriptación PHP [openssl](https://secure.php.net/manual/en/book.openssl.php).

Por defecto, este componente usa el cifrado `AES-256-CFB`.

El cifrado AES-256 se usa, entre otros lugares, en SSL/TLS a través de Internet. Se considera de los mejores cifrados. En teoría no es *crackeable* ya que las combinaciones de claves son masivas. Aunque la NSA lo ha categorizado en [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), también han recomendado usar claves más grandes de 128-bit para encriptación.

> **NOTA**: Debe usar un tamaño de clave correspondiente al algoritmo actual. Para el algoritmo predeterminado `aes-256-cfb` el tamaño de clave predeterminado es de 32 bytes.
{: .alert .alert-warning }

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
{: .alert .alert-warning }

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

Se puede usar `encryptBase64()` para encriptar una cadena de una manera amigable con URL. Internamente usa `encrypt()` y acepta `text` y opcionalmente la `key` del elemento a encriptar. También hay un tercer parámetro `safe` (por defecto `false`) que realizará sustituciones de cadena para los caracteres no *amigables* en URL como `+` o `/`.

## Desencriptar en Base64

Se puede usar `decryptBase64()` para desencriptar una cadena de una manera amigable con URL. De forma similar a `encryptBase64()` usa `decrypt()` internamente y acepta el `text` y opcionalmente la `key` del elemento a desencriptar. También hay un tercer parámetro `safe` (por defecto `false`) que realizará sustituciones de cadena para los caracteres no *amigables* en URL previamente reemplazados como `+` o `/`.

## Excepciones

Las excepciones lanzadas en el componente [Phalcon\Crypt](api/phalcon_crypt#crypt) serán del tipo \[Phalcon\Crypt\Exception\]\[config-exception\]. Sin embargo, si está usando firma y el *hash* calculado para `decrypt()` no coincide, se lanzará [Phalcon\Crypt\Mismatch](api/phalcon_crypt#crypt-mismatch). Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

## Functionality

### Ciphers

The getter `getCipher()` returns the currently selected cipher. If none has been explicitly defined either by the setter `setCipher()` or the constructor of the object the `aes-256-cfb` is selected by default. The `aes-256-gcm` is the preferable cipher.

You can always get an array of all the available ciphers for your system by calling `getAvailableCiphers()`.

### Hash Algorithm

The getter `getHashAlgo()` returns the hashing algorithm use by the component. If none has been explicitly defined by the setter `setHashAlgo()` the `sha256` will be used. If the hash algorithm defined is not available in the system or is wrong, a \[Phalcon\Crypt\Exception\]\[crypt=exception\] will be thrown.

You can always get an array of all the available hashing algorithms for your system by calling `getAvailableHashAlgos()`.

### Keys

The component offers a getter and a setter for the key to be used. Once the key is set, it will be used for any encrypting or decrypting operation (provided that the `key` parameter is not defined when using these methods).

* `getKey()`: Returns the encryption key.
* `setKey()` Sets the encryption key.

> You should always create as secure keys as possible. `12345` might be good for your luggage combination, or `password1` for your email, but for your application you should try something a lot more complex. The longer and more random the key is the better. The length of course depends on the chosen cipher.
> 
> Several online services can generate a random and strong text that can be used for a key. Alternatively you can always use the `hash()` methods from the [Phalcon\Security](security) component, which can offer a strong key by hashing a string.
{: .alert .alert-danger }

### Signing

To instruct the component to use signing or not, `useSigning` is available. It accepts a boolean which sets a flag internally, specifying whether signing will be used or not.

### Auth Data

If the cipher selected is of type `gcm` or `ccm` (what the cipher name ends with), auth data is required for the component to correctly encrypt or decrypt data. The methods available for this operation are:

* `setAuthTag()`
* `setAuthData()`
* `setAuthTagLength()` - defaults to `16`

### Padding

You can also set the padding used by the component by using `setPadding()`. By default the component will use `PADDING_DEFAULT`. The available padding constants are:

* `PADDING_ANSI_X_923`
* `PADDING_DEFAULT`
* `PADDING_ISO_10126`
* `PADDING_ISO_IEC_7816_4`
* `PADDING_PKCS7`
* `PADDING_SPACE`
* `PADDING_ZERO`

## Inyección de Dependencias

As with most Phalcon components, you can store the [Phalcon\Crypt](api/phalcon_crypt#crypt) object in your [Phalcon\Di](di) container. By doing so, you will be able to access your configuration object from controllers, models, views and any component that implements `Injectable`.

An example of the registration of the service as well as accessing it is below:

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

The component is now available in your controllers using the `crypt` key

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

* [Advanced Encryption Standard (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [What is block cipher](https://en.wikipedia.org/wiki/Block_cipher)
* [Introduction to Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encryption](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recommendation for Block Cipher Modes of Operation: Methods and Techniques](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Counter (CTR) mode](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)