---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Посібник - основи'
keywords: 'tutorial, basic tutorial, step by step, mvc, посібник, навчання, основи, крок за кроком'
---

# Посібник - основи

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-beginner.svg)

## Огляд

В цьому посібнику ми створимо програму з простою реєстраційною формою, розкриваючи основні аспекти дизайну Phalcon.

Цей посібник охоплює реалізацію простого MVC додатку, показуючи, як швидко і легко це можна зробити за допомогою Phalcon. Після розробки ви можете скористатися цим додатком і розширити його для задоволення ваших потреб. Код в цьому посібнику також може використовуватися як майданчик для вивчення інших понять та ідей Phalcon. <iframe width="560" height="315" src="https://www.youtube.com/embed/75W-emM4wNQ" frameborder="0" allowfullscreen></iframe> 

Якщо ви хочете просто почати роботу, ви можете пропустити це і створити проект Phalcon автоматично за допомогою наших [інструментів розробника](devtools).

Найкращий спосіб використовувати цей посібник - вникнути в основи та спробувати насолодитись процесом. Ви можете отримати повний код [тут](https://github.com/phalcon/tutorial). Якщо ви зіткнулися з труднощами або маєте запитання, будь ласка звертайтеся до нас у [Discord](https://phalcon.io/discord) чи напишіть нам на нашому [форумі](https://phalcon.io/forum).

## Файлова структура

Однією з головних особливостей Phalcon є слабка зв'язаність. Через це ви можете використати будь-яку структуру каталогів, яка вам зручна. У цьому посібнику ми будемо використовувати *стандартну* структуру каталогів, що зазвичай використовується в MVC застосунках.

```text
.
└── tutorial
    ├── app
    │   ├── controllers
    │   │   ├── IndexController.php
    │   │   └── SignupController.php
    │   ├── models
    │   │   └── Users.php
    │   └── views
    └── public
        ├── css
        ├── img
        ├── index.php
        └── js
```

> **ПРИМІТКА**: Оскільки весь код, який пропонує Phalcon, зібрано у розширенні (яке ви завантажили на вашому веб-сервері), ви не побачите папку `vendor`, яка містить код Phalcon. Все, що вам потрібно, знаходиться в пам'яті. Якщо Ви ще не встановили розширення, перейдіть на сторінку [установка](installation) і завершіть встановлення перед тим, як продовжувати виконувати вказівки цього посібника.
{: .alert .alert-warning }

Якщо це все абсолютно нове для вас, рекомендується також встановити [Phalcon Devtools](devtools). DevTools доповнює вбудований веб-сервер PHP, що дозволяє вам запустити ваш продукт майже миттєво. Якщо ви виберете цю опцію, то вам знадобиться файл `.htrouter.php` в кореневому каталозі вашого проекту з наступним змістом:

```php
<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
```

У випадку цього посібника цей файл повинен знаходитися в каталозі `tutorial`.

Ви також можете використовувати nginX, apache, cherokee або інші веб-сервери. Ви можете відвідати [сторінку налаштування веб-сервера](webserver-setup) для отримання інструкцій.

## Bootstrap

Перший файл, який потрібно створити - це файл bootstrap. Цей файл працює як вхідна точка і базова конфігурація для вашого продукту. У цьому файлі можна реалізувати ініціалізацію компонентів, а також визначити поведінку програми.

Цей файл виконує три завдання:

- Реєстрація автозавантажувачів компонентів
- Налаштування сервісів та реєстрація їх у контейнері управління залежностями (Dependency Injection)
- Забезпечення виконання HTTP запитів вашого продукту

### Автозавантажувач

Ми збираємося використовувати [Phalcon\Loader](loader) як [PSR-4](https://www.php-fig.org/psr/psr-4/) сумісний завантажувач файлів. Загальні речі, які слід додати до автозавантажувача, це ваші контролери і моделі. Ви також можете зареєструвати каталоги, які будуть проскановані для пошуку файлів, необхідних вашій програмі.

Для початку, давайте зареєструємо каталоги `контролерів` нашої програми і `моделей`, за допомогою [Phalcon\Loader](loader):

`public/index.php`

```php
<?php

use Phalcon\Loader;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();
```

### Керування залежностями

Оскільки Phalcon є слабко зв'язаним, сервіси реєструються в менеджері залежностей фреймворка, тому вони можуть бути автоматично вставлені в компоненти і послуги, загорнуті в [IoC](https://en.wikipedia.org/wiki/Inversion_of_control) контейнер. Часто ви стикатиметесь з терміном DI, який означає впровадження залежностей (Dependency Injection). Впровадження залежностей та Інверсія контролю (IoC) можуть звучати складно, але Phalcon гарантує, що їх використання є простим, практичним та ефективним. Контейнер IoC Phalcon містить такі концепції:

- Сервіс-контейнер - "сховище", де ми зберігаємо сервіси, які наш продукт потребує для функціонування.
- Послуга або компонент - об'єкт обробки даних, який буде включено до компонентів

Кожен раз, коли фреймворк потребує компонента або послугу, він буде звертатися до контейнера використовуючи певне ім'я сервісу. Таким чином, ми маємо простий спосіб отримання об'єктів, необхідних для нашої програми, таких як логер, з'єднання бази даних і тощо.

> **ПРИМІТКА**: Якщо вас цікавлять деталі, то ознайомтесь із статтею [Мартіна Фавлера](https://martinfowler.com/articles/injection.html). Також ми маємо [чудовий посібник](di), що охоплює багато випадків використання.
{: .alert .alert-warning }

### Factory Default

[Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) є варіантом [Phalcon\Di](api/Phalcon_Di). Щоб спростити роботу, він автоматично зареєструє більшість компонентів, що необхідні для продукту та стандартно поставляється з Phalcon. Хоч і рекомендується налаштовувати служби вручну, ви можете використовувати [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) спочатку та пізніше налаштувати його відповідно до ваших потреб.

Сервіси можуть бути зареєстровані кількома способами, але для нашого посібника, ми будемо використовувати [анонімну функцію](https://php.net/manual/en/functions.anonymous.php):

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;

// Create a DI
$container = new FactoryDefault();
```

Тепер нам потрібно зареєструвати службу *view*, встановивши каталог, де фреймворк знайде файли подання. Оскільки представлення не належать до класів, вони не можуть бути автоматично завантажені нашим автозавантажувачем.

`public/index.php`

```php
<?php

use Phalcon\Mvc\View;

// ...

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);
```

Тепер нам потрібно зареєструвати базову URI, яка надасть можливість створення всіх URL-адрес за допомогою Phalcon. Цей компонент буде гарантувати, що якщо ви запускатимете програму через верхній каталог або підкаталог, всі ваші URI будуть правильними. Для цього навчального посібника наш базовий шлях є `/`. Це матиме значення пізніше у цьому посібнику, коли ми використовуватимемо клас `Phalcon\Tag` для генерування гіперпосилань.

`public/index.php`

```php
<?php

use Phalcon\Url;

// ...

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');

        return $url;
    }
);
```

### Обробка запитів додатка

Для того, щоб обробляти будь-які запити, використовуєтьс об'єкт [Phalcon\Mvc\Application](application), який виконує всі самі важкі завдання. Цей компонент прийме запит користувача, визначить шляхи, скоординує дії контролера та виведе візуальне подання результатів обробки запиту.

`public/index.php`

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($container);

$response = $application->handle(
    $_SERVER["REQUEST_URI"]
);

$response->send();
```

### А тепер зберемо все разом

Файл `tutorial/public/index.php` повинен виглядати так:

`public/index.php`

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;

// Визначимо деякі константи абсолютних шляхів, щоб забезпечити визначення розташування ресурсів
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Реєструємо автозавантажувач
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

try {
    // Опрацьовуємо запити
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
```

Як ви бачите, файл bootstrap дуже короткий і нам не потрібно включати до нього будь-які додаткові файли. Ви маєте змогу створити гнучкий MVC додаток менш ніж за 30 рядків коду.

## Створення контролера

За замовчуванням Phalcon буде шукати контролер з назвою `IndexController`. Це початкова точка, коли в запиті не було додано жодного контролера чи дії (наприклад, `https://localhost/`). `IndexController` та його `IndexAction` повинен бути схожим на такий приклад:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return '<h1>Привіт!</h1>';
    }
}
```

Класи контролера повинні містити суфікс `Controller`, а дії контролера повинні мати суфікс `Action`. Для отримання додаткової інформації ви можете прочитати наш документ про [контролери](controllers). Якщо ви спробуєте отримати досту до вашого продукта через браузер, то побачите щось на зразок цього:

![](/assets/images/content/tutorial-basic-1.png)

> **Вітаємо, ви літаєте із Phalcon!**
{: .alert .alert-info }

## Відправка результату до View

Виведення результату на екран безпосередньо з контролера часом потрібне, але не бажане, і це підтвердять більшість пуристів MVC спільноти. Всі результати мають передаватись компоненту view, який відповідальний за виведення інформації на екран. Phalcon шукатиме view з такою ж назвою, як і остання виконана дія, в папці з ім'ям контролера, якому така дія належить.

Таким чином, у нашому випадку якщо URL-адреса:

```php
http://localhost/
```

буде викликано `IndexController` і `indexAction`, який буде шукати подання:

```php
/views/index/index.phtml
```

Якщо такий файл існує, його буде зчитано і виведено результат на екран. Наш view в такому разі матиме вміст:

`app/views/index/index.phtml`

```php
<?php echo "<h1>Привіт!</h1>";
```

і оскільки ми перемістили `echo` з нашої дії контролера у подання, то дія буде порожньою:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

    }
}
```

Виведена браузером інформація не зміниться. Компонент `Phalcon\Mvc\View` автоматично створюється по завершенню виконання дії. Інформацію про подання у Phalcon ви можете почитати [тут](views).

## Створення форми реєстрації

Тепер ми змінимо файл подання `index.phtml`, щоб додати посилання на новий контролер з назвою *signup*. Мета - дозволити користувачам зареєструватися у нашому додатку.

`app/views/index/index.phtml`

```php
<?php

echo "<h1>Привіт!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    'signup',
    'Зареєструватись тут!'
);
```

Згенерований HTML код показує посилання (`&lt;a&gt;</code), що веде до нового контролера:</p>

<p><code>app/views/index/index.phtml` (зчитано)

```html
<h1>Привіт!</h1>

<a href="/signup">Зареєструватись тут!</a>
```

Для створення посилання для тегу `<a>`, ми використовуємо компонент [Phalcon\Tag](tag). Це допоміжний інструмент, який пропонує простий спосіб побудови HTML-тегів з урахуванням правил фреймворку. Цей клас також є сервісом, зареєстрованим у Dependency Injector, тому ми можемо використовувати `$this->tag` для доступу до його функціональності.

> **ПРИМІТКА**: `Phalcon\Tag` вже зареєстрований у контейнері DI, оскільки ми використали `Phalcon\Di\FactoryDefault`. Якщо ви вирішили реєструвати усі сервіси самостійно, то потрібно зареєструвати у цьому контейнері кожен такий сервіс, щоб зробити його доступним у вашому продукті.
{: .alert .alert-info }

Компонент [Phalcon\Tag](tag) також використовує раніше зареєстрований [Phalcon\Uri](uri) компонент для правильного створення URI. Більш детальну статтю стосовно генерування HTML [можна знайти тут](tag).

![](/assets/images/content/tutorial-basic-2.png)

А контролер реєстрації - (`app/controllers/SignupController.php`):

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }
}
```

Порожня дія індексу забезпечує безпосередній перехід до файлу подання з визначенням форми (`app/views/signup/index.phtml`):

`app/views/signup/index.phtml`

```html
<h2> Зареєструйтесь, використовуючи цю форму</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Ім'я</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Зареєструватися"); ?>
    </p>

</form>
```

Перегляд форми у вашому браузері покаже наступне:

![](/assets/images/content/tutorial-basic-3.png)

Як зазначено вище, клас інструментів [Phalcon\Tag](tag) пропонує корисні методи, що дозволяють з легкістю створювати форми HTML-елементів. `Phalcon\Tag::form()` метод отримує лише один параметр - відносний URI до контролера/дії в додатку. `Phalcon\Tag::textField()` створює текстовий елемент HTML з іменем як переданим параметром, тоді як `Phalcon\Tag::submitButton()` створює HTML кнопку відправки даних форми.

Натискаючи кнопку *Зареєструватись*, ви отримаєте повідомлення від фреймворка про виняткову ситуацію, причиною якої є відсутність дії `register` у контролері `signup`. Наш `public/index.php` згенерує цей виняток:

```bash
Exception: Action "register" was not found on handler "signup"
```

Реалізація цього методу дозволить уникнути виняткової ситуації:

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {

    }
}
```

Тепер якщо ви знову натиснете кнопку *Зареєструватися*, то побачите чисту сторінку. Трохи пізніше ми додамо подання, що міститиме корисний відгук. Але спочатку ми маємо написати код для зберігання записів користувачів у базі даних.

Відповідно до рекомендацій MVC, взаємодії з базами даних повинні здійснюватися за допомогою моделей для гарантування чистого об'єктно-орієнтованого коду.

## Створення моделі

Phalcon пропонує перший ORM для PHP повністю написаний на мові C. Замість того, щоб підвищити складність розробки, він спрощує її.

Перед створенням нашої першої моделі, нам потрібно створити таблицю баз даних використовуючи інструмент доступу до бази даних або командний рядок бази даних. Для цього навчального посібника ми використовуємо MySQL як нашу базу даних. Просту таблицю для зберігання зареєстрованих користувачів можна створити наступним чином:

`create_users_table.sql`

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

Модель має розташовуватись у каталозі `app/models` (`app/models/Users.php`). Карта моделі для таблиці *users*:

`app/models/Users.php`

```php
<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
}
```

> **ПРИМІТКА**: Зверніть увагу на те, що публічні властивості моделі відповідають іменам полів у нашій таблиці. 
{: .alert .alert-info }

## Встановлення підключення до бази даних

Для того, щоб використовувати з'єднання з базою даних і за потреби отримати доступ до даних через наші моделі, ми повинні це визначити в нашому процесі завантаження. Зв'язок з базою даних - це ще один сервіс нашого додатка, який у ньому може використовуватися:

`public/index.php`

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

Змініть вищевказаний фрагмент коду відповідно до налаштувань доступу до вашої бази даних.

З правильними параметрами бази даних наша модель готова до взаємодії з рештою додатку і таким чином ми вже можемо зберегти записи користувача. Спочатку - давайте знайдемо хвилинку і створимо подання для `SignupController::registerAction()`, яке буде відображати повідомлення про результат операції *save*.

`app/views/signup/register.phtml`

```php
<div class="alert alert-<?php echo $success === true ? 'success' : 'danger'; ?>">
    <?php echo $message; ?>
</div>

<?php echo $this->tag->linkTo(['/', 'Назад на головну', 'class' => 'btn btn-primary']); ?>
```

Зауважте, що ми додали деякі CSS стилі в зазначений код. Ми розкриємо вміст таблиці стилів нижче у розділі [Оформлення](#styling).

## Зберігання даних за допомогою моделей

`app/controllers/SignupController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new Users();

        //присвоєння значень з форми змінній $user
        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        // Перевірка на наявність помилок та збереження
        $success = $user->save();

        // виведення результату для перегляду
        $this->view->success = $success;

        if ($success) {
            $message = "Дякуємо за реєстрацію!";
        } else {
            $message = "Вибачте, було ідентифіковано такі проблеми:<br>"
                     . implode('<br>', $user->getMessages());
        }

        // передача повідомлення поданню
        $this->view->message = $message;
    }
}
```

На початку `registerAction` ми створили порожній об'єкт користувача, використовуючи клас користувачів `Users`, який ми створили раніше. Ми будемо використовувати цей клас для керування записами користувача. Як було зазначено вище, публічні властивості класу ведуть до полів таблиці `users` у нашій базі даних. Вставлення відповідних значень до нового запису і виклик `save()` збереже дані цього запису у базі даних. Метод `save()` повертає значення `boolean`, яке сигналізує про успіх чи невдачу операції збереження.

ORM автоматично обріже записи, аби уникнути SQL ін'єкцій, тому нам потрібно лише передати запит методу `save()`.

Додаткова перевірка відбувається автоматично в усіх полях, що визначені як не null (обов’язкові). Якщо ми не заповнимо жодного з обов'язкових полів у реєстраційній формі, наш екран виглядатиме схоже на це:

![](/assets/images/content/tutorial-basic-4.png)

## Список зареєстрованих користувачів

Тепер нам потрібно буде відобразити всіх зареєстрованих користувачів у нашій базі даних

Перше, що ми зробимо в `indexAction` контролера `IndexController` - це показати результат пошуку всіх користувачів, що робиться просто шляхом виклику статичного методу `find()` в нашій моделі (`Users::find()`).

`indexAction` буде змінено так:

`app/controllers/IndexController.php`

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    /**
     * Вітання та список користувачів
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
}
```

> **ПРИМІТКА**: Ми присвоюємо результат операції `find` магічній властивості об'єкта `view`. Це вставляє у цю змінну присвоєні їй дані та робить їх доступними у нашому поданні
{: .alert .alert-info } 

У нашому файлі подання `views/index/index.phtml` ми можемо використовувати змінну `$users` так:

Ураховуючи все вищезазначене, наше подання виглядатиме приблизно так:

`views/index/index.phtml`

```html
<?php

echo "<h1>Привіт!</h1>";

echo $this->tag->linkTo(["signup", "Зареєструватися!", 'class' => 'btn btn-primary']);

if ($users->count() > 0) {
    ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
        <tr>
            <th>N п/п</th>
            <th>Ім'я</th>
            <th>Email</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3"> Кількість користувачів: <?php echo $users->count(); ?></td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->email; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
```

As you can see our variable `$users` can be iterated and counted. Ви можете отримати більше інформації про те, як функціонують моделі, в нашому документі про [моделі](db-models).

![](/assets/images/content/tutorial-basic-5.png)

## Оформлення

Тепер ми можемо трохи покращити зовнішній вигляд нашої програми. Ми можемо додати [Bootstrap CSS](https://getbootstrap.com/) у наш код для того, щоб він використовувався на наших поданнях. Ми додамо файл `index.phtml` до теки`views` з таким змістом:

`app/views/index.phtml`

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Посібник Phalcon</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php echo $this->getContent(); ?>
</div>
</body>
</html>
```

У наведеному вище шаблоні найважливіший рядок це виклик метода `getContent()`. Цей метод повертає весь вміст, створений нашим поданням. Тепер наш додаток показуватиме:

![](/assets/images/content/tutorial-basic-6.png)

## Підсумок

Як бачите, почати будувати застосунок за допомогою Phalcon досить просто. Оскільки Phalcon це розширення, завантажене в пам'ять, обсяг коду вашого проекту буде мінімальним, тоді як вам сподобається гарний приріст продуктивності.

Якщо ви готові ще більше дізнатися, то перейдіть далі до [Посібника Vökuró](tutorial-vokuro).
