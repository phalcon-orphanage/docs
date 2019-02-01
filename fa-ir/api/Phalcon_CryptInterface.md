---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\CryptInterface'
---
# Interface **Phalcon\CryptInterface**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cryptinterface.zep)

## روش ها

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