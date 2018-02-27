# Klase ng Abstrak **Phalcon\\Mvc\\Model**

*implements* [Phalcon\Mvc\EntityInterface](/en/3.2/api/Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface), [Phalcon\Mvc\Model\ResultInterface](/en/3.2/api/Phalcon_Mvc_Model_ResultInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Serializable](http://php.net/manual/en/class.serializable.php), [JsonSerializable](http://php.net/manual/en/class.jsonserializable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model.zep" class="btn btn-default btn-sm">Pinanggalingan sa Github</a>

Phalcon\\Mvc\\Model kumokonekta sa mga layon ng negosyo at database ng mga talahanayan para gumawa ng isang matibay na modelo ng dominyo kung saan ang lohika at datos ay inilahad sa isang pag-wrap. Ito ay isang implementasyon ng layon-pagmamapa ng pamanggit (ORM).

Ang modelo ay naglalahad ng impormasyon (datos) ng aplikasyon at ng mga patakaran upang mamanipula ang datos. Ang mga modelo ay pangunahing ginamit para sa pagpapangasiwa ng mga patakaran ng interaksyon kasama ang isang tumutugon na talahanayan ng database. Sa mga kaso ng karamihan, bawat talahanayan sa iyong database ay tumutugma sa isang modelo sa iyong aplikasyon. Ang laki ng iyong aplikasyong ng lohika ng negosyo ay maaaring ang mga modelo ay maging puro.

Phalcon\\Mvc\\Model ay unang ORM na naisulat sa Zephric/C na mga lenggwahe para sa PHP, ipagkakaloob sa mga developer na mataas ang pagganap kapag nakikipagtulungan kasama ang mga database habang ito rin ay madaling magamit.

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can store robots: ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

## Mga Constant

*kabuuan* **OP_WALA**

*kabuuan* **OP_PAGLIKHA**

*kabuuan***OP_PAGBABAGO**

*kabuuan* **OP_TANGGALIN**

*kabuuan* **MARUMI_ESTADO_PAULIT-ULIT**

* kabuuan* **MARUMI_ESTADO_TRANSIYENT**

*Kabuuan* **MARUMI_ESTADO_HIWALAY**

## Mga Pamamaraan

kahuli-hulihang pampubliko **__gumawa** ([*magkahalo* $data], [[Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Model\ManagerInterface](/en/3.2/api/Phalcon_Mvc_Model_ManagerInterface) $modelsManager])

Phalcon\\Mvc\\Model tagapagbuo

pampublikong **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Itatakda ang dependensya na lalagyan ng ineksyon

pampublikong **getDI** ()

Ibabalik ang dependensya na lalagyan ng ineksyon

protektadong **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Itatakda ang isang tagapamahala ng mga pnagyayari sa kostumbre

protektadong **getEventsManager** ()

Ibabalik ang tagapamahala ng mga pangyayari sa kostumbre

pampublikong **getModelsMetaData** ()

Ibabalik ang mga modelo ng meta-data na serbisyo na may kaugnayan sa halimbawa ng entidad

pampublikong **getModelsManager** ()

Ibabalik ang mga modelo ng tagapamahala na may kaugnayan sa halimbawa ng entidad

pampublikong **setTransaction** ([Phalcon\Mvc\Model\TransactionInterface](/en/3.2/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

Itatakda ang isang transaksyon kaugnay sa Halimbawa ng Modelo

```php
<?php

use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

try {
    $txManager = new TxManager();

    $transaction = $txManager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Robot part cannot be saved");
    }

    $transaction->commit();
} catch (TxFailed $e) {
    echo "Failed, reason: ", $e->getMessage();
}

```

protektadong **setSource** (*mixed* $source)

Itatakda ang pangalan ng talahanayan sa kung saan ang modelo ay dapat na isamapa

pampublikong **getSource** ()

Ibabalik ang pangalan ng talahanayan na isinamapa sa modelo

protektadong **setSchema** (*mixed* $schema)

Itatakda ang talahanayan ng panukala kung saan ang isinamapa na talahanayan na matatagpuan

pampublikong **getSchema** ()

Ibabalik ang pangalan ng panukala kung saan ang isinamapa na talahanayan na matatagpuan

pampublikong **setConnectionService** (*mixed* $connectionService)

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo

pampublikong **setReadConnectionService** (*mixed* $connectionService)

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagbasa ng datos

pampublikong **setWriteConnectionService** (*mixed* $connectionService)

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagsulat sa datos

pampublikong **getReadConnectionService** ()

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagbasa ng datos

pampublikong **getWriteConnectionService** ()

Ibabalik ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagsulat sa datos na may kaugnayan sa datos

pampublikong **setDirtyState** (*magkahalo* $dirtyState)

Itatakda ang maruming estado ng layon gamit ang isa sa DIRTY_STATE_* na mga constant

pampublikong **getDirtyState** ()

Ibabalik ang isa sa DIRTY_STATE_* na mga constant sasabihin na ang umiiral na rekord sa database o hindi

pampublikong **getReadConnection** ()

Makakakuha ng koneksyon upang gamitin ang pagbasa ng datos para sa modelo

pampublikong **getWriteConnection** ()

Makakakuha ng koneksyon upang gamitin ang pagsulat ng datos sa modelo

pampublikong [Phalcon\Mvc\Model](/en/3.2/api/Phalcon_Mvc_Model) **assign** (*array* $data, [*mixed* $dataColumnMap], [*array* $whiteList])

Nagtatalaga ng mga mahahalaga sa isang modelo mula sa isang array

```php
<?php

$robot->assign(
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Assign by db row, column map needed
$robot->assign(
    $dbRow,
    [
        "db_type" => "type",
        "db_name" => "name",
        "db_year" => "year",
    ]
);

// Allow assign only name and year
$robot->assign(
    $_POST,
    null,
    [
        "name",
        "year",
    ]
);

// By default assign method will use setters if exist, you can disable it by using ini_set to directly use properties

ini_set("phalcon.orm.disable_assign_setters", true);

$robot->assign(
    $_POST,
    null,
    [
        "name",
        "year",
    ]
);

```

pampublikong istatik **cloneResultMap** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\Model\Row](/en/3.2/api/Phalcon_Mvc_Model_Row) $base, *array* $data, *array* $columnMap, [*int* $dirtyState], [*boolean* $keepSnapshots])

Nagtatalaga ng mga mahahalaga sa isang modelo mula sa isang array, pagbabalik sa isang bagong modelo.

```php
<?php

$robot = \Phalcon\Mvc\Model::cloneResultMap(
    new Robots(),
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

```

pampublikong istatik *mixed* **cloneResultMapHydrate** (*array* $data, *array* $columnMap,*int* $hydrationMode)

Ibabalik ang isang hydrated na resulta base sa datos at sa kulumna na mapa

pampublikong istatik [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) **cloneResult** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $base, *array* $data, [*int* $dirtyState])

Nagtatalaga ng mga mahahalaga sa isang modelo mula sa isang array pagbabalik sa isang bagong modelo

```php
<?php

$robot = Phalcon\Mvc\Model::cloneResult(
    new Robots(),
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

```

pampublikong istatik **find** ([*mixed* $parameters])

Mag-usisa para sa isang takda ng mga rekord na tumutugma ang tinukoy na mga kondisyon

```php
<?php

// How many robots are there?
$robots = Robots::find();

echo "There are ", count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find(
    "type = 'mechanical'"
);

echo "There are ", count($robots), "\n";

// Get and print virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

foreach ($robots as $robot) {
 echo $robot->name, "\n";
}

// Get first 100 virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100,
    ]
);

foreach ($robots as $robot) {
 echo $robot->name, "\n";
}

```

pampublikong istatik *static* **findFirst** ([*string* | *array* $parameters])

Mag-usisa sa unang pagrekord na magtutugma sa tinukoy na mga kondisyon

```php
<?php

// What's the first robot in robots table?
$robot = Robots::findFirst();

echo "The robot name is ", $robot->name;

// What's the first mechanical robot in robots table?
$robot = Robots::findFirst(
    "type = 'mechanical'"
);

echo "The first mechanical robot name is ", $robot->name;

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

echo "The first virtual robot name is ", $robot->name;

```

pampublikong istatik **query** ([[Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector])

Gumawa ng isang pamantayan para sa isang partikular na modelo

protektadong *boolean* **_exists** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, [*string* | *array* $table])

Sinisiyasat kung ang kasalukuyang rekord ay umiiral na

protektadong istatik [Phalcon\Mvc\Model\ResultsetInterface](/en/3.2/api/Phalcon_Mvc_Model_ResultsetInterface) **_groupResult** (*mixed* $functionName, *string* $alias, *array* $parameters)

Bumuo ng isang PHQL SELECT na pahayag para sa isang kabuuan

pampublikong istatik *mixed* **count** ([*array* $parameters])

Binibilang kung gaano karami ang mga rekord na tumutugma ang tinukoy na mga kondisyon

```php
<?php

// How many robots are there?
$number = Robots::count();

echo "There are ", $number, "\n";

// How many mechanical robots are there?
$number = Robots::count("type = 'mechanical'");

echo "There are ", $number, " mechanical robots\n";

```

pampublikong istatik *mixed* **sum** ([*array* $parameters])

Kalkulahin ang kabuuan sa isang kulumna para sa isang resulta na itinakda ng mga hanay na tumugma ang tinukoy na mga kondisyon

```php
<?php

// How much are all robots?
$sum = Robots::sum(
    [
        "column" => "price",
    ]
);

echo "The total price of robots is ", $sum, "\n";

// How much are mechanical robots?
$sum = Robots::sum(
    [
        "type = 'mechanical'",
        "column" => "price",
    ]
);

echo "The total price of mechanical robots is  ", $sum, "\n";

```

pampublikong istatik *mixed* **maximum** ([*array* $parameters])

Ibabalik ang pinakamataas na halaga sa isang kulumna para sa isang resulta na itinakda ng mga hanay na tumugma ang tinukoy na mga kondisyon

```php
<?php

// What is the maximum robot id?
$id = Robots::maximum(
    [
        "column" => "id",
    ]
);

echo "The maximum robot id is: ", $id, "\n";

// What is the maximum id of mechanical robots?
$sum = Robots::maximum(
    [
        "type = 'mechanical'",
        "column" => "id",
    ]
);

echo "The maximum robot id of mechanical robots is ", $id, "\n";

```

pampublikong istatik *mixed* **minimum** ([*array* $parameters])

Ibabalik ang pinakamababa na halaga sa isang kulumna para sa isang resulta na itinakda ng mga hanay na tumugma ang tinukoy na mga kondisyon

```php
<?php

// What is the minimum robot id?
$id = Robots::minimum(
    [
        "column" => "id",
    ]
);

echo "The minimum robot id is: ", $id;

// What is the minimum id of mechanical robots?
$sum = Robots::minimum(
    [
        "type = 'mechanical'",
        "column" => "id",
    ]
);

echo "The minimum robot id of mechanical robots is ", $id;

```

pampumblikong istatik *double* **average** ([*array* $parameters])

Ibabalik ang katamtamang halaga sa isang kulumna para sa isang resulta ng itinakda ng mga hanay na tumutugma ang tinukoy na mga kondisyon

```php
<?php

// What's the average price of robots?
$average = Robots::average(
    [
        "column" => "price",
    ]
);

echo "The average price is ", $average, "\n";

// What's the average price of mechanical robots?
$average = Robots::average(
    [
        "type = 'mechanical'",
        "column" => "price",
    ]
);

echo "The average price of mechanical robots is ", $average, "\n";

```

pampublikong **fireEvent** (*mixed* $eventName)

Isisante ang isang pangyayari, implicitly ay tinatawag na pag-uugali at mga tagapakinig sa tagapamahala ng mga pangyayari ay maabisuhan

pampublikong **fireEventCancel** (*mixed* $eventName)

Isisante ang isang pangyayari, implicitly ay tinatawag na pag-uugali at mga tagapakinig sa tagapamahala ng mga pangyayari ay ipinabatid Ang pamamaraang ito ay hindi humihinto kung ang isa sa callback/mga tagapakinig ay bumabalik sa boolean na hindi tama

protektadong **_cancelOperation** ()

Kanselahin ang opersayon ng kasalukuyan

pampublikong **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](/en/3.2/api/Phalcon_Mvc_Model_MessageInterface) $message)

Ilakip ang isang nai-customize na mensahe sa proseso ng pagpapatunay

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message as Message;

class Robots extends Model
{
    public function beforeSave()
    {
        if ($this->name === "Peter") {
            $message = new Message(
                "Sorry, but a robot cannot be named Peter"
            );

            $this->appendMessage($message);
        }
    }
}

```

protektadong **validate** ([Phalcon\ValidationInterface](/en/3.2/api/Phalcon_ValidationInterface) $validator)

Nagpapatupad sa mga validator sa bawat tawag ng pagpapatunay

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscriptors extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}

```

pampublikong **validationHasFailed** ()

Siyasatin kung ang proseso ng pagpapatunay ay mayroong nabuo sa kahit anong mga menshahe

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscriptors extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->validate(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}

```

pampublikong **getMessages** ([*mixed* $filter])

Ibinabalik ng array ang pagpapatunay ng mga mensahe

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

kahuli-hulihang protektado **_checkForeignKeysRestrict** ()

Bumabasa ng "nabibilang sa" ng mga relasyon at sinisiyasat ang virtual na dayuhan ng mga key kapag magpapasok o mag-a-update ng mga rekord upang maberipika na ang ipinasok/na-update na mga mahahalaga ay naroroon sa may kaugnayang entidad

kahuli-hulihang protektado **_checkForeignKeysReverseCascade** ()

Binabasa parehas ang "hasMany" at "hasOne" na mga relasyon at sinisiyasat ang virtual na dayuhang mga key (kaskad) kapa nagtatanggal ng mga rekord

kahuli-hulihang protektado **_checkForeignKeysReverseRestrict** ()

Binabasa parehas ang "hasMany" at "hasOne" na mga relasyon at sinisiyasat ang virtual ba dayuhang mga key (takdaan) tuwing nagtatanggal ng mga rekord

protektadong **_preSave** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, *mixed* $exists, *mixed* $identityField)

Ipatutupad ang mga hook na panloob bago i-seyb ang isang rekord

protektadong **_postSave** (*mixed* $success, *mixed* $exists)

Ipatutupad ang panloob na mga pangyayari matapos i-seyb ang isang rekord

protektadong *boolean* **_doLowInsert** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table, *boolean* | *string* $identityField)

Magpapadala ng isang pre-build na INSERT SQL na paglalahad sa pamanggit na sistema ng database

protektadong *boolean* **_doLowUpdate** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table)

Magpapadala ng isang pre-build na UPDATE SQL na paglalahad sa pamanggit na sistema ng database

protektadong *boolean* **_preSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $related)

Magsi-seyb ng may kaugnayan sa mga rekord na dapat nakatagong priyor para ma-seyb ang master ng rekord

protektadong *boolean* **_postSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $related)

I-seyb ang may kaugnayang mga rekord na itinalaga sa has-one/has-many na mga relasyon

pampublikong *boolean* **save** ([*array* $data], [*array* $whiteList])

Magpapasok o magpapabago ang isang modelo ng halimbawa. Ibabalik sa totoong pagtatagumpay o mali sa ibang paraan.

```php
<?php

// Creating a new robot
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->save();

// Updating a robot name
$robot = Robots::findFirst("id = 100");

$robot->name = "Biomass";

$robot->save();

```

pampublikong **create** ([*mixed* $data], [*mixed* $whiteList])

Magpapasok ng isang modelo ng halimbawa. Kung ang halimbawa ay umiiiral na sa pagtitiyaga ay ito-throw ito sa isang eksepsyon Ibabalik sa totoong pagtatagumpay o mali sa ibang paraan.

```php
<?php

// Creating a new robot
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();

// Passing an array to create
$robot = new Robots();

$robot->create(
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

```

pampublikong **update** ([*mixed* $data], [*mixed* $whiteList])

Ma-a-update ang isang modelo ng halimbawa. Kung ang halimbawa ay hindi umiiral sa pagtitiyaga ay ito-throw nito ang isang eksepsyon Ibabalik sa totoong pagtatagumpay o mali sa ibang paraan.

```php
<?php

// Updating a robot name
$robot = Robots::findFirst("id = 100");

$robot->name = "Biomass";

$robot->update();

```

pampublikong **delete** ()

Tatanggalin ang isang modelo. Babalik sa totoong pagtatagumpay o mali sa ibang paraan.

```php
<?php

$robot = Robots::findFirst("id=100");

$robot->delete();

$robots = Robots::find("type = 'mechanical'");

foreach ($robots as $robot) {
    $robot->delete();
}

```

pampublikong **getOperationMade** ()

Ibabalik ang tipo ng pinakabagong operasyon na isinagawa sa pamamagitan ng ORM Ibabalik ang isa sa OP_* na klase ng mga constant

pampublikong **refresh** ()

Papanariwain ang modelo ng mga katangian na muling magtanong ang rekord mula sa database

pampublikong **skipOperation** (*mixed* $skip)

Laktawan ang kasalukuyang operasyong pinipilit sa isang matagumpay na estado

pampublikong **readAttribute** (*mixed* $attribute)

Binabasa ang halaga ng isang katangian sa pamamagitan ng pangalan nito

```php
<?php

echo $robot->readAttribute("name");

```

pampublikong **writeAttribute** (*mixed* $attribute, *mixed* $value)

Nagsusulat ang halaga ng isang katangian sa pamamagitan ng pangalan nito

```php
<?php

$robot->writeAttribute("name", "Rosey");

```

protektadong **skipAttributes** (*array* $attributes)

Magtatakda ng isang listahan ng mga katangian na dapat na nalaktwan mula sa nabuong INSERT/UPDATE ng pahayag

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributes(
            [
                "price",
            ]
        );
    }
}

```

protektadong **skipAttributesOnCreate** (*array* $attributes)

Magtatakda ng isang listahan ng mga katangian na dapat ay nalaktawan mula sa nabuong INSERT ng pahayag

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributesOnCreate(
            [
                "created_at",
            ]
        );
    }
}

```

protektadong **skipAttributesOnUpdate** (*array* $attributes)

Magtatakda ng isang listahan ng mga katangian na dapat ay nalaktwan mula sa nabuong UPDATE ng pahayag

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributesOnUpdate(
            [
                "modified_in",
            ]
        );
    }
}

```

protektadong **allowEmptyStringValues** (*array* $attributes)

Magtatakda ng isang listahan ng mga katangian na dapat ay nalaktawan mula sa nabuong UPDATE ng pahayag

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->allowEmptyStringValues(
            [
                "name",
            ]
        );
    }
}

```

protektadong **hasOne** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

I-setup ang isang 1-1 na relasyon sa pagitan ng dalawang mga modelo

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne("id", "RobotsDescription", "robots_id");
    }
}

```

protektadong **belongsTo** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

I-setup ang isang pagbaliktad ng 1-1 o n- 1 na relasyon sa pagitan ng dalawang mga modelo

```php
<?php

class RobotsParts extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo("robots_id", "Robots", "id");
    }
}

```

protektadong **hasMany** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

I-setup ang isang 1-n na relasyon sa pagitan sa dalawang mga modelo

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "robots_id");
    }
}

```

protektadong [Phalcon\Mvc\Model\Relation](/en/3.2/api/Phalcon_Mvc_Model_Relation) **hasManyToMany** (*string* | *array* $fields, *string* $intermediateModel, *string* | *array* $intermediateFields, *string* | *array* $intermediateReferencedFields, *mixed* $referenceModel, *string* | *array* $referencedFields, [*array* $options])

I-setup ang isang n-n na relasyon sa pagitan ng dalawang mga modelo, sa pamamagitan ng isang intermediya na relasyon

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        // Setup a many-to-many relation to Parts through RobotsParts
        $this->hasManyToMany(
            "id",
            "RobotsParts",
            "robots_id",
            "parts_id",
            "Parts",
            "id",
        );
    }
}

```

pampublikong **addBehavior** ([Phalcon\Mvc\Model\BehaviorInterface](/en/3.2/api/Phalcon_Mvc_Model_BehaviorInterface) $behavior)

Ise-setup ang isang kilos sa isang modelo

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Robots extends Model
{
    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
               [
                   "onCreate" => [
                        "field"  => "created_at",
                        "format" => "Y-m-d",
                       ],
                ]
            )
        );
    }
}

```

protektadong **keepSnapshots** (*mixed* $keepSnapshot)

Magtatakda kung ang modelo ay dapat panatilihin ang orihinal na rekord ng snapshot sa memorya

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}

```

pampublikong **setSnapshotData** (*array* $data, [*array* $columnMap])

Magtatakda ang rekord ng snapshot sa datos

pampublikong **hasSnapshotData** ()

Sinisisayat kung ang layon ay amyroon nakapaloob na datos ng snapshot

pampublikong **getSnapshotData** ()

Ibabalik ang nakapaloob na datos ng snapshot

pampublikong **getOldSnapshotData** ()

Ibabalik ang nakapaloob na lumang datos ng snapshot

pampublikong **hasChanged** ([*string* | *array* $fieldName], [*boolean* $allFields])

Siyasatin kung ang isang tinukoy na katangian ay nabago Ito ay magagawa lamang kung ang modelo ay iniingatan ang datos ng mga snapshot

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();
$robot->type = "hydraulic";
$hasChanged = $robot->hasChanged("type"); // returns true
$hasChanged = $robot->hasChanged(["type", "name"]); // returns true
$hasChanged = $robot->hasChanged(["type", "name", true]); // returns false

```

pampublikong **hasUpdated** ([*string* | *array* $fieldName], [*mixed* $allFields])

Siyasatin kung ang isang partikular na katangian ay na-update Ito ay magagawa lamang kung ang modelo ay iniingatan ang datos ng mga snapshot

pampublikong **getChangedFields** ()

Ibabalik ang isang listahan ng binagong mga kahalagahan.

```php
<?php

$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]

```

pampublikong **getUpdatedFields** ()

Ibabalik ang isang listahan ng binagong mga kahalagahan.

```php
<?php

$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]
$robots->save();
print_r($robots->getChangedFields()); // []
print_r($robots->getUpdatedFields()); // ["deleted"]

```

protektadong **useDynamicUpdate** (*mixed* $dynamicUpdate)

Itatakda kung ang isang modelo ay dapat gamitin ang dinamika na pagbabago sa halip ang lahat ng ia-update na field

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}

```

pampublikong [Phalcon\Mvc\Model\ResultsetInterface](/en/3.2/api/Phalcon_Mvc_Model_ResultsetInterface) **getRelated** (*string* $alias, [*array* $arguments])

Ibabalik ang may kaugnayan sa mga rekord base sa tinukoy na mga relasyon

protektadong *mixed* **_getRelatedRecords** (*string* $modelName, *string* $method, *array* $arguments)

Ibabalik ang may kaugnayan na mga rekord na tinukoy na mga relasyon depende sa pamamaraan ng pangalan

kahuli-hulihang protektadong istatik [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) | *boolean* **_invokeFinder** (*string* $method, *array* $arguments)

Subukang siyasatin kung ang katanungan ay dapat manawagan sa isang tagahanap

pampublikong *mixed* **__call** (*string* $method, *array* $arguments)

Hinahawakan ang mga tawag ng pamamaraan kung kailan ang isang pamamaraan ay hindi ipinatupad

pampublikong istatik *mixed* **__callStatic** (*string* $method, *array* $arguments)

Hinahawakan ang mga tawag ng pamamaraan kung kailan ang isang pamamaraan ng isang istatik ay hindi ipinatupad

pampublikong **__set** (*string* $property, *mixed* $value)

Ang Pamamaraan na mahika ay upang magtalaga ng mahahalaga sa modelo

kahuli-hulihang protektadong *string* **_possibleSetter** (*string* $property, *mixed* $value)

Siyasatin para sa, at subukan gumamit, posibleng setter.

pampublikong [Phalcon\Mvc\Model\Resultset](/en/3.2/api/Phalcon_Mvc_Model_Resultset) | [Phalcon\Mvc\Model](/en/3.2/api/Phalcon_Mvc_Model) **__get** (*string* $property)

Ang pamamaraang mahika ay kumukuha ng may kaugnayang mga rekord gamit ang relasyon ng alyas bilang isang katangian

pampublikong **__isset** (*mixed* $property)

Ang pamamaraan ng mahika ay upang masiyasat kung ang isang katangian ay isang tunay na relasyon

pampublikong **serialize** ()

Inilalalathala nang baha-bahagi ang layon upang hindi pansinin ang mga koneksyon, mga serbisyo, may kauganayang mga layon o istatik na mga katangian

pampublikong **unserialize** (*mixed* $data)

Hindi inilalathala nang baha-bahagi ang layon mula sa isang inilathalang baha-bahaging string

pampublikong **dump** ()

Ibabalik ang isang simpleng representasyon ng layon na maaaring gamitin kasama ng var-dump

```php
<?php

var_dump(
    $robot->dump()
);

```

pampublikong *array* **toArray** ([*array* $columns])

Ibabalik ang instansiya bilang presentasyon ng isang array

```php
<?php

print_r(
    $robot->toArray()
);

```

pampublikong *array* **jsonSerialize** ()

Inilalathala nang baha-bahagi ang layon para sa json-encode

```php
<?php

echo json_encode($robot);

```

pampublikong istatik **setup** (*array* $options)

Ang mga Enables/disables ay mga pagpipilian sa ORM

pampublikong **reset** ()

I-reset ang isang modelo ng instansiya na datos