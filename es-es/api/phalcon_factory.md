---
layout: default
title: 'Phalcon\Factory'
---

* [Phalcon\Factory\AbstractConfigFactory](#factory-abstractconfigfactory)
* [Phalcon\Factory\AbstractFactory](#factory-abstractfactory)
* [Phalcon\Factory\Exception](#factory-exception)

<h1 id="factory-abstractconfigfactory">Abstract Class Phalcon\Factory\AbstractConfigFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Factory/AbstractConfigFactory.zep)

| Namespace  | Phalcon\Factory | | Uses       | Phalcon\Config\ConfigInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
protected function checkConfig( mixed $config ): array;
```
Comprueba la configuración si es un objeto válido


```php
protected function checkConfigElement( array $config, string $element ): array;
```
Checks if the config has "adapter"


```php
protected function getException( string $message ): \Exception;
```
Returns the exception object for the child class


```php
protected function getExceptionClass(): string;
```





<h1 id="factory-abstractfactory">Abstract Class Phalcon\Factory\AbstractFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Factory/AbstractFactory.zep)

| Namespace  | Phalcon\Factory | | Uses       | Phalcon\Config\ConfigInterface | | Extends    | AbstractConfigFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

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
protected function getService( string $name ): mixed;
```
Comprueba si un servicio existe y lanza una excepción


```php
abstract protected function getServices(): array;
```
Devuelve los adaptadores de la fábrica


```php
protected function init( array $services = [] ): void;
```
Initialize services/add new services




<h1 id="factory-exception">Class Phalcon\Factory\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Factory/Exception.zep)

| Namespace  | Phalcon\Factory | | Extends    | \Exception |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.
