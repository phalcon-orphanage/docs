---
layout: default
language: 'es-es'
version: '4.0'
title: 'Seguridad - JWT'
keywords: 'seguridad, hash, contraseñas, jwt, rfc7519'
---

# Seguridad - Tokens Web JSON (JWT)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-4.1.svg)

## Resumen

> **NOTA**: Actualmente, sólo se soportan algoritmos simétricos 
> 
> {: .alert .alert-info }

`Phalcon\Security\JWT` is a namespace that contains components that allow you to issue, parse and validate JSON Web Tokens as described in [RFC 7519][rfc-7519]. Estos componentes son:

- Builder ([Phalcon\Security\JWT\Builder][security-jwt-builder])
- Parser ([Phalcon\Security\JWT\Token\Parser][security-jwt-token-parser])
- Validator ([Phalcon\Security\JWT\Validator][security-jwt-validator])

Un ejemplo de uso del componente es:

```php
<?php

use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

// Defaults to 'sha512'
$signer  = new Hmac();

// Builder object
$builder = new Builder($signer);

$now        = new DateTimeImmutable();
$issued     = $now->getTimestamp();
$notBefore  = $now->modify('-1 minute')->getTimestamp();
$expires    = $now->modify('+1 day')->getTimestamp();
$passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

// Setup
$builder
    ->setAudience('https://target.phalcon.io')  // aud
    ->setContentType('application/json')        // cty - header
    ->setExpirationTime($expires)               // exp 
    ->setId('abcd123456789')                    // JTI id 
    ->setIssuedAt($issued)                      // iat 
    ->setIssuer('https://phalcon.io')           // iss 
    ->setNotBefore($notBefore)                  // nbf
    ->setSubject('my subject for this claim')   // sub
    ->setPassphrase($passphrase)                // password 
;

// Phalcon\Security\JWT\Token\Token object
$tokenObject = $builder->getToken();

// The token
echo $tokenObject->getToken();

// Token split into different lines for readability
//
// eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImN0eSI6ImFwcGxpY2F0aW9uXC9qc29uIn0.
// eyJhdWQiOlsiaHR0cHM6XC9cL3RhcmdldC5waGFsY29uLmlvIl0sImV4cCI6MTYxNDE4NTkxN
// ywianRpIjoiYWJjZDEyMzQ1Njc4OSIsImlhdCI6MTYxNDA5OTUxNywiaXNzIjoiaHR0cHM6XC
// 9cL3BoYWxjb24uaW8iLCJuYmYiOjE2MTQwOTk0NTcsInN1YiI6Im15IHN1YmplY3QgZm9yIHR
// oaXMgY2xhaW0ifQ.
// LdYevRZaQDZ2lul4CCQ5DymeP2ubcapTtgeezOZGIq7Meu7rFF1pv32b-AMWOxCS63CQz_jpm
// BPlPyOeEAkMbg
```

```php
// $tokenReceived is what we received
$tokenReceived = getMyTokenFromTheApplication();
$audience      = 'https://target.phalcon.io';
$now           = new DateTimeImmutable();
$issued        = $now->getTimestamp();
$notBefore     = $now->modify('-1 minute')->getTimestamp();
$expires       = $now->getTimestamp();
$id            = 'abcd123456789';
$issuer        = 'https://phalcon.io';

// Defaults to 'sha512'
$signer     = new Hmac();
$passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

// Parse the token
$parser      = new Parser();

// Phalcon\Security\JWT\Token\Token object
$tokenObject = $parser->parse($tokenReceived);

// Phalcon\Security\JWT\Validator object
$validator = new Validator($tokenObject, 100); // allow for a time shift of 100

// Throw exceptions if those do not validate
$validator
    ->validateAudience($audience)
    ->validateExpiration($expires)
    ->validateId($id)
    ->validateIssuedAt($issued)
    ->validateIssuer($issuer)
    ->validateNotBefore($notBefore)
    ->validateSignature($signer, $passphrase)
;
```

El ejemplo anterior da una vista general de cómo se puede usar el componente para generar, analizar y validar Tokens Web JSON.

## Objetos

Hay varios componentes de utilidad bajo el espacio de nombres `Phalcon\Security\JWT\Token`, que ayudan con la emisión, análisis y validación de tokens JWT

### Enum

[Phalcon\Security\JWT\Token\Enum][security-jwt-token-enum] es una clase que contiene varias constantes. Estas constantes son cadenas definidas en [RFC 7915][rfc-7519]. Puede usarlas si desea o en su lugar usar sus cadenas equivalentes.

```php
<?php

class Enum
{
    /**
     * Headers
     */
    const TYPE         = "typ";
    const ALGO         = "alg";
    const CONTENT_TYPE = "cty";

    /**
     * Claims
     */
    const AUDIENCE        = "aud";
    const EXPIRATION_TIME = "exp";
    const ID              = "jti";
    const ISSUED_AT       = "iat";
    const ISSUER          = "iss";
    const NOT_BEFORE      = "nbf";
    const SUBJECT         = "sub";
}
```

### Item

[Phalcon\Security\JWT\Token\Item][security-jwt-token-item] se usa internamente para almacenar una carga útil así como su estado codificado. Tal carga útil puede ser los datos de los reclamos o los datos de cabecera. Al usar este componente, podemos extraer fácilmente la información necesaria de cada Token.

### Signature

[Phalcon\Security\JWT\Token\Signature][security-jwt-token-signature] es similar a [Phalcon\Security\JWT\Token\Item][security-jwt-token-item], pero este sólo mantiene el hash de la firma así como su valor codificado.

### Token

[Phalcon\Security\JWT\Token\Token][security-jwt-token-token] es el componente responsable de almacenar y calcular el token JWT. Acepta las cabeceras, reclamaciones (como objetos [Phalcon\Security\JWT\Token\Item][security-jwt-token-item]) y objetos de firma en su constructor y expone:

* `getPayload`: Devuelve la carga útil
* `getToken`: Devuelve el token

Para un token `abcd.efgh.ijkl`, `getPayload` devolverá `abcd.efgh` y `getToken` devolverá `abcd.efgh.ijkl`.

### Signer

Para crear un token JWT, necesitamos suministrar un algoritmo de Firma. Por defecto, el constructor usa "none" ([Phalcon\Security\JWT\Signer\None][security-jwt-signer-none]). Pero puede usar el firmante HMAC ([Phalcon\Security\JWT\Signer\Hmac][security-jwt-signer-hmac]). También, para más personalización, puede usar el interfaz proporcionado [Phalcon\Security\JWT\Signer\SignerInterface][security-jwt-signer-signerinterface].

```php
<?php

use Phalcon\Security\JWT\Signer\Hmac;

$signer  = new Hmac();
```

**None**

El firmante se proporciona principalmente para propósitos de desarrollo. Siempre debería firmar sus tokens JWT.

**HMAC**

El firmante HMAC soporta los algoritmos `sha512`, `sha384`, y `sha256`. Si no se proporciona ninguno, se seleccionará automáticamente `sha512`. Si proporciona un algoritmo diferente, se lanzará [Phalcon\Security\JWT\Exceptions\UnsupportedAlgorithmException][security-jwt-exceptions-unsupportedalgorithmexception]. El algoritmo se establece en el constructor.


```php
<?php

use Phalcon\Security\JWT\Signer\Hmac;

$signer  = new Hmac();
$signer  = new Hmac('sha512');
$signer  = new Hmac('sha384');
$signer  = new Hmac('sha256');
$signer  = new Hmac('sha111'); // exception
```

El componente usa internamente los métodos PHP \[hmac_equals\]\[hmac_equals\] y \[hash_hmac\]\[hash_hmac\] para verificar y firmar la carga útil. Expone los siguientes métodos:

```php
public function getAlgHeader(): string
```

Devuelve una cadena que identifica el algoritmo. Para el algoritmo HMAC devolverá:

| Algoritmo | `getAlgHeader` |
| --------- | -------------- |
| `sha512`  | `HS512`        |
| `sha384`  | `HS384`        |
| `sha256`  | `HS256`        |

```php
public function sign(string $payload, string $passphrase): string
```

Devuelve el hash de la carga útil usando la frase secreta

```php
public function verify(string $source, string $payload, string $passphrase): bool
```

Verifica que el hash de la cadena original es el mismo que el hash de la carga útil con la frase secreta.

## Emisión de Tokens

Está disponible un componente `Builder` ([Phalcon\Security\JWT\Builder][security-jwt-builder]), utilizando métodos encadenados, y listo para usar para crear tokens JWT. Todo lo que tiene que hacer es instanciar el objeto `Builder`, configurar su token y llamar `getToken()`. Esto devolverá un objeto [Phalcon\Security\Token\Token][security-jwt-token-token] que contiene todo la información necesaria para su token. Al instanciar el componente constructor, debe proporcionar la clase de firmante. En el siguiente ejemplo usamos el firmante [Phalcon\Security\JWT\Signer\Hmac][security-jwt-signer-hmac].

Todos los *setters* de este componente son encadenables.

```php
<?php

use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;

// Defaults to 'sha512'
$signer  = new Hmac();

// Builder object
$builder = new Builder($signer);
```

### Métodos

```php
public function __construct(SignerInterface $signer): Builder
```
Constructor

```php
public function init(): Builder
```
Inicializa el objeto - útil cuando quiere reutilizar el mismo constructor

```php
public function getAudience()
```
Obtiene el contenido de `aud`

```php
public function getClaims(): array
```
Obtiene los reclamos como vector

```php
public function getContentType(): ?string
```
Devuelve el tipo de contenido (`cty` - cabeceras)

```php
public function getExpirationTime(): ?int
```
Devuelve el contenido de `exp`

```php
public function getHeaders(): array
```
Devuelve las cabeceras como vector

```php
public function getId(): ?string
```
Devuelve el contenido de `jti` (ID de este JWT)

```php
public function getIssuedAt(): ?int
```
Devuelve el contenido de `iat`

```php
public function getIssuer(): ?string
```
Devuelve el contenido de `iss`

```php
public function getNotBefore(): ?int
```
Devuelve el contenido de `nbf`

```php
public function getSubject(): ?string
```
Devuelve el contenido de `sub`

```php
public function getToken(): Token
```
Devuelve el token

```php
public function getPassphrase(): string
```
Devuelve la frase secreta proporcionada

```php
public function setAudience($audience): Builder
```
Establece la audiencia (`aud`). Si el parámetro pasado no es un vector o cadena, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function setContentType(string $contentType): Builder
```
Establece el tipo de contenido (`cty` - cabeceras)

```php
public function setExpirationTime(int $timestamp): Builder
```
Establece la audiencia (`exp`). Si `$timestamp` es menor que la hora actual, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function setId(string $id): Builder
```
Establece el id (`jti`).

```php
public function setIssuedAt(int $timestamp): Builder
```
Establece el emitido a la hora (`iat`).

```php
public function setIssuer(string $issuer): Builder
```
Establece el emisor (`iss`).

```php
public function setNotBefore(int $timestamp): Builder
```
Sets el tiempo no anterior (`nbf`). Si `$timestamp` es mayor que la hora actual, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function setSubject(string $subject): Builder
```
Establece el asunto (`sub`).

```php
public function setPassphrase(string $passphrase): Builder
```
Establece la frase secreta. Si `$passphrase` es débil, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
private function setClaim(string $name, $value): Builder
```
Establece un valor de reclamo en la colección interna.


### Ejemplo

```php
<?php

use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

// Defaults to 'sha512'
$signer  = new Hmac();

// Builder object
$builder = new Builder($signer);

$now        = new DateTimeImmutable();
$issued     = $now->getTimestamp();
$notBefore  = $now->modify('-1 minute')->getTimestamp();
$expires    = $now->modify('+1 day')->getTimestamp();
$passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

// Setup
$builder
    ->setAudience('https://target.phalcon.io')  // aud
    ->setContentType('application/json')        // cty - header
    ->setExpirationTime($expires)               // exp 
    ->setId('abcd123456789')                    // JTI id 
    ->setIssuedAt($issued)                      // iat 
    ->setIssuer('https://phalcon.io')           // iss 
    ->setNotBefore($notBefore)                  // nbf
    ->setSubject('my subject for this claim')   // sub
    ->setPassphrase($passphrase)                // password 
;

// Phalcon\Security\JWT\Token\Token object
$tokenObject = $builder->getToken();

// The token
echo $tokenObject->getToken();

// Token split into different lines for readability
//
// eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImN0eSI6ImFwcGxpY2F0aW9uXC9qc29uIn0.
// eyJhdWQiOlsiaHR0cHM6XC9cL3RhcmdldC5waGFsY29uLmlvIl0sImV4cCI6MTYxNDE4NTkxN
// ywianRpIjoiYWJjZDEyMzQ1Njc4OSIsImlhdCI6MTYxNDA5OTUxNywiaXNzIjoiaHR0cHM6XC
// 9cL3BoYWxjb24uaW8iLCJuYmYiOjE2MTQwOTk0NTcsInN1YiI6Im15IHN1YmplY3QgZm9yIHR
// oaXMgY2xhaW0ifQ.
// LdYevRZaQDZ2lul4CCQ5DymeP2ubcapTtgeezOZGIq7Meu7rFF1pv32b-AMWOxCS63CQz_jpm
// BPlPyOeEAkMbg
```

## Validación de Tokens

Para poder validar un token necesitará crear un nuevo objeto [Phalcon\Security\JWT\Validator][security-jwt-validator]. El objeto se puede construir usando un objeto [Phalcon\Security\JWT\Token\Token][security-jwt-token-token] y un desplazamiento en tiempo para gestionar los cambios de hora/reloj de los ordenadores de envío y recepción.

Para poder analizar el JWT recibido y convertirlo a un objeto [Phalcon\Security\JWT\Token\Token][security-jwt-token-token], necesitará usar un objeto [Phalcon\Security\JWT\Token\Parser][security-jwt-token-parser] y analizarlo.

```php
// Parser
$parser = new Parser();

// Parse the token received
$tokenObject = $parser->parse($tokenReceived);

// Create the validator
$validator = new Validator($tokenObject, 100); // allow for a time shift of 100
```

Después de esto, puede empezar llamando los métodos `validate*` con los parámetros necesarios para validar el token recibido. Si no se lanzan excepciones, el token es válido.

### Métodos

```php
public function __construct(Token $token, int $timeShift = 0)
```
Constructor

```php
public function setToken(Token $token): Validator
```
Establece el objeto token.

```php
public function validateAudience(string $audience): Validator
```
Valida la audiencia. Si no se incluye en el `aud` del token, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function validateExpiration(int $timestamp): Validator
```
Valida el tiempo de expiración. El valor `exp` almacenado en el token es menor que ahora, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function validateId(string $id): Validator
```
Valida el id. Si no es el mismo que el valor `jti` almacenado en el token, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function validateIssuedAt(int $timestamp): Validator
```
Valida el emitido a la hora. Si el valor `iat` almacenado en el token es mayor que ahora, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function validateIssuer(string $issuer): Validator
```
Valida el emisor. Si no es el mismo que el valor `iss` almacenado en el token, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function validateNotBefore(int $timestamp): Validator
```
Valida el tiempo no anterior. Si el valor `nbf` almacenado es mayor que ahora, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
public function validateSignature(SignerInterface $signer, string $passphrase): Validator
```
Valida al firma del token. Si la firma no es válida, se lanzará [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

### Ejemplo

```php
<?php

use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

// Token split into different lines for readability
//
// eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImN0eSI6ImFwcGxpY2F0aW9uXC9qc29uIn0.
// eyJhdWQiOlsiaHR0cHM6XC9cL3RhcmdldC5waGFsY29uLmlvIl0sImV4cCI6MTYxNDE4NTkxN
// ywianRpIjoiYWJjZDEyMzQ1Njc4OSIsImlhdCI6MTYxNDA5OTUxNywiaXNzIjoiaHR0cHM6XC
// 9cL3BoYWxjb24uaW8iLCJuYmYiOjE2MTQwOTk0NTcsInN1YiI6Im15IHN1YmplY3QgZm9yIHR
// oaXMgY2xhaW0ifQ.
// LdYevRZaQDZ2lul4CCQ5DymeP2ubcapTtgeezOZGIq7Meu7rFF1pv32b-AMWOxCS63CQz_jpm
// BPlPyOeEAkMbg

// $tokenReceived is what we received
$tokenReceived = getMyTokenFromTheApplication();
$audience      = 'https://target.phalcon.io';
$now           = new DateTimeImmutable();
$issued        = $now->getTimestamp();
$notBefore     = $now->modify('-1 minute')->getTimestamp();
$expires       = $now->getTimestamp();
$id            = 'abcd123456789';
$issuer        = 'https://phalcon.io';

// Defaults to 'sha512'
$signer     = new Hmac();
$passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

// Parse the token
$parser      = new Parser();

// Phalcon\Security\JWT\Token\Token object
$tokenObject = $parser->parse($tokenReceived);

// Phalcon\Security\JWT\Validator object
$validator = new Validator($tokenObject, 100); // allow for a time shift of 100

// Throw exceptions if those do not validate
$validator
    ->validateAudience($audience)
    ->validateExpiration($expires)
    ->validateId($id)
    ->validateIssuedAt($issued)
    ->validateIssuer($issuer)
    ->validateNotBefore($notBefore)
    ->validateSignature($signer, $passphrase)
;
```

## Excepciones

Cualquier excepción lanzada en el componente `Security` será del espacio del nombres `Phalcon\Security\JWT\*`. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente. Hay dos excepciones lanzadas. Primera si provee la cadena de algoritmo incorrecta cuando instancia el componente [Phalcon\Security\JWT\Signer\Hmac][security-jwt-signer-hmac]. Esta excepción es [Phalcon\Security\JWT\Exceptions\UnsupportedAlgorithmException][security-jwt-exceptions-unsupportedalgorithmexception].

La segunda excepción se lanza cuando se valida un JWT. Esta excepción es [Phalcon\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Validator;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $signer     = new Hmac();
            $builder    = new Builder($signer);
            $expiry     = strtotime('+1 day');
            $issued     = strtotime('now') + 100;
            $notBefore  = strtotime('-1 day');
            $passphrase = '&vsJBETaizP3A3VX&TPMJUqi48fJEgN7';

            return $builder
                ->setAudience('my-audience')
                ->setExpirationTime($expiry)
                ->setIssuer('Phalcon JWT')
                ->setIssuedAt($issued)
                ->setId('PH-JWT')
                ->setNotBefore($notBefore)
                ->setSubject('Mary had a little lamb')
                ->setPassphrase($passphrase)
                ->getToken()
            ;

            $validator = new Validator($token);
            $validator->validateAudience("unknown");
        } catch (Exception $ex) {
            echo $ex->getMessage(); // Validation: audience not allowed
        }
    }
}
```

[rfc-7519]: https://datatracker.ietf.org/doc/html/rfc7519

[rfc-7519]: https://datatracker.ietf.org/doc/html/rfc7519
[security-jwt-builder]: api/phalcon_security#security-jwt-builder
[security-jwt-exceptions-unsupportedalgorithmexception]: api/phalcon_security#security-jwt-exceptions-unsupportedalgorithmexception
[security-jwt-exceptions-validatorexception]: api/phalcon_security#security-jwt-exceptions-validatorexception
[security-jwt-signer-hmac]: api/phalcon_security#security-jwt-signer-hmac
[security-jwt-signer-none]: api/phalcon_security#security-jwt-signer-none
[security-jwt-signer-signerinterface]: api/phalcon_security#security-jwt-signer-signerinterface
[security-jwt-token-enum]: api/phalcon_security#security-jwt-token-enum
[security-jwt-token-item]: api/phalcon_security#security-jwt-token-item
[security-jwt-token-parser]: api/phalcon_security#security-jwt-token-parser
[security-jwt-token-signature]: api/phalcon_security#security-jwt-token-signature
[security-jwt-token-token]: api/phalcon_security#security-jwt-token-token
[security-jwt-token-token]: api/phalcon_security#security-jwt-token-token
[security-jwt-validator]: api/phalcon_security#security-jwt-validator
