# Class **Phalcon\\Cache\\Backend\\Factory**

*extends* abstract class [Phalcon\Factory](/en/3.2/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/en/3.2/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/factory.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

次の例では、'adapter'オプションを使用してBackend Cache Adapterクラスをロードし、フロントエンドが配列として提供される場合は、Frontend Cache Factoryが呼ばれます。

```php
<?php

use Phalcon\Cache\Backend\Factory;
use Phalcon\Cache\Frontend\Data;

$options = [
    "prefix"   => "app-data",
    "frontend" => new Data(),
    "adapter"  => "apc",
];
$backendCache = Factory::load($options);

```

## メソッド

public static **load** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...