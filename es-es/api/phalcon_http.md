---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Http'
---

- [Phalcon\Http\Cookie](#http-cookie)
- [Phalcon\Http\Cookie\CookieInterface](#http-cookie-cookieinterface)
- [Phalcon\Http\Cookie\Exception](#http-cookie-exception)
- [Phalcon\Http\Message\AbstractCommon](#http-message-abstractcommon)
- [Phalcon\Http\Message\AbstractMessage](#http-message-abstractmessage)
- [Phalcon\Http\Message\AbstractRequest](#http-message-abstractrequest)
- [Phalcon\Http\Message\Exception\InvalidArgumentException](#http-message-exception-invalidargumentexception)
- [Phalcon\Http\Message\Request](#http-message-request)
- [Phalcon\Http\Message\RequestFactory](#http-message-requestfactory)
- [Phalcon\Http\Message\Response](#http-message-response)
- [Phalcon\Http\Message\ResponseFactory](#http-message-responsefactory)
- [Phalcon\Http\Message\ServerRequest](#http-message-serverrequest)
- [Phalcon\Http\Message\ServerRequestFactory](#http-message-serverrequestfactory)
- [Phalcon\Http\Message\Stream](#http-message-stream)
- [Phalcon\Http\Message\Stream\Input](#http-message-stream-input)
- [Phalcon\Http\Message\Stream\Memory](#http-message-stream-memory)
- [Phalcon\Http\Message\Stream\Temp](#http-message-stream-temp)
- [Phalcon\Http\Message\StreamFactory](#http-message-streamfactory)
- [Phalcon\Http\Message\UploadedFile](#http-message-uploadedfile)
- [Phalcon\Http\Message\UploadedFileFactory](#http-message-uploadedfilefactory)
- [Phalcon\Http\Message\Uri](#http-message-uri)
- [Phalcon\Http\Message\UriFactory](#http-message-urifactory)
- [Phalcon\Http\Request](#http-request)
- [Phalcon\Http\Request\Exception](#http-request-exception)
- [Phalcon\Http\Request\File](#http-request-file)
- [Phalcon\Http\Request\FileInterface](#http-request-fileinterface)
- [Phalcon\Http\RequestInterface](#http-requestinterface)
- [Phalcon\Http\Response](#http-response)
- [Phalcon\Http\Response\Cookies](#http-response-cookies)
- [Phalcon\Http\Response\CookiesInterface](#http-response-cookiesinterface)
- [Phalcon\Http\Response\Exception](#http-response-exception)
- [Phalcon\Http\Response\Headers](#http-response-headers)
- [Phalcon\Http\Response\HeadersInterface](#http-response-headersinterface)
- [Phalcon\Http\ResponseInterface](#http-responseinterface)
- [Phalcon\Http\Server\AbstractMiddleware](#http-server-abstractmiddleware)
- [Phalcon\Http\Server\AbstractRequestHandler](#http-server-abstractrequesthandler)

<h1 id="http-cookie">Class Phalcon\Http\Cookie</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Cookie.zep)

| Namespace | Phalcon\Http | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Crypt\CryptInterface, Phalcon\Crypt\Mismatch, Phalcon\Filter\FilterInterface, Phalcon\Helper\Arr, Phalcon\Http\Response\Exception, Phalcon\Http\Cookie\CookieInterface, Phalcon\Http\Cookie\Exception, Phalcon\Session\ManagerInterface | | Extends | AbstractInjectionAware | | Implements | CookieInterface |

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

//
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
protected secure;

/**
 * The cookie's sign key.
 * @var string|null
 */
protected signKey;

/**
 * @var bool
 */
protected useEncryption = false;

/**
 * @var mixed
 */
protected value;

```

## Métodos

```php
public function __construct( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = bool, array $options = [] );
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Cookie/CookieInterface.zep)

| Namespace | Phalcon\Http\Cookie |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Cookie/Exception.zep)

| Namespace | Phalcon\Http\Cookie | | Extends | \Phalcon\Exception |

Phalcon\Http\Cookie\Exception

Las excepciones lanzadas en Phalcon\Http\Cookie usarán esta clase.

<h1 id="http-message-abstractcommon">Abstract Class Phalcon\Http\Message\AbstractCommon</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/AbstractCommon.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Exception\InvalidArgumentException |

Métodos comunes

## Métodos

```php
final protected function checkStringParameter( mixed $element ): void;
```

Comprueba el elemento pasado si es una cadena

```php
final protected function cloneInstance( mixed $element, string $property ): mixed;
```

Devuelve una nueva instancia al establecer el parámetro

```php
final protected function processWith( mixed $element, string $property ): mixed;
```

Comprueba el elemento pasado; lo asigna a la propiedad y devuelve un clon del objeto de vuelta

<h1 id="http-message-abstractmessage">Abstract Class Phalcon\Http\Message\AbstractMessage</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/AbstractMessage.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\StreamInterface, Psr\Http\Message\UriInterface | | Extends | AbstractCommon |

Métodos de mensaje

## Propiedades

```php
/**
 * Gets the body of the message.
 *
 * @var StreamInterface
 */
protected body;

/**
 * @var Collection|CollectionInterface
 */
protected headers;

/**
 * Retrieves the HTTP protocol version as a string.
 *
 * The string MUST contain only the HTTP version number (e.g., '1.1',
 * '1.0').
 *
 * @return string HTTP protocol version.
 *
 * @var string
 */
protected protocolVersion = 1.1;

/**
 * Retrieves the URI instance.
 *
 * This method MUST return a UriInterface instance.
 *
 * @see http://tools.ietf.org/html/rfc3986#section-4.3
 *
 * @var UriInterface
 */
protected uri;

```

## Métodos

```php
public function getBody(): StreamInterface
```

```php
public function getHeader( mixed $name ): array;
```

Recupera un valor de cabecera de mensaje por el nombre dado insensible a mayúsculas y minúsculas.

Este método devuelve un vector de todos los valores de cabecera del nombre de cabecera dado insensible a mayúsculas y minúsculas.

Si la cabecera no aparece en el mensaje, este método DEBE devolver un vector vacío.

```php
public function getHeaderLine( mixed $name ): string;
```

Obtiene una cadena separada por comas de los valores para una única cabecera.

Este método devuelve todos los valores de cabecera de un nombre de cabecera dado insensible a mayúsculas y minúsculas como una cadena concatenada junta usando una coma.

NOTA: No todos los valores de cabecera pueden ser representados apropiadamente usando la concatenación por coma. Para esas cabeceras, use getHeader() en su lugar y proporcione su propio delimitador al concatenar.

Si la cabecera no aparece en el mensaje, este método DEBE devolver una cadena vacía.

```php
public function getHeaders(): array;
```

Obtiene todos los valores de cabecera del mensaje.

Las claves representan el nombre de la cabecera tal y como se enviarán, y cada valor es un vector de cadenas asociadas con la cabecera.

    // Represent the headers as a string
    foreach ($message->getHeaders() as $name => $values) {
        echo $name . ': ' . implode(', ', $values);
    }
    
    // Emit headers iteratively:
    foreach ($message->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    

Mientras que los nombres de la cabecera son insensibles a mayúsculas, getHeaders() preservará intactas las mayúsculas y minúsculas en el que las cabeceras fueron especificadas originalmente.

```php
public function getProtocolVersion(): string
```

```php
public function getUri(): UriInterface
```

```php
public function hasHeader( mixed $name ): bool;
```

Comprueba si existe una cabecera por el nombre dado insensible a mayúsculas y minúsculas.

```php
public function withAddedHeader( mixed $name, mixed $value ): mixed;
```

Devuelve una instancia con la cabecera especificada añadida con el valor dado.

Se mantendrán los valores existentes para la cabecera especificada. El/los nuevo/s valor/es será/n añadido/s a la lista existente. Si la cabecera no existía previamente, será añadida.

Este método DEBE ser implementado de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga la nueva cabecera y/o valor.

```php
public function withBody( StreamInterface $body ): mixed;
```

Devuelve una instancia con el cuerpo de mensaje especificado.

El cuerpo DEBE ser un objeto `StreamInterface`.

Este método DEBE ser implementado de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una nueva instancia con el nuevo flujo de cuerpo.

```php
public function withHeader( mixed $name, mixed $value ): mixed;
```

Devuelve una instancia con el valor proporcionado reemplazando la cabecera especificada.

Mientras que los nombres de cabecera son insensibles a mayúsculas, esta función mantendrá las mayúsculas y minúsculas de la cabecera, y se devolverán con getHeaders().

Este método DEBE ser implementado de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga la nueva y/o actualizada cabecera y valor.

```php
public function withProtocolVersion( mixed $version ): mixed;
```

Devuelve una instancia con la versión de protocolo HTTP especificada.

La cadena de versión DEBE contener sólo el número de versión HTTP (ej, '1.1', '1.0').

Este método DEBE ser implementado de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga la nueva versión de protocolo.

```php
public function withoutHeader( mixed $name ): mixed;
```

Devuelve una instancia sin la cabecera especificada.

La resolución de cabecera se DEBE hacer sin sensibilidad a mayúsculas y minúsculas.

Este método DEBE implementarse de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que elimine la cabecera nombrada.

```php
final protected function checkHeaderHost( CollectionInterface $collection ): CollectionInterface;
```

Asegura que `Host` es la primera cabecera.

@see: http://tools.ietf.org/html/rfc7230#section-5.4

```php
final protected function checkHeaderName( mixed $name ): void;
```

Comprueba el nombre de la cabecera. Lanza excepción si no es válida

@see http://tools.ietf.org/html/rfc7230#section-3.2

```php
final protected function checkHeaderValue( mixed $value ): void;
```

Valida un valor de cabecera

La mayoría de los valores de campo de cabecera se definen usando componentes de sintaxis común (token, cadena entre comillas, y comentario) separados por espacios en blanco o caracteres específicos de delimitación. Los delimitadores se eligen del conjunto de caracteres visuales US-ASCII no permitidos en un token (DQUOTE and '(),/:;<=>?@[\]{}').

    token          = 1*tchar
    
    tchar          = '!' / '#' / '$' / '%' / '&' / ''' / '*'
                   / '+' / '-' / '.' / '^' / '_' / '`' / '|' / '~'
                   / DIGIT / ALPHA
                   ; any VCHAR, except delimiters
    

Una cadena de texto se analiza como un valor único si escribe usando comillas dobles.

    quoted-string  = DQUOTE( qdtext / quoted-pair ) DQUOTE
    qdtext         = HTAB / SP /%x21 / %x23-5B / %x5D-7E / obs-text
    obs-text       = %x80-FF
    

Los comentarios se pueden incluir en algunos campos de cabecera HTTP rodeando el texto del comentario con paréntesis. Los comentarios sólo se permiten en campos que contienen 'comment' como parte de su definición del valor de campo.

    comment        = '('( ctext / quoted-pair / comment ) ')'
    ctext          = HTAB / SP / %x21-27 / %x2A-5B / %x5D-7E / obs-text
    

El octeto de barra inversa ('\') se puede usar como mecanismo de cita de un sólo octeto en construcciones de cadenas-entrecomilladas y comentarios. Los recipientes que procesan el valor de una cadena entrecomillada DEBE gestionar un par entrecomillado como si fuera sustituido por el octeto que sigue a la barra invertida.

    quoted-pair    = '\' ( HTAB / SP / VCHAR / obs-text )
    

Un remitente NO DEBERÍA generar un par entrecomillado en una cadena entrecomillada excepto donde sea necesario entrecomillar octetos de DQUOTE y barra invertida que ocurran dentro de esa cadena. Un remitente NO DEBERÍA generar un par entrecomillado en un comentario excepto donde sea necesario entrecomillar paréntesis ['(' y ')'] y octetos de barra invertida que ocurran dentro de ese comentario.

@see https://tools.ietf.org/html/rfc7230#section-3.2.6

```php
final protected function getHeaderValue( mixed $values ): array;
```

Devuelve los valores de cabecera comprobados para su validez

```php
final protected function getUriHost( UriInterface $uri ): string;
```

Devuelve el servidor, y, si es aplicable, el puerto

```php
final protected function populateHeaderCollection( array $headers ): CollectionInterface;
```

Rellena la colección de cabeceras

```php
final protected function processBody( mixed $body = string, string $mode = string ): StreamInterface;
```

Establece un flujo válido

```php
final protected function processHeaders( mixed $headers ): CollectionInterface;
```

Establece las cabeceras

```php
final protected function processProtocol( mixed $protocol = string ): string;
```

Comprueba el protocolo

<h1 id="http-message-abstractrequest">Abstract Class Phalcon\Http\Message\AbstractRequest</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/AbstractRequest.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\UriInterface | | Extends | AbstractMessage |

Métodos de solicitud

## Propiedades

```php
/**
 * Retrieves the HTTP method of the request.
 *
 * @var string
 */
protected method = GET;

/**
 * The request-target, if it has been provided or calculated.
 *
 * @var null|string
 */
protected requestTarget;

/**
 * Retrieves the URI instance.
 *
 * This method MUST return a UriInterface instance.
 *
 * @see http://tools.ietf.org/html/rfc3986#section-4.3
 *
 * @var UriInterface
 */
protected uri;

```

## Métodos

```php
public function getMethod(): string
```

```php
public function getRequestTarget(): string;
```

Obtiene el destino de la petición del mensaje.

Obtiene el destino de la petición del mensaje tal y como aparecerá (para clientes), como apareció en la petición (para servidores), o como fue especificado por la instancia (ver withRequestTarget()).

En la mayoría de casos, esta será la forma original de la URL compuesta, a no ser que se proporcione un valor para la implementación concreta (ver withRequestTarget() más abajo).

```php
public function getUri(): UriInterface
```

```php
public function withMethod( mixed $method ): mixed;
```

Devuelve una instancia con el método HTTP proporcionado.

Mientras que los nombres de método HTTP son típicamente todos caracteres mayúsculas, los nombres de método HTTP son sensibles a mayúsculas y minúsculas y por lo tanto las implementaciones NO DEBERÍAN modificar la cadena dada.

Este método DEBE ser implementado de tal manera que conserve al inmutabilidad del mensaje, y DEBE devolver una instancia que tenga el método de petición cambiado.

```php
public function withRequestTarget( mixed $requestTarget ): mixed;
```

Devuelve una instancia con el destino especificado de la petición.

Si la petición necesita un destino de petición no en la forma original — ej., para especificar una forma absoluta, una forma de autoridad, o una forma de asterisco — este método se podría usar para crear una instancia con el destino de petición especificado, literalmente.

Este método se DEBE implementar de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga el destino de la petición cambiado.

@see http://tools.ietf.org/html/rfc7230#section-5.3 (for the various request-target forms allowed in request messages)

```php
public function withUri( UriInterface $uri, mixed $preserveHost = bool ): mixed;
```

Devuelve una instancia con la URL proporcionada.

Este método DEBE actualizar la cabecera `Host` de la petición devuelta por defecto si la URI contiene un componente servidor. If the URI does not contain a host component, any pre-existing Host header MUST be carried over to the returned request.

Puede optar por preservar el estado original de la cabecera `Host` estableciendo `$preserveHost` a `true`. Cuando `$preserveHost` se establece a `true`, este método interactúa con la cabecera `Host` de la siguiente manera:

- Si la cabecera `Host`no está o está vacía, y la nueva URI contiene un componente servidor, este método DEBE actualizar la cabecera `Host` en la petición devuelta.
- Si la cabecera `Host` no está o está vacía, y la nueva URI no contiene un componente servidor, este método NO DEBE actualizar la cabecera `Host` en la petición devuelta.
- Si una cabecera Host está presente y no está vacía, este método NO DEBE actualizar la cabecera `Host` en la petición devuelta.

Este método se DEBE implementar de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga la nueva instancia UriInterface.

@see http://tools.ietf.org/html/rfc3986#section-4.3

```php
final protected function processMethod( mixed $method = string ): string;
```

Comprueba el método

```php
final protected function processUri( mixed $uri ): UriInterface;
```

Establece una Uri válida

<h1 id="http-message-exception-invalidargumentexception">Class Phalcon\Http\Message\Exception\InvalidArgumentException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Exception/InvalidArgumentException.zep)

| Namespace | Phalcon\Http\Message\Exception | | Uses | Throwable | | Extends | \InvalidArgumentException | | Implements | Throwable |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

<h1 id="http-message-request">Final Class Phalcon\Http\Message\Request</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Request.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Stream\Input, Phalcon\Http\Message\AbstractRequest, Psr\Http\Message\RequestInterface, Psr\Http\Message\StreamInterface, Psr\Http\Message\UriInterface | | Extends | AbstractRequest | | Implements | RequestInterface |

PSR-7 Request

## Métodos

```php
public function __construct( string $method = string, mixed $uri = null, mixed $body = string, mixed $headers = [] );
```

Constructor Request.

<h1 id="http-message-requestfactory">Final Class Phalcon\Http\Message\RequestFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/RequestFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\RequestInterface, Psr\Http\Message\RequestFactoryInterface, Psr\Http\Message\UriInterface | | Implements | RequestFactoryInterface |

PSR-17 RequestFactory

## Métodos

```php
public function createRequest( string $method, mixed $uri ): RequestInterface;
```

Crea una nueva petición.

<h1 id="http-message-response">Final Class Phalcon\Http\Message\Response</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Response.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Number, Phalcon\Http\Message\AbstractMessage, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\ResponseInterface | | Extends | AbstractMessage | | Implements | ResponseInterface |

PSR-7 Response

## Propiedades

```php
/**
 * Gets the response reason phrase associated with the status code.
 *
 * Because a reason phrase is not a required element in a response
 * status line, the reason phrase value MAY be empty. Implementations MAY
 * choose to return the default RFC 7231 recommended reason phrase (or
 * those
 * listed in the IANA HTTP Status Code Registry) for the response's
 * status code.
 *
 * @see http://tools.ietf.org/html/rfc7231#section-6
 * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
 *
 * @var string
 */
protected reasonPhrase = ;

/**
 * Gets the response status code.
 *
 * The status code is a 3-digit integer result code of the server's attempt
 * to understand and satisfy the request.
 *
 * @var int
 */
protected statusCode = 200;

```

## Métodos

```php
public function __construct( mixed $body = string, int $code = int, array $headers = [] );
```

Constructor Response.

```php
public function getReasonPhrase(): string
```

```php
public function getStatusCode(): int
```

```php
public function withStatus( mixed $code, mixed $reasonPhrase = string ): Response;
```

Devuelve una instancia con el código de estado especificado y, opcionalmente, la frase de razón.

Si no se especifica una frase de razón, las implementaciones PUEDEN elegir por defecto la frase de razón recomendada por RFC 7231 o IANA para el código de estado de la respuesta.

Este método DEBE implementarse de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tiene el estado y frase de razón actualizados.

@see http://tools.ietf.org/html/rfc7231#section-6 @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml

```php
protected function getPhrases(): array;
```

Devuelve la lista de códigos de estado disponibles

```php
protected function processCode( mixed $code, mixed $phrase = string ): void;
```

Establece un código de estado y frase válidos

<h1 id="http-message-responsefactory">Final Class Phalcon\Http\Message\ResponseFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/ResponseFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\ResponseInterface, Psr\Http\Message\ResponseFactoryInterface | | Implements | ResponseFactoryInterface |

PSR-17 ResponseFactory

## Métodos

```php
public function createResponse( int $code = int, string $reasonPhrase = string ): ResponseInterface;
```

Crea una nueva respuesta.

<h1 id="http-message-serverrequest">Final Class Phalcon\Http\Message\ServerRequest</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/ServerRequest.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Phalcon\Http\Message\Exception\InvalidArgumentException, Phalcon\Http\Message\Stream\Input, Psr\Http\Message\ServerRequestInterface, Psr\Http\Message\StreamInterface, Psr\Http\Message\UploadedFileInterface, Psr\Http\Message\UriInterface | | Extends | AbstractRequest | | Implements | ServerRequestInterface |

PSR-7 ServerRequest

## Propiedades

```php
/**
 * @var Collection|CollectionInterface
 */
protected attributes;

/**
 * Retrieve cookies.
 *
 * Retrieves cookies sent by the client to the server.
 *
 * The data MUST be compatible with the structure of the $_COOKIE
 * superglobal.
 *
 * @var array
 */
protected cookieParams;

/**
 * Retrieve any parameters provided in the request body.
 *
 * If the request Content-Type is either application/x-www-form-urlencoded
 * or multipart/form-data, and the request method is POST, this method MUST
 * return the contents of $_POST.
 *
 * Otherwise, this method may return any results of deserializing
 * the request body content; as parsing returns structured content, the
 * potential types MUST be arrays or objects only. A null value indicates
 * the absence of body content.
 *
 * @var mixed
 */
protected parsedBody;

/**
 * Retrieve query string arguments.
 *
 * Retrieves the deserialized query string arguments, if any.
 *
 * Note: the query params might not be in sync with the URI or server
 * params. If you need to ensure you are only getting the original
 * values, you may need to parse the query string from
 * `getUri()->getQuery()` or from the `QUERY_STRING` server param.
 *
 * @var array
 */
protected queryParams;

/**
 * Retrieve server parameters.
 *
 * Retrieves data related to the incoming request environment,
 * typically derived from PHP's $_SERVER superglobal. The data IS NOT
 * REQUIRED to originate from $_SERVER.
 *
 * @var array
 */
protected serverParams;

/**
 * Retrieve normalized file upload data.
 *
 * This method returns upload metadata in a normalized tree, with each leaf
 * an instance of Psr\Http\Message\UploadedFileInterface.
 *
 * These values MAY be prepared from $_FILES or the message body during
 * instantiation, or MAY be injected via withUploadedFiles().
 *
 * @var array
 */
protected uploadedFiles;

```

## Métodos

```php
public function __construct( string $method = string, mixed $uri = null, array $serverParams = [], mixed $body = string, mixed $headers = [], array $cookies = [], array $queryParams = [], array $uploadFiles = [], mixed $parsedBody = null, string $protocol = string );
```

Constructor ServerRequest.

```php
public function getAttribute( mixed $name, mixed $defaultValue = null ): mixed;
```

Devuelve un único atributo de la petición derivada.

Rescupera un único atributo de la petición derivada como se describe en getAttributes(). Si el atributo no se ha establecido previamente, devuelve el valor predeterminado tal como se haya proporcionado.

Este método evita la necesidad del método hasAttribute(), ya que permite especificar un valor predeterminado a devolver si el atributo no se encuentra.

```php
public function getAttributes(): array;
```

Recupera atributos derivados de la petición.

Los 'atributos' de la petición se pueden usar para permitir la inyección de cualquier parámetro derivado de la petición: ej, los resultados de operaciones de coincidencia de rutas; los resultados de desencriptar cookies; los resultados de deserializar cuerpos de mensajes no-codificado-form; etc. Los atributos serán específicos de la aplicación y la petición, y PUEDEN ser mutables.

```php
public function getCookieParams(): array
```

```php
public function getParsedBody(): mixed
```

```php
public function getQueryParams(): array
```

```php
public function getServerParams(): array
```

```php
public function getUploadedFiles(): array
```

```php
public function withAttribute( mixed $name, mixed $value ): ServerRequest;
```

Devuelve una instancia con el atributo especificado de la petición derivada.

Este método permite establecer un único atributo de la petición derivada como se describe en getAttributes().

Este método se DEBE implementar de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga el atributo actualizado.

```php
public function withCookieParams( array $cookies ): ServerRequest;
```

Devuelve una instancia con las cookies especificadas.

NO ES NECESARIO que los datos vengan del superglobal $_COOKIE, pero DEBEN ser compatibles con la estructura de $_COOKIE. Normalmente, estos datos serán inyectados en la instanciación.

Este método NO DEBE actualizar la cabecera `Cookie` relacionada de la petición, ni los valores relacionados en los parámetros del servidor.

Este método se DEBE implementar de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga los valores de cookie actualizados.

```php
public function withParsedBody( mixed $data ): ServerRequest;
```

Devuelve una instancia con los parámetros del cuerpo especificados.

Estos se PUEDE inyectar durante la instanciación.

Si el `Content-Type` de la petición es `application/x-www-form-urlencoded` o `multipart/form-data`, y el método de la petición es POST, use este método SOLO para inyectar los contenidos de $_POST.

NO ES NECESARIO que los datos vengan de $_POST, pero DEBEN ser el resultado de deserializar el contenido del cuerpo de la petición. La deserialización/análisis devuelve datos estructurados, y, como tal, este método SOLO acepta vectores u objetos, o un valor nulo si no hay nada disponible para analizar.

Como ejemplo, si la negociación de contenido determina que los datos solicitados son una carga útil JSON, este método se podría usar para crear una instancia de petición con los parámetros deserializados.

Este método se DEBE implementar de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga los parámetros del cuerpo actualizados.

```php
public function withQueryParams( array $query ): ServerRequest;
```

Devuelve una instancia con los argumentos de cadena de la consulta especificados.

Estos valores DEBERÍAN permanecer inmutables durante el transcurso de la petición entrante. Se PUEDEN inyectar durante la instanciación, como por ejemplo desde el superglobal $_GET de PHP, o se PUEDEN derivar desde algún otro valor como la URI. En los casos donde los argumentos son analizados desde la URI, los datos DEBEN ser compatibles con lo que la función `parse_str()` de PHP devolvería para fijarse en cómo se manejan los parámetros de consulta duplicados, y como se manejan los conjuntos anidados.

Establecer argumentos de cadena de consulta NO DEBE cambiar la URI almacenada por la petición, ni los valores en los parámetros del servidor.

Este método se DEBE implementar de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga los argumentos de cadena de consulta actualizados.

```php
public function withUploadedFiles( array $uploadedFiles ): ServerRequest;
```

Crea una nueva instancia con los ficheros subidos especificados.

Este método se DEBE implementar de tal forma que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que tenga los parámetros del cuerpo actualizados.

```php
public function withoutAttribute( mixed $name ): ServerRequest;
```

Devuelve una instancia que elimina el atributo especificado de la petición derivada.

Este método permite eliminar un único atributo de la petición derivada como se describe en getAttributes().

Este método se DEBE implementar de tal manera que conserve la inmutabilidad del mensaje, y DEBE devolver una instancia que elimine el atributo.

<h1 id="http-message-serverrequestfactory">Class Phalcon\Http\Message\ServerRequestFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/ServerRequestFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Phalcon\Helper\Arr, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\ServerRequestFactoryInterface, Psr\Http\Message\ServerRequestInterface, Psr\Http\Message\UriInterface, Psr\Http\Message\UploadedFileInterface | | Implements | ServerRequestFactoryInterface |

PSR-17 ServerRequestFactory

## Métodos

```php
public function createServerRequest( string $method, mixed $uri, array $serverParams = [] ): ServerRequestInterface;
```

Crea una nueva petición de servidor.

Tenga en cuenta que los parámetros de servidor se toman exactamente tal como se dan - no se realiza ningún análisis/procesamiento de los valores dados, y, en particular, no se intenta determinar el método HTTP o URI, que se debe proporcionar explícitamente.

```php
public function load( array $server = null, array $get = null, array $post = null, array $cookies = null, array $files = null ): ServerRequest;
```

Crea una petición a partir de los valores superglobales proporcionados.

Si no se proporciona algún argumento, se usará el valor superglobal correspondiente.

```php
protected function getHeaders();
```

Devuelve el apache_request_headers si existe

<h1 id="http-message-stream">Class Phalcon\Http\Message\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Stream.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Arr, Exception, Psr\Http\Message\StreamInterface, RuntimeException | | Implements | StreamInterface |

PSR-7 Stream

## Propiedades

```php
/**
 * @var resource | null
 */
protected handle;

/**
 * @var resource | string
 */
protected stream;

```

## Métodos

```php
public function __construct( mixed $stream, string $mode = string );
```

Constructor Stream.

```php
public function __destruct();
```

Cierra el flujo cuando se destruye.

```php
public function __toString(): string;
```

Lee todos los datos del flujo en un cadena, de principio a fin.

Este método DEBE intentar buscar el principio del flujo antes de leer datos y leer el flujo hasta alcanzar el final.

Advertencia: Esto podría intentar cargar una gran cantidad de datos en memoria.

Este método NO DEBE lanzar una excepción para cumplir con las operaciones de *casting* de cadena de PHP.

@see http://php.net/manual/en/language.oop5.magic.php#object.tostring

```php
public function close(): void;
```

Cierra el flujo y cualquier recurso subyacente.

```php
public function detach(): resource | null;
```

Separa cualquier recurso subyacente del flujo.

Después de que el flujo haya sido desvinculado, el flujo queda en un estado inutilizable.

```php
public function eof(): bool;
```

Devuelve `true` si el flujo está al final del flujo.

```php
public function getContents(): string;
```

Devuelve el contenido restante en una cadena

```php
public function getMetadata( mixed $key = null );
```

Obtiene metadatos del flujo como vector asociativo u obtiene una clave específica.

Las claves devueltas son idénticas a las claves devueltas por la función stream_get_meta_data() de PHP.

```php
public function getSize(): null | int;
```

Obtiene el tamaño del flujo si se conoce.

```php
public function isReadable(): bool;
```

Devuelve si el flujo es legible o no.

```php
public function isSeekable(): bool;
```

Devuelve si el flujo es buscable o no.

```php
public function isWritable(): bool;
```

Devuelve si el flujo es escribible o no.

```php
public function read( mixed $length ): string;
```

Lee datos desde el flujo.

```php
public function rewind(): void;
```

Busca el principio del flujo.

Si el flujo no se puede buscar, éste método lanzará una excepción; de lo contrario, realizará un seek(0).

```php
public function seek( mixed $offset, mixed $whence = int ): void;
```

Intenta colocarse en una posición del flujo.

```php
public function setStream( mixed $stream, string $mode = string ): void;
```

Establece el flujo - instancia existente

```php
public function tell(): int;
```

Devuelve la posición actual del puntero de lectura/escritura del fichero

```php
public function write( mixed $data ): int;
```

Escribe datos al flujo.

<h1 id="http-message-stream-input">Class Phalcon\Http\Message\Stream\Input</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Stream/Input.zep)

| Namespace | Phalcon\Http\Message\Stream | | Uses | Phalcon\Http\Message\Stream | | Extends | Stream |

Describe un flujo de datos de "php://input"

Por lo general, una instancia envolverá un flujo PHP; esta interfaz proporciona una envoltura sobre las operaciones más comunes, incluyendo la serialización de todo el flujo a una cadena.

## Propiedades

```php
/**
 * @var string
 */
private data = ;

/**
 * @var bool
 */
private eof = false;

```

## Métodos

```php
public function __construct();
```

Constructor Input.

```php
public function __toString(): string;
```

Lee todos los datos del flujo en un cadena, de principio a fin.

Este método DEBE intentar buscar el principio del flujo antes de leer datos y leer el flujo hasta alcanzar el final.

Advertencia: Esto podría intentar cargar una gran cantidad de datos en memoria.

Este método NO DEBE lanzar una excepción para cumplir con las operaciones de *casting* de cadena de PHP.

@see http://php.net/manual/en/language.oop5.magic.php#object.tostring

```php
public function getContents( int $length = int ): string;
```

Devuelve el contenido restante en una cadena

@throws RuntimeException if unable to read. @throws RuntimeException if error occurs while reading.

```php
public function isWritable(): bool;
```

Devuelve si el flujo es escribible o no.

```php
public function read( mixed $length ): string;
```

Lee datos desde el flujo.

<h1 id="http-message-stream-memory">Class Phalcon\Http\Message\Stream\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Stream/Memory.zep)

| Namespace | Phalcon\Http\Message\Stream | | Uses | Phalcon\Http\Message\Stream | | Extends | Stream |

Describe un flujo de datos de "php://memory"

Por lo general, una instancia envolverá un flujo PHP; esta interfaz proporciona una envoltura sobre las operaciones más comunes, incluyendo la serialización de todo el flujo a una cadena.

## Métodos

```php
public function __construct( mixed $mode = string );
```

Constructor

<h1 id="http-message-stream-temp">Class Phalcon\Http\Message\Stream\Temp</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Stream/Temp.zep)

| Namespace | Phalcon\Http\Message\Stream | | Uses | Phalcon\Http\Message\Stream | | Extends | Stream |

Describe un flujo de datos de "php://temp"

Por lo general, una instancia envolverá un flujo PHP; esta interfaz proporciona una envoltura sobre las operaciones más comunes, incluyendo la serialización de todo el flujo a una cadena.

## Métodos

```php
public function __construct( mixed $mode = string );
```

Constructor

<h1 id="http-message-streamfactory">Final Class Phalcon\Http\Message\StreamFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/StreamFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\StreamFactoryInterface, Psr\Http\Message\StreamInterface | | Implements | StreamFactoryInterface |

PSR-17 StreamFactory

## Métodos

```php
public function createStream( string $content = string ): StreamInterface;
```

Crea un nuevo flujo a partir de una cadena.

El flujo se DEBERÍA crear con un recurso temporal.

```php
public function createStreamFromFile( string $filename, string $mode = string ): StreamInterface;
```

Crea un flujo desde un fichero existente.

El fichero se DEBE abrir usando el modo dado, que puede ser cualquier modo soportado por la función `fopen`.

`$filename` PUEDE ser cualquier cadena soportada por `fopen()`.

```php
public function createStreamFromResource( mixed $phpResource ): StreamInterface;
```

Crea un nuevo flujo desde un recurso existente.

El flujo DEBE ser legible y puede ser escribible.

<h1 id="http-message-uploadedfile">Final Class Phalcon\Http\Message\UploadedFile</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/UploadedFile.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Number, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\StreamInterface, Psr\Http\Message\UploadedFileInterface, RuntimeException | | Implements | UploadedFileInterface |

PSR-7 UploadedFile

## Propiedades

```php
/**
 * If the file has already been moved, we hold that status here
 *
 * @var bool
 */
private alreadyMoved = false;

/**
 * Retrieve the filename sent by the client.
 *
 * Do not trust the value returned by this method. A client could send
 * a malicious filename with the intention to corrupt or hack your
 * application.
 *
 * Implementations SHOULD return the value stored in the 'name' key of
 * the file in the $_FILES array.
 *
 * @var string | null
 */
private clientFilename;

/**
 * Retrieve the media type sent by the client.
 *
 * Do not trust the value returned by this method. A client could send
 * a malicious media type with the intention to corrupt or hack your
 * application.
 *
 * Implementations SHOULD return the value stored in the 'type' key of
 * the file in the $_FILES array.
 *
 * @var string | null
 */
private clientMediaType;

/**
 * Retrieve the error associated with the uploaded file.
 *
 * The return value MUST be one of PHP's UPLOAD_ERR_XXX constants.
 *
 * If the file was uploaded successfully, this method MUST return
 * UPLOAD_ERR_OK.
 *
 * Implementations SHOULD return the value stored in the 'error' key of
 * the file in the $_FILES array.
 *
 * @see http://php.net/manual/en/features.file-upload.errors.php
 *
 * @var int
 */
private error = 0;

/**
 * If the stream is a string (file name) we store it here
 *
 * @var string
 */
private fileName = ;

/**
 * Retrieve the file size.
 *
 * Implementations SHOULD return the value stored in the 'size' key of
 * the file in the $_FILES array if available, as PHP calculates this based
 * on the actual size transmitted.
 *
 * @var int | null
 */
private size;

/**
 * Holds the stream/string for the uploaded file
 *
 * @var StreamInterface|string|null
 */
private stream;

```

## Métodos

```php
public function __construct( mixed $stream, int $size = null, int $error = int, string $clientFilename = null, string $clientMediaType = null );
```

Constructor UploadedFile.

```php
public function getClientFilename(): string | null
```

```php
public function getClientMediaType(): string | null
```

```php
public function getError(): int
```

```php
public function getSize(): int | null
```

```php
public function getStream(): mixed;
```

Devuelve un flujo que representa al fichero subido.

Este método DEBE devolver una instancia `StreamInterface`, que representa al fichero subido. El propósito de este método es permitir utilizar funcionalidad de flujo de PHP nativa para manipular la subida de ficheros, tal como stream_copy_to_stream() (aunque el resultado necesitará ser decorado en un contenedor nativo de flujo de PHP para trabajar con tales funciones).

Si se ha llamado anteriormente al método moveTo(), este método DEBE lanzar una excepción.

```php
public function moveTo( mixed $targetPath ): void;
```

Mueve un fichero subido a una nueva ubicación.

Use este método como alternativa a move_uploaded_file(). Se garantiza que este método funciona tanto en entornos SAPI como no SAPI. Las implementaciones debe determinar en qué entorno están, y usar el método apropiado (move_uploaded_file(), rename(), o una operación de flujo) para realizar la operación.

$targetPath puede ser una ruta absoluta, o una ruta relativa. Si es una ruta relativa, la resolución debería ser la misma que la usada por la función `rename()` de PHP.

El fichero original o flujo se DEBE eliminar al completarse.

Si este método se llama más de una vez, cualquier llamada posterior DEBE lanzar una excepción.

Cuando se usa un entorno SAPI donde se rellena $_FILES, cuando se escriben los ficheros vía moveTo(), is_uploaded_file() y move_uploaded_file() se DEBERÍAN usar para asegurar que los permisos y el estado de subida son verificados correctamente.

Si desea moverse a un flujo, use getStream(), ya que las operaciones SAPI no pueden garantizar la escritura a destinos de flujo.

@see http://php.net/is_uploaded_file @see http://php.net/move_uploaded_file

<h1 id="http-message-uploadedfilefactory">Final Class Phalcon\Http\Message\UploadedFileFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/UploadedFileFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\StreamInterface, Psr\Http\Message\UploadedFileInterface, Psr\Http\Message\UploadedFileFactoryInterface | | Implements | UploadedFileFactoryInterface |

PSR-17 UploadedFileFactory

## Métodos

```php
public function createUploadedFile( StreamInterface $stream, int $size = null, int $error = int, string $clientFilename = null, string $clientMediaType = null ): UploadedFileInterface;
```

Crea un nuevo fichero subido.

Si no se proporciona un tamaño, se determinará comprobando el tamaño del flujo.

@link http://php.net/manual/features.file-upload.post-method.php @link http://php.net/manual/features.file-upload.errors.php

<h1 id="http-message-uri">Final Class Phalcon\Http\Message\Uri</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/Uri.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\UriInterface | | Extends | AbstractCommon | | Implements | UriInterface |

PSR-7 Uri

## Propiedades

```php
/**
 * Returns the fragment of the URL
 *
 * @return string
 */
protected fragment = ;

/**
 * Retrieve the host component of the URI.
 *
 * If no host is present, this method MUST return an empty string.
 *
 * The value returned MUST be normalized to lowercase, per RFC 3986
 * Section 3.2.2.
 *
 * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
 *
 * @return string
 */
protected host = ;

/**
 * @var string
 */
protected pass = ;

/**
 * Returns the path of the URL
 *
 * @return string
 */
protected path = ;

/**
 * Retrieve the port component of the URI.
 *
 * If a port is present, and it is non-standard for the current scheme,
 * this method MUST return it as an integer. If the port is the standard
 * port used with the current scheme, this method SHOULD return null.
 *
 * If no port is present, and no scheme is present, this method MUST return
 * a null value.
 *
 * If no port is present, but a scheme is present, this method MAY return
 * the standard port for that scheme, but SHOULD return null.
 *
 * @return int|null
 */
protected port;

/**
 * Returns the query of the URL
 *
 * @return string
 */
protected query = ;

/**
 * Retrieve the scheme component of the URI.
 *
 * If no scheme is present, this method MUST return an empty string.
 *
 * The value returned MUST be normalized to lowercase, per RFC 3986
 * Section 3.1.
 *
 * The trailing ":" character is not part of the scheme and MUST NOT be
 * added.
 *
 * @see https://tools.ietf.org/html/rfc3986#section-3.1
 *
 * @return string
 */
protected scheme = https;

/**
 * @var string
 */
protected user = ;

```

## Métodos

```php
public function __construct( string $uri = string );
```

Constructor Uri.

```php
public function __toString(): string;
```

Devuelve la representación de cadena como referencia URI.

Dependiendo de qué componentes de la URI estén presentes, la cadena resultante es una referencia completa o relativa de URI según RFC 3986, Sección 4.1. Este método concatena los distintos componentes de la URI, usando los delimitadores apropiados

```php
public function getAuthority(): string;
```

Obtiene el componente autoridad de la URI.

```php
public function getFragment()
```

```php
public function getHost()
```

```php
public function getPath()
```

```php
public function getPort()
```

```php
public function getQuery()
```

```php
public function getScheme()
```

```php
public function getUserInfo(): string;
```

Devuelve el componente de información de usuario de la URI.

Si no está presente la información de usuario, este método DEBE devolver una cadena vacía.

Si un usuario está presente en la URI, se devolverá ese valor; adicionalmente, si la contraseña también está presente, se añadirá al valor del usuario, con dos puntos (":") separando los valores.

El caracter "@" final no es parte de la información de usuario y NO DEBE ser añadido.

```php
public function withFragment( mixed $fragment ): Uri;
```

Devuelve una instancia con el fragmento de URI especificado.

Este método DEBE mantener el estado de la instancia actual, y devolver una instancia que contenga el fragmento URI especificado.

Los usuarios pueden proporcionar tanto caracteres de fragmento codificados como decodificados. Las implementaciones aseguran la correcta codificación como se describe en `getFragment()`.

Un valor de fragmento vacío es equivalente a eliminar el fragmento.

```php
public function withHost( mixed $host ): Uri;
```

Devuelve una instancia con el servidor especificado.

Este método DEBE conservar el estado de la instancia actual, y devolver una instancia que contenga el servidor especificado.

Un valor de servidor vacío es equivalente a eliminar el servidor.

```php
public function withPath( mixed $path ): Uri;
```

Devuelve una instancia con la ruta especificada.

Este método DEBE conservar el estado de la instancia actual, y devolver una instancia que contenga la ruta especificada.

La ruta puede estar vacía o ser absoluta (empezando con una barra) o sin raíz (no empezando con una barra). Las implementaciones DEBEN soportar las tres sintaxis.

Si una ruta HTTP está destinada a ser relativa al servidor en lugar de relativa a la ruta entonces debe empezar con una barra ("/"). Las rutas HTTP que no empiezan con una barra son relativas a alguna ruta base conocida por la aplicación o consumidor.

Los usuarios pueden proporcionar tanto caracteres de ruta codificados como decodificados. Las implementaciones se aseguran de la correcta codificación como se describe en `getPath()`.

```php
public function withPort( mixed $port ): Uri;
```

Devuelve una instancia con el puerto especificado.

Este método DEBE conservar el estado de la instancia actual, y devolver una instancia que contenga el puerto especificado.

Las implementaciones DEBEN lanzar una excepción para puertos fuera de los rangos de puertos TCP y UDP establecidos.

Un valor nulo proporcionado para el puerto es equivalente a eliminar la información del puerto.

```php
public function withQuery( mixed $query ): Uri;
```

Devuelve una instancia con la cadena de consulta especificada.

Este método DEBE conservar el estado de la instancia actual, y devolver una instancia que contenga la cadena de consulta especificada.

Los usuarios pueden proporcionar tanto caracteres de consulta codificados como decodificados. Las implementaciones aseguran la correcta codificación como se describe en `getQuery()`.

Una cadena de consulta vacía es equivalente a eliminar la cadena de consulta.

```php
public function withScheme( mixed $scheme ): Uri;
```

Devuelve una instancia con el esquema especificado.

Este método DEBE conservar el estado de la instancia actual, y devolver una instancia que contenga el esquema especificado.

Las implementaciones DEBEN soportar los esquemas "http" y "https" insensibles a mayúsculas y minúsculas, y PUEDEN incluir otros esquemas si se requiere.

Un esquema vacío es equivalente a eliminar el esquema.

```php
public function withUserInfo( mixed $user, mixed $password = null ): Uri;
```

Devuelve una instancia con la información de usuario especificada.

<h1 id="http-message-urifactory">Final Class Phalcon\Http\Message\UriFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Message/UriFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\UriFactoryInterface, Psr\Http\Message\UriInterface | | Implements | UriFactoryInterface |

PSR-17 UriFactory

## Métodos

```php
public function createUri( string $uri = string ): UriInterface;
```

Devuelve un objeto Localizador con todos los ayudantes definidos en funciones anónimas

<h1 id="http-request">Class Phalcon\Http\Request</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Request.zep)

| Namespace | Phalcon\Http | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface, Phalcon\Helper\Json, Phalcon\Http\Request\File, Phalcon\Http\Request\FileInterface, Phalcon\Http\Request\Exception, UnexpectedValueException, stdClass | | Extends | AbstractInjectionAware | | Implements | RequestInterface |

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
//
private filterService;

/**
 * @var bool
 */
private httpMethodParameterOverride = false;

/**
 * @var array
 */
private queryFilters;

//
private putCache;

//
private rawBody;

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
];&lt;/p>

&lt;p>$headers = $request->getHeaders();&lt;/p>

&lt;p>echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Request/Exception.zep)

| Namespace | Phalcon\Http\Request | | Extends | \Phalcon\Exception |

Phalcon\Http\Request\Exception

Las excepciones lanzadas en Phalcon\Http\Request usarán esta clase

<h1 id="http-request-file">Class Phalcon\Http\Request\File</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Request/File.zep)

| Namespace | Phalcon\Http\Request | | Uses | Phalcon\Helper\Arr | | Implements | FileInterface |

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

//
protected name;

//
protected realType;

//
protected size;

//
protected tmp;

//
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Request/FileInterface.zep)

| Namespace | Phalcon\Http\Request |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/RequestInterface.zep)

| Namespace | Phalcon\Http | | Uses | Phalcon\Http\Request\FileInterface, stdClass |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Response.zep)

| Namespace | Phalcon\Http | | Uses | DateTime, DateTimeZone, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Helper\Fs, Phalcon\Helper\Json, Phalcon\Http\Response\Exception, Phalcon\Http\Response\HeadersInterface, Phalcon\Http\Response\CookiesInterface, Phalcon\Url\UrlInterface, Phalcon\Mvc\ViewInterface, Phalcon\Http\Response\Headers, Phalcon\Di\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Implements | ResponseInterface, InjectionAwareInterface, EventsAwareInterface |

Parte del ciclo HTTP es devolver respuestas a los clientes. Phalcon\HTTP\Response es el componente Phalcon responsable de realizar esta tarea. Las respuestas HTTP suelen estar compuestas por cabeceras y cuerpo.

```php
$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();
```

## Propiedades

```php
//
protected container;

//
protected content;

//
protected cookies;

//
protected eventsManager;

//
protected file;

//
protected headers;

/**
 * @var bool
 */
protected sent = false;

//
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
public function getEventsManager(): ManagerInterface;
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Response/Cookies.zep)

| Namespace | Phalcon\Http\Response | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\Cookie\Exception, Phalcon\Http\Cookie\CookieInterface | | Extends | AbstractInjectionAware | | Implements | CookiesInterface |

Phalcon\Http\Response\Cookies

Esta clase es una bolsa para gestionar las cookies.

Una bolsa de cookies se registra automáticamente como parte del servicio 'response' en el DI. Por defecto, las cookies automáticamente se encriptan antes de enviarse al cliente y son desencriptadas cuando se recuperan desde el usuario. Para establecer la clave de firma a usar para generar un código de autenticación de mensaje use `Phalcon\Http\Response\Cookies::setSignKey()`.

```php
use Phalcon\Di;
use Phalcon\Crypt;
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
//
protected cookies;

//
protected registered = false;

/**
 * The cookie's sign key.
 * @var string|null
 */
protected signKey;

//
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Response/CookiesInterface.zep)

| Namespace | Phalcon\Http\Response | | Uses | Phalcon\Http\Cookie\CookieInterface |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Response/Exception.zep)

| Namespace | Phalcon\Http\Response | | Extends | \Phalcon\Exception |

Phalcon\Http\Response\Exception

Las excepciones lanzadas en Phalcon\Http\Response usarán esta clase.

<h1 id="http-response-headers">Class Phalcon\Http\Response\Headers</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Response/Headers.zep)

| Namespace | Phalcon\Http\Response | | Implements | HeadersInterface |

Phalcon\Http\Response\Headers

Esta clase es una bolsa para gestionar las cabeceras de la respuesta

## Propiedades

```php
//
protected headers;

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
public function remove( string $header ): HeadersInterface;
```

Elimina una cabecera que será enviada al final de la solicitud

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Response/HeadersInterface.zep)

| Namespace | Phalcon\Http\Response |

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/ResponseInterface.zep)

| Namespace | Phalcon\Http | | Uses | DateTime, Phalcon\Http\Response\HeadersInterface |

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

<h1 id="http-server-abstractmiddleware">Abstract Class Phalcon\Http\Server\AbstractMiddleware</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Server/AbstractMiddleware.zep)

| Namespace | Phalcon\Http\Server | | Uses | Psr\Http\Message\ResponseInterface, Psr\Http\Message\ServerRequestInterface, Psr\Http\Server\MiddlewareInterface, Psr\Http\Server\RequestHandlerInterface | | Implements | MiddlewareInterface |

Participante en el procesamiento de una petición y respuesta del servidor.

Un componente `middleware` HTTP participa en el procesamiento de un mensaje HTTP: actuando en la petición, generando la respuesta, o reenviando la petición a un `middleware` posterior y posiblemente actuando en su respuesta.

## Métodos

```php
abstract public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface;
```

Procesa una petición de servidor entrante.

Procesa una petición de servidor entrante para producir una respuesta. Si es incapaz de producir una respuesta por sí mismo, puede delegar al gestor de la solicitud proporcionado para hacerlo.

<h1 id="http-server-abstractrequesthandler">Abstract Class Phalcon\Http\Server\AbstractRequestHandler</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Http/Server/AbstractRequestHandler.zep)

| Namespace | Phalcon\Http\Server | | Uses | Psr\Http\Message\ResponseInterface, Psr\Http\Message\ServerRequestInterface, Psr\Http\Server\RequestHandlerInterface | | Implements | RequestHandlerInterface |

Gestiona una petición del servidor y produce una respuesta.

Una gestor de petición HTTP procesa una petición HTTP para producir una respuesta HTTP.

## Métodos

```php
abstract public function handle( ServerRequestInterface $request ): ResponseInterface;
```

Gestiona una petición y produce una respuesta.

Puede llamar a otro código colaborador para generar la respuesta.
