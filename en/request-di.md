---
layout: article
language: 'en'
version: '4.0'
category: 'request'
---
# HTTP Request Component
<hr/>

## Dependency Injection
The [Phalcon\Http\Request](api/Phalcon_Http_Request) object implements the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.
