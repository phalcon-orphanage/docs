Notes d'installation sur Apache
===============================

Apache_ est un serveur web populaire et bien connu, disponible sur de nombreuses plateformes.

Configurer Apache pour Phalcon
------------------------------
Ce qui suit sont de possibles configurations que vous pouvez utiliser pour configurer Apache pour Phalcon. Ces instruction sont principalement dirigées vers la configuration du module mod_rewrite qui permet l'utilisation d'URLs conviviales
et du  :doc:`router component <routing>`. Les applications ont habituellement cette structure:

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

Répertoire à partir de la racine document
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
C'est le cas le plus fréquent. L'application est installée dans n'importe quel dossier sous la racine document.
Dans ce cas nous utilisons deux fichiers .htaccess. Le premier sert à masquer l'application en redirigeant toutes les requêtes
vers la racine de l'application (public/).


.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

Le second fichier .htaccess est placé dans le dossier public/. Celui-ci réécrit toutes les URIs vers le fichier public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Si vous ne souhaitez pas utiliser les fichier .htaccess, vous pouvez déplacer ces configurations dans le fichier principal de configuration d'Apache:

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

Hôtes Virtuels
^^^^^^^^^^^^^^
Cette deuxième configuration vous permet d'installer une application Phalcon dans un hôte virtuel:

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

Ou si vous utilisez Apache 2.4 et supérieurs:

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
