---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Factory'
---

* [Phalcon\Factory\AbstractFactory](#factory-abstractfactory)
* [Phalcon\Factory\Exception](#factory-exception)

<h1 id="factory-abstractfactory">Abstract Class Phalcon\Factory\AbstractFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Factory/AbstractFactory.zep)

| Namespace | Phalcon\Factory | | Uses | Phalcon\Config, Phalcon\Config\ConfigInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Propiedades

```php
/**
 * @var array
 */
protected mapper;

/**
 * @var array
 */
protected services;

```

## Métodos

```php
protected function checkConfig( mixed $config ): array;
```

Comprueba la configuración si es un objeto válido

```php
abstract protected function getAdapters(): array;
```

Devuelve los adaptadores de la factoría

```php
protected function getService( string $name ): mixed;
```

Comprueba si un servicio existe y lanza una excepción

```php
protected function init( array $services = [] ): void;
```

Constructor AdapterFactory.

<h1 id="factory-exception">Class Phalcon\Factory\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Factory/Exception.zep)

| Namespace | Phalcon\Factory | | Extends | \Phalcon\Exception |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.
