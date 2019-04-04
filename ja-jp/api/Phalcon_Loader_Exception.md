---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Loader\Exception'
---
# Class **Phalcon\Loader\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader/exception.zep)

## メソッド

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外のクローンを生成します。

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外のコンストラクタ

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外メッセージを取得します。

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外コードを取得します。

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外が発生したファイルを取得します。

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外が発生した行を取得します。

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

スタックトレースを取得します。

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

直前の例外を返します。

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

スタックトレースを文字列として取得します。

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

例外を表す文字列