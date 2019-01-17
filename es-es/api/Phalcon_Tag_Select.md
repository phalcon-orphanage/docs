---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Tag\Select'
---
# Abstract class **Phalcon\Tag\Select**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/tag/select.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Generates a SELECT html tag using a static array of values or a Phalcon\Mvc\Model resultset

## Métodos

public static **selectField** (*array* $parameters, [*array* $data])

Genera una etiqueta SELECT

private static **_optionsFromResultset** ([Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset) $resultset, *array* $using, *mixed* $value, *string* $closeOption)

Genera etiquetas OPTION basadas en un Resultset

private static **_optionsFromArray** (*array* $data, *mixed* $value, *string* $closeOption)

Genera etiquetas OPTION basadas en un arreglo