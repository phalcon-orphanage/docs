---
layout: default
title: 'Seguridad - JWT'
keywords: 'seguridad, hash, contraseñas, jwt, rfc7519'
---

# Seguridad - Tokens Web JSON (JWT)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

> **NOTA**: Actualmente, sólo se soportan algoritmos simétricos 
> 
> {: .alert .alert-info }

`Phalcon\Encryption\Security\JWT` is a namespace that contains components that allow you to issue, parse and validate JSON Web Tokens as described in [RFC 7915][rfc-7519]. Estos componentes son:

- Builder ([Phalcon\Encryption\Security\JWT\Builder][security-jwt-builder])
- Parser ([Phalcon\Encryption\Security\JWT\Token\Parser][security-jwt-token-parser])
- Validator ([Phalcon\Encryption\Security\JWT\Validator][security-jwt-validator])

Un ejemplo de uso del componente es:

```php
<?php

use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Token\Parser;
use Phalcon\Encryption\Security\JWT\Validator;

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

// Phalcon\Encryption\Security\JWT\Token\Token object
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

// Phalcon\Encryption\Security\JWT\Token\Token object
$tokenObject = $parser->parse($tokenReceived);

// Phalcon\Encryption\Security\JWT\Validator object
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

There are several utility components that live in the `Phalcon\Encryption\Security\JWT\Token` namespace, that help with the issuing, parsing and validating JWT tokens

### Enum

[Phalcon\Encryption\Security\JWT\Token\Enum][security-jwt-token-enum] is a class that contains several constants. Estas constantes son cadenas definidas en [RFC 7915][rfc-7519]. Puede usarlas si desea o en su lugar usar sus cadenas equivalentes.

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

[Phalcon\Encryption\Security\JWT\Token\Item][security-jwt-token-item] is used internally to store a payload as well as its encoded state. Such payload can be the claims data or the headers' data. Al usar este componente, podemos extraer fácilmente la información necesaria de cada Token.

### Signature

[Phalcon\Encryption\Security\JWT\Token\Signature][security-jwt-token-signature] is similar to the [Phalcon\Encryption\Security\JWT\Token\Item][security-jwt-token-item], but it only holds the signature hash as well as its encoded value.

### Token

[Phalcon\Encryption\Security\JWT\Token\Token][security-jwt-token-token] is the component responsible for storing and calculating the JWT token. It accepts the headers, claims (as [Phalcon\Encryption\Security\JWT\Token\Item][security-jwt-token-item] objects) and signature objects in its constructor and exposes:

* `getPayload`: Devuelve la carga útil
* `getToken`: Devuelve el token

Para un token `abcd.efgh.ijkl`, `getPayload` devolverá `abcd.efgh` y `getToken` devolverá `abcd.efgh.ijkl`.

### Signer

Para crear un token JWT, necesitamos suministrar un algoritmo de Firma. By default, the builder uses "none" ([Phalcon\Encryption\Security\JWT\Signer\None][security-jwt-signer-none]). You can however use the HMAC signer ([Phalcon\Encryption\Security\JWT\Signer\Hmac][security-jwt-signer-hmac]). Also, for further customization, you can utilize the supplied [Phalcon\Encryption\Security\JWT\Signer\SignerInterface][security-jwt-signer-signerinterface] interface.

```php
<?php

use Phalcon\Encryption\Security\JWT\Signer\Hmac;

$signer  = new Hmac();
```

**None**

El firmante se proporciona principalmente para propósitos de desarrollo. Siempre debería firmar sus tokens JWT.

**HMAC**

El firmante HMAC soporta los algoritmos `sha512`, `sha384`, y `sha256`. Si no se proporciona ninguno, se seleccionará automáticamente `sha512`. If you supply a different algorithm, a [Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException][security-jwt-exceptions-unsupportedalgorithmexception] will be raised. El algoritmo se establece en el constructor.


```php
<?php

use Phalcon\Encryption\Security\JWT\Signer\Hmac;

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

A Builder component ([Phalcon\Encryption\Security\JWT\Builder][security-jwt-builder]) is available, utilizing chained methods, and ready to be used to create JWT tokens. Todo lo que tiene que hacer es instanciar el objeto `Builder`, configurar su token y llamar `getToken()`. This will return a [Phalcon\Encryption\Security\Token\Token][security-jwt-token-token] object which contains all the necessary information for your token. Al instanciar el componente constructor, debe proporcionar la clase de firmante. In the example below we use the [Phalcon\Encryption\Security\JWT\Signer\Hmac][security-jwt-signer-hmac] signer.

Todos los *setters* de este componente son encadenables.

```php
<?php

use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;

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
Establece la audiencia (`aud`). If the parameter passed is not an array or a string, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function setContentType(string $contentType): Builder
```
Establece el tipo de contenido (`cty` - cabeceras)

```php
public function setExpirationTime(int $timestamp): Builder
```
Establece la audiencia (`exp`). If the `$timestamp` is less than the current time, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

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
Sets el tiempo no anterior (`nbf`). If the `$timestamp` is greater than the current time, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function setSubject(string $subject): Builder
```
Establece el asunto (`sub`).

```php
public function setPassphrase(string $passphrase): Builder
```
Establece la frase secreta. If the `$passphrase` is weak, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
private function setClaim(string $name, $value): Builder
```
Establece un valor de reclamo en la colección interna.


### Ejemplo

```php
<?php

use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Token\Parser;
use Phalcon\Encryption\Security\JWT\Validator;

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

// Phalcon\Encryption\Security\JWT\Token\Token object
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

In order to validate a token you will need to create a new [Phalcon\Encryption\Security\JWT\Validator][security-jwt-validator] object. The object can be constructed using a [Phalcon\Encryption\Security\JWT\Token\Token][security-jwt-token-token] object and an offset in time to handle time/clock shifts of the sending and receiving computers.

In order to parse the JWT received and convert it to a [Phalcon\Encryption\Security\JWT\Token\Token][security-jwt-token-token] object, you will need to use a [Phalcon\Encryption\Security\JWT\Token\Parser][security-jwt-token-parser] object and parse it.

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
Valida la audiencia. If it is not included in the token's `aud`, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function validateExpiration(int $timestamp): Validator
```
Valida el tiempo de expiración. If the `exp` value stored in the token is less than now, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function validateId(string $id): Validator
```
Valida el id. If it is not the same as the `jti` value stored in the token, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function validateIssuedAt(int $timestamp): Validator
```
Valida el emitido a la hora. If the `iat` value stored in the token is greater than now, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function validateIssuer(string $issuer): Validator
```
Valida el emisor. If it is not the same as the `iss` value stored in the token, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function validateNotBefore(int $timestamp): Validator
```
Valida el tiempo no anterior. If the `nbf` value stored in the token is greater than now, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

```php
public function validateSignature(SignerInterface $signer, string $passphrase): Validator
```
Valida al firma del token. If the signature is not valid, a [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception] will be thrown.

### Ejemplo

```php
<?php

use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Token\Parser;
use Phalcon\Encryption\Security\JWT\Validator;

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

// Phalcon\Encryption\Security\JWT\Token\Token object
$tokenObject = $parser->parse($tokenReceived);

// Phalcon\Encryption\Security\JWT\Validator object
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

Any exceptions thrown in the Security component will be of the namespace `Phalcon\Encryption\Security\JWT\*`. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente. Hay dos excepciones lanzadas. First if you supply the wrong algoritm string when instantiating the [Phalcon\Encryption\Security\JWT\Signer\Hmac][security-jwt-signer-hmac] component. This exception is [Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException][security-jwt-exceptions-unsupportedalgorithmexception].

La segunda excepción se lanza cuando se valida un JWT. This exception is [Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException][security-jwt-exceptions-validatorexception].

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Validator;

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
[security-jwt-builder]: api/phalcon_encryption#encryption-security-jwt-builder
[security-jwt-exceptions-unsupportedalgorithmexception]: api/phalcon_encryption#encryption-security-jwt-exceptions-unsupportedalgorithmexception
[security-jwt-exceptions-validatorexception]: api/phalcon_encryption#encryption-security-jwt-exceptions-validatorexception
[security-jwt-signer-hmac]: api/phalcon_encryption#encryption-security-jwt-signer-hmac
[security-jwt-signer-none]: api/phalcon_encryption#encryption-security-jwt-signer-none
[security-jwt-signer-signerinterface]: api/phalcon_encryption#encryption-security-jwt-signer-signerinterface
[security-jwt-token-enum]: api/phalcon_encryption#encryption-security-jwt-token-enum
[security-jwt-token-item]: api/phalcon_encryption#encryption-security-jwt-token-item
[security-jwt-token-parser]: api/phalcon_encryption#encryption-security-jwt-token-parser
[security-jwt-token-signature]: api/phalcon_encryption#encryption-security-jwt-token-signature
[security-jwt-token-token]: api/phalcon_encryption#encryption-security-jwt-token-token
[security-jwt-token-token]: api/phalcon_encryption#encryption-security-jwt-token-token
[security-jwt-validator]: api/phalcon_encryption#encryption-security-jwt-validator
