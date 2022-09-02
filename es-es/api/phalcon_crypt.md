---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Crypt'
---

* [Phalcon\Crypt](#crypt)
* [Phalcon\Crypt\CryptInterface](#crypt-cryptinterface)
* [Phalcon\Crypt\Exception](#crypt-exception)
* [Phalcon\Crypt\Mismatch](#crypt-mismatch)

<h1 id="crypt">Class Phalcon\Crypt</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Crypt.zep)

| Namespace | Phalcon | | Uses | Phalcon\Crypt\CryptInterface, Phalcon\Crypt\Exception, Phalcon\Crypt\Mismatch | | Implements | CryptInterface |

Proporciona capacidades de encriptado a las aplicaciones Phalcon.

```php
use Phalcon\Crypt;

$crypt = new Crypt();

$crypt->setCipher('aes-256-ctr');

$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = "The message to be encrypted";

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

## Constantes

```php
const PADDING_ANSI_X_923 = 1;
const PADDING_DEFAULT = 0;
const PADDING_ISO_10126 = 3;
const PADDING_ISO_IEC_7816_4 = 4;
const PADDING_PKCS7 = 2;
const PADDING_SPACE = 6;
const PADDING_ZERO = 5;
```

## Propiedades

```php
/**
 * @var string
 */
protected authTag;

/**
 * @var string
 */
protected authData = ;

/**
 * @var int
 */
protected authTagLength = 16;

/**
 * @var string
 */
protected key = ;

/**
 * @var int
 */
protected padding = 0;

/**
 * @var string
 */
protected cipher = aes-256-cfb;

/**
 * Available cipher methods.
 * @var array
 */
protected availableCiphers;

/**
 * The cipher iv length.
 * @var int
 */
protected ivLength = 16;

/**
 * The name of hashing algorithm.
 * @var string
 */
protected hashAlgo = sha256;

/**
 * Whether calculating message digest enabled or not.
 *
 * @var bool
 */
protected useSigning = true;

```

## Métodos

```php
public function __construct( string $cipher = string, bool $useSigning = bool );
```

Constructor Phalcon\Crypt.

```php
public function decrypt( string $text, string $key = null ): string;
```

Desencripta un texto encriptado.

```php
$encrypted = $crypt->decrypt(
    $encrypted,
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```

```php
public function decryptBase64( string $text, mixed $key = null, bool $safe = bool ): string;
```

Desencripta un texto que está codificado como cadena en base64.

@throws \Phalcon\Crypt\Mismatch

```php
public function encrypt( string $text, string $key = null ): string;
```

Encripta un texto.

```php
$encrypted = $crypt->encrypt(
    "Top secret",
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```

```php
public function encryptBase64( string $text, mixed $key = null, bool $safe = bool ): string;
```

Encripta un texto devolviendo el resultado como cadena en base64.

```php
public function getAuthData(): string
```

```php
public function getAuthTag(): string
```

```php
public function getAuthTagLength(): int
```

```php
public function getAvailableCiphers(): array;
```

Devuelve una lista de cifrados disponibles.

```php
public function getAvailableHashAlgos(): array;
```

Devuelve una lista de algoritmos *hash* registrados adecuados para hash_hmac.

```php
public function getCipher(): string;
```

Devuelve el cifrado actual

```php
public function getHashAlgo(): string;
```

Obtiene el nombre del algoritmo de *hash*.

```php
public function getKey(): string;
```

Devuelve la clave de encriptación

```php
public function setAuthData( string $data ): CryptInterface;
```

```php
public function setAuthTag( string $tag ): CryptInterface;
```

```php
public function setAuthTagLength( int $length ): CryptInterface;
```

```php
public function setCipher( string $cipher ): CryptInterface;
```

Establece el algoritmo de cifrado para el encriptado y desencriptado de los datos.

`aes-256-gcm' es el cifrado preferido, pero no se puede usar hasta que se actualice la librería openssl, que está disponible en PHP 7.1.

`aes-256-ctr' es posiblemente la mejor elección como algoritmo de cifrado para la versión actual de la librería openssl.

```php
public function setHashAlgo( string $hashAlgo ): CryptInterface;
```

Establece el nombre del algoritmo de *hash*.

@throws \Phalcon\Crypt\Exception

```php
public function setKey( string $key ): CryptInterface;
```

Establece la clave de encriptación.

`$key' se debe haber generado previamente de una forma criptográficamente segura.

Clave incorrecta: "le password"

Mejor (aunque todavía insegura): "#1dj8$=dp?.ak//j1V$~%*0X"

Clave buena: "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"

```php
public function setPadding( int $scheme ): CryptInterface;
```

Cambia el esquema de relleno usado.

```php
public function useSigning( bool $useSigning ): CryptInterface;
```

Establece si se debe usar el cálculo del resumen del mensaje.

```php
protected function assertCipherIsAvailable( string $cipher ): void;
```

Marca el cifrado como disponible.

```php
protected function assertHashAlgorithmAvailable( string $hashAlgo ): void;
```

Marca el algoritmo de *hash* como disponible.

```php
protected function cryptPadText( string $text, string $mode, int $blockSize, int $paddingType ): string;
```

Rellena los textos antes de la encriptación. Ver [cryptopad](http://www.di-mgt.com.au/cryptopad.html)

```php
protected function cryptUnpadText( string $text, string $mode, int $blockSize, int $paddingType );
```

Elimina un relleno de un texto.

Si la función detecta que el texto no tiene relleno, lo devolverá sin modificar.

```php
protected function getIvLength( string $cipher ): int;
```

Inicializa los algoritmos de cifrado disponibles.

```php
protected function initializeAvailableCiphers(): void;
```

Inicializa los algoritmos de cifrado disponibles.

<h1 id="crypt-cryptinterface">Interface Phalcon\Crypt\CryptInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Crypt/CryptInterface.zep)

| Namespace | Phalcon\Crypt |

Interfaz para Phalcon\Crypt

## Métodos

```php
public function decrypt( string $text, string $key = null ): string;
```

Desencripta un texto

```php
public function decryptBase64( string $text, mixed $key = null ): string;
```

Desencripta un texto que está codificado como cadena en base64

```php
public function encrypt( string $text, string $key = null ): string;
```

Encripta un texto

```php
public function encryptBase64( string $text, mixed $key = null ): string;
```

Encripta un texto devolviendo el resultado como cadena en base64

```php
public function getAuthData(): string;
```

Devuelve datos de autenticación

```php
public function getAuthTag(): string;
```

Devuelve la etiqueta de autenticación

```php
public function getAuthTagLength(): int;
```

Devuelve el tamaño de la etiqueta de autenticación

```php
public function getAvailableCiphers(): array;
```

Devuelve una lista de cifrados disponibles

```php
public function getCipher(): string;
```

Devuelve el cifrado actual

```php
public function getKey(): string;
```

Devuelve la clave de encriptación

```php
public function setAuthData( string $data ): CryptInterface;
```

Establece los datos de autenticación

```php
public function setAuthTag( string $tag ): CryptInterface;
```

Establece la etiqueta de autenticación

```php
public function setAuthTagLength( int $length ): CryptInterface;
```

Establece el tamaño de la etiqueta de autenticación

```php
public function setCipher( string $cipher ): CryptInterface;
```

Establece el algoritmo de cifrado

```php
public function setKey( string $key ): CryptInterface;
```

Establece la clave de encriptación

```php
public function setPadding( int $scheme ): CryptInterface;
```

Cambia el esquema de relleno usado.

<h1 id="crypt-exception">Class Phalcon\Crypt\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Crypt/Exception.zep)

| Namespace | Phalcon\Crypt | | Extends | \Phalcon\Exception |

Las excepciones lanzadas desde Phalcon\Crypt usarán esta clase

<h1 id="crypt-mismatch">Class Phalcon\Crypt\Mismatch</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Crypt/Mismatch.zep)

| Namespace | Phalcon\Crypt | | Extends | Exception |

Las excepciones lanzadas en Phalcon\Crypt usarán esta clase.
