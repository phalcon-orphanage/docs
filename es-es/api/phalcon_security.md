---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Security'
---

- [Phalcon\Security](#security)
- [Phalcon\Security\Exception](#security-exception)
- [Phalcon\Security\JWT\Builder](#security-jwt-builder)
- [Phalcon\Security\JWT\Exceptions\UnsupportedAlgorithmException](#security-jwt-exceptions-unsupportedalgorithmexception)
- [Phalcon\Security\JWT\Exceptions\ValidatorException](#security-jwt-exceptions-validatorexception)
- [Phalcon\Security\JWT\Signer\AbstractSigner](#security-jwt-signer-abstractsigner)
- [Phalcon\Security\JWT\Signer\Hmac](#security-jwt-signer-hmac)
- [Phalcon\Security\JWT\Signer\None](#security-jwt-signer-none)
- [Phalcon\Security\JWT\Signer\SignerInterface](#security-jwt-signer-signerinterface)
- [Phalcon\Security\JWT\Token\AbstractItem](#security-jwt-token-abstractitem)
- [Phalcon\Security\JWT\Token\Enum](#security-jwt-token-enum)
- [Phalcon\Security\JWT\Token\Item](#security-jwt-token-item)
- [Phalcon\Security\JWT\Token\Parser](#security-jwt-token-parser)
- [Phalcon\Security\JWT\Token\Signature](#security-jwt-token-signature)
- [Phalcon\Security\JWT\Token\Token](#security-jwt-token-token)
- [Phalcon\Security\JWT\Validator](#security-jwt-validator)
- [Phalcon\Security\Random](#security-random)

<h1 id="security">Class Phalcon\Security</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\RequestInterface, Phalcon\Security\Random, Phalcon\Security\Exception, Phalcon\Session\ManagerInterface | | Extends | AbstractInjectionAware |

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
 * @var int|null
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
 * @var string}null
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

Constructor Phalcon\Security

```php
public function checkHash( string $password, string $passwordHash, int $maxPassLength = int ): bool;
```

Comprueba si una contraseña de texto plano y su versión hash coinciden

```php
public function checkToken( mixed $tokenKey = null, mixed $tokenValue = null, bool $destroyIfValid = bool ): bool;
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
public function getDefaultHash(): int | null;
```

Devuelve el hash predeterminado

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

Generar una cadena pseudo aleatoria de longitud superior a 22 para ser utilizado como sal para contraseñas

```php
public function getSessionToken(): string | null;
```

Devuelve el valor del token CSRF en sesión

```php
public function getToken(): string;
```

Genera un token pseudo aleatorio para ser usado como valor en inputs en el chequeo de CSRF

```php
public function getTokenKey(): string;
```

Genera un token pseudo aleatorio para ser usando como nombre en inputs en el chequeo de CSRF

```php
public function getWorkFactor(): int
```

```php
public function hash( string $password, int $workFactor = int ): string;
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

<h1 id="security-exception">Class Phalcon\Security\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/Exception.zep)

| Namespace | Phalcon\Security | | Extends | \Phalcon\Exception |

Phalcon\Security\Exception

Las excepciones lanzadas en Phalcon\Security usarán esta clase

<h1 id="security-jwt-builder">Class Phalcon\Security\JWT\Builder</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Builder.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT | | Uses | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Phalcon\Helper\Base64, Phalcon\Helper\Json, Phalcon\Security\JWT\Exceptions\ValidatorException, Phalcon\Security\JWT\Signer\SignerInterface, Phalcon\Security\JWT\Token\Enum, Phalcon\Security\JWT\Token\Item, Phalcon\Security\JWT\Token\Signature, Phalcon\Security\JWT\Token\Token |

Class Builder

@property CollectionInterface $claims @property CollectionInterface $jose @property string $passphrase @property SignerInterface $signer

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

El reclamo "aud" (audiencia) identifica a los destinatarios para los que el JWT está destinado. Cada uno de los principales destinados a procesar el JWT DEBE se identifica con un valor en el reclamo de audiencia. Si el procesamiento principal del reclamo no se identifica con un valor en el reclamo "aud" cuando esta reclamación está presente, entonces el JWT DEBE ser rechazado. En el caso general, el valor "aud" es un vector de cadenas sensibles a mayúsculas y minúsculas, cada una contiene un valor StringOrURI. En el caso especial cuando el JWT tiene una audiencia, el valor "aud" PUEDE ser una cadena única sensible a mayúsculas y minúsculas que contiene un valor StringOrURI. La interpretación de los valores de la audiencia es generalmente específica de la aplicación. El uso de este reclamo es OPCIONAL.

```php
public function setContentType( string $contentType ): Builder;
```

Establece el encabezado de tipo de contenido 'cty'

```php
public function setExpirationTime( int $timestamp ): Builder;
```

El reclamo "exp" (tiempo de caducidad) identifica el tiempo de expiración durante o después del cual el JWT NO DEBE ser aceptado para su procesamiento. El procesamiento del reclamo "exp" requiere que la fecha/hora actual DEBE ser anterior a la fecha/hora de vencimiento listada en el reclamo "exp". Los implementadores PUEDEN proporcionar un pequeño margen de maniobra, por lo general no mayor de de unos pocos minutos, para tener en cuenta la desviación del reloj. Su valor DEBE ser un número que contenga un valor NumericDate. El uso de este reclamo es OPCIONAL.

```php
public function setId( string $id ): Builder;
```

El reclamo "jti" (JWT ID) proporciona un identificador único para el JWT. El valor del identificador DEBE ser asignado de una manera que asegure que hay una probabilidad despreciable de que el mismo valor será asignado accidentalmente a un objeto de datos diferente; si la aplicación utiliza múltiples emisores, las colisiones DEBEN ser prevenidas entre los valores producidos por diferentes emisores también. El reclamo "jti" se puede usar para prevenir que el JWT se vuelva a reproducir. El valor "jti" es una cadena sensible a mayúsculas y minúsculas. El uso de este reclamo es OPCIONAL.

```php
public function setIssuedAt( int $timestamp ): Builder;
```

El reclamo "iat" (emitida en) identifica el tiempo en el que el JWT fue emitido. Este reclamo se puede utilizar para determinar la edad del JWT. Su valor DEBE ser un número que contenga un valor NumericDate. El uso de este reclamo es OPCIONAL.

```php
public function setIssuer( string $issuer ): Builder;
```

El reclamo "iss" (emisor) identifica al principal que emite el JWT. La tramitación de este reclamo es generalmente específica para la aplicación. El valor "iss" es una cadena sensible a mayúsculas y minúsculas que contiene un valor StringOrURI. El uso de este reclamo es OPCIONAL.

```php
public function setNotBefore( int $timestamp ): Builder;
```

El reclamo "nbf" (no antes) identifica el tiempo anterior al cual el JWT NO DEBE ser aceptado para su procesamiento. El procesamiento del reclamo "nbf" requiere que la fecha/hora actual DEBE ser posterior o igual a la fecha/hora no anterior listada en el reclamo "nbf". Los implementadores PUEDEN proporcionar un pequeño margen de maniobra, por lo general no mayor de de unos pocos minutos, para tener en cuenta la desviación del reloj. Su valor DEBE ser un número que contenga un valor NumericDate. El uso de este reclamo es OPCIONAL.

```php
public function setPassphrase( string $passphrase ): Builder;
```

```php
public function setSubject( string $subject ): Builder;
```

El reclamo "sub" (asunto) identifica el principal que es el sujeto del JWT. Los reclamos en un JWT son normalmente sentencias sobre el asunto. El valor del asunto DEBE ser localmente único en el contexto del emisor o ser único globalmente. La tramitación de este reclamo es generalmente específica para la aplicación. El valor "sub" es una cadena sensible a mayúsculas y minúsculas que contiene un valor StringOrURI. El uso de este reclamo es OPCIONAL.

<h1 id="security-jwt-exceptions-unsupportedalgorithmexception">Class Phalcon\Security\JWT\Exceptions\UnsupportedAlgorithmException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Exceptions/UnsupportedAlgorithmException.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Exceptions | | Uses | Exception, Throwable | | Extends | Exception | | Implements | Throwable |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

<h1 id="security-jwt-exceptions-validatorexception">Class Phalcon\Security\JWT\Exceptions\ValidatorException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Exceptions/ValidatorException.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Exceptions | | Uses | Exception, Throwable | | Extends | Exception | | Implements | Throwable |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

<h1 id="security-jwt-signer-abstractsigner">Abstract Class Phalcon\Security\JWT\Signer\AbstractSigner</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Signer/AbstractSigner.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Signer | | Implements | SignerInterface |

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

<h1 id="security-jwt-signer-hmac">Class Phalcon\Security\JWT\Signer\Hmac</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Signer/Hmac.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Signer | | Uses | Phalcon\Security\JWT\Exceptions\UnsupportedAlgorithmException | | Extends | AbstractSigner |

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

<h1 id="security-jwt-signer-none">Class Phalcon\Security\JWT\Signer\None</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Signer/None.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Signer | | Implements | SignerInterface |

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

<h1 id="security-jwt-signer-signerinterface">Interface Phalcon\Security\JWT\Signer\SignerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Signer/SignerInterface.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Signer |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

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

<h1 id="security-jwt-token-abstractitem">Abstract Class Phalcon\Security\JWT\Token\AbstractItem</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Token/AbstractItem.zep)

| Namespace | Phalcon\Security\JWT\Token |

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

<h1 id="security-jwt-token-enum">Class Phalcon\Security\JWT\Token\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Token/Enum.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Token |

Class Enum

@link https://tools.ietf.org/html/rfc7519

## Constantes

```php
const ALGO            = 'alg';
const AUDIENCE        = 'aud';
const CONTENT_TYPE    = 'cty';
const EXPIRATION_TIME = 'exp';
const ID              = 'jti';
const ISSUED_AT       = 'iat';
const ISSUER          = 'iss';
const NOT_BEFORE      = 'nbf';
const SUBJECT         = 'sub';
const TYPE            = 'typ';
```

<h1 id="security-jwt-token-item">Class Phalcon\Security\JWT\Token\Item</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Token/Item.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Token | | Extends | AbstractItem |

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

<h1 id="security-jwt-token-parser">Class Phalcon\Security\JWT\Token\Parser</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Token/Parser.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Token | | Uses | InvalidArgumentException, Phalcon\Helper\Arr, Phalcon\Helper\Base64, Phalcon\Helper\Json |

Class Parser

## Métodos

```php
public function parse( string $token ): Token;
```

Analiza un token y lo devuelve

<h1 id="security-jwt-token-signature">Class Phalcon\Security\JWT\Token\Signature</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Token/Signature.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Token | | Extends | AbstractItem |

Class Item

## Métodos

```php
public function __construct( string $hash = string, string $encoded = string );
```

Constructor Signature.

```php
public function getHash(): string;
```

<h1 id="security-jwt-token-token">Class Phalcon\Security\JWT\Token\Token</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Token/Token.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT\Token |

Class Token

@property Item $claims @property Item $headers @property Signature $signature

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

<h1 id="security-jwt-validator">Class Phalcon\Security\JWT\Validator</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/JWT/Validator.zep)

![](/assets/images/version-4.1.svg)

| Namespace | Phalcon\Security\JWT | | Uses | Phalcon\Security\JWT\Exceptions\ValidatorException, Phalcon\Security\JWT\Signer\SignerInterface, Phalcon\Security\JWT\Token\Enum, Phalcon\Security\JWT\Token\Token |

Class Validator

@property int $timeShift @property Token $token

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

<h1 id="security-random">Class Phalcon\Security\Random</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Security/Random.zep)

| Namespace | Phalcon\Security |

Phalcon\Security\Random

Clase generadora segura de números aleatorios.

Proporciona un generador seguro de números aleatorios que es adecuado para generar clave de sesión en cookies HTTP, etc.

`Phalcon\Security\Random` podría ser útil principalmente para:

- Generación de claves (por ejemplo, generación de claves complicadas)
- Generando contraseñas aleatorias para nuevas cuentas de usuario
- Sistemas de cifrado

```php
$random = new \Phalcon\Security\Random();

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

Es similar a `Phalcon\Security\Random:base64()` pero se ha modificado para evitar tanto los caracteres no alfanuméricos como letras que pueden parecer ambiguas cuando se imprimen.

```php
$random = new \Phalcon\Security\Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE
```

@see \Phalcon\Security\Random:base64 @link https://en.wikipedia.org/wiki/Base58 @throws Exception If secure random number generator is not available or unexpected partial read

```php
public function base62( int $len = null ): string;
```

Genera una cadena base62 aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro.

Es similar a `Phalcon\Security\Random:base58()` pero se ha modificado para proporcionar el mayor valor que se puede utilizar de forma segura en las URLs sin necesidad de tener en cuenta los caracteres adicionales porque es [A-Za-z0-9].

```php
$random = new \Phalcon\Security\Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw
```

@see \Phalcon\Security\Random:base58 @throws Exception If secure random number generator is not available or unexpected partial read

```php
public function base64( int $len = null ): string;
```

Genera una cadena base64 aleatoria

Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len. Fórmula del tamaño: 4 * ($len / 3) y redondeado a un múltiplo de 4.

```php
$random = new \Phalcon\Security\Random();

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
$random = new \Phalcon\Security\Random();

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
$random = new \Phalcon\Security\Random();

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
$random = new \Phalcon\Security\Random();

echo $random->hex(10); // a29f470508d5ccb8e289
```

@throws Exception If secure random number generator is not available or unexpected partial read

```php
public function number( int $len ): int;
```

Genera un número aleatorio entre 0 y $len

Devuelve un entero: 0 <= result <= $len.

```php
$random = new \Phalcon\Security\Random();

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
$random = new \Phalcon\Security\Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22
```

@link https://www.ietf.org/rfc/rfc4122.txt @throws Exception If secure random number generator is not available or unexpected partial read

```php
protected function base( string $alphabet, int $base, mixed $n = null ): string;
```

Genera una cadena aleatoria basada en el número ($base) de caracteres ($alphabet).

Si $n no se especifica, se asume 16. Puede ser más grande en el futuro.

@throws Exception If secure random number generator is not available or unexpected partial read
