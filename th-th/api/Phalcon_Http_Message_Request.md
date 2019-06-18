---
layout: default
language: 'th-th'
version: '4.0'
title: 'Phalcon\Http\Message\Request'
---

# Class **Phalcon\Http\Message\Request**

**implements** [Psr\Http\Message\RequestInterface](https://www.php-fig.org/psr/psr-7)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/message/request.zep)

This class represents an outgoing, client-side request as per the [PSR-7](https://www.php-fig.org/psr/psr-7) specification

Per the HTTP specification, this interface includes properties for each of the following:

- Protocol version
- HTTP method
- URI
- Headers
- Message body

During construction, implementations MUST attempt to set the Host header from a provided URI if no Host header is provided.

Requests are considered immutable; all methods that might change state MUST be implemented such that they retain the internal state of the current message and return an instance that contains the changed state.

## Methods

```php
string $method   // Default "GET"
mixed  $uri      // string or UriInterface
mixed  $body     // string or StreamInterface or resource
array  $headers  // Headers array for the Request

public function __construct( 
    [string $method = 'GET' [, $uri = null [, $body = 'php://temp' [, array $headers = []]]]]
) : void
```

Object constructor

* * *

```php
public function getBody() : StreamInterface
```

Gets the body of the message.

* * *

```php
public function getMethod(): string
```

Retrieves the HTTP method of the request.

* * *

```php
mixed $name // The name of the header

public function getHeader( mixed $name ): array
```

Retrieves a message header value by the given case-insensitive name. This method returns an array of all the header values of the given case-insensitive header name. If the header does not exist, an empty array is returned.

* * *

```php
mixed $name // The name of the header

public function getHeaderLine( mixed $name ): string
```

Retrieves a comma-separated string of the values for a single header. This method returns all of the header values of the given case-insensitive header name as a string concatenated together using a comma. If the header does not exist, an empty string is returned.

* * *

```php
public function getHeaders(): array
```

Retrieves all message header values. The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header.

```php
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
```

* * *

```php
public function getProtocolVersion(): string
```

Retrieves the HTTP protocol version as a string.

* * *

```php
public function getRequestTarget(): string
```

Retrieves the message's request target either as it will appear (for clients), as it appeared at request (for servers), or as it was specified for the instance (see `withRequestTarget()`). In most cases, this will be the origin-form of the composed URI, unless a value was provided to the concrete implementation (see `withRequestTarget()`).

* * *

```php
public function getUri() : UriInterface
```

Retrieves the URI instance.

* * *

```php
mixed $name // The name of the header

public function hasHeader( mixed $name ): bool
```

Checks if a header exists by the given case-insensitive name.

* * *

```php
mixed $name  // The name of the header
mixed $value // The value of the header

public function withAddedHeader($name, $value): Request {}
```

Return an instance with the specified header appended with the given value. Existing values for the specified header will be maintained. The new value(s) will be appended to the existing list. If the header did not exist previously, it will be added.

* * *

```php
StreamInterface $body // The message body of the request

public function withBody StreamInterface $body ): Request
```

Return an instance with the specified message body.

* * *

```php
mixed $name  // The name of the header
mixed $value // The value of the header

public function withHeader( mixed $name, mixed $value ): Request
```

Return an instance with the provided value replacing the specified header. While header names are case-insensitive, the casing of the header will be preserved by this function, and returned from `getHeaders()`.

Throws `\InvalidArgumentException` for invalid header names or values.

* * *

```php
mixed $method // The method name

public function withMethod($method): Request
```

Return an instance with the provided HTTP method.

Throws `\InvalidArgumentException` for invalid HTTP methods.

* * *

```php
public function withProtocolVersion( mixed $version ): Request
```

Return an instance with the specified HTTP protocol version.

* * *

```php
mixed $requestTarget // The request target

public function withRequestTarget( mixed $requestTarget ): Request
```

Return an instance with the specific request-target. If the request needs a non-origin-form request-target - e.g., for specifying an absolute-form, authority-form, or asterisk-form this method may be used to create an instance with the specified request-target, verbatim.

<http://tools.ietf.org/html/rfc7230#section-5.3>

* * *

```php
UriInterface $uri          // The Uri required
bool         $preserveHost // Flag to preserve the host or not

public function withUri(UriInterface $uri, mixed $preserveHost = false): Request
```

Returns an instance with the provided URI. This method updates the `Host` header of the returned request by default if the URI contains a host component. If the URI does not contain a host component, any pre-existing Host header is carried over to the returned request.

You can opt-in to preserving the original state of the Host header by setting `$preserveHost` to `true`. When `$preserveHost` is set to `true`, this method interacts with the Host header in the following ways:

- If the Host header is missing or empty, and the new URI contains a host component, this method MUST update the Host header in the returned request.
- If the Host header is missing or empty, and the new URI does not contain a host component, this method MUST NOT update the Host header in the returned request.
- If a Host header is present and non-empty, this method does not update the Host header in the returned request.

<http://tools.ietf.org/html/rfc3986#section-4.3>

* * *

```php
mixed $name  // The name of the header

public function withoutHeader( mixed $name ): Request
```

Return an instance without the specified header. Resolution of the headers is done in a case-insensitive manner.

* * *