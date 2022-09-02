---
layout: default
title: 'Phalcon\Version'
---

* [Phalcon\Version](#version)

<h1 id="version">Class Phalcon\Version</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Version.zep)

| Namespace | Phalcon |

Esta clase permite obtener la versión instalada del framework


## Constantes
```php
const VERSION_MAJOR = 0;
const VERSION_MEDIUM = 1;
const VERSION_MINOR = 2;
const VERSION_SPECIAL = 3;
const VERSION_SPECIAL_NUMBER = 4;
```

## Métodos

```php
public static function get(): string;
```
Devuelve la versión activa (cadena)

```php
echo Phalcon\Version::get();
```


```php
public static function getId(): string;
```
Devuelve la versión activa en formato numérico

```php
echo Phalcon\Version::getId();
```


```php
public static function getPart( int $part ): string;
```
Devuelve una parte específica de la versión. Si se pasa el parámetro incorrecto devolverá la versión completa

```php
echo Phalcon\Version::getPart(
    Phalcon\Version::VERSION_MAJOR
);
```


```php
protected static function _getVersion(): array;
```
Área donde se encuentra el número de versión. El formato es el siguiente: ABBCCDE

A - Major version B - Med version (two digits) C - Min version (two digits) D - Special release: 1 = alpha, 2 = beta, 3 = RC, 4 = stable E - Special release version i.e. RC1, Beta2 etc.

@todo Eliminar en v5 @deprecated Usar getVersion()


```php
protected static function getVersion(): array;
```
Área donde se encuentra el número de versión. El formato es el siguiente: ABBCCDE

A - Major version B - Med version (two digits) C - Min version (two digits) D - Special release: 1 = alpha, 2 = beta, 3 = RC, 4 = stable E - Special release version i.e. RC1, Beta2 etc.
