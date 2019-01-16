* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Di\Exception'

* * *

# Class **Phalcon\Di\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/di/exception.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clona la excepción

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

Constructor de la excepción

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el mensaje de excepción

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el código de Exception

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el archivo en el que se produjo la excepción

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene la línea en que se produjo la excepción

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el seguimiento de la pila

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Devuelve la excepción anterior

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el seguimiento de la pila como una cadena

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Representación de la excepción como una cadena