* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Manager'

* * *

# Class **Phalcon\Assets\Manager**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/manager.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

CSS/Javascriptのアセットのコレクションを管理します。

## メソッド

public **__construct** ([*array* $options])

public **setOptions** (*array* $options)

マネージャーのオプションを設定します。

public **getOptions** ()

マネージャーのオプションを返します。

public **useImplicitOutput** (*mixed* $implicitOutput)

生成したHTMLを直接表示するか、それとも返すかを設定します。

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

CSSリソースを'css'コレクションに追加します。

```php
<?php

$assets->addCss("css/bootstrap.css");
$assets->addCss("https://bootstrap.my-cdn.com/style.css", false);

```

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

インラインCSSを 'css'コレクションに追加します。

public **addJs** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Javascriptリソースを 'js' コレクションに追加します。

```php
<?php

$assets->addJs("scripts/jquery.js");
$assets->addJs("https://jquery.my-cdn.com/jquery.js", false);

```

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

インラインJavascriptを 'js' コレクションに追加します。

public **addResourceByType** (*mixed* $type, [Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

そのタイプによってリソースを追加します

```php
<?php

$assets->addResourceByType("css",
    new \Phalcon\Assets\Resource\Css("css/style.css")
);

```

public **addInlineCodeByType** (*mixed* $type, [Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

そのタイプによってインラインコードを追加します

public **addResource** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

生のリソースをマネージャーに追加します。

```php
<?php

$assets->addResource(
    new Phalcon\Assets\Resource("css", "css/style.css")
);

```

public **addInlineCode** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

生のインラインコードをマネージャーに追加します。

public **set** (*mixed* $id, [Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection)

アセットマネージャのコレクションを設定する。

```php
<?php

$assets->set("js", $collection);

```

public **get** (*mixed* $id)

Idによってコレクションを返します。

```php
<?php

$scripts = $assets->get("js");

```

public **getCss** ()

アセットのCSSコレクションを返します。

public **getJs** ()

アセットのCSSコレクションを返します。

public **collection** (*mixed* $name)

リソースのコレクションを作成または返します。

public **output** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *callback* $callback, *string* $type)

コレクションを縦断して、そのHTMLを生成するためのコールバックを呼び出します。

public **outputInline** ([Phalcon\Assets\Collection](Phalcon_Assets_Collection) $collection, *string* $type)

コレクションを縦断してHTMLを生成します。

public **outputCss** ([*string* $collectionName])

CSSリソースのためにHTMLを出力します。

public **outputInlineCss** ([*string* $collectionName])

インラインCSSのためにHTMLを出力します。

public **outputJs** ([*string* $collectionName])

JSリソースのためにHTMLを出力します。

public **outputInlineJs** ([*string* $collectionName])

インラインJSのためにHTMLを出力します。

public **getCollections** ()

マネージャー中にある既存のコレクションを返します。

public **exists** (*mixed* $id)

コレクションが存在するかどうか、真偽値を返します。

```php
<?php

if ($assets->exists("jsHeader")) {
    // \Phalcon\Assets\Collection
    $collection = $assets->get("jsHeader");
}

```