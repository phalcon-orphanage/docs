---
layout: default
language: 'es-es'
version: '5.0'
title: 'Crypt'
upgrade: '#encryption'
keywords: 'crypt, encriptación, desencriptación, cifrados'
---

# Componente Crypt
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen

> **NOTE**: Requires PHP's [openssl][openssl] extension to be present in the system 
> 
> {: .alert .alert-info }

> **DOES NOT** support insecure algorithms with modes: 
> 
> `des*`, `rc2*`, `rc4*`, `des*`, `*ecb` 
> 
> {: .alert .alert-danger }

Phalcon provides encryption facilities via the [Phalcon\Encryption\Crypt][crypt] component. This class offers simple object-oriented wrappers to the [openssl][openssl] PHP's encryption library.

Por defecto, este componente usa el cifrado `AES-256-CFB`.

El cifrado AES-256 se usa, entre otros lugares, en SSL/TLS a través de Internet. Se considera de los mejores cifrados. In theory, it is not crackable since the combinations of keys are massive. Although NSA has categorized this in [Suite B][suite_b], they have also recommended using higher than 128-bit keys for encryption.

> **NOTE**: You must use a key length corresponding to the current algorithm. Para el algoritmo predeterminado `aes-256-cfb` el tamaño de clave predeterminado es de 32 bytes. 
> 
> {: .alert .alert-warning }

## Uso básico
Este componente se ha diseñado para ser muy simple de usar:

```php
<?php

use Phalcon\Encryption\Crypt;

$key = "12345";

$crypt     = new Crypt();
$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

Si no se pasan parámetros en el constructor, el componente usará el cifrado `aes-256-cfb` con la firma por defecto. Siempre puede cambiar el cifrado así como desactivar al firma.

> **NOTE**: The constructor also accepts a parameter for signing requests. For v5, the default value for this parameter has changed to `true` 
> 
> {: .alert .alert-warning }

> **NOTE**: The constructor accepts now a [Phalcon\Encryption\Crypt\PadFactory][pad-factory] as a third parameter. If not specified, a [Phalcon\Encryption\Crypt\PadFactory][pad-factory] object will be created for you 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Encryption\Crypt;
use Phalcon\Encryption\Crypt\PadFactory;

$key = "12345";

$padFactory = new PadFactory();
$crypt      = new Crypt("aes-256-cfb", true, $padFactory);

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

```php
<?php

use Phalcon\Encryption\Crypt;

$key   = "12345";
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

use Phalcon\Encryption\Crypt;

$key   = "12345"; 
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'This is the text that you want to encrypt.';
$encrypted = $crypt->encrypt($text);
```

o usando la clave como segundo parámetro

```php
<?php

use Phalcon\Encryption\Crypt;

$key       = "12345"; 
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

use Phalcon\Encryption\Crypt;

$key   = "12345"; 
$crypt = new Crypt();
$crypt->setKey($key);

$text      = 'T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3';
$encrypted = $crypt->decrypt($text);
```

o usando la clave como segundo parámetro

```php
<?php

use Phalcon\Encryption\Crypt;

$key   = "12345"; 
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
Exceptions thrown in the [Phalcon\Encryption\Crypt][crypt] component will be of type \[Phalcon\Encryption\Crypt\Exception\]\[config-exception\]. If however you are using signing and the calculated hash for `decrypt()` does not match, [Phalcon\Encryption\Crypt\Mismatch][crypt-mismatch] will be thrown. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Encryption\Crypt\Mismatch;
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
`getHashAlgo()` devuelve el algoritmo de *hash* que usa el componente. Si no se ha definido ninguno explícitamente mediante `setHashAlgo()` se usará `sha256`. If the hash algorithm defined is not available in the system or is wrong, a \[Phalcon\Encryption\Crypt\Exception\]\[crypt=exception\] will be thrown.

Siempre puede obtener un vector con todos los algoritmos de *hash* disponibles en su sistema llamando a `getAvailableHashAlgos()`.

### Claves
El componente ofrece un *getter* y un *setter* para la clave a usar. Una vez configurada la clave, se usará para cualquier operación de encriptado o desencriptado (siempre que no se defina el parámetro `key` cuando use estos métodos).

* `getKey()`: Devuelve la clave de encriptación.
* `setKey()` Establece la clave de encriptación.

> Siempre debería crear las claves lo más seguras posible. `12345` podría ser buena para su combinación de equipaje, o `password1` para su email, pero para su aplicación debería intentar algo mucho más complejo. Cuanto más larga y más aleatoria sea la clave, mejor. Por supuesto, el tamaño depende del cifrado elegido. 
> 
> Varios servicios online pueden generar un texto aleatorio y fuerte que se puede usar como clave. Alternatively you can always use the `hash()` methods from the [Phalcon\Security](encryption-security) component, which can offer a strong key by hashing a string. 
> 
> {: .alert .alert-danger }

### Firma
Para indicar al componente que use la firma o no, está disponible `useSigning`. Acepta un booleano que establece un parámetro internamente, que indica si la firma se debe usar o no.

### Datos de Autenticación
Si el cifrado seleccionado es del tipo `gcm` o `ccm` (como termina el nombre del cifrado), se necesitan datos de autenticación para el componente para encriptar y desencriptar correctamente los datos. Los métodos disponibles para esa operación son:

* `setAuthTag()`
* `setAuthData()`
* `setAuthTagLength()` - (`16`)

### Relleno
Puede establecer el relleno a usar por el componente usando `setPadding()`. By default, the component will use `PADDING_DEFAULT`. Las constantes de rellenos disponibles son:

* `PADDING_ANSI_X_923`
* `PADDING_DEFAULT`
* `PADDING_ISO_10126`
* `PADDING_ISO_IEC_7816_4`
* `PADDING_PKCS7`
* `PADDING_SPACE`
* `PADDING_ZERO`

## Inyección de Dependencias
As with most Phalcon components, you can store the [Phalcon\Encryption\Crypt][crypt] object in your [Phalcon\Di](di) container. Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Encryption\Crypt;

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
use Phalcon\Encryption\Crypt;
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

## Constantes
Two constants are available:

* `DEFAULT_ALGORITHM = "sha256"`
* `DEFAULT_CIPHER    = "aes-256-cfb"`

* `PADDING_ANSI_X_923`     = 1
* `PADDING_DEFAULT`        = 0
* `PADDING_ISO_10126`      = 3
* `PADDING_ISO_IEC_7816_4` = 4
* `PADDING_PKCS7`          = 2
* `PADDING_SPACE`          = 6
* `PADDING_ZERO`           = 5

You can use them in your project or override them if you want to implement your own class.

## Métodos

```php
public function __construct(string $cipher = self::DEFAULT_CIPHER, bool $useSigning = true, PadFactory $padFactory = null)
```
Constructor

```php
public function decrypt(string $input, string $key = null): string
```
Decrypt an encrypted text

```php
public function decryptBase64(string $input, string $key = null, bool $safe = false): string
```
Decrypt a text that is coded as a `base64` string

```php
public function encrypt(string $input, string $key = null): string
```
Encrypt a text

```php
public function encryptBase64(string $input, string $key = null, bool $safe = false
): string
```
Encrypts a text returning the result as a `base64` string

```php
public function getAvailableCiphers(): array
```
Return a list of available ciphers

```php
public function getAuthData(): string
```
Return the auth data

```php
public function getAuthTag(): string
```
Return the auth tag

```php
public function getAuthTagLength(): int
```
Return the auth tag length

```php
public function getAvailableHashAlgorithms(): array
```
Return a list of registered hashing algorithms suitable for `hash_hmac`

```php
public function getHashAlgorithm(): string
```
Obtiene el nombre del algoritmo de *hash*.

```php
public function getCipher(): string
```
Devuelve el cifrado actual

```php
public function getKey(): string
```
Devuelve la clave de encriptación

```php
public function isValidDecryptLength(string $input): bool
```
Returns if the input length for decryption is valid or not (number of bytes required by the cipher)

```php
public function setAuthData(string $data): CryptInterface
```
Set the auth data

```php
public function setAuthTag(string $tag): CryptInterface
```
Set the auth tag

```php
public function setAuthTagLength(int $length): CryptInterface
```
Set the auth tag length

```php
public function setCipher(string $cipher): CryptInterface
```
Set the cipher algorithm for data encryption and decryption

```php
public function setKey(string $key): CryptInterface
```

```php
public function setHashAlgorithm(string $hashAlgorithm): CryptInterface
```
Establece el nombre del algoritmo de *hash*.

```php
public function setPadding(int $scheme): CryptInterface
```
Set the padding scheme

```php
public function useSigning(bool $useSigning): CryptInterface
```
Use a message digest (signing) to be used or not

## PadFactory
The [Phalcon\Encryption\Crypt\PadFactory][pad-factory] is an object that instantiates classes to be used for padding and unpadding data during encryption or decryption.

| Nombre     | Clase                                           |
| ---------- | ----------------------------------------------- |
| `ansi`     | `Phalcon\Encryption\Crypt\Padding\Ansi`     |
| `iso10126` | `Phalcon\Encryption\Crypt\Padding\Iso10126` |
| `isoiek`   | `Phalcon\Encryption\Crypt\Padding\IsoIek`   |
| `noop`     | `Phalcon\Encryption\Crypt\Padding\Noop`     |
| `pjcs7`    | `Phalcon\Encryption\Crypt\Padding\Pkcs7`    |
| `space`    | `Phalcon\Encryption\Crypt\Padding\Space`    |
| `zero`     | `Phalcon\Encryption\Crypt\Padding\Zero`     |

[Phalcon\Encryption\Crypt\Padding\PadInterface][pad-interface] is also available, should you need to create your own padding strategy. Note that you will need to register the new padding class in the [Phalcon\Encryption\Crypt\PadFactory][pad-factory] and inject it to the constructor of the [Phalcon\Encryption\Crypt][crypt] component.

## Enlaces

* [Estándar de Encriptación Avanzado (AES)](https://es.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [Qué es un cifrado de bloque](https://es.wikipedia.org/wiki/Cifrado_por_bloques)
* [Introducción a Blowfish](https://www.splashdata.com/splashid/blowfish.htm)
* [Modo de Encriptación CTR](https://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recomendación para Modos Cifrado de Bloque de Operación: Métodos y Técnicas](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Modo contador (CTR)](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)

[openssl]: https://www.php.net/manual/en/book.openssl.php
[suite_b]: https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography
[crypt]: api/phalcon_encryption#crypt
[crypt-mismatch]: api/phalcon_encryption#crypt-mismatch
[pad-factory]: api/phalcon_encryption#encryption-crypt-padfactory
[pad-interface]: api/phalcon_encryption#encryption-crypt-padding-padinterface
