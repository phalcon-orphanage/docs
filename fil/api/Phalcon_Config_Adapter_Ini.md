# Klase ng **Phalcon\\Konfig\\Adapter\\Ini**

*ipagpatuloy pa ang* klase ng [Phalcon\Config](/en/3.2/api/Phalcon_Config)

*nagpapatupad ng* [Nabibilang](http://php.net/manual/en/class.countable.php), [ArrayAkses](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config/adapter/ini.zep" class="btn btn-default btn-sm">Pinagkukunan sa GitHub</a>

Nagbabasa ng mga file na ini at kino-konvert ang mga ito sa Phalcon\\Config na mga bagay.

Kasunod na binigay na kompigurasyon na file:

```ini
<?php

[database]
adapter = Mysql
host = localhost
username = scott
password = cheetah
dbname = test_db

[phalcon]
controllersDir = "../app/controllers/"
modelsDir = "../app/models/"
viewsDir = "../app/views/"

```

Maaari mo itong basahin bilang mga sumusunod:

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

echo $config->phalcon->controllersDir;
echo $config->database->username;

```

Maaaring mai-parse rin ang mga Konstant ng PHP sa file na ini, kaya kung tutukuyin mo ang isang konstant bilang isang halaga ng ini bago tawagin ang konstruktor, ang mga halaga ng konstant ay maisasama sa mga resulta. Upang magamit sa ganitong paraan kailangan mong tiyakin ang opsyonal ng dalawang parameter bilang INI_SCANNER_NORMAL kapag tinawag ang konstruktor:

```php
<?php

$config = bagong \Phalcon\Config\Adapter\Ini(
    "path/config-with-constants.ini",
    INI_SCANNER_NORMAL
);

```

## Mga konstant

*string* **DEFAULT_DAANAN_DELIMITER**

## Mga Paraan

pampublikong **__Konstruk** (*mixed* $filePath, [*mixed* $mode])

Phalcon\\Konfig\\Adapter\\Ini konstruktor

protektadong **_parseIniString** (*mixed* $path, *mixed* $value)

Gumawa ng array multidimensional na ayos mula sa string

```php
<?php

$this->_parseIniString("path.hello.world", "halaga para sa huling key");

// result
[
     "path" => [
         "hello" => [
             "world" => "halaga para sa huling key",
         ],
     ],
];

```

protektadong **_cast** (*mixed* $ini)

Kailangan nating mag-alis ng mga halaga nang manu-mano dahil ang parse_ini_file() ay may mahinang pagpapatupad.

pampublikong **offsetExists** (*mixed* $index) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Nagpapahintulot na suriin kung ang isang katangian ay timukoy gamit ang array-sintaks

```php
<?php

var_dump(
    isset($config["database"])
);

```

pampublikong **daanan** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Ibinabalik ang isang halaga mula sa kasalukuyang konfig gamit ang daanan ng pinaghihiwalay na tuldok.

```php
<?php

eko $config->path("unknown.path", "default", ".");

```

pampublikong **get** (*mixed* $index, [*mixed* $defaultValue]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Nakakakuha ng isang katangian mula sa kompigurasyon, kung ang attribute ay hindi tinukoy na ibinabalik na null Kung ang halaga ay eksaktong null o hindi natukoy ang default na halaga ay gagamitin sa halip

```php
<?php

eko $config->get("controllersDir", "../app/controllers/");

```

pampublikong **offsetGet** (*mixed* $index) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Kumukuha ng isang katangian na gumagamit ng array-sintaks

```php
<?php

print_r(
    $config["database"]
);

```

pampublikong **offsetSet** (*mixed* $index, *mixed* $value) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Nagtatakda ng isang katangian na gumagamit ng array-sintaks

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

pampublikong **offsetUnset** (*mixed* $index) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Hindi tinatakda ang isang katangian na gumagamit ng array-sintaks

```php
<?php

unset($config["database"]);

```

pampublikong **pinagsama** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) $config) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Pinagsama ang pagsasaayos sa kasalukuyan

```php
<?php

$appConfig = bagong \Phalcon\Konfig(
    [
        "database" => [
            "host" => "lokalhost",
        ],
    ]
);

$globalConfig->merge($appConfig);

```

pampublikong **toArray** () na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Kino-konvert ng paulit-ulit ang object sa isang array

```php
<?php

print_r(
    $config->toArray()
);

```

pampublikong **bilang** () na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Ibinabalik ang bilang ng mga katangian na itinakda sa konfig

```php
<?php

i-print ang bilang($config);

```

o

```php
<?php

i-print ang $config->bilang();

```

pampublikong statik **__set_state** (*array* $data) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Ibinabalik ang estado ng isang Phalcon\\Konfig na bagay

pampublikong statik **setPathDelimiter** ([*mixed* $delimiter]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Itinatakda ang default na delimiter ng pagdaraanan

pampublikong statik **getPathDelimiter** () na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Nagkukuha ng default na delimiter ng pagdaraanan

huling protektado *na pinagsamang Konfig konfig* **_merge** (*Config* $config, [*mixed* $instance]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Pamamaraan ng Helper para sa mga konfig na pagsasamahin (pagpapasa ng nested konfig na instansiya)