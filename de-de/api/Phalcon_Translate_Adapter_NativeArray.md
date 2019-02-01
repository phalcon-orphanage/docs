---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Translate\Adapter\NativeArray'
---
# Class **Phalcon\Translate\Adapter\NativeArray**

*extends* abstract class [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

*implements* [Phalcon\Translate\AdapterInterface](Phalcon_Translate_AdapterInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/adapter/nativearray.zep)

Allows to define translation lists using PHP arrays

## Methoden

public **__construct** (*array* $options)

Phalcon\Translate\Adapter\NativeArray constructor

public **query** (*mixed* $index, [*mixed* $placeholders])

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

public **exists** (*mixed* $index)

Überprüft, ob ein Übersetzungsschlüssel im internen Array existiert

public **setInterpolator** ([Phalcon\Translate\InterpolatorInterface](Phalcon_Translate_InterpolatorInterface) $interpolator) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

...

public *string* **t** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

public *string* **_** (*string* $translateKey, [*array* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück (Alias der Methode ' t ')

public **offsetSet** (*string* $offset, *string* $value) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Legt einen Wert der Übersetzung fest

public **offsetExists** (*mixed* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Check whether a translation key exists

public **offsetUnset** (*string* $offset) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Entfernt eine Übersetzung aus dem Wörterbuch wieder

public *string* **offsetGet** (*string* $translateKey) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Gibt die Zeichenfolge Übersetzung des angegebenen Schlüssels zurück

protected **replacePlaceholders** (*mixed* $translation, [*mixed* $placeholders]) inherited from [Phalcon\Translate\Adapter](Phalcon_Translate_Adapter)

Ersetzt Platzhalter durch die übergebenen Werte