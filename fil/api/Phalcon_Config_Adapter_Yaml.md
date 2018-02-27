# Klase ng **Phalcon\\Config\\Adapter\\Yaml**

*extends* klase [Phalcon\Config](/en/3.2/api/Phalcon_Config)

*implements* [Countable](http://php.net/manual/en/class.countable.php), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config/adapter/yaml.zep" class="btn btn-default btn-sm">Pinagkukunan sa GitHub</a>

Nagbabasa ng mga file na YAML at kino-konvert ang mga ito sa Phalcon\\Config na mga bagay.

Ibinigay ang sumusunod na kompigurasyon na file:

```php
<?php

phalcon:
  baseuri:        /phalcon/
  controllersDir: !approot  /app/controllers/
models:
  metadata: memorya

```

Maaari mo itong basahin bilang mga sumusunod:

```php
<?php

define(
    "APPROOT",
    dirname(__DIR__)
);

$config = new \Phalcon\Config\Adapter\Yaml(
    "path/config.yaml",
    [
        "!approot" => function($value) {
            return APPROOT . $value;
        },
    ]
);

echo $config->phalcon->controllersDir;
echo $config->phalcon->baseuri;
echo $config->models->metadata;

```

## Mga Konstant

*string* **DEFAULT_PATH_DELIMITER**

## Mga Paraan

pampublikong **__construct** (*mixed* $filePath, [*array* $callbacks])

Phalcon\\Config\\Adapter\\Yaml na konstruktor

pampublikong **offsetExists** (*mixed* $index) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Nagpapahintulot na suriin kung ang isang katangian ay tinukoy gamit ang array-syntax

```php
<?php

var_dump(
    isset($config["database"])
);

```

pampublikong **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Ibinabalik ang isang halaga mula sa kasalukuyang konfig gamit ang daanan ng pinaghihiwalay na tuldok.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

pampublikong **get** (*mixed* $index, [*mixed* $defaultValue]) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Nakakakuha ng isang katangian mula sa kompigurasyon, kung ang attribute ay hindi tinukoy na ibinabalik na null Kung ang halaga ay eksaktong null o hindi natukoy ang default na halaga ay gagamitin sa halip

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

pampublikong **offsetGet** (*mixed* $index) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Kumukuha ng isang katangian na gumagamit ng array-syntax

```php
<?php

print_r(
    $config["database"]
);

```

pampublikong **offsetSet** (*mixed* $index, *mixed* $value) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Nagtatakda ng isang katangian na gumagamit ng array-syntax

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

pampublikong **offsetUnset** (*mixed* $index) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Hindi tinatakda ang isang katangian na gumagamit ng array-syntax

```php
<?php

unset($config["database"]);

```

pampublikong **merge** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) $config) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Pinagsama ang pagsasaayos sa kasalukuyan

```php
<?php

$appConfig = new \Phalcon\Config(
    [
        "database" => [
            "host" => "localhost",
        ],
    ]
);

$globalConfig->merge($appConfig);

```

pampublikong **toArray** () na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Kino-konvert ng paulit-ulit ang object sa isang array

```php
<?php

print_r(
    $config->toArray()
);

```

pampublikong **count** () na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

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

pampublikong statik **__set_state** (*array* $data) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Ibinabalik ang estado ng isang Phalcon\\Konfig na bagay

pampublikong statik **setPathDelimiter** ([*mixed* $delimiter]) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Itinatakda ang default na delimiter ng pagdaraanan

pampublikong statik **getPathDelimiter** () na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Nagkukuha ng default na delimiter ng pagdaraanan

huling protektado *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) na nakuha mula sa [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Pamamaraan ng Helper para sa mga konfig na pagsasamahin (pagpapasa ng nested konfig na instansiya)