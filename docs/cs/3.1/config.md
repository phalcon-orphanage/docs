<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Čtení konfigurace</a> <ul>
        <li>
          <a href="#native-arrays">Nativní pole (Array)</a>
        </li>
        <li>
          <a href="#file-adapter">Adaptéry pro soubory</a>
        </li>
        <li>
          <a href="#ini-files">Čtení INI souborů</a>
        </li>
        <li>
          <a href="#merging">Slučování konfigurace</a>
        </li>
        <li>
          <a href="#nested-configuration">Vnořené konfigurace</a>
        </li>
        <li>
          <a href="#injecting-into-di">Konfigurace jako služba</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Reading Configurations

Komponenta `Phalcon\Config` se používá pro konvertování různých formátů konfiguračních souborů (s použitím adaptérů) do PHP objektů pro pouřití v aplikaci.

<a name='native-arrays'></a>

## Native Arrays

Na prvnímpříkladu si ukážeme jak zkonvertovat klasické Php pole do `Phalcon\Config` objektů. Tato možnost nabízí nejlepší výkon protože nenačítá žádné soubory v průběhu požadavku.

```php
<?php

use Phalcon\Config;

$settings = [
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'scott',
        'password' => 'cheetah',
        'dbname'   => 'test_db'
    ],
     'app' => [
        'controllersDir' => '../app/controllers/',
        'modelsDir'      => '../app/models/',
        'viewsDir'       => '../app/views/'
    ],
    'mysetting' => 'the-value'
];

$config = new Config($settings);

echo $config->app->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->mysetting, "\n";
```

Pro lepší organizaci můžete konfigurační pole uložit do jiného souboru a poté ho načíst.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## File Adapters

Dostupné adaptéry jsou:

| Třída                            | Description                                                                                             |
| -------------------------------- | ------------------------------------------------------------------------------------------------------- |
| `Phalcon\Config\Adapter\Ini`  | Použivá INI soubory jako úložiště nastavení. Tento adaptér interně využívá PHP funkci `parse_ini_file`. |
| `Phalcon\Config\Adapter\Json` | Používá JSON soubory jako úložiště nastavení.                                                           |
| `Phalcon\Config\Adapter\Php`  | Používá vícerozměrné PHP pole jako úložiště nastavení. Tento adaptér nabízí nejlepší výkon.             |
| `Phalcon\Config\Adapter\Yaml` | Používá YAML soubory jako úložiště nastavení.                                                           |

<a name='ini-files'></a>

## Reading INI Files

Ini soubory jsou běžný způsob pro ulkádání konfiguračních hodnot. `Phalcon\Config` používá optimalizovanou PHP funkci `parse_ini_file` pro čtení těchto souborů. Sekce v Ini souborech (uzavřené do hranatých závorek) jsou parsovány jako vnořený objekt pro snadný přístup.

```ini
[database]
adapter  = Mysql
host     = localhost
username = scott
password = cheetah
dbname   = test_db

[phalcon]
controllersDir = '../app/controllers/'
modelsDir      = '../app/models/'
viewsDir       = '../app/views/'

[models]
metadata.adapter  = 'Memory'
```

Naní můžete tentou soubor přečíst takto:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## Merging Configurations

`Phalcon\Config` umožňuje rekurzivní slučování atributů a hodnot z jednoho konfiguračního objektu do jiného. Nové atributy jsou přidány a existující jsou aktualizovány.

```php
<?php

use Phalcon\Config;

$config = new Config(
    [
        'database' => [
            'host'   => 'localhost',
            'dbname' => 'test_db',
        ],
        'debug' => 1,
    ]
);

$config2 = new Config(
    [
        'database' => [
            'dbname'   => 'production_db',
            'username' => 'scott',
            'password' => 'secret',
        ],
        'logging' => 1,
    ]
);

$config->merge($config2);

print_r($config);
```

Výše uvedený kód vypíše toto:

```bash
Phalcon\Config Object
(
    [database] => Phalcon\Config Object
        (
            [host] => localhost
            [dbname]   => production_db
            [username] => scott
            [password] => secret
        )
    [debug] => 1
    [logging] => 1
)
```

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)

<a name='nested-configuration'></a>

## Nested Configuration

Pro přístup k vnořeným nastavením můžete také použít metodu `Phalcon\Config::path`. Tato metoda dovoluje získat vnořené konfigurace bez očetřování zda li některé části cesty chybí. Podívejte se na příklad:

```php
<?php

use Phalcon\Config;

$config = new Config(
   [
        'phalcon' => [
            'baseuri' => '/phalcon/'
        ],
        'models' => [
            'metadata' => 'memory'
        ],
        'database' => [
            'adapter'  => 'mysql',
            'host'     => 'localhost',
            'username' => 'user',
            'password' => 'passwd',
            'name'     => 'demo'
        ],
        'test' => [
            'parent' => [
                'property' => 1,
                'property2' => 'yeah'
            ],
        ],
   ]
);

// Použiji tečku jako oddělovač
$config->path('test.parent.property2');    // yeah
$config->path('database.host', null, '.'); // localhost

$config->path('test.parent'); // Phalcon\Config

// Použiji lomítko jako oddělovač
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

<a name='injecting-into-di'></a>

## Injecting Configuration Dependency

V controllerech se může konfigurace použít jako služba. Aby tak mohlo být, přidejte následující kód k definici Di kontejneru.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// Vytvoření DI kontejneru
$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

Nyní ve svém controlleru můžete přistoupit ke konfiguraci za použití Di funkcionality použitím názvu `config` jako následující kód:

```php
<?php

use Phalcon\Mvc\Controller;

class MyController extends Controller
{
    private function getDatabaseName()
    {
        return $this->config->database->dbname;
    }
}
```