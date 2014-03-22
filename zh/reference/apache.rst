Apache 安装笔记
=========================
Apache httpd 是一个非常流行且世人皆知的多平台web服务器

配置Phalcon使用Apache httpd  
------------------------------
The following are potential configurations you can use to setup Apache with Phalcon. These notes are primarily
focused on the configuration of the mod-rewrite module allowing to use friendly urls and the
:doc:`router component <routing>`. 通常一个应用程序的结构如下：

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

Directory under the main Document Root
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
This being the most common case, the application is installed in any directory under the document root.
In this case, we use .htaccess 2 files, the first one to hide the application code and forward all requests
to the application document root (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>

另外一个方案是使用.htaccess文件，将它放在public/目录下，重写所有URI指定到public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

如果你想使用.htaccess文件，你可以在主配置文件中删除下面的配置：

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>

        <Directory "/var/www/test">
            RewriteEngine on
            RewriteRule  ^$ public/    [L]
            RewriteRule  (.*) public/$1 [L]
        </Directory>

        <Directory "/var/www/test/public">
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
        </Directory>

    </IfModule>

虚拟主机
^^^^^^^^^^^^^
Phalcon运用程序允许运行在虚拟主机环境下：

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
