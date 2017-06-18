アセット管理
=================

:code:`Phalcon\Assets` コンポーネントは、Web アプリケーション内の CSS や JavaScript などの静的リソースを管理することができます。

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` はサービスコンテナで使用可能で、コンテナが使用可能などの場所からもリソースを追加することが出来ます。

リソースの追加
----------------
Assets は CSS と JavaScript をビルトインリソースとしてサポートしています。必要であれば他のリソースを作成することが出来ます。Assets Manager はデフォルトで JavaScript と CSS のコレクションを持っています。

以下のようにして、これらのコレクションに簡単にリソースを追加することが出来ます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function index()
        {
            // CSSのローカルリソースを追加します
            $this->assets->addCss("css/style.css");
            $this->assets->addCss("css/index.css");

            // JavaScriptのローカルリソースを追加します
            $this->assets->addJs("js/jquery.js");
            $this->assets->addJs("js/bootstrap.min.js");
        }
    }

追加されたリソースはビューで出力することが出来ます。

.. code-block:: html+php

    <html>
        <head>
            <title>素晴らしいウェブサイトたち</title>

            <?php $this->assets->outputCss(); ?>
        </head>

        <body>
            <!-- ... -->

            <?php $this->assets->outputJs(); ?>
        </body>
    <html>

Volt で書くと:

.. code-block:: html+jinja

    <html>
        <head>
            <title>素晴らしいウェブサイトたち</title>

            {{ assets.outputCss() }}
        </head>

        <body>
            <!-- ... -->

            {{ assets.outputJs() }}
        </body>
    <html>

ページ読み込みパフォーマンス向上のため、JavaScript は :code:`<head>` の中よりも、HTML の最後に配置することを推奨します。

ローカル／リモートリソース
--------------------------
ローカルリソースは同じアプリケーションのドキュメントルートに配備されたものです。ローカルリソースの URL は `url` サービスによって生成されます（通常は :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` ）。

リモートリソースは CDN から提供される、jQuery や Bootstrap のようなライブラリです。

:code:`addCss()` と :code:`addJs()` の２番目のパラメータはリソースがローカルか否かを指定します(:code:`true` はローカルで :code:`false` はリモートを指しています)。デフォルトでは、Assets Manager はローカルとみなします:

.. code-block:: php

    <?php

    public function indexAction()
    {
        // ローカル CSS リソースの追加
        $this->assets->addCss("//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css", false);
        $this->assets->addCss("css/style.css", true);
        $this->assets->addCss("css/extra.css");
    }

コレクション
------------
コレクションは同じ種類のリソースをグループ化します。Assets Manager は暗黙的に css と js のコレクションを生成します。ビューへの配置を容易にするために、特定のリソースをグループ化するコレクションを追加することが出来ます。

.. code-block:: php

    <?php

    // head 部分に配置予定の JavaScript
    $headerCollection = $this->assets->collection("header");

    $headerCollection->addJs("js/jquery.js");
    $headerCollection->addJs("js/bootstrap.min.js");

    // HTML 末尾に配置予定の JavaScript
    $footerCollection = $this->assets->collection("footer");

    $footerCollection->addJs("js/jquery.js");
    $footerCollection->addJs("js/bootstrap.min.js");

ビューへ配置：

.. code-block:: html+php

    <html>
        <head>
			<title>素晴らしいウェブサイトたち</title>

            <?php $this->assets->outputJs("header"); ?>
        </head>

        <body>
            <!-- ... -->

            <?php $this->assets->outputJs("footer"); ?>
        </body>
    <html>

Volt で書くと:

.. code-block:: html+jinja

    <html>
        <head>
			<title>素晴らしいウェブサイトたち</title>

            {{ assets.outputCss("header") }}
        </head>

        <body>
            <!-- ... -->

            {{ assets.outputJs("footer") }}
        </body>
    <html>

プレフィックス
--------------
コレクションは URL のプレフィックスを付けることができ、簡単に配信元のサーバを切り替えることができます。

.. code-block:: php

    <?php

    $footerCollection = $this->assets->collection("footer");

    if ($config->environment === "development") {
        $footerCollection->setPrefix("/");
    } else {
        $footerCollection->setPrefix("http:://cdn.example.com/");
    }

    $footerCollection->addJs("js/jquery.js");
    $footerCollection->addJs("js/bootstrap.min.js");

メソッドチェインも使用できます:

.. code-block:: php

    <?php

    $headerCollection = $assets
        ->collection("header")
        ->setPrefix("http://cdn.example.com/")
        ->setLocal(false)
        ->addJs("js/jquery.js")
        ->addJs("js/bootstrap.min.js");

圧縮/フィルター
----------------------
:code:`Phalcon\Assets` には、JavaScript や CSS のサイズを小さくする機能が備わっています。これを利用すると開発者は、フィルタリング機能を備える Assets Manager を操作するコレクションを作ることが出来ます。更に、Douglas Crockford による Jsmin がコアエクステンションの一部になっており、パフォーマンスを最大化させる JavaScript ファイルのサイズを小さくさせることが出来ます。CSS では、Ryan Day による CSSMin が CSS ファイルを縮小させることも出来ます。

次の例は、リソースコレクションの縮小方法を示しています。

.. code-block:: php

    <?php

    $manager

        // これらの JavaScript はページ下部に配置されます
        ->collection("jsFooter")

        // 最終的に出力されるファイル名
        ->setTargetPath("final.js")

        // このURIで生成されたscriptタグ
        ->setTargetUri("production/final.js")

        // これはフィルタリングを必要としないリモートリソースです
        ->addJs("code.jquery.com/jquery-1.10.0.min.js", false, false)

        // これらはフィルタリングを必要とするローカルリソースです
        ->addJs("common-functions.js")
        ->addJs("page-functions.js")

        // 全てのリソースを1つのファイルに結合します
        ->join(true)

        // 組み込みの Jsmin フィルターを使います
        ->addFilter(
            new Phalcon\Assets\Filters\Jsmin()
        )

        // カスタムフィルターを使います
        ->addFilter(
            new MyApp\Assets\Filters\LicenseStamper()
        );

コレクションは JavaScript または CSS のリソースを含むことができますが両方はできません。いくつかのリソースはリモートにあるかもしれません、すなわち、それらは更に行われるフィルタリングのためにリモートのソースから HTTP を介して取得されます。取得のオーバーヘッドを排除するため、外部のリソースをローカルに変換することが推奨されています。

前述のように :code:`addJs()` メソッドはコレクションへリソースを追加するために使用され、
２番目のパラメータはリソースが外部かどうか指定し、
そして３番目のパラメータはそのリソースがフィルタリング対象とすべきか、残すべきかを指定します：

.. code-block:: php

    <?php

    // これらの JavaScript はページ下部に配置されます
	$jsFooterCollection = $manager->collection("jsFooter");

    // これはフィルタリングする必要のないリモートのリソースです
    $jsFooterCollection->addJs("code.jquery.com/jquery-1.10.0.min.js", false, false);

    // これらはフィルタリング必須のローカルリソースです
	$jsFooterCollection->addJs("common-functions.js");
    $jsFooterCollection->addJs("page-functions.js");

フィルタはコレクションに登録されています。複数のフィルタを利用でき、リソースの中のコンテンツは、フィルタを登録した順と同じ順序でフィルタにかけられます:

.. code-block:: php

    <?php

    // 組み込みの Jsmin フィルタを使う
    $jsFooterCollection->addFilter(
        new Phalcon\Assets\Filters\Jsmin()
    );

    // 自作フィルタを使う
    $jsFooterCollection->addFilter(
        new MyApp\Assets\Filters\LicenseStamper()
    );

組み込みのフィルタと自作フィルタ両方がコレクションに対して透過的に適用できることに留意してください。
最後のステップでは、コレクションのすべてのリソースを単一のファイル含めるのか、別々のものに振り分けるのかを決めます。コレクションにすべてのリソースをまとめる指示するには、「:code:`join()`」メソッドを利用できます.

リソースが結合できる場合、リソースを保存するために使用するファイルと、表示するための URL も定義する必要があります。
これらの設定は :code:`setTargetPath()` と :code:`setTargetUri()` で設定します。

.. code-block:: php

    <?php

    $jsFooterCollection->join(true);

    // 最後のファイルパスの名前です
    $jsFooterCollection->setTargetPath("public/production/final.js");

    // このスクリプトのHTMLタグがこのURIで生成されます
    $jsFooterCollection->setTargetUri("production/final.js");

もしリソースをまとめようとしているなら、私たちはリソースを保存するのに使うファイルがどれか、それを表示するのに使うファイルがどれかを定義する必要があります。これらの設定は、:code:`setTargetPath()` と :code:`setTargetUri()` で設定できます。

組み込みフィルタ
^^^^^^^^^^^^^^^^^^
Phalcon は、JavaScript と CSS のそれぞれに対して圧縮するための 2 つの組み込みフィルタを提供しています。それらの C 言語によるバックエンドは、このタスクを実行するためのオーバーヘッドを最小限に留めてくれます:

+---------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------+
| フィルタ                                                                          | 説明                                                                                                  |
+=================================================================================+==============================================================================================================+
| :doc:`Phalcon\\Assets\\Filters\\Jsmin <../api/Phalcon_Assets_Filters_Jsmin>`    | Javascript のインタプリタ・コンパイラに無視される不要な文字を削除することで Javascript を最小化                          |
+---------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Assets\\Filters\\Cssmin <../api/Phalcon_Assets_Filters_Cssmin>`  | ブラウザによって無視される不要な文字を削除することで CSS を最小化                                          |
+---------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------+

カスタムフィルタ
^^^^^^^^^^^^^^^^
ビルトインフィルタに加え、開発者は独自のフィルタを作成できます。 YUI_ 、 Sass_ 、 Closure_ などの既存のもっと高度なツールを活用することができます:

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * YUI 圧縮による CSS フィルタ
     *
     * @param string $contents
     * @return string
     */
    class CssYUICompressor implements FilterInterface
    {
        protected $_options;

        /**
         * CssYUICompressor constructor
         *
         * @param array $options
         */
        public function __construct(array $options)
        {
            $this->_options = $options;
        }

        /**
         * フィルタリング実行
         *
         * @param string $contents
         *
         * @return string
         */
        public function filter($contents)
        {
            // 文字列のコンテンツを一時ファイルに書き出す
            file_put_contents("temp/my-temp-1.css", $contents);

            system(
                $this->_options["java-bin"] .
                " -jar " .
                $this->_options["yui"] .
                " --type css " .
                "temp/my-temp-file-1.css " .
                $this->_options["extra-options"] .
                " -o temp/my-temp-file-2.css"
            );

            // ファイルのコンテンツを返す
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }

使用法:

.. code-block:: php

    <?php

    // CSS コレクションを取得する
    $css = $this->assets->get("head");

    // コレクションに YUI コンプレッサーフィルタを追加/有効にする
    $css->addFilter(
        new CssYUICompressor(
            [
                "java-bin"      => "/usr/local/bin/java",
                "yui"           => "/some/path/yuicompressor-x.y.z.jar",
                "extra-options" => "--charset utf8",
            ]
        )
    );

前の例では、:code:`LicenseStamper` を使いました:

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * ファイル上部にライセンスメッセージを追加します。
     *
     * @param string $contents
     *
     * @return string
     */
    class LicenseStamper implements FilterInterface
    {
        /**
         * フィルタリング実行
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {
            $license = "/* (c) 2015 あなたの名前がここにきます */";

            return $license . PHP_EOL . PHP_EOL . $contents;
        }
    }

カスタム出力
-------------
必要な HTML コードを生成する :code:`outputJs()` と :code:`outputCss()` メソッドがリソースのタイプに応じて利用できます。これらのメソッドをオーバーライドするか、次のようにリソースを手動で出力します:

.. code-block:: php

    <?php

    use Phalcon\Tag;

    $jsCollection = $this->assets->collection("js");

    foreach ($jsCollection as $resource) {
        echo Tag::javascriptInclude(
            $resource->getPath()
        );
    }

.. _YUI: http://yui.github.io/yuicompressor/
.. _Closure: https://developers.google.com/closure/compiler/?hl=fr
.. _Sass: http://sass-lang.com/
