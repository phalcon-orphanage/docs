---
layout: default
language: 'cs-cz'
version: '5.0'
title: 'Html Attributes'
keywords: 'html, attributes'
---

# HTML Components
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
The [Phalcon\Html\Attributes][html-attributes] is a wrapper of [Phalcon\Collection](support-collection). It also contains two more methods `render()` and `__toString()`. `render()` uses [Phalcon\Html\TagFactory](html-tagfactory) internally to render the attributes that a HTML element has. These HTML attributes are defined in the object itself.

The component can be used on its own if you want to collect HTML attributes in an object and then _render) them (return them as a string) in a `key=value` format.

This component is used internally by [Phalcon\Forms\Form](forms) to store the attributes of form elements.

[html-attributes]: api/phalcon_html#html-attributes
