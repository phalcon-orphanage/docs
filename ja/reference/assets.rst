アセット管理
=================

Phalcon\\Assets コンポーネントは、Webアプリケーション内のCSSやJavaScriptなどの静的リソースを管理することができます。

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` はサービスコンテナで使用可能で、コンテナが使用可能などの場所からもリソースを追加することが出来ます。

リソースの追加
----------------
AssetsはCSSとJavaScriptをビルドインリソースとしてサポートしています。必要であれば他のリソースを作成することが出来ます。Assets ManagerはデフォルトでJavaScriptとCSSのコレクションを持っています。

以下のようにして、これらのコレクションに簡単にリソースを追加することが出来ます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function index()
        {
            // CSSのローカルリソースを追加します
            $this->assets
                ->addCss('css/style.css')
                ->addCss('css/index.css');

            // JavaScriptのローカルリソースを追加します
            $this->assets
                ->addJs('js/jquery.js')
                ->addJs('js/bootstrap.min.js');
        }
    }

追加されたリソースはビューで出力することが出来ます。

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>
            <?php $this->assets->outputCss() ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs() ?>
        </body>
    <html>

Volt syntax:

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>
              {{ assets.outputCss() }}
        </head>
        <body>

            <!-- ... -->

            {{ assets.outputJs() }}
        </body>
    <html>

ローカル／リモートリソース
----------------------
ローカルリソースは同じアプリケーションのドキュメントルートに配備されたものです。ローカルリソースのURLは`URL`サービスによって生成されます（通常は :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` ）。

リモートリソースはCDNから提供される、jQueryやBootstrapのようなライブラリです。

.. code-block:: php

    <?php

    public function indexAction()
    {
        // Add some local CSS resources
        $this->assets
            ->addCss('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css', false)
            ->addCss('css/style.css', true);
    }

コレクション
-----------
コレクションは同じ種類のリソースをグループ化します。Asset Managerは暗黙的にcssとjsのコレクションを生成します。ビューへの配置を容易にするために、特定のリソースをグループ化するコレクションを追加することが出来ます。

.. code-block:: php

    <?php

    // ヘッダーのJavaScript
    $this->assets
        ->collection('header')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

    // フッターのJavaScript
    $this->assets
        ->collection('footer')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

ビューへ配置：

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>
            <?php $this->assets->outputJs('header') ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs('footer') ?>
        </body>
    <html>

Volt syntax:

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>
              {{ assets.outputCss('header') }}
        </head>
        <body>

            <!-- ... -->

            {{ assets.outputJs('footer') }}
        </body>
    <html>

プレフィックス
--------
コレクションはURLのプレフィックスを付けることができ、簡単に配信元のサーバを切り替えることができます。

.. code-block:: php

    <?php

    $scripts = $this->assets->collection('footer');

    if ($config->environment == 'development') {
        $scripts->setPrefix('/');
    } else {
        $scripts->setPrefix('http:://cdn.example.com/');
    }

    $scripts->addJs('js/jquery.js')
            ->addJs('js/bootstrap.min.js');

メソッドチェインも使用できます:

.. code-block:: php

    <?php

    $scripts = $assets
        ->collection('header')
        ->setPrefix('http://cdn.example.com/')
        ->setLocal(false)
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

圧縮/フィルター
----------------------
Phalcon\\Assets には、JavaScriptやCSSのサイズを小さくする機能が備わっています。これを利用すると開発者は、フィルタリング機能を備えるAssets Managerを操作するコレクションを作ることが出来ます。更に、Douglas CrockfordによるJsminがコアエクステンションの一分になっており、パフォーマンスを最大化させるJavaScriptファイルのサイズを小さくさせることが出来ます。CSSでは、Ryan DayによるCSSMinがCSSファイルを縮小させることも出来ます。

次の例は、リソースコレクションの縮小方法を示しています。

.. code-block:: php

    <?php

    $manager

        // これらのJavaScriptはページ下部に配置されます
        ->collection('jsFooter')

        // 最終的に出力されるファイル名
        ->setTargetPath('final.js')

        // このURIで生成されたscriptタグ
        ->setTargetUri('production/final.js')

        // これはフィルタリングを必要としないリモートリソースです
        ->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false)

        // これらはフィルタリングを必要とするローカルリソースです
        ->addJs('common-functions.js')
        ->addJs('page-functions.js')

        // 全てのリソースを1つのファイルに結合します
        ->join(true)

        // 組み込みのJsminフィルターを使います
        ->addFilter(new Phalcon\Assets\Filters\Jsmin())

        // カスタムフィルターを使います
        ->addFilter(new MyApp\Assets\Filters\LicenseStamper());

これは、アセットマネージャーからリソースのコレクションの取得を始めます。javascript や css のリソースを含むことができるコレクションですが、両方を含むことはできません。いくつかのリソースはリモートにあるかもしれません、すなわち、それらはさらなるフィルタリングのためにリモートのソースからHTTPを介して取得されます。取得のオーバーヘッドを排除するため、外部のリソースをローカルに変換することが推奨されています。

.. code-block:: php

    <?php

    // These Javascripts are located in the page's bottom
    $js = $manager->collection('jsFooter');

上記で示すように、addJsメソッドがコレクションにリソースを追加するのに使われます。2番目のパラメータはリソースが外部のものかそうでないかを指定し、3番目のパラメータはリソースがフィルタされるべきかそのままにすべきかを指定します:

.. code-block:: php

    <?php

    // これはフィルタリングする必要のないリモートのリソースです
    $js->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false);

    // These are local resources that must be filtered
    $js->addJs('common-functions.js');
    $js->addJs('page-functions.js');

フィルタはコレクションに登録されています。複数のフィルタを利用でき、リソースの中のコンテンツは、フィルタを登録した順と同じ順序でフィルタにかけられます:

.. code-block:: php

    <?php

    // Use the built-in Jsmin filter
    $js->addFilter(new Phalcon\Assets\Filters\Jsmin());

    // Use a custom filter
    $js->addFilter(new MyApp\Assets\Filters\LicenseStamper());

ビルトインのフィルタとカスタムフィルタのどちらも、コレクションに対して透過的に適用されることに留意してください。最後のステップでは、コレクションのすべてのリソースを単一のファイル含めるのか、別々のものに振り分けるのかを決めます。コレクションにすべてのリソースをまとめる指示するには、「join」メソッドを利用できます:

.. code-block:: php

    <?php

    // This a remote resource that does not need filtering
    $js->join(true);

    // 最後のファイルパスの名前です
    $js->setTargetPath('public/production/final.js');

    // このスクリプトのhtmlタグがこのURIで生成されます
    $js->setTargetUri('production/final.js');

もしリソースをまとめようとしているなら、私たちはリソースを保存するのに使うファイルがどれか、それを表示するのに使うファイルがどれかを定義する必要があります。これらの設定は、setTargetPath() と setTargetUri() で設定できます。

ビルトインフィルタ
^^^^^^^^^^^^^^^^
Phalcon は、javascript と CSS のそれぞれに対して圧縮するための 2つのビルトインのフィルタを提供します。それらの C言語によるバックエンドは、このタスクを実行するためのオーバーヘッドを最小限に留めてくれます:

+-----------------------------------+-----------------------------------------------------------------------------------------------------------+
| Filter                            | Description                                                                                               |
+===================================+===========================================================================================================+
| Phalcon\\Assets\\Filters\\Jsmin   | Minifies Javascript removing unnecessary characters that are ignored by Javascript interpreters/compilers |
+-----------------------------------+-----------------------------------------------------------------------------------------------------------+
| Phalcon\\Assets\\Filters\\Cssmin  | Minifies CSS removing unnecessary characters that are already ignored by browsers                         |
+-----------------------------------+-----------------------------------------------------------------------------------------------------------+

カスタムフィルタ
^^^^^^^^^^^^^^
ビルトインフィルタに加え、開発者は独自のフィルタを作成できます。 YUI_ 、 Sass_ 、 Closure_ などの既存のもっと高度なツールを活用することができます:

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * Filters CSS content using YUI
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
        public function __construct($options)
        {
            $this->_options = $options;
        }

        /**
         * Do the filtering
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {
            // 文字列のコンテンツを一時ファイルに書き出す
            file_put_contents('temp/my-temp-1.css', $contents);

            system(
                $this->_options['java-bin'] .
                ' -jar ' .
                $this->_options['yui'] .
                ' --type css '.
                'temp/my-temp-file-1.css ' .
                $this->_options['extra-options'] .
                ' -o temp/my-temp-file-2.css'
            );

            // ファイルのコンテンツを返す
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }

使用法:

.. code-block:: php

    <?php

    // CSSコレクションを取得する
    $css = $this->assets->get('head');

    // コレクションにYUIコンプレッサーフィルタを追加/有効にする
    $css->addFilter(
        new CssYUICompressor(
            array(
                'java-bin'      => '/usr/local/bin/java',
                'yui'           => '/some/path/yuicompressor-x.y.z.jar',
                'extra-options' => '--charset utf8'
            )
        )
    );

カスタム出力
-------------
必要なHTMLコードを生成する outputJs と outputCss メソッドがリソースのタイプに応じて利用できます。これらのメソッドをオーバーライドするか、次のようにリソースを手動で出力します:

.. code-block:: php

    <?php

    use Phalcon\Tag;

    foreach ($this->assets->collection('js') as $resource) {
        echo Tag::javascriptInclude($resource->getPath());
    }

.. _YUI : http://yui.github.io/yuicompressor/
.. _Closure : https://developers.google.com/closure/compiler/?hl=fr
.. _Sass : http://sass-lang.com/
