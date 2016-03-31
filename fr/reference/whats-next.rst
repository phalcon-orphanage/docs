.. highlights::

    Attention: Cette documentation est incomplète.

Améliorer les performances : C'est quoi la suite ?
==================================================

Avoir des applications plus rapides nécessite l'amélioration de différents composants : Le serveur, le client, le réseau la base de données, le serveur web, les sources statiques, etc.
Dans ce chapitre nous avons sélectionné des scénarios où l'on pourra améliorer les performances et où nous verrons comment voir ce qui ralentit notre application.

Profilage du Server
-------------------
Chaque application est différente, le profilage (l'analyse) constante est importante pour comprendre où les performances peuvent être améliorés.
Le profilage nous permet d'avoir une idée réelle de ce qui est lent et de ce qui ne l'est pas. Chaque analyse varie en fonction des requêtes, donc
il est important de faire assez de mesures pour obtenir des conclusions efficace.


Profilage avec XDebug
^^^^^^^^^^^^^^^^^^^^^
Xdebug_ nous fournit un moyen simple d'analyser des applications PHP, il suffit d'installer l'extension et d'autoriser le profilage dans php.ini :

.. code-block:: ini

    xdebug.profiler_enable = On

En utilisant un outils comme Webgrind_ on peux voir quelles fonctions/méthodes sont lentes par rapport aux autres :

.. figure:: ../_static/img/webgrind.jpg
    :align: center

Profilage avec Xhprof
^^^^^^^^^^^^^^^^^^^^^
Xhprof_ est une autre extension intéressante pour l'analyse d'applications PHP. Ajoutez le code suivant au début du fichier index.php (le fichier bootstrap qui se trouve normalement dans public/) :

.. code-block:: php

    <?php

    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

Puis à la fin de ce même fichier, ajoutez ceci :

.. code-block:: php

    <?php

    $xhprof_data = xhprof_disable('/tmp');

    $XHPROF_ROOT = "/var/www/xhprof/";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
    include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

    $xhprof_runs = new XHProfRuns_Default();
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

    echo "http://localhost/xhprof/xhprof_html/index.php?run={$run_id}&source=xhprof_testing\n";

Xhprof fournit un aperçu en HTML pour analyser les données récupérés :

.. figure:: ../_static/img/xhprof-2.jpg
    :align: center

.. figure:: ../_static/img/xhprof-1.jpg
    :align: center

Profilage des requête SQL
^^^^^^^^^^^^^^^^^^^^^^^^^
La plupart des bases de données fournissent des outils pour identifier les requêtes lourdes. Détecter et corriger ces requêtes est très important pour améliorer les performances
du côté serveur. Dans le cas de MySQL, vous pouvez utiliser les "slow queries logs" (logs de requêtes lentes) pour savoir quelles requêtes prennent plus de temps que prévu :

.. code-block:: ini

    log-slow-queries = /var/log/slow-queries.log
    long_query_time = 1.5

Profilage côté Client
---------------------
Des fois, on as besoin d'améliorer le chargement des éléments statiques comme des images, du javascript et du CSS pour améliorer les performances.
Les outils suivants sont très utiles pour détecter les goulot d'étranglement du côté client :

Profilage avec Chrome/Firefox
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
La plupart des navigateurs modernes ont des outils pour profiler le chargement des pages. Dans chrome vous pouvez utiliser l'inspecteur d'élément
pour savoir ce qui prends du temps à charger sur une page.

.. figure:: ../_static/img/chrome-1.jpg
    :align: center

Firebug_ fournit les mêmes fonctionnalités sous firefox :

.. figure:: ../_static/img/firefox-1.jpg
    :align: center

Yahoo! YSlow
------------
YSlow_  analyse les pages web et suggère des moyens d'améliorer les performances en fonction d'un ensemble de `règles pour des pages de hautes performances`_

.. figure:: ../_static/img/yslow-1.jpg
    :align: center

Profilage avec Speed Tracer
^^^^^^^^^^^^^^^^^^^^^^^^^^^
`Speed Tracer`_ is a tool to help you identify and fix performance problems in your web applications.
It visualizes metrics that are taken from low level instrumentation points inside of the browser and analyzes them as your application runs.
Speed Tracer is available as a Chrome extension and works on all platforms where extensions are currently supported (Windows and Linux).

.. figure:: ../_static/img/speed-tracer.jpg
    :align: center

Cet outil est très pratique parce qu'il permet d'avoir un vrai temps de chargement nécessaire pour l'affichage de la page complet (y compris le parsage des éléments HTML, Javascript et CSS).

Utiliser une version récente de PHP
-----------------------------------
PHP est plus rapide chaque jour, en utilisant la dernière version, vous pourrez améliorer les performances de votre application
et aussi de PHP.

Utiliser un cache PHP Bytecode
------------------------------
APC_, comme beaucoup d'autre cache bytecode, aide une application à réduire le temps de chargement des lectures, il segmente et parse les fichiers PHP pour chaque requêtes.
Une fois l'extension installé, utilisez la ligne suivante pour le mettre en place :

.. code-block:: ini

    apc.enabled = On

PHP 5.5 inclus un cache bytecode intégré appelé ZendOptimizer+, cette extension est aussi disponible pour PHP 5.3 et 5.4.

Mettez le travail lent en tâche de fond
---------------------------------------
Traiter une vidéo, envoyer des emails, compresser un fichier ou une image sont des tâches lentes qui doivent être mises en tâche de fond.
Voici une variété d'outils qui fournissent un système de mise en queue (effectuer les tâches les unes après les autres) ou un système de messages programme à programme qui fonctionne bien avec PHP :

* `Beanstalkd <http://kr.github.io/beanstalkd/>`_
* `Redis <http://redis.io/>`_
* `RabbitMQ <http://www.rabbitmq.com/>`_
* `Resque <https://github.com/chrisboulton/php-resque>`_
* `Gearman <http://gearman.org/>`_
* `ZeroMQ <http://www.zeromq.org/>`_

Google Page Speed
-----------------
mod_pagespeed_ accélère votre site et réduit le temps de chargement des pages. Ce module apache open-source (aussi disponible pour nginx sous le nom ngx_pagespeed_)
met en place les meilleures pratique d'optimisation sur votre serveur, automatique. Il associe aussi les fichiers CSS, javascript et les images sans que vous n'ayez besoin de
modifier le contenu de votre site.

.. _firebug: http://getfirebug.com/
.. _YSlow: http://developer.yahoo.com/yslow/
.. _règles pour des pages de hautes performances: http://developer.yahoo.com/performance/rules.html
.. _XDebug: http://xdebug.org/docs
.. _Xhprof: https://github.com/facebook/xhprof
.. _Speed Tracer: https://developers.google.com/web-toolkit/speedtracer/
.. _Webgrind: https://github.com/jokkedk/webgrind/
.. _APC: http://php.net/manual/en/book.apc.php
.. _mod_pagespeed: https://developers.google.com/speed/pagespeed/mod
.. _ngx_pagespeed: https://developers.google.com/speed/pagespeed/ngx
