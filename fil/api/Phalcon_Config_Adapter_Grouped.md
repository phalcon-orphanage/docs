# Klase ng **Phalcon\\Konfig\\Adapter\\Nakapangkat**

*ipinagpatuloy ang* klase ng [Phalcon\Config](/en/3.2/api/Phalcon_Config)

*nagpapatupad ng* [Nabibilang](http://php.net/manual/en/class.countable.php), [ArrayAkses](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config/adapter/grouped.zep" class="btn btn-default btn-sm">Pinagkukunan sa GitHub</a>

Nakakabasa ng maramihang mga file (o mga array) at pinagsama ang mga ito nang sama-sama.

```php
<?php

gamitin ang Phalcon\Konfig\Adapter\Nakapangkat;

$config = bagong Nakapangkat(
    [
        "path/to/config.php",
        "path/to/config.dist.php",
    ]
);

```

```php
<?php

gamitin ang Phalcon\Konfig\Adapter\Nakapangkat;

$config = bagong Nakapangkat(
    [
        "path/to/config.json",
        "path/to/config.dist.json",
    ],
    "json"
);

```

```php
<?php

gamitin ang Phalcon\Konfig\Adapter\Nakapangkat;

$config = bagong Nakapangkat(
    [
        [
            "filePath" => "path/to/config.php",
            "adapter"  => "php",
        ],
        [
            "filePath" => "path/to/config.json",
            "adapter"  => "json",
        ],
        [
            "adapter"  => "array",
            "config"   => [
                "property" => "halaga",
        ],
    ],
);

```

## Mga konstant

*string* **DEFAULT_DAANAN_DELIMITER**

## Mga Paraan

pampublikong **__konstrak** (*array* $arrayConfig, [*mixed* $defaultAdapter])

Phalcon\\Konfig\\Adapter\\Nakapangkat na konstruktor

pampublikong **offsetExists** (*mixed* $index) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Pinapayagan para suriin kung ang isang katangian ay tinukoy gamit ang array-sintaks

```php
<?php

var_dump(
    isset($config["database"])
);

```

pampublikong **daanan** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Ibinabalik ang isang halaga mula sa kasalukuyang konfig gamit ang isang daanan na pinaghiwalay na tuldok.

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
    "uri" => "Sqlite",
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

i-print ang $config->count();

```

pampublikong statik **__set_state** (*array* $data) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Ibinabalik ang estado ng isang Phalcon\\Konfig na bagay

pampublikong statik **setPathDelimiter** ([*mixed* $delimiter]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Itinatakda ang default na delimiter ng pagdaraanan

pampublikong statik **getPathDelimiter** () na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Nagkukuha ng default na delimiter ng pagdaraanan

huling protektado *na pinagsamang Konfig konfig* **_merge** (*Config* $config, [*mixed* $instance]) na nakuha mula sa [Phalcon\Konfig](/en/3.2/api/Phalcon_Config)

Pamamaraan ng Helper para sa mga konfig na pagsasamahin (pagpapasa ng nested konfig na instansiya)