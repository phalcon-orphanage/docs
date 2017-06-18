Utilisation du serveur web interne à PHP
========================================

A partir de PHP 5.4.0, vous pouvez utiliser un serveur web interne_ pour le développement.

Tapez pour démarrer le serveur:

.. code-block:: bash

    php -S localhost:8000 -t /public

Si vous souhaitez réécrire les URIs pour le fichier index.php utilisez le fichier routeur suivant (.htrouter.php):

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

et démarrez le serveur à partir du répertoire de base du projet avec:

.. code-block:: bash

    php -S localhost:8000 -t /public .htrouter.php

Et ouvrez votre navigateur à l'adresse http://localhost:8000/ pour vérifier que cela fonctionne.

.. _interne: http://php.net/manual/fr/features.commandline.webserver.php
