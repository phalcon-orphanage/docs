%{phql_5386430706e3d70dcd6721cfffc4e04d}%
=============================
%{phql_b876fbd21078f3f503088a28152f5c24}%

%{phql_770e44dedceb2f0e5f5b89dbad1cae91}%

%{phql_7befb3258cfb156f4f2a5ad9fad387a6}%

%{phql_a7c2ad8614a5f3c85370ac420ac4f2de}%

%{phql_04a340ea6f68d77f12989beba2458a04}%

%{phql_b2923a136099a523e93b60cda2e7677e}%
-------------
%{phql_d22afdc2a2ef5fa71cb68ec9cee108e3}%

.. code-block:: php

    <?php

    class Cars extends Phalcon\Mvc\Model
    {
        public $id;

        public $name;

        public $brand_id;

        public $price;

        public $year;

        public $style;

        /**
         * This model is mapped to the table sample_cars
         */
        public function getSource()
        {
            return 'sample_cars';
        }

        /**
         * A car only has a Brand, but a Brand have many Cars
         */
        public function initialize()
        {
            $this->belongsTo('brand_id', 'Brands', 'id');
        }
    }

%{phql_a1b67fe5a612a433c7b35828bbc11a19}%

.. code-block:: php

    <?php

    class Brands extends Phalcon\Mvc\Model
    {

        public $id;

        public $name;

        /**
         * The model Brands is mapped to the "sample_brands" table
         */
        public function getSource()
        {
            return 'sample_brands';
        }

        /**
         * A Brand can have many Cars
         */
        public function initialize()
        {
            $this->hasMany('id', 'Cars', 'brand_id');
        }
    }

%{phql_99e03f118557b526d8879d653323d7e0}%
---------------------
%{phql_fbd53b85ed0193a035d9a2e10e612704}%

.. code-block:: php

    <?php

    // {%phql_96b97a7069cbf855c8b71352e096c536%}
    $query = new Phalcon\Mvc\Model\Query("SELECT * FROM Cars", $this->getDI());

    // {%phql_3ddf5c225412a7acb145b96766a5d0b7%}
    $cars = $query->execute();

%{phql_0080a39b5259541169eff46ea9c5ea5c}%

.. code-block:: php

    <?php

    //{%phql_5ce486f3c35ba7079a88a64cafcc6a29%}
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars");
    $cars = $query->execute();

    //{%phql_ec4a20140e92c98c7367b42fb86fcf5d%}
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars WHERE name = :name:");
    $cars = $query->execute(array(
        'name' => 'Audi'
    ));

%{phql_eb08feb94389f4e5366ba4264095493f}%

.. code-block:: php

    <?php

    //{%phql_5ce486f3c35ba7079a88a64cafcc6a29%}
    $cars = $this->modelsManager->executeQuery("SELECT * FROM Cars");

    //{%phql_1a92af3c6a25bedc035a9bd3d94cafc2%}
    $cars = $this->modelsManager->executeQuery("SELECT * FROM Cars WHERE name = :name:", array(
        'name' => 'Audi'
    ));

%{phql_0afa7a4c7c005ec76d601567c48161aa}%
-----------------
%{phql_e893a9b9e54a8e1c795bb12607cc5d30}%

.. code-block:: php

    <?php

    $query = $manager->createQuery("SELECT * FROM Cars ORDER BY Cars.name");
    $query = $manager->createQuery("SELECT Cars.name FROM Cars ORDER BY Cars.name");

%{phql_0c20a135c062e555fe12e8c814499f4b}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql = "SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql = "SELECT c.name FROM Formula\Cars c ORDER BY c.name";
    $query = $manager->createQuery($phql);

%{phql_ffc487d3932c4ba21aba660d1dd667d3}%

.. code-block:: php

    <?php

    $phql   = "SELECT c.name FROM Cars AS c "
       . "WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";
    $query = $manager->createQuery($phql);

%{phql_916cd70dd9c9093314fa736afb3fa271}%
^^^^^^^^^^^^
%{phql_bc4220d30d228afa326f33c7a14e364b}%

.. code-block:: php

    <?php

    $phql = "SELECT c.* FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

%{phql_218768eb16a53531d34ee07eb961bf54}%

.. code-block:: php

    <?php

    $cars = Cars::find(array("order" => "name"));
    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

%{phql_f4ae99b03590be12389bbabf4251f7eb}%

.. code-block:: php

    <?php

    $phql = "SELECT c.id, c.name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

%{phql_f5d0f1eb448afd6d210e17c26cb318a1}%

%{phql_78dcbe0c98269dba3f1d5ed10a082def}%

.. code-block:: php

    <?php

    $phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car) {
        echo $car->id_name, "\n";
    }

%{phql_94f09089ff33f445caba711f4f2097fc}%

.. code-block:: php

    <?php

    $phql   = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";
    $result = $manager->executeQuery($phql);

%{phql_dbdab4ba0af00fb264476765639c133f}%

.. code-block:: php

    <?php

    foreach ($result as $row) {
        echo "Name: ", $row->cars->name, "\n";
        echo "Price: ", $row->cars->price, "\n";
        echo "Taxes: ", $row->taxes, "\n";
    }

%{phql_c0989395fd723b460ecba688406c428f}%

%{phql_949a9ea10ee823acc28ef307f9bca73c}%
^^^^^
%{phql_f8d1d2d3bb81b845d9ea4aa7975d2fa3}%

.. code-block:: php

    <?php

    $phql  = "SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->car_name, "\n";
        echo $row->brand_name, "\n";
    }

%{phql_c1a585f858c40fc2f0d6b434f6a02bf4}%

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands";
    $rows = $manager->executeQuery($phql);

%{phql_e3447c732565d148d43c0879a9e4dee4}%

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id";
    $rows = $manager->executeQuery($phql);

%{phql_3bf6a4bfa18e0de13229380cef912515}%

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo "Car: ", $row->cars->name, "\n";
        echo "Brand: ", $row->brands->name, "\n";
    }

%{phql_9a4aaaeb812b9935609f9041f47b04df}%

.. code-block:: php

    <?php

    $phql = "SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo "Car: ", $row->c->name, "\n";
        echo "Brand: ", $row->b->name, "\n";
    }

%{phql_2e5cafc991790cd62cbd6dfcaed033a4}%

.. code-block:: php

    <?php

    $phql = 'SELECT Brands.name, Songs.name FROM Artists ' .
            'JOIN Songs WHERE Artists.genre = "Trip-Hop"';
    $result = $this->modelsManager->query($phql);

%{phql_17534ddfe740a0ccb36157f6d52484c1}%

.. code-block:: sql

    SELECT `brands`.`name`, `songs`.`name` FROM `artists`
    INNER JOIN `albums` ON `albums`.`artists_id` = `artists`.`id`
    INNER JOIN `songs` ON `albums`.`songs_id` = `songs`.`id`
    WHERE `artists`.`genre` = 'Trip-Hop'

%{phql_0c496866e3b7ef5ccb7d7b86d29300ac}%
^^^^^^^^^^^^
%{phql_46101d69c165924fce0b932d0b0548ba}%

.. code-block:: php

    <?php

    // {%phql_da101dffc8bf2fe5d404bc86a3d5a3c8%}
    $phql = "SELECT SUM(price) AS summatory FROM Cars";
    $row  = $manager->executeQuery($phql)->getFirst();
    echo $row['summatory'];

    // {%phql_79449ef9cedde3a7d5cfb29d813baf4d%}
    $phql = "SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->brand_id, ' ', $row["1"], "\n";
    }

    // {%phql_79449ef9cedde3a7d5cfb29d813baf4d%}
    $phql = "SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->name, ' ', $row["1"], "\n";
    }

    $phql = "SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row["maximum"], ' ', $row["minimum"], "\n";
    }

    // {%phql_4c177f8dae8049f5081efe9068def226%}
    $phql = "SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->brandId, "\n";
    }

%{phql_ec9a533445b22960d8dee63554092547}%
^^^^^^^^^^
%{phql_d3190497c5ffa0d31b5787a970b17b92}%

.. code-block:: php

    <?php

    // {%phql_fa566cbb733c476d210a11ffb47e71f6%}
    $phql = "SELECT * FROM Cars WHERE Cars.name = 'Lamborghini Espada'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.price > 10000";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE TRIM(Cars.name) = 'Audi R8'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.name LIKE 'Ferrari%'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.name NOT LIKE 'Ferrari%'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.price IS NULL";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id IN (120, 121, 122)";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id NOT IN (430, 431)";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id BETWEEN 1 AND 100";
    $cars = $manager->executeQuery($phql);

%{phql_081927ac33f9f150d6cba295931352d2}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE Cars.name = :name:";
    $cars = $manager->executeQuery($phql, array("name" => 'Lamborghini Espada'));

    $phql = "SELECT * FROM Cars WHERE Cars.name = ?0";
    $cars = $manager->executeQuery($phql, array(0 => 'Lamborghini Espada'));


%{phql_d70f9732a93804895552d4041ad92122}%
--------------
%{phql_a7834c88201ad71e5c5127802aad3100}%

.. code-block:: php

    <?php

    // {%phql_339142904822f30efbe178bc1b91f24c%}
    $phql = "INSERT INTO Cars VALUES (NULL, 'Lamborghini Espada', "
          . "7, 10000.00, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // {%phql_1e867d775737fee641d19fdde4f6b32f%}
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES ('Lamborghini Espada', 7, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // {%phql_e78dba49a628db072a3b6d3899d71510%}
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES (:name:, :brand_id:, :year:, :style)";
    $manager->executeQuery($sql,
        array(
            'name'     => 'Lamborghini Espada',
            'brand_id' => 7,
            'year'     => 1969,
            'style'    => 'Grand Tourer',
        )
    );

%{phql_ae74d4ec26f07635bb94fe0da8e72228}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Message;

    class Cars extends Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            if ($this->price < 10000)
            {
                $this->appendMessage(new Message("A car cannot cost less than $ 10,000"));
                return false;
            }
        }

    }

%{phql_a8d62b862354f089a65b6cbe59b30486}%

.. code-block:: php

    <?php

    $phql   = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2012, 'Sedan')";
    $result = $manager->executeQuery($phql);
    if ($result->success() == false)
    {
        foreach ($result->getMessages() as $message)
        {
            echo $message->getMessage();
        }
    }

%{phql_7e95ceac582a15ef3f27c690a4862c5a}%
-------------
%{phql_596650f1fbee737a2e58cffc3309beb2}%

.. code-block:: php

    <?php

    // {%phql_cb7cdc9ff650fd9ee33c32456a68aa30%}
    $phql = "UPDATE Cars SET price = 15000.00 WHERE id = 101";
    $manager->executeQuery($phql);

    // {%phql_2f2b6de24506145eebe079fdc7de25ce%}
    $phql = "UPDATE Cars SET price = 15000.00, type = 'Sedan' WHERE id = 101";
    $manager->executeQuery($phql);

    // {%phql_729b62ead26f158b5b215693a4fbe495%}
    $phql = "UPDATE Cars SET price = 7000.00, type = 'Sedan' WHERE brands_id > 5";
    $manager->executeQuery($phql);

    // {%phql_a4249c82cce91f8052a47c301a8b9d78%}
    $phql = "UPDATE Cars SET price = ?0, type = ?1 WHERE brands_id > ?2";
    $manager->executeQuery($phql, array(
        0 => 7000.00,
        1 => 'Sedan',
        2 => 5
    ));

%{phql_0979c3765dec192eaa96d839b8f054d7}%

%{phql_da66af554b6721e9f08884a18d5d6205}%

%{phql_69ef98663df382b084d84d6fd923f0dd}%

.. code-block:: php

    <?php

    $phql = "UPDATE Cars SET price = 15000.00 WHERE id > 101";
    $success = $manager->executeQuery($phql);

%{phql_b4a5b5bc261949098989806892c8d360}%

.. code-block:: php

    <?php

    $messages = null;

    $process = function() use (&$messages) {
        foreach (Cars::find("id > 101") as $car) {
            $car->price = 15000;
            if ($car->save() == false) {
                $messages = $car->getMessages();
                return false;
            }
        }
        return true;
    };

    $success = $process();

%{phql_12f49100cf21592b1bed0daa5b42bcd9}%
-------------
%{phql_d901c3161bdaf00898323fc337f3bc75}%

.. code-block:: php

    <?php

    // {%phql_d3745656787965ae2c701756124845b8%}
    $phql = "DELETE FROM Cars WHERE id = 101";
    $manager->executeQuery($phql);

    // {%phql_6a51fd768ce8d80ccf5b2c080e22f694%}
    $phql = "DELETE FROM Cars WHERE id > 100";
    $manager->executeQuery($phql);

    // {%phql_a4249c82cce91f8052a47c301a8b9d78%}
    $phql = "DELETE FROM Cars WHERE id BETWEEN :initial: AND :final:";
    $manager->executeQuery(
        $phql,
        array(
            'initial' => 1,
            'final' => 100
        )
    );

%{phql_ce996524e4b2ec0b5dfd262e78b54e70}%

%{phql_c45f0d6895e27b7d482aae69f4248daa}%
----------------------------------------
%{phql_9ec79915f86b984af84bfed7258f981f}%

.. code-block:: php

    <?php

    //{%phql_ec957aedb592e4673349ba1d2eb417a8%}
    $robots = $this->modelsManager->createBuilder()
        ->from('Robots')
        ->join('RobotsParts')
        ->orderBy('Robots.name')
        ->getQuery()
        ->execute();

    //{%phql_9a25ed76d4f7a3538d2d4b0cecf4e538%}
    $robots = $this->modelsManager->createBuilder()
        ->from('Robots')
        ->join('RobotsParts')
        ->orderBy('Robots.name')
        ->getQuery()
        ->getSingleResult();

%{phql_5622680411b3dd3c93fe1bb97610f387}%

.. code-block:: php

    <?php

    $phql = "SELECT Robots.*
        FROM Robots JOIN RobotsParts p
        ORDER BY Robots.name LIMIT 20";
    $result = $manager->executeQuery($phql);

%{phql_d2d5790eccbd79c211951e7466073c59}%

.. code-block:: php

    <?php

    // 'SELECT Robots.* FROM Robots';
    $builder->from('Robots');

    // 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts';
    $builder->from(array('Robots', 'RobotsParts'));

    // 'SELECT * FROM Robots';
    $phql = $builder->columns('*')
                    ->from('Robots');

    // 'SELECT id FROM Robots';
    $builder->columns('id')
            ->from('Robots');

    // 'SELECT id, name FROM Robots';
    $builder->columns(array('id', 'name'))
            ->from('Robots');

    // 'SELECT Robots.* FROM Robots WHERE Robots.name = "Voltron"';
    $builder->from('Robots')
            ->where('Robots.name = "Voltron"');

    // 'SELECT Robots.* FROM Robots WHERE Robots.id = 100';
    $builder->from('Robots')
            ->where(100);

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" AND Robots.id > 50';
    $builder->from('Robots')
            ->where('type = "virtual"')
            ->andWhere('id > 50');

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" OR Robots.id > 50';
    $builder->from('Robots')
            ->where('type = "virtual"')
            ->orWhere('id > 50');

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name';
    $builder->from('Robots')
            ->groupBy('Robots.name');

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id';
    $builder->from('Robots')
            ->groupBy(array('Robots.name', 'Robots.id'));

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name';
    $builder->columns(array('Robots.name', 'SUM(Robots.price)'))
        ->from('Robots')
        ->groupBy('Robots.name');

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name HAVING SUM(Robots.price) > 1000';
    $builder->columns(array('Robots.name', 'SUM(Robots.price)'))
        ->from('Robots')
        ->groupBy('Robots.name')
        ->having('SUM(Robots.price) > 1000');

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts';
    $builder->from('Robots')
        ->join('RobotsParts');

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p';
    $builder->from('Robots')
        ->join('RobotsParts', null, 'p');

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p';
    $builder->from('Robots')
        ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p');

    // 'SELECT Robots.* FROM Robots ;
    // JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p ;
    // JOIN Parts ON Parts.id = RobotsParts.parts_id AS t';
    $builder->from('Robots')
        ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p')
        ->join('Parts', 'Parts.id = RobotsParts.parts_id', 't');

    // 'SELECT r.* FROM Robots AS r';
    $builder->addFrom('Robots', 'r');

    // 'SELECT Robots.*, p.* FROM Robots, Parts AS p';
    $builder->from('Robots')
        ->addFrom('Parts', 'p');

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
    $builder->from(array('r' => 'Robots'))
            ->addFrom('Parts', 'p');

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
    $builder->from(array('r' => 'Robots', 'p' => 'Parts'));

    // 'SELECT Robots.* FROM Robots LIMIT 10';
    $builder->from('Robots')
        ->limit(10);

    // 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5';
    $builder->from('Robots')
            ->limit(10, 5);

    // 'SELECT Robots.* FROM Robots WHERE id BETWEEN 1 AND 100';
    $builder->from('Robots')
            ->betweenWhere('id', 1, 100);

    // 'SELECT Robots.* FROM Robots WHERE id IN (1, 2, 3)';
    $builder->from('Robots')
            ->inWhere('id', array(1, 2, 3));

    // 'SELECT Robots.* FROM Robots WHERE id NOT IN (1, 2, 3)';
    $builder->from('Robots')
            ->notInWhere('id', array(1, 2, 3));

    // 'SELECT Robots.* FROM Robots WHERE name LIKE '%Art%';
    $builder->from('Robots')
            ->where('name LIKE :name:', array('name' => '%' . $name . '%'));

    // 'SELECT r.* FROM Store\Robots WHERE r.name LIKE '%Art%';
    $builder->from(['r' => 'Store\Robots'])
            ->where('r.name LIKE :name:', array('name' => '%' . $name . '%'));

%{phql_1f784a870292bdaabbe7fc60b31ed9fd}%
^^^^^^^^^^^^^^^^
%{phql_e390c52bab27bb0f6db5df479386930e}%

.. code-block:: php

    <?php

    //{%phql_01f8500886a672440ad7fc7034ebdb11%}
    $robots = $this->modelsManager->createBuilder()
        ->from('Robots')
        ->where('name = :name:', array('name' => $name))
        ->andWhere('type = :type:', array('type' => $type))
        ->getQuery()
        ->execute();

    //{%phql_d7706a31e381b4c891339311dfba09bf%}
    $robots = $this->modelsManager->createBuilder()
        ->from('Robots')
        ->where('name = :name:')
        ->andWhere('type = :type:')
        ->getQuery()
        ->execute(array('name' => $name, 'type' => $type));

%{phql_a134584ccac2fddfcf5b203f45920a47}%
-------------------------
%{phql_95562861ff6ac47d167e77c98715380c}%

.. code-block:: php

    <?php

    $login = 'voltron';
    $phql = "SELECT * FROM Models\Users WHERE login = '$login'";
    $result = $manager->executeQuery($phql);

%{phql_773e416c79c434f2c5f22029dc850d62}%

.. code-block:: php

    <?php

    "SELECT * FROM Models\Users WHERE login = '' OR '' = ''"

%{phql_f06b05c12d90f04b3a5b708f0054c863}%

%{phql_d74e9e775e3f0555e8d4801bdc57cba1}%

.. code-block:: php

    <?php

    $phql = "SELECT Robots.* FROM Robots WHERE Robots.name = :name:";
    $result = $manager->executeQuery($phql, array('name' => $name));

%{phql_fa72ca62b13daccc542cb8fa8c2ac158}%

.. code-block:: php

    <?php

    Phalcon\Mvc\Model::setup(array('phqlLiterals' => false));

%{phql_40a67d40a5341adea99c58b52c7b3cd0}%

%{phql_10a77d4c1d136c3f869772725d0dd66f}%
-----------------------
%{phql_82759b93009043bc9741c004abc098cb}%

.. code-block:: php

    <?php

    $phql = "SELECT * FROM [Update]";
    $result = $manager->executeQuery($phql);

    $phql = "SELECT id, [Like] FROM Posts";
    $result = $manager->executeQuery($phql);

%{phql_80b58ea91a646d68e6caf9009bceec79}%

%{phql_c69f6d0581529e1032622e5cbdfe36d4}%
--------------
%{phql_861e30126232847422608f9c138961de}%

%{phql_322e30a4dae62dcfd552a024d89ef7b0}%

%{phql_49c62a60348782860b0968b26fbc1d74}%
-------------
%{phql_5cac6cfb9413d2ca60be37b78373e5ef}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Phalcon\Mvc\Model
    {
        public static function findByCreateInterval()
        {
            // {%phql_526648eefa48ae4fc46e912e0ba3b02a%}
            $sql = "SELECT * FROM robots WHERE id > 0";

            // {%phql_bcd0bbc0f07716044bbe40aa8894896e%}
            $robot = new Robots();

            // {%phql_d24ba4a062f845a259f6bd1397452bdd%}
            return new Resultset(null, $robot, $robot->getReadConnection()->query($sql));
        }
    }

%{phql_2a6e6ccb82a04bd0b277a8af40196603}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Phalcon\Mvc\Model
    {
        public static function findByRawSql($conditions, $params=null)
        {
            // {%phql_526648eefa48ae4fc46e912e0ba3b02a%}
            $sql = "SELECT * FROM robots WHERE $conditions";

            // {%phql_bcd0bbc0f07716044bbe40aa8894896e%}
            $robot = new Robots();

            // {%phql_d24ba4a062f845a259f6bd1397452bdd%}
            return new Resultset(null, $robot, $robot->getReadConnection()->query($sql, $params));
        }
    }

%{phql_e7641f4f450d4d75e3cdcf49a66b1143}%

.. code-block:: php

    <?php

    $robots = Robots::findByRawSql('id > ?', array(10));

%{phql_f07747c719e154f6ba1384e010ddc59e}%
---------------
%{phql_acfbc5f424a4b0cc8fbc9c7662993076}%

%{phql_89addad6c504712029f8c60a192ef518}%

