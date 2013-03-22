Framework Benchmarks
====================
En el pasado, el rendimiento no era considerado una prioridad al desarrollar aplicaciones web. Tener un buen hardware
era suficiente para compensarlo. Ahora que Google ha decidido_ tener en cuenta la velocidad en sus rankings de búsqueda,
esta se ha vuelto una proridad junto con el contenido y la funcionalidad. 

Los benchmarks acontinuación, muestran que tan eficiente es Phalcon al ser comparado con frameworks PHP tradicionales.
Estos benchmarks son actualizados en la medida que nuevas versiones son liberadas.

Puedes clonar la test suite que se usó para estos benchmarks. Si tienes optimizaciones adicionales o comentarios puedes
`escribirnos`_. `Check out source at Github`_

¿Cuál es el entorno de pruebas?
------------------------------
APC_ fue habilitado para todos los frameworks. Módulos como mod-rewrite fueron desabilitados para evitar posibles overheads.

El hardware utilizado es el siguiente:

* Sistema Operativo: Mac OS X Lion 10.7.4
* Web Server: Apache httpd 2.2.22
* PHP: 5.3.15
* CPU: 2.04 Ghz Intel Core i5
* Memoria Principal: 4GB 1333 MHz DDR3
* Disco duro: 500GB SATA Disk

*Versión de PHP e información:*

.. figure:: ../_static/img/bench-4.png
    :align: center

*Configuración de APC:*

.. figure:: ../_static/img/bench-5.png
    :align: center


List of Benchmarks
-----------------------

.. toctree::
   :maxdepth: 1

   benchmark/hello-world
   benchmark/micro

ChangeLog
---------

.. versionadded:: 1.0
    Update Mar-20-2012: Benchmarks redone changing the apc.stat setting to Off. More Info

.. versionchanged:: 1.1
    Update May-13-2012: Benchmarks redone PHP plain templating engine instead of Twig for Symfony. Configuration settings for Yii were also changed as recommended.

.. versionchanged:: 1.2
    Update May-20-2012: Fuel framework was added to benchmarks.

.. versionchanged:: 1.3
    Update Jun-4-2012: Cake framework was added to benchmarks. It is not however present in the graphics, since it takes  30 seconds to run only 10 of 1000.

.. versionchanged:: 1.4
    Update Ago-27-2012: PHP updated to 5.3.15, APC updated to 3.1.11, Yii updated to 1.1.12, Phalcon updated to 0.5.0, Added Laravel, OS updated to Mac OS X Lion. Hardware upgraded.

.. _decidido: http://googlewebmastercentral.blogspot.com/2010/04/using-site-speed-in-web-search-ranking.html
.. _escribirnos: https://github.com/phalcon/framework-bench
.. _Check out source at Github: https://github.com/phalcon/framework-bench
.. _APC: http://php.net/manual/en/book.apc.php

