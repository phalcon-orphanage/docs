---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Version'
---
# Class **Phalcon\Version**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/version.zep)

Kelas ini memungkinkan untuk mendapatkan versi kerangka kerja yang terinstal

## Constants

*integer* **VERSION_MAJOR**

*integer* **VERSION_MEDIUM**

*integer* **VERSION_MINOR**

*integer* **VERSION_SPECIAL**

*integer* **VERSION_SPECIAL_NUMBER**

## Metode

protected static **_getVersion** ()

Area dimana nomor versi ditetapkan. The format is as follows: ABBCCDE A - Major version B - Med version (two digits) C - Min version (two digits) D - Special release: 1 = Alpha, 2 = Beta, 3 = RC, 4 = Stable E - Special release version i.e. RC1, Beta2 etc.

final protected static **_getSpecial** (*mixed* $special)

Menerjemahkan nomor ke rilis khusus Jika rilis khusus = 1 fungsi ini akan mengembalikan ALFA

public static **get** ()

Mengembalikan versi aktif (deretan)

```php
<?php

echo Phalcon\Version::get();

```

public static **getId** ()

Mengembalikan versi aktif numerik

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