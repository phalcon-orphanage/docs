File d'attente
==============

Les activités comme la manipulation de vidéos, le recadrage d'image ou l'envoi de mails, ne sont pas adaptés pour être réalisées
en ligne ou bien en temps réel à cause du temps de chargement des pages qui peut avoir un impact sérieux sur l'expérience utilisateur.

La meilleure des solutions serait de mettre en place des tâches de fond. Les applications ajouteraient les tâches à une file et ces tâches seraient traitées indépendamment.

Bien que vous puissiez trouver des extensions PHP plus sophistiquées pour la mise en file d'attente comme RabbitMQ_;
Phalcon fournit un client pour Beanstalk_, un backend de mise en file d'attente de jobs inspiré de Memcache_.
Il est simple, léger, et parfaitement spécialisé dans la mise en file d'attente.


.. attention::

    Certains retour de méthodes de la queue nécessite la présence du module Yaml. Veuillez 
    vous référer à http://php.net/manual/book.yaml.php pour plus d'information. Pour PHP < 7, Yaml 1.3.0
    est acceptable. Pour PHP >= 7 vous devez utiliser Yaml >= 2.0.0.
    
Pousser les tâches dans la queue
--------------------------------
Après vous être connecté à Beanstalk vous pouvez insérer autant de jobs que nécessaire. Vous pouvez définir la structure
du message en fonction des besoins de l'application:

.. code-block:: php

    <?php

    use Phalcon\Queue\Beanstalk;

    // Connexion à la queue
    $queue = new Beanstalk(
        [
            "host" => "192.168.0.21",
            "port" => "11300",
        ]
    );

    // Ajoute le job dans la queue
    $queue->put(
        [
            "processVideo" => 4871,
        ]
    );


Les options de connexion disponibles sont:

+----------+----------------------------------------------------------+-----------+
| Option   | Description                                              | Default   |
+==========+==========================================================+===========+
| host     | IP du serveur beanstalk                                  | 127.0.0.1 |
+----------+----------------------------------------------------------+-----------+
| port     | Port de connexion                                        | 11300     |
+----------+----------------------------------------------------------+-----------+

Dans l'exemple précédent nous stockions un message qui permettait à une tâche de fond de traiter une vidéo.
Le message est enfilé immédiatement dans la queue et a une durée de vie limitée.

Pour les options supplémentaire comme le temps d'exécution, la priorité ou le délai sont passés en second paramètre:

.. code-block:: php

    <?php

    // Enfile le job dans la queue avec des options
    $queue->put(
        [
            "processVideo" => 4871,
        ],
        [
            "priority" => 250,
            "delay"    => 10,
            "ttr"      => 3600,
        ]
    );

Les options suivantes sont possibles:

+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Option   | Description                                                                                                                                                                                 |
+==========+=============================================================================================================================================================================================+
| priority | It's an integer < 2**32. Jobs with smaller priority values will be scheduled before jobs with larger priorities. The most urgent priority is 0; the least urgent priority is 4,294,967,295. |
+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| delay    | It's an integer number of seconds to wait before putting the job in the ready queue. The job will be in the "delayed" state during this time.                                               |
+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| ttr      | Time to run -- is an integer number of seconds to allow a worker to run this job. This time is counted from the moment a worker reserves this job.                                          |
+----------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Chaque job enfilé dans la queue retourne un identifiant de job qui permet de suivre l'état du job:

.. code-block:: php

    <?php

    $jobId = $queue->put(
        [
            "processVideo" => 4871,
        ]
    );

Récupération de messages
------------------------
Une fois le job placé dans la queue, ces messages sont consommés par un agent en arrière plan qui devrait avoir le temps de réaliser 
la tâche:

.. code-block:: php

    <?php

    while (($job = $queue->peekReady()) !== false) {
        $message = $job->getBody();

        var_dump($message);

        $job->delete();
    }

Les jobs doivent être défilés de la queue pour éviter d'être traités deux fois. Si plusieurs agents en tâche de fond sont mis en œuvre,
il faut réserver les jobs pour éviter que les autres agents ne les traitent aussi.

.. code-block:: php

    <?php

    while (($job = $queue->reserve()) !== false) {
        $message = $job->getBody();

        var_dump($message);

        $job->delete();
    }

Notre client exploite un jeu élémentaire de fonctionnalités fournis par Beanstalkd mais suffisamment pour vous permettre 
de construire des applications qui mettent en œuvre des queues.

.. _RabbitMQ: http://pecl.php.net/package/amqp
.. _Beanstalk: http://www.igvita.com/2010/05/20/scalable-work-queues-with-beanstalk/
.. _Memcache: http://memcached.org/
