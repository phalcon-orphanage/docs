---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Veritabanı\Çevirici\Üstünyazı önişlemcisi veri objeleri\ilişkisel Sql veritabanı motoru'
---
# Class **Phalcon\Db\Adapter\Pdo\Sqlite**

*extends* abstract class [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter/pdo/sqlite.zep)

Specific functions for the Sqlite database system

```php
<?php

use Phalcon\Db\Adapter\Pdo\Sqlite;

$connection = new Sqlite(
    [
        "dbname" => "/tmp/test.sqlite",
    ]
);

```

## Metodlar

public **connect** ([*array* $descriptor])

This method is automatically called in Phalcon\Db\Adapter\Pdo constructor. Call it when you need to restore a database connection.

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Returns an array of Phalcon\Db\Column objects describing a table

```php
<?php

print_r(
    $connection->describeColumns("posts")
);

```

public [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) **describeIndexes** (*string* $table, [*string* $schema])

Tablo indekslerini listeler

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) **describeReferences** (*string* $table, [*string* $schema])

Tablo referanslarını listeler

genel **useExplicitIdValue** ()

Veritabanı sisteminin kimlik sütunları için belirgin bir değere ihtiyacı olup olmadığını kontrol eder

public **getDefaultValue** ()

RBDM'in Tablo tanımlamasında beyan edilen varsayılan değeri kullanmasını sağlamak için varsayılan değeri getirir

```php
<?php

// Inserting a new robot with a valid default value for the column 'year'
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        $connection->getDefaultValue(),
    ],
    [
        "name",
        "year",
    ]
);

```

public **__construct** (*array* $descriptor) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Constructor for Phalcon\Db\Adapter\Pdo

public **prepare** (*mixed* $sqlStatement) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

'executePrepared' ile yürütülecek bir PDO hazırlanmış ifade döndürür

```php
<?php

use Phalcon\Db\Column;

$statement = $db->prepare(
    "SELECT * FROM robots WHERE name = :name"
);

$result = $connection->executePrepared(
    $statement,
    [
        "name" => "Voltron",
    ],
    [
        "name" => Column::BIND_PARAM_INT,
    ]
);

```

public [PDOStatement](https://php.net/manual/en/class.pdostatement.php) **executePrepared** ([PDOStatement](https://php.net/manual/en/class.pdostatement.php) $statement, *array* $placeholders, *array* $dataTypes) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Executes a prepared statement binding. This function uses integer indexes starting from zero

```php
<?php

use Phalcon\Db\Column;

$statement = $db->prepare(
    "SELECT * FROM robots WHERE name = :name"
);

$result = $connection->executePrepared(
    $statement,
    [
        "name" => "Voltron",
    ],
    [
        "name" => Column::BIND_PARAM_INT,
    ]
);

```

public **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows

```php
<?php

// Querying data
$resultset = $connection->query(
    "SELECT * FROM robots WHERE type = 'mechanical'"
);

$resultset = $connection->query(
    "SELECT * FROM robots WHERE type = ?",
    [
        "mechanical",
    ]
);

```

public **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server doesn't return any rows

```php
<?php

// Inserting data
$success = $connection->execute(
    "INSERT INTO robots VALUES (1, 'Astro Boy')"
);

$success = $connection->execute(
    "INSERT INTO robots VALUES (?, ?)",
    [
        1,
        "Astro Boy",
    ]
);

```

public **affectedRows** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Veritabanı sisteminde yürütülen en son INSERT/UPDATE/DELETE sayısına göre etkilenen satır sayısını döndürür

```php
<?php

$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " were deleted";

```

public **close** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends

public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Bağlantıdaki aktif karakter setine göre SQL enjeksiyonlarını önlemek için bir değer kaçar

```php
<?php

$escapedStr = $connection->escapeString("some dangerous value");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Converts bound parameters such as :name: or ?1 into PDO bind params ?

```php
<?php

print_r(
    $connection->convertBoundParams(
        "SELECT * FROM robots WHERE name = :name:",
        [
            "Bender",
        ]
    )
);

```

public *int* | *boolean* **lastInsertId** ([*string* $sequenceName]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

En son yürütülen SQL deyim içinde eklenen auto_increment/serial column için ekleme kimliğini döndürür

```php
<?php

// Inserting a new robot
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        1952,
    ],
    [
        "name",
        "year",
    ]
);

// Getting the generated id
$id = $connection->lastInsertId();

```

public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Bağlantıda bir işlem başlatır

public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

İşlemdeki aktif bağlantıyı geri alır

public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Bağlantıda etkin işlemi gerçelkeştirir

public **getTransactionLevel** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Geçerli işlemin yerleştirme seviyesini getirir

public **isUnderTransaction** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Bağlantının bir işlem altında olup olmadığını denetler

```php
<?php

$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);

```

public **getInternalHandler** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Dahili PDO işleyicisisini döndür

public *array* **getErrorInfo** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Varsa hata bilgisini döndür

public **getDialectType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Kullanılan lehçenin adı

public **getType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Adaptörün kendisi için kullanıldığı veritabanı sistemi türü

public **getSqlVariables** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Etkin SQL iilişkili parametre değişkenleri

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Olay yöneticisi ayarlar

public **getEventsManager** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Dahili olay yöneticisini döndürür

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

SQL'i üretmek için kullanılan lehçeyi ayarlar

public **getDialect** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Dahili lehçe örneğini döndürür

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir SQL sorgusu sonucundaki ilk satırı döndürür

```php
<?php

// Getting first robot
$robot = $connection->fetchOne("SELECT * FROM robots");
print_r($robot);

// Getting first robot with associative indexes only
$robot = $connection->fetchOne("SELECT * FROM robots", \Phalcon\Db::FETCH_ASSOC);
print_r($robot);

```

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir sorgunun tam sonucunu bir diziye yığar

```php
<?php

// Getting all robots with associative indexes only
$robots = $connection->fetchAll(
    "SELECT * FROM robots",
    \Phalcon\Db::FETCH_ASSOC
);

foreach ($robots as $robot) {
    print_r($robot);
}

 // Getting all robots that contains word "robot" withing the name
$robots = $connection->fetchAll(
    "SELECT * FROM robots WHERE name LIKE :name",
    \Phalcon\Db::FETCH_ASSOC,
    [
        "name" => "%robot%",
    ]
);
foreach($robots as $robot) {
    print_r($robot);
}
 
Text
XPath: /pre[2]/code

```

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir SQL sorgusu sonucundaki ilk satırın n'nci alanını döndürür

```php
<?php

// Getting count of robots
$robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
print_r($robotsCount);

// Son düzenlenen robotun adını öğrenme
$robot = $connection->fetchColumn(
    "SELECT id, name FROM robots order by modified desc",
    1
);
print_r($robot);
 
yazdırma
XPath: /pre[3]/code;

```

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Veriyi özel RDBMS SQL sözdizimi kullanarak bir tabloya yerleştirir

```php
<?php

// Inserting a new robot
$success = $connection->insert(
    "robots",
    ["Astro Boy", 1952],
    ["name", "year"]
);

// Next SQL sentence is sent to the database system
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Veriyi özel RDBM SQL sözdizimi kullanarak bir tabloya yerleştirir

```php
<?php

// Inserting a new robot
$success = $connection->insertAsDict(
    "robots",
    [
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Next SQL sentence is sent to the database system
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablodaki veriyi özel RBDM sözdizimi kullanarak günceller

```php
<?php

// Updating existing robot
$success = $connection->update(
    "robots",
    ["name"],
    ["New Astro Boy"],
    "id = 101"
);

// Next SQL sentence is sent to the database system
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

// Updating existing robot with array condition and $dataTypes
$success = $connection->update(
    "robots",
    ["name"],
    ["New Astro Boy"],
    [
        "conditions" => "id = ?",
        "bind"       => [$some_unsafe_id],
        "bindTypes"  => [PDO::PARAM_INT], // use only if you use $dataTypes param
    ],
    [
        PDO::PARAM_STR
    ]
);

```

Warning! If $whereCondition is string it not escaped.

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bİr tablodaki veriyi özel RBDM SQL sözdizimini kullanarak günceller Diğer, daha uygun sözdizimi

```php
<?php

// Updating existing robot
$success = $connection->updateAsDict(
    "robots",
    [
        "name" => "New Astro Boy",
    ],
    "id = 101"
);

// Next SQL sentence is sent to the database system
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

```

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablodan özel RBDM SQL sözdizimini kullarak veriyi siler

```php
<?php

// Deleting existing robot
$success = $connection->delete(
    "robots",
    "id = 101"
);

// Next SQL sentence is generated
DELETE FROM `robots` WHERE `id` = 101

```

public **escapeIdentifier** (*array* | *string* $identifier) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Escapes a column/table/schema name

```php
<?php

$escapedTable = $connection->escapeIdentifier(
    "robots"
);

$escapedTable = $connection->escapeIdentifier(
    [
        "store",
        "robots",
    ]
);

```

public *string* **getColumnList** (*array* $columnList) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Sütunların bir listesini alır

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Appends a LIMIT clause to $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir schema.table varlığı için SQL denetimi üretir

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir schema.view varlığı için SQL denetimi üretir

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir FOR UPDATE yan tümcesiyle değiştirilmiş bir SQL döndürür

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir LOCK IN SHARE MODE yan tümcesiyle değiştirilmiş bir SQL döndürür

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablo oluştur

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir şema/veritabanından bir tablo düşürür

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir görünüm oluşturur

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir görünüm düşürür

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tabloya bir sütun ekler

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablo sütununu bir tanıma dayanarak değiştirir

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablodan bir sütun düşürür

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tabloya bir indeks ekler

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablodan bir sütun düşür

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tabloya bir birincil anahtar ekler

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablonun birincil anahtarını düşürür

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tabloya bir dış anahtar ekler

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablodan bir dış anahtar düşürür

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir sütundan SQL sütun tanımını döndürür

public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir veritabanındaki tüm tabloları listele

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir veritabanındaki tüm görünümleri listele

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir tablodan oluştrma seçeneklerini alır

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Yeni bir kayıt noktası oluşturur

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Verilen kayıt noktasını bırakır

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Verilen kayıt noktasına geri döner

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

İç içe geçmiş işlemler kayıt noktaları kullanmalı mı, ayarlar

public **isNestedTransactionsWithSavepoints** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

İç içe geçmiş işlemler kayıt noktaları kullanmalı mı, döndürür

public **getNestedTransactionSavepointName** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

İç içe geçmiş işlemlerde kullanmak için kayıt noktası adını döndürür

public **getDefaultIdValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir kimlik sütununda eklenecek varsayılan kimlik değerlerini döndürür

```php
<?php

// Inserting a new robot with a valid default value for the column 'id'
$success = $connection->insert(
    "robots",
    [
        $connection->getDefaultIdValue(),
        "Astro Boy",
        1952,
    ],
    [
        "id",
        "name",
        "year",
    ]
);

```

public **supportSequences** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Bir veritabanı sistemi otomatik-sayısal değerler üretmek için bir sıralamaya ihtiyaç duyar mı duymaz mı kontrol et

public **getDescriptor** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Etkin veritabanına bağlanmak için kullanılan tanımlayıcıyı döndür

public *string* **getConnectionId** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Etkin bağlantının benzersiz tanımlayıcısını alır

public **getSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Nesnede etkin SQL ifade

public **getRealSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

İlişkili parametreleri değiştirmeksizin nesnede etkin SQL ifade

public *array* **getSQLBindTypes** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Nesnede etkin SQL ifade