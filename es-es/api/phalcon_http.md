---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Cookie.zep)

| Namespace  | Phalcon\Http | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Encryption\Crypt\CryptInterface, Phalcon\Encryption\Crypt\Mismatch, Phalcon\Filter\FilterInterface, Phalcon\Http\Response\Exception, Phalcon\Http\Cookie\CookieInterface, Phalcon\Http\Cookie\Exception, Phalcon\Session\ManagerInterface | | Extends    | AbstractInjectionAware | | Implements | CookieInterface |

Proporciona envolturas OO para gestionar una cookie HTTP.


## Propiedades
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

## Métodos

```php
public function __construct( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] );
```
Constructor Phalcon\Http\Cookie.


```php
public function __toString(): string;
```
Método mágico __toString convierte el valor de la cookie a cadena


```php
public function delete();
```
Elimina la cookie estableciendo un tiempo de caducidad en el pasado


```php
public function getDomain(): string;
```
Devuelve el dominio para el que la cookie está disponible


```php
public function getExpiration(): string;
```
Devuelve el tiempo de caducidad actual


```php
public function getHttpOnly(): bool;
```
Devuelve si la cookie está accesible sólo mediante el protocolo HTTP


```php
public function getName(): string;
```
Devuelve el nombre actual de la cookie


```php
public function getOptions(): array;
```
Devuelve las opciones actuales de la cookie


```php
public function getPath(): string;
```
Devuelve la ruta actual de la cookie


```php
public function getSecure(): bool;
```
Devuelve si la cookie debe ser enviada solo cuando la conexión es segura (HTTPS)


```php
public function getValue( mixed $filters = null, mixed $defaultValue = null ): mixed;
```
Devuelve el valor de la cookie.


```php
public function isUsingEncryption(): bool;
```
Comprueba si la cookie está usando encriptación implícita


```php
public function restore(): CookieInterface;
```
Lee la información relacionada con las cookie desde la SESSION para restaurar la cookie tal como fue configurada.

Este método se llama de forma automática internamente, por lo que normalmente no necesita llamarlo.


```php
public function send(): CookieInterface;
```
Envía la cookie al cliente HTTP.

Almacena la definición de la cookie en sesión.


```php
public function setDomain( string $domain ): CookieInterface;
```
Establece el dominio para el que está disponible la cookie


```php
public function setExpiration( int $expire ): CookieInterface;
```
Establece el tiempo de caducidad de la cookie


```php
public function setHttpOnly( bool $httpOnly ): CookieInterface;
```
Establece si la cookie está accesible sólo mediante el protocolo HTTP


```php
public function setOptions( array $options ): CookieInterface;
```
Establece las opciones de la cookie


```php
public function setPath( string $path ): CookieInterface;
```
Establece la ruta de la cookie


```php
public function setSecure( bool $secure ): CookieInterface;
```
Establece si la cookie se debe enviar solo cuando la conexión es segura (HTTPS)


```php
public function setSignKey( string $signKey = null ): CookieInterface;
```
Establece la clave de firma de la cookie.

`$signKey' DEBE tener al menos 32 caracteres de longitud y generarse usando un generador pseudoaleatorio seguro criptográficamente.

Use NULL para deshabilitar la firma de cookies.

@see \Phalcon\Security\Random @throws \Phalcon\Http\Cookie\Exception


```php
public function setValue( mixed $value ): CookieInterface;
```
Establece el valor de la cookie


```php
public function useEncryption( bool $useEncryption ): CookieInterface;
```
Establece si la cookie se debe encriptar/desencriptar automáticamente


```php
protected function assertSignKeyIsLongEnough( string $signKey ): void;
```
Afirma que la clave de la cookie es suficientemente larga.

@throws \Phalcon\Http\Cookie\Exception




<h1 id="http-cookie-cookieinterface">Interface Phalcon\Http\Cookie\CookieInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Cookie/CookieInterface.zep)

| Namespace  | Phalcon\Http\Cookie |

Interfaz para Phalcon\Http\Cookie


## Métodos

```php
public function delete();
```
Elimina la cookie


```php
public function getDomain(): string;
```
Devuelve el dominio para el que la cookie está disponible


```php
public function getExpiration(): string;
```
Devuelve el tiempo de caducidad actual


```php
public function getHttpOnly(): bool;
```
Devuelve si la cookie está accesible sólo mediante el protocolo HTTP


```php
public function getName(): string;
```
Devuelve el nombre actual de la cookie


```php
public function getOptions(): array;
```
Devuelve las opciones actuales de la cookie


```php
public function getPath(): string;
```
Devuelve la ruta actual de la cookie


```php
public function getSecure(): bool;
```
Devuelve si la cookie debe ser enviada solo cuando la conexión es segura (HTTPS)


```php
public function getValue( mixed $filters = null, mixed $defaultValue = null ): mixed;
```
Devuelve el valor de la cookie.


```php
public function isUsingEncryption(): bool;
```
Comprueba si la cookie está usando encriptación implícita


```php
public function send(): CookieInterface;
```
Envía la cookie al cliente HTTP


```php
public function setDomain( string $domain ): CookieInterface;
```
Establece el dominio para el que está disponible la cookie


```php
public function setExpiration( int $expire ): CookieInterface;
```
Establece el tiempo de caducidad de la cookie


```php
public function setHttpOnly( bool $httpOnly ): CookieInterface;
```
Establece si la cookie está accesible sólo mediante el protocolo HTTP


```php
public function setOptions( array $options ): CookieInterface;
```
Establece las opciones de la cookie


```php
public function setPath( string $path ): CookieInterface;
```
Establece el tiempo de caducidad de la cookie


```php
public function setSecure( bool $secure ): CookieInterface;
```
Establece si la cookie se debe enviar solo cuando la conexión es segura (HTTPS)


```php
public function setValue( mixed $value ): CookieInterface;
```
Establece el valor de la cookie


```php
public function useEncryption( bool $useEncryption ): CookieInterface;
```
Establece si la cookie se debe encriptar/desencriptar automáticamente




<h1 id="http-cookie-exception">Class Phalcon\Http\Cookie\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Cookie/Exception.zep)

| Namespace  | Phalcon\Http\Cookie | | Extends    | \Exception |

Phalcon\Http\Cookie\Exception

Las excepciones lanzadas en Phalcon\Http\Cookie usarán esta clase.



<h1 id="http-message-requestmethodinterface">Interface Phalcon\Http\Message\RequestMethodInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Message/RequestMethodInterface.zep)

| Namespace  | Phalcon\Http\Message |

Interface for Request methods

Implementation of this file has been influenced by PHP FIG @link    https://github.com/php-fig/http-message-util/ @license https://github.com/php-fig/http-message-util/blob/master/LICENSE


## Constantes
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Message/ResponseStatusCodeInterface.zep)

| Namespace  | Phalcon\Http\Message |

Interface for Request methods

Implementation of this file has been influenced by PHP FIG @link    https://github.com/php-fig/http-message-util/ @license https://github.com/php-fig/http-message-util/blob/master/LICENSE

Defines constants for common HTTP status code.

@see https://tools.ietf.org/html/rfc2295#section-8.1 @see https://tools.ietf.org/html/rfc2324#section-2.3 @see https://tools.ietf.org/html/rfc2518#section-9.7 @see https://tools.ietf.org/html/rfc2774#section-7 @see https://tools.ietf.org/html/rfc3229#section-10.4 @see https://tools.ietf.org/html/rfc4918#section-11 @see https://tools.ietf.org/html/rfc5842#section-7.1 @see https://tools.ietf.org/html/rfc5842#section-7.2 @see https://tools.ietf.org/html/rfc6585#section-3 @see https://tools.ietf.org/html/rfc6585#section-4 @see https://tools.ietf.org/html/rfc6585#section-5 @see https://tools.ietf.org/html/rfc6585#section-6 @see https://tools.ietf.org/html/rfc7231#section-6 @see https://tools.ietf.org/html/rfc7238#section-3 @see https://tools.ietf.org/html/rfc7725#section-3 @see https://tools.ietf.org/html/rfc7540#section-9.1.2 @see https://tools.ietf.org/html/rfc8297#section-2 @see https://tools.ietf.org/html/rfc8470#section-7


## Constantes
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request.zep)

| Namespace  | Phalcon\Http | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface, Phalcon\Http\Message\RequestMethodInterface, Phalcon\Http\Request\File, Phalcon\Http\Request\FileInterface, Phalcon\Http\Request\Exception, UnexpectedValueException, stdClass | | Extends    | AbstractInjectionAware | | Implements | RequestInterface, RequestMethodInterface |

Encapsula la información de la solicitud para un acceso fácil y seguro desde los controladores de la aplicación.

El objeto de solicitud es un objeto de valor simple que se pasa entre las clases del despachador y controlador. Empaqueta el entorno de solicitud HTTP.

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


## Propiedades
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

## Métodos

```php
public function get( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable del superglobal $_REQUEST aplicando filtros si es necesario. Si no se pasan parámetros se devuelve el superglobal $_REQUEST

```php
// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```


```php
public function getAcceptableContent(): array;
```
Obtiene un vector con tipos mime y su calidad aceptada por el navegador/cliente desde _SERVER["HTTP_ACCEPT"]


```php
public function getBasicAuth(): array | null;
```
Obtiene información de autenticación aceptada por el navegador/cliente desde $_SERVER["PHP_AUTH_USER"]


```php
public function getBestAccept(): string;
```
Obtiene el mejor tipo mime aceptado por el navegador/cliente desde _SERVER["HTTP_ACCEPT"]


```php
public function getBestCharset(): string;
```
Obtiene el mejor conjunto de caracteres aceptado por el navegador/cliente desde _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getBestLanguage(): string;
```
Obtiene el mejor idioma aceptado por el navegador/cliente desde _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
public function getClientAddress( bool $trustForwardedHeader = bool ): string | bool;
```
Obtiene la mayoría posible de direcciones IPv4 de clientes. Este método busca en `$_SERVER["REMOTE_ADDR"]` y opcionalmente en `$_SERVER["HTTP_X_FORWARDED_FOR"]`


```php
public function getClientCharsets(): array;
```
Obtiene un vector del conjunto de caracteres y su calidad aceptada por el navegador/cliente desde _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getContentType(): string | null;
```
Obtiene el tipo de contenido en el que se hizo la solicitud


```php
public function getDigestAuth(): array;
```
Obtiene información de autenticación aceptada por el navegador/cliente desde $_SERVER["PHP_AUTH_DIGEST"]


```php
public function getFilteredPost( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene un valor `post` siempre saneado con los filtros preestablecidos


```php
public function getFilteredPut( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene un valor `put` siempre saneado con los filtros preestablecidos


```php
public function getFilteredQuery( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una valor de consulta o `get` siempre saneado con los filtros preestablecidos


```php
public function getHTTPReferer(): string;
```
Obtiene la página web de referencia en la petición activa. ie: http://www.google.com


```php
final public function getHeader( string $header ): string;
```
Obtiene la cabecera HTTP de los datos de la solicitud


```php
public function getHeaders(): array;
```
Devuelve las cabeceras disponibles en la petición

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
Obtiene el nombre de servidor usado por la petición.

`Request::getHttpHost` intenta encontrar el nombre del servidor en el siguiente orden:

- `$_SERVER["HTTP_HOST"]`
- `$_SERVER["SERVER_NAME"]`
- `$_SERVER["SERVER_ADDR"]`

Opcionalmente `Request::getHttpHost` valida y limpia el nombre del servidor. Se puede usar `Request::$strictHostCheck` para validar el nombre del servidor.

Nota: la validación y limpieza pueden tener un impacto negativo en el rendimiento porque usan expresiones regulares.

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
Obtiene el cuerpo de la petición HTTP sin procesar decodificado en JSON


```php
public function getLanguages(): array;
```
Obtiene el vector de idiomas y su calidad aceptada por el navegador/cliente desde _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
final public function getMethod(): string;
```
Obtiene el método HTTP en el que se ha hecho la petición

Si se establece la cabecera X-HTTP-Method-Override, y el método es POST, entonces se usa para determinar el método HTTP previsto "real".

El parámetro de petición _method también se puede usar para determinar el método HTTP, pero sólo si se ha llamado a setHttpMethodParameterOverride(true).

El método siempre es una cadena en mayúscula.


```php
public function getPort(): int;
```
Obtiene información sobre el puerto en el cual se realizó la solicitud.


```php
public function getPost( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable del superglobal $_POST aplicando filtros si es necesario. Si no se proporcionan parámetros se devuelve el superglobal $_POST

```php
// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");
```


```php
public function getPreferredIsoLocaleVariant(): string;
```
Obtiene la variante de configuración regional ISO preferida.

Obtiene la variante de configuración regional preferida aceptada por el cliente desde la cabecera HTTP de la solicitud "Accept-Language" y devuelve parte de su base, ej. `en` en vez de `en-US`.

Nota: Este método depende de la cabecera `$_SERVER["HTTP_ACCEPT_LANGUAGE"]`.

@link https://www.iso.org/standard/50707.html


```php
public function getPut( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable de la solicitud `put`

```php
// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");
```


```php
public function getQuery( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable del superglobal $_GET aplicando filtros si es necesario. Si no se proporcionan parámetros se devuelve el superglobal $_GET

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
Obtiene el cuerpo de solicitud HTTP sin procesar


```php
public function getScheme(): string;
```
Obtiene el esquema HTTP (http/https)


```php
public function getServer( string $name ): string | null;
```
Obtiene una variable del superglobal $_SERVER


```php
public function getServerAddress(): string;
```
Obtiene la IP de la dirección del servidor activo


```php
public function getServerName(): string;
```
Obtiene el nombre del servidor activo


```php
final public function getURI( bool $onlyPath = bool ): string;
```
Obtiene el HTTP URI en el cual se hizo la solicitud

```php
// Returns /some/path?with=queryParams
$uri = $request->getURI();

// Returns /some/path
$uri = $request->getURI(true);
```


```php
public function getUploadedFiles( bool $onlySuccessful = bool, bool $namedKeys = bool ): FileInterface[];
```
Obtiene los archivos adjuntos como instancias Phalcon\Http\Request\File


```php
public function getUserAgent(): string;
```
Obtiene el agente de usuario HTTP utilizado para hacer la solicitud


```php
public function has( string $name ): bool;
```
Comprueba si el superglobal $_REQUEST tiene un determinado índice


```php
public function hasFiles(): bool;
```
Devuelve si la solicitud tiene archivos o no


```php
final public function hasHeader( string $header ): bool;
```
Comprueba si las cabeceras tienen un cierto índice


```php
public function hasPost( string $name ): bool;
```
Comprueba si el superglobal $_POST tiene un cierto índice


```php
public function hasPut( string $name ): bool;
```
Comprueba si los datos PUT tienen un cierto índice


```php
public function hasQuery( string $name ): bool;
```
Comprueba si el superglobal $_GET tiene un cierto índice


```php
final public function hasServer( string $name ): bool;
```
Comprueba si el superglobal $_SERVER tiene un cierto índice


```php
public function isAjax(): bool;
```
Comprueba si la petición se ha hecho usando ajax


```php
public function isConnect(): bool;
```
Comprueba si el método HTTP es CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"


```php
public function isDelete(): bool;
```
Comprueba si el método HTTP es DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"


```php
public function isGet(): bool;
```
Comprueba si el método HTTP es GET. if _SERVER["REQUEST_METHOD"]==="GET"


```php
public function isHead(): bool;
```
Comprueba si el método HTTP es HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"


```php
public function isMethod( mixed $methods, bool $strict = bool ): bool;
```
Comprueba si el método HTTP coincide con cualquiera de los métodos pasados. Cuando `strict` es `true` comprueba si los métodos validados son métodos HTTP reales


```php
public function isOptions(): bool;
```
Comprueba si el método HTTP es OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"


```php
public function isPatch(): bool;
```
Comprueba si el método HTTP es PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"


```php
public function isPost(): bool;
```
Comprueba si el método HTTP es POST. if _SERVER["REQUEST_METHOD"]==="POST"


```php
public function isPurge(): bool;
```
Comprueba si el método HTTP es PURGE (soporte Squid y Varnish). if _SERVER["REQUEST_METHOD"]==="PURGE"


```php
public function isPut(): bool;
```
Comprueba si el método HTTP es PUT. if _SERVER["REQUEST_METHOD"]==="PUT"


```php
public function isSecure(): bool;
```
Comprueba si la petición se ha hecho usando alguna capa segura


```php
public function isSoap(): bool;
```
Comprueba si la petición se ha hecho usando SOAP


```php
public function isStrictHostCheck(): bool;
```
Comprueba si el método `Request::getHttpHost` usará validación estricta del nombre del servidor o no


```php
public function isTrace(): bool;
```
Comprueba si el método HTTP es TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"


```php
public function isValidHttpMethod( string $method ): bool;
```
Comprueba si un método es un método HTTP válido


```php
public function numFiles( bool $onlySuccessful = bool ): long;
```
Devuelve el número de archivos disponibles


```php
public function setHttpMethodParameterOverride( bool $httpMethodParameterOverride )
```

```php
public function setParameterFilters( string $name, array $filters = [], array $scope = [] ): RequestInterface;
```
Establece saneadores/filtros automáticos para un campo particular y para métodos particulares


```php
public function setStrictHostCheck( bool $flag = bool ): RequestInterface;
```
Establece si el método `Request::getHttpHost` debe usar validación estricta del nombre de servidor o no


```php
final protected function getBestQuality( array $qualityParts, string $name ): string;
```
Procesa una cabecera de solicitud y devuelve la de mejor calidad


```php
final protected function getHelper( array $source, string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Ayudante para obtener datos de los superglobales, aplicando filtros si es necesario. Si no se dan parámetros se devuelve el superglobal.


```php
final protected function getQualityHeader( string $serverIndex, string $name ): array;
```
Procesa una cabecera de petición y devuelve un vector de valores con sus calidades


```php
final protected function hasFileHelper( mixed $data, bool $onlySuccessful ): long;
```
Cuenta recursivamente ficheros en un vector de ficheros


```php
protected function resolveAuthorizationHeaders(): array;
```
Resuelve cabeceras de autorización.


```php
final protected function smoothFiles( array $names, array $types, array $tmp_names, array $sizes, array $errors, string $prefix ): array;
```
Simplifica $_FILES para tener un vector simple con todos los ficheros subidos




<h1 id="http-request-exception">Class Phalcon\Http\Request\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request/Exception.zep)

| Namespace  | Phalcon\Http\Request | | Extends    | \Exception |

Phalcon\Http\Request\Exception

Las excepciones lanzadas en Phalcon\Http\Request usarán esta clase



<h1 id="http-request-file">Class Phalcon\Http\Request\File</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request/File.zep)

| Namespace  | Phalcon\Http\Request | | Implements | FileInterface |

Phalcon\Http\Request\File

Provee envolturas OO al superglobal $_FILES

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


## Propiedades
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

## Métodos

```php
public function __construct( array $file, mixed $key = null );
```
Constructor Phalcon\Http\Request\File


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
Devuelve el nombre real del fichero subido


```php
public function getRealType(): string;
```
Obtiene el tipo mime real del fichero subido usando finfo


```php
public function getSize(): int;
```
Devuelve el tamaño de fichero del fichero subido


```php
public function getTempName(): string;
```
Devuelve el nombre temporal del fichero subido


```php
public function getType(): string;
```
Devuelve el tipo mime notificado por el navegador. Este tipo mime no es completamente seguro, use getRealType() en su lugar


```php
public function isUploadedFile(): bool;
```
Comprueba si el fichero se ha subido mediante Post.


```php
public function moveTo( string $destination ): bool;
```
Mueve el fichero temporal a una ubicación dentro de la aplicación




<h1 id="http-request-fileinterface">Interface Phalcon\Http\Request\FileInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Request/FileInterface.zep)

| Namespace  | Phalcon\Http\Request |

Phalcon\Http\Request\FileInterface

Interfaz para Phalcon\Http\Request\File



## Métodos

```php
public function getError(): string | null;
```
Devuelve el error, si lo hay


```php
public function getName(): string;
```
Devuelve el nombre real del fichero subido


```php
public function getRealType(): string;
```
Obtiene el tipo mime real del fichero subido usando finfo


```php
public function getSize(): int;
```
Devuelve el tamaño de fichero del fichero subido


```php
public function getTempName(): string;
```
Devuelve el nombre temporal del fichero subido


```php
public function getType(): string;
```
Devuelve el tipo mime notificado por el navegador. Este tipo mime no es completamente seguro, use getRealType() en su lugar


```php
public function moveTo( string $destination ): bool;
```
Mueve el fichero temporal a una ubicación




<h1 id="http-requestinterface">Interface Phalcon\Http\RequestInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/RequestInterface.zep)

| Namespace  | Phalcon\Http | | Uses       | Phalcon\Http\Request\FileInterface, stdClass |

Interfaz para Phalcon\Http\Request


## Métodos

```php
public function get( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable del superglobal $_REQUEST aplicando filtros si es necesario. Si no se pasan parámetros se devuelve el superglobal $_REQUEST

```php
// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```


```php
public function getAcceptableContent(): array;
```
Obtiene un vector con tipos mime y su calidad aceptada por el navegador/cliente desde _SERVER["HTTP_ACCEPT"]


```php
public function getBasicAuth(): array | null;
```
Obtiene información de autenticación aceptada por el navegador/cliente desde $_SERVER["PHP_AUTH_USER"]


```php
public function getBestAccept(): string;
```
Obtiene el mejor tipo mime aceptado por el navegador/cliente desde _SERVER["HTTP_ACCEPT"]


```php
public function getBestCharset(): string;
```
Obtiene el mejor conjunto de caracteres aceptado por el navegador/cliente desde _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getBestLanguage(): string;
```
Obtiene el mejor idioma aceptado por el navegador/cliente desde _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
public function getClientAddress( bool $trustForwardedHeader = bool ): string | bool;
```
Obtiene la mayoría posible de direcciones IPv4 de clientes. Este método busca en $_SERVER["REMOTE_ADDR"] y opcionalmente en $_SERVER["HTTP_X_FORWARDED_FOR"]


```php
public function getClientCharsets(): array;
```
Obtiene un vector del conjunto de caracteres y su calidad aceptada por el navegador/cliente desde _SERVER["HTTP_ACCEPT_CHARSET"]


```php
public function getContentType(): string | null;
```
Obtiene el tipo de contenido en el que se hizo la solicitud


```php
public function getDigestAuth(): array;
```
Obtiene información de autenticación aceptada por el navegador/cliente desde $_SERVER["PHP_AUTH_DIGEST"]


```php
public function getHTTPReferer(): string;
```
Obtiene la página web de referencia en la petición activa. ie: http://www.google.com


```php
public function getHeader( string $header ): string;
```
Obtiene la cabecera HTTP de los datos de la solicitud


```php
public function getHeaders(): array;
```
Devuelve las cabeceras disponibles en la petición

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
Obtiene el nombre de servidor usado por la petición.

`Request::getHttpHost` intenta encontrar el nombre del servidor en el siguiente orden:

- `$_SERVER["HTTP_HOST"]`
- `$_SERVER["SERVER_NAME"]`
- `$_SERVER["SERVER_ADDR"]`

Opcionalmente `Request::getHttpHost` valida y limpia el nombre del servidor. `Request::$_strictHostCheck` se puede usar para validar el nombre de servidor.

Nota: la validación y limpieza pueden tener un impacto negativo en el rendimiento porque usan expresiones regulares.

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
Obtiene el cuerpo de la petición HTTP sin procesar decodificado en JSON


```php
public function getLanguages(): array;
```
Obtiene el vector de idiomas y su calidad aceptada por el navegador/cliente desde _SERVER["HTTP_ACCEPT_LANGUAGE"]


```php
public function getMethod(): string;
```
Obtiene el método HTTP en el que se ha hecho la petición

Si se establece la cabecera X-HTTP-Method-Override, y el método es POST, entonces se usa para determinar el método HTTP previsto "real".

El parámetro de petición _method también se puede usar para determinar el método HTTP, pero sólo si se ha llamado a setHttpMethodParameterOverride(true).

El método siempre es una cadena en mayúscula.


```php
public function getPort(): int;
```
Obtiene información sobre el puerto en el que se ha hecho la petición


```php
public function getPost( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable del superglobal $_POST aplicando filtros si es necesario. Si no se proporcionan parámetros se devuelve el superglobal $_POST

```php
// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");
```


```php
public function getPut( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable de la solicitud `put`

```php
// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");
```


```php
public function getQuery( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```
Obtiene una variable del superglobal $_GET aplicando filtros si es necesario. Si no se proporcionan parámetros se devuelve el superglobal $_GET

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
Obtiene el cuerpo de solicitud HTTP sin procesar


```php
public function getScheme(): string;
```
Obtiene el esquema HTTP (http/https)


```php
public function getServer( string $name ): string | null;
```
Obtiene una variable del superglobal $_SERVER


```php
public function getServerAddress(): string;
```
Obtiene la IP de la dirección del servidor activo


```php
public function getServerName(): string;
```
Obtiene el nombre del servidor activo


```php
public function getURI( bool $onlyPath = bool ): string;
```
Obtiene el HTTP URI en el cual se hizo la solicitud

```php
// Returns /some/path?with=queryParams
$uri = $request->getURI();

// Returns /some/path
$uri = $request->getURI(true);
```


```php
public function getUploadedFiles( bool $onlySuccessful = bool, bool $namedKeys = bool ): FileInterface[];
```
Obtiene los archivos adjuntos como instancias compatibles con Phalcon\Http\Request\FileInterface


```php
public function getUserAgent(): string;
```
Obtiene el agente de usuario HTTP utilizado para hacer la solicitud


```php
public function has( string $name ): bool;
```
Comprueba si el superglobal $_REQUEST tiene un determinado índice


```php
public function hasFiles(): bool;
```
Comprueba si la petición incluye ficheros adjuntos


```php
public function hasHeader( string $header ): bool;
```
Comprueba si las cabeceras tienen un cierto índice


```php
public function hasPost( string $name ): bool;
```
Comprueba si el superglobal $_POST tiene un cierto índice


```php
public function hasPut( string $name ): bool;
```
Comprueba si los datos PUT tienen un cierto índice


```php
public function hasQuery( string $name ): bool;
```
Comprueba si el superglobal $_GET tiene un cierto índice


```php
public function hasServer( string $name ): bool;
```
Comprueba si el superglobal $_SERVER tiene un cierto índice


```php
public function isAjax(): bool;
```
Comprueba si la petición se ha hecho usando ajax. Comprueba si $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest"


```php
public function isConnect(): bool;
```
Comprueba si el método HTTP es CONNECT. if $_SERVER["REQUEST_METHOD"] === "CONNECT"


```php
public function isDelete(): bool;
```
Comprueba si el método HTTP es DELETE. if $_SERVER["REQUEST_METHOD"] === "DELETE"


```php
public function isGet(): bool;
```
Comprueba si el método HTTP es GET. if $_SERVER["REQUEST_METHOD"] === "GET"


```php
public function isHead(): bool;
```
Comprueba si el método HTTP es HEAD. if $_SERVER["REQUEST_METHOD"] === "HEAD"


```php
public function isMethod( mixed $methods, bool $strict = bool ): bool;
```
Comprueba si el método HTTP coincide con alguno de los métodos pasados


```php
public function isOptions(): bool;
```
Comprueba si el método HTTP es OPTIONS. if $_SERVER["REQUEST_METHOD"] === "OPTIONS"


```php
public function isPost(): bool;
```
Comprueba si el método HTTP es POST. if $_SERVER["REQUEST_METHOD"] === "POST"


```php
public function isPurge(): bool;
```
Comprueba si el método HTTP es PURGE (soporte Squid y Varnish). if $_SERVER["REQUEST_METHOD"] === "PURGE"


```php
public function isPut(): bool;
```
Comprueba si el método HTTP es PUT. if $_SERVER["REQUEST_METHOD"] === "PUT"


```php
public function isSecure(): bool;
```
Comprueba si la petición se ha hecho usando alguna capa segura


```php
public function isSoap(): bool;
```
Comprueba si la petición se ha hecho usando SOAP


```php
public function isTrace(): bool;
```
Comprueba si el método HTTP es TRACE. if $_SERVER["REQUEST_METHOD"] === "TRACE"


```php
public function numFiles( bool $onlySuccessful = bool ): long;
```
Devuelve el número de archivos disponibles




<h1 id="http-response">Class Phalcon\Http\Response</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response.zep)

| Namespace  | Phalcon\Http | | Uses       | DateTime, DateTimeZone, InvalidArgumentException, Phalcon\Di\Di, Phalcon\Di\DiInterface, Phalcon\Http\Message\ResponseStatusCodeInterface, Phalcon\Http\Response\Exception, Phalcon\Http\Response\HeadersInterface, Phalcon\Http\Response\CookiesInterface, Phalcon\Mvc\Url\UrlInterface, Phalcon\Mvc\ViewInterface, Phalcon\Http\Response\Headers, Phalcon\Di\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Implements | ResponseInterface, InjectionAwareInterface, EventsAwareInterface, ResponseStatusCodeInterface |

Parte del ciclo HTTP es devolver respuestas a los clientes. Phalcon\HTTP\Response es el componente Phalcon responsable de realizar esta tarea. Las respuestas HTTP suelen estar compuestas por cabeceras y cuerpo.

```php
$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();
```


## Propiedades
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

## Métodos

```php
public function __construct( string $content = null, mixed $code = null, mixed $status = null );
```
Constructor Phalcon\Http\Response


```php
public function appendContent( mixed $content ): ResponseInterface;
```
Añade una cadena al cuerpo de respuesta HTTP


```php
public function getContent(): string;
```
Obtiene el cuerpo de la respuesta HTTP


```php
public function getCookies(): CookiesInterface;
```
Devuelve las cookies establecidas por el usuario


```php
public function getDI(): DiInterface;
```
Devuelve el inyector de dependencias interno


```php
public function getEventsManager(): ManagerInterface | null;
```
Devuelve el administrador de eventos interno


```php
public function getHeaders(): HeadersInterface;
```
Devuelve las cabeceras establecidas por el usuario


```php
public function getReasonPhrase(): string | null;
```
Devuelve la frase de razón

```php
echo $response->getReasonPhrase();
```


```php
public function getStatusCode(): int | null;
```
Devuelve el código de estado

```php
echo $response->getStatusCode();
```


```php
public function hasHeader( string $name ): bool;
```
Comprueba si existe una cabecera

```php
$response->hasHeader("Content-Type");
```


```php
public function isSent(): bool;
```
Comprueba si la respuesta ya se ha enviado


```php
public function redirect( mixed $location = null, bool $externalRedirect = bool, int $statusCode = int ): ResponseInterface;
```
Redirige por HTTP a otra acción o URL

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
Elimina una cabecera en la respuesta

```php
$response->removeHeader("Expires");
```


```php
public function resetHeaders(): ResponseInterface;
```
Resetea todas las cabeceras establecidas


```php
public function send(): ResponseInterface;
```
Muestra la respuesta HTTP al cliente


```php
public function sendCookies(): ResponseInterface;
```
Envía las cookies al cliente


```php
public function sendHeaders(): ResponseInterface | bool;
```
Envía las cabeceras al cliente


```php
public function setCache( int $minutes ): ResponseInterface;
```
Establece las cabeceras de caché para usar la caché HTTP

```php
$this->response->setCache(60);
```


```php
public function setContent( string $content ): ResponseInterface;
```
Establece el cuerpo de respuesta HTTP

```php
$response->setContent("<h1>Hello!</h1>");
```


```php
public function setContentLength( int $contentLength ): ResponseInterface;
```
Establece la longitud del contenido de la respuesta

```php
$response->setContentLength(2048);
```


```php
public function setContentType( string $contentType, mixed $charset = null ): ResponseInterface;
```
Establece el tipo mime del contenido de la respuesta, opcionalmente el conjunto de caracteres

```php
$response->setContentType("application/pdf");
$response->setContentType("text/plain", "UTF-8");
```


```php
public function setCookies( CookiesInterface $cookies ): ResponseInterface;
```
Establece externamente una bolsa de cookies para la respuesta


```php
public function setDI( DiInterface $container ): void;
```
Configura el inyector de dependencia


```php
public function setEtag( string $etag ): ResponseInterface;
```
Establece un ETag personalizado

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
Establece el administrador de eventos


```php
public function setExpires( DateTime $datetime ): ResponseInterface;
```
Establece una cabecera `Expires` en la respuesta que permite usar el caché HTTP

```php
$this->response->setExpires(
    new DateTime()
);
```


```php
public function setFileToSend( string $filePath, mixed $attachmentName = null, mixed $attachment = bool ): ResponseInterface;
```
Establece un fichero adjunto a enviar al final de la petición


```php
public function setHeader( string $name, mixed $value ): ResponseInterface;
```
Sobreescribe una cabecera en la respuesta

```php
$response->setHeader("Content-Type", "text/plain");
```


```php
public function setHeaders( HeadersInterface $headers ): ResponseInterface;
```
Establece externamente una bolsa de cabeceras para la respuesta


```php
public function setJsonContent( mixed $content, int $jsonOptions = int, int $depth = int ): ResponseInterface;
```
Establece el cuerpo de respuesta HTTP. El parámetro se convierte automáticamente a JSON y también establece la cabecera predeterminada: Content-Type: "application/json; charset=UTF-8"

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
Establece la cabecera Last-Modified

```php
$this->response->setLastModified(
    new DateTime()
);
```


```php
public function setNotModified(): ResponseInterface;
```
Envía una respuesta Not-Modified


```php
public function setRawHeader( string $header ): ResponseInterface;
```
Envía una cabecera en bruto a la respuesta

```php
$response->setRawHeader("HTTP/1.1 404 Not Found");
```


```php
public function setStatusCode( int $code, string $message = null ): ResponseInterface;
```
Establece el código de respuesta HTTP

```php
$response->setStatusCode(404, "Not Found");
```




<h1 id="http-response-cookies">Class Phalcon\Http\Response\Cookies</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/Cookies.zep)

| Namespace  | Phalcon\Http\Response | | Uses       | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\Cookie\Exception, Phalcon\Http\Cookie\CookieInterface | | Extends    | AbstractInjectionAware | | Implements | CookiesInterface |

Phalcon\Http\Response\Cookies

Esta clase es una bolsa para gestionar las cookies.

Una bolsa de cookies se registra automáticamente como parte del servicio 'response' en el DI. Por defecto, las cookies automáticamente se encriptan antes de enviarse al cliente y son desencriptadas cuando se recuperan desde el usuario. Para establecer la clave de firma a usar para generar un código de autenticación de mensaje use `Phalcon\Http\Response\Cookies::setSignKey()`.

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


## Propiedades
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

## Métodos

```php
public function __construct( bool $useEncryption = bool, string $signKey = null );
```
Constructor Phalcon\Http\Response\Cookies


```php
public function delete( string $name ): bool;
```
Elimina una cookie por su nombre Este método no elimina las cookies del superglobal _COOKIE


```php
public function get( string $name ): CookieInterface;
```
Obtiene una cookie de la bolsa


```php
public function getCookies(): array;
```
Obtiene todas las cookies de la bolsa


```php
public function has( string $name ): bool;
```
Comprueba si una cookie está definida en la bolsa o existe en el superglobal _COOKIE


```php
public function isSent(): bool;
```
Returns if the headers have already been sent


```php
public function isUsingEncryption(): bool;
```
Devuelve si la bolsa está encriptando/desencriptando cookies automáticamente


```php
public function reset(): CookiesInterface;
```
Resetea las cookies establecidas


```php
public function send(): bool;
```
Envía las cookies al cliente Las cookies no se envían si ya se han enviado las cabeceras en la petición actual


```php
public function set( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] ): CookiesInterface;
```
Establece una cookie a enviar al final de la petición.

Este método sobreescribe cualquier cookie establecida antes con el mismo nombre.

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
Establece la clave de firma de la cookie.

`$signKey' DEBE tener al menos 32 caracteres de longitud y generarse usando un generador pseudoaleatorio seguro criptográficamente.

Use NULL para deshabilitar la firma de cookies.

@see \Phalcon\Security\Random


```php
public function useEncryption( bool $useEncryption ): CookiesInterface;
```
Establece si las cookies de la bolsa se deben encriptar/desencriptar automáticamente




<h1 id="http-response-cookiesinterface">Interface Phalcon\Http\Response\CookiesInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/CookiesInterface.zep)

| Namespace  | Phalcon\Http\Response | | Uses       | Phalcon\Http\Cookie\CookieInterface |

Phalcon\Http\Response\CookiesInterface

Interfaz para Phalcon\Http\Response\Cookies


## Métodos

```php
public function delete( string $name ): bool;
```
Elimina una cookie por su nombre Este método no elimina las cookies del superglobal _COOKIE


```php
public function get( string $name ): CookieInterface;
```
Obtiene una cookie de la bolsa


```php
public function has( string $name ): bool;
```
Comprueba si una cookie está definida en la bolsa o existe en el superglobal _COOKIE


```php
public function isUsingEncryption(): bool;
```
Devuelve si la bolsa está encriptando/desencriptando cookies automáticamente


```php
public function reset(): CookiesInterface;
```
Resetea las cookies establecidas


```php
public function send(): bool;
```
Envía las cookies al cliente


```php
public function set( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] ): CookiesInterface;
```
Establece una cookie para ser enviada al final de la petición


```php
public function useEncryption( bool $useEncryption ): CookiesInterface;
```
Establece si las cookies de la bolsa se deben encriptar/desencriptar automáticamente




<h1 id="http-response-exception">Class Phalcon\Http\Response\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/Exception.zep)

| Namespace  | Phalcon\Http\Response | | Extends    | \Exception |

Phalcon\Http\Response\Exception

Las excepciones lanzadas en Phalcon\Http\Response usarán esta clase.



<h1 id="http-response-headers">Class Phalcon\Http\Response\Headers</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/Headers.zep)

| Namespace  | Phalcon\Http\Response | | Implements | HeadersInterface |

Phalcon\Http\Response\Headers

Esta clase es una bolsa para gestionar las cabeceras de la respuesta


## Propiedades
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

## Métodos

```php
public function get( string $name ): string | bool;
```
Obtiene un valor de cabecera desde la bolsa interna


```php
public function has( string $name ): bool;
```
Comprueba si existe una cabecera


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
Resetea las cabeceras establecidas


```php
public function send(): bool;
```
Envía las cabeceras al cliente


```php
public function set( string $name, string $value ): HeadersInterface;
```
Establece una cabecera para enviar al final de la petición


```php
public function setRaw( string $header ): HeadersInterface;
```
Establece una cabecera en bruto para enviar al final de la petición


```php
public function toArray(): array;
```
Devuelve las cabeceras actuales como un vector




<h1 id="http-response-headersinterface">Interface Phalcon\Http\Response\HeadersInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/Response/HeadersInterface.zep)

| Namespace  | Phalcon\Http\Response |

Phalcon\Http\Response\HeadersInterface

Interfaz para bolsas compatibles con Phalcon\Http\Response\Headers


## Métodos

```php
public function get( string $name ): string | bool;
```
Obtiene un valor de cabecera desde la bolsa interna


```php
public function has( string $name ): bool;
```
Comprueba si existe una cabecera


```php
public function reset();
```
Resetea las cabeceras establecidas


```php
public function send(): bool;
```
Envía las cabeceras al cliente


```php
public function set( string $name, string $value );
```
Establece una cabecera para enviar al final de la petición


```php
public function setRaw( string $header );
```
Establece una cabecera en bruto para enviar al final de la petición




<h1 id="http-responseinterface">Interface Phalcon\Http\ResponseInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Http/ResponseInterface.zep)

| Namespace  | Phalcon\Http | | Uses       | DateTime, Phalcon\Http\Response\HeadersInterface |

Phalcon\Http\Response

Interfaz para Phalcon\Http\Response


## Métodos

```php
public function appendContent( mixed $content ): ResponseInterface;
```
Añade una cadena al cuerpo de respuesta HTTP


```php
public function getContent(): string;
```
Obtiene el cuerpo de la respuesta HTTP


```php
public function getHeaders(): HeadersInterface;
```
Devuelve las cabeceras establecidas por el usuario


```php
public function getStatusCode(): int | null;
```
Devuelve el código de estado


```php
public function hasHeader( string $name ): bool;
```
Comprueba si existe una cabecera


```php
public function isSent(): bool;
```
Comprueba si la respuesta ya se ha enviado


```php
public function redirect( mixed $location = null, bool $externalRedirect = bool, int $statusCode = int ): ResponseInterface;
```
Redirige por HTTP a otra acción o URL


```php
public function resetHeaders(): ResponseInterface;
```
Resetea todas las cabeceras establecidas


```php
public function send(): ResponseInterface;
```
Muestra la respuesta HTTP al cliente


```php
public function sendCookies(): ResponseInterface;
```
Envía las cookies al cliente


```php
public function sendHeaders(): ResponseInterface | bool;
```
Envía las cabeceras al cliente


```php
public function setContent( string $content ): ResponseInterface;
```
Establece el cuerpo de respuesta HTTP


```php
public function setContentLength( int $contentLength ): ResponseInterface;
```
Establece la longitud del contenido de la respuesta


```php
public function setContentType( string $contentType, mixed $charset = null ): ResponseInterface;
```
Establece el tipo mime del contenido de la respuesta, opcionalmente el conjunto de caracteres


```php
public function setExpires( DateTime $datetime ): ResponseInterface;
```
Establece la salida de la cabecera de tiempo de expiración


```php
public function setFileToSend( string $filePath, mixed $attachmentName = null ): ResponseInterface;
```
Establece un fichero adjunto a enviar al final de la petición


```php
public function setHeader( string $name, mixed $value ): ResponseInterface;
```
Sobreescribe una cabecera en la respuesta


```php
public function setJsonContent( mixed $content ): ResponseInterface;
```
Establece el cuerpo de respuesta HTTP. El parámetro se convierte automáticamente a JSON

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
Envía una respuesta Not-Modified


```php
public function setRawHeader( string $header ): ResponseInterface;
```
Envía una cabecera en bruto a la respuesta


```php
public function setStatusCode( int $code, string $message = null ): ResponseInterface;
```
Establece el código de respuesta HTTP


