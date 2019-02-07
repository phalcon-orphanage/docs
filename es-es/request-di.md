---
layout: article
language: 'es-es'
version: '4.0'
category: 'request'
---
# Componente de Petición HTTP

* * *

## Inyección de Dependencias

The [Phalcon\Http\Request](api/Phalcon_Http_Request) object implements the [Phalcon\Di\InjectionAwareInterface](api/Phalcon_Di_InjectionAwareInterface) interface. As a result, the DI container is available and can be retrieved using the `getDI()` method. A container can also be set using the `setDI()` method.