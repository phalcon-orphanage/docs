# Abstract class **Phalcon\\Validation\\Validator**

*implements* [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

バリデータの基本クラスです

## メソッド

public **__construct** ([*array* $options])

Phalcon\\Validation\\Validator のコンストラクタ

public **isSetOption** (*mixed* $key)

オプションが定義されているかをチェックします。

public **hasOption** (*mixed* $key)

オプションが定義されているかをチェックします。

public **getOption** (*mixed* $key, [*mixed* $defaultValue])

バリデータのオプションから一つのオプションを返します。 オプションが設定されていない場合はnullを返します。

public **setOption** (*mixed* $key, *mixed* $value)

バリデーターのオプションを設定します

abstract public **validate** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $attribute)

バリデーションの実行

protected **prepareLabel** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field)

フィールドのラベルを準備します。

protected **prepareMessage** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option])

バリデーションメッセージを準備します。

protected **prepareCode** (*mixed* $field)

バリデーションコードを準備します。