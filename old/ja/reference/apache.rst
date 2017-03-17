Apache インストール ノート
==========================

Apache_ は多くのプラットフォームで利用可能な、人気のあるWebサーバーです。

PhalconのためのApacheの設定
------------------------------
次の設定は、 PhalconをApacheで使う際の設定例です。ここでは主に、使いやすいURLと :doc:`router component <routing>`. を
使用できるようにmod_rewriteモジュールを設定する方法についてフォーカスしています。 一般的にアプリケーションは下記のような構造になります。

.. code-block:: php

    test/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/
        index.php

メインドキュメントルート下のディレクトリ
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
これは最も一般的なケースで、アプリケーションはドキュメントルート下の任意のディレクトリにインストールされています。
このケースでは、2つの .htaccess ファイルを使います。1つめはアプリケーションコードを隠すためにすべてのリクエストを
アプリケーションのドキュメントルート (public/) へリダイレクトします。

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

2つめの .htaccess ファイルは、public/ ディレクトリに配置し、すべてのURIを public/index.php ファイルにリライトします。

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

もし .htaccessファイルを使用したくない場合は、これらの設定を Apacheのメインの設定ファイルに移動させることができます。

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>

        <Directory "/var/www/test">
            RewriteEngine on
            RewriteRule  ^$ public/    [L]
            RewriteRule  ((?s).*) public/$1 [L]
        </Directory>

        <Directory "/var/www/test/public">
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
        </Directory>

    </IfModule>

バーチャルホスト
^^^^^^^^^^^^^^^^
そしてこの2つめの設定では、Virtual Host 内に Phalconアプリケーションをインストールすることができます。

.. code-block:: apacheconf

    <VirtualHost *:80>

        ServerAdmin admin@example.host
        DocumentRoot "/var/vhosts/test/public"
        DirectoryIndex index.php
        ServerName example.host
        ServerAlias www.example.host

        <Directory "/var/vhosts/test/public">
            Options All
            AllowOverride All
            Allow from all
        </Directory>

    </VirtualHost>

.. _Apache: http://httpd.apache.org/

>= Apache 2.4:

.. code-block:: apacheconf

    <VirtualHost *:80>

        ServerAdmin admin@example.host
        DocumentRoot "/var/vhosts/test/public"
        DirectoryIndex index.php
        ServerName example.host
        ServerAlias www.example.host

        <Directory "/var/vhosts/test/public">
            Options All
            AllowOverride All
            Require all granted
        </Directory>

    </VirtualHost>

.. _Apache: http://httpd.apache.org/
