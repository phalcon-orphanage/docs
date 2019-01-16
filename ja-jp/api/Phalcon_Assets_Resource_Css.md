* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Resource\Css'

* * *

# Class **Phalcon\Assets\Resource\Css**

*extends* class [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/resource/css.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

CSSのリソースを表します。

## メソッド

public **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

public **getType** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getLocal** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getFilter** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getAttributes** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getSourcePath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **setType** (*mixed* $type) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースのタイプを設定します。

public **setPath** (*mixed* $path) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースのパスを設定します。

public **setLocal** (*mixed* $local) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースがローカル(local)か外部(external)かを設定します。

public **setFilter** (*mixed* $filter) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースをフィルターするかどうかを設定します。

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

追加の HTML 属性を設定します

public **setTargetUri** (*mixed* $targetUri) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

生成するHTML のターゲット uri を設定します。

public **setSourcePath** (*mixed* $sourcePath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースのソースパスを設定します。

public **setTargetPath** (*mixed* $targetPath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースのターゲットパスを設定します。

public **getContent** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

文字列としてリソースの内容を返します。 オプションとして、そのリソースの保管するベースパスを設定できます。

public **getRealTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

生成するHTML の実際のターゲット uri を返します。

public **getRealSourcePath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースを保管する、完全な位置を返します。

public **getRealTargetPath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースの書き込み先の完全な位置を返します。

public **getResourceKey** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

リソースのキーを取得します。