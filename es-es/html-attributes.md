---
layout: default
language: 'es-es'
version: '5.0'
title: 'Html Attributes'
keywords: 'html, attributes'
---

# HTML Components
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
The [Phalcon\Html\Attributes][html-attributes] is a wrapper of [Phalcon\Collection](support-collection). Además contiene dos métodos más `render()` y `__toString()`. `render()` uses [Phalcon\Html\TagFactory](html-tagfactory) internally to render the attributes that a HTML element has. Estos atributos HTML son definidos en el propio objeto.

El componente se puede usar por si mismo si quieres recopilar atributos HTML en un objeto y luego renderizarlos (devolviéndolos como una cadena) en un formato `clave=valor`.

Este componente se usa internamente por [Phalcon\Forms\Form](forms) para almacenar los atributos de elementos de formulario.

[html-attributes]: api/phalcon_html#html-attributes
