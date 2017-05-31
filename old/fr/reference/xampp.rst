Installation sur XAMPP
======================

XAMPP_ est une distribution Apache facile à installer qui contient MySQL, PHP et Perl. Une fois téléchargé XAMPP, vous l'extrayez simplement et commencez à vous en servir. Les instructions d'installation de Phalcon sur XAMPP sont détaillées ci-dessous. L'utilisation de la dernière version de XAMPP est fortement recommandée.

Téléchargement de la bonne version de Phalcon
---------------------------------------------
XAMPP est utilise toujours les versions 32 bits d'Apache et de PHP. Vous avez juste besoin de télécharger la version x86 de Phalcon pour Windows dans la section de téléchargement.

Après le téléchargement de la librairie Phalcon vous obtenez un fichier zip comme celui montré ci-dessous:

.. figure:: ../_static/img/xampp-1.png
    :align: center

Extrayez la librairie de l'archive et récupérer la DLL Phalcon:

.. figure:: ../_static/img/xampp-2.png
    :align: center

Copiez le fichier php_phalcon.dll à coté des autres extensions. Si vous avez installé XAMPP dans le dossier C:\\xampp, l'extension doit se trouver dans C:\\xampp\\php\\ext

.. figure:: ../_static/img/xampp-3.png
    :align: center

Modifiez le fichier php.ini qui se trouve à C:\\xampp\\php\\php.ini. Il peut être édité avec le bloc-notes (Notepad) ou tout autre programme similaire. Nous recommandons Notepad++ pour éviter les problèmes avec les fins de ligne. Ajoutez à la fin du fichier: extension=php_phalcon.dll et enregistrez-le.

.. figure:: ../_static/img/xampp-4.png
    :align: center

Redémarrer le serveur Apache à partir du centre de contrôle XAMPP. La nouvelle configuration PHP devrait être chargée.

.. figure:: ../_static/img/xampp-5.png
    :align: center

Ouvrez votre navigateur à l'adresse http://localhost. La page d'accueil de XAMPP devrait apparaître. Cliquez sur le lien phpinfo(). 

.. figure:: ../_static/img/xampp-6.png
    :align: center

phpinfo() génère une quantité importante d'informations à propos de l'état courant de PHP. Faites défiler vers le bas pour vérifier que l'extension Phalcon soit correctement chargée.

.. figure:: ../_static/img/xampp-7.png
    :align: center

Si vous voyez la version de Phalcon au sein de la sortie de phpinfo(), alors félicitations ! Vous volez désormais avec Phaclon.²

Vidéo
-----
La vidéo qui suit montre pas à pas l'installation de Phalcon sous Windows:

.. raw:: html

   <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Voir aussi
----------
* :doc:`Installation générale </reference/install>`
* :doc:`Installation détaillée avec WAMP pour Windows </reference/wamp>`

.. _XAMPP: https://www.apachefriends.org/fr/download.html
