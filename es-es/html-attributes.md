---
layout: default
title: 'Html Attributes'
keywords: 'html, attributes'
---

# HTML Components
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
The [Phalcon\Html\Attributes][html-attributes] is a wrapper of [Phalcon\Support\Collection](support-collection). Además contiene dos métodos más `render()` y `__toString()`. `render()` uses [Phalcon\Html\TagFactory](html-tagfactory) internally to render the attributes that an HTML element has. Estos atributos HTML son definidos en el propio objeto.

The component can be used on its own if you want to collect HTML attributes in an object and then _render_ them (return them as a string) in a `key=value` format.

Este componente se usa internamente por [Phalcon\Forms\Form](forms) para almacenar los atributos de elementos de formulario.

[html-attributes]: api/phalcon_html#html-attributes
