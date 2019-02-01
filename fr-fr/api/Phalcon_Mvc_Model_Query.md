---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query'
---
# Class **Phalcon\Mvc\Model\Query**

*implements* [Phalcon\Mvc\Model\QueryInterface](Phalcon_Mvc_Model_QueryInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query.zep)

This class takes a PHQL intermediate representation and executes it.

```php
<?php

$phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c JOIN Brands AS b
         WHERE b.name = :name: ORDER BY c.name";

$result = $manager->executeQuery(
    $phql,
    [
        "name" => "Lamborghini",
    ]
);

foreach ($result as $row) {
    echo "Name: ",  $row->cars->name, "\n";
    echo "Price: ", $row->cars->price, "\n";
    echo "Taxes: ", $row->taxes, "\n";
}

```

## Constantes

*integer* **TYPE_SELECT**

*integer* **TYPE_INSERT**

*integer* **TYPE_UPDATE**

*integer* **TYPE_DELETE**

## Méthodes

public **__construct** ([*string* $phql], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [*mixed* $options])

Phalcon\Mvc\Model\Query constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injection container

public **getDI** ()

Returns the dependency injection container

public **setUniqueRow** (*mixed* $uniqueRow)

Tells to the query if only the first row in the resultset must be returned

public **getUniqueRow** ()

Vérifier si la requête est programmé pour obtenir uniquement la première ligne dans le jeu de résultats

final protected **_getQualified** (*array* $expr)

Remplace le nom du modèle à son nom de la source dans une qualifiée de l'expression de nom

final protected **_getCallArgument** (*array* $argument)

Résout une expression dans un seul argument appel

final protected **_getCaseExpression** (*array* $expr)

Résout une expression dans un seul argument appel

final protected **_getFunctionCall** (*array* $expr)

Résout une expression dans un seul argument appel

final protected *string* **_getExpression** (*array* $expr, [*boolean* $quoting])

Resolves an expression from its intermediate code into a string

final protected **_getSelectColumn** (*array* $column)

Résout une colonne à partir de sa représentation intermédiaire dans un tableau utilisé pour déterminer si le jeu de résultats produit est simple ou complexe

final protected *string* **_getTable** ([Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $manager, *array* $qualifiedName)

Résout un tableau dans une instruction SELECT de vérifier si le modèle existe

final protected **_getJoin** ([Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $manager, *mixed* $join)

Résout une clause de JOINTURE de vérifier si l'associé modèles existent

final protected *string* **_getJoinType** (*array* $join)

Résout un type de JOINTURE

final protected *array* **_getSingleJoin** (*string* $joinType, *string* $joinSource, *string* $modelAlias, *string* $joinAlias, [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation)

Résout rejoint impliquant a-one/appartient à/a-beaucoup de relations

final protected *array* **_getMultiJoin** (*string* $joinType, *string* $joinSource, *string* $modelAlias, *string* $joinAlias, [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation)

Résout rejoint impliquant plusieurs-à-plusieurs relations

final protected *array* **_getJoins** (*array* $select)

Les processus les Jointures dans la requête qui renvoie une représentation interne de la base de données dialecte

final protected *array* **_getOrderClause** (*array* | *string* $order)

Retourne un ordre clause pour une instruction SELECT

final protected **_getGroupClause** (*array* $group)

Retourne un traité clause group pour une instruction SELECT

final protected **_getLimitClause** (*array* $limitClause)

Returns a processed limit clause for a SELECT statement

final protected **_prepareSelect** ([*mixed* $ast], [*mixed* $merge])

Analyzes a SELECT intermediate code and produces an array to be executed later

final protected **_prepareInsert** ()

Analyzes an INSERT intermediate code and produces an array to be executed later

final protected **_prepareUpdate** ()

Analyzes an UPDATE intermediate code and produces an array to be executed later

final protected **_prepareDelete** ()

Analyzes a DELETE intermediate code and produces an array to be executed later

public **parse** ()

Parses the intermediate code produced by Phalcon\Mvc\Model\Query\Lang generating another intermediate representation that could be executed by Phalcon\Mvc\Model\Query

public **getCache** ()

Returns the current cache backend instance

final protected **_executeSelect** (*mixed* $intermediate, *mixed* $bindParams, *mixed* $bindTypes, [*mixed* $simulate])

Executes the SELECT intermediate representation producing a Phalcon\Mvc\Model\Resultset

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeInsert** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the INSERT intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeUpdate** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the UPDATE intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeDelete** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the DELETE intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **_getRelatedRecords** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $intermediate, *array* $bindParams, *array* $bindTypes)

Interroger les dossiers sur lesquels la mise à JOUR/SUPPRESSION est bien fait

public *mixed* **execute** ([*array* $bindParams], [*array* $bindTypes])

Exécute un analysée PHQL déclaration

public [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) **getSingleResult** ([*array* $bindParams], [*array* $bindTypes])

Exécute la requête qui renvoie le premier résultat

public **setType** (*mixed* $type)

Définit le type de PHQL instruction à exécuter

public **getType** ()

Obtient le type de PHQL exécution d'une instruction

public **setBindParams** (*array* $bindParams, [*mixed* $merge])

Jeu de lier des paramètres par défaut

public *array* **getBindParams** ()

Les retours de liaison par défaut params

public **setBindTypes** (*array* $bindTypes, [*mixed* $merge])

Jeu de lier des paramètres par défaut

public **setSharedLock** ([*mixed* $sharedLock])

Ensemble VERROU PARTAGÉ clause

public *array* **getBindTypes** ()

Les retours de liaison par défaut des types de

public **setIntermediate** (*array* $intermediate)

Permet de définir l'IR à être exécuté

public *array* **getIntermediate** ()

Retourne la représentation intermédiaire de la déclaration PHQL

public **cache** (*mixed* $cacheOptions)

Définit les paramètres de cache de la requête

public **getCacheOptions** ()

Retourne le courant options de mise en cache

public **getSql** ()

Renvoie le SQL générés par l'interne PHQL (ne fonctionne que dans les instructions SELECT)

public static **clean** ()

Détruit de l'intérieur PHQL cache