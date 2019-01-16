* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Resource'

* * *

# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/resource.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

アセットリソースを表します。

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## メソッド

public **getType** ()

public **getPath** ()

public **getLocal** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

public **setType** (*mixed* $type)

リソースのタイプを設定します。

public **setPath** (*mixed* $path)

リソースのパスを設定します。

public **setLocal** (*mixed* $local)

リソースがローカル(local)か外部(external)かを設定します。

public **setFilter** (*mixed* $filter)

リソースをフィルターするかどうかを設定します。

public **setAttributes** (*array* $attributes)

追加の HTML 属性を設定します

public **setTargetUri** (*mixed* $targetUri)

生成するHTML のターゲット uri を設定します。

public **setSourcePath** (*mixed* $sourcePath)

リソースのソースパスを設定します。

public **setTargetPath** (*mixed* $targetPath)

リソースのターゲットパスを設定します。

public **getContent** ([*mixed* $basePath])

文字列としてリソースの内容を返します。 オプションとして、そのリソースの保管するベースパスを設定できます。

public **getRealTargetUri** ()

生成するHTML の実際のターゲット uri を返します。

public **getRealSourcePath** ([*mixed* $basePath])

リソースを保管する、完全な位置を返します。

public **getRealTargetPath** ([*mixed* $basePath])

リソースの書き込み先の完全な位置を返します。

public **getResourceKey** ()

リソースのキーを取得します。