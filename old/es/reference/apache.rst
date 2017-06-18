Notas para la instalación en Apache
===================================

Apache_ es un servidor web muy popular disponible para numerosas plataformas.

Configurando Apache para Phalcon
--------------------------------
Lo siguiente son definiciones de configuraciones que puedes usar para configurar tu aplicación en Apache. Estas notas están enfocadas en la configuración del modulo mod_rewrite para usar URL amistosas y
:doc:`router component <routing>`. Por lo general una aplicación posee esta estructura:

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

Directorios dentro del directorio raiz
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
El caso más común es que la aplicación es instalada en un directorio dentro del directorio raiz.
En este caso, usaremos 2 ficheros .htaccess, el primero para ocultar el código de la aplicación redireccionando
cualquier petición a la carpeta raiz de la aplicación (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

El segundo fichero .htaccess estará localizado dentro del directorio public/, reescribiendo todas las URIs hacia el fichero public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Si no quieres usar ficheros .htaccess puedes definir estas configuraciones en la configuración principal de Apache:

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

Hosts Virtuales
^^^^^^^^^^^^^^^
A continuación puedes encontrar como puedes configurar tu aplicación para que funcione como un Host Virtual:

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
