---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Version'
---

* [Phalcon\Version](#version)
        
<h1 id="version">Class Phalcon\Version</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Version.zep)

| Namespace  | Phalcon |

This class allows to get the installed version of the framework


## Constants
```php
const VERSION_MAJOR = 0;
const VERSION_MEDIUM = 1;
const VERSION_MINOR = 2;
const VERSION_SPECIAL = 3;
const VERSION_SPECIAL_NUMBER = 4;
```

## Methods
```php
public static function get(): string;
```
Returns the active version (string)

```php
echo Phalcon\Version::get();
```


```php
public static function getId(): string;
```
Returns the numeric active version

```php
echo Phalcon\Version::getId();
```


```php
public static function getPart( int $part ): string;
```
Returns a specific part of the version. If the wrong parameter is passed
it will return the full version

```php
echo Phalcon\Version::getPart(
    Phalcon\Version::VERSION_MAJOR
);
```


```php
protected static function _getVersion(): array;
```
Area where the version number is set. The format is as follows:
ABBCCDE

A - Major version
B - Med version (two digits)
C - Min version (two digits)
D - Special release: 1 = alpha, 2 = beta, 3 = RC, 4 = stable
E - Special release version i.e. RC1, Beta2 etc.


