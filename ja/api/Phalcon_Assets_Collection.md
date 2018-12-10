# Class **Phalcon\\Assets\\Collection**

*implements* [Countable](http://php.net/manual/en/class.countable.php), [Iterator](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/assets/collection.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

リソースのコレクションを表します。

## メソッド

public **getPrefix** ()

...

public **getLocal** ()

...

public **getResources** ()

...

public **getCodes** ()

...

public **getPosition** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

public **__construct** ()

Phalcon\\Assets\\Collection コンストラクタ

public **add** ([Phalcon\Assets\Resource](/en/3.2/api/Phalcon_Assets_Resource) $resource)

リソースをコレクションに追加します。

public **addInline** ([Phalcon\Assets\Inline](/en/3.2/api/Phalcon_Assets_Inline) $code)

インラインコードをコレクションに追加します。

public **has** ([Phalcon\Assets\ResourceInterface](/en/3.2/api/Phalcon_Assets_ResourceInterface) $resource)

このリソースがコレクションに加えられているかどうかをチェックします。

```php
<?php

use Phalcon\Assets\Resource;
use Phalcon\Assets\Collection;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // true

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

CSSリソースをコレクションに追加します。

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

インラインCSSをコレクションに追加します。

public [Phalcon\Assets\Collection](/en/3.2/api/Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Javascriptリソースをコレクションに追加します。

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

インラインJavascriptをコレクションに追加します。

public **count** ()

フォームの要素数を返します

public **rewind** ()

内部のイテレータを巻き戻します。

public **current** ()

イテレータ中の現在のリソースを返します。

public *int* **key** ()

イテレータ中の現在の位置/キーを返します。

public **next** ()

内部のイテレータの位置を次の位置に移動します。

public **valid** ()

イテレータ中の現在の要素が妥当かどうかチェックします。

public **setTargetPath** (*mixed* $targetPath)

フィルタリングされたまたは追加された出力のためのファイルの対象パスを設定します。

public **setSourcePath** (*mixed* $sourcePath)

このコレクション内のすべてのリソースの ベースソース パスを設定します

public **setTargetUri** (*mixed* $targetUri)

生成するHTML のターゲット uri を設定します。

public **setPrefix** (*mixed* $prefix)

すべてのリソースに共通したプレフィックスを設定します

public **setLocal** (*mixed* $local)

コレクションがデフォルトでローカルリソースを使用するかどうかを設定します。

public **setAttributes** (*array* $attributes)

追加の HTML 属性を設定します

public **setFilters** (*array* $filters)

コレクションのフィルター配列を設定します

public **setTargetLocal** (*mixed* $targetLocal)

ターゲットをローカルに設定します

public **join** (*mixed* $join)

コレクション内のフィルターされた全リソースが単一のファイルに結合するかどうかを設定します。

public **getRealTargetPath** (*mixed* $basePath)

フィルター または結合したコレクションの書き込み先の完全な位置を返します。

public **addFilter** ([Phalcon\Assets\FilterInterface](/en/3.2/api/Phalcon_Assets_FilterInterface) $filter)

フィルターをコレクションに追加します。

final protected **addResource** ([Phalcon\Assets\ResourceInterface](/en/3.2/api/Phalcon_Assets_ResourceInterface) $resource)

リソースまたはインラインコードをコレクションに追加します。