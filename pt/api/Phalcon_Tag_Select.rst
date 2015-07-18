Abstract class **Phalcon\\Tag\\Select**
=======================================

Generates a SELECT html tag using a static array of values or a Phalcon\\Mvc\\Model resultset


Methods
-------

public static  **selectField** (*array* $parameters, [*array* $data])

Generates a SELECT tag



private static  **_optionsFromResultset** (:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` $resultset, *array* $using, *mixed* $value, *string* $closeOption)

Generate the OPTION tags based on a resultset



private static  **_optionsFromArray** (*array* $data, *mixed* $value, *string* $closeOption)

Generate the OPTION tags based on an array



