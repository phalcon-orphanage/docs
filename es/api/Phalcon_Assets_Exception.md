# Clase **Phalcon\\Assets\\Exception**

*extends* class [Phalcon\Exception](/[[language]]/[[version]]/api/Phalcon_Exception)

*implementa* [Throwable](http://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/exception.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

final private [Exception](http://php.net/manual/en/class.exception.php) **__clone** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Clona la excepción

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) heredado de [Exception](http://php.net/manual/en/class.exception.php)

Constructor de la excepción

public **__wakeup** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Obtiene el mensaje de la excepción

final public *int* **getCode** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Obtiene el código de excepción

final public *string* **getFile** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Obtiene el archivo en el que se produjo la excepción

final public *int* **getLine** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Obtiene la línea en que se produjo la excepción

final public *array* **getTrace** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Obtiene el seguimiento de la pila (stack)

final public [Exception](http://php.net/manual/en/class.exception.php) **getPrevious** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Devuelve la excepción anterior

final public [Exception](http://php.net/manual/en/class.exception.php) **getTraceAsString** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Obtiene el seguimiento de la pila como una cadena

public *string* **__toString** () heredado de [Exception](http://php.net/manual/en/class.exception.php)

Representación de la excepción como una cadena