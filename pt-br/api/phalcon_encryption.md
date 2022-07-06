---
layout: default
language: 'pt-br'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt.zep)

| Namespace  | Phalcon\Encryption | | Uses       | Phalcon\Encryption\Crypt\CryptInterface, Phalcon\Encryption\Crypt\Exception\Exception, Phalcon\Encryption\Crypt\Exception\Mismatch, Phalcon\Encryption\Crypt\PadFactory | | Implements | CryptInterface |

Provides encryption capabilities to Phalcon applications.

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


## Constants
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

## Properties
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

## Methods

```php
public function __construct( string $cipher = static-constant-access, bool $useSigning = bool, PadFactory $padFactory = null );
```
Crypt constructor.


```php
public function decrypt( string $input, string $key = null ): string;
```
Decrypts an encrypted text.

```php
$encrypted = $crypt->decrypt(
    $encrypted,
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```


```php
public function decryptBase64( string $input, string $key = null, bool $safe = bool ): string;
```
Decrypt a text that is coded as a base64 string.


```php
public function encrypt( string $input, string $key = null ): string;
```
Encrypts a text.

```php
$encrypted = $crypt->encrypt(
    "Top secret",
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
);
```


```php
public function encryptBase64( string $input, string $key = null, bool $safe = bool ): string;
```
Encrypts a text returning the result as a base64 string.


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
Returns a list of available ciphers.


```php
public function getAvailableHashAlgorithms(): array;
```
Return a list of registered hashing algorithms suitable for hash_hmac.


```php
public function getCipher(): string;
```
Returns the current cipher


```php
public function getHashAlgorithm(): string;
```
Get the name of hashing algorithm.


```php
public function getKey(): string;
```
Returns the encryption key


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
Sets the cipher algorithm for data encryption and decryption.


```php
public function setHashAlgorithm( string $hashAlgorithm ): CryptInterface;
```
Set the name of hashing algorithm.


```php
public function setKey( string $key ): CryptInterface;
```
Sets the encryption key.

The `$key` should have been previously generated in a cryptographically safe way.

Bad key: "le password"

Better (but still unsafe) -> "#1dj8$=dp?.ak//j1V$~%*0X"

Good key: "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"


```php
public function setPadding( int $scheme ): CryptInterface;
```
Changes the padding scheme used.


```php
public function useSigning( bool $useSigning ): CryptInterface;
```
Sets if the calculating message digest must used.


```php
protected function checkCipherHashIsAvailable( string $cipher, string $type ): void;
```
Checks if a cipher or a hash algorithm is available


```php
protected function cryptPadText( string $input, string $mode, int $blockSize, int $paddingType ): string;
```
Pads texts before encryption. See [cryptopad](https://www.di-mgt.com.au/cryptopad.html)


```php
protected function cryptUnpadText( string $input, string $mode, int $blockSize, int $paddingType ): string;
```
Removes a padding from a text.

If the function detects that the text was not padded, it will return it unmodified.


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
Initialize available cipher algorithms.


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/CryptInterface.zep)

| Namespace  | Phalcon\Encryption\Crypt |

Interface for Phalcon\Crypt


## Methods

```php
public function decrypt( string $input, string $key = null ): string;
```
Decrypts a text


```php
public function decryptBase64( string $input, string $key = null ): string;
```
Decrypt a text that is coded as a base64 string


```php
public function encrypt( string $input, string $key = null ): string;
```
Encrypts a text


```php
public function encryptBase64( string $input, string $key = null ): string;
```
Encrypts a text returning the result as a base64 string


```php
public function getAuthData(): string;
```
Returns authentication data


```php
public function getAuthTag(): string;
```
Returns the authentication tag


```php
public function getAuthTagLength(): int;
```
Returns the authentication tag length


```php
public function getAvailableCiphers(): array;
```
Returns a list of available cyphers


```php
public function getCipher(): string;
```
Returns the current cipher


```php
public function getKey(): string;
```
Returns the encryption key


```php
public function setAuthData( string $data ): CryptInterface;
```
Sets authentication data


```php
public function setAuthTag( string $tag ): CryptInterface;
```
Sets the authentication tag


```php
public function setAuthTagLength( int $length ): CryptInterface;
```
Sets the authentication tag length


```php
public function setCipher( string $cipher ): CryptInterface;
```
Sets the cipher algorithm


```php
public function setKey( string $key ): CryptInterface;
```
Sets the encryption key


```php
public function setPadding( int $scheme ): CryptInterface;
```
Changes the padding scheme used.


```php
public function useSigning( bool $useSigning ): CryptInterface;
```
Sets if the calculating message digest must be used.




<h1 id="encryption-crypt-exception-exception">Class Phalcon\Encryption\Crypt\Exception\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Exception/Exception.zep)

| Namespace  | Phalcon\Encryption\Crypt\Exception | | Extends    | \Exception |

Exceptions thrown in Phalcon\Crypt use this class



<h1 id="encryption-crypt-exception-mismatch">Class Phalcon\Encryption\Crypt\Exception\Mismatch</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Exception/Mismatch.zep)

| Namespace  | Phalcon\Encryption\Crypt\Exception | | Extends    | Exception |

Exceptions thrown in Phalcon\Crypt will use this class.



<h1 id="encryption-crypt-padfactory">Class Phalcon\Encryption\Crypt\PadFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/PadFactory.zep)

| Namespace  | Phalcon\Encryption\Crypt | | Uses       | Phalcon\Encryption\Crypt, Phalcon\Encryption\Crypt\Padding\PadInterface, Phalcon\Factory\AbstractFactory, Phalcon\Support\Helper\Arr\Get | | Extends    | AbstractFactory |

Class PadFactory

@package Phalcon\Crypt


## Properties
```php
/**
 * @var string
 */
protected exception = Phalcon\\Encryption\\Crypt\\Exception\\Exception;

```

## Methods

```php
public function __construct( array $services = [] );
```
AdapterFactory constructor.


```php
public function newInstance( string $name ): PadInterface;
```
Create a new instance of the adapter


```php
public function padNumberToService( int $number ): string;
```
Gets a Crypt pad constant and returns the unique service name for the padding class


```php
protected function getServices(): array;
```





<h1 id="encryption-crypt-padding-ansi">Class Phalcon\Encryption\Crypt\Padding\Ansi</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Ansi.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Ansi

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-iso10126">Class Phalcon\Encryption\Crypt\Padding\Iso10126</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Iso10126.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Iso10126

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-isoiek">Class Phalcon\Encryption\Crypt\Padding\IsoIek</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/IsoIek.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class IsoIek

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-noop">Class Phalcon\Encryption\Crypt\Padding\Noop</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Noop.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Noop

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-padinterface">Interface Phalcon\Encryption\Crypt\Padding\PadInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/PadInterface.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding |

Interface for Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-pkcs7">Class Phalcon\Encryption\Crypt\Padding\Pkcs7</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Pkcs7.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Pkcs7

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-space">Class Phalcon\Encryption\Crypt\Padding\Space</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Space.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Space

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-crypt-padding-zero">Class Phalcon\Encryption\Crypt\Padding\Zero</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Crypt/Padding/Zero.zep)

| Namespace  | Phalcon\Encryption\Crypt\Padding | | Implements | PadInterface |

Class Zero

@package Phalcon\Encryption\Crypt\Padding


## Methods

```php
public function pad( int $paddingSize ): string;
```

```php
public function unpad( string $input, int $blockSize ): int;
```





<h1 id="encryption-security">Class Phalcon\Encryption\Security</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security.zep)

| Namespace  | Phalcon\Encryption | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\RequestInterface, Phalcon\Encryption\Security\Random, Phalcon\Encryption\Security\Exception, Phalcon\Session\ManagerInterface | | Extends    | AbstractInjectionAware |

This component provides a set of functions to improve the security in Phalcon applications

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


## Constants
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

## Properties
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

## Methods

```php
public function __construct( SessionInterface $session = null, RequestInterface $request = null );
```
Security constructor.


```php
public function checkHash( string $password, string $passwordHash, int $maxPassLength = int ): bool;
```
Checks a plain text password and its hash version to check if the password matches


```php
public function checkToken( string $tokenKey = null, mixed $tokenValue = null, bool $destroyIfValid = bool ): bool;
```
Check if the CSRF token sent in the request is the same that the current in session


```php
public function computeHmac( string $data, string $key, string $algo, bool $raw = bool ): string;
```
Computes a HMAC


```php
public function destroyToken(): Security;
```
Removes the value of the CSRF token and key from session


```php
public function getDefaultHash(): int;
```
Returns the default hash


```php
public function getHashInformation( string $hash ): array;
```
Returns information regarding a hash


```php
public function getRandom(): Random;
```
Returns a secure random number generator instance


```php
public function getRandomBytes(): int;
```
Returns a number of bytes to be generated by the openssl pseudo random generator


```php
public function getRequestToken(): string | null;
```
Returns the value of the CSRF token for the current request.


```php
public function getSaltBytes( int $numberBytes = int ): string;
```
Generate a >22-length pseudo random string to be used as salt for passwords


```php
public function getSessionToken(): string | null;
```
Returns the value of the CSRF token in session


```php
public function getToken(): string | null;
```
Generates a pseudo random token value to be used as input's value in a CSRF check


```php
public function getTokenKey(): string | null;
```
Generates a pseudo random token key to be used as input's name in a CSRF check


```php
public function getWorkFactor(): int
```

```php
public function hash( string $password, array $options = [] ): string;
```
Creates a password hash using bcrypt with a pseudo random salt


```php
public function isLegacyHash( string $passwordHash ): bool;
```
Checks if a password hash is a valid bcrypt's hash


```php
public function setDefaultHash( int $defaultHash ): Security;
```
Sets the default hash


```php
public function setRandomBytes( int $randomBytes ): Security;
```
Sets a number of bytes to be generated by the openssl pseudo random generator


```php
public function setWorkFactor( int $workFactor ): Security;
```
Sets the work factor


```php
protected function getLocalService( string $name, string $property );
```





<h1 id="encryption-security-exception">Class Phalcon\Encryption\Security\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/Exception.zep)

| Namespace  | Phalcon\Encryption\Security | | Extends    | \Exception |

Phalcon\Encryption\Security\Exception

Exceptions thrown in Phalcon\Security will use this class



<h1 id="encryption-security-jwt-builder">Class Phalcon\Encryption\Security\JWT\Builder</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Builder.zep)

| Namespace  | Phalcon\Encryption\Security\JWT | | Uses       | InvalidArgumentException, Phalcon\Support\Collection, Phalcon\Support\Collection\CollectionInterface, Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException, Phalcon\Encryption\Security\JWT\Signer\SignerInterface, Phalcon\Encryption\Security\JWT\Token\Enum, Phalcon\Encryption\Security\JWT\Token\Item, Phalcon\Encryption\Security\JWT\Token\Signature, Phalcon\Encryption\Security\JWT\Token\Token |

Class Builder

@property CollectionInterface  $claims @property CollectionInterface  $jose @property string               $passphrase @property SignerInterface      $signer

@link https://tools.ietf.org/html/rfc7519


## Properties
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

## Methods

```php
public function __construct( SignerInterface $signer );
```
Builder constructor.


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
The "aud" (audience) claim identifies the recipients that the JWT is intended for.  Each principal intended to process the JWT MUST identify itself with a value in the audience claim.  If the principal processing the claim does not identify itself with a value in the "aud" claim when this claim is present, then the JWT MUST be rejected.  In the general case, the "aud" value is an array of case- sensitive strings, each containing a StringOrURI value.  In the special case when the JWT has one audience, the "aud" value MAY be a single case-sensitive string containing a StringOrURI value.  The interpretation of audience values is generally application specific. Use of this claim is OPTIONAL.


```php
public function setContentType( string $contentType ): Builder;
```
Sets the content type header 'cty'


```php
public function setExpirationTime( int $timestamp ): Builder;
```
The "exp" (expiration time) claim identifies the expiration time on or after which the JWT MUST NOT be accepted for processing.  The processing of the "exp" claim requires that the current date/time MUST be before the expiration date/time listed in the "exp" claim. Implementers MAY provide for some small leeway, usually no more than a few minutes, to account for clock skew.  Its value MUST be a number containing a NumericDate value.  Use of this claim is OPTIONAL.


```php
public function setId( string $id ): Builder;
```
The "jti" (JWT ID) claim provides a unique identifier for the JWT. The identifier value MUST be assigned in a manner that ensures that there is a negligible probability that the same value will be accidentally assigned to a different data object; if the application uses multiple issuers, collisions MUST be prevented among values produced by different issuers as well.  The "jti" claim can be used to prevent the JWT from being replayed.  The "jti" value is a case- sensitive string.  Use of this claim is OPTIONAL.


```php
public function setIssuedAt( int $timestamp ): Builder;
```
The "iat" (issued at) claim identifies the time at which the JWT was issued.  This claim can be used to determine the age of the JWT.  Its value MUST be a number containing a NumericDate value.  Use of this claim is OPTIONAL.


```php
public function setIssuer( string $issuer ): Builder;
```
The "iss" (issuer) claim identifies the principal that issued the JWT.  The processing of this claim is generally application specific. The "iss" value is a case-sensitive string containing a StringOrURI value.  Use of this claim is OPTIONAL.


```php
public function setNotBefore( int $timestamp ): Builder;
```
The "nbf" (not before) claim identifies the time before which the JWT MUST NOT be accepted for processing.  The processing of the "nbf" claim requires that the current date/time MUST be after or equal to the not-before date/time listed in the "nbf" claim.  Implementers MAY provide for some small leeway, usually no more than a few minutes, to account for clock skew.  Its value MUST be a number containing a NumericDate value.  Use of this claim is OPTIONAL.


```php
public function setPassphrase( string $passphrase ): Builder;
```

```php
public function setSubject( string $subject ): Builder;
```
The "sub" (subject) claim identifies the principal that is the subject of the JWT.  The claims in a JWT are normally statements about the subject.  The subject value MUST either be scoped to be locally unique in the context of the issuer or be globally unique. The processing of this claim is generally application specific.  The "sub" value is a case-sensitive string containing a StringOrURI value.  Use of this claim is OPTIONAL.


```php
protected function setClaim( string $name, mixed $value ): Builder;
```
Sets a registered claim




<h1 id="encryption-security-jwt-exceptions-unsupportedalgorithmexception">Class Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Exceptions/UnsupportedAlgorithmException.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Exceptions | | Uses       | Exception, Throwable | | Extends    | Exception | | Implements | Throwable |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.



<h1 id="encryption-security-jwt-exceptions-validatorexception">Class Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Exceptions/ValidatorException.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Exceptions | | Uses       | Exception, Throwable | | Extends    | Exception | | Implements | Throwable |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.



<h1 id="encryption-security-jwt-signer-abstractsigner">Abstract Class Phalcon\Encryption\Security\JWT\Signer\AbstractSigner</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/AbstractSigner.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer | | Implements | SignerInterface |

Class AbstractSigner

@property string $algo


## Properties
```php
/**
 * @var string
 */
protected algorithm;

```

## Methods

```php
public function getAlgorithm(): string
```





<h1 id="encryption-security-jwt-signer-hmac">Class Phalcon\Encryption\Security\JWT\Signer\Hmac</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/Hmac.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer | | Uses       | Phalcon\Encryption\Security\JWT\Exceptions\UnsupportedAlgorithmException | | Extends    | AbstractSigner |

Class Hmac


## Methods

```php
public function __construct( string $algo = string );
```
Hmac constructor.


```php
public function getAlgHeader(): string;
```
Return the value that is used for the "alg" header


```php
public function sign( string $payload, string $passphrase ): string;
```
Sign a payload using the passphrase


```php
public function verify( string $source, string $payload, string $passphrase ): bool;
```
Verify a passed source with a payload and passphrase




<h1 id="encryption-security-jwt-signer-none">Class Phalcon\Encryption\Security\JWT\Signer\None</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/None.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer | | Implements | SignerInterface |

Class None


## Methods

```php
public function getAlgHeader(): string;
```
Return the value that is used for the "alg" header


```php
public function getAlgorithm(): string;
```
Return the algorithm used


```php
public function sign( string $payload, string $passphrase ): string;
```
Sign a payload using the passphrase


```php
public function verify( string $source, string $payload, string $passphrase ): bool;
```
Verify a passed source with a payload and passphrase




<h1 id="encryption-security-jwt-signer-signerinterface">Interface Phalcon\Encryption\Security\JWT\Signer\SignerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Signer/SignerInterface.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Signer |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Methods

```php
public function getAlgHeader(): string;
```
Return the value that is used for the "alg" header


```php
public function getAlgorithm(): string;
```
Return the algorithm used


```php
public function sign( string $payload, string $passphrase ): string;
```
Sign a payload using the passphrase


```php
public function verify( string $source, string $payload, string $passphrase ): bool;
```
Verify a passed source with a payload and passphrase




<h1 id="encryption-security-jwt-token-abstractitem">Abstract Class Phalcon\Encryption\Security\JWT\Token\AbstractItem</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/AbstractItem.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token |

Class AbstractItem

@property array $data


## Properties
```php
/**
 * @var array
 */
protected data;

```

## Methods

```php
public function getEncoded(): string;
```





<h1 id="encryption-security-jwt-token-enum">Class Phalcon\Encryption\Security\JWT\Token\Enum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Enum.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token |

Class Enum

@link https://tools.ietf.org/html/rfc7519


## Constants
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Item.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token | | Extends    | AbstractItem |

Class Item


## Methods

```php
public function __construct( array $payload, string $encoded );
```
Item constructor.


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Parser.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token | | Uses       | InvalidArgumentException |

Class Parser


## Methods

```php
public function parse( string $token ): Token;
```
Parse a token and return it




<h1 id="encryption-security-jwt-token-signature">Class Phalcon\Encryption\Security\JWT\Token\Signature</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Signature.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token | | Extends    | AbstractItem |

Class Item


## Methods

```php
public function __construct( string $hash = string, string $encoded = string );
```
Signature constructor.


```php
public function getHash(): string;
```





<h1 id="encryption-security-jwt-token-token">Class Phalcon\Encryption\Security\JWT\Token\Token</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Token/Token.zep)

| Namespace  | Phalcon\Encryption\Security\JWT\Token |

Class Token

@property Item      $claims @property Item      $headers @property Signature $signature

@link https://tools.ietf.org/html/rfc7519


## Properties
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

## Methods

```php
public function __construct( Item $headers, Item $claims, Signature $signature );
```
Token constructor.


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/JWT/Validator.zep)

| Namespace  | Phalcon\Encryption\Security\JWT | | Uses       | Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException, Phalcon\Encryption\Security\JWT\Signer\SignerInterface, Phalcon\Encryption\Security\JWT\Token\Enum, Phalcon\Encryption\Security\JWT\Token\Token |

Class Validator

@property int   $timeShift @property Token $token


## Properties
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

## Methods

```php
public function __construct( Token $token, int $timeShift = int );
```
Validator constructor.


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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Encryption/Security/Random.zep)

| Namespace  | Phalcon\Encryption\Security |

Phalcon\Encryption\Security\Random

Secure random number generator class.

Provides secure random number generator which is suitable for generating session key in HTTP cookies, etc.

`Phalcon\Encryption\Security\Random` could be mainly useful for:

- Key generation (e.g. generation of complicated keys)
- Generating random passwords for new user accounts
- Encryption systems

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

This class partially borrows SecureRandom library from Ruby

@link http://ruby-doc.org/stdlib-2.2.2/libdoc/securerandom/rdoc/SecureRandom.html


## Methods

```php
public function base58( int $len = null ): string;
```
Generates a random base58 string

If $len is not specified, 16 is assumed. It may be larger in future. The result may contain alphanumeric characters except 0, O, I and l.

It is similar to `Phalcon\Encryption\Security\Random::base64()` but has been modified to avoid both non-alphanumeric characters and letters which might look ambiguous when printed.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE
```

@see    \Phalcon\Encryption\Security\Random:base64 @link   https://en.wikipedia.org/wiki/Base58 @throws Exception If secure random number generator is not available or unexpected partial read


```php
public function base62( int $len = null ): string;
```
Generates a random base62 string

If $len is not specified, 16 is assumed. It may be larger in future.

It is similar to `Phalcon\Encryption\Security\Random::base58()` but has been modified to provide the largest value that can safely be used in URLs without needing to take extra characters into consideration because it is [A-Za-z0-9].

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw
```

@see    \Phalcon\Encryption\Security\Random:base58 @throws Exception If secure random number generator is not available or unexpected partial read


```php
public function base64( int $len = null ): string;
```
Generates a random base64 string

If $len is not specified, 16 is assumed. It may be larger in future. The length of the result string is usually greater of $len. Size formula: 4($len / 3) rounded up to a multiple of 4.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8
```

@throws Exception If secure random number generator is not available or unexpected partial read


```php
public function base64Safe( int $len = null, bool $padding = bool ): string;
```
Generates a random URL-safe base64 string

If $len is not specified, 16 is assumed. It may be larger in future. The length of the result string is usually greater of $len.

By default, padding is not generated because "=" may be used as a URL delimiter. The result may contain A-Z, a-z, 0-9, "-" and "_". "=" is also used if $padding is true. See RFC 3548 for the definition of URL-safe base64.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug
```

@link https://www.ietf.org/rfc/rfc3548.txt @throws Exception If secure random number generator is not available or unexpected partial read


```php
public function bytes( int $len = int ): string;
```
Generates a random binary string

The `Random::bytes` method returns a string and accepts as input an int representing the length in bytes to be returned.

If $len is not specified, 16 is assumed. It may be larger in future. The result may contain any byte: "x00" - "xFF".

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
Generates a random hex string

If $len is not specified, 16 is assumed. It may be larger in future. The length of the result string is usually greater of $len.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->hex(10); // a29f470508d5ccb8e289
```

@throws Exception If secure random number generator is not available or unexpected partial read


```php
public function number( int $len ): int;
```
Generates a random number between 0 and $len

Returns an integer: 0 <= result <= $len.

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->number(16); // 8
```
@throws Exception If secure random number generator is not available, unexpected partial read or $len <= 0


```php
public function uuid(): string;
```
Generates a v4 random UUID (Universally Unique IDentifier)

The version 4 UUID is purely random (except the version). It doesn't contain meaningful information such as MAC address, time, etc. See RFC 4122 for details of UUID.

This algorithm sets the version number (4 bits) as well as two reserved bits. All other bits (the remaining 122 bits) are set using a random or pseudorandom data source. Version 4 UUIDs have the form xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx where x is any hexadecimal digit and y is one of 8, 9, A, or B (e.g., f47ac10b-58cc-4372-a567-0e02b2c3d479).

```php
$random = new \Phalcon\Encryption\Security\Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22
```

@link https://www.ietf.org/rfc/rfc4122.txt @throws Exception If secure random number generator is not available or unexpected partial read


```php
protected function base( string $alphabet, int $base, mixed $n = null ): string;
```
Generates a random string based on the number ($base) of characters ($alphabet).

If $n is not specified, 16 is assumed. It may be larger in future.

@throws Exception If secure random number generator is not available or unexpected partial read


