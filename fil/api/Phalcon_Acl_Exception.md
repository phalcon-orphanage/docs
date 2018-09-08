# Klase ng **Phalcon\\Acl\\Exception**

*extends* class [Phalcon\Exception](/en/3.2/api/Phalcon_Exception)

*implements* [Throwable](http://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/exception.zep" class="btn btn-default btn-sm">Mula sa Github</a>

## Mga Pamamaraan

final private [Exception](http://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

I-clone ang eksepsyon

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](http://php.net/manual/en/class.exception.php)

Exception constructor

pampublikong **__wakeup** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Makakakuha ng mensaheng Eksepsyon

final public *int* **getCode** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Makakakuha ng code ng Eksepsyon

final public *string* **getFile** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Makakakuha ng payl na kung saan ang eksepsyon ay naganap

final public *int* **getLine** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Makakakuha ng linya sa kung saan ang eksepsyon ay naganap

final public *array* **getTrace** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Makakakuha ng pag-trace ng stack

final public [Exception](http://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Ibabalik ang nakaraang eksepsyon

final public [Exception](http://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Makakakuha ang pag-trace sa stack bilang isang string

public *string* **__toString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

Ang String ang representasyon ng eksepsyon