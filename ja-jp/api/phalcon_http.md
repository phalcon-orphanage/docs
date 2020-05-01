---
layout: default
language: 'ja-jp'
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

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Cookie.zep)

| Namespace | Phalcon\Http | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Crypt\CryptInterface, Phalcon\Crypt\Mismatch, Phalcon\Filter\FilterInterface, Phalcon\Helper\Arr, Phalcon\Http\Response\Exception, Phalcon\Http\Cookie\CookieInterface, Phalcon\Http\Cookie\Exception, Phalcon\Session\ManagerInterface | | Extends | AbstractInjectionAware | | Implements | CookieInterface |

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

## メソッド

Phalcon\Http\Cookie constructor.

```php
public function __construct( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = bool, array $options = [] );
```

Magic __toString method converts the cookie's value to string

```php
public function __toString(): string;
```

Deletes the cookie by setting an expire time in the past

```php
public function delete();
```

Returns the domain that the cookie is available to

```php
public function getDomain(): string;
```

Returns the current expiration time

```php
public function getExpiration(): string;
```

Returns if the cookie is accessible only through the HTTP protocol

```php
public function getHttpOnly(): bool;
```

Returns the current cookie's name

```php
public function getName(): string;
```

Returns the current cookie's options

```php
public function getOptions(): array;
```

Returns the current cookie's path

```php
public function getPath(): string;
```

Returns whether the cookie must only be sent when the connection is secure (HTTPS)

```php
public function getSecure(): bool;
```

Returns the cookie's value.

```php
public function getValue( mixed $filters = null, mixed $defaultValue = null ): mixed;
```

Check if the cookie is using implicit encryption

```php
public function isUsingEncryption(): bool;
```

Reads the cookie-related info from the SESSION to restore the cookie as it was set.

This method is automatically called internally so normally you don't need to call it.

```php
public function restore(): CookieInterface;
```

Sends the cookie to the HTTP client.

Stores the cookie definition in session.

```php
public function send(): CookieInterface;
```

Sets the domain that the cookie is available to

```php
public function setDomain( string $domain ): CookieInterface;
```

Sets the cookie's expiration time

```php
public function setExpiration( int $expire ): CookieInterface;
```

Sets if the cookie is accessible only through the HTTP protocol

```php
public function setHttpOnly( bool $httpOnly ): CookieInterface;
```

Sets the cookie's options

```php
public function setOptions( array $options ): CookieInterface;
```

Sets the cookie's path

```php
public function setPath( string $path ): CookieInterface;
```

Sets if the cookie must only be sent when the connection is secure (HTTPS)

```php
public function setSecure( bool $secure ): CookieInterface;
```

Sets the cookie's sign key.

The `$signKey' MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

Use NULL to disable cookie signing.

@see \Phalcon\Security\Random @throws \Phalcon\Http\Cookie\Exception

```php
public function setSignKey( string $signKey = null ): CookieInterface;
```

Sets the cookie's value

```php
public function setValue( mixed $value ): CookieInterface;
```

Sets if the cookie must be encrypted/decrypted automatically

```php
public function useEncryption( bool $useEncryption ): CookieInterface;
```

Assert the cookie's key is enough long.

@throws \Phalcon\Http\Cookie\Exception

```php
protected function assertSignKeyIsLongEnough( string $signKey ): void;
```

<h1 id="http-cookie-cookieinterface">Interface Phalcon\Http\Cookie\CookieInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Cookie/CookieInterface.zep)

| Namespace | Phalcon\Http\Cookie |

Interface for Phalcon\Http\Cookie

## メソッド

Deletes the cookie

```php
public function delete();
```

Returns the domain that the cookie is available to

```php
public function getDomain(): string;
```

Returns the current expiration time

```php
public function getExpiration(): string;
```

Returns if the cookie is accessible only through the HTTP protocol

```php
public function getHttpOnly(): bool;
```

Returns the current cookie's name

```php
public function getName(): string;
```

Returns the current cookie's options

```php
public function getOptions(): array;
```

Returns the current cookie's path

```php
public function getPath(): string;
```

Returns whether the cookie must only be sent when the connection is secure (HTTPS)

```php
public function getSecure(): bool;
```

Returns the cookie's value.

```php
public function getValue( mixed $filters = null, mixed $defaultValue = null ): mixed;
```

Check if the cookie is using implicit encryption

```php
public function isUsingEncryption(): bool;
```

Sends the cookie to the HTTP client

```php
public function send(): CookieInterface;
```

Sets the domain that the cookie is available to

```php
public function setDomain( string $domain ): CookieInterface;
```

Sets the cookie's expiration time

```php
public function setExpiration( int $expire ): CookieInterface;
```

Sets if the cookie is accessible only through the HTTP protocol

```php
public function setHttpOnly( bool $httpOnly ): CookieInterface;
```

Sets the cookie's options

```php
public function setOptions( array $options ): CookieInterface;
```

Sets the cookie's expiration time

```php
public function setPath( string $path ): CookieInterface;
```

Sets if the cookie must only be sent when the connection is secure (HTTPS)

```php
public function setSecure( bool $secure ): CookieInterface;
```

Sets the cookie's value

```php
public function setValue( mixed $value ): CookieInterface;
```

Sets if the cookie must be encrypted/decrypted automatically

```php
public function useEncryption( bool $useEncryption ): CookieInterface;
```

<h1 id="http-cookie-exception">Class Phalcon\Http\Cookie\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Cookie/Exception.zep)

| Namespace | Phalcon\Http\Cookie | | Extends | \Phalcon\Exception |

Phalcon\Http\Cookie\Exception

Exceptions thrown in Phalcon\Http\Cookie will use this class.

<h1 id="http-message-abstractcommon">Abstract Class Phalcon\Http\Message\AbstractCommon</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/AbstractCommon.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Exception\InvalidArgumentException |

Common methods

## メソッド

Checks the element passed if it is a string

```php
final protected function checkStringParameter( mixed $element ): void;
```

Returns a new instance having set the parameter

```php
final protected function cloneInstance( mixed $element, string $property ): object;
```

Checks the element passed; assigns it to the property and returns a clone of the object back

```php
final protected function processWith( mixed $element, string $property ): object;
```

<h1 id="http-message-abstractmessage">Abstract Class Phalcon\Http\Message\AbstractMessage</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/AbstractMessage.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\StreamInterface, Psr\Http\Message\UriInterface | | Extends | AbstractCommon |

Message methods

## Properties

```php
/**
 * Gets the body of the message.
 *
 * @var StreamInterface
 */
protected body;

/**
 * @var Collection
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

## メソッド

```php
public function getBody(): StreamInterface
```

Retrieves a message header value by the given case-insensitive name.

This method returns an array of all the header values of the given case-insensitive header name.

If the header does not appear in the message, this method MUST return an empty array.

```php
public function getHeader( mixed $name ): array;
```

Retrieves a comma-separated string of the values for a single header.

This method returns all of the header values of the given case-insensitive header name as a string concatenated together using a comma.

NOTE: Not all header values may be appropriately represented using comma concatenation. For such headers, use getHeader() instead and supply your own delimiter when concatenating.

If the header does not appear in the message, this method MUST return an empty string.

```php
public function getHeaderLine( mixed $name ): string;
```

Retrieves all message header values.

The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header.

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
    

While header names are not case-sensitive, getHeaders() will preserve the exact case in which headers were originally specified.

```php
public function getHeaders(): array;
```

```php
public function getProtocolVersion(): string
```

```php
public function getUri(): UriInterface
```

Checks if a header exists by the given case-insensitive name.

```php
public function hasHeader( mixed $name ): bool;
```

Return an instance with the specified header appended with the given value.

Existing values for the specified header will be maintained. The new value(s) will be appended to the existing list. If the header did not exist previously, it will be added.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the new header and/or value.

```php
public function withAddedHeader( mixed $name, mixed $value ): object;
```

Return an instance with the specified message body.

The body MUST be a StreamInterface object.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return a new instance that has the new body stream.

```php
public function withBody( StreamInterface $body ): object;
```

Return an instance with the provided value replacing the specified header.

While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from getHeaders().

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the new and/or updated header and value.

```php
public function withHeader( mixed $name, mixed $value ): object;
```

Return an instance with the specified HTTP protocol version.

The version string MUST contain only the HTTP version number (e.g., '1.1', '1.0').

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the new protocol version.

```php
public function withProtocolVersion( mixed $version ): object;
```

Return an instance without the specified header.

Header resolution MUST be done without case-sensitivity.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that removes the named header.

```php
public function withoutHeader( mixed $name ): object;
```

Ensure Host is the first header.

@see: http://tools.ietf.org/html/rfc7230#section-5.4

```php
final protected function checkHeaderHost( Collection $collection ): Collection;
```

Check the name of the header. Throw exception if not valid

@see http://tools.ietf.org/html/rfc7230#section-3.2

```php
final protected function checkHeaderName( mixed $name ): void;
```

Validates a header value

Most HTTP header field values are defined using common syntax components (token, quoted-string, and comment) separated by whitespace or specific delimiting characters. Delimiters are chosen from the set of US-ASCII visual characters not allowed in a token (DQUOTE and '(),/:;<=>?@[\]{}').

    token          = 1*tchar
    
    tchar          = '!' / '#' / '$' / '%' / '&' / ''' / '*'
                   / '+' / '-' / '.' / '^' / '_' / '`' / '|' / '~'
                   / DIGIT / ALPHA
                   ; any VCHAR, except delimiters
    

A string of text is parsed as a single value if it is quoted using double-quote marks.

    quoted-string  = DQUOTE( qdtext / quoted-pair ) DQUOTE
    qdtext         = HTAB / SP /%x21 / %x23-5B / %x5D-7E / obs-text
    obs-text       = %x80-FF
    

Comments can be included in some HTTP header fields by surrounding the comment text with parentheses. Comments are only allowed in fields containing 'comment' as part of their field value definition.

    comment        = '('( ctext / quoted-pair / comment ) ')'
    ctext          = HTAB / SP / %x21-27 / %x2A-5B / %x5D-7E / obs-text
    

The backslash octet ('\') can be used as a single-octet quoting mechanism within quoted-string and comment constructs. Recipients that process the value of a quoted-string MUST handle a quoted-pair as if it were replaced by the octet following the backslash.

    quoted-pair    = '\' ( HTAB / SP / VCHAR / obs-text )
    

A sender SHOULD NOT generate a quoted-pair in a quoted-string except where necessary to quote DQUOTE and backslash octets occurring within that string. A sender SHOULD NOT generate a quoted-pair in a comment except where necessary to quote parentheses ['(' and ')'] and backslash octets occurring within that comment.

@see https://tools.ietf.org/html/rfc7230#section-3.2.6

```php
final protected function checkHeaderValue( mixed $value ): void;
```

Returns the header values checked for validity

```php
final protected function getHeaderValue( mixed $values ): array;
```

Return the host and if applicable the port

```php
final protected function getUriHost( UriInterface $uri ): string;
```

Populates the header collection

```php
final protected function populateHeaderCollection( array $headers ): Collection;
```

Set a valid stream

```php
final protected function processBody( mixed $body = string, string $mode = string ): StreamInterface;
```

Sets the headers

```php
final protected function processHeaders( mixed $headers ): Collection;
```

Checks the protocol

```php
final protected function processProtocol( mixed $protocol = string ): string;
```

<h1 id="http-message-abstractrequest">Abstract Class Phalcon\Http\Message\AbstractRequest</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/AbstractRequest.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\UriInterface | | Extends | AbstractMessage |

Request methods

## Properties

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

## メソッド

```php
public function getMethod(): string
```

Retrieves the message's request target.

Retrieves the message's request-target either as it will appear (for clients), as it appeared at request (for servers), or as it was specified for the instance (see withRequestTarget()).

In most cases, this will be the origin-form of the composed URI, unless a value was provided to the concrete implementation (see withRequestTarget() below).

```php
public function getRequestTarget(): string;
```

```php
public function getUri(): UriInterface
```

Return an instance with the provided HTTP method.

While HTTP method names are typically all uppercase characters, HTTP method names are case-sensitive and thus implementations SHOULD NOT modify the given string.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the changed request method.

```php
public function withMethod( mixed $method ): object;
```

Return an instance with the specific request-target.

If the request needs a non-origin-form request-target — e.g., for specifying an absolute-form, authority-form, or asterisk-form — this method may be used to create an instance with the specified request-target, verbatim.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the changed request target.

@see http://tools.ietf.org/html/rfc7230#section-5.3 (for the various request-target forms allowed in request messages)

```php
public function withRequestTarget( mixed $requestTarget ): object;
```

Returns an instance with the provided URI.

This method MUST update the Host header of the returned request by default if the URI contains a host component. If the URI does not contain a host component, any pre-existing Host header MUST be carried over to the returned request.

You can opt-in to preserving the original state of the Host header by setting `$preserveHost` to `true`. When `$preserveHost` is set to `true`, this method interacts with the Host header in the following ways:

- If the Host header is missing or empty, and the new URI contains a host component, this method MUST update the Host header in the returned request.
- If the Host header is missing or empty, and the new URI does not contain a host component, this method MUST NOT update the Host header in the returned request.
- If a Host header is present and non-empty, this method MUST NOT update the Host header in the returned request.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the new UriInterface instance.

@see http://tools.ietf.org/html/rfc3986#section-4.3

```php
public function withUri( UriInterface $uri, mixed $preserveHost = bool ): object;
```

Check the method

```php
final protected function processMethod( mixed $method = string ): string;
```

Sets a valid Uri

```php
final protected function processUri( mixed $uri ): UriInterface;
```

<h1 id="http-message-exception-invalidargumentexception">Class Phalcon\Http\Message\Exception\InvalidArgumentException</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Exception/InvalidArgumentException.zep)

| Namespace | Phalcon\Http\Message\Exception | | Uses | Throwable | | Extends | \InvalidArgumentException | | Implements | Throwable |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

<h1 id="http-message-request">Final Class Phalcon\Http\Message\Request</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Request.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Stream\Input, Phalcon\Http\Message\AbstractRequest, Psr\Http\Message\RequestInterface, Psr\Http\Message\StreamInterface, Psr\Http\Message\UriInterface | | Extends | AbstractRequest | | Implements | RequestInterface |

PSR-7 Request

## メソッド

Request constructor.

```php
public function __construct( string $method = string, mixed $uri = null, mixed $body = string, mixed $headers = [] );
```

<h1 id="http-message-requestfactory">Final Class Phalcon\Http\Message\RequestFactory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/RequestFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\RequestInterface, Psr\Http\Message\RequestFactoryInterface, Psr\Http\Message\UriInterface | | Implements | RequestFactoryInterface |

PSR-17 RequestFactory

## メソッド

Create a new request.

```php
public function createRequest( string $method, mixed $uri ): RequestInterface;
```

<h1 id="http-message-response">Final Class Phalcon\Http\Message\Response</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Response.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Number, Phalcon\Http\Message\AbstractMessage, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\ResponseInterface | | Extends | AbstractMessage | | Implements | ResponseInterface |

PSR-7 Response

## Properties

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
private reasonPhrase = ;

/**
 * Gets the response status code.
 *
 * The status code is a 3-digit integer result code of the server's attempt
 * to understand and satisfy the request.
 *
 * @var int
 */
private statusCode = 200;

```

## メソッド

Response constructor.

```php
public function __construct( mixed $body = string, int $code = int, array $headers = [] );
```

```php
public function getReasonPhrase(): string
```

```php
public function getStatusCode(): int
```

Return an instance with the specified status code and, optionally, reason phrase.

If no reason phrase is specified, implementations MAY choose to default to the RFC 7231 or IANA recommended reason phrase for the response's status code.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the updated status and reason phrase.

@see http://tools.ietf.org/html/rfc7231#section-6 @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml

```php
public function withStatus( mixed $code, mixed $reasonPhrase = string ): Response;
```

<h1 id="http-message-responsefactory">Final Class Phalcon\Http\Message\ResponseFactory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/ResponseFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\ResponseInterface, Psr\Http\Message\ResponseFactoryInterface | | Implements | ResponseFactoryInterface |

PSR-17 ResponseFactory

## メソッド

Create a new response.

```php
public function createResponse( int $code = int, string $reasonPhrase = string ): ResponseInterface;
```

<h1 id="http-message-serverrequest">Final Class Phalcon\Http\Message\ServerRequest</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/ServerRequest.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Http\Message\Exception\InvalidArgumentException, Phalcon\Http\Message\Stream\Input, Psr\Http\Message\ServerRequestInterface, Psr\Http\Message\StreamInterface, Psr\Http\Message\UploadedFileInterface, Psr\Http\Message\UriInterface | | Extends | AbstractRequest | | Implements | ServerRequestInterface |

PSR-7 ServerRequest

## Properties

```php
/**
 * @var Collection
 */
private attributes;

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
private cookieParams;

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
private parsedBody;

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
private queryParams;

/**
 * Retrieve server parameters.
 *
 * Retrieves data related to the incoming request environment,
 * typically derived from PHP's $_SERVER superglobal. The data IS NOT
 * REQUIRED to originate from $_SERVER.
 *
 * @var array
 */
private serverParams;

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
private uploadedFiles;

```

## メソッド

ServerRequest constructor.

```php
public function __construct( string $method = string, mixed $uri = null, array $serverParams = [], mixed $body = string, mixed $headers = [], array $cookies = [], array $queryParams = [], array $uploadFiles = [], mixed $parsedBody = null, string $protocol = string );
```

Retrieve a single derived request attribute.

Retrieves a single derived request attribute as described in getAttributes(). If the attribute has not been previously set, returns the default value as provided.

This method obviates the need for a hasAttribute() method, as it allows specifying a default value to return if the attribute is not found.

```php
public function getAttribute( mixed $name, mixed $defaultValue = null ): mixed;
```

Retrieve attributes derived from the request.

The request 'attributes' may be used to allow injection of any parameters derived from the request: e.g., the results of path match operations; the results of decrypting cookies; the results of deserializing non-form-encoded message bodies; etc. Attributes will be application and request specific, and CAN be mutable.

```php
public function getAttributes(): array;
```

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

Return an instance with the specified derived request attribute.

This method allows setting a single derived request attribute as described in getAttributes().

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the updated attribute.

```php
public function withAttribute( mixed $name, mixed $value ): ServerRequest;
```

Return an instance with the specified cookies.

The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST be compatible with the structure of $_COOKIE. Typically, this data will be injected at instantiation.

This method MUST NOT update the related Cookie header of the request instance, nor related values in the server params.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the updated cookie values.

```php
public function withCookieParams( array $cookies ): ServerRequest;
```

Return an instance with the specified body parameters.

These MAY be injected during instantiation.

If the request Content-Type is either application/x-www-form-urlencoded or multipart/form-data, and the request method is POST, use this method ONLY to inject the contents of $_POST.

The data IS NOT REQUIRED to come from $_POST, but MUST be the results of deserializing the request body content. Deserialization/parsing returns structured data, and, as such, this method ONLY accepts arrays or objects, or a null value if nothing was available to parse.

As an example, if content negotiation determines that the request data is a JSON payload, this method could be used to create a request instance with the deserialized parameters.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the updated body parameters.

```php
public function withParsedBody( mixed $data ): ServerRequest;
```

Return an instance with the specified query string arguments.

These values SHOULD remain immutable over the course of the incoming request. They MAY be injected during instantiation, such as from PHP's $_GET superglobal, or MAY be derived from some other value such as the URI. In cases where the arguments are parsed from the URI, the data MUST be compatible with what PHP's parse_str() would return for purposes of how duplicate query parameters are handled, and how nested sets are handled.

Setting query string arguments MUST NOT change the URI stored by the request, nor the values in the server params.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the updated query string arguments.

```php
public function withQueryParams( array $query ): ServerRequest;
```

Create a new instance with the specified uploaded files.

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that has the updated body parameters.

```php
public function withUploadedFiles( array $uploadedFiles ): ServerRequest;
```

Return an instance that removes the specified derived request attribute.

This method allows removing a single derived request attribute as described in getAttributes().

This method MUST be implemented in such a way as to retain the immutability of the message, and MUST return an instance that removes the attribute.

```php
public function withoutAttribute( mixed $name ): ServerRequest;
```

<h1 id="http-message-serverrequestfactory">Class Phalcon\Http\Message\ServerRequestFactory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/ServerRequestFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Collection, Phalcon\Helper\Arr, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\ServerRequestFactoryInterface, Psr\Http\Message\ServerRequestInterface, Psr\Http\Message\UriInterface, Psr\Http\Message\UploadedFileInterface | | Implements | ServerRequestFactoryInterface |

PSR-17 ServerRequestFactory

## メソッド

Create a new server request.

Note that server-params are taken precisely as given - no parsing/processing of the given values is performed, and, in particular, no attempt is made to determine the HTTP method or URI, which must be provided explicitly.

```php
public function createServerRequest( string $method, mixed $uri, array $serverParams = [] ): ServerRequestInterface;
```

Create a request from the supplied superglobal values.

If any argument is not supplied, the corresponding superglobal value will be used.

```php
public function load( array $server = null, array $get = null, array $post = null, array $cookies = null, array $files = null ): ServerRequest;
```

Returns the apache_request_headers if it exists

```php
protected function getHeaders();
```

<h1 id="http-message-stream">Class Phalcon\Http\Message\Stream</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Stream.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Arr, Exception, Psr\Http\Message\StreamInterface, RuntimeException | | Implements | StreamInterface |

PSR-7 Stream

## Properties

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

## メソッド

Stream constructor.

```php
public function __construct( mixed $stream, string $mode = string );
```

Closes the stream when the destructed.

```php
public function __destruct();
```

Reads all data from the stream into a string, from the beginning to end.

This method MUST attempt to seek to the beginning of the stream before reading data and read the stream until the end is reached.

Warning: This could attempt to load a large amount of data into memory.

This method MUST NOT raise an exception in order to conform with PHP's string casting operations.

@see http://php.net/manual/en/language.oop5.magic.php#object.tostring

```php
public function __toString(): string;
```

Closes the stream and any underlying resources.

```php
public function close(): void;
```

Separates any underlying resources from the stream.

After the stream has been detached, the stream is in an unusable state.

```php
public function detach(): resource | null;
```

Returns true if the stream is at the end of the stream.

```php
public function eof(): bool;
```

Returns the remaining contents in a string

```php
public function getContents(): string;
```

Get stream metadata as an associative array or retrieve a specific key.

The keys returned are identical to the keys returned from PHP's stream_get_meta_data() function.

```php
public function getMetadata( mixed $key = null );
```

Get the size of the stream if known.

```php
public function getSize(): null | int;
```

Returns whether or not the stream is readable.

```php
public function isReadable(): bool;
```

Returns whether or not the stream is seekable.

```php
public function isSeekable(): bool;
```

Returns whether or not the stream is writable.

```php
public function isWritable(): bool;
```

Read data from the stream.

```php
public function read( mixed $length ): string;
```

Seek to the beginning of the stream.

If the stream is not seekable, this method will raise an exception; otherwise, it will perform a seek(0).

```php
public function rewind(): void;
```

Seek to a position in the stream.

```php
public function seek( mixed $offset, mixed $whence = int ): void;
```

Sets the stream - existing instance

```php
public function setStream( mixed $stream, string $mode = string ): void;
```

Returns the current position of the file read/write pointer

```php
public function tell(): int;
```

Write data to the stream.

```php
public function write( mixed $data ): int;
```

<h1 id="http-message-stream-input">Class Phalcon\Http\Message\Stream\Input</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Stream/Input.zep)

| Namespace | Phalcon\Http\Message\Stream | | Uses | Phalcon\Http\Message\Stream | | Extends | Stream |

Describes a data stream from "php://input"

Typically, an instance will wrap a PHP stream; this interface provides a wrapper around the most common operations, including serialization of the entire stream to a string.

## Properties

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

## メソッド

Input constructor.

```php
public function __construct();
```

Reads all data from the stream into a string, from the beginning to end.

This method MUST attempt to seek to the beginning of the stream before reading data and read the stream until the end is reached.

Warning: This could attempt to load a large amount of data into memory.

This method MUST NOT raise an exception in order to conform with PHP's string casting operations.

@see http://php.net/manual/en/language.oop5.magic.php#object.tostring

```php
public function __toString(): string;
```

Returns the remaining contents in a string

@throws RuntimeException if unable to read. @throws RuntimeException if error occurs while reading.

```php
public function getContents( int $length = int ): string;
```

Returns whether or not the stream is writeable.

```php
public function isWritable(): bool;
```

Read data from the stream.

```php
public function read( mixed $length ): string;
```

<h1 id="http-message-stream-memory">Class Phalcon\Http\Message\Stream\Memory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Stream/Memory.zep)

| Namespace | Phalcon\Http\Message\Stream | | Uses | Phalcon\Http\Message\Stream | | Extends | Stream |

Describes a data stream from "php://memory"

Typically, an instance will wrap a PHP stream; this interface provides a wrapper around the most common operations, including serialization of the entire stream to a string.

## メソッド

Constructor

```php
public function __construct( mixed $mode = string );
```

<h1 id="http-message-stream-temp">Class Phalcon\Http\Message\Stream\Temp</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Stream/Temp.zep)

| Namespace | Phalcon\Http\Message\Stream | | Uses | Phalcon\Http\Message\Stream | | Extends | Stream |

Describes a data stream from "php://temp"

Typically, an instance will wrap a PHP stream; this interface provides a wrapper around the most common operations, including serialization of the entire stream to a string.

## メソッド

Constructor

```php
public function __construct( mixed $mode = string );
```

<h1 id="http-message-streamfactory">Final Class Phalcon\Http\Message\StreamFactory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/StreamFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\StreamFactoryInterface, Psr\Http\Message\StreamInterface | | Implements | StreamFactoryInterface |

PSR-17 StreamFactory

## メソッド

Create a new stream from a string.

The stream SHOULD be created with a temporary resource.

```php
public function createStream( string $content = string ): StreamInterface;
```

Create a stream from an existing file.

The file MUST be opened using the given mode, which may be any mode supported by the `fopen` function.

The `$filename` MAY be any string supported by `fopen()`.

```php
public function createStreamFromFile( string $filename, string $mode = string ): StreamInterface;
```

Create a new stream from an existing resource.

The stream MUST be readable and may be writable.

```php
public function createStreamFromResource( mixed $phpResource ): StreamInterface;
```

<h1 id="http-message-uploadedfile">Final Class Phalcon\Http\Message\UploadedFile</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/UploadedFile.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Number, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\StreamInterface, Psr\Http\Message\UploadedFileInterface, RuntimeException | | Implements | UploadedFileInterface |

PSR-7 UploadedFile

## Properties

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

## メソッド

UploadedFile constructor.

```php
public function __construct( mixed $stream, int $size = null, int $error = int, string $clientFilename = null, string $clientMediaType = null );
```

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

Retrieve a stream representing the uploaded file.

This method MUST return a StreamInterface instance, representing the uploaded file. The purpose of this method is to allow utilizing native PHP stream functionality to manipulate the file upload, such as stream_copy_to_stream() (though the result will need to be decorated in a native PHP stream wrapper to work with such functions).

If the moveTo() method has been called previously, this method MUST raise an exception.

```php
public function getStream(): mixed;
```

Move the uploaded file to a new location.

Use this method as an alternative to move_uploaded_file(). This method is guaranteed to work in both SAPI and non-SAPI environments. Implementations must determine which environment they are in, and use the appropriate method (move_uploaded_file(), rename(), or a stream operation) to perform the operation.

$targetPath may be an absolute path, or a relative path. If it is a relative path, resolution should be the same as used by PHP's rename() function.

The original file or stream MUST be removed on completion.

If this method is called more than once, any subsequent calls MUST raise an exception.

When used in an SAPI environment where $_FILES is populated, when writing files via moveTo(), is_uploaded_file() and move_uploaded_file() SHOULD be used to ensure permissions and upload status are verified correctly.

If you wish to move to a stream, use getStream(), as SAPI operations cannot guarantee writing to stream destinations.

@see http://php.net/is_uploaded_file @see http://php.net/move_uploaded_file

```php
public function moveTo( mixed $targetPath ): void;
```

<h1 id="http-message-uploadedfilefactory">Final Class Phalcon\Http\Message\UploadedFileFactory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/UploadedFileFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\StreamInterface, Psr\Http\Message\UploadedFileInterface, Psr\Http\Message\UploadedFileFactoryInterface | | Implements | UploadedFileFactoryInterface |

PSR-17 UploadedFileFactory

## メソッド

Create a new uploaded file.

If a size is not provided it will be determined by checking the size of the stream.

@link http://php.net/manual/features.file-upload.post-method.php @link http://php.net/manual/features.file-upload.errors.php

```php
public function createUploadedFile( StreamInterface $stream, int $size = null, int $error = int, string $clientFilename = null, string $clientMediaType = null ): UploadedFileInterface;
```

<h1 id="http-message-uri">Final Class Phalcon\Http\Message\Uri</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/Uri.zep)

| Namespace | Phalcon\Http\Message | | Uses | Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Http\Message\Exception\InvalidArgumentException, Psr\Http\Message\UriInterface | | Extends | AbstractCommon | | Implements | UriInterface |

PSR-7 Uri

## Properties

```php
/**
 * Returns the fragment of the URL
 *
 * @return string
 */
private fragment = ;

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
private host = ;

/**
 * @var string
 */
private pass = ;

/**
 * Returns the path of the URL
 *
 * @return string
 */
private path = ;

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
private port;

/**
 * Returns the query of the URL
 *
 * @return string
 */
private query = ;

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
private scheme = https;

/**
 * @var string
 */
private user = ;

```

## メソッド

Uri constructor.

```php
public function __construct( string $uri = string );
```

Return the string representation as a URI reference.

Depending on which components of the URI are present, the resulting string is either a full URI or relative reference according to RFC 3986, Section 4.1. The method concatenates the various components of the URI, using the appropriate delimiters

```php
public function __toString(): string;
```

Retrieve the authority component of the URI.

```php
public function getAuthority(): string;
```

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

Retrieve the user information component of the URI.

If no user information is present, this method MUST return an empty string.

If a user is present in the URI, this will return that value; additionally, if the password is also present, it will be appended to the user value, with a colon (":") separating the values.

The trailing "@" character is not part of the user information and MUST NOT be added.

```php
public function getUserInfo(): string;
```

Return an instance with the specified URI fragment.

This method MUST retain the state of the current instance, and return an instance that contains the specified URI fragment.

Users can provide both encoded and decoded fragment characters. Implementations ensure the correct encoding as outlined in getFragment().

An empty fragment value is equivalent to removing the fragment.

```php
public function withFragment( mixed $fragment ): Uri;
```

Return an instance with the specified host.

This method MUST retain the state of the current instance, and return an instance that contains the specified host.

An empty host value is equivalent to removing the host.

```php
public function withHost( mixed $host ): Uri;
```

Return an instance with the specified path.

This method MUST retain the state of the current instance, and return an instance that contains the specified path.

The path can either be empty or absolute (starting with a slash) or rootless (not starting with a slash). Implementations MUST support all three syntaxes.

If an HTTP path is intended to be host-relative rather than path-relative then it must begin with a slash ("/"). HTTP paths not starting with a slash are assumed to be relative to some base path known to the application or consumer.

Users can provide both encoded and decoded path characters. Implementations ensure the correct encoding as outlined in getPath().

```php
public function withPath( mixed $path ): Uri;
```

Return an instance with the specified port.

This method MUST retain the state of the current instance, and return an instance that contains the specified port.

Implementations MUST raise an exception for ports outside the established TCP and UDP port ranges.

A null value provided for the port is equivalent to removing the port information.

```php
public function withPort( mixed $port ): Uri;
```

Return an instance with the specified query string.

This method MUST retain the state of the current instance, and return an instance that contains the specified query string.

Users can provide both encoded and decoded query characters. Implementations ensure the correct encoding as outlined in getQuery().

An empty query string value is equivalent to removing the query string.

```php
public function withQuery( mixed $query ): Uri;
```

Return an instance with the specified scheme.

This method MUST retain the state of the current instance, and return an instance that contains the specified scheme.

Implementations MUST support the schemes "http" and "https" case insensitively, and MAY accommodate other schemes if required.

An empty scheme is equivalent to removing the scheme.

```php
public function withScheme( mixed $scheme ): Uri;
```

Return an instance with the specified user information.

```php
public function withUserInfo( mixed $user, mixed $password = null ): Uri;
```

<h1 id="http-message-urifactory">Final Class Phalcon\Http\Message\UriFactory</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Message/UriFactory.zep)

| Namespace | Phalcon\Http\Message | | Uses | Psr\Http\Message\UriFactoryInterface, Psr\Http\Message\UriInterface | | Implements | UriFactoryInterface |

PSR-17 UriFactory

## メソッド

Returns a Locator object with all the helpers defined in anonynous functions

```php
public function createUri( string $uri = string ): UriInterface;
```

<h1 id="http-request">Class Phalcon\Http\Request</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Request.zep)

| Namespace | Phalcon\Http | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface, Phalcon\Helper\Json, Phalcon\Http\Request\File, Phalcon\Http\Request\FileInterface, Phalcon\Http\Request\Exception, UnexpectedValueException, stdClass | | Extends | AbstractInjectionAware | | Implements | RequestInterface |

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

## メソッド

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```

```php
public function get( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]

```php
public function getAcceptableContent(): array;
```

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]

```php
public function getBasicAuth(): array | null;
```

Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]

```php
public function getBestAccept(): string;
```

Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]

```php
public function getBestCharset(): string;
```

Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]

```php
public function getBestLanguage(): string;
```

Gets most possible client IPv4 Address. This method searches in `$_SERVER["REMOTE_ADDR"]` and optionally in `$_SERVER["HTTP_X_FORWARDED_FOR"]`

```php
public function getClientAddress( bool $trustForwardedHeader = bool ): string | bool;
```

Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]

```php
public function getClientCharsets(): array;
```

Gets content type which request has been made

```php
public function getContentType(): string | null;
```

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_DIGEST"]

```php
public function getDigestAuth(): array;
```

Retrieves a post value always sanitized with the preset filters

```php
public function getFilteredPost( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Retrieves a put value always sanitized with the preset filters

```php
public function getFilteredPut( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Retrieves a query/get value always sanitized with the preset filters

```php
public function getFilteredQuery( string $name = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets web page that refers active request. ie: http://www.google.com

```php
public function getHTTPReferer(): string;
```

Gets HTTP header from request data

```php
final public function getHeader( string $header ): string;
```

Returns the available headers in the request

<code>
$_SERVER = [
    "PHP_AUTH_USER" => "phalcon",
    "PHP_AUTH_PW"   => "secret",
];&lt;/p>

&lt;p>$headers = $request->getHeaders();&lt;/p>

&lt;p>echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=
</code>

```php
public function getHeaders(): array;
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
public function getHttpHost(): string;
```

```php
public function getHttpMethodParameterOverride(): bool
```

Gets decoded JSON HTTP raw request body

```php
public function getJsonRawBody( bool $associative = bool ): \stdClass | array | bool;
```

Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]

```php
public function getLanguages(): array;
```

Gets HTTP method which request has been made

If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method.

The _method request parameter can also be used to determine the HTTP method, but only if setHttpMethodParameterOverride(true) has been called.

The method is always an uppercased string.

```php
final public function getMethod(): string;
```

Gets information about the port on which the request is made.

```php
public function getPort(): int;
```

Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned

```php
// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");
```

```php
public function getPost( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets a variable from put request

```php
// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");
```

```php
public function getPut( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
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
public function getQuery( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets HTTP raw request body

```php
public function getRawBody(): string;
```

Gets HTTP schema (http/https)

```php
public function getScheme(): string;
```

Gets variable from $_SERVER superglobal

```php
public function getServer( string $name ): string | null;
```

Gets active server address IP

```php
public function getServerAddress(): string;
```

Gets active server name

```php
public function getServerName(): string;
```

Gets HTTP URI which request has been made to

```php
// Returns /some/path?with=queryParams
$uri = $request->getURI();

// Returns /some/path
$uri = $request->getURI(true);
```

```php
final public function getURI( bool $onlyPath = bool ): string;
```

Gets attached files as Phalcon\Http\Request\File instances

```php
public function getUploadedFiles( bool $onlySuccessful = bool, bool $namedKeys = bool ): FileInterface[];
```

Gets HTTP user agent used to made the request

```php
public function getUserAgent(): string;
```

Checks whether $_REQUEST superglobal has certain index

```php
public function has( string $name ): bool;
```

Returns if the request has files or not

```php
public function hasFiles(): bool;
```

Checks whether headers has certain index

```php
final public function hasHeader( string $header ): bool;
```

Checks whether $_POST superglobal has certain index

```php
public function hasPost( string $name ): bool;
```

Checks whether the PUT data has certain index

```php
public function hasPut( string $name ): bool;
```

Checks whether $_GET superglobal has certain index

```php
public function hasQuery( string $name ): bool;
```

Checks whether $_SERVER superglobal has certain index

```php
final public function hasServer( string $name ): bool;
```

Checks whether request has been made using ajax

```php
public function isAjax(): bool;
```

Checks whether HTTP method is CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"

```php
public function isConnect(): bool;
```

Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"

```php
public function isDelete(): bool;
```

Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"

```php
public function isGet(): bool;
```

Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"

```php
public function isHead(): bool;
```

Check if HTTP method match any of the passed methods When strict is true it checks if validated methods are real HTTP methods

```php
public function isMethod( mixed $methods, bool $strict = bool ): bool;
```

Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"

```php
public function isOptions(): bool;
```

Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"

```php
public function isPatch(): bool;
```

Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"

```php
public function isPost(): bool;
```

Checks whether HTTP method is PURGE (Squid and Varnish support). if _SERVER["REQUEST_METHOD"]==="PURGE"

```php
public function isPurge(): bool;
```

Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"

```php
public function isPut(): bool;
```

Checks whether request has been made using any secure layer

```php
public function isSecure(): bool;
```

Checks whether request has been made using SOAP

```php
public function isSoap(): bool;
```

Checks if the `Request::getHttpHost` method will be use strict validation of host name or not

```php
public function isStrictHostCheck(): bool;
```

Checks whether HTTP method is TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"

```php
public function isTrace(): bool;
```

Checks if a method is a valid HTTP method

```php
public function isValidHttpMethod( string $method ): bool;
```

Returns the number of files available

```php
public function numFiles( bool $onlySuccessful = bool ): long;
```

```php
public function setHttpMethodParameterOverride( bool $httpMethodParameterOverride )
```

Sets automatic sanitizers/filters for a particular field and for particular methods

```php
public function setParameterFilters( string $name, array $filters = [], array $scope = [] ): RequestInterface;
```

Sets if the `Request::getHttpHost` method must be use strict validation of host name or not

```php
public function setStrictHostCheck( bool $flag = bool ): RequestInterface;
```

Process a request header and return the one with best quality

```php
final protected function getBestQuality( array $qualityParts, string $name ): string;
```

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.

```php
final protected function getHelper( array $source, string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Process a request header and return an array of values with their qualities

```php
final protected function getQualityHeader( string $serverIndex, string $name ): array;
```

Recursively counts file in an array of files

```php
final protected function hasFileHelper( mixed $data, bool $onlySuccessful ): long;
```

Resolve authorization headers.

```php
protected function resolveAuthorizationHeaders(): array;
```

Smooth out $_FILES to have plain array with all files uploaded

```php
final protected function smoothFiles( array $names, array $types, array $tmp_names, array $sizes, array $errors, string $prefix ): array;
```

<h1 id="http-request-exception">Class Phalcon\Http\Request\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Request/Exception.zep)

| Namespace | Phalcon\Http\Request | | Extends | \Phalcon\Exception |

Phalcon\Http\Request\Exception

Exceptions thrown in Phalcon\Http\Request will use this class

<h1 id="http-request-file">Class Phalcon\Http\Request\File</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Request/File.zep)

| Namespace | Phalcon\Http\Request | | Implements | FileInterface |

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

## メソッド

Phalcon\Http\Request\File constructor

```php
public function __construct( array $file, mixed $key = null );
```

```php
public function getError(): string|null
```

```php
public function getExtension(): string
```

```php
public function getKey(): string|null
```

Returns the real name of the uploaded file

```php
public function getName(): string;
```

Gets the real mime type of the upload file using finfo

```php
public function getRealType(): string;
```

Returns the file size of the uploaded file

```php
public function getSize(): int;
```

Returns the temporary name of the uploaded file

```php
public function getTempName(): string;
```

Returns the mime type reported by the browser This mime type is not completely secure, use getRealType() instead

```php
public function getType(): string;
```

Checks whether the file has been uploaded via Post.

```php
public function isUploadedFile(): bool;
```

Moves the temporary file to a destination within the application

```php
public function moveTo( string $destination ): bool;
```

<h1 id="http-request-fileinterface">Interface Phalcon\Http\Request\FileInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Request/FileInterface.zep)

| Namespace | Phalcon\Http\Request |

Phalcon\Http\Request\FileInterface

Interface for Phalcon\Http\Request\File

## メソッド

Returns the error if any

```php
public function getError(): string | null;
```

Returns the real name of the uploaded file

```php
public function getName(): string;
```

Gets the real mime type of the upload file using finfo

```php
public function getRealType(): string;
```

Returns the file size of the uploaded file

```php
public function getSize(): int;
```

Returns the temporal name of the uploaded file

```php
public function getTempName(): string;
```

Returns the mime type reported by the browser This mime type is not completely secure, use getRealType() instead

```php
public function getType(): string;
```

Move the temporary file to a destination

```php
public function moveTo( string $destination ): bool;
```

<h1 id="http-requestinterface">Interface Phalcon\Http\RequestInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/RequestInterface.zep)

| Namespace | Phalcon\Http | | Uses | Phalcon\Http\Request\FileInterface, stdClass |

Interface for Phalcon\Http\Request

## メソッド

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");
```

```php
public function get( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]

```php
public function getAcceptableContent(): array;
```

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]

```php
public function getBasicAuth(): array | null;
```

Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]

```php
public function getBestAccept(): string;
```

Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]

```php
public function getBestCharset(): string;
```

Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]

```php
public function getBestLanguage(): string;
```

Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]

```php
public function getClientAddress( bool $trustForwardedHeader = bool ): string | bool;
```

Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]

```php
public function getClientCharsets(): array;
```

Gets content type which request has been made

```php
public function getContentType(): string | null;
```

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_DIGEST"]

```php
public function getDigestAuth(): array;
```

Gets web page that refers active request. ie: http://www.google.com

```php
public function getHTTPReferer(): string;
```

Gets HTTP header from request data

```php
public function getHeader( string $header ): string;
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
public function getHeaders(): array;
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
public function getHttpHost(): string;
```

Gets decoded JSON HTTP raw request body

```php
public function getJsonRawBody( bool $associative = bool ): stdClass | array | bool;
```

Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]

```php
public function getLanguages(): array;
```

Gets HTTP method which request has been made

If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method.

The _method request parameter can also be used to determine the HTTP method, but only if setHttpMethodParameterOverride(true) has been called.

The method is always an uppercased string.

```php
public function getMethod(): string;
```

Gets information about the port on which the request is made

```php
public function getPort(): int;
```

Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned

```php
// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");
```

```php
public function getPost( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets a variable from put request

```php
// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");
```

```php
public function getPut( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
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
public function getQuery( string $name = null, mixed $filters = null, mixed $defaultValue = null, bool $notAllowEmpty = bool, bool $noRecursive = bool ): mixed;
```

Gets HTTP raw request body

```php
public function getRawBody(): string;
```

Gets HTTP schema (http/https)

```php
public function getScheme(): string;
```

Gets variable from $_SERVER superglobal

```php
public function getServer( string $name ): string | null;
```

Gets active server address IP

```php
public function getServerAddress(): string;
```

Gets active server name

```php
public function getServerName(): string;
```

Gets HTTP URI which request has been made to

```php
// Returns /some/path?with=queryParams
$uri = $request->getURI();

// Returns /some/path
$uri = $request->getURI(true);
```

```php
public function getURI( bool $onlyPath = bool ): string;
```

Gets attached files as Phalcon\Http\Request\FileInterface compatible instances

```php
public function getUploadedFiles( bool $onlySuccessful = bool, bool $namedKeys = bool ): FileInterface[];
```

Gets HTTP user agent used to made the request

```php
public function getUserAgent(): string;
```

Checks whether $_REQUEST superglobal has certain index

```php
public function has( string $name ): bool;
```

Checks whether request include attached files

```php
public function hasFiles(): bool;
```

Checks whether headers has certain index

```php
public function hasHeader( string $header ): bool;
```

Checks whether $_POST superglobal has certain index

```php
public function hasPost( string $name ): bool;
```

Checks whether the PUT data has certain index

```php
public function hasPut( string $name ): bool;
```

Checks whether $_GET superglobal has certain index

```php
public function hasQuery( string $name ): bool;
```

Checks whether $_SERVER superglobal has certain index

```php
public function hasServer( string $name ): bool;
```

Checks whether request has been made using ajax. Checks if $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest"

```php
public function isAjax(): bool;
```

Checks whether HTTP method is CONNECT. if $_SERVER["REQUEST_METHOD"] === "CONNECT"

```php
public function isConnect(): bool;
```

Checks whether HTTP method is DELETE. if $_SERVER["REQUEST_METHOD"] === "DELETE"

```php
public function isDelete(): bool;
```

Checks whether HTTP method is GET. if $_SERVER["REQUEST_METHOD"] === "GET"

```php
public function isGet(): bool;
```

Checks whether HTTP method is HEAD. if $_SERVER["REQUEST_METHOD"] === "HEAD"

```php
public function isHead(): bool;
```

Check if HTTP method match any of the passed methods

```php
public function isMethod( mixed $methods, bool $strict = bool ): bool;
```

Checks whether HTTP method is OPTIONS. if $_SERVER["REQUEST_METHOD"] === "OPTIONS"

```php
public function isOptions(): bool;
```

Checks whether HTTP method is POST. if $_SERVER["REQUEST_METHOD"] === "POST"

```php
public function isPost(): bool;
```

Checks whether HTTP method is PURGE (Squid and Varnish support). if $_SERVER["REQUEST_METHOD"] === "PURGE"

```php
public function isPurge(): bool;
```

Checks whether HTTP method is PUT. if $_SERVER["REQUEST_METHOD"] === "PUT"

```php
public function isPut(): bool;
```

Checks whether request has been made using any secure layer

```php
public function isSecure(): bool;
```

Checks whether request has been made using SOAP

```php
public function isSoap(): bool;
```

Checks whether HTTP method is TRACE. if $_SERVER["REQUEST_METHOD"] === "TRACE"

```php
public function isTrace(): bool;
```

Returns the number of files available

```php
public function numFiles( bool $onlySuccessful = bool ): long;
```

<h1 id="http-response">Class Phalcon\Http\Response</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Response.zep)

| Namespace | Phalcon\Http | | Uses | DateTime, DateTimeZone, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Helper\Fs, Phalcon\Helper\Json, Phalcon\Http\Response\Exception, Phalcon\Http\Response\HeadersInterface, Phalcon\Http\Response\CookiesInterface, Phalcon\Url\UrlInterface, Phalcon\Mvc\ViewInterface, Phalcon\Http\Response\Headers, Phalcon\Di\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Implements | ResponseInterface, InjectionAwareInterface, EventsAwareInterface |

Part of the HTTP cycle is return responses to the clients. Phalcon\HTTP\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.

```php
$response = new \Phalcon\Http\Response();

$response->setStatusCode(200, "OK");
$response->setContent("<html><body>Hello</body></html>");

$response->send();
```

## Properties

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

## メソッド

Phalcon\Http\Response constructor

```php
public function __construct( mixed $content = null, mixed $code = null, mixed $status = null );
```

Appends a string to the HTTP response body

```php
public function appendContent( mixed $content ): ResponseInterface;
```

Gets the HTTP response body

```php
public function getContent(): string;
```

Returns cookies set by the user

```php
public function getCookies(): CookiesInterface;
```

Returns the internal dependency injector

```php
public function getDI(): DiInterface;
```

内部イベントマネージャーを返します

```php
public function getEventsManager(): ManagerInterface;
```

Returns headers set by the user

```php
public function getHeaders(): HeadersInterface;
```

Returns the reason phrase

```php
echo $response->getReasonPhrase();
```

```php
public function getReasonPhrase(): string | null;
```

Returns the status code

```php
echo $response->getStatusCode();
```

```php
public function getStatusCode(): int | null;
```

Checks if a header exists

```php
$response->hasHeader("Content-Type");
```

```php
public function hasHeader( string $name ): bool;
```

Check if the response is already sent

```php
public function isSent(): bool;
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
public function redirect( mixed $location = null, bool $externalRedirect = bool, int $statusCode = int ): ResponseInterface;
```

Remove a header in the response

```php
$response->removeHeader("Expires");
```

```php
public function removeHeader( string $name ): ResponseInterface;
```

Resets all the established headers

```php
public function resetHeaders(): ResponseInterface;
```

Prints out HTTP response to the client

```php
public function send(): ResponseInterface;
```

Sends cookies to the client

```php
public function sendCookies(): ResponseInterface;
```

Sends headers to the client

```php
public function sendHeaders(): ResponseInterface | bool;
```

Sets Cache headers to use HTTP cache

```php
$this->response->setCache(60);
```

```php
public function setCache( int $minutes ): ResponseInterface;
```

Sets HTTP response body

```php
$response->setContent("<h1>Hello!</h1>");
```

```php
public function setContent( string $content ): ResponseInterface;
```

Sets the response content-length

```php
$response->setContentLength(2048);
```

```php
public function setContentLength( int $contentLength ): ResponseInterface;
```

Sets the response content-type mime, optionally the charset

```php
$response->setContentType("application/pdf");
$response->setContentType("text/plain", "UTF-8");
```

```php
public function setContentType( string $contentType, mixed $charset = null ): ResponseInterface;
```

Sets a cookies bag for the response externally

```php
public function setCookies( CookiesInterface $cookies ): ResponseInterface;
```

Sets the dependency injector

```php
public function setDI( DiInterface $container ): void;
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
public function setEtag( string $etag ): ResponseInterface;
```

イベントマネージャーをセットします

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Sets an Expires header in the response that allows to use the HTTP cache

```php
$this->response->setExpires(
    new DateTime()
);
```

```php
public function setExpires( DateTime $datetime ): ResponseInterface;
```

Sets an attached file to be sent at the end of the request

```php
public function setFileToSend( string $filePath, mixed $attachmentName = null, mixed $attachment = bool ): ResponseInterface;
```

Overwrites a header in the response

```php
$response->setHeader("Content-Type", "text/plain");
```

```php
public function setHeader( string $name, mixed $value ): ResponseInterface;
```

Sets a headers bag for the response externally

```php
public function setHeaders( HeadersInterface $headers ): ResponseInterface;
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
public function setJsonContent( mixed $content, int $jsonOptions = int, int $depth = int ): ResponseInterface;
```

Sets Last-Modified header

```php
$this->response->setLastModified(
    new DateTime()
);
```

```php
public function setLastModified( DateTime $datetime ): ResponseInterface;
```

Sends a Not-Modified response

```php
public function setNotModified(): ResponseInterface;
```

Send a raw header to the response

```php
$response->setRawHeader("HTTP/1.1 404 Not Found");
```

```php
public function setRawHeader( string $header ): ResponseInterface;
```

Sets the HTTP response code

```php
$response->setStatusCode(404, "Not Found");
```

```php
public function setStatusCode( int $code, string $message = null ): ResponseInterface;
```

<h1 id="http-response-cookies">Class Phalcon\Http\Response\Cookies</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Response/Cookies.zep)

| Namespace | Phalcon\Http\Response | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Http\Cookie\Exception, Phalcon\Http\Cookie\CookieInterface | | Extends | AbstractInjectionAware | | Implements | CookiesInterface |

Phalcon\Http\Response\Cookies

This class is a bag to manage the cookies.

A cookies bag is automatically registered as part of the 'response' service in the DI. By default, cookies are automatically encrypted before being sent to the client and are decrypted when retrieved from the user. To set sign key used to generate a message authentication code use `Phalcon\Http\Response\Cookies::setSignKey()`.

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

## Properties

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

## メソッド

Phalcon\Http\Response\Cookies constructor

```php
public function __construct( bool $useEncryption = bool, string $signKey = null );
```

Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal

```php
public function delete( string $name ): bool;
```

Gets a cookie from the bag

```php
public function get( string $name ): CookieInterface;
```

Gets all cookies from the bag

```php
public function getCookies(): array;
```

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal

```php
public function has( string $name ): bool;
```

Returns if the bag is automatically encrypting/decrypting cookies

```php
public function isUsingEncryption(): bool;
```

Reset set cookies

```php
public function reset(): CookiesInterface;
```

Sends the cookies to the client Cookies aren't sent if headers are sent in the current request

```php
public function send(): bool;
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
public function set( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] ): CookiesInterface;
```

Sets the cookie's sign key.

The `$signKey' MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

Use NULL to disable cookie signing.

@see \Phalcon\Security\Random

```php
public function setSignKey( string $signKey = null ): CookieInterface;
```

Set if cookies in the bag must be automatically encrypted/decrypted

```php
public function useEncryption( bool $useEncryption ): CookiesInterface;
```

<h1 id="http-response-cookiesinterface">Interface Phalcon\Http\Response\CookiesInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Response/CookiesInterface.zep)

| Namespace | Phalcon\Http\Response | | Uses | Phalcon\Http\Cookie\CookieInterface |

Phalcon\Http\Response\CookiesInterface

Interface for Phalcon\Http\Response\Cookies

## メソッド

Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal

```php
public function delete( string $name ): bool;
```

Gets a cookie from the bag

```php
public function get( string $name ): CookieInterface;
```

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal

```php
public function has( string $name ): bool;
```

Returns if the bag is automatically encrypting/decrypting cookies

```php
public function isUsingEncryption(): bool;
```

Reset set cookies

```php
public function reset(): CookiesInterface;
```

Sends the cookies to the client

```php
public function send(): bool;
```

Sets a cookie to be sent at the end of the request

```php
public function set( string $name, mixed $value = null, int $expire = int, string $path = string, bool $secure = null, string $domain = null, bool $httpOnly = null, array $options = [] ): CookiesInterface;
```

Set if cookies in the bag must be automatically encrypted/decrypted

```php
public function useEncryption( bool $useEncryption ): CookiesInterface;
```

<h1 id="http-response-exception">Class Phalcon\Http\Response\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Response/Exception.zep)

| Namespace | Phalcon\Http\Response | | Extends | \Phalcon\Exception |

Phalcon\Http\Response\Exception

Exceptions thrown in Phalcon\Http\Response will use this class.

<h1 id="http-response-headers">Class Phalcon\Http\Response\Headers</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Response/Headers.zep)

| Namespace | Phalcon\Http\Response | | Implements | HeadersInterface |

Phalcon\Http\Response\Headers

This class is a bag to manage the response headers

## Properties

```php
//
protected headers;

```

## メソッド

Gets a header value from the internal bag

```php
public function get( string $name ): string | bool;
```

Sets a header to be sent at the end of the request

```php
public function has( string $name ): bool;
```

Removes a header to be sent at the end of the request

```php
public function remove( string $header ): HeadersInterface;
```

Reset set headers

```php
public function reset();
```

Sends the headers to the client

```php
public function send(): bool;
```

Sets a header to be sent at the end of the request

```php
public function set( string $name, string $value ): HeadersInterface;
```

Sets a raw header to be sent at the end of the request

```php
public function setRaw( string $header ): HeadersInterface;
```

Returns the current headers as an array

```php
public function toArray(): array;
```

<h1 id="http-response-headersinterface">Interface Phalcon\Http\Response\HeadersInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Response/HeadersInterface.zep)

| Namespace | Phalcon\Http\Response |

Phalcon\Http\Response\HeadersInterface

Interface for Phalcon\Http\Response\Headers compatible bags

## メソッド

Gets a header value from the internal bag

```php
public function get( string $name ): string | bool;
```

Returns true if the header is set, false otherwise

```php
public function has( string $name ): bool;
```

Reset set headers

```php
public function reset();
```

Sends the headers to the client

```php
public function send(): bool;
```

Sets a header to be sent at the end of the request

```php
public function set( string $name, string $value );
```

Sets a raw header to be sent at the end of the request

```php
public function setRaw( string $header );
```

<h1 id="http-responseinterface">Interface Phalcon\Http\ResponseInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/ResponseInterface.zep)

| Namespace | Phalcon\Http | | Uses | DateTime, Phalcon\Http\Response\HeadersInterface |

Phalcon\Http\Response

Interface for Phalcon\Http\Response

## メソッド

Appends a string to the HTTP response body

```php
public function appendContent( mixed $content ): ResponseInterface;
```

Gets the HTTP response body

```php
public function getContent(): string;
```

Returns headers set by the user

```php
public function getHeaders(): HeadersInterface;
```

Returns the status code

```php
public function getStatusCode(): int | null;
```

Checks if a header exists

```php
public function hasHeader( string $name ): bool;
```

Checks if the response was already sent

```php
public function isSent(): bool;
```

Redirect by HTTP to another action or URL

```php
public function redirect( mixed $location = null, bool $externalRedirect = bool, int $statusCode = int ): ResponseInterface;
```

Resets all the established headers

```php
public function resetHeaders(): ResponseInterface;
```

Prints out HTTP response to the client

```php
public function send(): ResponseInterface;
```

Sends cookies to the client

```php
public function sendCookies(): ResponseInterface;
```

Sends headers to the client

```php
public function sendHeaders(): ResponseInterface | bool;
```

Sets HTTP response body

```php
public function setContent( string $content ): ResponseInterface;
```

Sets the response content-length

```php
public function setContentLength( int $contentLength ): ResponseInterface;
```

Sets the response content-type mime, optionally the charset

```php
public function setContentType( string $contentType, mixed $charset = null ): ResponseInterface;
```

Sets output expire time header

```php
public function setExpires( DateTime $datetime ): ResponseInterface;
```

Sets an attached file to be sent at the end of the request

```php
public function setFileToSend( string $filePath, mixed $attachmentName = null ): ResponseInterface;
```

Overwrites a header in the response

```php
public function setHeader( string $name, mixed $value ): ResponseInterface;
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
public function setJsonContent( mixed $content ): ResponseInterface;
```

Sends a Not-Modified response

```php
public function setNotModified(): ResponseInterface;
```

Send a raw header to the response

```php
public function setRawHeader( string $header ): ResponseInterface;
```

Sets the HTTP response code

```php
public function setStatusCode( int $code, string $message = null ): ResponseInterface;
```

<h1 id="http-server-abstractmiddleware">Abstract Class Phalcon\Http\Server\AbstractMiddleware</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Server/AbstractMiddleware.zep)

| Namespace | Phalcon\Http\Server | | Uses | Psr\Http\Message\ResponseInterface, Psr\Http\Message\ServerRequestInterface, Psr\Http\Server\MiddlewareInterface, Psr\Http\Server\RequestHandlerInterface | | Implements | MiddlewareInterface |

Participant in processing a server request and response.

An HTTP middleware component participates in processing an HTTP message: by acting on the request, generating the response, or forwarding the request to a subsequent middleware and possibly acting on its response.

## メソッド

Process an incoming server request.

Processes an incoming server request in order to produce a response. If unable to produce the response itself, it may delegate to the provided request handler to do so.

```php
abstract public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface;
```

<h1 id="http-server-abstractrequesthandler">Abstract Class Phalcon\Http\Server\AbstractRequestHandler</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Http/Server/AbstractRequestHandler.zep)

| Namespace | Phalcon\Http\Server | | Uses | Psr\Http\Message\ResponseInterface, Psr\Http\Message\ServerRequestInterface, Psr\Http\Server\RequestHandlerInterface | | Implements | RequestHandlerInterface |

Handles a server request and produces a response.

An HTTP request handler process an HTTP request in order to produce an HTTP response.

## メソッド

Handles a request and produces a response.

May call other collaborating code to generate the response.

```php
abstract public function handle( ServerRequestInterface $request ): ResponseInterface;
```