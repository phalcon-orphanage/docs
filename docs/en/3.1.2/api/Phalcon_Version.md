# Class **Phalcon\\Version**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/version.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class allows to get the installed version of the framework


## Constants
*integer* **VERSION_MAJOR**

*integer* **VERSION_MEDIUM**

*integer* **VERSION_MINOR**

*integer* **VERSION_SPECIAL**

*integer* **VERSION_SPECIAL_NUMBER**

## Methods
protected static  **_getVersion** ()

Area where the version number is set. The format is as follows:
ABBCCDE
A - Major version
B - Med version (two digits)
C - Min version (two digits)
D - Special release: 1 = Alpha, 2 = Beta, 3 = RC, 4 = Stable
E - Special release version i.e. RC1, Beta2 etc.



final protected static  **_getSpecial** (*mixed* $special)

Translates a number to a special release
If Special release = 1 this function will return ALPHA



public static  **get** ()

Returns the active version (string)

```php
<?php

echo Phalcon\Version::get();

```



public static  **getId** ()

Returns the numeric active version

```php
<?php

echo Phalcon\Version::getId();

```



public static  **getPart** (*mixed* $part)

Returns a specific part of the version. If the wrong parameter is passed
it will return the full version

```php
<?php

echo Phalcon\Version::getPart(
    Phalcon\Version::VERSION_MAJOR
);

```



