Apache 安装说明（Apache Installation Notes）
============================================

Apache_ 是一个流行且出名的web服务器，并且可以支持很多平台。

Apache 下配置 Phalcon（Configuring Apache for Phalcon）
-------------------------------------------------------
以下内容是你可能在使用Apache下搭建Phalcon时可能会用到的配置。这些内容重点关注于mod_rewrite模块的配置，以便可以使用友好的链接和路由组件 :doc:`router component <routing>` 。通常一个应用会有以下目录结构：

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

在主文档根目录下（Directory under the main Document Root）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
这是一种最为常用的情况，应用安装在根目录下的任意一个目录。对于这种情况，我们使用两个.htaccess文件，第一个用于隐藏应用转发全部请求到对应文档根目录（public/）的相关代码。

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

然后第二个.htaccess位于public/下，并将全部的URI重定向到public/index.php文件。

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

如果你不想使用这些.htaccess文件，你可以将这些配置移到apache的主配置文件中：

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

虚拟主机（Virtual Hosts）
^^^^^^^^^^^^^^^^^^^^^^^^^
第二份配置则允许你可以将一个Phalcon应用安装在虚拟主机：

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

如果你使用的Apache版本为2.4或者以上:

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
