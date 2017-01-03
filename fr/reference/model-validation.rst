Validation de modèles
=====================

Validation de l'intégrité des données
-------------------------------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` fournit plusieurs événements pour valider les données et rédiger les règles métier. L'événement spécial "validation"
nous permet d'appeler des validateurs prédéfinis sur l'enregistrement. Phalcon expose quelques validateurs déjà prêts à l'emploi à ce niveau de validation.

L'exemple suivant montre comment l'utiliser:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Uniqueness;
    use Phalcon\Validation\Validator\InclusionIn;

    class Robots extends Model
    {
        public function validation()
        {
            $validator = new Validation();

            $validator->add(
                "type",
                new InclusionIn(
                    [
                        "domain" => [
                            "Mechanical",
                            "Virtual",
                        ]
                    ]
                )
            );

            $validator->add(
                "name",
                new Uniqueness(
                    [
                        "message" => "The robot name must be unique",
                    ]
                )
            );

            return $this->validate($validator);
        }
    }

L'exemple précédent effectue une validation en utilisant le validateur prédéfini "InclusionIn". Il vérifie que la valeur du champ "type" soit dans la liste de "domain".
Si la valeur n'est pas inclue dans la méthode alors le validateur échoue et retourne "faux". Les validateurs prédéfinis qui suivent sont disponibles:

.. highlights::

	Pour plus d'information sur le validateurs, consultez :doc:`Validation documentation <validation>`.

L'idée derrière la création de validateurs est de les rendre réutilisables entre plusieurs modèles. Un validateur peut être aussi simple que:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Message;

    class Robots extends Model
    {
        public function validation()
        {
            if ($this->type === "Old") {
                $message = new Message(
                    "Sorry, old robots are not allowed anymore",
                    "type",
                    "MyType"
                );

                $this->appendMessage($message);

                return false;
            }

            return true;
        }
    }

Messages de validation
----------------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` dispose d'un sous-système de messagerie qui fourni un moyen flexible de sortir ou stocker des
messages de validation générés pendant les processus d'insertion/mise à jour.

Chaque message consiste en une instance de la classe :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>`. L'ensemble
de messages générés peut être récupéré avec la méthode :code:`getMessages()`. Chaque message contient une information étendue comme le nom du champ
à l'origine du message ou bien le type du message:

.. code-block:: php

    <?php

    if ($robot->save() === false) {
        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

:code:`getMessages()` peut générer les types de messages de validation suivants:

+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                 | Description                                                                                                                        |
+======================+====================================================================================================================================+
| PresenceOf           | Généré lorsqu'un champ avec un attribut non-nul en base tente d'insérer/mettre à jour une valeur nulle                             |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation  | Généré lorsqu'un champ à clé étrangère tente d'insérer/mettre à jour une valeur qui n'existe pas dans le modèle référencé          |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidValue         | Généré lorsqu'un validateur échoue à cause d'une valeur invalide                                                                   |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidCreateAttempt | Produit lors de la tentative de création d'un enregistrement qui existe déjà                                                       |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidUpdateAttempt | Produit lors de la tentative de mise à jour d'un enregistrement qui n'existe pas                                                   |
+----------------------+------------------------------------------------------------------------------------------------------------------------------------+

La méthode :code:`getMessages()` peut être surchargée dans un modèle pour remplacer/traduire le message par défaut qui est généré automatiquement par l'ORM:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function getMessages()
        {
            $messages = [];

            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case "InvalidCreateAttempt":
                        $messages[] = "The record cannot be created because it already exists";
                        break;

                    case "InvalidUpdateAttempt":
                        $messages[] = "The record cannot be updated because it doesn't exist";
                        break;

                    case "PresenceOf":
                        $messages[] = "The field " . $message->getField() . " is mandatory";
                        break;
                }
            }

            return $messages;
        }
    }

Événement d'échec de validation
-------------------------------
D'autres types d'événement sont disponibles lorsque le processus de validation détecte une incohérence:

+---------------------------------+--------------------+-----------------------------------------------------------------------------------+
| Opération                       | Nom                | Explication                                                                       |
+=================================+====================+===================================================================================+
| Insertion ou M.à.j              | notSaved           | Déclenché lorsqu'une opération INSERT ou UPDATE échoue pour une raison quelconque |
+---------------------------------+--------------------+-----------------------------------------------------------------------------------+
| Insertion, suppression ou M.à.j | onValidationFails  | Déclenché lorsqu'une opération de manipulation sur les données échoue             |
+---------------------------------+--------------------+-----------------------------------------------------------------------------------+
