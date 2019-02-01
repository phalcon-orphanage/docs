---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Adapter'
---
# Abstract class **Phalcon\Db\Adapter**

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter.zep)

Base class for Phalcon\Db adapters

## Metodlar

genel **getDialectType** ()

Kullanılan lehçenin adı

genel **getType** ()

Adaptörün kendisi için kullanıldığı veritabanı sistemi türü

genel **getSqlVariables** ()

Etkin SQL iilişkili parametre değişkenleri

genel **__construct** (*dizi* $açıklayıcısı)

Phalcon\Db\Adapter constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Olay yöneticisi ayarlar

herkes **Olay yöneticisini al** ()

Dahili olay yöneticisini döndürür

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect)

SQL'i üretmek için kullanılan lehçeyi ayarlar

genel **getDialect** ()

Dahili lehçe örneğini döndürür

genel **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes])

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

genel *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

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

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column])

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

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

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

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes])

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

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes])

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

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes])

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

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

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

public **escapeIdentifier** (*array* | *string* $identifier)

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

public *string* **getColumnList** (*array* $columnList)

Sütunların bir listesini alır

public **limit** (*mixed* $sqlQuery, *mixed* $number)

Appends a LIMIT clause to $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Bir schema.table varlığı için SQL denetimi üretir

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Bir schema.view varlığı için SQL denetimi üretir

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery)

Bir FOR UPDATE yan tümcesiyle değiştirilmiş bir SQL döndürür

public **sharedLock** (*mixed* $sqlQuery)

Bir LOCK IN SHARE MODE yan tümcesiyle değiştirilmiş bir SQL döndürür

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Bir tablo oluştur

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Bir şema/veritabanından bir tablo düşürür

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Bir görünüm oluşturur

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Bir görünüm düşürür

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Bir tabloya bir sütun ekler

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Bir tablo sütununu bir tanıma dayanarak değiştirir

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Bir tablodan bir sütun düşürür

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Bir tabloya bir indeks ekler

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Bir tablodan bir sütun düşür

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Bir tabloya bir birincil anahtar ekler

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Bir tablonun birincil anahtarını düşürür

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Bir tabloya bir dış anahtar ekler

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Bir tablodan bir dış anahtar düşürür

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Bir sütundan SQL sütun tanımını döndürür

public **listTables** ([*mixed* $schemaName])

Bir veritabanındaki tüm tabloları listele

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName])

Bir veritabanındaki tüm görünümleri listele

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema])

Tablo indekslerini listeler

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Tablo referanslarını listeler

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

Bir tablodan oluştrma seçeneklerini alır

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name)

Yeni bir kayıt noktası oluşturur

public **releaseSavepoint** (*mixed* $name)

Verilen kayıt noktasını bırakır

public **rollbackSavepoint** (*mixed* $name)

Verilen kayıt noktasına geri döner

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

İç içe geçmiş işlemler kayıt noktaları kullanmalı mı, ayarlar

public **isNestedTransactionsWithSavepoints** ()

İç içe geçmiş işlemler kayıt noktaları kullanmalı mı, döndürür

public **getNestedTransactionSavepointName** ()

İç içe geçmiş işlemlerde kullanmak için kayıt noktası adını döndürür

public **getDefaultIdValue** ()

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

public **getDefaultValue** ()

RBDM'in Tablo tanımlamasında beyan edilen varsayılan değeri kullanmasını sağlamak için varsayılan değeri getirir

```php
<?php

// Inserting a new robot with a valid default value for the column 'year'
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        $connection->getDefaultValue()
    ],
    [
        "name",
        "year",
    ]
);

```

genel **supportSequences** ()

Bir veritabanı sistemi otomatik-sayısal değerler üretmek için bir sıralamaya ihtiyaç duyar mı duymaz mı kontrol et

genel **useExplicitIdValue** ()

Veritabanı sisteminin kimlik sütunları için belirgin bir değere ihtiyacı olup olmadığını kontrol eder

genel **getDescriptor** ()

Etkin veritabanına bağlanmak için kullanılan tanımlayıcıyı döndür

public *string* **getConnectionId** ()

Etkin bağlantının benzersiz tanımlayıcısını alır

public **getSQLStatement** ()

Nesnede etkin SQL ifade

public **getRealSQLStatement** ()

İlişkili parametreleri değiştirmeksizin nesnede etkin SQL ifade

public *array* **getSQLBindTypes** ()

Nesnede etkin SQL ifade

abstract public **connect** ([*array* $descriptor]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **query** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **execute** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **affectedRows** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **lastInsertId** ([*mixed* $sequenceName]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **isUnderTransaction** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **getInternalHandler** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...