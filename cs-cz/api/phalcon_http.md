---
layout: default
language: 'cs-cz'
version: '5.0'
title: 'Phalcon\Http'
---

* [Phalcon\Http\Cookie](#http-cookie)
* [Phalcon\Http\Cookie\CookieInterface](#http-cookie-cookieinterface)
* [Phalcon\Http\Cookie\Exception](#http-cookie-exception)
* [Phalcon\Http\Message\RequestMethodInterface](#http-message-requestmethodinterface)
* [Phalcon\Http\Message\ResponseStatusCodeInterface](#http-message-responsestatuscodeinterface)
* [Phalcon\Http\Request](#http-request)
* [Phalcon\Http\Request\Exception](#http-request-exception)
* [Phalcon\Http\Request\File](#http-request-file)
* [Phalcon\Http\Request\FileInterface](#http-request-fileinterface)
* [Phalcon\Http\RequestInterface](#http-requestinterface)
* [Phalcon\Http\Response](#http-response)
* [Phalcon\Http\Response\Cookies](#http-response-cookies)
* [Phalcon\Http\Response\CookiesInterface](#http-response-cookiesinterface)
* [Phalcon\Http\Response\Exception](#http-response-exception)
* [Phalcon\Http\Response\Headers](#http-response-headers)
* [Phalcon\Http\Response\HeadersInterface](#http-response-headersinterface)
* [Phalcon\Http\ResponseInterface](#http-responseinterface)

<h1 id="http-cookie">Class Phalcon\Http\Cookie</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Cookie.zep)

| Namespace  | Phalcon\Http | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Encryption\Crypt\CryptInterface, Phalcon\Encryption\Crypt\Mismatch, Phalcon\Filter\FilterInterface, Phalcon\Http\Response\Exception, Phalcon\Http\Cookie\CookieInterface, Phalcon\Http\Cookie\Exception, Phalcon\Session\ManagerInterface | | Extends    | AbstractInjectionAware | | Implements | CookieInterface |

Provide OO wrappers to manage a HTTP cookie.


## Properties
```php
/**
 * @var string
 */
protected domain;

/**
 * @var int
 */
protected expire;

/**
 * @var FilterInterface|null
 */
protected filter;

/**
 * @var bool
 */
protected httpOnly;

/**
 * @var string
 */
protected name;

/**
 * @var array
 */
protected options;

/**
 * @var string
 */
protected path;

/**
 * @var bool
 */
protected read = false;

/**
 * @var bool
 */
protected restored = false;

/**
 * @var bool
 */
protected secure = true;

/**
 * The cookie's sign key.
 *
 * @var string|null
 */
protected signKey;

/**
 * @var bool
 */
protected useEncryption = false;

/**
 * @var mixed|null
 */
protected value;

```

## Methods

```php
public function __construct( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] );
```
Phalcon\Http\Cookie constructor.


```php
public function __toString(): string;
```
Magic __toString method converts the cookie's value to string


```php
public function delete();
```
Deletes the cookie by setting an expire time in the past


```php
public function getDomain(): string;
```
Returns the domain that the cookie is available to


```php
public function getExpiration(): string;
```
Returns the current expiration time


```php
public function getHttpOnly(): bool;
```
Returns if the cookie is accessible only through the HTTP protocol


```php
public function getName(): string;
```
Returns the current cookie's name


```php
public function getOptions(): array;
```
Returns the current cookie's options


```php
public function getPath(): string;
```
Returns the current cookie's path


```php
public function getSecure(): bool;
```
Returns whether the cookie must only be sent when the connection is secure (HTTPS)


```php
public function getValue( mixed $filters = null, mixed $defaultValue = null ): mixed;
```
Returns the cookie's value.


```php
public function isUsingEncryption(): bool;
```
Check if the cookie is using implicit encryption


```php
public function restore(): CookieInterface;
```
Reads the cookie-related info from the SESSION to restore the cookie as it was set.

This method is automatically called internally so normally you don't need to call it.


```php
public function send(): CookieInterface;
```
Sends the cookie to the HTTP client.

Stores the cookie definition in session.


```php
public function setDomain( string $domain ): CookieInterface;
```
Sets the domain that the cookie is available to


```php
public function setExpiration( int $expire ): CookieInterface;
```
Sets the cookie's expiration time


```php
public function setHttpOnly( bool $httpOnly ): CookieInterface;
```
Sets if the cookie is accessible only through the HTTP protocol


```php
public function setOptions( array $options ): CookieInterface;
```
Sets the cookie's options


```php
public function setPath( string $path ): CookieInterface;
```
Sets the cookie's path


```php
public function setSecure( bool $secure ): CookieInterface;
```
Sets if the cookie must only be sent when the connection is secure (HTTPS)


```php
public function setSignKey( string $signKey = null ): CookieInterface;
```
Sets the cookie's sign key.

The `$signKey' MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

Use NULL to disable cookie signing.

@see \Phalcon\Security\Random @throws \Phalcon\Http\Cookie\Exception


```php
public function setValue( mixed $value ): CookieInterface;
```
Sets the cookie's value


```php
public function useEncryption( bool $useEncryption ): CookieInterface;
```
Sets if the cookie must be encrypted/decrypted automatically


```php
protected function assertSignKeyIsLongEnough( string $signKey ): void;
```
Assert the cookie's key is enough long.

@throws \Phalcon\Http\Cookie\Exception




<h1 id="http-cookie-cookieinterface">Interface Phalcon\Http\Cookie\CookieInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Cookie/CookieInterface.zep)

| Namespace  | Phalcon\Http\Cookie |

Interface for Phalcon\Http\Cookie


## Methods

```php
public function delete();
```
Deletes the cookie


```php
public function getDomain(): string;
```
Returns the domain that the cookie is available to


```php
public function getExpiration(): string;
```
Returns the current expiration time


```php
public function getHttpOnly(): bool;
```
Returns if the cookie is accessible only through the HTTP protocol


```php
public function getName(): string;
```
Returns the current cookie's name


```php
public function getOptions(): array;
```
Returns the current cookie's options


```php
public function getPath(): string;
```
Returns the current cookie's path


```php
public function getSecure(): bool;
```
Returns whether the cookie must only be sent when the connection is secure (HTTPS)


```php
public function getValue( mixed $filters = null, mixed $defaultValue = null ): mixed;
```
Returns the cookie's value.


```php
public function isUsingEncryption(): bool;
```
Check if the cookie is using implicit encryption


```php
public function send(): CookieInterface;
```
Sends the cookie to the HTTP client


```php
public function setDomain( string $domain ): CookieInterface;
```
Sets the domain that the cookie is available to


```php
public function setExpiration( int $expire ): CookieInterface;
```
Sets the cookie's expiration time


```php
public function setHttpOnly( bool $httpOnly ): CookieInterface;
```
Sets if the cookie is accessible only through the HTTP protocol


```php
public function setOptions( array $options ): CookieInterface;
```
Sets the cookie's options


```php
public function setPath( string $path ): CookieInterface;
```
Sets the cookie's expiration time


```php
public function setSecure( bool $secure ): CookieInterface;
```
Sets if the cookie must only be sent when the connection is secure (HTTPS)


```php
public function setValue( mixed $value ): CookieInterface;
```
Sets the cookie's value


```php
public function useEncryption( bool $useEncryption ): CookieInterface;
```
Sets if the cookie must be encrypted/decrypted automatically




<h1 id="http-cookie-exception">Class Phalcon\Http\Cookie\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Cookie/Exception.zep)

| Namespace  | Phalcon\Http\Cookie | | Extends    | \Exception |

Phalcon\Http\Cookie\Exception

Exceptions thrown in Phalcon\Http\Cookie will use this class.



<h1 id="http-message-requestmethodinterface">Interface Phalcon\Http\Message\RequestMethodInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Message/RequestMethodInterface.zep)

| Namespace  | Phalcon\Http\Message |

Interface for Request methods

Implementation of this file has been influenced by PHP FIG @link    https://github.com/php-fig/http-message-util/ @license https://github.com/php-fig/http-message-util/blob/master/LICENSE


## Constants
```php
const METHOD_CONNECT = CONNECT;
const METHOD_DELETE = DELETE;
const METHOD_GET = GET;
const METHOD_HEAD = HEAD;
const METHOD_OPTIONS = OPTIONS;
const METHOD_PATCH = PATCH;
const METHOD_POST = POST;
const METHOD_PURGE = PURGE;
const METHOD_PUT = PUT;
const METHOD_TRACE = TRACE;
```


<h1 id="http-message-responsestatuscodeinterface">Interface Phalcon\Http\Message\ResponseStatusCodeInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Message/ResponseStatusCodeInterface.zep)

| Namespace  | Phalcon\Http\Message |

Interface for Request methods

Implementation of this file has been influenced by PHP FIG @link    https://github.com/php-fig/http-message-util/ @license https://github.com/php-fig/http-message-util/blob/master/LICENSE

Defines constants for common HTTP status code.

@see https://tools.ietf.org/html/rfc2295#section-8.1 @see https://tools.ietf.org/html/rfc2324#section-2.3 @see https://tools.ietf.org/html/rfc2518#section-9.7 @see https://tools.ietf.org/html/rfc2774#section-7 @see https://tools.ietf.org/html/rfc3229#section-10.4 @see https://tools.ietf.org/html/rfc4918#section-11 @see https://tools.ietf.org/html/rfc5842#section-7.1 @see https://tools.ietf.org/html/rfc5842#section-7.2 @see https://tools.ietf.org/html/rfc6585#section-3 @see https://tools.ietf.org/html/rfc6585#section-4 @see https://tools.ietf.org/html/rfc6585#section-5 @see https://tools.ietf.org/html/rfc6585#section-6 @see https://tools.ietf.org/html/rfc7231#section-6 @see https://tools.ietf.org/html/rfc7238#section-3 @see https://tools.ietf.org/html/rfc7725#section-3 @see https://tools.ietf.org/html/rfc7540#section-9.1.2 @see https://tools.ietf.org/html/rfc8297#section-2 @see https://tools.ietf.org/html/rfc8470#section-7


## Constants
```php
const STATUS_ACCEPTED = 202;
const STATUS_ALREADY_REPORTED = 208;
const STATUS_BAD_GATEWAY = 502;
const STATUS_BAD_REQUEST = 400;
const STATUS_BANDWIDTH_LIMIT_EXCEEDED = 509;
const STATUS_BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450;
const STATUS_CLIENT_CLOSED_REQUEST = 499;
const STATUS_CONFLICT = 409;
const STATUS_CONNECTION_TIMEOUT = 522;
const STATUS_CONTINUE = 100;
const STATUS_CREATED = 201;
const STATUS_EARLY_HINTS = 103;
const STATUS_EXPECTATION_FAILED = 417;
const STATUS_FAILED_DEPENDENCY = 424;
const STATUS_FORBIDDEN = 403;
const STATUS_FOUND = 302;
const STATUS_GATEWAY_TIMEOUT = 504;
const STATUS_GONE = 410;
const STATUS_HTTP_REQUEST_SENT_TO_HTTPS_PORT = 497;
const STATUS_IM_A_TEAPOT = 418;
const STATUS_IM_USED = 226;
const STATUS_INSUFFICIENT_STORAGE = 507;
const STATUS_INTERNAL_SERVER_ERROR = 500;
const STATUS_INVALID_SSL_CERTIFICATE = 526;
const STATUS_INVALID_TOKEN_ESRI = 498;
const STATUS_LENGTH_REQUIRED = 411;
const STATUS_LOCKED = 423;
const STATUS_LOGIN_TIMEOUT = 440;
const STATUS_LOOP_DETECTED = 508;
const STATUS_METHOD_FAILURE = 420;
const STATUS_METHOD_NOT_ALLOWED = 405;
const STATUS_MISDIRECTED_REQUEST = 421;
const STATUS_MOVED_PERMANENTLY = 301;
const STATUS_MULTIPLE_CHOICES = 300;
const STATUS_MULTI_STATUS = 207;
const STATUS_NETWORK_AUTHENTICATION_REQUIRED = 511;
const STATUS_NETWORK_CONNECT_TIMEOUT_ERROR = 599;
const STATUS_NETWORK_READ_TIMEOUT_ERROR = 598;
const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
const STATUS_NOT_ACCEPTABLE = 406;
const STATUS_NOT_EXTENDED = 510;
const STATUS_NOT_FOUND = 404;
const STATUS_NOT_IMPLEMENTED = 501;
const STATUS_NOT_MODIFIED = 304;
const STATUS_NO_CONTENT = 204;
const STATUS_NO_RESPONSE = 444;
const STATUS_OK = 200;
const STATUS_ORIGIN_DNS_ERROR = 530;
const STATUS_ORIGIN_IS_UNREACHABLE = 523;
const STATUS_PAGE_EXPIRED = 419;
const STATUS_PARTIAL_CONTENT = 206;
const STATUS_PAYLOAD_TOO_LARGE = 413;
const STATUS_PAYMENT_REQUIRED = 402;
const STATUS_PERMANENT_REDIRECT = 308;
const STATUS_PRECONDITION_FAILED = 412;
const STATUS_PRECONDITION_REQUIRED = 428;
const STATUS_PROCESSING = 102;
const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
const STATUS_RAILGUN_ERROR = 527;
const STATUS_RANGE_NOT_SATISFIABLE = 416;
const STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
const STATUS_REQUEST_HEADER_TOO_LARGE = 494;
const STATUS_REQUEST_TIMEOUT = 408;
const STATUS_RESERVED = 306;
const STATUS_RESET_CONTENT = 205;
const STATUS_RETRY_WITH = 449;
const STATUS_SEE_OTHER = 303;
const STATUS_SERVICE_UNAVAILABLE = 503;
const STATUS_SSL_CERTIFICATE_ERROR = 495;
const STATUS_SSL_CERTIFICATE_REQUIRED = 496;
const STATUS_SSL_HANDSHAKE_FAILED = 525;
const STATUS_SWITCHING_PROTOCOLS = 101;
const STATUS_TEMPORARY_REDIRECT = 307;
const STATUS_THIS_IS_FINE = 218;
const STATUS_TIMEOUT_OCCURRED = 524;
const STATUS_TOO_EARLY = 425;
const STATUS_TOO_MANY_REQUESTS = 429;
const STATUS_UNAUTHORIZED = 401;
const STATUS_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
const STATUS_UNKNOWN_ERROR = 520;
const STATUS_UNPROCESSABLE_ENTITY = 422;
const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
const STATUS_UPGRADE_REQUIRED = 426;
const STATUS_URI_TOO_LONG = 414;
const STATUS_USE_PROXY = 305;
const STATUS_VARIANT_ALSO_NEGOTIATES = 506;
const STATUS_VERSION_NOT_SUPPORTED = 505;
const STATUS_WEB_SERVER_IS_DOWN = 521;
```


<h1 id="http-request">Class Phalcon\Http\Request</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request.zep)

| Namespace  | Phalcon\Http | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface, Phalcon\Http\Message\RequestMethodInterface, Phalcon\Http\Request\File, Phalcon\Http\Request\FileInterface, Phalcon\Http\Request\Exception, UnexpectedValueException, stdClass | | Extends    | AbstractInjectionAware | | Implements | RequestInterface, RequestMethodInterface |

Encapsulates request information for easy and secure access from application controllers.

The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.

```php
use Phalcon\Http\Request;

$request = new Request();

if ($request->isPost() && $request->isAjax()) {
    echo "Request was made using POST and AJAX";
}

// Retrieve SERVER variables
$request->getServer("HTTP_HOST");

// GET, POST, PUT, DELETE, HEAD, OPTIONS, PATCH, PURGE, TRACE, CONNECT
$request->getMethod();

// An array of languages the client accepts
$request->getLanguages();
```


## Properties
```php
/**
 * @var FilterInterface|null
 */
private filterService;

/**
 * @var bool
 */
private httpMethodParameterOverride = false;

/**
 * @var array
 */
private queryFilters;

/**
 * @var array|null
 */
private putCache;

/**
 * @var string
 */
private rawBody = ;

/**
 * @var bool
 */
private strictHostCheck = false;

```

## Methods

```php
public function get( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```


```php
public function getAcceptableContent(): array;
```
Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]


```php
public function getBasicAuth(): array | null;
```
Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]


```php
public function getBestAccept(): string;
```
Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]


```php
public function getBestCharset(): string;
```
Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getBestLanguage(): string;
```
Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
public function getClientAddress( bool $trustForwardedHeader = bool ): string | bool;
```
Gets most possible client IPv4 Address. This method searches in `$_SERVER["REMOTE_ADDR"]` and optionally in `$_SERVER["HTTP_X_FORWARDED_FOR"]`


```php
public function getClientCharsets(): array;
```
Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getContentType(): string | null;
```
Gets content type which request has been made


```php
public function getDigestAuth(): array;
```
Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_DIGEST"]


```php
public function getFilteredPost( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Retrieves a post value always sanitized with the preset filters


```php
public function getFilteredPut( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Retrieves a put value always sanitized with the preset filters


```php
public function getFilteredQuery( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Retrieves a query/get value always sanitized with the preset filters


```php
public function getHTTPReferer(): string;
```
Gets web page that refers active request. ie: http://www.google.com


```php
final public function getHeader( string $header ): string;
```
Gets HTTP header from request data


```php
public function getHeaders(): array;
```
Returns the available headers in the request

<code>
$_SERVER = [
    "PHP_AUTH_USER" => "phalcon",
    "PHP_AUTH_PW"   => "secret",
];

$headers = $request->getHeaders();

echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=
</code>

```php
public function getHttpHost(): string;
```
Gets host name used by the request.

`Request::getHttpHost` trying to find host name in following order:

- `$_SERVER["HTTP_HOST"]`
- `$_SERVER["SERVER_NAME"]`
- `$_SERVER["SERVER_ADDR"]`

Optionally `Request::getHttpHost` validates and clean host name. The `Request::$strictHostCheck` can be used to validate host name.

Note: validation and cleaning have a negative performance impact because they use regular expressions.

```php
use Phalcon\Http\Request;

$request = new Request;

$_SERVER["HTTP_HOST"] = "example.com";
$request->getHttpHost(); // example.com

$_SERVER["HTTP_HOST"] = "example.com:8080";
$request->getHttpHost(); // example.com:8080

$request->setStrictHostCheck(true);
$_SERVER["HTTP_HOST"] = "ex=am~ple.com";
$request->getHttpHost(); // UnexpectedValueException

$_SERVER["HTTP_HOST"] = "ExAmPlE.com";
$request->getHttpHost(); // example.com
```


```php
public function getHttpMethodParameterOverride(): bool
```

```php
public function getJsonRawBody( bool $associative = bool ): \stdClass | array | bool;
```
Gets decoded JSON HTTP raw request body


```php
public function getLanguages(): array;
```
Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
final public function getMethod(): string;
```
Gets HTTP method which request has been made

If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method.

The _method request parameter can also be used to determine the HTTP method, but only if setHttpMethodParameterOverride(true) has been called.

The method is always an uppercased string.


```php
public function getPort(): int;
```
Gets information about the port on which the request is made.


```php
public function getPost( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned

```php
// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");
```


```php
public function getPreferredIsoLocaleVariant(): string;
```
Gets the preferred ISO locale variant.

Gets the preferred locale accepted by the client from the "Accept-Language" request HTTP header and returns the base part of it i.e. `en` instead of `en-US`.

Note: This method relies on the `$_SERVER["HTTP_ACCEPT_LANGUAGE"]` header.

@link https://www.iso.org/standard/50707.html


```php
public function getPut( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets a variable from put request

```php
// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");
```


```php
public function getQuery( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets variable from $_GET superglobal applying filters if needed If no parameters are given the $_GET superglobal is returned

```php
// Returns value from $_GET["id"] without sanitizing
$id = $request->getQuery("id");

// Returns value from $_GET["id"] with sanitizing
$id = $request->getQuery("id", "int");

// Returns value from $_GET["id"] with a default value
$id = $request->getQuery("id", null, 150);
```


```php
public function getRawBody(): string;
```
Gets HTTP raw request body


```php
public function getScheme(): string;
```
Gets HTTP schema (http/https)


```php
public function getServer( string $name ): string | null;
```
Gets variable from $_SERVER superglobal


```php
public function getServerAddress(): string;
```
Gets active server address IP


```php
public function getServerName(): string;
```
Gets active server name


```php
final public function getURI( bool $onlyPath = bool ): string;
```
Gets HTTP URI which request has been made to

```php
// Returns /some/path?with=queryParams
$uri = $request->getURI();

// Returns /some/path
$uri = $request->getURI(true);
```


```php
public function getUploadedFiles( bool $onlySuccessful = bool, bool $namedKeys = bool ): FileInterface[];
```
Gets attached files as Phalcon\Http\Request\File instances


```php
public function getUserAgent(): string;
```
Gets HTTP user agent used to made the request


```php
public function has( string $name ): bool;
```
Checks whether $_REQUEST superglobal has certain index


```php
public function hasFiles(): bool;
```
Returns if the request has files or not


```php
final public function hasHeader( string $header ): bool;
```
Checks whether headers has certain index


```php
public function hasPost( string $name ): bool;
```
Checks whether $_POST superglobal has certain index


```php
public function hasPut( string $name ): bool;
```
Checks whether the PUT data has certain index


```php
public function hasQuery( string $name ): bool;
```
Checks whether $_GET superglobal has certain index


```php
final public function hasServer( string $name ): bool;
```
Checks whether $_SERVER superglobal has certain index


```php
public function isAjax(): bool;
```
Checks whether request has been made using ajax


```php
public function isConnect(): bool;
```
Checks whether HTTP method is CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"


```php
public function isDelete(): bool;
```
Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"


```php
public function isGet(): bool;
```
Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"


```php
public function isHead(): bool;
```
Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"


```php
public function isMethod( mixed $methods, bool $strict = bool ): bool;
```
Check if HTTP method match any of the passed methods When strict is true it checks if validated methods are real HTTP methods


```php
public function isOptions(): bool;
```
Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"


```php
public function isPatch(): bool;
```
Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"


```php
public function isPost(): bool;
```
Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"


```php
public function isPurge(): bool;
```
Checks whether HTTP method is PURGE (Squid and Varnish support). if _SERVER["REQUEST_METHOD"]==="PURGE"


```php
public function isPut(): bool;
```
Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"


```php
public function isSecure(): bool;
```
Checks whether request has been made using any secure layer


```php
public function isSoap(): bool;
```
Checks whether request has been made using SOAP


```php
public function isStrictHostCheck(): bool;
```
Checks if the `Request::getHttpHost` method will be use strict validation of host name or not


```php
public function isTrace(): bool;
```
Checks whether HTTP method is TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"


```php
public function isValidHttpMethod( string $method ): bool;
```
Checks if a method is a valid HTTP method


```php
public function numFiles( bool $onlySuccessful = bool ): long;
```
Returns the number of files available


```php
public function setHttpMethodParameterOverride( bool $httpMethodParameterOverride )
```

```php
public function setParameterFilters( string $name, array $filters = [], array $scope = [] ): RequestInterface;
```
Sets automatic sanitizers/filters for a particular field and for particular methods


```php
public function setStrictHostCheck( bool $flag = bool ): RequestInterface;
```
Sets if the `Request::getHttpHost` method must be use strict validation of host name or not


```php
final protected function getBestQuality( array $qualityParts, string $name ): string;
```
Process a request header and return the one with best quality


```php
final protected function getHelper( array $source, string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.


```php
final protected function getQualityHeader( string $serverIndex, string $name ): array;
```
Process a request header and return an array of values with their qualities


```php
final protected function hasFileHelper( mixed $data, bool $onlySuccessful ): long;
```
Recursively counts file in an array of files


```php
protected function resolveAuthorizationHeaders(): array;
```
Resolve authorization headers.


```php
final protected function smoothFiles( array $names, array $types, array $tmp_names, array $sizes, array $errors, string $prefix ): array;
```
Smooth out $_FILES to have plain array with all files uploaded




<h1 id="http-request-exception">Class Phalcon\Http\Request\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request/Exception.zep)

| Namespace  | Phalcon\Http\Request | | Extends    | \Exception |

Phalcon\Http\Request\Exception

Exceptions thrown in Phalcon\Http\Request will use this class



<h1 id="http-request-file">Class Phalcon\Http\Request\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request/File.zep)

| Namespace  | Phalcon\Http\Request | | Implements | FileInterface |

Phalcon\Http\Request\File

Provides OO wrappers to the $_FILES superglobal

```php
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function uploadAction()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
            // Print the real file names and their sizes
            foreach ($this->request->getUploadedFiles() as $file) {
                echo $file->getName(), " ", $file->getSize(), "\n";
            }
        }
    }
}
```


## Properties
```php
/**
 * @var string|null
 */
protected error;

/**
 * @var string
 */
protected extension;

/**
 * @var string|null
 */
protected key;

/**
 * @var string
 */
protected name;

/**
 * @var string
 */
protected realType;

/**
 * @var int
 */
protected size = 0;

/**
 * @var string|null
 */
protected tmp;

/**
 * @var string
 */
protected type;

```

## Methods

```php
public function __construct( array $file, mixed $key = null );
```
Phalcon\Http\Request\File constructor


```php
public function getError(): string|null
```

```php
public function getExtension(): string
```

```php
public function getKey(): string|null
```

```php
public function getName(): string;
```
Returns the real name of the uploaded file


```php
public function getRealType(): string;
```
Gets the real mime type of the upload file using finfo


```php
public function getSize(): int;
```
Returns the file size of the uploaded file


```php
public function getTempName(): string;
```
Returns the temporary name of the uploaded file


```php
public function getType(): string;
```
Returns the mime type reported by the browser This mime type is not completely secure, use getRealType() instead


```php
public function isUploadedFile(): bool;
```
Checks whether the file has been uploaded via Post.


```php
public function moveTo( string $destination ): bool;
```
Moves the temporary file to a destination within the application




<h1 id="http-request-fileinterface">Interface Phalcon\Http\Request\FileInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request/FileInterface.zep)

| Namespace  | Phalcon\Http\Request |

Phalcon\Http\Request\FileInterface

Interface for Phalcon\Http\Request\File



## Methods

```php
public function getError(): string | null;
```
Returns the error if any


```php
public function getName(): string;
```
Returns the real name of the uploaded file


```php
public function getRealType(): string;
```
Gets the real mime type of the upload file using finfo


```php
public function getSize(): int;
```
Returns the file size of the uploaded file


```php
public function getTempName(): string;
```
Returns the temporal name of the uploaded file


```php
public function getType(): string;
```
Returns the mime type reported by the browser This mime type is not completely secure, use getRealType() instead


```php
public function moveTo( string $destination ): bool;
```
Move the temporary file to a destination




<h1 id="http-requestinterface">Interface Phalcon\Http\RequestInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/RequestInterface.zep)

| Namespace  | Phalcon\Http | | Uses       | Phalcon\Http\Request\FileInterface, stdClass |

Interface for Phalcon\Http\Request


## Methods

```php
public function get( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```


```php
public function getAcceptableContent(): array;
```
Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]


```php
public function getBasicAuth(): array | null;
```
Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]


```php
public function getBestAccept(): string;
```
Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]


```php
public function getBestCharset(): string;
```
Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getBestLanguage(): string;
```
Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
public function getClientAddress( bool $trustForwardedHeader = bool ): string | bool;
```
Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]


```php
public function getClientCharsets(): array;
```
Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getContentType(): string | null;
```
Gets content type which request has been made


```php
public function getDigestAuth(): array;
```
Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_DIGEST"]


```php
public function getHTTPReferer(): string;
```
Gets web page that refers active request. ie: http://www.google.com


```php
public function getHeader( string $header ): string;
```
Gets HTTP header from request data


```php
public function getHeaders(): array;
```
Returns the available headers in the request

```php
$_SERVER = [
    "PHP_AUTH_USER" => "phalcon",
    "PHP_AUTH_PW"   => "secret",
];

$headers = $request->getHeaders();

echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=
```


```php
public function getHttpHost(): string;
```
Gets host name used by the request.

`Request::getHttpHost` trying to find host name in following order:

- `$_SERVER["HTTP_HOST"]`
- `$_SERVER["SERVER_NAME"]`
- `$_SERVER["SERVER_ADDR"]`

Optionally `Request::getHttpHost` validates and clean host name. The `Request::$_strictHostCheck` can be used to validate host name.

Note: validation and cleaning have a negative performance impact because they use regular expressions.

```php
use Phalcon\Http\Request;

$request = new Request;

$_SERVER["HTTP_HOST"] = "example.com";
$request->getHttpHost(); // example.com

$_SERVER["HTTP_HOST"] = "example.com:8080";
$request->getHttpHost(); // example.com:8080

$request->setStrictHostCheck(true);
$_SERVER["HTTP_HOST"] = "ex=am~ple.com";
$request->getHttpHost(); // UnexpectedValueException

$_SERVER["HTTP_HOST"] = "ExAmPlE.com";
$request->getHttpHost(); // example.com
```


```php
public function getJsonRawBody( bool $associative = bool ): stdClass | array | bool;
```
Gets decoded JSON HTTP raw request body


```php
public function getLanguages(): array;
```
Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
public function getMethod(): string;
```
Gets HTTP method which request has been made

If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method.

The _method request parameter can also be used to determine the HTTP method, but only if setHttpMethodParameterOverride(true) has been called.

The method is always an uppercased string.


```php
public function getPort(): int;
```
Gets information about the port on which the request is made


```php
public function getPost( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned

```php
// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");
```


```php
public function getPut( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets a variable from put request

```php
// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");
```


```php
public function getQuery( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Gets variable from $_GET superglobal applying filters if needed If no parameters are given the $_GET superglobal is returned

```php
// Returns value from $_GET["id"] without sanitizing
$id = $request->getQuery("id");

// Returns value from $_GET["id"] with sanitizing
$id = $request->getQuery("id", "int");

// Returns value from $_GET["id"] with a default value
$id = $request->getQuery("id", null, 150);
```


```php
public function getRawBody(): string;
```
Gets HTTP raw request body


```php
public function getScheme(): string;
```
Gets HTTP schema (http/https)


```php
public function getServer( string $name ): string | null;
```
Gets variable from $_SERVER superglobal


```php
public function getServerAddress(): string;
```
Gets active server address IP


```php
public function getServerName(): string;
```
Gets active server name


```php
public function getURI( bool $onlyPath = bool ): string;
```
Gets HTTP URI which request has been made to

```php
// Returns /some/path?with=queryParams
$uri = $request->getURI();

// Returns /some/path
$uri = $request->getURI(true);
```


```php
public function getUploadedFiles( bool $onlySuccessful = bool, bool $namedKeys = bool ): FileInterface[];
```
Gets attached files as Phalcon\Http\Request\FileInterface compatible instances


```php
public function getUserAgent(): string;
```
Gets HTTP user agent used to made the request


```php
public function has( string $name ): bool;
```
Checks whether $_REQUEST superglobal has certain index


```php
public function hasFiles(): bool;
```
Checks whether request include attached files


```php
public function hasHeader( string $header ): bool;
```
Checks whether headers has certain index


```php
public function hasPost( string $name ): bool;
```
Checks whether $_POST superglobal has certain index


```php
public function hasPut( string $name ): bool;
```
Checks whether the PUT data has certain index


```php
public function hasQuery( string $name ): bool;
```
Checks whether $_GET superglobal has certain index


```php
public function hasServer( string $name ): bool;
```
Checks whether $_SERVER superglobal has certain index


```php
public function isAjax(): bool;
```
Checks whether request has been made using ajax. Checks if $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest"


```php
public function isConnect(): bool;
```
Checks whether HTTP method is CONNECT. if $_SERVER["REQUEST_METHOD"] === "CONNECT"


```php
public function isDelete(): bool;
```
Checks whether HTTP method is DELETE. if $_SERVER["REQUEST_METHOD"] === "DELETE"


```php
public function isGet(): bool;
```
Checks whether HTTP method is GET. if $_SERVER["REQUEST_METHOD"] === "GET"


```php
public function isHead(): bool;
```
Checks whether HTTP method is HEAD. if $_SERVER["REQUEST_METHOD"] === "HEAD"


```php
public function isMethod( mixed $methods, bool $strict = bool ): bool;
```
Check if HTTP method match any of the passed methods


```php
public function isOptions(): bool;
```
Checks whether HTTP method is OPTIONS. if $_SERVER["REQUEST_METHOD"] === "OPTIONS"


```php
public function isPost(): bool;
```
Checks whether HTTP method is POST. if $_SERVER["REQUEST_METHOD"] === "POST"


```php
public function isPurge(): bool;
```
Checks whether HTTP method is PURGE (Squid and Varnish support). if $_SERVER["REQUEST_METHOD"] === "PURGE"


```php
public function isPut(): bool;
```
Checks whether HTTP method is PUT. if $_SERVER["REQUEST_METHOD"] === "PUT"


```php
public function isSecure(): bool;
```
Checks whether request has been made using any secure layer


```php
public function isSoap(): bool;
```
Checks whether request has been made using SOAP


```php
public function isTrace(): bool;
```
Checks whether HTTP method is TRACE. if $_SERVER["REQUEST_METHOD"] === "TRACE"


```php
public function numFiles( bool $onlySuccessful = bool ): long;
```
Returns the number of files available




<h1 id="http-response">Class Phalcon\Http\Response</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response.zep)

| Namespace  | Phalcon\Http | | Uses       | DateTime, DateTimeZone, InvalidArgumentException, Phalcon\Di\Di, Phalcon\Di\DiInterface, Phalcon\Http\Message\ResponseStatusCodeInterface, Phalcon\Http\Response\Exception, Phalcon\Http\Response\HeadersInterface, Phalcon\Http\Response\CookiesInterface, Phalcon\Mvc\Url\UrlInterface, Phalcon\Mvc\ViewInterface, Phalcon\Http\Response\Headers, Phalcon\Di\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Implements | ResponseInterface, InjectionAwareInterface, EventsAwareInterface, ResponseStatusCodeInterface |

Part of the HTTP cycle is return responses to the clients. Phalcon\HTTP\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.

```php
$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();
```


## Properties
```php
/**
 * @var DiInterface|null
 */
protected container;

/**
 * @var string|null
 */
protected content;

/**
 * @var CookiesInterface|null
 */
protected cookies;

/**
 * @var ManagerInterface|null
 */
protected eventsManager;

/**
 * @var string|null
 */
protected file;

/**
 * @var Headers
 */
protected headers;

/**
 * @var bool
 */
protected sent = false;

/**
 * @var array
 */
protected statusCodes;

```

## Methods

```php
public function __construct( string $content = null, mixed $code = null, mixed $status = null );
```
Phalcon\Http\Response constructor


```php
public function appendContent( mixed $content ): ResponseInterface;
```
Appends a string to the HTTP response body


```php
public function getContent(): string;
```
Gets the HTTP response body


```php
public function getCookies(): CookiesInterface;
```
Returns cookies set by the user


```php
public function getDI(): DiInterface;
```
Returns the internal dependency injector


```php
public function getEventsManager(): ManagerInterface | null;
```
Returns the internal event manager


```php
public function getHeaders(): HeadersInterface;
```
Returns headers set by the user


```php
public function getReasonPhrase(): string | null;
```
Returns the reason phrase

```php
echo $response->getReasonPhrase();
```


```php
public function getStatusCode(): int | null;
```
Returns the status code

```php
echo $response->getStatusCode();
```


```php
public function hasHeader( string $name ): bool;
```
Checks if a header exists

```php
$response->hasHeader("Content-Type");
```


```php
public function isSent(): bool;
```
Check if the response is already sent


```php
public function redirect( mixed $location = null, bool $externalRedirect = bool, int $statusCode = int ): ResponseInterface;
```
Redirect by HTTP to another action or URL

```php
// Using a string redirect (internal/external)
$response->redirect("posts/index");
$response->redirect("http://en.wikipedia.org", true);
$response->redirect("http://www.example.com/new-location", true, 301);

// Making a redirection based on a named route
$response->redirect(
    [
        "for"        => "index-lang",
        "lang"       => "jp",
        "controller" => "index",
    ]
);
```


```php
public function removeHeader( string $name ): ResponseInterface;
```
Remove a header in the response

```php
$response->removeHeader("Expires");
```


```php
public function resetHeaders(): ResponseInterface;
```
Resets all the established headers


```php
public function send(): ResponseInterface;
```
Prints out HTTP response to the client


```php
public function sendCookies(): ResponseInterface;
```
Sends cookies to the client


```php
public function sendHeaders(): ResponseInterface | bool;
```
Sends headers to the client


```php
public function setCache( int $minutes ): ResponseInterface;
```
Sets Cache headers to use HTTP cache

```php
$this->response->setCache(60);
```


```php
public function setContent( string $content ): ResponseInterface;
```
Sets HTTP response body

```php
$response->setContent("<h1>Hello!</h1>");
```


```php
public function setContentLength( int $contentLength ): ResponseInterface;
```
Sets the response content-length

```php
$response->setContentLength(2048);
```


```php
public function setContentType( string $contentType, mixed $charset = null ): ResponseInterface;
```
Sets the response content-type mime, optionally the charset

```php
$response->setContentType("application/pdf");
$response->setContentType("text/plain", "UTF-8");
```


```php
public function setCookies( CookiesInterface $cookies ): ResponseInterface;
```
Sets a cookies bag for the response externally


```php
public function setDI( DiInterface $container ): void;
```
Sets the dependency injector


```php
public function setEtag( string $etag ): ResponseInterface;
```
Set a custom ETag

```php
$response->setEtag(
    md5(
        time()
    )
);
```


```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```
Sets the events manager


```php
public function setExpires( DateTime $datetime ): ResponseInterface;
```
Sets an Expires header in the response that allows to use the HTTP cache

```php
$this->response->setExpires(
    new DateTime()
);
```


```php
public function setFileToSend( string $filePath, mixed $attachmentName = null, mixed $attachment = bool ): ResponseInterface;
```
Sets an attached file to be sent at the end of the request


```php
public function setHeader( string $name, mixed $value ): ResponseInterface;
```
Overwrites a header in the response

```php
$response->setHeader("Content-Type", "text/plain");
```


```php
public function setHeaders( HeadersInterface $headers ): ResponseInterface;
```
Sets a headers bag for the response externally


```php
public function setJsonContent( mixed $content, int $jsonOptions = int, int $depth = int ): ResponseInterface;
```
Sets HTTP response body. The parameter is automatically converted to JSON and also sets default header: Content-Type: "application/json; charset=UTF-8"

```php
$response->setJsonContent(
    [
        "status" => "OK",
    ]
);
```


```php
public function setLastModified( DateTime $datetime ): ResponseInterface;
```
Sets Last-Modified header

```php
$this->response->setLastModified(
    new DateTime()
);
```


```php
public function setNotModified(): ResponseInterface;
```
Sends a Not-Modified response


```php
public function setRawHeader( string $header ): ResponseInterface;
```
Send a raw header to the response

```php
$response->setRawHeader("HTTP/1.1 404 Not Found");
```


```php
public function setStatusCode( int $code, string $message = null ): ResponseInterface;
```
Sets the HTTP response code

```php
$response->setStatusCode(404, "Not Found");
```




<h1 id="http-response-cookies">Class Phalcon\Http\Response\Cookies</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/Cookies.zep)

| Namespace  | Phalcon\Http\Response | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\Cookie\Exception, Phalcon\Http\Cookie\CookieInterface | | Extends    | AbstractInjectionAware | | Implements | CookiesInterface |

Phalcon\Http\Response\Cookies

This class is a bag to manage the cookies.

A cookies bag is automatically registered as part of the 'response' service in the DI. By default, cookies are automatically encrypted before being sent to the client and are decrypted when retrieved from the user. To set sign key used to generate a message authentication code use `Phalcon\Http\Response\Cookies::setSignKey()`.

```php
use Phalcon\Di\Di;
use Phalcon\Encryption\Crypt;
use Phalcon\Http\Response\Cookies;

$di = new Di();

$di->set(
    'crypt',
    function () {
        $crypt = new Crypt();

        // The `$key' should have been previously generated in a cryptographically safe way.
        $key = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

        $crypt->setKey($key);

        return $crypt;
    }
);

$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        // The `$key' MUST be at least 32 characters long and generated using a
        // cryptographically secure pseudo random generator.
        $key = "#1dj8$=dp?.ak//j1V$~%*0XaK\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

        $cookies->setSignKey($key);

        return $cookies;
    }
);
```


## Properties
```php
/**
 * @var array
 */
protected cookies;

/**
 * @var bool
 */
protected isSent = false;

/**
 * @var bool
 */
protected registered = false;

/**
 * The cookie's sign key.
 * @var string|null
 */
protected signKey;

/**
 * @var bool
 */
protected useEncryption = true;

```

## Methods

```php
public function __construct( bool $useEncryption = bool, string $signKey = null );
```
Phalcon\Http\Response\Cookies constructor


```php
public function delete( string $name ): bool;
```
Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal


```php
public function get( string $name ): CookieInterface;
```
Gets a cookie from the bag


```php
public function getCookies(): array;
```
Gets all cookies from the bag


```php
public function has( string $name ): bool;
```
Check if a cookie is defined in the bag or exists in the _COOKIE superglobal


```php
public function isSent(): bool;
```
Returns if the headers have already been sent


```php
public function isUsingEncryption(): bool;
```
Returns if the bag is automatically encrypting/decrypting cookies


```php
public function reset(): CookiesInterface;
```
Reset set cookies


```php
public function send(): bool;
```
Sends the cookies to the client Cookies aren't sent if headers are sent in the current request


```php
public function set( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] ): CookiesInterface;
```
Sets a cookie to be sent at the end of the request.

This method overrides any cookie set before with the same name.

```php
use Phalcon\Http\Response\Cookies;

$now = new DateTimeImmutable();
$tomorrow = $now->modify('tomorrow');

$cookies = new Cookies();
$cookies->set(
    'remember-me',
    json_encode(['user_id' => 1]),
    (int) $tomorrow->format('U'),
);
```


```php
public function setSignKey( string $signKey = null ): CookiesInterface;
```
Sets the cookie's sign key.

The `$signKey' MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

Use NULL to disable cookie signing.

@see \Phalcon\Security\Random


```php
public function useEncryption( bool $useEncryption ): CookiesInterface;
```
Set if cookies in the bag must be automatically encrypted/decrypted




<h1 id="http-response-cookiesinterface">Interface Phalcon\Http\Response\CookiesInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/CookiesInterface.zep)

| Namespace  | Phalcon\Http\Response | | Uses       | Phalcon\Http\Cookie\CookieInterface |

Phalcon\Http\Response\CookiesInterface

Interface for Phalcon\Http\Response\Cookies


## Methods

```php
public function delete( string $name ): bool;
```
Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal


```php
public function get( string $name ): CookieInterface;
```
Gets a cookie from the bag


```php
public function has( string $name ): bool;
```
Check if a cookie is defined in the bag or exists in the _COOKIE superglobal


```php
public function isUsingEncryption(): bool;
```
Returns if the bag is automatically encrypting/decrypting cookies


```php
public function reset(): CookiesInterface;
```
Reset set cookies


```php
public function send(): bool;
```
Sends the cookies to the client


```php
public function set( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] ): CookiesInterface;
```
Sets a cookie to be sent at the end of the request


```php
public function useEncryption( bool $useEncryption ): CookiesInterface;
```
Set if cookies in the bag must be automatically encrypted/decrypted




<h1 id="http-response-exception">Class Phalcon\Http\Response\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/Exception.zep)

| Namespace  | Phalcon\Http\Response | | Extends    | \Exception |

Phalcon\Http\Response\Exception

Exceptions thrown in Phalcon\Http\Response will use this class.



<h1 id="http-response-headers">Class Phalcon\Http\Response\Headers</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/Headers.zep)

| Namespace  | Phalcon\Http\Response | | Implements | HeadersInterface |

Phalcon\Http\Response\Headers

This class is a bag to manage the response headers


## Properties
```php
/**
 * @var array
 */
protected headers;

/**
 * @var bool
 */
protected isSent = false;

```

## Methods

```php
public function get( string $name ): string | bool;
```
Gets a header value from the internal bag


```php
public function has( string $name ): bool;
```
Checks if a header exists


```php
public function isSent(): bool;
```
Returns if the headers have already been sent


```php
public function remove( string $header ): HeadersInterface;
```
Removes a header by its name


```php
public function reset();
```
Reset set headers


```php
public function send(): bool;
```
Sends the headers to the client


```php
public function set( string $name, string $value ): HeadersInterface;
```
Sets a header to be sent at the end of the request


```php
public function setRaw( string $header ): HeadersInterface;
```
Sets a raw header to be sent at the end of the request


```php
public function toArray(): array;
```
Returns the current headers as an array




<h1 id="http-response-headersinterface">Interface Phalcon\Http\Response\HeadersInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/HeadersInterface.zep)

| Namespace  | Phalcon\Http\Response |

Phalcon\Http\Response\HeadersInterface

Interface for Phalcon\Http\Response\Headers compatible bags


## Methods

```php
public function get( string $name ): string | bool;
```
Gets a header value from the internal bag


```php
public function has( string $name ): bool;
```
Checks if a header exists


```php
public function reset();
```
Reset set headers


```php
public function send(): bool;
```
Sends the headers to the client


```php
public function set( string $name, string $value );
```
Sets a header to be sent at the end of the request


```php
public function setRaw( string $header );
```
Sets a raw header to be sent at the end of the request




<h1 id="http-responseinterface">Interface Phalcon\Http\ResponseInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/ResponseInterface.zep)

| Namespace  | Phalcon\Http | | Uses       | DateTime, Phalcon\Http\Response\HeadersInterface |

Phalcon\Http\Response

Interface for Phalcon\Http\Response


## Methods

```php
public function appendContent( mixed $content ): ResponseInterface;
```
Appends a string to the HTTP response body


```php
public function getContent(): string;
```
Gets the HTTP response body


```php
public function getHeaders(): HeadersInterface;
```
Returns headers set by the user


```php
public function getStatusCode(): int | null;
```
Returns the status code


```php
public function hasHeader( string $name ): bool;
```
Checks if a header exists


```php
public function isSent(): bool;
```
Checks if the response was already sent


```php
public function redirect( mixed $location = null, bool $externalRedirect = bool, int $statusCode = int ): ResponseInterface;
```
Redirect by HTTP to another action or URL


```php
public function resetHeaders(): ResponseInterface;
```
Resets all the established headers


```php
public function send(): ResponseInterface;
```
Prints out HTTP response to the client


```php
public function sendCookies(): ResponseInterface;
```
Sends cookies to the client


```php
public function sendHeaders(): ResponseInterface | bool;
```
Sends headers to the client


```php
public function setContent( string $content ): ResponseInterface;
```
Sets HTTP response body


```php
public function setContentLength( int $contentLength ): ResponseInterface;
```
Sets the response content-length


```php
public function setContentType( string $contentType, mixed $charset = null ): ResponseInterface;
```
Sets the response content-type mime, optionally the charset


```php
public function setExpires( DateTime $datetime ): ResponseInterface;
```
Sets output expire time header


```php
public function setFileToSend( string $filePath, mixed $attachmentName = null ): ResponseInterface;
```
Sets an attached file to be sent at the end of the request


```php
public function setHeader( string $name, mixed $value ): ResponseInterface;
```
Overwrites a header in the response


```php
public function setJsonContent( mixed $content ): ResponseInterface;
```
Sets HTTP response body. The parameter is automatically converted to JSON

```php
$response->setJsonContent(
    [
        "status" => "OK",
    ]
);
```


```php
public function setNotModified(): ResponseInterface;
```
Sends a Not-Modified response


```php
public function setRawHeader( string $header ): ResponseInterface;
```
Send a raw header to the response


```php
public function setStatusCode( int $code, string $message = null ): ResponseInterface;
```
Sets the HTTP response code


