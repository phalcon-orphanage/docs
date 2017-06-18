Apache Installation Notes
=========================

Apache_ is a popular and well known web server available on many platforms.

Configuring Apache for Phalcon
------------------------------
The following are potential configurations you can use to setup Apache with Phalcon. These notes are primarily focused on the configuration of the mod_rewrite module allowing to use friendly URLs and the
:doc:`router component <routing>`. Commonly an application has the following structure:

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
In this case, we use two .htaccess files, the first one to hide the application code forwarding all requests
to the application's document root (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

Now a second .htaccess file is located in the public/ directory, this re-writes all the URIs to the public/index.php file:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

If you do not want to use .htaccess files you can move these configurations to the apache's main configuration file:

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

Virtual Hosts
^^^^^^^^^^^^^
And this second configuration allows you to install a Phalcon application in a virtual host:

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
