<div class='article-menu'>
  <ul>
    <li>
      <a href="#basic">Tutorial - basic</a> <ul>
        <li>
          <a href="#file-structure">File structure</a>
        </li>
        <li>
          <a href="#bootstrap">Bootstrap</a> <ul>
            <li>
              <a href="#autoloaders">Autoloaders</a>
            </li>
            <li>
              <a href="#dependency-management">Dependency Management</a>
            </li>
            <li>
              <a href="#request">Handling the application request</a>
            </li>
            <li>
              <a href="#full-example">Putting everything together</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#controller">Creating a Controller</a>
        </li>
        <li>
          <a href="#view">Sending output to a view</a>
        </li>
        <li>
          <a href="#signup-form">Designing a sign up form</a>
        </li>
        <li>
          <a href="#model">Creating a Model</a>
        </li>
        <li>
          <a href="#database-connection">Setting a Database Connection</a>
        </li>
        <li>
          <a href="#storing-data">Storing data using models</a>
        </li>
        <li>
          <a href="#conclusion">Conclusion</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Tutorial - basic

در طول این اولین آموزش، ما شما را از طریق ایجاد یک برنامه با یک فرم ثبت نام ساده از ابتدا راه می اندازیم. ما همچنین جنبه های اصلی عملکرد چهارچوب را توضیح خواهیم داد. اگر شما علاقه مند به ابزار تولید خودکار کد برای فالکون هستید، می توانید را بررسی کنید[ابزار های توسعه دهنده](/[[language]]/[[version]]/developer-tools).

بهترین راه برای استفاده از این راهنما، دنبال کردن هر مرحله است. شما می توانید کد کامل را دریافت کنید [در اینجا](https://github.com/phalcon/tutorial).

<a name='file-structure'></a>

## File structure

فالکون یک ساختار فایل خاص را برای توسعه برنامه تحمیل نمی کند. با این اوصاف به آسانی می توانید برنامه های کاربردی فالکون را با ساختاری که راحت تر از آن استفاده می کنید را اجرا کنید.

برای اهداف این آموزش و به عنوان یک نقطه شروع، ما این ساختار بسیار ساده را پیشنهاد می کنیم:

```bash
آموزش /
   برنامه /
     کنترل کننده ها /
     مدل ها/
     نمایش ها /
   عمومی/
     سی اس اس/
     آی ام جی/
     جی اس/
```

توجه داشته باشید که شما به هیچ دایرکتوری "کتابخانه" مربوط به فالکون نیاز ندارید. چهارچوب موجود در حافظه، آماده است که شما از آن استفاده کنید.

قبل از ادامه دادن، لطفا از اینکه با [موفقیت فالکون را نصب کرده اید](/[[language]]/[[version]]/installation) و راه اندازی کرده اید مطمئن شوید [نگین ایکس](/[[language]]/[[version]]/setup#nginx)،[آپاچه](/[[language]]/[[version]]/setup#apache) یا [چروکی](/[[language]]/[[version]]/setup#cherokee).

<a name='bootstrap'></a>

## Bootstrap

فایل اولی که شما باید ایجاد کنید، فایل خودراه انداز است. این فایل بسیار مهم است؛ از آنجا که آن به عنوان اساس برنامه شما عمل می کند، به شما اجازه کنترل تمام بخش های آن را می دهد. در این فایل شما می توانید مقداردهی اولیه اجزا و همچنین تعیین عملکرد برنامه را انجام دهید.

در نهایت، 3 وظیفه مهم وجود دارد:

- راه اندازی بارگیری خودکار.
- پیکربندی ایجاد تزریق وابستگی.
- رسیدگی به درخواست برنامه.

<a name='autoloaders'></a>

### Autoloaders

بخش اول که ما در خودراه انداز می یابیم، ثبت کردن بارگیری خودکار است. بارگیری خودکار برای بارگذاری دسته ها به عنوان کنترلر و مدل در برنامه مورد استفاده قرار خواهد گرفت. برای مثال ما می توانیم جهت افزایش انعطاف پذیری یک یا چند دایرکتوری از کنترلرها را برنامه ثبت کنیم. در این مثال ما از مولفه استفاده می کنیم`فالکون/راه انداز`.

با استفاده از این، می توانیم دسته ها را با استفاده از استراتژی های مختلف بارگذاری کنیم اما برای این مثال ما تصمیم گرفتیم که قرارگیری دسته ها براساس دایرکتوری های پیش تعریف شده باشند:

```php
<?php

استفاده از فالکون/ راه انداز;

// ...

$loader = new Loader();

$loader->registerDirs(
[
'../app/controllers/',
'../app/models/',
]
);

$loader->register();
```

<a name='dependency-management'></a>

### Dependency Management

یک مفهوم بسیار مهم که باید در هنگام کار با فالکون شناخته شود `ظرفیت ایجاد وابستگی است <di>`. این ممکن است پیچیده باشد اما در واقع بسیار ساده و عملی است.

ظرف سرویس یک فضای انعطاف پذیر است که در آن ما سرویسهایی را که برنامه جهت عملیات استفاده خواهد کرد را در سطح جهانی ذخیره می کنیم. هر بار که چارچوب نیاز به یک مولفه داشته باشد، از ظرف استفاده یک نام توافقی برای سرویس درخواست خواهد کرد. از آنجا که فالکون یک چارچوب بسیار شفاف سازی شده است،`فالکون/دی`مانند چسب عمل می کند و به یک پارچگی مولفه های مختلف جهت انجام عملیات ترکیبی بصورت شفاف، کمک می کند.

```php
<?php

use Phalcon\Di\FactoryDefault;

// ...

// Create a DI
$di = new FactoryDefault();
```

`فالکون/دی/پیشفرض کارخانه`از یک نوع `فالکون/دی`. برای تسهیل در کار، بسیار از مولفه های کاربردی فالکون از قبل ثبت شده اند. بنابراین لازم نیست ما آنها را یک به یک ثبت کنیم. بعدها مشکلی در جایگزینی سرویس کارخانه وجود نخواهد داشت.

در بخش بعدی، ما سروی "نمایه" را ثبت می کنیم که نشان دهنده دایرکتوری است که در آن چارچوب فایل های قابل نمایش را پیدا می کند. همانطور که فایل های قابل نمایش با دسته ها مطابقت ندارند، با بارگیری خودکار قابل بارگذاری نیستند.

سرویس ها را می توان از چند راه ثبت کرد، اما برای آموزش، ما استفاده می کنیم از یک [تابع با نام مستعار](http://php.net/manual/en/functions.anonymous.php):

```php
<?php

use Phalcon\Mvc\View;

// ...

// تنظیم مولفه نمایش
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        return $view;
    }
);
```

ما یک URI اولیه را ثبت می کنیم و همه URI های ایجاد شده توسط فالکون در پوشه "آموزش" که قبل تر ایجاد کردیم قرار می گیرند. از این پس در این تمرین، زمانی که ما از دسته`فالکون/برچسب` برای ایجاد یک ابر پیوند استفاده کنیم مهم خواهد بود.

```php
<?php

use Phalcon\Mvc\Url as UrlProvider;

// ...

// راه اندازی یک URI پایه به طوری که تمام URI های ایجاد شده شامل پوشه "آموزش" است
$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/tutorial/');

        return $url;
    }
);
```

<a name='request'></a>

### Handling the application request

در قسمت آخر این فایل، ما را پیدا می کنیم`فالکون/ام وی سی/برنامه`. هدف آن این است که محیط درخواستی را مقدار دهی اولیه کرده، مسیر درخواست ورودی راه را تعیین و سپس هر گونه فعالیت شناسایی شده را مخابره نماید؛ هر پاسخی را جمع آوری می کند و زمانی که فرآیند کامل می شود، آنها را بازمی گرداند.

```php
<?php

use Phalcon\Mvc\Application;

// ...

$application = new Application($di);

$response = $application->handle();

$response->send();
```

<a name='full-example'></a>

### Putting everything together

فایل `آموزش/عمومی/فهرست`باید به این شکل باشد:

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
[
'../app/controllers/',
'../app/models/',
]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Setup the view component
$di->set(
'view',
function () {
$view = new View();

$view->setViewsDir('../app/views/');

return $view;
}
);

// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
'url',
function () {
$url = new UrlProvider();

$url->setBaseUri('/tutorial/');

return $url;
}
);

$application = new Application($di);

try {
// Handle the request
$response = $application->handle();

$response->send();
} catch (\Exception $e) {
echo 'Exception: ', $e->getMessage();
}
```

همانطور که می بینید، فایل خد راه انداز بسیار کوتاه است و ما نیازی به اضافه کردن هیچ فایل دیگری نداریم. ما یک برنامه ام وی سی انعطاف پذیر در کمتر از 30 خط کد برای خود تنظیم کرده ایم.

<a name='controller'></a>

## Creating a Controller

به طور پیش فرض فالکون یک کنترلربا نام شاخص را جستجو می کند. این نقطه آغاز است که هیچ کنترلریا عملی درخواست نشده است. کنترلرشاخص(`برنامه/کنترل کننده/کنترل کننده شاخص`)به این شکل است:

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Hello!</h1>';
    }
}
```

دسته کنترلرباید پسوند "کنترل کننده" داشته باشد و دسته اقدامات کنترلر باید پسوند "عمل" داشته باشد. اگر از مرورگر خود به برنامه دسترسی داشته باشید، باید چیزی شبیه به این را ببینید:

![](/images/content/tutorial-basic-1.png)

تبریک می گوییم، شما با فالکون همکاری می کنید!

<a name='view'></a>

## Sending output to a view

در مواقع ضروری خروجی از کنترلر به صفحه نمایش ارسال می شود، اما این مطلوب نیست، زیرا بیشتر متخصصان در انجمن ام وی سی این را تایید می کنند. داده نمایه های ورودی باعث ایجاد داده های خروجی که در صفحه نمایش هستند می شوند. فالکون یک نمایه با همان نام با عنوان آخرین عمل انجام شده در داخل یک پوشه به نام آخرین کنترل انجام شده، را جستجو می کند. در مورد ما (`app/views/index/index.phtml`):

```php
<?php echo "<h1>Hello!</h1>";
```

کنترلر ما (`app/controllers/IndexController.php`) در حال حاضر یک تعریف عمل تهی دارد:

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

خروجی مرورگر باید همانطور باقی بماند. `فالکون/ام وی سی/نمایش`مولفه های ثابت هنگامی که اجرای عملیات به پایان رسید، به طور خودکار ایجاد می شوند. درباره استفاده از `نمایه ها در اینجا بیشتر بدانید<views>`.

<a name='signup-form'></a>

## Designing a sign up form

حالا ما فایل نمایه `شاخص.پی اچ تی ام ال` را تغییر خواهیم داد تا یک پیوند به یک کنترلر جدید با نام "ثبت نام" اضافه کنیم. هدف این است که کاربران اجازه ثبت نام در برنامه خود را داشته باشند.

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    "signup",
    "Sign Up Here!"
);
```

کد اچ تی ام التولید شده نشان دهنده تگ اچ تی ام ال "a" است که به یک کنترلر جدید مرتبط است:

```html
<h1>سلام</h1>

<a href="/tutorial/signup">اینجا ثبت نام کنید</a>
```

برای تولید تگ، ما از دسته استفاده می کنیم`فالکون/تگ`. این یک دسته ابزار است که ما را قادر به ساخت تگ های اچ تی ام ال با قوانین چارچوب می کند. زیرا این دسته نیز یک سرویس ثبت شده در دی ای است، که ما از `$this->tag`برای دسترسی به آن استفاده می کنیم.

یک مقاله مفصل در مورد نسل اچ تی ام ال می تواند باشد :doc: `یافت شد <tags>`.

![](/images/content/tutorial-basic-2.png)

اینجا کنترل کننده ثبت نام است (`app/controllers/SignupController.php`):

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

عملکردهای بی نتیجه، گذرگاه پاکسازی شده خالی را برای یک نمایه ی تعیین فرم شده می دهد (`app/views/signup/index.phtml`):

```php
<h2>
   با استفاده از این فرم ثبت نام کنید
</h2>

<?php echo $this->tag->form("signup/register"); ?>

<p>
<label for="name">
Name
</label>

<?php echo $this->tag->textField("name"); ?>
</p>

<p>
<label for="email">
E-Mail
</label>

<?php echo $this->tag->textField("email"); ?>
</p>



<p>
<?php echo $this->tag->submitButton("Register"); ?>
</p>

</form>
```

مشاهده فرم در مرورگر شما چیزی شبیه به این را نشان می دهد:

![](/images/content/tutorial-basic-3.png)

`فالکون/تگ`همچنین روش های مفید برای ساخت عناصر فرم را فراهم می کند.

روش :code: `فالکون/تگ::فرم()`تنها یک پارامتر به عنوان مثال، نسبی یو ار ای به کنترل کننده/اقدام در برنامه را دریافت می کند.

با کلیک کردن بر روی دکمه "ارسال"، شما یک استثنا را در چارچوب متوجه خواهید شد، و آن اینست که ما عملیات "ثبت نام" را در کنترلر "ثبت نام" نداریم. فایل `عمومی/شاخص` ما این استثنا را سبب می شود:

```bash
Exception: Action "register" was not found on handler "signup"
```

پیاده سازی این روش، استثنا را حذف خواهد کرد:

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

اگر دوباره روی "ارسال" کلیک کنید، یک صفحه خالی خواهید دید. نام و ایمیل ورودی ارائه شده توسط کاربر باید در پایگاه داده ها ذخیره شود. با توجه به دستورالعمل ام وی سی، تعاملات پایگاه داده باید از طریق مدل ها انجام شود تا از پاک شدن کد شی گرا اطمینان حاصل شود.

<a name='model'></a>

## Creating a Model

فالکون نخستین ارم برای پی اچ پی را به طور کامل در زبان سی به ارمغان می آورد. به جای افزایش پیچیدگی سیر تکاملی، آن را ساده می کند.

قبل از ایجاد اولین مدل ما، ما نیاز به ایجاد جدول پایگاه داده خارج از فالکون برای نقشه برداری آن. یک جدول ساده برای ذخیره کاربران ثبت شده می تواند به این صورت تعریف شود:

```sql
CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `name`  varchar(70)          NOT NULL,
    `email` varchar(70)          NOT NULL,

    PRIMARY KEY (`id`)
);
```

یک مدل باید در دایرکتوری `برنامه/مدلها`دایرکتوری (`برنامه/مدلها/کاربران`) قرار گیرد. این مدل به جدول "کاربران" می پردازد:

```php
<?پی اچ پی

استفاده از فالکون/ام وی سی/مدل;

کاربران کلاس، مدل را گسترش می دهند
{
    عمومی$id;

    عمومی$name;

    عمومی$email;
}
```

<a name='database-connection'></a>

## Setting a Database Connection

برای اینکه قادر به استفاده از یک اتصال به پایگاه داده و سپس دسترسی به داده ها از طریق مدل های ما باشیم، باید آن را در فرایند راه انداز مان مشخص کنیم. یک اتصال پایگاه داده فقط سرویس دیگری است که برنامه ما می تواند آن را برای چندین قسمت استفاده کند:

```php
<?پی اچ پی

استفاده از فالکون/دی بی/ آداپتور/پی دی ا/مای اسکیو ال به عنوان دیبی اداپتور;

// راه اندازی سرویس پایگاه داده
$di->قراردادن(
    'db',
    تابع() {
      بازگشت دی بی جدید(
            [
                'میزبان'     => 'میزبان محلی',
                'نام کاریری' => 'ریشه',
                'گذرواژه' => 'مخفی',
                'دی بی نام'   => 'تست_دی بی',
            ]
        );
    }
);
```

با پارامترهای پایگاه داده صحیح، مدل ما آماده کار و تعامل با بقیه برنامه است.

<a name='storing-data'></a>

## Storing data using models

دریافت اطلاعات از فرم و ذخیره آنها در جدول مرحله بعدی است.

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

        // Store and check for errors
        $success = $user->save(
            $this->request->getPost(),
            [
                "name",
                "email",
            ]
        );

        if ($success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

سپس ما دسته کاربران را که مربوط به سابقه یک کاربر است را ایجاد می کنیم. خواص عمومی دسته به فیلدهای سابقه در جدول کاربران می پردازد. تنظیمات مقادیر مربوط به سابقه جدید و تماس های `ذخیره شده()` بعنوان داده در پایگاه داده ها برای آن سابقه ذخیره خواهد شد. روش `ذخیره()` یک مقدار بولین درست یا غلط را نشان می دهد که نشان دهنده اینست که آیا ذخیره سازی داده موفق بوده یا خیر.

ارم به طور خودکار ورودی را بعلت پیشگیری از تزریق اسکیوال خارج میکند بنابراین ما فقط باید درخواست را به روش`ذخیره() `منتقل کنیم.

اطلاعاتی که باید وارد شوند به طور خودکار در فیلدهایی که به عنوان (مورد نیاز) تعریف شده است قرار می گیرد. اگر ما به هر کدام از فیلدهای مورد نیاز در فرم ثبت نام وارد نشویم، صفحه نمایش ما اینگونه خواهد بود:

![](/images/content/tutorial-basic-4.png)

<a name='conclusion'></a>

## Conclusion

این یک آموزش بسیار ساده است و همانطور که می بینید، ساختن یک برنامه با استفاده از فالکون آسان است. واقعیت این است که فالکون یک افزونه در وب سرور شماست که با سهولت توسعه یا ویژگی های موجود تداخل ندارد. از شما دعوت می کنیم که به خواندن این کتاب ادامه دهید تا بتوانید ویژگی های اضافی ارائه شده توسط فالکون را بیابید!