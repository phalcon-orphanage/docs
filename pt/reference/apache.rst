Notas de Instalação do Apache
=============================

Apache_ é um popular e bem conhecido servidor web, disponível para muitas plataformas.

Configurando o Apache para o Phalcon
------------------------------------
A seguir existem potenciais configurações que você pode usar para configurar o Apache com o Phalcon. Essas notas são primariamente focadas na configuração do modulo mod_rewrite, permitindo utilizar URLs amigáveis e o
:doc:`componente de rotas <routing>`. Normalmente uma aplicação terá a seguinte estrutura:

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

Diretório principal sob o Documento Raiz (DocumentRoot)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Esse é o caso mais comum, a aplicação é instalada em qualquer diretório sob a raiz do documento.
Neste caso, utilizamos dois .htaccess, o primeiro para esconder o código da aplicação enviando todas as requisições
para o documento raiz (DocumentRoot) da aplicação (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

Agora o segundo .htaccess é localizado no diretório public/, este contem os re-writes de todas URIs para o public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Se você não quiser usar o .htaccess, você pode mover essas configurações para o arquivo principal de configuração do apache:

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
Esta segunda configuração permite você instalar uma aplicação Phalcon em um virtual host:

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
