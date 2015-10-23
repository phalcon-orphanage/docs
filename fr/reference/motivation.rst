Nos Motivations
===============

Aujourd'hui il existe une multitude de framework PHP, mais aucun d'eux ne ressemble à Phalcon (faites-nous confiance sur ce point).

La plupart des programmeurs préfèreront utiliser un framework.
C'est tout d'abord  un apport de fonctionnalités déjà testées et prêtes à l'utilisation,
ce qui permet de garder un code DRY ("Don't Repeat Yourself" - ne vous répétez pas).
Cependant, l'utilisation du framework demande l'inclusion de beaucoup de fichiers et de centaines de lignes de code
qui seront interprétées et exécutées lors de chaque accès à l'application. Les framework orientés objets ajoutent
également ennormément de tâches à exécuter, ce qui peut ralentir les applications complexes.
Toutes ces opérations ralentissants l'application peuvent avoir un impacte négatif sur l'utilisateur.


La Question
-----------
Pourquoi ne pouvons-nous pas avoir un framework complet avec tous ces avantages mais sans un seul, ou très peu, de ces désavantages ?

C'est pour ça que Phalcon est né !

Durant ces derniers mois, nous avons longuement étudié les comportements de PHP, déterminant les optimisations nécessaires (mineures ou majeures).
Grâce à la compréhension du Zend Engine, nous avons réussi à éliminer les validations inutiles, à réaliser des optimisations
et à générer des solutions bas niveau pour arriver à atteindre le meilleur taux de performances pour Phalcon.



Pourquoi ?
----------
* Aujourd'hui, l'utilisation d'un framework est devenue obligatoire dans le monde professionel du développement PHP.
* Les framework offrent un mode de travail structuré permettant de maintenir facilement un projet, d'écrire moins de code et de rendre le développement plus divertissant.

Fonctionnement interne de PHP ?
-------------------------------
* PHP utilise des variables dynamiques et faiblement typées. A chaque opération binaire (ex. 2 + "2"), PHP vérifie le type des opérandes pour effectuer d'éventuelles conversions.
* Contrairement à un langage compilé, PHP est un langage interprété. La perte de performances en est le plus grand désavantage
* A chaque fois qu'un script est appelé, il est d'abord interprété
* Si aucun cache d'OPCodes (comme APC) n'est utilisé, la vérification syntaxique est faite lors de chaque requête

Comment fonctionne un framework traditionnel ?
----------------------------------------------
* Des fichiers avec des classes et des fonctions sont lus lors de chaque requête. Les accès disque sont coûteux en termes de performances, surtout quand la structure des fichier est profonde
* Les frameworks modernes utilisent le "lazy loadind" (autoload) pour améliorer les performances en ne chargeant que les fichiers nécessaires
* Le chargement continue ou interprété impacte les performances
* Le code du framework ne change pas souvent, cependant l'application doit le charger et l'interpréter à chaque requête

Comment fonctionne une extension C pour PHP ?
---------------------------------------------
* Les extensions C sont chargées une seule fois en même temps que PHP lorsque le processus (daemon) du serveur web démarre
* Les classes et les fonctions proposées par l'extension sont disponnibles depuis PHP dans n'importe quelle application
* Le code n'est pas interprété parcequ'il est déjà compilé pour une plateforme spécifique.

Comment fonctionne Phalcon ?
----------------------------
* Les composants sont faiblement couplés. Avec Phalcon, rien n'est imposé : vous êtes libre d'utiliser tout le framework ou seulement une partie
* L'optimisation bas niveau offre d'excellentes performances pour les applications MVC
* Les interractions avec la base de données sont optimisées au maximum en utilisant un ORM écrit en langage C pour PHP
* Phalcon a un accès direct aux structures internes de PHP optimisant ainsi son exécution


Pourquoi ai-je besoin de Phalcon ?
----------------------------------

Chaque application ses propres nécessités et tâches à accomplire.
Par exemple certaines sont faites pour générer un contenu qui ne change que rarement.
Ces applications peuvent être créées avec n'importe quel langage de programation ou framework.
L'utilisation d'un cache rendra généralement l'application très rapide même si elle a été très mal écrite.

D'autres applications génèrent un contenu qui changera à chaque requête. Dans ce cas PHP est utilisé pour génèrer ce contenu.
De telles applications peuvent être des APIs, des forums à fort trafic, des blogs avec beaucoup de commentaires et de contributeurs,
des applications de statistiques, des interfaces d'administration, des progiciels de gestion intégré (ou "ERP"),
 des logiciels d'informatique décisionnelle ("BI", ou  "business-intelligence" en anglais) qui traitent des données en temps réel, et bien d'autres...

Une application sera aussi lente que le plus lent de ses composants/processus.
Phalcon offre des fonctionnalités riches et très rapides qui permettent aux développeurs de se concentrer sur la création de leurs applications.
En suivant les bonnes méthodes, Phalcon peut effectuer beaucoup plus de tâches par requête en consommant moins de mémoire et de processeur que n'importe quel autre framework.




Conclusion
----------
Phalcon se concentre à construire le framework PHP le plus rapide. Vous avez maintenant la possibilité de développer rapidement des application avec un framework qui suit la philosophie "la performance est primordiale" ! Enjoy !

.. _`compute-bound` : http://en.wikipedia.org/wiki/CPU_bound
.. _`memory-bound` : http://en.wikipedia.org/wiki/Memory_bound
.. _`I/O bound` : http://en.wikipedia.org/wiki/IO_bound
