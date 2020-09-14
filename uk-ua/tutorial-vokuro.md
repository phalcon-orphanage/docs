---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Навчальний посібник - Vökuró'
keywords: 'tutorial, vokuro tutorial, step by step, mvc, security, permissions, навчальний посібник vokuro, крок за кроком, безпека, дозволи'
---

# Навчальний посібник - Vökuró

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-intermediate.svg)

## Vökuró

[Vökuró](https://github.com/phalcon/vokuro) - це приклад програми, що відтворює типовий веб-продукт, написаний на Phalcon. Цей додаток орієнтується на: - Авторизацію користувача (безпека) - Реєстрацію користувача (безпека) - Права доступу користувачів - Керування користувачами

> **ПРИМІТКА**: Ви можете використовувати Vökuró як базу для розробки вашого продукту та його приведення до ваших потреб. Це аж ніяк не ідеальний продукт, який точно не відповідає усім потребам.
{: .alert .alert-info }

> 
> **ПРИМІТКА**: Цей посібник орієнтований на тих, хто уже знайомий зі схемою дизайну Model-View-Controller (MVC). (дивіться посилання у кінці цього посібника)
{: .alert .alert-warning }

> 
> **ПРИМІТКА**: Зауважте, що вказаний нижче код був відформатований для збільшення читабельності
{: .alert .alert-warning }

## Встановлення

### Завантаження

Для того, щоб встановити додаток, ви можете клонувати або завантажити його з [GitHub](https://github.com/phalcon/vokuro). Ви можете відвідати сторінку GitHub, завантажити додаток і потім розпакувати його в каталог на вашому комп'ютері. Крім того, ви можете використовувати `git clone`:

```bash
git clone https://github.com/phalcon/vokuro
```

### Розширення

Для запуску Vökuró необхідно виконати певні умови. Ви повинні мати встановлений на вашій машині PHP >= 7.2 з такими розширеннями: - ctype - curl - dom - json - iconv - mbstring - memcached - opcache - openssl - pdo - pdo_mysql - psr - session - simplexml - xml - xmlwriter

Phalcon повинен бути встановлений. Перейдіть на сторінку [встановлення](installation), якщо вам потрібна допомога з встановленням Phalcon. Зверніть увагу, що Phalcon v4 потребує встановленого PSR розширення та його завантаження **перед** Phalcon. Щоб встановити PSR, ви можете скористатись сторінкою [php-psr](https://github.com/jbboehr/php-psr) на GitHub.

Нарешті, вам також потрібно буде переконатися, що ви оновили пакети композера (див. розділ нижче).

### Старт

Якщо всі вищезазначені вимоги задоволені, ви можете запустити додаток за допомогою локального PHP веб-сервера, виконавши таку команду в терміналі:

```bash
php -S localhost:8080 -t public/ .htrouter.php
```

Ця команда запустить сайт для `localhost` з портом `8080`. Ви можете змінити ці налаштування відповідно до ваших потреб. Крім того, ви можете налаштувати свій сайт в Apache або nginX за допомогою віртуального хоста. Будь ласка, зверніться до відповідної документації, щоб налаштувати віртуальний хост для цих веб-серверів.

### Docker

У папці `resources` ви знайдете `Dockerfile`, який дозволяє швидко налаштувати середовище і запустити програму. Щоб використовувати `Dockerfile` нам потрібно визначити назву нашого докеризованого додатка. Для цілей цього посібника ми використаємо `phalcon-tutorial-vokuro`.

З кореню додатка ми повинні компілювати проект (вам потрібно це робити лише раз):

```bash
$ docker build -t phalcon-tutorial-vokuro -f resources/Dockerfile .
```

а потім запустіть його

```bash
$ docker run -it --rm phalcon-tutorial-vokuro bash
```

Це дозволить нам отримати доступ до докеризованого середовища. Щоб перевірити версію PHP:

```bash
root@c7b43060b115:/code $ php -v

PHP 7.3.9 (cli) (built: Sep 12 2019 10:08:33) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.9, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.3.9, Copyright (c) 1999-2018, by Zend Technologies
```

та Phalcon:

```bash
root@c7b43060b115:/code $ php -r 'echo Phalcon\Version::get();'

4.0.0
```

Тепер ви маєте докеризоване середовище з усіма необхідними компонентами, щоб запустити Vökuró.

### Nanobox

У теці `resources` ви також знайдете файл `boxfile.yml`, що дозволяє використовувати nanobox для швидкого налаштування середовища. Вам потрібно просто скопіювати файл в кореневий каталог і запустити `nanobox run php-server`. Після налаштування додатка ви зможете перейти за IP-адресою, що відображається на екрані та працювати з цим додатком.

Для отримання додаткової інформації про те, як налаштувати nanobox, ознайомтесь з нашими сторінками \[Середовища Nanobox\]\[environments-nanobox\] та посібника[Nanobox](https://guides.nanobox.io/php/)

> **ПРИМІТКА**: У цьому посібнику ми припускаємо, що ваш додаток було скопійовано чи клоновано у теку з назвою `vokuro`.
{: .alert .alert-info }

## Структура

Погляньте на структуру додатка:

```bash
vokuro/
    .ci
    configs
    db
        migrations
        seeds
    public
    resources
    src
        Controllers
        Forms
        Models
        Phalcon
        Plugins
        Providers
    tests
    themes
        vokuro
    var
        cache
            acl
            metaData
            session
            volt
        logs
    vendor
```

| Каталог           | Опис                                                                |
| ----------------- | ------------------------------------------------------------------- |
| `.ci`             | Файли, необхідні для налаштування служб для CI                      |
| `configs`         | Файли конфігурації                                                  |
| `db`              | Містить файли міграції для бази даних                               |
| `public`          | Точка входу в додаток, місце зберігання файлів css, js та зображень |
| `resources`       | Файли Docker/nanobox для налаштування додатка                       |
| `src`             | Місце розташування всіх основних файлів (контролери, форми тощо)    |
| `src/Controllers` | Контролери                                                          |
| `src/Forms`       | Форми                                                               |
| `src/Models`      | Моделі бази даних                                                   |
| `src/Plugins`     | Плагіни                                                             |
| `src/Providers`   | Постачальники: налаштування сервісів у контейнері DI                |
| `tests`           | Тести                                                               |
| `themes`          | Теми/подання для легкого налаштування                               |
| `themes/vokuro`   | Тема додатку за замовчуванням                                       |
| `var`             | Різні допоміжні файли                                               |
| `var/cache`       | Файли кешу                                                          |
| `var/logs`        | Журнали                                                             |
| `vendor`          | Бібліотеки сторонній постачальників/композера                       |

## Налаштування

### `.env`

[Vökuró](https://github.com/phalcon/vokuro) використовує популярну бібліотеку [Dotenv](https://github.com/vlucas/phpdotenv) від Vance Lucas. Бібліотека використовує `.env` файл розташований в кореневій теці, який містить параметри конфігурації, такі як сервер бази даних, ім'я користувача, пароль тощо. Там є файл `.env.example`, який постачається з Vökuró, який можна скопіювати та перейменувати на `.env` а потім відредагувати його у відповідності до умов вашого середовища. Ви повинні зробити це спочатку, щоб ваш додаток міг працювати належним чином.

Доступні варіанти:

| Опція                | Опис                                                                                                                                                            |
| -------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `APP_CRYPT_SALT`     | Випадковий і довгий рядок, який використовується компонентом [Phalcon\Crypt](crypt) для створення паролів та будь-яких додаткових функцій безпеки              |
| `APP_BASE_URI`       | Зазвичай `/`, якщо ваш веб-сервер спрямовує запити безпосередньо у каталог Vökuró. Якщо ви встановили Vökuró в підкаталозі, ви можете відкоригувати базовий URI |
| `APP_PUBLIC_URL`     | Публічний URL додатку. Використовується для електронних листів.                                                                                                 |
| `DB_ADAPTER`         | Адаптер бази даних. Доступні адаптери: `mysql`, `pgsql`, `sqlite`. Будь ласка, переконайтеся, що в вашій системі встановлені відповідні розширення бази даних.  |
| `DB_HOST`            | Хост бази даних                                                                                                                                                 |
| `DB_PORT`            | Порт бази даних                                                                                                                                                 |
| `DB_USERNAME`        | Ім'я користувача бази даних                                                                                                                                     |
| `DB_PASSWORD`        | Пароль бази даних                                                                                                                                               |
| `DB_NAME`            | Ім'я бази даних                                                                                                                                                 |
| `MAIL_FROM_NAME`     | Ім'я FROM при надсиланні електронної пошти                                                                                                                      |
| `MAIL_FROM_EMAIL`    | FROM email при надсиланні електронної пошти                                                                                                                     |
| `MAIL_SMTP_SERVER`   | Сервер SMTP                                                                                                                                                     |
| `MAIL_SMTP_PORT`     | SMTP порт                                                                                                                                                       |
| `MAIL_SMTP_SECURITY` | Безпека SMTP (наприклад, `tls`)                                                                                                                                 |
| `MAIL_SMTP_USERNAME` | Ім'я користувача SMTP                                                                                                                                           |
| `MAIL_SMTP_PASSWORD` | Пароль до SMTP                                                                                                                                                  |
| `CODECEPTION_URL`    | Сервер Codection для випробувань. Якщо ви запускаєте тести локально, це має бути `127.0.0.1`                                                                    |
| `CODECEPTION_PORT`   | Порт Codeception                                                                                                                                                |

Після того, як файл конфігурації буде збережено, перехід у браузері за цією IP-адресою відобразить щось схоже на це:

![](/assets/images/content/tutorial-vokuro-1.png)

### `База данних`

Також потрібно ініціалізувати базу даних. [Vökuró](https://github.com/phalcon/vokuro) використовує популярну бібліотеку [Phinx](https://github.com/cakephp/phinx) від Rob Morgan (тепер Фонд Cake Foundation). Бібліотека використовує власний файл конфігурації (`phinx.php`), але для Vökuró вам не потрібно змінювати будь-які параметри, оскільки `phinx.php` читає файл `.env`, щоб отримати налаштування конфігурації. Це дозволяє вам встановити параметри конфігурації в одному місці.

Тепер нам потрібно буде розпочати міграцію. Щоб перевірити статус нашої бази даних:

```bash
/app $ ./vendor/bin/phinx status
```

Ви побачите цей екран:

![](/assets/images/content/tutorial-vokuro-2.png)

Щоб ініціалізувати базу даних, нам потрібно запустити міграції:

```bash
/app $ ./vendor/bin/phinx migrate
```

Екран відображатиме дію:

![](/assets/images/content/tutorial-vokuro-3.png)

А команда `status` тепер покаже всі зелені:

![](/assets/images/content/tutorial-vokuro-4.png)

### Налаштування

**acl.php**

Заглянувши у папку `config/`, ви помітите чотири файли. Вам не потрібно змінювати ці файли, щоб запустити додаток, але якщо ви хочете їх змінити, то це саме те місце, де вони розташовані. Файл `acl.php` повертає масив *routes*, який контролює, які маршрути видимі тільки для зареєстрованих користувачів.

Поточне налаштування вимагає, щоб користувач увійшов у систему, якщо хоче отрисати доступ до таких маршрутів:

- `users/index`
- `users/search`
- `users/edit`
- `users/create`
- `users/delete`
- `users/changePassword`
- `profiles/index`
- `profiles/search`
- `profiles/edit`
- `profiles/create`
- `profiles/delete`
- `permissions/index`

Якщо ви використовуєте Vökuró як відправну точку для вашого власного продукту, то вам потрібно буде змінити цей файл, щоб додавати чи видалити маршрути, щоб переконатися, що ваші захищені маршрути доступні після авторизації.

> **ПРИМІТКА**: Зберігання приватних маршрутів у масиві ефективне і просте в обслуговуванні для невеликої та середньої програми. Як тільки ваш додаток почне зростати, ви можете розглянути іншу техніку зберігання своїх приватних иаршрутів, наприклад: база даних з механізмом кешування.
{: .alert .alert-info }

**config.php**

Цей файл містить всі параметри конфігурації, які потрібно Vökuró. Зазвичай вам не потрібно змінювати цей файл, так як елементи масиву встановлено `.env` файлом і [Dotenv](https://github.com/vlucas/phpdotenv). Однак, ви можете захотіти змінити місцезнаходження своїх журналів чи інші шляхи, вирішите змінити структуру каталогів.

Одним з елементів, які ви можете захотіти змінити у роботі з Vökuró на своїй локальній машині є `useMail` та встановити його на `false`. Це вкаже Vökuró, не намагатися підключатися до поштового сервера, щоб надіслати повідомлення при реєстрації користувача на сайті.

**providers.php**

Цей файл містить всіх постачальників, які потрібні Vökuró. Це список класів нашого додатку, що реєструє певні класи у контейнері DI. Якщо вам потрібно зареєструвати нові компоненти у контейнері DI, ви можете додати їх до масиву цього файлу.

**routes.php**

У цьому файлі містяться маршрути, які розуміє Vökuró. Роутер уже зареєстрував маршрути за замовчуванням, тому будь-які маршрутизатори, визначені в `routes.php` є специфічними і нетиповими. Ви можете додати в цей файл будь-які нестандартні маршрути при налаштуванні Vökuró. На всякий випадок нагадаємо маршрути за замовчуванням:

```bash
/:controller/:action/:parameters
```

### Постачальники

Як було зазначено вище, Vökuró використовує класи під назвою Providers для реєстрації послуг у контейнері DI. Це один зі способів реєстрації послуг в контейнері DI, ніщо не заважає вам помістити всі ці реєстрації в один файл.

Для Vökuró ми вирішили використовувати окремі файли для кожного сервісу, та файл `providers.php` (див. вище) в якості реєстраційного масиву конфігурації для цих сервісів. Це дозволяє нам мати набагато менші фрагменти коду, організовані в окремих файлах для різних сервісів, а також масив який дозволяє нам реєструвати чи відключати службу без видалення файлів. Все, що нам потрібно - це змінити масив `providers.php`.

Класи постачальників розташовані в `src/Providers`. Кожен із класів постачальників реалізує інтерфейс [Phalcon\Di\ServiceProviderInterface](api/phalcon_di#di-serviceproviderinterface). Для отримання додаткової інформації дивіться нижче у розділі завантажувача.

## Composer

[Vökuró](https://github.com/phalcon/vokuro) використовує [композер](https://getcomposer.org) для завантаження і встановлення PHP бібліотек. Бібліотеки, що використовуються:

- [Dotenv](https://github.com/vlucas/phpdotenv)
- [Phinx](https://github.com/cakephp/phinx)
- [Swift Mailer](https://swiftmailer.symfony.com)

Глянувши у `composer.json`, бачимо, що необхідні такі пакунки:

```json
"require": {
    "php": ">=7.2",
    "ext-openssl": "*",
    "ext-phalcon": "~4.0.0-beta.2",
    "robmorgan/phinx": "^0.11.1",
    "swiftmailer/swiftmailer": "^5.4",
    "vlucas/phpdotenv": "^3.4"
}
```

Якщо це нова установка, ви можете запустити

```bash
composer install
```

або якщо ви хочете оновити вже встановлені вищезгадані пакети:

```bash
composer update
```

Для отримання додаткової інформації про композер, ви можете відвідати сторінку його [документації](https://getcomposer.org).

## Завантажувач

### Точка входу

Вхідною точкою нашого додатку є `public/index.php`. У цьому файлі міститься необхідний код, який збирає і завантажує додаток. Він також служить єдиною точкою входу до нашого додатка, спрощує нам відловлювання помилок, захист файлів тощо.

Давайте поглянемо на код:

```php
<?php

use Vokuro\Application as VokuroApplication;

error_reporting(E_ALL);
$rootPath = dirname(__DIR__);

try {
    require_once $rootPath . '/vendor/autoload.php';

    /**
     * Завантаження .env конфігурації
     */
    Dotenv\Dotenv::create($rootPath)->load();

    /**
     * Запуск Vökuró!
     */
    echo (new VokuroApplication($rootPath))->run();
} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
```

Перш за все, ми пересвідчуємось, що маємо повноцінне звітування про помилки. Звісно, ви можете змінити це, якщо бажаєте, або переписати код, щоб звітування про помилки контролювалось через записи у вашому `.env` файлі.

Блок `try`/`catch` згортає усі операції. Це гарантує, що на екрані з'являться всі помилки.

> **ПРИМІТКА** Вам потрібно буде переробити код для підвищення безпеки. Якщо зараз станеться помилка бази даних, код `catch` виведе на екран технічну інформацію щодо доступу до бази даних з інформацією про помилку. Цей код є посібником, та не готовий для повномасштабного виробничого додатку
{: .alert .alert-danger }

Ми впевнені, що маємо доступ до всіх підтримуваних бібліотек, завантажуючи автозавантажувач композера. У `composer.json` ми також визначили запис `autoload`, що забезпечує автозавантаження будь-яких класів з простору імен `Vokuro` з теки `src`.

```json
"autoload": {
    "psr-4": {
        "Vokuro\\": "app/"
    },
    "files": [
        "app/Helpers.php"
    ]
}
```

Потім ми завантажуємо змінні середовища, визначені у нашому файлі `.env`, викликаючи

```php
Dotenv\Dotenv::create($rootPath)->load();
```

І нарешті ми запускаємо нашу програму.

### Application

Вся логіка програми загорнута в клас `Vokuro\Application`. Давайте подивимося, як це робиться:

```php
<?php
declare(strict_types=1);

namespace Vokuro;

use Exception;
use Phalcon\Application\AbstractApplication;
use Phalcon\Di\DiInterface;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Application as MvcApplication;

/**
 * Vökuró Application
 */
class Application
{
    const APPLICATION_PROVIDER = 'bootstrap';

    /**
     * @var AbstractApplication
     */
    protected $app;

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * Кореневий шлях проекту
     *
     * @var string
     */
    protected $rootPath;

    /**
     * @param string $rootPath
     *
     * @throws Exception
     */
    public function __construct(string $rootPath)
    {
        $this->di       = new FactoryDefault();
        $this->app      = $this->createApplication();
        $this->rootPath = $rootPath;

        $this->di->setShared(self::APPLICATION_PROVIDER, $this);

        $this->initializeProviders();
    }

    /**
     * Запуск Vökuró Application
     *
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return (string) $this
            ->app
            ->handle($_SERVER['REQUEST_URI'])
            ->getContent()
        ;
    }

    /**
     * Отримуємо кореневий шлях проекту
     *
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    /**
     * @return AbstractApplication
     */
    protected function createApplication(): AbstractApplication
    {
        return new MvcApplication($this->di);
    }

    /**
     * @throws Exception
     */
    protected function initializeProviders(): void
    {
        $filename = $this->rootPath 
                 . '/configs/providers.php';
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new Exception(
                'Файл providers.php не існує або нечитабельний.'
            );
        }

        $providers = include_once $filename;
        foreach ($providers as $providerClass) {
            /** @var ServiceProviderInterface $provider */
            $provider = new $providerClass;
            $provider->register($this->di);
        }
    }
}

```

Конструктор класу спочатку створює новий контейнер DI та зберігає його в локальній власності. Ми використовуємо [Phalcon\Di\FactoryDefault](di), який містить багато сервісів уже зареєстрованих для нас.

Потім ми створюємо новий [Phalcon\Mvc\Application](application) та зберігаємо його також у власність. Ми також зберігаємо кореневий шлях, тому що він потрібний кругом у додатку.

Потім ми реєструємо цей клас ( `Vokuro\Application`) у контейнері Di, використовуючи ім'я `bootstrap`. Це дає нам доступ до цього класу з будь-якої частини нашого застосунку через контейнер DI.

Останнє, що ми робимо - це реєструємо всіх постачальників. Хоча об'єкт [Phalcon\Di\FactoryDefault](di) має багато сервісів, які вже зареєстровані для нас, нам все ще треба реєструвати постачальників, які відповідають потребам нашої програми. Як зазначено вище, кожен клас постачальника реалізує інтерфейс [Phalcon\Di\ServiceProviderInterface](api/phalcon_di#di-serviceproviderinterface), тож ми можемо завантажити кожен клас, викликаючи метод `register()` з контейнера Di для реєстрації кожного сервісу. Для цього ми спочатку завантажимо масив конфігурації `config/providers.php`, а потім зв'яжемо записи і зареєструємо кожного провайдера.

Доступні постачальники:

| Постачальник             | Опис                                                                 |
| ------------------------ | -------------------------------------------------------------------- |
| `AclProvider`            | Права доступу                                                        |
| `AuthProvider`           | Авторизація                                                          |
| `ConfigProvider`         | Значення конфігурації                                                |
| `CryptProvider`          | Шифрування                                                           |
| `DbProvider`             | Доступ до бази даних                                                 |
| `DispatcherProvider`     | Диспетчер, який використовує контролер для переходу за URL-адресою   |
| `FlashProvider`          | Флеш-повідомлення для забезпечення зворотного зв'язку з користувачем |
| `LoggerProvider`         | Реєстратор помилок та іншої інформації                               |
| `MailProvider`           | Підтримка пошти                                                      |
| `ModelsMetadataProvider` | Метадані для моделей                                                 |
| `RouterProvider`         | Маршрути                                                             |
| `SecurityProvider`       | Безпека                                                              |
| `SessionBagProvider`     | Дані сесії                                                           |
| `SessionProvider`        | Дані сесії                                                           |
| `UrlProvider`            | Обробка URL                                                          |
| `ViewProvider`           | Подання та двигун, що його формує                                    |

`run()` тепер запустить `REQUEST_URI`, обробить його і поверне вміст назад. Внутрішньо програма вираховує маршрут на основі запиту, координує відповідний контролер і подання перед поверненням результату цієї операції назад користувачеві у якості відповіді.

## База данних

Як зазначено вище, Vökuró можна встановити з MariaDB/MySQL/Aurora, PostgreSql або SQLite в якості сховища баз даних. Для цілей цього посібника ми використовуємо MariaDB. Таблиці, які використовує програма:

| Таблиця               | Опис                                            |
| --------------------- | ----------------------------------------------- |
| `email_confirmations` | Підтвердження електронною поштою для реєстрації |
| `failed_logins`       | Невдалі спроби входу                            |
| `password_changes`    | Коли було змінено пароль і ким                  |
| `permissions`         | Матриця дозволів                                |
| `phinxlog`            | Міграційна таблиця Phinx                        |
| `profiles`            | Профіль для кожного користувача                 |
| `remember_tokens`     | Функціональні токени *Пам'ятати мене*           |
| `reset_passwords`     | Таблиця токенів скидання паролів                |
| `success_logins`      | Успішні спроби входу                            |
| `users`               | Користувачі                                     |

## Моделі

Слідуючи шаблону [Model-View-Controller](https://en.wikipedia.org/wiki/Model–view–controller), Vökuró має одну модель для окремої таблиці бази даних (виключаючи `phinxlog`). Моделі дозволяють нам взаємодіяти з таблицями бази даних у легкий об'єктно-орієнтований спосіб. Моделі розташовані в каталозі `/src/Models`, і кожна модель визначає відповідні поля вихідної таблиці та будь-які зв'язки між моделлю та іншими об'єктами. Деякі моделі також втілюють правила перевірки для забезпечення належного збереження даних у базі даних.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * Успішні авторизації
 *
 * Ця модель реєструє успішні спроби авторизації зареєстрованих користувачів
 */
class SuccessLogins extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var string
     */
    public $userAgent;

    public function initialize()
    {
        $this->belongsTo(
            'usersId', 
            Users::class, 
            'id', 
            [
                'alias' => 'user',
            ]
        );
    }
}
```

У моделі вище ми визначили всі поля таблиці як публічні властивості для спрощення доступу:

```php
echo $successLogin->ipAddress;
```

> **NOTE**: If you notice, the property names map exactly the case (upper/lower) of the field names in the relevant table.
{: .alert .alert-warning }

In the `initialize()` method, we also define a relationship between this model and the `Users` model. We assign the fields (local/remote) as well as an `alias` for this relationship. We can therefore access the user related to a record of this model as follows:

```php
echo $successLogin->user->name;
```

> **NOTE**: Feel free to open each model file and identify the relationships between the models. Check our documentation for the difference between various types of relationships
{: .alert .alert-info }

## Контролери

Again following the [Model-View-Controller](https://en.wikipedia.org/wiki/Model–view–controller) pattern, Vökuró has one controller to handle a specific *parent* route. This means that the `AboutController` handles the `/about` route. All controllers are located in the `/src/Cotnrollers` directory.

The default controller is `IndexController`. All controller classes have the suffix `Controller`. Each controller has methods suffixed with `Action` and the default action is `indexAction`. Therefore if you visit the site with just the URL, the `IndexController` will be called and the `indexAction` will be executed.

After that, unless you have registered specific routes, the default routes (automatically registered) will try to match:

```bash
/profiles/search
```

to

```bash
/src/Controllers/SearchController.php -> searchAction
```

The available controllers, actions and routes for Vökuró are:

| Controller      | Action           | Route                     | Description                                 |
| --------------- | ---------------- | ------------------------- | ------------------------------------------- |
| `About`         | `index`          | `/about`                  | Shows the `about` page                      |
| `Index`         | `index`          | `/`                       | Default action - home page                  |
| `Права доступу` | `index`          | `/permissions`            | View/change permissions for a profile level |
| `Privacy`       | `index`          | `/privacy`                | View the privacy page                       |
| `Profiles`      | `index`          | `/profiles`               | View profiles default page                  |
| `Profiles`      | `create`         | `/profiles/create`        | Create profile                              |
| `Profiles`      | `delete`         | `/profiles/delete`        | Delete profile                              |
| `Profiles`      | `edit`           | `/profiles/edit`          | Edit profile                                |
| `Profiles`      | `search`         | `/profiles/search`        | Search profiles                             |
| `Session`       | `index`          | `/session`                | Session default action                      |
| `Session`       | `forgotPassword` | `/session/forgotPassword` | Forget password                             |
| `Session`       | `login`          | `/session/login`          | Login                                       |
| `Session`       | `logout`         | `/session/logout`         | Logout                                      |
| `Session`       | `signup`         | `/session/signup`         | Signup                                      |
| `Terms`         | `index`          | `/terms`                  | View the terms page                         |
| `UserControl`   | `confirmEmail`   | `/confirm`                | Confirm email                               |
| `UserControl`   | `resetPassword`  | `/reset-password`         | Reset password                              |
| `Користувачі`   | `index`          | `/users`                  | Users default screen                        |
| `Користувачі`   | `changePassword` | `/users/changePassword`   | Change user password                        |
| `Користувачі`   | `create`         | `/users/create`           | Create user                                 |
| `Користувачі`   | `delete`         | `/users/delete`           | Delete user                                 |
| `Користувачі`   | `edit`           | `/users/edit`             | Edit user                                   |

## Views

The last element of the [Model-View-Controller](https://en.wikipedia.org/wiki/Model–view–controller) pattern is the views. Vökuró uses [Volt](volt) as the view engine for its views.

> **NOTE**: Generally, one would expect to see a `views` folder under the `/src` folder. Vökuró uses a slightly different approach, storing all the view files under `/themes/vokuro`. 
{: .alert .alert-info }

The views directory contains directories that map to each controller. Inside each of those directories, `.volt` files are mapped to each action. So for example the route:

```bash
/profiles/create
```

maps to:

```bash
ProfilesController -> createAction
```

and the view is located:

```bash
/themes/vokuro/profiles/create.volt
```

The available views are:

| Controller      | Action           | Вигляд                         | Description                                 |
| --------------- | ---------------- | ------------------------------ | ------------------------------------------- |
| `About`         | `index`          | `/about/index.volt`            | Shows the `about` page                      |
| `Index`         | `index`          | `/index/index.volt`            | Default action - home page                  |
| `Права доступу` | `index`          | `/permissions/index.volt`      | View/change permissions for a profile level |
| `Privacy`       | `index`          | `/privacy/index.volt`          | View the privacy page                       |
| `Profiles`      | `index`          | `/profiles/index.volt`         | View profiles default page                  |
| `Profiles`      | `create`         | `/profiles/create.volt`        | Create profile                              |
| `Profiles`      | `delete`         | `/profiles/delete.volt`        | Delete profile                              |
| `Profiles`      | `edit`           | `/profiles/edit.volt`          | Edit profile                                |
| `Profiles`      | `search`         | `/profiles/search.volt`        | Search profiles                             |
| `Session`       | `index`          | `/session/index.volt`          | Session default action                      |
| `Session`       | `forgotPassword` | `/session/forgotPassword.volt` | Forget password                             |
| `Session`       | `login`          | `/session/login.volt`          | Login                                       |
| `Session`       | `logout`         | `/session/logout.volt`         | Logout                                      |
| `Session`       | `signup`         | `/session/signup.volt`         | Signup                                      |
| `Terms`         | `index`          | `/terms/index.volt`            | View the terms page                         |
| `Користувачі`   | `index`          | `/users/index.volt`            | Users default screen                        |
| `Користувачі`   | `changePassword` | `/users/changePassword.volt`   | Change user password                        |
| `Користувачі`   | `create`         | `/users/create.volt`           | Create user                                 |
| `Користувачі`   | `delete`         | `/users/delete.volt`           | Delete user                                 |
| `Користувачі`   | `edit`           | `/users/edit.volt`             | Edit user                                   |

The `/index.volt` file contains the main layout of the page, including stylesheets, javascript references etc. The `/layouts` directory contains different layouts that are used in the application, for instance a `public` one if the user is not logged in, and a `private` one for logged in users. The individual views are injected into the layouts and construct the final page.

## Компоненти

There are several components that we use in Vökuró, offering functionality throughout the application. All these components are located in the `/src/Plugins` directory.

### Acl

`Vokuro\Plugins\Acl\Acl` is a component that implements an [Access Control List](https://en.wikipedia.org/wiki/Access-control_list) for our application. The ACL controls which user has access to which resources. You can read more about ACL in our [dedicated page](acl).

In this component, We define the resources that are considered *private*. These are held in an internal array with controller as the key and action as the value, and identify which controller/actions require authentication. It also holds human readable descriptions for actions used throughout the application.

The component exposes the following methods:

| Method                                      | Returns      | Description                                                     |
| ------------------------------------------- | ------------ | --------------------------------------------------------------- |
| `getActionDescription($action)`             | `string`     | Returns the action description according to its simplified name |
| `getAcl()`                                  | `ACL object` | Returns the ACL list                                            |
| `getPermissions(Profiles $profile)`         | `array`      | Returns the permissions assigned to a profile                   |
| `getResources()`                            | `array`      | Returns all the resources and their actions available           |
| `isAllowed($profile, $controller, $action)` | `bool`       | Checks if the current profile is allowed to access a resource   |
| `isPrivate($controllerName)`                | `bool`       | Checks if a controller is private or not                        |
| `rebuild()`                                 | `ACL object` | Rebuilds the access list into a file                            |

### Auth

`Vokuro\Plugins\Auth\Auth` is a component that manages authentication and offers identity management in Vökuró.

The component exposes the following methods:

| Method                                   | Description                                                                            |
| ---------------------------------------- | -------------------------------------------------------------------------------------- |
| `check($credentials)`                    | Checks the user credentials                                                            |
| `saveSuccessLogin($user)`                | Creates the remember me environment settings the related cookies and generating tokens |
| `registerUserThrottling($userId)`        | Implements login throttling. Reduces the effectiveness of brute force attacks          |
| `createRememberEnvironment(Users $user)` | Creates the remember me environment settings the related cookies and generating tokens |
| `hasRememberMe(): bool`                  | Check if the session has a remember me cookie                                          |
| `loginWithRememberMe(): Response`        | Logs on using the information in the cookies                                           |
| `checkUserFlags(Users $user)`            | Checks if the user is banned/inactive/suspended                                        |
| `getIdentity(): array / null`            | Returns the current identity                                                           |
| `getName(): string`                      | Returns the name of the user                                                           |
| `remove()`                               | Removes the user identity information from session                                     |
| `authUserById($id)`                      | Authenticates the user by his/her id                                                   |
| `getUser(): Users`                       | Get the entity related to user in the active identity                                  |
| `findFirstByToken($token): int / null`   | Returns the current token user                                                         |
| `deleteToken(int $userId)`               | Delete the current user token in session                                               |

### Mail

`Vokuro\Plugins\Mail\Mail` is a wrapper to [Swift Mailer](https://swiftmailer.symfony.com). It exposes two methods `send()` and `getTemplate()` which allow you to get a template from the views and populate it with data. The resulting HTML can then be used in the `send()` method along with the recipient and other parameters to send the email message.

> **NOTE**: Note that this component is used only if `useMail` is enabled in your `.env` file. You will also need to ensure that the SMTP server and credentials are valid.
{: .alert .alert-info } 

## Sign Up

### Controller

In order to access all the areas of Vökuró you need to have an account. Vökuró allows you to sign up to the site by clicking the `Create an Account` button.

What this will do is navigate you to the `/session/signup` URL, which in turn will call the `SessionController` and `signupAction`. Let's have a look what is going on in the `signupAction`:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Flash\Direct;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;
use Phalcon\Mvc\View;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\Users;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 * @property Request    $request
 * @property Security   $security
 * @property View       $view
 */
class SessionController extends ControllerBase
{
    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        // ....

        $this->view->setVar('form', $form);
    }
}
```

The workflow of the application is:

- Visit `/session/signup` 
    - Create form, send form to the view, render the form
- Submit data (not post) 
    - Form shows again, nothing else happens
- Submit data (post) 
    - Errors 
        - Form validators have errors, send the form to the view, render the form (errors will show)
    - No errors 
        - Data is sanitized
        - New Model created
        - Data saved in the database 
            - Error 
                - Show message on screen and refresh the form
            - Success 
                - Record saved
                - Show confirmation on screen
                - Send email (if applicable)

### Form

In order to have validation for user supplied data, we are utilizing the [Phalcon\Forms\Form](forms) and [Phalcon\Validation\*](validation) classes. These classes allow us to create HTML elements and attach validators to them. The form is then passed to the view, where the actual HTML elements are rendered on the screen.

When the user submits information, we send the posted data back to the form and the relevant validators validate the input and return any potential error messages.

> **NOTE**: All the forms for Vökuró are located in `/src/Forms`
{: .alert .alert-info }

First we create a `SignUpForm` object. In that object we define all the HTML elements we need with their respective validators:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SignUpForm extends Form
{
    /**
     * @param string|null $entity
     * @param array       $options
     */
    public function initialize(
        string $entity = null, 
        array $options = []
    ) {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The name is required',
                    ]
                ),
            ]
        );

        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        $email->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The e-mail is required',
                    ]
                ),
                new Email(
                    [
                        'message' => 'The e-mail is not valid',
                    ]
                ),
            ]
        );

        $this->add($email);

        // Password
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The password is required',
                    ]
                ),
                new StringLength(
                    [
                        'min'            => 8,
                        'messageMinimum' => 'Password is too short. ' .
                                            'Minimum 8 characters',
                    ]
                ),
                new Confirmation(
                    [
                        'message' => "Password doesn't match " .
                                     "confirmation",
                        'with'    => 'confirmPassword',
                    ]
                ),
            ]
        );

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->addValidators(
            [
                new PresenceOf(
                    [
                        'message' => 'The confirmation password ' .
                                     'is required',
                    ]
                ),
            ]
        );

        $this->add($confirmPassword);

        // Remember
        $terms = new Check(
            'terms', 
            [
                'value' => 'yes',
            ]
        );

        $terms->setLabel('Accept terms and conditions');
        $terms->addValidator(
            new Identical(
                [
                    'value'   => 'yes',
                    'message' => 'Terms and conditions must be ' .
                                 'accepted',
                ]
            )
        );

        $this->add($terms);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidator(
            new Identical(
                [
                    'value'   => $this->security->getRequestToken(),
                    'message' => 'CSRF validation failed',
                ]
            )
        );
        $csrf->clear();

        $this->add($csrf);

        // Sign Up
        $this->add(
            new Submit(
                'Sign Up', 
                [
                    'class' => 'btn btn-success',
                ]
            )
        );
    }

    /**
     * Prints messages for a specific element
     *
     * @param string $name
     *
     * @return string
     */
    public function messages(string $name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                return $message;
            }
        }

        return '';
    }
}
```

In the `initialize` method we are setting up all the HTML elements we need. These elements are:

| Element           | Type       | Description                  |
| ----------------- | ---------- | ---------------------------- |
| `name`            | `Text`     | The name of the user         |
| `email`           | `Text`     | The email for the account    |
| `password`        | `Password` | The password for the account |
| `confirmPassword` | `Password` | Password confirmation        |
| `terms`           | `Check`    | Accept the terms checkbox    |
| `csrf`            | `Hidden`   | CSRF protection element      |
| `Sign Up`         | `Submit`   | Submit button                |

Adding elements is pretty straight forward:

```php
<?php
declare(strict_types=1);

// Email
$email = new Text('email');
$email->setLabel('E-Mail');
$email->addValidators(
    [
        new PresenceOf(
            [
                'message' => 'The e-mail is required',
            ]
        ),
        new Email(
            [
                'message' => 'The e-mail is not valid',
            ]
        ),
    ]
);

$this->add($email);
```

First we create a `Text` object and set its name to `email`. We also set the label of the element to `E-Mail`. After that we attach various validators on the element. These will be invoked after the user submits data, and that data is passed in the form.

As we see above, we attach the `PresenceOf` validator on the `email` element with a message `The e-mail is required`. The validator will check if the user has submitted data when they clicked the submit button and will produce the message if the validator fails. The validator checks the passed array (usually `$_POST`) and for this particular element it will check `$_POST['email']`.

We also attach the `Email` validator, which is responsible for checking for a valid email address. As you can see the validators belong in an array, so you can easily attach as many validators as you need on any particular element.

The last thing we do is to add the element in the form.

You will notice that the `terms` element does not have any validators attached to it, so our form will not check the contents of the element.

Special attention to the `password` and `confirmPassword` elements. You will notice that both elements are of type `Password`. The idea is that you need to type your password twice, and the passwords need to match in order to avoid errors.

The `password` field has two validators for content: `PresenceOf` i.e. it is required and `StringLength`: we need the password to be more than 8 characters. We also attach a third validator called `Confirmation`. This special validator ties the `password` element with the `confirmPassword` element. When it is triggered to validate it will check the contents of both elements and if they are not identical, the error message will appear i.e. the validation will fail.

### Вигляд

Now that we have everything set up in our form, we pass the form to the view:

```php
$this->view->setVar('form', $form);
```

Our view now needs to *render* the elements:

```twig
{% raw %}
{# ... #}
{% 
    set isEmailValidClass = form.messages('email') ? 
        'form-control is-invalid' : 
        'form-control' 
%}
{# ... #}

<h1 class="mt-3">Sign Up</h1>

<form method="post">
    {# ... #}

    <div class="form-group row">
        {{ 
            form.label(
                'email', 
                [
                    'class': 'col-sm-2 col-form-label'
                ]
            ) 
        }}
        <div class="col-sm-10">
            {{ 
                form.render(
                    'email', 
                    [
                        'class': isEmailValidClass, 
                        'placeholder': 'Email'
                    ]
                ) 
            }}
            <div class="invalid-feedback">
                {{ form.messages('email') }}
            </div>
        </div>
    </div>

    {# ... #}
    <div class="form-group row">
        <div class="col-sm-10">
            {{ 
                form.render(
                    'csrf', 
                    [
                        'value': security.getToken()
                    ]
                ) 
            }}
            {{ form.messages('csrf') }}

            {{ form.render('Sign Up') }}
        </div>
    </div>
</form>

<hr>

{{ link_to('session/login', "&larr; Back to Login") }}
{% endraw %}
```

The variable that we set in our view for our `SignUpForm` object is called `form`. We therefore use it directly and call the methods of it. The syntax in Volt is slightly different. In PHP we would use `$form->render()` whereas in Volt we will use `form.render()`.

The view contains a conditional at the top, checking whether there have been any errors in our form, and if there were, it attaches the `is-invalid` CSS class to the element. This class puts a nice red border by the element, highlighting the error and showing the message.

After that we have regular HTML tags with the relevant styling. In order to display the HTML code of each element we need to call `render()` on the `form` with the relevant element name. Also note that we also call `form.label()` with the same element name, so that we can create respective `<label>` tags.

At the end of the view we render the `CSRF` hidden field as well as the submit button `Sign Up`.

### Post

As mentioned above, once the user fills the form and clicks the `Sign Up` button, the form will *self post* i.e. it will post the data on the same controller and action (in our case `/session/signup`). The action now needs to process this posted data:

```php
<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Flash\Direct;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security;
use Phalcon\Mvc\View;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\Users;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 * @property Request    $request
 * @property Security   $security
 * @property View       $view
 */
class SessionController extends ControllerBase
{
    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        if (true === $this->request->isPost()) {
            if (false !== $form->isValid($this->request->getPost())) {
                $name     = $this
                    ->request
                    ->getPost('name', 'striptags')
                ;
                $email    = $this
                    ->request
                    ->getPost('email')
                ;
                $password = $this
                    ->request
                    ->getPost('password')
                ;
                $password = $this
                    ->security
                    ->hash($password)
                ;

                $user = new Users(
                    [
                        'name'       => $name,
                        'email'      => $email,
                        'password'   => $password,
                        'profilesId' => 2,
                    ]
                );

                if ($user->save()) {
                    return $this->dispatcher->forward([
                        'controller' => 'index',
                        'action'     => 'index',
                    ]);
                }

                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
        }

        $this->view->setVar('form', $form);
    }
}
```

If the user has submitted data, the following line will evaluate and we will be executing code inside the `if` statement:

```php
if (true === $this->request->isPost()) {
```

Here we are checking the request that came from the user, if it is a `POST`. Now that it is, we need to use the form validators and check if we have any errors. The [Phalcon\Http\Request](request) object, allows us to get that data easily by using:

```php
$this->request->getPost()
```

We now need to pass this posted data in the form and call `isValid`. This will fire all the validators for each element and if any of them fail, the form will populate the internal messages collection and return `false`

```php
if (false !== $form->isValid($this->request->getPost())) {
```

If everything is fine, we use again the [Phalcon\Http\Request](request) object to retrieve the submitted data but also sanitize them. The following example strips the tags from the submitted `name` string:

```php
$name     = $this
    ->request
    ->getPost('name', 'striptags')
;
```

Note that we never store clear text passwords. Instead we use the [Phalcon\Security](security) component and call `hash` on it, to transform the supplied password to a one way hash and store that instead. This way, if someone compromises our database, at least they have no access to clear text passwords.

```php
$password = $this
    ->security
    ->hash($password)
;
```

We now need to store the supplied data in the database. We do that by creating a new `Users` model, pass the sanitized data into it and then call `save`:

```php
$user = new Users(
    [
        'name'       => $name,
        'email'      => $email,
        'password'   => $password,
        'profilesId' => 2,
    ]
);

if ($user->save()) {
    return $this
        ->dispatcher
        ->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
}
```

If the `$user->save()` returns `true`, the user will be forwarded to the home page (`index/index`) and a success message will appear on screen.

### Model

**Зв'язки**

Now we need to check the `Users` model, since there is some logic we have applied there, in particular the `afterSave` and `beforeValidationOnCreate` events.

The core method, the setup if you like happens in the `initialize` method. That is the spot where we set all the [relationships](db-models-relationships) for the model. For the `Users` class we have several relationships defined. Why relationships you might ask? Phalcon offers an easy way to retrieve related data to a particular model.

If for instance we want to check all the successful logins for a particular user, we can do so with the following code snippet:

```php
<?php
declare(strict_types=1);

use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

$user = Users::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 7,
        ] 
    ]
);

$logins = SuccessLogin::find(
    [
        'conditions' => 'userId = :userId:',
        'bind'       => [
            'userId' => 7,
        ] 
    ]
);
```

The above code gets the user with id `7` and then gets all the successful logins from the relevant table for that user.

Using relationships we can let Phalcon do all the heavy lifting for us. So the code above becomes:

```php
<?php
declare(strict_types=1);

use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

$user = Users::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 7,
        ] 
    ]
);

$logins = $user->successLogins;

$logins = $user->getRelated('successLogins');
```

The last two lines do exactly the same thing. It is a matter of preference which syntax you want to use. Phalcon will query the related table, filtering the related table with the id of the user.

For our `Users` table we define the following relationships:

| Name              | Source field | Target field | Model             |
| ----------------- | ------------ | ------------ | ----------------- |
| `passwordChanges` | `id`         | `usersId`    | `PasswordChanges` |
| `profile`         | `profileId`  | `id`         | `Profiles`        |
| `resetPasswords`  | `id`         | `usersId`    | `ResetPasswords`  |
| `successLogins`   | `id`         | `usersId`    | `SuccessLogins`   |

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    // ...

    public function initialize()
    {
        $this->belongsTo(
            'profilesId', 
            Profiles::class, 
            'id', 
            [
                'alias'    => 'profile',
                'reusable' => true,
            ]
        );

        $this->hasMany(
            'id', 
            SuccessLogins::class, 
            'usersId', 
            [
                'alias'      => 'successLogins',
                'foreignKey' => [
                    'message' => 'User cannot be deleted because ' .
                                 'he/she has activity in the system',
                ],
            ]
        );

        $this->hasMany(
            'id', 
            PasswordChanges::class, 
            'usersId', 
            [
                'alias'      => 'passwordChanges',
                'foreignKey' => [
                    'message' => 'User cannot be deleted because ' .
                                 'he/she has activity in the system',
                ],
            ]
        );

        $this->hasMany(
            'id', 
            ResetPasswords::class, 
            'usersId', [
            'alias'      => 'resetPasswords',
            'foreignKey' => [
                'message' => 'User cannot be deleted because ' .
                             'he/she has activity in the system',
            ],
        ]);
    }

    // ...
}
```

As you can see in the defined relationships, we have a `belongsTo` and three `hasMany`. All relationships have an alias so that we can access them easier. The `belongsTo` relationship also has the `reusable` flag set to on. This means that if the relationship is called more than once in the same request, Phalcon would perform the database query only the first time and cache the resultset. Any subsequent calls will use the cached resultset.

Also notable is that we define specific messages for foreign keys. If the particular relationship is violated, the defined message will be raised.

**Events**

[Phalcon\Mvc\Model](db-models) is designed to fire specific <events>. These event methods can be located either in a listener or in the same model.

For the `Users` model, we attach code to the `afterSave` and `beforeValidationOnCreate` events.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function beforeValidationOnCreate()
    {
        if (true === empty($this->password)) {
            $tempPassword = preg_replace(
                '/[^a-zA-Z0-9]/', 
                '', 
                base64_encode(openssl_random_pseudo_bytes(12))
            );

            $this->mustChangePassword = 'Y';

            $this->password = $this->getDI()
                                   ->getSecurity()
                                   ->hash($tempPassword)
            ;
        } else {
            $this->mustChangePassword = 'N';
        }

        if ($this->getDI()->get('config')->useMail) {
            $this->active = 'N';
        } else {
            $this->active = 'Y';
        }

        $this->suspended = 'N';

        $this->banned = 'N';
    }
}
```

The `beforeValidationOnCreate` will fire every time we have a new record (`Create`), before any validations occur. We check if we have a defined password and if not, we will generate a random string, then hash that string using [Phalcon\Security](security) amd storing it in the `password` property. We also set the flag to change the password.

If the password is not empty, we just set the `mustChangePassword` field to `N`. Finally, we set some defaults on whether the user is `active`, `suspended` or `banned`. This ensures that our record is ready before it is inserted in the database.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function afterSave()
    {
        if ($this->getDI()->get('config')->useMail) {
            if ($this->active == 'N') {
                $emailConfirmation          = new EmailConfirmations();
                $emailConfirmation->usersId = $this->id;

                if ($emailConfirmation->save()) {
                    $this->getDI()
                         ->getFlash()
                         ->notice(
                            'A confirmation mail has ' .
                            'been sent to ' . $this->email
                        )
                    ;
                }
            }
        }
    }
}
```

The `afterSave` event fires right after a record is saved in the database. In this event we check if emails have been enabled (see `.env` file `useMail` setting), and if active we create a new record in the `EmailConfirmations` table and then save the record. Once everything is done, a notice will appear on screen.

> **NOTE**: Note that the `EmailConfirmations` model also has an `afterCreate` event, which is responsible for actually sending the email to the user.
{: .alert .alert=info }

**Валідація**

The model also has the `validate` method which allows us to attach a validator to any number of fields in our model. For the `Users` table, we need the `email` to be unique. As such, we attach the `Uniqueness` [validator](validation) to it. The validator will fire right before any save operation is performed on the model and the message will be returned back if the validation fails.

```php
<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * All the users registered in the application
 */
class Users extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email', 
            new Uniqueness(
                [
                    "message" => "The email is already registered",
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

## Підсумок

Vökuró is a sample application that we use to demonstrate some of the features that Phalcon offers. It is definitely not a solution that will fit all needs. However you can use it as a starting point to develop your application.

## References

- [Access Control Lists definition](https://en.wikipedia.org/wiki/Access-control_list)
- [Composer](https://getcomposer.org) 
- [DotEnv - Vance Lucas](https://github.com/vlucas/phpdotenv)
- [Model-View-Controller definition](https://en.wikipedia.org/wiki/Model–view–controller)
- [Nanobox Guides](https://guides.nanobox.io/php/)
- [Phinx - Cake PHP](https://github.com/cakephp/phinx)
- [PSR Extension](https://github.com/jbboehr/php-psr)
- [Swift Mailer](https://swiftmailer.symfony.com)
- [Phalcon ACL](acl)
- [Phalcon Forms](forms)
- [Phalcon HTTP Response](response)
- [Phalcon Security](security)
- [Vökuró - GitHub Repository](https://github.com/phalcon/vokuro)