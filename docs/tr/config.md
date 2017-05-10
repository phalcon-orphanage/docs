<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Yapılandırmaları Okuma</a> <ul>
        <li>
          <a href="#native-arrays">Doğal Diziler</a>
        </li>
        <li>
          <a href="#file-adapter">Dosya Bağdaştırıcıları</a>
        </li>
        <li>
          <a href="#ini-files">INI Dosyaları Okuma</a>
        </li>
        <li>
          <a href="#merging">Yapılandırmaları Birleştirme</a>
        </li>
        <li>
          <a href="#injecting-into-di">Yapılandırma Bağımlılığını Enjekte Etme</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Yapılandırmaları Okuma

`Phalcon\Config`, bir uygulamada kullanmak üzere çeşitli biçimlerdeki yapılandırma dosyalarını (bağdaştırıcıları kullanarak) PHP nesnelerine dönüştürmek için kullanılan bir bileşendir.

<a name='native-arrays'></a>

## Doğal Diziler

Birinci örnek, doğal dizileri `Phalcon\Config` nesnelerine dönüştürmeyi gösterir. Bu seçenek, bu istek sırasında herhangi bir dosya okunmadığından en iyi performansı sunar.

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

Projenizi daha iyi organize etmek istiyorsanız, diziyi başka bir dosyaya kaydedebilir ve sonra okuyabilirsiniz.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## Dosya Bağdaştırıcıları

Mevcut bağdaştırıcılar şunlardır:

| Sınıf                            | Açıklama                                                                                                                |
| -------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Config\Adapter\Ini`  | INI dosyalarını ayarları depolamak için kullanır. Dahili olarak, adaptör PHP işlevi `parse_ini_file`'yi kullanmaktadır. |
| `Phalcon\Config\Adapter\Json` | Ayarları saklamak için JSON dosyalarını kullanır.                                                                       |
| `Phalcon\Config\Adapter\Php`  | Ayarları depolamak için PHP çok boyutlu dizileri kullanır. Bu adaptör en iyi performansı sunar.                         |
| `Phalcon\Config\Adapter\Yaml` | Ayarları saklamak için YAML dosyalarını kullanır.                                                                       |

<a name='ini-files'></a>

## INI Dosyaları Okuma

Ini dosyaları ayarları depolamanın yaygın bir yoludur. `Phalcon\Config`, bu dosyaları okumak için optimize edilmiş PHP işlevi `parse_ini_file` kullanır. Dosya bölümleri, kolay erişim için alt ayarlara ayrıştırılır.

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

Dosyayı aşağıdaki gibi okuyabilirsiniz:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## Yapılandırmaları Birleştirme

`Phalcon\Config`, bir yapılandırma nesnesinin özelliklerini tekrar tekrar birleştirir. Yeni özellikler eklendi ve mevcut özellikler güncellendi.

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

Yukarıdaki kod aşağıdakileri üretir:

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

[Phalcon Incubator](https://github.com/phalcon/incubator) bileşeninde bunlar için daha fazla bağdaştırıcı bulunmaktadır

<a name='injecting-into-di'></a>

## Yapılandırma Bağımlılığını Enjekte Etme

`Phalcon\Mvc\Controller` içinde `Phalcon\Config`'i kullanmamıza izin veren denetleyiciye yapılandırma bağımlılığı enjekte edebilirsiniz. Bunu yapabilmek için, bağımlılık enjektör komut dosyanızın içine aşağıdaki kodu ekleyin.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// DI Oluştur
$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

Şimdi denetleyicinizde aşağıdaki kod gibi `config` adını kullanarak bağımlılık enjeksiyonu özelliğini kullanarak yapılandırmanıza erişebilirsiniz:

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