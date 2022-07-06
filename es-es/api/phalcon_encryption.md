---
layout: default
language: 'es-es'
version: '5.0'
title: 'Phalcon\Encryption'
---

* [Phalcon\Encryption\Crypt](#encryption-crypt)
* [Phalcon\Encryption\Crypt\CryptInterface](#encryption-crypt-cryptinterface)
* [Phalcon\Encryption\Crypt\Exception\Exception](#encryption-crypt-exception-exception)
* [Phalcon\Encryption\Crypt\Exception\Mismatch](#encryption-crypt-exception-mismatch)
* [Phalcon\Encryption\Crypt\PadFactory](#encryption-crypt-padfactory)
* [Phalcon\Encryption\Crypt\Padding\Ansi](#encryption-crypt-padding-ansi)
* [Phalcon\Encryption\Crypt\Padding\Iso10126](#encryption-crypt-padding-iso10126)
* [Phalcon\Encryption\Crypt\Padding\IsoIek](#encryption-crypt-padding-isoiek)
* [Phalcon\Encryption\Crypt\Padding\Noop](#encryption-crypt-padding-noop)
* [Phalcon\Encryption\Crypt\Padding\PadInterface](#encryption-crypt-padding-padinterface)
* [Phalcon\Encryption\Crypt\Padding\Pkcs7](#encryption-crypt-padding-pkcs7)
* [Phalcon\Encryption\Crypt\Padding\Space](#encryption-crypt-padding-space)
* [Phalcon\Encryption\Crypt\Padding\Zero](#encryption-crypt-padding-zero)
* [Phalcon\Encryption\Security](#encryption-security)
* [Phalcon\Encryption\Security\Exception](#encryption-security-exception)
* [Phalcon\Encryption\Security\JWT\Builder](#encryption-security-jwt-builder)
* [Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException](#encryption-security-jwt-exceptions-unsupportedalgorithmexception)
* [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException](#encryption-security-jwt-exceptions-validatorexception)
* [Phalcon\Encryption\Security\JWT\Signer\AbstractSigner](#encryption-security-jwt-signer-abstractsigner)
* [Phalcon\Encryption\Security\JWT\Signer\Hmac](#encryption-security-jwt-signer-hmac)
* [Phalcon\Encryption\Security\JWT\Signer\None](#encryption-security-jwt-signer-none)
* [Phalcon\Encryption\Security\JWT\Signer\SignerInterface](#encryption-security-jwt-signer-signerinterface)
* [Phalcon\Encryption\Security\JWT\Token\AbstractItem](#encryption-security-jwt-token-abstractitem)
* [Phalcon\Encryption\Security\JWT\Token\Enum](#encryption-security-jwt-token-enum)
* [Phalcon\Encryption\Security\JWT\Token\Item](#encryption-security-jwt-token-item)
* [Phalcon\Encryption\Security\JWT\Token\Parser](#encryption-security-jwt-token-parser)
* [Phalcon\Encryption\Security\JWT\Token\Signature](#encryption-security-jwt-token-signature)
* [Phalcon\Encryption\Security\JWT\Token\Token](#encryption-security-jwt-token-token)
* [Phalcon\Encryption\Security\JWT\Validator](#encryption-security-jwt-validator)
* [Phalcon\Encryption\Security\Random](#encryption-security-random)

<h1 id="encryption-crypt">Class Phalcon\Encryption\Crypt</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt.zep)

| Namespace  | Phalcon\Encryption | | Uses       | Phalcon\Encryption\Crypt\CryptInterface, Phalcon\Encryption\Crypt\Exception\Exception, Phalcon\Encryption\Crypt\Exception\Mismatch, Phalcon\Encryption\Crypt\PadFactory | | Implements | CryptInterface |

Proporciona capacidades de encriptado a las aplicaciones Phalcon.

```php
use Phalcon\Crypt;

$crypt = new Crypt();

$crypt->setCipher("aes-256-ctr");

$key  =
"T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$input = "The message to be encrypted";

$encrypted = $crypt->encrypt($input, $key);

echo $crypt->decrypt($encrypted, $key);
```


## Constantes
```php
const DEFAULT_ALGORITHM = sha256;
const DEFAULT_CIPHER = aes-256-cfb;
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
protected authData = ;

/**
 * @var string
 */
protected authTag = ;

/**
 * @var int
 */
protected authTagLength = 16;

/**
 * Available cipher methods.
 *
 * @var array
 */
protected availableCiphers;

/**
 * @var string
 */
protected cipher;

/**
 * The name of hashing algorithm.
 *
 * @var string
 */
protected hashAlgorithm;

/**
 * The cipher iv length.
 *
 * @var int
 */
protected ivLength = 16;

/**
 * @var string
 */
protected key = ;

/**
 * @var int
 */
protected padding = 0;

/**
 * @var PadFactory
 */
protected padFactory;

/**
 * Whether calculating message digest enabled or not.
 *
 * @var bool
 */
protected useSigning = true;

```

## Métodos

```php
public function __construct( string $cipher = static-constant-access, bool $useSigning = bool, PadFactory $padFactory = null );
```
Crypt constructor.


```php
public function decrypt( string $input, string $key = null ): string;
```
Desencripta un texto encriptado.

```php
$encrypted = $crypt->decrypt(
    $encrypted,
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```


```php
public function decryptBase64( string $input, string $key = null, bool $safe = bool ): string;
```
Desencripta un texto que está codificado como cadena en base64.


```php
public function encrypt( string $input, string $key = null ): string;
```
Encripta un texto.

```php
$encrypted = $crypt->encrypt(
    "Top secret",
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```


```php
public function encryptBase64( string $input, string $key = null, bool $safe = bool ): string;
```
Encripta un texto devolviendo el resultado como cadena en base64.


```php
public function getAuthData(): string;
```
Returns the auth data


```php
public function getAuthTag(): string;
```
Returns the auth tag


```php
public function getAuthTagLength(): int;
```
Returns the auth tag length


```php
public function getAvailableCiphers(): array;
```
Devuelve una lista de cifrados disponibles.


```php
public function getAvailableHashAlgorithms(): array;
```
Devuelve una lista de algoritmos *hash* registrados adecuados para hash_hmac.


```php
public function getCipher(): string;
```
Devuelve el cifrado actual


```php
public function getHashAlgorithm(): string;
```
Obtiene el nombre del algoritmo de *hash*.


```php
public function getKey(): string;
```
Devuelve la clave de encriptación


```php
public function isValidDecryptLength( string $input ): bool;
```
Returns if the input length for decryption is valid or not (number of bytes required by the cipher).


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


```php
public function setHashAlgorithm( string $hashAlgorithm ): CryptInterface;
```
Establece el nombre del algoritmo de *hash*.


```php
public function setKey( string $key ): CryptInterface;
```
Establece la clave de encriptación.

The `$key` should have been previously generated in a cryptographically safe way.

Clave incorrecta: "le password"

Better (but still unsafe) -> "#1dj8$=dp?.ak//j1V$~%*0X"

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
protected function checkCipherHashIsAvailable( string $cipher, string $type ): void;
```
Checks if a cipher or a hash algorithm is available


```php
protected function cryptPadText( string $input, string $mode, int $blockSize, int $paddingType ): string;
```
Rellena los textos antes de la encriptación. See [cryptopad](https://www.di-mgt.com.au/cryptopad.html)


```php
protected function cryptUnpadText( string $input, string $mode, int $blockSize, int $paddingType ): string;
```
Elimina un relleno de un texto.

Si la función detecta que el texto no tiene relleno, lo devolverá sin modificar.


```php
protected function decryptGcmCcmAuth( string $mode, string $cipherText, string $decryptKey, string $iv ): string;
```

```php
protected function decryptGetUnpadded( string $mode, int $blockSize, string $decrypted ): string;
```

```php
protected function encryptGcmCcm( string $mode, string $padded, string $encryptKey, string $iv ): string;
```

```php
protected function encryptGetPadded( string $mode, string $input, int $blockSize ): string;
```

```php
protected function initializeAvailableCiphers(): Crypt;
```
Inicializa los algoritmos de cifrado disponibles.


```php
protected function phpFunctionExists( string $name ): bool;
```
@todo to be removed when we get traits


```php
protected function phpOpensslCipherIvLength( string $cipher ): int | bool;
```

```php
protected function phpOpensslRandomPseudoBytes( int $length );
```





<h1 id="encryption-crypt-cryptinterface">Interface Phalcon\Encryption\Crypt\CryptInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/CryptInterface.zep)

| Namespace  | Phalcon\Encryption\Crypt |

Interfaz para Phalcon\Crypt


## Métodos

```php
public function decrypt( string $input, string $key = null ): string;
```
Desencripta un texto


```php
public function decryptBase64( string $input, string $key = null ): string;
```
Desencripta un texto que está codificado como cadena en base64


```php
public function encrypt( string $input, string $key = null ): string;
```
Encripta un texto


```php
public function encryptBase64( string $input, string $key = null ): string;
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


```php
public function useSigning( bool $useSigning ): CryptInterface;
```
Sets if the calculating message digest must be used.




<h1 id="encryption-crypt-exception-exception">Class Phalcon\Encryption\Crypt\Exception\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Exception/Exception.zep)

| Namespace  | Phalcon\Encryption\Crypt\Exception | | Extends    | \Exception |

Las excepciones lanzadas desde Phalcon\Crypt usarán esta clase



<h1 id="encryption-crypt-exception-mismatch">Class Phalcon\Encryption\Crypt\Exception\Mismatch</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Exception/Mismatch.zep)

| Namespace  | Phalcon\Encryption\Crypt\Exception | | Extends    | Exception |

Las excepciones lanzadas en Phalcon\Crypt usarán esta clase.



<h1 id="encryption-crypt-padfactory">Class Phalcon\Encryption\Crypt\PadFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/PadFactory.zep)

| Namespace  | Phalcon\Encryption\Crypt | | Uses       | Phalcon\Encryption\Crypt, Phalcon\Encryption\Crypt\Padding\PadInterface, Phalcon\Factory\AbstractFactory, Phalcon\Support\Helper\Arr\Get | | Extends    | AbstractFactory |

Class PadFactory

@package Phalcon\Crypt


## Propiedades
```php
/**
 * @var string
 */
protected exception = Phalcon\\Encryption\\Crypt\\Exception\\Exception;

```

## Métodos

```php
public function __construct( array $services = [] );
```
Constructor AdapterFactory.


```php
public function newInstance( string $name ): PadInterface;
```
Crea una nueva instancia del adaptador


```php
public function padNumberToService( int $number ): string;
```
Gets a Crypt pad constant and returns the unique service name for the padding class


```php
protected function getServices(): array;
```





<h1 id="encryption-crypt-padding-ansi">Class Phalcon\Encryption\Crypt\Padding\Ansi</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Ansi.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Ansi

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-iso10126">Class Phalcon\Encryption\Crypt\Padding\Iso10126</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Iso10126.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Iso10126

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-isoiek">Class Phalcon\Encryption\Crypt\Padding\IsoIek</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/IsoIek.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class IsoIek

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-noop">Class Phalcon\Encryption\Crypt\Padding\Noop</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Noop.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Noop

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-padinterface">Interface Phalcon\Encryption\Crypt\Padding\PadInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/PadInterface.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding |

Interface for Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-pkcs7">Class Phalcon\Encryption\Crypt\Padding\Pkcs7</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Pkcs7.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Pkcs7

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-space">Class Phalcon\Encryption\Crypt\Padding\Space</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Space.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Space

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-zero">Class Phalcon\Encryption\Crypt\Padding\Zero</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Zero.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Zero

@package Phalcon\Encryption\Crypt\Padding


## Métodos

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-security">Class Phalcon\Encryption\Security</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security.zep)

| Namespace  | Phalcon\Encryption | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\RequestInterface, Phalcon\Encryption\Security\Random, Phalcon\Encryption\Security\Exception, Phalcon\Session\ManagerInterface | | Extends    | AbstractInjectionAware |

Este componente provee un conjunto de funciones para mejorar la seguridad en aplicaciones Phalcon

```php
$login    = $this->request->getPost("login");
$password = $this->request->getPost("password");

$user = Users::findFirstByLogin($login);

if ($user) {
    if ($this->security->checkHash($password, $user->password)) {
        // The password is valid
    }
}
```


## Constantes
```php
const CRYPT_ARGON2I = 10;
const CRYPT_ARGON2ID = 11;
const CRYPT_BCRYPT = 0;
const CRYPT_BLOWFISH = 4;
const CRYPT_BLOWFISH_A = 5;
const CRYPT_BLOWFISH_X = 6;
const CRYPT_BLOWFISH_Y = 7;
const CRYPT_DEFAULT = 0;
const CRYPT_EXT_DES = 2;
const CRYPT_MD5 = 3;
const CRYPT_SHA256 = 8;
const CRYPT_SHA512 = 9;
const CRYPT_STD_DES = 1;
```

## Propiedades
```php
/**
 * @var int
 */
protected defaultHash;

/**
 * @var int
 */
protected numberBytes = 16;

/**
 * @var Random
 */
protected random;

/**
 * @var string|null
 */
protected requestToken;

/**
 * @var string|null
 */
protected token;

/**
 * @var string|null
 */
protected tokenKey;

/**
 * @var string
 */
protected tokenKeySessionId = $PHALCON/CSRF/KEY$;

/**
 * @var string
 */
protected tokenValueSessionId = $PHALCON/CSRF$;

/**
 * @var int
 */
protected workFactor = 10;

/**
 * @var SessionInterface|null
 */
private localSession;

/**
 * @var RequestInterface|null
 */
private localRequest;

```

## Métodos

```php
public function __construct( SessionInterface $session = null, RequestInterface $request = null );
```
Security constructor.


```php
public function checkHash( string $password, string $passwordHash, int $maxPassLength = int ): bool;
```
Comprueba si una contraseña de texto plano y su versión hash coinciden


```php
public function checkToken( string $tokenKey = null, mixed $tokenValue = null, bool $destroyIfValid = bool ): bool;
```
Comprueba si el token CSRF enviado en la consulta es el mismo que el almacenado en la sesión actual


```php
public function computeHmac( string $data, string $key, string $algo, bool $raw = bool ): string;
```
Calcula un HMAC


```php
public function destroyToken(): Security;
```
Elimina el valor y clave del token CSRF de la sesión


```php
public function getDefaultHash(): int;
```
Devuelve el hash predeterminado


```php
public function getHashInformation( string $hash ): array;
```
Returns information regarding a hash


```php
public function getRandom(): Random;
```
Devuelve una instancia del generador seguro de números aleatorio


```php
public function getRandomBytes(): int;
```
Devuelve un número de bytes a ser generados por el generador pseudoaleatorio de openssl


```php
public function getRequestToken(): string | null;
```
Devuelve el valor del token CSRF para la petición actual.


```php
public function getSaltBytes( int $numberBytes = int ): string;
```
Generate a >22-length pseudo random string to be used as salt for passwords


```php
public function getSessionToken(): string | null;
```
Devuelve el valor del token CSRF en sesión


```php
public function getToken(): string | null;
```
Genera un token pseudo aleatorio para ser usado como valor en inputs en el chequeo de CSRF


```php
public function getTokenKey(): string | null;
```
Genera un token pseudo aleatorio para ser usando como nombre en inputs en el chequeo de CSRF


```php
public function getWorkFactor(): int
```

```php
public function hash( string $password, array $options = [] ): string;
```
Crea un hash de contraseña utilizando bcrypt con una sal pseudo aleatoria


```php
public function isLegacyHash( string $passwordHash ): bool;
```
Comprueba si una contraseña hash es un hash bcrypt válido


```php
public function setDefaultHash( int $defaultHash ): Security;
```
Establece el hash por defecto


```php
public function setRandomBytes( int $randomBytes ): Security;
```
Establece un número de bytes a ser generados por el generador pseudo aleatorio de openssl


```php
public function setWorkFactor( int $workFactor ): Security;
```
Establece el factor de trabajo


```php
protected function getLocalService( string $name, string $property );
```





<h1 id="encryption-security-exception">Class Phalcon\Encryption\Security\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/Exception.zep)

| Namespace  | Phalcon\Encryption\Security | | Extends    | \Exception |

Phalcon\Encryption\Security\Exception

Las excepciones lanzadas en Phalcon\Security usarán esta clase



<h1 id="encryption-security-jwt-builder">Class Phalcon\Encryption\Security\JWT\Builder</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Builder.zep)

| Namespace  | Phalcon\Encryption\Security\JWT | | Uses       | InvalidArgumentException, Phalcon\Support\Collection, Phalcon\Support\Collection\CollectionInterface, Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException, Phalcon\Encryption\Security\JWT\Signer\SignerInterface, Phalcon\Encryption\Security\JWT\Token\Enum, Phalcon\Encryption\Security\JWT\Token\Item, Phalcon\Encryption\Security\JWT\Token\Signature, Phalcon\Encryption\Security\JWT\Token\Token |

Class Builder

@property CollectionInterface  $claims @property CollectionInterface  $jose @property string               $passphrase @property SignerInterface      $signer

@link https://tools.ietf.org/html/rfc7519


## Propiedades
```php
/**
 * @var CollectionInterface
 */
private claims;

/**
 * @var CollectionInterface
 */
private jose;

/**
 * @var string
 */
private passphrase;

/**
 * @var SignerInterface
 */
private signer;

```

## Métodos

```php
public function __construct( SignerInterface $signer );
```
Constructor.


```php
public function addClaim( string $name, mixed $value ): Builder;
```
Adds a custom claim


```php
public function getAudience();
```

```php
public function getClaims(): array;
```

```php
public function getContentType(): string | null;
```

```php
public function getExpirationTime(): int | null;
```

```php
public function getHeaders(): array;
```

```php
public function getId(): string | null;
```

```php
public function getIssuedAt(): int | null;
```

```php
public function getIssuer(): string | null;
```

```php
public function getNotBefore(): int | null;
```

```php
public function getPassphrase(): string;
```

```php
public function getSubject(): string | null;
```

```php
public function getToken(): Token;
```

```php
public function init(): Builder;
```

```php
public function setAudience( mixed $audience ): Builder;
```
El reclamo "aud" (audiencia) identifica a los destinatarios para los que el JWT está destinado.  Cada uno de los principales destinados a procesar el JWT DEBE se identifica con un valor en el reclamo de audiencia.  Si el procesamiento principal del reclamo no se identifica con un valor en el reclamo "aud" cuando esta reclamación está presente, entonces el JWT DEBE ser rechazado.  En el caso general, el valor "aud" es un vector de cadenas sensibles a mayúsculas y minúsculas, cada una contiene un valor StringOrURI.  En el caso especial cuando el JWT tiene una audiencia, el valor "aud" PUEDE ser una cadena única sensible a mayúsculas y minúsculas que contiene un valor StringOrURI.  La interpretación de los valores de la audiencia es generalmente específica de la aplicación. El uso de este reclamo es OPCIONAL.


```php
public function setContentType( string $contentType ): Builder;
```
Establece el encabezado de tipo de contenido 'cty'


```php
public function setExpirationTime( int $timestamp ): Builder;
```
El reclamo "exp" (tiempo de caducidad) identifica el tiempo de expiración durante o después del cual el JWT NO DEBE ser aceptado para su procesamiento.  El procesamiento del reclamo "exp" requiere que la fecha/hora actual DEBE ser anterior a la fecha/hora de vencimiento listada en el reclamo "exp". Los implementadores PUEDEN proporcionar un pequeño margen de maniobra, por lo general no mayor de de unos pocos minutos, para tener en cuenta la desviación del reloj.  Su valor DEBE ser un número que contenga un valor NumericDate.  El uso de este reclamo es OPCIONAL.


```php
public function setId( string $id ): Builder;
```
El reclamo "jti" (JWT ID) proporciona un identificador único para el JWT. El valor del identificador DEBE ser asignado de una manera que asegure que hay una probabilidad despreciable de que el mismo valor será asignado accidentalmente a un objeto de datos diferente; si la aplicación utiliza múltiples emisores, las colisiones DEBEN ser prevenidas entre los valores producidos por diferentes emisores también.  El reclamo "jti" se puede usar para prevenir que el JWT se vuelva a reproducir.  El valor "jti" es una cadena sensible a mayúsculas y minúsculas.  El uso de este reclamo es OPCIONAL.


```php
public function setIssuedAt( int $timestamp ): Builder;
```
El reclamo "iat" (emitida en) identifica el tiempo en el que el JWT fue emitido.  Este reclamo se puede utilizar para determinar la edad del JWT.  Su valor DEBE ser un número que contenga un valor NumericDate.  El uso de este reclamo es OPCIONAL.


```php
public function setIssuer( string $issuer ): Builder;
```
El reclamo "iss" (emisor) identifica al principal que emite el JWT.  La tramitación de este reclamo es generalmente específica para la aplicación. El valor "iss" es una cadena sensible a mayúsculas y minúsculas que contiene un valor StringOrURI.  El uso de este reclamo es OPCIONAL.


```php
public function setNotBefore( int $timestamp ): Builder;
```
El reclamo "nbf" (no antes) identifica el tiempo anterior al cual el JWT NO DEBE ser aceptado para su procesamiento.  El procesamiento del reclamo "nbf" requiere que la fecha/hora actual DEBE ser posterior o igual a la fecha/hora no anterior listada en el reclamo "nbf".  Los implementadores PUEDEN proporcionar un pequeño margen de maniobra, por lo general no mayor de de unos pocos minutos, para tener en cuenta la desviación del reloj.  Su valor DEBE ser un número que contenga un valor NumericDate.  El uso de este reclamo es OPCIONAL.


```php
public function setPassphrase( string $passphrase ): Builder;
```

```php
public function setSubject( string $subject ): Builder;
```
El reclamo "sub" (asunto) identifica el principal que es el sujeto del JWT.  Los reclamos en un JWT son normalmente sentencias sobre el asunto.  El valor del asunto DEBE ser localmente único en el contexto del emisor o ser único globalmente. La tramitación de este reclamo es generalmente específica para la aplicación.  El valor "sub" es una cadena sensible a mayúsculas y minúsculas que contiene un valor StringOrURI.  El uso de este reclamo es OPCIONAL.


```php
protected function setClaim( string $name, mixed $value ): Builder;
```
Sets a registered claim




<h1 id="encryption-security-jwt-exceptions-unsupportedalgorithmexception">Class Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Exceptions/UnsupportedAlgorithmException.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Exceptions | | Uses       | Exception, Throwable | | Extends    | Exception | | Implements | Throwable |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.



<h1 id="encryption-security-jwt-exceptions-validatorexception">Class Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Exceptions/ValidatorException.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Exceptions | | Uses       | Exception, Throwable | | Extends    | Exception | | Implements | Throwable |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.



<h1 id="encryption-security-jwt-signer-abstractsigner">Abstract Class Phalcon\Encryption\Security\JWT\Signer\AbstractSigner</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/AbstractSigner.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer | | Implements | SignerInterface |

Class AbstractSigner

@property string $algo


## Propiedades
```php
/**
 * @var string
 */
protected algorithm;

```

## Métodos

```php
public function getAlgorithm(): string
```





<h1 id="encryption-security-jwt-signer-hmac">Class Phalcon\Encryption\Security\JWT\Signer\Hmac</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/Hmac.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer | | Uses       | Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException | | Extends    | AbstractSigner |

Class Hmac


## Métodos

```php
public function __construct( string $algo = string );
```
Constructor Hmac.


```php
public function getAlgHeader(): string;
```
Devuelve el valor que se utiliza para la cabecera "alg"


```php
public function sign( string $payload, string $passphrase ): string;
```
Firma una carga útil usando la contraseña


```php
public function verify( string $source, string $payload, string $passphrase ): bool;
```
Verificar una fuente pasada con una carga útil y una contraseña




<h1 id="encryption-security-jwt-signer-none">Class Phalcon\Encryption\Security\JWT\Signer\None</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/None.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer | | Implements | SignerInterface |

Class None


## Métodos

```php
public function getAlgHeader(): string;
```
Devuelve el valor que se utiliza para la cabecera "alg"


```php
public function getAlgorithm(): string;
```
Devuelve el algoritmo usado


```php
public function sign( string $payload, string $passphrase ): string;
```
Firma una carga útil usando la contraseña


```php
public function verify( string $source, string $payload, string $passphrase ): bool;
```
Verificar una fuente pasada con una carga útil y una contraseña




<h1 id="encryption-security-jwt-signer-signerinterface">Interface Phalcon\Encryption\Security\JWT\Signer\SignerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/SignerInterface.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
public function getAlgHeader(): string;
```
Devuelve el valor que se utiliza para la cabecera "alg"


```php
public function getAlgorithm(): string;
```
Devuelve el algoritmo usado


```php
public function sign( string $payload, string $passphrase ): string;
```
Firma una carga útil usando la contraseña


```php
public function verify( string $source, string $payload, string $passphrase ): bool;
```
Verificar una fuente pasada con una carga útil y una contraseña




<h1 id="encryption-security-jwt-token-abstractitem">Abstract Class Phalcon\Encryption\Security\JWT\Token\AbstractItem</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/AbstractItem.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token |

Class AbstractItem

@property array $data


## Propiedades
```php
/**
 * @var array
 */
protected data;

```

## Métodos

```php
public function getEncoded(): string;
```





<h1 id="encryption-security-jwt-token-enum">Class Phalcon\Encryption\Security\JWT\Token\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Enum.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token |

Class Enum

@link https://tools.ietf.org/html/rfc7519


## Constantes
```php
const ALGO = alg;
const AUDIENCE = aud;
const CONTENT_TYPE = cty;
const EXPIRATION_TIME = exp;
const ID = jti;
const ISSUED_AT = iat;
const ISSUER = iss;
const NOT_BEFORE = nbf;
const SUBJECT = sub;
const TYPE = typ;
```


<h1 id="encryption-security-jwt-token-item">Class Phalcon\Encryption\Security\JWT\Token\Item</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Item.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token | | Extends    | AbstractItem |

Class Item


## Métodos

```php
public function __construct( array $payload, string $encoded );
```
Constructor Item.


```php
public function get( string $name, mixed $defaultValue = null ): mixed | null;
```

```php
public function getPayload(): array;
```

```php
public function has( string $name ): bool;
```





<h1 id="encryption-security-jwt-token-parser">Class Phalcon\Encryption\Security\JWT\Token\Parser</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Parser.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token | | Uses       | InvalidArgumentException |

Class Parser


## Métodos

```php
public function parse( string $token ): Token;
```
Analiza un token y lo devuelve




<h1 id="encryption-security-jwt-token-signature">Class Phalcon\Encryption\Security\JWT\Token\Signature</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Signature.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token | | Extends    | AbstractItem |

Class Item


## Métodos

```php
public function __construct( string $hash = string, string $encoded = string );
```
Constructor Signature.


```php
public function getHash(): string;
```





<h1 id="encryption-security-jwt-token-token">Class Phalcon\Encryption\Security\JWT\Token\Token</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Token.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token |

Class Token

@property Item      $claims @property Item      $headers @property Signature $signature

@link https://tools.ietf.org/html/rfc7519


## Propiedades
```php
/**
 * @var Item
 */
private claims;

/**
 * @var Item
 */
private headers;

/**
 * @var Signature
 */
private signature;

```

## Métodos

```php
public function __construct( Item $headers, Item $claims, Signature $signature );
```
Constructor Token.


```php
public function getClaims(): Item
```

```php
public function getHeaders(): Item
```

```php
public function getPayload(): string;
```

```php
public function getSignature(): Signature
```

```php
public function getToken(): string;
```





<h1 id="encryption-security-jwt-validator">Class Phalcon\Encryption\Security\JWT\Validator</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Validator.zep)

| Namespace  | Phalcon\Encryption\Security\JWT | | Uses       | Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException, Phalcon\Encryption\Security\JWT\Signer\SignerInterface, Phalcon\Encryption\Security\JWT\Token\Enum, Phalcon\Encryption\Security\JWT\Token\Token |

Class Validator

@property int   $timeShift @property Token $token


## Propiedades
```php
/**
 * @var int
 */
private timeShift = 0;

/**
 * @var Token
 */
private token;

```

## Métodos

```php
public function __construct( Token $token, int $timeShift = int );
```
Constructor Validator.


```php
public function setToken( Token $token ): Validator;
```

```php
public function validateAudience( string $audience ): Validator;
```

```php
public function validateExpiration( int $timestamp ): Validator;
```

```php
public function validateId( string $id ): Validator;
```

```php
public function validateIssuedAt( int $timestamp ): Validator;
```

```php
public function validateIssuer( string $issuer ): Validator;
```

```php
public function validateNotBefore( int $timestamp ): Validator;
```

```php
public function validateSignature( SignerInterface $signer, string $passphrase ): Validator;
```





<h1 id="encryption-security-random">Class Phalcon\Encryption\Security\Random</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/Random.zep)

| Namespace  | Phalcon\Encryption\Security |

Phalcon\Encryption\Security\Random

Clase generadora segura de números aleatorios.

Proporciona un generador seguro de números aleatorios que es adecuado para generar clave de sesión en cookies HTTP, etc.

`Phalcon\Encryption\Security\Random` could be mainly useful for:

- Generación de claves (por ejemplo, generación de claves complicadas)
- Generando contraseñas aleatorias para nuevas cuentas de usuario
- Sistemas de cifrado

```php
$random = new \Phalcon\Encryption\Security\Random();

// Random binary string
$bytes = $random->bytes();

// Random hex string
echo $random->hex(10); // a29f470508d5ccb8e289
echo $random->hex(10); // 533c2f08d5eee750e64a
echo $random->hex(11); // f362ef96cb9ffef150c9cd
echo $random->hex(12); // 95469d667475125208be45c4
echo $random->hex(13); // 05475e8af4a34f8f743ab48761

// Random base62 string
echo $random->base62(); // z0RkwHfh8ErDM1xw

// Random base64 string
echo $random->base64(12); // XfIN81jGGuKkcE1E
echo $random->base64(12); // 3rcq39QzGK9fUqh8
echo $random->base64();   // DRcfbngL/iOo9hGGvy1TcQ==
echo $random->base64(16); // SvdhPcIHDZFad838Bb0Swg==

// Random URL-safe base64 string
echo $random->base64Safe();           // PcV6jGbJ6vfVw7hfKIFDGA
echo $random->base64Safe();           // GD8JojhzSTrqX7Q8J6uug
echo $random->base64Safe(8);          // mGyy0evy3ok
echo $random->base64Safe(null, true); // DRrAgOFkS4rvRiVHFefcQ==

// Random UUID
echo $random->uuid(); // db082997-2572-4e2c-a046-5eefe97b1235
echo $random->uuid(); // da2aa0e2-b4d0-4e3c-99f5-f5ef62c57fe2
echo $random->uuid(); // 75e6b628-c562-4117-bb76-61c4153455a9
echo $random->uuid(); // dc446df1-0848-4d05-b501-4af3c220c13d

// Random number between 0 and $len
echo $random->number(256); // 84
echo $random->number(256); // 79
echo $random->number(100); // 29
echo $random->number(300); // 40

// Random base58 string
echo $random->base58();   // 4kUgL2pdQMSCQtjE
echo $random->base58();   // Umjxqf7ZPwh765yR
echo $random->base58(24); // qoXcgmw4A9dys26HaNEdCRj9
echo $random->base58(7);  // 774SJD3vgP
```

Esta clase toma prestada parcialmente la librería SecureRandom de Ruby

@link http://ruby-doc.org/stdlib-2.2.2/libdoc/securerandom/rdoc/SecureRandom.html


## Métodos

```php
public function base58( int $len = null ): string;
```
Genera una cadena base58 aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. El resultado puede contener caracteres alfanuméricos excepto 0, O, I y l.

It is similar to `Phalcon\Encryption\Security\Random::base64()` but has been modified to avoid both non-alphanumeric characters and letters which might look ambiguous when printed.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE
```

@see    \Phalcon\Encryption\Security\Random:base64 @link   https://en.wikipedia.org/wiki/Base58 @throws Exception If secure random number generator is not available or unexpected partial read


```php
public function base62( int $len = null ): string;
```
Genera una cadena base62 aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro.

It is similar to `Phalcon\Encryption\Security\Random::base58()` but has been modified to provide the largest value that can safely be used in URLs without needing to take extra characters into consideration because it is [A-Za-z0-9].

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw
```

@see    \Phalcon\Encryption\Security\Random:base58 @throws Exception If secure random number generator is not available or unexpected partial read


```php
public function base64( int $len = null ): string;
```
Genera una cadena base64 aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len. Fórmula del tamaño: 4 * ($len / 3) y redondeado a un múltiplo de 4.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8
```

@throws Exception If secure random number generator is not available or unexpected partial read


```php
public function base64Safe( int $len = null, bool $padding = bool ): string;
```
Genera una cadena base64 de URL segura aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len.

Por defecto, el relleno no se genera porque "=" se puede usar como un delimitador de URL. El resultado puede contener A-Z, a-z, 0-9, "-" y "_". "=" también se usa si $padding es verdadero. Consulte RFC 3548 para la definición de base64 segura para URL.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug
```

@link https://www.ietf.org/rfc/rfc3548.txt @throws Exception If secure random number generator is not available or unexpected partial read


```php
public function bytes( int $len = int ): string;
```
Genera una cadena binaria aleatoria

El método `Random::bytes` devuelve una cadena y acepta como entrada un entero representando la longitud en bytes a devolver.

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. El resultado puede contener cualquier byte: "x00" - "xFF".

```php
$random = new \Phalcon\Encryption\Security\Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"
```

@throws Exception If secure random number generator is not available or unexpected partial read


```php
public function hex( int $len = null ): string;
```
Genera una cadena hexadecimal aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->hex(10); // a29f470508d5ccb8e289
```

@throws Exception If secure random number generator is not available or unexpected partial read


```php
public function number( int $len ): int;
```
Genera un número aleatorio entre 0 y $len

Returns an integer: 0 <= result <= $len.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->number(16); // 8
```
@throws Exception If secure random number generator is not available, unexpected partial read or $len <= 0


```php
public function uuid(): string;
```
Genera un UUID aleatorio v4 (IDentificador Único Universal)

La versión 4 de UUID es puramente aleatoria (excepto la versión). No contiene información significativa como dirección MAC, hora, etc. Ver RFC 4122 para detalles del UUID.

Este algoritmo establece el número de versión (4 bits) así como dos bits reservados. Todos los demás bits (los 122 bits restantes) se establecen usando una fuente de datos aleatoria o pseudoaleatoria. Los UUID de versión 4 tienen la forma xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx donde x es cualquier dígito hexadecimal e y es uno de 8, 9, A o B (p. ej., f47ac10b-58cc-4372-a567-0e02b2c3d479).

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22
```

@link https://www.ietf.org/rfc/rfc4122.txt @throws Exception If secure random number generator is not available or unexpected partial read


```php
protected function base( string $alphabet, int $base, mixed $n = null ): string;
```
Genera una cadena aleatoria basada en el número ($base) de caracteres ($alphabet).

Si $n no se especifica, se asume 16. Puede ser más grande en el futuro.

@throws Exception If secure random number generator is not available or unexpected partial read


