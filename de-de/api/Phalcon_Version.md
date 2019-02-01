---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Version'
---
# Class **Phalcon\Version**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/version.zep)

Diese Klasse ermöglicht es, die installierte Version des Frameworks zu erhalten

## Konstanten

*integer* **VERSION_MAJOR**

*integer* **VERSION_MEDIUM**

*integer* **VERSION_MINOR**

*integer* **VERSION_SPECIAL**

*integer* **VERSION_SPECIAL_NUMBER**

## Methoden

protected static **_getVersion** ()

Bereich wo die Versionsnummer festgelegt wird. Das Format ist wie folgt aufgebaut: ABBCCDE A - Major version B - Med version (zweistellig) C - Min version (zweistellig) D - Special release: 1 = Alpha, 2 = Beta, 3 = RC, 4 = Stabil E - Special release version i.e. RC1, Beta2 etc.

final protected static **_getSpecial** (*mixed* $special)

Übersetzt eine Zahl, in eine Special release Wenn das special Release = 1 ist, gibt die Funktion ALPHA zurück

public static **get** ()

Gibt die aktive Version zurück (Zeichenfolge)

```php
<?php

echo Phalcon\Version::get();

```

public static **getId** ()

Gibt die numerische aktive version zurück

```php
<?php

echo Phalcon\Version::getId();

```

public static **getPart** (*mixed* $part)

Returns a specific part of the version. If the wrong parameter is passed it will return the full version

```php
<?php

echo Phalcon\Version::getPart(
    Phalcon\Version::VERSION_MAJOR
);

```