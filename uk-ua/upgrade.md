---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Інструкція з оновлення'
keywords: 'оновлення, v3, v4'
---

# Інструкція з оновлення

* * *

# Оновлення до V4

Отже, ви вирішили оновитись до v4! **Вітаємо**!!

Phalcon v4 містить багато змін у компонентах, в тому числі зміни інтерфейсів, суворих типів, видалення компонентів і додавання нових. Цей документ покликаний допомогти вам оновити наявний продукт, розроблений на базі Phalcon, до v4. Ми виділимо ті аспекти, на які Вам слід звернути увагу і внести необхідні зміни до вашого коду, аби він продовжив працювати так само легко і швидко, як у версії 3. Хоч і зміни значні, та це скоріше методичне завдання, ніж невідкладне.

## Вимоги

### PHP 7.2

Phalcon v4 підтримує тільки PHP 7.2 або вище. PHP 7.1 випущено понад 2 роки тому і [активна підтримка](https://secure.php.net/supported-versions.php) цієї версії уже припинена, тому ми вирішили працювати лише з версіями PHP, що активно підтримуються.

<a name='psr'></a>

### PSR

Phalcon потребує PSR-розширення. Його можна завантажити і скомпілювати з [цього](https://github.com/jbboehr/php-psr) GitHub репозиторію. Інструкції з встановлення викладені у файлі `README` цього репозиторію. Після компіляції цього розширення у вашій системі його слід додати до `php.ini`. Ви маєте додати цей рядок:

```ini
extension=psr.so
```

перед

```ini
extension=phalcon.so
```

Деякі дистрибутиви додають числовий префікс до `ini` файлів для управління черговістю завантаження розширень. Якщо це має місце у вашій системі, вкажіть вище число для Phalcon (наприклад, `50-phalcon.ini`).

### Встановлення

Завантажте останню версію `zephir.phar` [звідси](https://github.com/phalcon/zephir/releases). Додайте її в теку, до якої буде мати доступ ваша система.

Скопіюйте репозиторій

```bash
git clone https://github.com/phalcon/cphalcon
```

Скомпілюйте Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Перевірте модуль

```bash
php -m | grep phalcon
```

* * *

## Загальні нотатки

### Обробники

- `Phalcon\Mvc\Application`, `Phalcon\Mvc\Micro` та `Phalcon\Mvc\Router` тепер потребують URI для опрацювання запитів

### Винятки

- Змінено виловлювач помилок `Exception` на `Throwable`

* * *

# Компоненти

## ACL

> Статус: **необхідні зміни**
> 
> Використання: [Документація ACL](acl)
{: .alert .alert-info }

У компоненті [ACL](acl) були перейменовані деякі методи та компоненти. Функціонал залишається таким самим, як у попередніх версіях.

### Огляд

Компоненти, необхідні для роботи ACL перейменовано. Зокрема, `Resource` було перейменовано на `Component` у всіх відповідних інтерфейсах, класах і методах, які використовує цей компонент.

- Додано `Phalcon\Acl\Adapter\AbstractAdapter`
- Додано `Acl\Enum`

- Видалено `Phalcon\Acl`

- Видалено `Phalcon\Acl\Adapter`

- Перейменовано `Phalcon\Acl\Resource` на `Phalcon\Acl\Component`

- Перейменовано `Phalcon\Acl\ResourceInterface` на `Phalcon\Acl\ComponentInterface`
- Перейменовано `Phalcon\Acl\ResourceAware` на `Phalcon\Acl\ComponentAware`
- Перейменовано `Phalcon\Acl\AdapterInterface::isResource` на `Phalcon\Acl\AdapterInterface::isComponent`
- Перейменовано `Phalcon\Acl\AdapterInterface::addResource` на `Phalcon\Acl\AdapterInterface:addComponent`
- Перейменовано `Phalcon\Acl\AdapterInterface::addResourceAccess` на `Phalcon\Acl\AdapterInterface:addComponentAccess`
- Перейменовано `Phalcon\Acl\AdapterInterface::dropResourceAccess` на `Phalcon\Acl\AdapterInterface::ComponentAccess`
- Перейменовано `Phalcon\Acl\AdapterInterface::getActiveResource` на `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Перейменовано `Phalcon\Acl\AdapterInterface::getResources` на `Phalcon\Acl\AdapterInterface:getComponents`
- Перейменовано `Phalcon\Acl\Adapter::getActiveResource` на `Phalcon\Acl\AdapterInterface::getActiveComponent`
- Перейменовано `Phalcon\Acl\Adapter\Memory::isResource` на `Phalcon\Acl\Adapter\Memory::isComponent`
- Перейменовано `Phalcon\Acl\Adapter\Memory::addResource` на `Phalcon\Acl\Adapter\Memory:addComponent`
- Перейменовано `Phalcon\Acl\Adapter\Memory::addResourceAccess` на `Phalcon\Acl\Adapter\Memory::addComponentAccess`
- Перейменовано `Phalcon\Acl\Adapter\Memory::dropResourceAccess` на `Phalcon\Acl\Adapter\Memory::dropComponentAccess`
- Перейменовано `Phalcon\Acl\Adapter\Memory::getResources` на `Phalcon\Acl\Adapter\Memory:getComponents`

### Acl\Adapter\Memory

- Додано `getActiveKey`, `activeFunctionCustomArgumentsCount` і `getActiveFunction` щоб отримати останній ключ, кількість користувацьких аргументів, і функцію, яка використовується для отримання доступу
- Added `addOpertion` support multiple inherited

### Acl\Enum (Константи)

Приклад:

```php
use Phalcon\Acl\Enum;

echo Enum::ALLOW; //виводить 1
echo Enum::DENY;  //виводить 0

```

* * *

## Assets

> Статус: **необхідні зміни**
> 
> Використання: [Документація з Assets](assets)
{: .alert .alert-info }

CSS і JS фільтри було видалено з [Assets](assets). У зв'язку з обмеженнями ліцензій, мінімізатори CSS та JS (фільтри) були видалені з v4. У майбутніх версіях за підтримки спільноти ми можемо ввести ці фільтри знову. Ви завжди можете реалізувати власні фільтри, використовуючи можливості `Phalcon\Assets\FilterInterface`.

- Видалено `Phalcon\Assets\Filters\CssMin`
- Видалено `Phalcon\Assets\Filters\JsMin`
- Перейменовано `Phalcon\Assets\Resource` на `Phalcon\Assets\Asset`
- Перейменовано `Phalcon\Assets\ResourceInterface` на `Phalcon\Assets\AssetInterface`
- Перейменовано `Phalcon\Assets\Manager::addResource` на `Phalcon\Assets\Manager::addAsset`
- Перейменовано `Phalcon\Assets\Manager::addResourceByType` на `Phalcon\Assets\Manager::addAssetByType`
- Перейменовано `Phalcon\Assets\Manager::collectionResourcesByType` на `Phalcon\Assets\Manager::collectionAssetsByType`

* * *

## Cache

> Статус: **необхідні зміни**
> 
> Використання: [Документація кешу](cache)
{: .alert .alert-info }

`xcache`, `apc` та `memcache` адаптери застаріли та видалені. Перші два не підтримуються у PHP 7.2+. `apc` замінено на `apcu`, а `memcache` може бути замінений на `libmemcached`.

- Видалено `Phalcon\Annotations\Adapter\Apc`
- Видалено `Phalcon\Annotations\Adapter\Xcache`
- Видалено `Phalcon\Cache\Backend\Apc`
- Видалено `Phalcon\Cache\Backend\Memcache`
- Видалено `Phalcon\Cache\Backend\Xcache`
- Видалено `Phalcon\Mvc\Model\Metadata\Apc`
- Видалено `Phalcon\Mvc\Model\Metadata\Memcache`
- Видалено `Phalcon\Mvc\Model\Metadata\Xcache`

Компонент `Cache` перезаписано, щоб він відповідав [PSR-16](https://www.php-fig.org/psr/psr-16/). Це дозволяє вам використовувати [Phalcon\Cache](api/Phalcon_Cache) до будь-якого застосунку, який використовує кеш [PSR-16](https://www.php-fig.org/psr/psr-16/), а не лише кеш Phalcon.

У v3, кеш було розділено на два компонента: фронтенд та бекенд. Це створило трохи плутанини, але воно було функціональним. Для того, щоб створити кеш компонент, спочатку потрібно було створити Frontend і потім вставити його у відповідний Backend (який також діяв як адаптер).

Для v4 ми повністю переписали компонент. Вперше ми створили клас `Storage`, що є основою класів кешу. Ми створили класи серіалізатора, єдиною відповідальністю яких є серіалізація та несеріалізація даних, перш ніж вони збережуться у кеш-адаптері та після їх витягування з кешу. Ці класи вставляються (за бажанням розробника) до об'єкта Adapter, який з'єднується з бекендом (`Memcached`, `Redis` і т. д.), не маючи спільного адаптера інтерфейсу.

Клас кешу реалізує [PSR-16](https://www.php-fig.org/psr/psr-16/) і приймає адаптер у своєму конструкторі, який у свою чергу виконує всі важкі завдання під'єднання до бекенду і маніпулювання даними.

Для більш детального пояснення як працює новий компонент кешу, будь ласка, перегляньте відповідну сторінку в нашій документації.

### Створення кешу

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\Serializer\SerializerFactory;

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory($serializerFactory);

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200
];

$adapter = $adapterFactory->newInstance('apcu', $options);

$cache = new Cache($adapter);
```

Реєстрація його у DI

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\Serializer\SerializerFactory;

$container = new Di();

$container->set(
    'cache',
    function () {
        $options = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200
        ];

        $adapter = (new AdapterFactory(new SerializerFactory()))
                    ->newInstance('apcu', $options); 

        return new Cache($adapter);
    }
);
```

* * *

## CLI

> Статус: **необхідні зміни**
> 
> Використання: [Документація CLI](cli)
{: .alert .alert-info }

### Параметри

Параметри тепер поводяться так само, як MVC контролери. Тоді як раніше вони існували у властивості `$params`, тепер ви можете назвати їх належним чином:

```php
use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function testAction(string $yourName, string $myName)
    {
        echo sprintf(
            'Hello %s!' . PHP_EOL,
            $yourName
        );

        echo sprintf(
            'Best regards, %s' . PHP_EOL,
            $myName
        );
    }
}
```

### Cli\Console

- Видалено `Phalcon\Cli\Console:addModules` на користь `Phalcon\Cli\Console:registerModules`

### Cli\Router\RouteInterface

- Додано `delimiter`, `getDelimiter`

### Cli\Dispatcher

- Додано `getTaskSuffix()`, `setSuffix()`

### Cli\DispatcherInterface

- Додано `setOptions`, `getOptions`

* * *

## Container

- Додано `Phalcon\Container`, проміжний клас контейнерів для `Phalcon\DI`, що реалізує PSR-11

* * *

## Debug

- Видалено `Phalcon\Debug::getMajorVersion`

* * *

## Db

- Доданий глобальний параметр налаштувань `orm.case_insensitive_column_map` для спроби знайти значення у мапі колонок не чутливих до регістру. Може бути також увімкнено через встановлення параметра `caseInsensitiveColumnMap` у `\Phalcon\Mvc\Model::setup()`
- Видалено простір імен `Phalcon\Db`. Замінено на `Phalcon\Db\AbstractDb` для необхідних методів і на `Phalcon\Db\Enum` для констант, наприклад:

```php
use Phalcon\Db\Enum;

echo Enum::FETCH_ASSOC;
```

### Db\AdapterInterface

- Додано `fetchColumn`, `insertAsDict`, `updateAsDict`

### Db\Adapter\Pdo

- Додано більше типів стовпців для адаптера Mysql. Підтримуються адаптери: 
    - `TYPE_BIGINTEGER`
    - `TYPE_BIT`
    - `TYPE_BLOB`
    - `TYPE_BOOLEAN`
    - `TYPE_CHAR`
    - `TYPE_DATE`
    - `TYPE_DATETIME`
    - `TYPE_DECIMAL`
    - `TYPE_DOUBLE`
    - `TYPE_ENUM`
    - `TYPE_FLOAT`
    - `TYPE_INTEGER`
    - `TYPE_JSON`
    - `TYPE_JSONB`
    - `TYPE_LONGBLOB`
    - `TYPE_LONGTEXT`
    - `TYPE_MEDIUMBLOB`
    - `TYPE_MEDIUMINTEGER`
    - `TYPE_MEDIUMTEXT`
    - `TYPE_SMALLINTEGER`
    - `TYPE_TEXT`
    - `TYPE_TIME`
    - `TYPE_TIMESTAMP`
    - `TYPE_TINYBLOB`
    - `TYPE_TINYINTEGER`
    - `TYPE_TINYTEXT`
    - `TYPE_VARCHAR` Деякі адаптери не підтримують певні типи. Наприклад, `JSON` не підтримується для `Sqlite`. Його буде автоматично змінено на `VARCHAR`.

### Db\DialectInterface

- Додано `registerCustomFunction`, `getCustomFunctions`, `getSqlExpression`

### Db\Dialect\Postgresql

- Змінено `addPrimaryKey`, щоб зробити обмеження імені первинного ключа унікальним, префіксуючи їх з назвою таблиці.

* * *

## DI

### Di\ServiceInterface

- Додано `getParameter`, `isResolved`

### Di\Service

- Змінено `Phalcon\Di\Service` конструктор, щоб він більше не переймав ім'я сервісу.

* * *

## Dispatcher

- Видалено `Phalcon\Dispatcher::setModelBinding()` на користь `Phalcon\Dispatcher::setModelBinder()`
- Додано `getHandlerSuffix()`, `setHandlerSuffix()`

* * *

## Events

### Events\ManagerInterface

- Додано `hasListeners`

* * *

## Flash

- Додано можливість встановити користувацький шаблон для Flash Messenger.
- Конструктор більше не приймає масив для класів CSS. Вам потрібно буде використовувати `setCsClasses()` щоб встановити свої користувацькі класи CSS для компонента
- Конструктор тепер приймає необов'язковий об’єкт `Phalcon\Escaper`, а також об'єкт `Phalcon\Session\Manager` (у випадку `Phalcon\Flash\Session`) на випадок, якщо ви не хочете користуватися DI і встановите його самі.

* * *

## Filter

> Статус: **необхідні зміни**
> 
> Використання: [Документація фільтра](filter)
{: .alert .alert-info }

Компонент `Filter` було перезаписано, використовуючи локатор сервісів. Кожен "знешкоджувач" (sanitizer) тепер вкладений у власний клас і завантажений в лінивому режимі, щоб забезпечити максимальну продуктивність і найменше використання ресурсів.

### Огляд

Клас `Phalcon\Filter` був переписаний, щоб виконувати роль локатора сервісу для різних *знешкоджувачів*. Цей об'єкт дозволяє вам знешкодити введені дані, як раніше використовувався метод `sanitize()`.

Знешкоджені значення автоматично перетворюються на відповідні типи. Це типова поведінка для `int`, `bool` та `float` фільтрів.

При активізації об'єкта фільтра, він не знає про жоден про знешкоджувач. У вас є два варіанти:

#### Завантажити всі знешкоджувачі за промовчанням

Ви можете завантажити всі підтримувані Phalcon знешкоджувачі, використавши компонент [Phalcon\Filter\Factory](api/Phalcon_Filter#filter-filterfactory).

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();
$locator = $factory->newInstance();
```

Виклик`newInstance()` поверне об’єкт [Phalcon\Filter](api/Phalcon_Filter#filter) з усіма зареєстрованими знешкоджувачами. Знешкоджувачі завантажені у лінивому режимі, тому вони будуть активовані лише за викликом з локатора.

#### Завантажити лише знешкоджувачі, які вам потрібні

Ви можете задіяти компонент [Phalcon\Filter](api/Phalcon_Filter#filter) або ж використати метод `set()` для встановлення всіх необхідних вам знешкоджувачів, або передати масив зі знешкоджувачами, які ви хочете зареєструвати, у масив конструктора.

### Використання `FactoryDefault`

Якщо ви використовуєте контейнер [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault), тоді [Phalcon\Filter](api/Phalcon_Filter#filter) буде завантажено у контейнер автоматично. Потім ви можете продовжувати використовувати сервіс у своїх контролерах або компонентах, як ви робили до цього. Назва цього сервісу у контейнері Di - `filter`, як і раніше.

Також компоненти, які використовують службу фільтрації, такі як об'єкт [Request](api/phalcon_http#http-request), безпосередньо використовують новий локатор фільтрів. Для цих компонентів не потрібні ніякі додаткові зміни.

### Використання власного `Di`

Якщо ви встановили всі сервіси в [Phalcon\Di](api/Phalcon_Di) самостійно і потребуєте сервіс фільтрування, тоді ви повинні змінити його реєстрацію наступним чином:

```php
<?php

use Phalcon\Di;
use Phalcon\Filter\FilterFactory;

$container = new Di();

$container->set(
    'filter',
    function () {
        $factory = new FilterFactory();
        return $factory->newInstance();
    }
);
```

> **ПРИМІТКА**: Зважайте на те, що навіть якщо ви зареєструєте сервіс фільтрування вручну, **ім'я** цього сервісу має бути **filter**, щоб інші компоненти змогли його використовувати
{: .alert .alert-warning }

### Константи

Константи, які мав `Phalcon\Filter` у v3, дещо змінилися.

#### Видалено

- `FILTER_INT_CAST` (`int!`)
- `FILTER_FLOAT_CAST` (`float!`)

За замовчуванням сервіс sanitizers передає значення відповідному типу, тому ці застарілі

- `FILTER_APHANUM` було видалено - замінено на `FILTER_ALNUM`

#### Змінено

- `FILTER_SPECAL_CHARS` було видалено - замінено на `FILTER_SPECIAL`
- `FILTER_ALNUM` - замінено `FILTER_ALPHANUM`
- `FILTER_ALPHA` - знешкоджує тільки альфа-символи
- `FILTER_BOOL` - знешкоджує лише логічні типи, включаючи "так", "ні", і т. д.
- `FILTER_LOWERFIRST` - sanitze using `lcfirst`
- `FILTER_REGEX` - sanitize based on a pattern (`preg_replace`)
- `FILTER_REMOVE` - sanitize by removing characters (`str_replace`)
- `FILTER_REPLACE` - sanitize by replacing characters (`str_replace`)
- `FILTER_SPECIAL` - replaced `FILTER_SPECIAL_CHARS`
- `FILTER_SPECIALFULL` - sanitize special chars (`filter_var`)
- `FILTER_UPPERFIRST` - sanitize using `ucfirst`
- `FILTER_UPPERWORDS` - sanitize using `ucwords`

* * *

## Форми

### Forms\Form

- `Phalcon\Forms\Form::clear` will no longer call `Phalcon\Forms\Element::clear`, instead it will clear/set default value itself, and `Phalcon\Forms\Element::clear` will now call `Phalcon\Forms\Form::clear` if it’s assigned to the form, otherwise it will just clear itself.
- `Phalcon\Forms\Form::getValue` will now also try to get the value by calling `Tag::getValue` or element’s `getDefault` method before returning `null`, and `Phalcon\Forms\Element::getValue` calls `Tag::getDefault` only if it’s not added to the form.

* * *

## Html

### Html\Breadcrumbs

- Added `Phalcon\Html\Breadcrumbs`, a component that creates HTML code for breadcrumbs.

### Html\Tag

- Added `Phalcon\Html\Tag`, a component that creates HTML elements. It will replace `Phalcon\Tag` in a future version. This component does not use static method calls.

### Http\RequestInterface

- Removed `isSecureRequest` in favor of `isSecure`
- Removed `isSoapRequested` in favor of `isSoap`

### Http\Response

- Added `hasHeader()` method to `Phalcon\Http\Response` to provide the ability to check if a header exists.
- Added `Phalcon\Http\Response\Cookies::getCookies`
- Changed `setHeaders` now merges the headers with any pre-existing ones in the internal collection
- Added two new events `response::beforeSendHeaders` and `response::afterSendHeaders`

* * *

## Зображення

- Added `Phalcon\Image\Enum`
- Renamed `Phalcon\Image\Adapter` to `Phalcon\Image\Adapter\AbstractAdapter`
- Renamed `Phalcon\Image\Factory` to `Phalcon\Image\ImageFactory`
- Removed `Phalcon\Image`

## Image\Enum (Constants)

Example:

```php
<?php

use Phalcon\Image\Enum;

// Resizing constraints
echo Enum::AUTO;    // prints 4
echo Enum::HEIGHT;  // prints  3
echo Enum::INVERSE; // prints  5
echo Enum::NONE;   // prints  1
echo Enum::PRECISE; // prints  6
echo Enum::TENSILE; // prints  7
echo Enum::WIDTH;   // prints  2

// Flipping directions
echo Enum::HORIZONTAL; // prints  11
echo Enum::VERTICAL;   // prints  12
```

* * *

## Logging

> Статус: **необхідні зміни**
> 
> Usage: [Logger Documentation](logger)
{: .alert .alert-info }

The `Logger` component has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). This allows you to use the [Phalcon\Logger](api/Phalcon_Logger) to any application that utilizes a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

In v3, the logger was incorporating the adapter in the same component. So in essence when creating a logger object, the developer was creating an adapter (file, stream etc.) with logger functionality.

For v4, we rewrote the component to implement only the logging functionality and to accept one or more adapters that would be responsible for doing the work of logging. This immediately offers compatibility with [PSR-3](https://www.php-fig.org/psr/psr-3/) and separates the responsibilities of the component. It also offers an easy way to attach more than one adapter to the logging component so that logging to multiple adapters can be achieved. By using this implementation we have reduced the code necessary for this component and removed the old `Logger\Multiple` component.

### Creating a Logger Component

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

Реєстрація його у DI

```php
<?php

use Phalcon\Di;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new Di();

$container->set(
    'logger',
    function () {
        $adapter = new Stream('/logs/application.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return $logger;
    }
);
```

### Multiple Loggers

The `Phalcon\Logger\Multiple` component has been removed. You can achieve the same functionality using the logger component and registering more than one adapter:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

* * *

## Messages

- `Phalcon\Messages\Message` and its collection `Phalcon\Messages\Messages` are new components that handle messages for models and validation. In the past we had two components, one for validation and one for models. We have merged these two, so you should be getting back a `MessageInterface[]` back when calling `save` on a model or when retrieving validation messages. 
    - Changed `Phalcon\Mvc\Model` to use the `Phalcon\Messages\Message` object for its messages
    - Changed `Phalcon\Validation\*` to use the `Phalcon\Messages\Message` object for its messages

* * *

### Transactions

Removed in version 4.0:

- Removed `$logger->begin()`
- Removed `$logger->commit()`

### Log Level

- Removed `$logger->setLogLevel()`

## Моделі

> Статус: **необхідні зміни**
> 
> Usage: [Models Documentation](db-models)
{: .alert .alert-info }

- You can no longer assign data to models while saving them

### Initialization

The `getSource()` method has been marked as `final`. As such you can no longer override this method in your model to set the corresponding table/source of the RDBMS. Instead, you can now use the `initialize()` method and `setSource()` to set the source of your model.

```php
<?php

use Phalcon\Mvc\Model;

class Users
{
    public function initialize()
    {
        $this->setSource('Users');
        // ....
    }
}
```

### Save

The `save()` method no longer accepts parameters to set data. You can use `assign` instead.

### Criteria

The second parameter of `Criteria::limit()` ('offset') must now be an integer or null. Previously there was no type requirement.

```php
$criteria->limit(10);

$criteria->limit(10, 5);

$criteria->limit(10, null);
```

* * *

## MVC

> Статус: **необхідні зміни**
> 
> Usage: [MVC Documentation](mvc)
{: .alert .alert-info }

### Mvc\Collection

- Removed `Phalcon\Mvc\Collection::validationHasFailed`
- Removed calling `Phalcon\Mvc\Collection::validate` with object of type `Phalcon\Mvc\Model\ValidatorInterface`

### Mvc\Micro\Lazyloader

- Removed `__call` in favor of `callMethod`

### Mvc\Model

- Removed `Phalcon\Model::reset`
- Added `isRelationshipLoaded` to check if relationship is loaded
- Changed `Phalcon\Model::assign` parameters order to `$data`, `$whiteList`, `$dataColumnMap`
- Changed `Phalcon\Model::findFirst` to return `null` instead of `false` if no record was found
- Changed `Phalcon\Model::getRelated()` to return `null` for one to one relationships if no record was found

### Mvc\Model\Criteria

- Removed `addWhere`
- Removed `order`
- Removed `order` in favor of `orderBy`

### Mvc\Model\CriteriaInterface

- Added `distinct`, `leftJoin`, `innerJoin`, `rightJoin`, `groupBy`, `having`, `cache`, `getColumns`, `getGroupBy`, `getHaving`

### Mvc\Model\Manager

- `Load` no longer reuses already initialized models
- Removed `Phalcon\Model\Manager::registerNamespaceAlias()`
- Removed `Phalcon\Model\Manager::getNamespaceAlias()`
- Removed `Phalcon\Model\Manager::getNamespaceAliases()`
- The signature of `Phalcon\Mvc\Model\Manager::getRelationRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getBelongsToRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getHasOneRecords()` has changed
- The signature of `Phalcon\Mvc\Model\Manager::getHasManyRecords()` has changed

### Mvc\Model\ManagerInterface

- Added `isVisibleModelProperty`, `keepSnapshots`, `isKeepingSnapshots`, `useDynamicUpdate`, `isUsingDynamicUpdate`, `addHasManyToMany`, `existsHasManyToMany`, `getRelationRecords`, `getHasManyToMany`
- Removed `Phalcon\Model\ManagerInterface::getNamespaceAlias()`
- Removed `Phalcon\Model\ManagerInterface::registerNamespaceAlias()`

### Mvc\Model\MessageInterface

- Added `setModel`, `getModel`, `setCode`, `getCode`

### Mvc\Model\QueryInterface

- Added `getSingleResult`, `setBindParams`, `getBindParams`, `setBindTypes`, `setSharedLock`, `getBindTypes`, `getSql`

### Mvc\Model\Query\BuilderInterface

- Added `offset`

### Mvc\Model\Query\Builder

- Added bind support. The Query Builder has the same methods as `Phalcon\Mvc\Model\Query`; `getBindParams`, `setBindParams`, `getBindTypes` and `setBindTypes`.
- Changed `addFrom` to remove third parameter `$with`

### Mvc\Model\Query\BuilderInterface

- Added `distinct`, `getDistinct`, `forUpdate`, `offset`, `getOffset`

### Mvc\Model\RelationInterface

- Added `getParams`

### Mvc\Model\ResultsetInterface

- Added `setHydrateMode`, `getHydrateMode`, `getMessages`, `update`, `delete`, `filter`

### Mvc\Model\Transaction\ManagerInterface

- Added `setDbService`, `getDbService`, `setRollbackPendent`, `getRollbackPendent`

### Mvc\Model\Validator*

- Removed `Phalcon\Mvc\Model\Validator\*` in favor of `Phalcon\Validation\Validator\*`

### Mvc\ModelInterface

- Added `getModelsMetaData`

### Mvc\Router

- Removed `getRewriteUri()`. The URI needs to be passed in the `handle` method of the application object.

### Mvc\RouterInterface

- Added `attach`

### Mvc\Router\RouteInterface

- Added `convert` so that calling `add` will return an instance that has `convert` method

### Mvc\Router\RouteInterface

- Added response handler to `Phalcon\Mvc\Micro`, `Phalcon\Mvc\Micro::setResponseHandler`, to allow use of a custom response handler.

### Mvc\User

- Removed `Phalcon\Mvc\User\Component` - use `Phalcon\Di\Injectable` instead
- Removed `Phalcon\Mvc\User\Module` - use `Phalcon\Di\Injectable` instead
- Removed `Phalcon\Mvc\User\Plugin` - use `Phalcon\Di\Injectable` instead

### Mvc\View\Engine\Volt

The options for Volt have changed (the key names). Using the old syntax will produce a deprecation warning. The new options are:

- `always` - Always compile
- `extension` - Extension of files
- `separator` - Separator (used for the folders/routes)
- `stat` - Stat each file before trying to use it
- `path` - The path of the files
- `prefix` - The prefix of the files

* * *

## Paginator

- `getPaginate` now becomes `paginate`
- `$before` is removed and replaced with `$previous`
- `$total_pages` is removed since it contained the same information as `$last`
- Added `Phalcon\Paginator\RepositoryInterface` for repository the current state of `paginator` and also optional sets the aliases for properties repository

## Router

- Removed `getRewriteUri()`. The URI needs to be passed in the `handle` method of the application object.
- You can add `CONNECT`, `PURGE`, `TRACE` routes to the Router Group. They function the same as they do in the normal Router:

```php
use Phalcon\Mvc\Router\Group;

$group = new Group();

$group->addConnect(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'connect',
    ]
);

$group->addPurge(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'purge',
    ]
);

$group->addTrace(
    '/api',
    [
        'controller' => 'api',
        'action'     => 'trace',
    ]
);
```

* * *

## Безпека

- Removed `hasLibreSsl`
- Removed `getSslVersionNumber`
- Added `setPadding`
- Added a retainer for the current token to be used during the checks, so when `getToken` is called the token used for checks does not change

* * *

## Запит

### Http\Request

- Added `numFiles` returning `long` - the number of files present in the request
- Changed `hasFiles` to return `bool` - if the request has files or not

### Http\RequestInterface

- Added `numFiles` returning `int` - the number of files present in the request
- Changed `hasFiles` to return `bool` - if the request has files or not

* * *

## Session

> Статус: **необхідні зміни**
> 
> Usage: [Session Documentation](session)
{: .alert .alert-info }

`Session` and `Session\Bag` no longer get loaded by default in `Phalcon\DI\FactoryDefault`. `Session` was refactored.

- Added `Phalcon\Session\Adapter\AbstractAdapter`
- Added `Phalcon\Session\Adapter\Noop`
- Added `Phalcon\Session\Adapter\Stream`
- Added `Phalcon\Session\Manager`
- Added `Phalcon\Session\ManagerInterface`
- Removed `Phalcon\Session\Adapter` - replaced by `Phalcon\Session\Adapter\AbstractAdapter`
- Removed `Phalcon\Session\AdapterInterface` - replaced by native `SessionHandlerInterface`
- Removed `Phalcon\Session\Adapter\Files` - replaced by `Phalcon\Session\Adapter\Stream`
- Removed `Phalcon\Session\Adapter\Memcache`
- Removed `Phalcon\Session\BagInterface`
- Removed `Phalcon\Session\Factory`

### Session\Adapter

Each adapter implements PHP's `SessionHandlerInterface`. Available adapters are:

- `Phalcon\Session\Adapter\AbstractAdapter`
- `Phalcon\Session\Adapter\Libmemcached`
- `Phalcon\Session\Adapter\Noop`
- `Phalcon\Session\Adapter\Redis`
- `Phalcon\Session\Adapter\Stream`

### Session\Manager

- Now is the single component that offers session manipulation by using adapters (see above). Each adapter implements PHP's `SessionHandlerInterface`
- Developers can add any adapter that implements `SessionHandlerInterface`

* * *

## Тег

- Added `renderTitle()` that renders the title enclosed in `<title>` tags.
- Changed `getTitle`. It returns only the text. It accepts `prepend`, `append` booleans to prepend or append the relevant text to the title.
- Changed `textArea` to use `htmlspecialchars` to prevent XSS injection.

* * *

## Text

> Статус: **необхідні зміни**
> 
> Usage: [Str Documentation](helpers#str)
{: .alert .alert-info }

The `Phalcon\Text` component has been removed in favor of the `Phalcon\Helper\Str`. The functionality offered by `Phalcon\Text` in v3 is replicated and enhanced in the new class: `Phalcon\Helper\Str`.

* * *

## Валідація

### Validation\Message

- Removed `Phalcon\Validation\Message` and `Phalcon\Mvc\Model\Message` in favor of `Phalcon\Messages\Message`
- Removed `Phalcon\Validation\MessageInterface` and `Phalcon\Mvc\Model\MessageInterface` in favor of `Phalcon\Messages\MessageInterface`
- Removed `Phalcon\Validation\Message\Group` in favor of `Phalcon\Messages\Messages`
- Validator messages have been moved inside each validator

### Validation\Validator

- Removed `isSetOption`

### Validation\Validator\Ip

- Added `Phalcon\Validation\Validator\Ip`, class used to validate ip address fields. It allows to validate a field selecting IPv4 or IPv6, allowing private or reserved ranges and empty values if necessary.

* * *

## Views

> Статус: **необхідні зміни**
> 
> Usage: [View Documentation](views)
{: .alert .alert-info }

View caching along with the `viewCache` service have been removed from the framework because they were incompatible with the new Cache component. Developers can easily utilize a *view cache* from external services such as Varnish, Cloudflare etc. Additionally, developers can cache fragments by either using the `Phalcon\Mvc\View\Simple::render()` or the `Phalcon\Mvc\View::toString()`. Those two methods return the produced HTML that can be cached in the cache backend of your choice.

* * *

## Гіперпосилання

> Статус: **необхідні зміни**
> 
> Usage: [Url Documentation](url)
{: .alert .alert-info }

The `Phalcon\Mvc\Url` component has been renamed to `Phalcon\Url`. The functionality remains the same.

## Cheat Sheet

### Acl

| 3.4.x                  | State      | 4.0.x                                  |
| ---------------------- | ---------- | -------------------------------------- |
| Phalcon\Acl           | Видалено   |                                        |
| Phalcon\Acl\Adapter  | Renamed to | Phalcon\Acl\Adapter\AbstractAdapter |
| Phalcon\Acl\Resource | Renamed to | Phalcon\Acl\Component                |
|                        | New        | Phalcon\Acl\Enum                     |

### Примітки

| 3.4.x                                 | State      | 4.0.x                                          |
| ------------------------------------- | ---------- | ---------------------------------------------- |
| Phalcon\Annotations\Adapter         | Renamed to | Phalcon\Annotations\Adapter\AbstractAdapter |
| Phalcon\Annotations\Adapter\Apc    | Видалено   |                                                |
| Phalcon\Annotations\Adapter\Files  | Renamed to | Phalcon\Annotations\Adapter\Stream          |
| Phalcon\Annotations\Adapter\Xcache | Видалено   |                                                |
| Phalcon\Annotations\Factory         | Renamed to | Phalcon\Annotations\AnnotationsFactory       |

### Application

| 3.4.x                | State      | 4.0.x                                     |
| -------------------- | ---------- | ----------------------------------------- |
| Phalcon\Application | Renamed to | Phalcon\Application\AbstractApplication |

### Assets

| 3.4.x                          | State      | 4.0.x                       |
| ------------------------------ | ---------- | --------------------------- |
| Phalcon\Assets\Resource      | Renamed to | Phalcon\Assets\Asset      |
| Phalcon\Assets\Resource\Css | Renamed to | Phalcon\Assets\Asset\Css |
| Phalcon\Assets\Resource\Js  | Renamed to | Phalcon\Assets\Asset\Js  |

### Cache

| 3.4.x                                 | State      | 4.0.x                                               |
| ------------------------------------- | ---------- | --------------------------------------------------- |
| Phalcon\Cache\Backend\Apc          | Видалено   |                                                     |
| Phalcon\Cache\Backend               | Renamed to | Phalcon\Cache                                      |
| Phalcon\Cache\Backend\Factory      | Renamed to | Phalcon\Cache\AdapterFactory                      |
| Phalcon\Cache\Backend\Apcu         | Renamed to | Phalcon\Cache\Adapter\Apcu                       |
| Phalcon\Cache\Backend\File         | Renamed to | Phalcon\Cache\Adapter\Stream                     |
| Phalcon\Cache\Backend\Libmemcached | Renamed to | Phalcon\Cache\Adapter\Libmemcached               |
| Phalcon\Cache\Backend\Memcache     | Видалено   |                                                     |
| Phalcon\Cache\Backend\Memory       | Renamed to | Phalcon\Cache\Adapter\Memory                     |
| Phalcon\Cache\Backend\Mongo        | Видалено   |                                                     |
| Phalcon\Cache\Backend\Redis        | Renamed to | Phalcon\Cache\Adapter\Redis                      |
|                                       | New        | Phalcon\Cache\CacheFactory                        |
| Phalcon\Cache\Backend\Xcache       | Видалено   |                                                     |
| Phalcon\Cache\Exception             | Renamed to | Phalcon\Cache\Exception\Exception                |
|                                       | New        | Phalcon\Cache\Exception\InvalidArgumentException |
| Phalcon\Cache\Frontend\Base64      | Видалено   |                                                     |
| Phalcon\Cache\Frontend\Data        | Видалено   |                                                     |
| Phalcon\Cache\Frontend\Factory     | Видалено   |                                                     |
| Phalcon\Cache\Frontend\Igbinary    | Видалено   |                                                     |
| Phalcon\Cache\Frontend\Json        | Видалено   |                                                     |
| Phalcon\Cache\Frontend\Msgpack     | Видалено   |                                                     |
| Phalcon\Cache\Frontend\None        | Видалено   |                                                     |
| Phalcon\Cache\Frontend\Output      | Видалено   |                                                     |
| Phalcon\Cache\Multiple              | Видалено   |                                                     |

### Колекція

| 3.4.x | State | 4.0.x                          |
| ----- | ----- | ------------------------------ |
|       | New   | Phalcon\Collection            |
|       | New   | Phalcon\Collection\Exception |
|       | New   | Phalcon\Collection\ReadOnly  |

### Config

| 3.4.x                    | State      | 4.0.x                          |
| ------------------------ | ---------- | ------------------------------ |
| Phalcon\Config\Factory | Renamed to | Phalcon\Config\ConfigFactory |

### Container

| 3.4.x | State | 4.0.x              |
| ----- | ----- | ------------------ |
|       | New   | Phalcon\Container |

### Db

| 3.4.x                              | State      | 4.0.x                                  |
| ---------------------------------- | ---------- | -------------------------------------- |
| Phalcon\Db                        | Renamed to | Phalcon\Db\AbstractDb                |
| Phalcon\Db\Adapter               | Renamed to | Phalcon\Db\Adapter\AbstractAdapter  |
| Phalcon\Db\Adapter\Pdo          | Renamed to | Phalcon\Db\Adapter\Pdo\AbstractPdo |
| Phalcon\Db\Adapter\Pdo\Factory | Renamed to | Phalcon\Db\Adapter\PdoFactory       |
|                                    | New        | Phalcon\Db\Enum                      |

### Диспетчер

| 3.4.x               | State      | 4.0.x                                   |
| ------------------- | ---------- | --------------------------------------- |
| Phalcon\Dispatcher | Renamed to | Phalcon\Dispatcher\AbstractDispatcher |
|                     | New        | Phalcon\Dispatcher\Exception          |

### Di

| 3.4.x | State | 4.0.x                                              |
| ----- | ----- | -------------------------------------------------- |
|       | New   | Phalcon\Di\AbstractInjectionAware                |
|       | New   | Phalcon\Di\Exception\ServiceResolutionException |

### Domain

| 3.4.x | State | 4.0.x                                    |
| ----- | ----- | ---------------------------------------- |
|       | New   | Phalcon\Domain\Payload\Payload        |
|       | New   | Phalcon\Domain\Payload\PayloadFactory |
|       | New   | Phalcon\Domain\Payload\Status         |

### Factory

| 3.4.x            | State      | 4.0.x                             |
| ---------------- | ---------- | --------------------------------- |
| Phalcon\Factory | Renamed to | Phalcon\Factory\AbstractFactory |

### Filter

| 3.4.x | State | 4.0.x                                  |
| ----- | ----- | -------------------------------------- |
|       | New   | Phalcon\Filter\FilterFactory         |
|       | New   | Phalcon\Filter\Sanitize\AbsInt      |
|       | New   | Phalcon\Filter\Sanitize\Alnum       |
|       | New   | Phalcon\Filter\Sanitize\Alpha       |
|       | New   | Phalcon\Filter\Sanitize\BoolVal     |
|       | New   | Phalcon\Filter\Sanitize\Email       |
|       | New   | Phalcon\Filter\Sanitize\FloatVal    |
|       | New   | Phalcon\Filter\Sanitize\IntVal      |
|       | New   | Phalcon\Filter\Sanitize\Lower       |
|       | New   | Phalcon\Filter\Sanitize\LowerFirst  |
|       | New   | Phalcon\Filter\Sanitize\Regex       |
|       | New   | Phalcon\Filter\Sanitize\Remove      |
|       | New   | Phalcon\Filter\Sanitize\Replace     |
|       | New   | Phalcon\Filter\Sanitize\Special     |
|       | New   | Phalcon\Filter\Sanitize\SpecialFull |
|       | New   | Phalcon\Filter\Sanitize\StringVal   |
|       | New   | Phalcon\Filter\Sanitize\Striptags   |
|       | New   | Phalcon\Filter\Sanitize\Trim        |
|       | New   | Phalcon\Filter\Sanitize\Upper       |
|       | New   | Phalcon\Filter\Sanitize\UpperFirst  |
|       | New   | Phalcon\Filter\Sanitize\UpperWords  |
|       | New   | Phalcon\Filter\Sanitize\Url         |

### Flash

| 3.4.x          | State      | 4.0.x                         |
| -------------- | ---------- | ----------------------------- |
| Phalcon\Flash | Renamed to | Phalcon\Flash\AbstractFlash |

### Форми

| 3.4.x                   | State      | 4.0.x                                    |
| ----------------------- | ---------- | ---------------------------------------- |
| Phalcon\Forms\Element | Renamed to | Phalcon\Forms\Element\AbstractElement |

### Helper

| 3.4.x | State | 4.0.x                      |
| ----- | ----- | -------------------------- |
|       | New   | Phalcon\Helper\Arr       |
|       | New   | Phalcon\Helper\Exception |
|       | New   | Phalcon\Helper\Fs        |
|       | New   | Phalcon\Helper\Json      |
|       | New   | Phalcon\Helper\Number    |
|       | New   | Phalcon\Helper\Str       |

### Html

| 3.4.x | State | 4.0.x                                      |
| ----- | ----- | ------------------------------------------ |
|       | New   | Phalcon\Html\Attributes                  |
|       | New   | Phalcon\Html\Breadcrumbs                 |
|       | New   | Phalcon\Html\Exception                   |
|       | New   | Phalcon\Html\Helper\AbstractHelper      |
|       | New   | Phalcon\Html\Helper\Anchor              |
|       | New   | Phalcon\Html\Helper\AnchorRaw           |
|       | New   | Phalcon\Html\Helper\Body                |
|       | New   | Phalcon\Html\Helper\Button              |
|       | New   | Phalcon\Html\Helper\Close               |
|       | New   | Phalcon\Html\Helper\Element             |
|       | New   | Phalcon\Html\Helper\ElementRaw          |
|       | New   | Phalcon\Html\Helper\Form                |
|       | New   | Phalcon\Html\Helper\Img                 |
|       | New   | Phalcon\Html\Helper\Label               |
|       | New   | Phalcon\Html\Helper\TextArea            |
|       | New   | Phalcon\Html\Link\EvolvableLink         |
|       | New   | Phalcon\Html\Link\EvolvableLinkProvider |
|       | New   | Phalcon\Html\Link\Link                  |
|       | New   | Phalcon\Html\Link\LinkProvider          |
|       | New   | Phalcon\Html\Link\Serializer\Header    |
|       | New   | Phalcon\Html\TagFactory                  |

### Http

| 3.4.x | State | 4.0.x                                                       |
| ----- | ----- | ----------------------------------------------------------- |
|       | New   | Phalcon\Http\Message\AbstractCommon                      |
|       | New   | Phalcon\Http\Message\AbstractMessage                     |
|       | New   | Phalcon\Http\Message\AbstractRequest                     |
|       | New   | Phalcon\Http\Message\Exception\InvalidArgumentException |
|       | New   | Phalcon\Http\Message\Request                             |
|       | New   | Phalcon\Http\Message\RequestFactory                      |
|       | New   | Phalcon\Http\Message\Response                            |
|       | New   | Phalcon\Http\Message\ResponseFactory                     |
|       | New   | Phalcon\Http\Message\ServerRequest                       |
|       | New   | Phalcon\Http\Message\ServerRequestFactory                |
|       | New   | Phalcon\Http\Message\Stream                              |
|       | New   | Phalcon\Http\Message\StreamFactory                       |
|       | New   | Phalcon\Http\Message\Stream\Input                       |
|       | New   | Phalcon\Http\Message\Stream\Memory                      |
|       | New   | Phalcon\Http\Message\Stream\Temp                        |
|       | New   | Phalcon\Http\Message\UploadedFile                        |
|       | New   | Phalcon\Http\Message\UploadedFileFactory                 |
|       | New   | Phalcon\Http\Message\Uri                                 |
|       | New   | Phalcon\Http\Message\UriFactory                          |
|       | New   | Phalcon\Http\Server\AbstractMiddleware                   |
|       | New   | Phalcon\Http\Server\AbstractRequestHandler               |

### Зображення

| 3.4.x                   | State      | 4.0.x                                    |
| ----------------------- | ---------- | ---------------------------------------- |
| Phalcon\Image          | Видалено   |                                          |
| Phalcon\Image\Adapter | Renamed to | Phalcon\Image\Adapter\AbstractAdapter |
|                         | New        | Phalcon\Image\Enum                     |
| Phalcon\Image\Factory | Renamed to | Phalcon\Image\ImageFactory             |

### Logging

| 3.4.x                               | State      | 4.0.x                                         |
| ----------------------------------- | ---------- | --------------------------------------------- |
|                                     | New        | Phalcon\Logger\AdapterFactory               |
| Phalcon\Logger\Adapter            | Renamed to | Phalcon\Logger\Adapter\AbstractAdapter     |
| Phalcon\Logger\Adapter\Blackhole | Renamed to | Phalcon\Logger\Adapter\Noop                |
| Phalcon\Logger\Adapter\File      | Renamed to | Phalcon\Logger\Adapter\Stream              |
| Phalcon\Logger\Adapter\Firephp   | Видалено   |                                               |
| Phalcon\Logger\Factory            | Renamed to | Phalcon\Logger\LoggerFactory                |
| Phalcon\Logger\Formatter          | Renamed to | Phalcon\Logger\Formatter\AbstractFormatter |
| Phalcon\Logger\Formatter\Firephp | Видалено   |                                               |
| Phalcon\Logger\Formatter\Syslog  | Видалено   |                                               |
| Phalcon\Logger\Multiple           | Видалено   |                                               |

### Message (new in V4, Formerly Phalcon\Validation\Message in 3.4)

| 3.4.x | State | 4.0.x                        |
| ----- | ----- | ---------------------------- |
|       | New   | Phalcon\Messages\Exception |
|       | New   | Phalcon\Messages\Message   |
|       | New   | Phalcon\Messages\Messages  |

### Mvc

| 3.4.x                                             | State      | 4.0.x                                        |
| ------------------------------------------------- | ---------- | -------------------------------------------- |
| Phalcon\Mvc\Collection                          | Renamed to | Phalcon\Collection                          |
| Phalcon\Mvc\Collection\Behavior                | Видалено   |                                              |
| Phalcon\Mvc\Collection\Behavior\SoftDelete    | Видалено   |                                              |
| Phalcon\Mvc\Collection\Behavior\Timestampable | Видалено   |                                              |
| Phalcon\Mvc\Collection\Document                | Видалено   |                                              |
| Phalcon\Mvc\Collection\Exception               | Renamed to | Phalcon\Collection\Exception               |
| Phalcon\Mvc\Collection\Manager                 | Видалено   |                                              |
|                                                   | New        | Phalcon\Collection\ReadOnly                |
| Phalcon\Mvc\Model\Message                      | Renamed to | Phalcon\Messages\Message                   |
| Phalcon\Mvc\Model\MetaData\Apc                | Видалено   |                                              |
| Phalcon\Mvc\Model\MetaData\Files              | Renamed to | Phalcon\Mvc\Model\MetaData\Stream        |
| Phalcon\Mvc\Model\MetaData\Memcache           | Видалено   |                                              |
| Phalcon\Mvc\Model\MetaData\Session            | Видалено   |                                              |
| Phalcon\Mvc\Model\MetaData\Xcache             | Видалено   |                                              |
| Phalcon\Mvc\Model\Validator                    | Renamed to | Phalcon\Validation\Validator               |
| Phalcon\Mvc\Model\Validator\Email             | Renamed to | Phalcon\Validation\Validator\Email        |
| Phalcon\Mvc\Model\Validator\Exclusionin       | Renamed to | Phalcon\Validation\Validator\ExclusionIn  |
| Phalcon\Mvc\Model\Validator\Inclusionin       | Renamed to | Phalcon\Validation\Validator\InclusionIn  |
| Phalcon\Mvc\Model\Validator\Ip                | Renamed to | Phalcon\Validation\Validator\Ip           |
| Phalcon\Mvc\Model\Validator\Numericality      | Renamed to | Phalcon\Validation\Validator\Numericality |
| Phalcon\Mvc\Model\Validator\PresenceOf        | Renamed to | Phalcon\Validation\Validator\PresenceOf   |
| Phalcon\Mvc\Model\Validator\Regex             | Renamed to | Phalcon\Validation\Validator\Regex        |
| Phalcon\Mvc\Model\Validator\StringLength      | Renamed to | Phalcon\Validation\Validator\StringLength |
| Phalcon\Mvc\Model\Validator\Uniqueness        | Renamed to | Phalcon\Validation\Validator\Uniqueness   |
| Phalcon\Mvc\Model\Validator\Url               | Renamed to | Phalcon\Validation\Validator\Url          |
| Phalcon\Mvc\Url                                 | Renamed to | Phalcon\Url                                 |
| Phalcon\Mvc\Url\Exception                      | Renamed to | Phalcon\Url\Exception                      |
| Phalcon\Mvc\User\Component                     | Renamed to | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\User\Module                        | Renamed to | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\User\Plugin                        | Renamed to | Phalcon\Di\Injectable                      |
| Phalcon\Mvc\View\Engine                        | Renamed to | Phalcon\Mvc\View\Engine\AbstractEngine   |

### Paginator

| 3.4.x                       | State      | 4.0.x                                        |
| --------------------------- | ---------- | -------------------------------------------- |
| Phalcon\Paginator\Adapter | Renamed to | Phalcon\Paginator\Adapter\AbstractAdapter |
| Phalcon\Paginator\Factory | Renamed to | Phalcon\Paginator\PaginatorFactory         |
|                             | New        | Phalcon\Paginator\Repository               |

### Queue

| 3.4.x                                | State    | 4.0.x |
| ------------------------------------ | -------- | ----- |
| Phalcon\Queue\Beanstalk            | Видалено |       |
| Phalcon\Queue\Beanstalk\Exception | Видалено |       |
| Phalcon\Queue\Beanstalk\Job       | Видалено |       |

### Session

| 3.4.x                               | State      | 4.0.x                                      |
| ----------------------------------- | ---------- | ------------------------------------------ |
| Phalcon\Session\Adapter           | Renamed to | Phalcon\Session\Adapter\AbstractAdapter |
| Phalcon\Session\Adapter\Files    | Renamed to | Phalcon\Session\Adapter\Stream          |
|                                     | New        | Phalcon\Session\Adapter\Noop            |
| Phalcon\Session\Adapter\Memcache | Видалено   |                                            |
| Phalcon\Session\Factory           | Renamed to | Phalcon\Session\Manager                  |

### Storage

| 3.4.x | State | 4.0.x                                            |
| ----- | ----- | ------------------------------------------------ |
|       | New   | Phalcon\Storage\AdapterFactory                 |
|       | New   | Phalcon\Storage\Adapter\AbstractAdapter       |
|       | New   | Phalcon\Storage\Adapter\Apcu                  |
|       | New   | Phalcon\Storage\Adapter\Libmemcached          |
|       | New   | Phalcon\Storage\Adapter\Memory                |
|       | New   | Phalcon\Storage\Adapter\Redis                 |
|       | New   | Phalcon\Storage\Adapter\Stream                |
|       | New   | Phalcon\Storage\Exception                      |
|       | New   | Phalcon\Storage\SerializerFactory              |
|       | New   | Phalcon\Storage\Serializer\AbstractSerializer |
|       | New   | Phalcon\Storage\Serializer\Base64             |
|       | New   | Phalcon\Storage\Serializer\Igbinary           |
|       | New   | Phalcon\Storage\Serializer\Json               |
|       | New   | Phalcon\Storage\Serializer\Msgpack            |
|       | New   | Phalcon\Storage\Serializer\None               |
|       | New   | Phalcon\Storage\Serializer\Php                |

### Переклад

| 3.4.x                       | State      | 4.0.x                                        |
| --------------------------- | ---------- | -------------------------------------------- |
| Phalcon\Translate          | Видалено   |                                              |
| Phalcon\Translate\Adapter | Renamed to | Phalcon\Translate\Adapter\AbstractAdapter |
|                             | New        | Phalcon\Translate\InterpolatorFactory      |
| Phalcon\Translate\Factory | Renamed to | Phalcon\Translate\TranslateFactory         |

### Гіперпосилання

| 3.4.x | State | 4.0.x                   |
| ----- | ----- | ----------------------- |
|       | New   | Phalcon\Url            |
|       | New   | Phalcon\Url\Exception |

### Валідація

| 3.4.x                                        | State      | 4.0.x                                                   |
| -------------------------------------------- | ---------- | ------------------------------------------------------- |
| Phalcon\Validation\CombinedFieldsValidator | Renamed to | Phalcon\Validation\AbstractCombinedFieldsValidator    |
| Phalcon\Validation\Message                 | Renamed to | Phalcon\Messages\Message                              |
| Phalcon\Validation\Message\Group          | Renamed to | Phalcon\Messages\Messages                             |
| Phalcon\Validation\Validator               | Renamed to | Phalcon\Validation\AbstractValidator                  |
|                                              | New        | Phalcon\Validation\AbstractValidatorComposite         |
|                                              | New        | Phalcon\Validation\Exception                          |
|                                              | New        | Phalcon\Validation\ValidatorFactory                   |
|                                              | New        | Phalcon\Validation\Validator\File\AbstractFile      |
|                                              | New        | Phalcon\Validation\Validator\File\MimeType          |
|                                              | New        | Phalcon\Validation\Validator\File\Resolution\Equal |
|                                              | New        | Phalcon\Validation\Validator\File\Resolution\Max   |
|                                              | New        | Phalcon\Validation\Validator\File\Resolution\Min   |
|                                              | New        | Phalcon\Validation\Validator\File\Size\Equal       |
|                                              | New        | Phalcon\Validation\Validator\File\Size\Max         |
|                                              | New        | Phalcon\Validation\Validator\File\Size\Min         |
|                                              | New        | Phalcon\Validation\Validator\StringLength\Max       |
|                                              | New        | Phalcon\Validation\Validator\StringLength\Min       |