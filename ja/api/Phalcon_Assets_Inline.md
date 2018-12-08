# Class **Phalcon\\Assets\\Inline**

*implements* [Phalcon\Assets\ResourceInterface](/en/3.2/api/Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/inline.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

インラインアセットを表します。

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");

```

## メソッド

public **getType** ()

...

public **getContent** ()

...

public **getFilter** ()

...

public **getAttributes** ()

...

public **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\\Assets\\Inline コンストラクタ

public **setType** (*mixed* $type)

インラインのタイプを設定します。

public **setFilter** (*mixed* $filter)

リソースをフィルターするかどうかを設定します。

public **setAttributes** (*array* $attributes)

追加の HTML 属性を設定します

public **getResourceKey** ()

リソースのキーを取得します。