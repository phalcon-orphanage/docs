# Clase Abstracta **Phalcon\\Tag\\Select**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/tag/select.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

Genera una etiqueta SELECT en HTML utilizando un arreglo estáticos de valores o un conjunto de resultados de un Phalcon\\Mvc\\Model

## Métodos

public static **selectField** (*array* $parameters, [*array* $data])

Genera una etiqueta SELECT

private static **_optionsFromResultset** ([Phalcon\Mvc\Model\Resultset](/[[language]]/[[version]]/api/Phalcon_Mvc_Model_Resultset) $resultset, *array* $using, *mixed* $value, *string* $closeOption)

Genera etiquetas OPTION basadas en un Resultset

private static **_optionsFromArray** (*array* $data, *mixed* $value, *string* $closeOption)

Genera etiquetas OPTION basadas en un arreglo