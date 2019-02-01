---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\CryptInterface'
---
# Interface **Phalcon\CryptInterface**

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cryptinterface.zep)

## Metodi

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