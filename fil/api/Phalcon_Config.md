# Klase ng **Phalcon\\Config**

*nagpapatupad ng* [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php), [Countable](http://php.net/manual/en/class.countable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config.zep" class="btn btn-default btn-sm">Pinagkukunan sa GitHub</a>

Ang Phalcon\\Config ay dinisenyo upang gawing simple ang pag-akses sa, at ang paggamit ng, pagsasaayos ng data sa loob ng mga aplikasyon. Nagbibigay ito ng mapugad na bagay na batay sa interface ng user para ma-akses ang datos ng pagsasaayos sa loob code ng aplikasyon.

```php
<?php

$config = new \Phalcon\Config(
    [
        "database" => [
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db",
        ],
        "phalcon" => [
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/",
        ],
    ]
);

```

## Mga Konstant

*string* **DEFAULT_PATH_DELIMITER**

## Mga Paraan

pampublikong **__construct** ([*array* $arrayConfig])

Phalcon\\Config na konstruktor

pampublikong **offsetExists** (*mixed* $index)

Nagpapahintulot na suriin kung ang isang katangian ay timukoy gamit ang array-syntax

```php
<?php

var_dump(
    isset($config["database"])
);

```

pampublikong **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter])

Ibinabalik ang isang halaga mula sa kasalukuyang konfig gamit ang daanan ng pinaghihiwalay na tuldok.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

pampublikong **get** (*mixed* $index, [*mixed* $defaultValue])

Nakakakuha ng isang katangian mula sa kompigurasyon, kung ang attribute ay hindi tinukoy na ibinabalik na null Kung ang halaga ay eksaktong null o hindi natukoy ang default na halaga ay gagamitin sa halip

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

pampublikong **offsetGet** (*mixed* $index)

Kumukuha ng isang katangian na gumagamit ng array-syntax

```php
<?php

print_r(
    $config["database"]
);

```

pampublikong **offsetSet** (*mixed* $index, *mixed* $value)

Nagtatakda ng isang katangian na gumagamit ng array-syntax

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

pampublikong **offsetUnset** (*mixed* $index)

Hindi tinatakda ang isang katangian na gumagamit ng array-syntax

```php
<?php

unset($config["database"]);

```

pampublikong **merge** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) $config)

Pinagsama ang pagsasaayos sa kasalukuyan

```php
<?php

$appConfig = new \Phalcon\Config(
    [
        "database" => [
            "host" => "lokalhost",
        ],
    ]
);

$globalConfig->merge($appConfig);

```

pampublikong **toArray** ()

Kino-konvert ng paulit-ulit ang object sa isang array

```php
<?php

print_r(
    $config->toArray()
);

```

pampublikong **count** ()

Ibinabalik ang bilang ng mga katangian na itinakda sa konfig

```php
<?php

print count($config);

```

o

```php
<?php

print $config->bilang();

```

pampublikong statik **__set_state** (*array* $data)

Ibinabalik ang estado ng isang Phalcon\\Config na bagay

pampublikong statik **setPathDelimiter** ([*mixed* $delimiter])

Itinatakda ang default na delimiter ng pagdaraanan

pampublikong statik **getPathDelimiter** ()

Nagkukuha ng default na delimiter ng pagdaraanan

huling protektado *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

Pamamaraan ng Helper para sa mga konfig na pagsasamahin (pagpapasa ng nested konfig na instansiya)