---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Translate\Adapter'
---
# Abstract class **Phalcon\Translate\Adapter**

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter.zep)

Base class for Phalcon\Translate adapters

## Methoden

public **__construct** (*array* $options)

...

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders])

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

public *string* **_** (*string* $translateKey, [*array* $placeholders])

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück (Alias der Methode ' t ')

public **offsetSet** (*string* $offset, *string* $value)

Legt einen Wert der Übersetzung fest

public **offsetExists** (*mixed* $translateKey)

Check whether a translation key exists

public **offsetUnset** (*string* $offset)

Entfernt eine Übersetzung aus dem Wörterbuch wieder

public *string* **offsetGet** (*string* $translateKey)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders])

Ersetzt Platzhalter durch die übergebenen Werte

abstract public **query** (*mixed* $index, [*mixed* $placeholders]) inherited from [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface)

...

abstract public **exists** (*mixed* $index) inherited from [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface)

...