# Class **Phalcon\\Assets\\Exception**

*extends* class [Phalcon\Exception](/en/3.2/api/Phalcon_Exception)

*implements* [Throwable](http://php.net/manual/en/class.throwable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/exception.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

final private [Exception](http://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外のクローンを生成します。

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外のコンストラクタ

public **__wakeup** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外メッセージを取得します。

final public *int* **getCode** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外コードを取得します。

final public *string* **getFile** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外が発生したファイルを取得します。

final public *int* **getLine** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外が発生した行を取得します。

final public *array* **getTrace** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

スタックトレースを取得します。

final public [Exception](http://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

以前の例外を返します。

final public [Exception](http://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

スタックトレースを文字列として取得します。

public *string* **__toString** () inherited from [Exception](http://php.net/manual/en/class.exception.php)

例外を表す文字列