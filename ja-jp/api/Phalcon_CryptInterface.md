* * *

layout: article language: 'ja-jp' version: '4.0' title: 'Phalcon\CryptInterface'

* * *

# Interface **Phalcon\CryptInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cryptinterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

abstract public **setCipher** (*mixed* $cipher)

...

abstract public **getCipher** ()

...

abstract public **setKey** (*mixed* $key)

...

abstract public **getKey** ()

...

abstract public **encrypt** (*mixed* $text, [*mixed* $key])

...

abstract public **decrypt** (*mixed* $text, [*mixed* $key])

...

abstract public **encryptBase64** (*mixed* $text, [*mixed* $key])

...

abstract public **decryptBase64** (*mixed* $text, [*mixed* $key])

...

abstract public **getAvailableCiphers** ()

...