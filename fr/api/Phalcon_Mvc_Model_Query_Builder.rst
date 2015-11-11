Class **Phalcon\\Mvc\\Model\\Query\\Builder**
=============================================

*implements* :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/query/builder.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Helps to create PHQL queries using an OO interface  

.. code-block:: php

    <?php

     $params = array(
        'models'     => array('Users'),
        'columns'    => array('id', 'name', 'status'),
        'conditions' => array(
            array(
                "created > :min: AND created < :max:",
                array("min" => '2013-01-01',   'max' => '2014-01-01'),
                array("min" => PDO::PARAM_STR, 'max' => PDO::PARAM_STR),
            ),
        ),
        // or 'conditions' => "created > '2013-01-01' AND created < '2014-01-01'",
        'group'      => array('id', 'name'),
        'having'     => "name = 'Kamil'",
        'order'      => array('name', 'id'),
        'limit'      => 20,
        'offset'     => 20,
        // or 'limit' => array(20, 20),
    );
    $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder($params);



Methods
-------

public  **__construct** ([*unknown* $params], [*unknown* $dependencyInjector])

Phalcon\\Mvc\\Model\\Query\\Builder constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **distinct** (*unknown* $distinct)

Sets SELECT DISTINCT / SELECT ALL flag 

.. code-block:: php

    <?php

    $builder->distinct("status");
    $builder->distinct(null);




public  **getDistinct** ()

Returns SELECT DISTINCT / SELECT ALL flag



public  **columns** (*unknown* $columns)

Sets the columns to be queried 

.. code-block:: php

    <?php

    $builder->columns("id, name");
    $builder->columns(array('id', 'name'));
      $builder->columns(array('name', 'number' => 'COUNT(*)'));




public *string|array*  **getColumns** ()

Return the columns to be queried



public  **from** (*unknown* $models)

Sets the models who makes part of the query 

.. code-block:: php

    <?php

    $builder->from('Robots');
    $builder->from(array('Robots', 'RobotsParts'));
    $builder->from(array('r' => 'Robots', 'rp' => 'RobotsParts'));




public  **addFrom** (*unknown* $model, [*unknown* $alias], [*unknown* $with])

Add a model to take part of the query 

.. code-block:: php

    <?php

      // Load data from models Robots
    $builder->addFrom('Robots');
    
      // Load data from model 'Robots' using 'r' as alias in PHQL
    $builder->addFrom('Robots', 'r');
    
      // Load data from model 'Robots' using 'r' as alias in PHQL
      // and eager load model 'RobotsParts'
    $builder->addFrom('Robots', 'r', 'RobotsParts');
    
      // Load data from model 'Robots' using 'r' as alias in PHQL
      // and eager load models 'RobotsParts' and 'Parts'
    $builder->addFrom('Robots', 'r', ['RobotsParts', 'Parts']);




public *string|array*  **getFrom** ()

Return the models who makes part of the query



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **join** (*string* $model, [*string* $conditions], [*string* $alias], [*string* $type])

Adds a INNER join to the query 

.. code-block:: php

    <?php

      // Inner Join model 'Robots' with automatic conditions and alias
    $builder->join('Robots');
    
      // Inner Join model 'Robots' specifing conditions
    $builder->join('Robots', 'Robots.id = RobotsParts.robots_id');
    
      // Inner Join model 'Robots' specifing conditions and alias
    $builder->join('Robots', 'r.id = RobotsParts.robots_id', 'r');
    
      // Left Join model 'Robots' specifing conditions, alias and type of join
    $builder->join('Robots', 'r.id = RobotsParts.robots_id', 'r', 'LEFT');




public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **innerJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Adds a INNER join to the query 

.. code-block:: php

    <?php

      // Inner Join model 'Robots' with automatic conditions and alias
    $builder->innerJoin('Robots');
    
      // Inner Join model 'Robots' specifing conditions
    $builder->innerJoin('Robots', 'Robots.id = RobotsParts.robots_id');
    
      // Inner Join model 'Robots' specifing conditions and alias
    $builder->innerJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **leftJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Adds a LEFT join to the query 

.. code-block:: php

    <?php

    $builder->leftJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **rightJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Adds a RIGHT join to the query 

.. code-block:: php

    <?php

    $builder->rightJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **where** (*mixed* $conditions, [*array* $bindParams], [*array* $bindTypes])

Sets the query conditions 

.. code-block:: php

    <?php

    $builder->where(100);
    $builder->where('name = "Peter"');
    $builder->where('name = :name: AND id > :id:', array('name' => 'Peter', 'id' => 100));




public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **andWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Appends a condition to the current conditions using a AND operator 

.. code-block:: php

    <?php

    $builder->andWhere('name = "Peter"');
    $builder->andWhere('name = :name: AND id > :id:', array('name' => 'Peter', 'id' => 100));




public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **orWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Appends a condition to the current conditions using a OR operator 

.. code-block:: php

    <?php

    $builder->orWhere('name = "Peter"');
    $builder->orWhere('name = :name: AND id > :id:', array('name' => 'Peter', 'id' => 100));




public  **betweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

Appends a BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->betweenWhere('price', 100.25, 200.50);




public  **notBetweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

Appends a NOT BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->notBetweenWhere('price', 100.25, 200.50);




public  **inWhere** (*unknown* $expr, *unknown* $values)

Appends an IN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->inWhere('id', [1, 2, 3]);




public  **notInWhere** (*unknown* $expr, *unknown* $values)

Appends a NOT IN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->notInWhere('id', [1, 2, 3]);




public *string|array*  **getWhere** ()

Return the conditions for the query



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **orderBy** (*string|array* $orderBy)

Sets a ORDER BY condition clause 

.. code-block:: php

    <?php

    $builder->orderBy('Robots.name');
    $builder->orderBy(array('1', 'Robots.name'));




public *string|array*  **getOrderBy** ()

Returns the set ORDER BY clause



public  **having** (*unknown* $having)

Sets a HAVING condition clause. You need to escape PHQL reserved words using [ and ] delimiters 

.. code-block:: php

    <?php

    $builder->having('SUM(Robots.price) > 0');




public  **forUpdate** (*unknown* $forUpdate)

Sets a FOR UPDATE clause 

.. code-block:: php

    <?php

    $builder->forUpdate(true);




public *string|array*  **getHaving** ()

Return the current having clause



public  **limit** ([*unknown* $limit], [*unknown* $offset])

Sets a LIMIT clause, optionally a offset clause 

.. code-block:: php

    <?php

    $builder->limit(100);
    $builder->limit(100, 20);




public *string|array*  **getLimit** ()

Returns the current LIMIT clause



public  **offset** (*unknown* $offset)

Sets an OFFSET clause 

.. code-block:: php

    <?php

    $builder->offset(30);




public *string|array*  **getOffset** ()

Returns the current OFFSET clause



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **groupBy** (*string|array* $group)

Sets a GROUP BY clause 

.. code-block:: php

    <?php

    $builder->groupBy(array('Robots.name'));




public *string*  **getGroupBy** ()

Returns the GROUP BY clause



final public *string*  **getPhql** ()

Returns a PHQL statement built based on the builder parameters



public  **getQuery** ()

Returns the query built



