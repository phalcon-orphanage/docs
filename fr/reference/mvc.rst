L'architecture MVC
==================

Phalcon offre les classes orientés objets nécessaires pour implémenter l'architecture avec model, vue et controller (plus connue comme MVC_).
Ce design pattern est très largement utilisé par les autres framework web et applications bureau.

Les avantages du MVC:

* Isolation de la partie logique du code et de la partie interface utilisateur ainsi que la partie gestion de base de données.
* Rendre clair à quelle partie un code appartient pour une maintenance plus aisée.

Si vous décidez d'utiliser le MVC, chaque requête de votre application sera gérée par l'architecture MVC_.
Les classes de Phalcon sont écrites en C, ce qui offre une haute performance à ce principe, pour une application PHP.

Les modèles
-----------
Un modèle représente les informations (données) de l'application et les règles pour manipuler ces données.
Les modèles sont principalement utilisés pour gérer l'intéraction avec une base de données.
Dans la plupart des cas, chaque table de votre base de données correspondra à un model de votre application.
L'essentiel de la logique de votre application sera concentrée sur les models. :doc:`En savoir plus <models>`

Les vues
--------
Les vues représentent l'interface utilisateur.
Elles sont souvent en HTML, avec du PHP intégré pour exécuter certaines tâches lié principalement à la représentation des données.
Les vues s'occupent de retranscrire les données de manière visible sur un navigateur ou tout autre support visuel. :doc:`En savoir plus <views>`

Les controlleurs
----------------
Les controlleurs gèrent le "flux" entre les models et les vues. Ils sont responsables de la gestion des requêtes venant du navigateur,
d'interroger le model pour les données et passer ces données à la vue. :doc:`En savoir plus <controllers>`

.. _MVC: http://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur
