---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'request'
---
# HTTP Request Component

* * *

## Dependency Injection

The [Phalcon\Http\Request](api/Phalcon_Http_Request) object implements the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.

<a name='events'></a>

## Olaylar

| Event                        | Description                                      |
| ---------------------------- | ------------------------------------------------ |
| `afterAuthorizationResolve`  | Fires when the authorization has been resolved   |
| `beforeAuthorizationResolve` | Fires before the authorization has been resolved |

When using HTTP authorization, the `Authorization` header has the following format:

```text
Authorization: <type> <credentials>
```

where `<type>` is an authentication type. A common type is `Basic`. Additional authentication types are described in [IANA registry of Authentication schemes](https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml) and [Authentication for AWS servers (AWS4-HMAC-SHA256)](https://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-auth-using-authorization-header.html). In most use cases the authentication type is: * `AWS4-HMAC-SHA256` * `Basic` * `Bearer` * `Digest` * `HOBA` * `Mutual` * `Negotiate` * `OAuth` * `SCRAM-SHA-1` * `SCRAM-SHA-256` * `vapid`

You can use the `request:beforeAuthorizationResolve` and `request:afterAuthorizationResolve` events to perform additional operations before or after the authorization resolves. A custom authorization resolver is required.

Example without using custom authorization resolver:

```php
<?php

use Phalcon\Http\Request;

$_SERVER['HTTP_AUTHORIZATION'] = 'Enigma Secret';

$request = new Request();
print_r($request->getHeaders());
```

Result:

```bash
Array
(
    [Authorization] => Enigma Secret
)

Type: Enigma
Credentials: Secret
```

Example using custom authorization resolver:

```php
<?php

use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Events\Manager;

class NegotiateAuthorizationListener
{
    public function afterAuthorizationResolve(Event $event, Request $request, array $data)
    {
        if (empty($data['server']['CUSTOM_KERBEROS_AUTH'])) {
            return false;
        }

        list($type,) = explode(' ', $data['server']['CUSTOM_KERBEROS_AUTH'], 2);

        if (!$type || stripos($type, 'negotiate') !== 0) {
            return false;
        }

        return [
           'Authorization'=> $data['server']['CUSTOM_KERBEROS_AUTH'],
        ];
    }
}

$_SERVER['CUSTOM_KERBEROS_AUTH'] = 'Negotiate a87421000492aa874209af8bc028';

$di = new Di();

$di->set('eventsManager', function () {
    $manager = new Manager();
    $manager->attach('request', new NegotiateAuthorizationListener());

    return $manager;
});

$request = new Request();
$request->setDI($di);

print_r($request->getHeaders());
```

Result:

```bash
Array
(
    [Authorization] => Negotiate a87421000492aa874209af8bc028
)

Type: Negotiate
Credentials: a87421000492aa874209af8bc028
```