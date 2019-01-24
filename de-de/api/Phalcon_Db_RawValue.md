---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Db\RawValue'
---
# Class **Phalcon\Db\RawValue**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/rawvalue.zep)

Mithilfe dieser Klasse können Sie Roh-Daten ohne Zitierung oder Formatierung einfügen/aktualisieren.

Das nächste Beispiel zeigt, wie die MySQL now() Funktion als Wert für ein Feld verwenden wird.

```php
<?php

$subscriber = new Subscribers();

$subscriber->email     = "andres@phalconphp.com";
$subscriber->createdAt = new \Phalcon\Db\RawValue("now()");

$subscriber->save();

```

## Methoden

public **getValue** ()

Rohwert ohne Zitierung oder Formatierung

public **__toString** ()

Rohwert ohne Zitierung oder Formatierung

public **__construct** (*mixed* $value)

Phalcon\Db\RawValue constructor