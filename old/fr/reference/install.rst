Installation
============
Les extensions PHP nécessitent une méthode d'installation un peu différente des librairies ou des framework basés sur PHP.
Vous pouvez soit télécharger le paquet binaire pour le système de votre choix soit le construire à partir des sources.

Windows
-------
Pour utiliser Phalcon sur Windows vous pouvez télécharger_ une DLL. Ouvrez votre php.ini et ajoutez la ligne suivante:

.. code-block:: bash

    extension=php_phalcon.dll

Ensuite redémarrez votre serveur web.

La vidéo qui suit (en anglais) montre pas à pas comment installer Phalcon sur Windows:

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Guides relatifs
^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------

Debian / Ubuntu
^^^^^^^^^^^^^^^
Pour ajouter le dépôt à votre distribution:

.. code-block:: bash

    # Versions stables
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # Versions nocturnes
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

Ceci ne doit être fait qu'une seule fois, à moins d'un changement de distribution ou que vous souhaitiez basculer vers une construction nocturne.

Pour installer Phalcon:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # ou pour PHP 7

    sudo apt-get install php7.0-phalcon

Distributions RPM (par ex. CentOs)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Pour ajouter le dépôt à votre distribution:

.. code-block:: bash

    # Versions stables
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # Versions nocturnes
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

Ceci ne doit être fait qu'une seule fois, à moins d'un changement de distribution ou que vous souhaitiez basculer vers une construction nocturne.

Pour installer Phalcon:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # or for PHP 7

    sudo yum install php70u-phalcon

Compiler depuis les sources
^^^^^^^^^^^^^^^^^^^^^^^^^^^
Sur un système Linux/Solaris vous pouvez aisément compiler et installer l'extension en partant du code source:

Les paquets nécessaires sont:

* PHP >= 5.5 development resources
* GCC compiler (Linux/Solaris)
* Git (s'il n'est pas déjà installé sur votre système - sinon vous pouvez le télécharger depuis Github et le déposer sur votre serveur via FTP/SFTP)

Paquets spécifique pour les plateformes courantes:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Création de l'extension:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Ajout de l'extension à votre configuration PHP:

.. code-block:: bash

    # Suse: Ajoutez un fichier nommé phalcon.ini dans /etc/php5/conf.d/ avec ce contenu:
    extension=phalcon.so

    # CentOS/RedHat/Fedora: Ajoutez un fichier nommé phalcon.ini in /etc/php.d/ avec ce contenu:
    extension=phalcon.so

    # Ubuntu/Debian with apache2: Ajoutez un fichier nommé 30-phalcon.ini in /etc/php5/apache2/conf.d/ avec ce contenu:
    extension=phalcon.so

    # Ubuntu/Debian with php5-fpm: Ajoutez un fichier nommé 30-phalcon.ini in /etc/php5/fpm/conf.d/ avec ce contenu:
    extension=phalcon.so

    # Ubuntu/Debian with php5-cli: Ajoutez un fichier nommé 30-phalcon.ini in /etc/php5/cli/conf.d/ avec ce contenu:
    extension=phalcon.so

Redémarrez le serveur web.

Si vous utilisez php5-fpm sur Ubuntu ou Debian, redémarrez le:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon détecte automatiquement votre architecture, cependant vous pouvez forcer la compilation pour une architecture spécifique:

.. code-block:: bash

    cd cphalcon/build

    # One of the following:
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

Si l'installateur automatique échoue, essayez la construction manuelle:

.. code-block:: bash

    cd cphalcon/build/64bits

    export CFLAGS="-O2 --fvisibility=hidden"

    ./configure --enable-phalcon

    make && sudo make install

Mac OS X
--------
Sur un système Mac OS X vous pouvez compiler et installer l'extension à partir du code source:

Pré-requis
^^^^^^^^^^
Les paquets nécessaires sont:

* PHP >= 5.5 development resources
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
    sudo port install php55-phalcon
    sudo port install php56-phalcon

Ajoutez l'extension à votre configuration PHP.

FreeBSD
-------
Un portage est disponible pour FreeBSD. Vous devez juste tapez cette ligne pour l'installer:

.. code-block:: bash

    pkg_add -r phalcon

ou

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Vérification de l'installation
------------------------------
Consultez la sortie de :code:`phpinfo()` à la recherche d'une section nommée "Phalcon" ou bien exécutez ce bout de code ci-dessous:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

L'extension Phalcon doit apparaître dans la sortie:

.. code-block:: php

    Array
    (
        [0] => Core
        [1] => libxml
        [2] => filter
        [3] => SPL
        [4] => standard
        [5] => phalcon
        [6] => pdo_mysql
    )

Notes d'installation
--------------------
Instructions d'installation pour les serveurs Web:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _télécharger: http://phalconphp.com/fr/download
