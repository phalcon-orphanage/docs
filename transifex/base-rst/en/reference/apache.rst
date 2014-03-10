%{apache_980177b08e4d9434a584ed1d7affd9c5}%
=========================
%{apache_f5f74f14af90f6465d786a06e1e0d6ec}%

%{apache_68d3e85aa63aa662569b0bc09eadc769}%
------------------------------
%{apache_302e3e21e0f814fce2fec0a678c9cb8d|:doc:`router component <routing>`}%

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


%{apache_16ffba90f0c26620fe972d6349e62c45}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{apache_687c102724c0c1508f209430f2403a32}%

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>


%{apache_c9e17a433282cb8798b80a2000dfc80f}%

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>


%{apache_9e94326392804d0e29dbcbf464217e38}%

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


%{apache_ebcc030276fd3491142c88ffb86f1201}%
^^^^^^^^^^^^^
%{apache_3d95c0322dd81f6a93fa8bb93ab0d95b}%

