<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">حاشیه نویسی پارسر</a> 
      <ul>
        <li>
          <a href="#factory">کارخانه</a>
        </li>
        <li>
          <a href="#reading">خواندن حاشیه نویسی ها</a>
        </li>
        <li>
          <a href="#types">انواع حاشیه نویسی</a>
        </li>
        <li>
          <a href="#usage">کاربرد عملی</a> 
          <ul>
            <li>
              <a href="#usage-cache">مخزن توانمندساز با حاشیه نویسی</a>
            </li>
            <li>
              <a href="#usage-access-management">مناطق خصوصی/عمومی در حاشیه نویسی</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters">آداپتورهای حاشیه نویسی</a> 
          <ul>
            <li>
              <a href="#adapters-custom">پیاده سازی آداپتورهای خود را</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#resources">منابع خارجی</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# حاشیه نویسی پارسر

این اولین بار است که حاشیه نویسی پارسر در C در دنیای PHP نوشته می شود. `فالکون/حاشیه نویسی`یک مولفه هدف کلی است که سهولت تجزیه و ذخیره کردن در کلاس های PHP را برای استفاده شدن در نرم افزارها، مهیا می کند.

حاشیه نویسی از داک بلاک ها در کلاس ها، روش ها و مشخصات خوانده می شود. حاشیه نویسی می تواند در هر موقعیتی در داک بلاک قرار گیرد:

```php
<?php

/**
 * این توصیف کلاس است 
 *
 * کلاس شگفت انگیز (درست)
 */
مثال کلاس
{
    /**
      * این ملک با یک ویژگی خاص است
      *
     * @ویژگی خاص
      */
     $someProperty محافظت شده است

     /**
      * این یک روش است
      *
      *@ویژگی خاص
      */
     تابع عمومی someMethod()
     {
         // ...
    }
}
```

حاشیه نویسی دارای نحو زیر است:

```php
/**
 * @حاشیه-نویسی نام
 * @حاشیه نویسی نام (پارامتر 1، پارامتر 2، ...)
 */
```

موقعیتی در داک بلاک قرار گیرد:

```php
<?php

/**
 *
 * ویژگی خاص@
 *
 * نظرات بیشتر
 *
 * ویژگی ویژه دیگر@ (درست)
 */
```

تجزیه کننده بسیار انعطاف پذیر است، مستند بلوک زیر معتبر است:

```php
<?php

/**
 * This a property with a special feature @SpecialFeature({
someParameter='the value', false

 })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

با این حال، برای ایجاد یک کد قابل اطمینان تر و قابل درک تر توصیه می شود که حاشیه نویسی را در انتهای مستند بلاک قرار دهید:

```php
<?php

/**
  * این ملک با یک ویژگی خاص است
  * نظرات بیشتر
  *
  * ویژگی ویژه@({برخی پارامتر = 'مقدار'، اشتباه})
  * ویژگی ویژه دیگر@(واقعی)
  */
```

<a name='factory'></a>

## کارخانه

آداپتورهای حاشیه نویسی زیادی در دسترس هستند (به [آداپتورها](#adapters)مراجعه کنید). چیزی که شما استفاده می کنید بستگی به نیازهای نرم افزارتان دارد. روش سنتی نمونه سازی چنین آداپتوری به شرح زیر است:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// .....
```

با این وجود شما می توانید از روش کارخانه برای دستیابی به همان کار استفاده کنید:

```php
<?php


use Phalcon\Annotations\Factory;

$options = [
    'prefix'   => 'annotations',
    'lifetime' => '3600',
    'adapter'  => 'memory',      // Load the Memory adapter
];

$annotations = Factory::load($options);
```

لودر کارخانه انعطاف پذیری بیشتری هنگام نمونه سازی آداپتورهای حاشیه نویسی از فایل های پیکربندی فراهم می کند.

<a name='reading'></a>

## خواندن حاشیه نویسی ها

بازتاب به منظور دریافت حاشیه نویسی های تعریف شده در یک کلاسی که از واسط شیء محور استفاده می کند به کار گرفته می شود:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// Reflect the annotations in the class Example
$reflector = $reader->get('Example');

// Read the annotations in the class' docblock
$annotations = $reflector->getClassAnnotations();

// Traverse the annotations
foreach ($annotations as $annotation) {
    // Print the annotation name
    echo $annotation->getName(), PHP_EOL;

    // Print the number of arguments
    echo $annotation->numberArguments(), PHP_EOL;

    // Print the arguments
    print_r($annotation->getArguments());
}
```

پروسه خواندن حاشیه نویسی بسیار سریع است، با این حال، به دلایل عملکردی توصیه می شود که حاشیه نویسی های تجزیه شده را با استفاده از یک آداپتور ذخیره کنید. آداپتورها حاشیه نویسی فرآوری شده را با اجتناب از نیاز تجزیه حاشیه نویسی دوباره و دوباره ذخیره می کنند.

`فالکن/حاشیه نویسی/آداپتور/حافظه`در مثال بالا استفاده شده بود. این آداپتور تنها زمانیکه درخواست، در حال اجرا است، حاشیه نویسی را ذخیره می کند و به همین دلیل، این آداپتور برای توسعه مناسب تر است. برای مبادله کردن به خارج، هنگامیکه نرم افزار در مرحله ی تولید است، آداپتورهای دیگری وجود دارد.

<a name='types'></a>

## انواع حاشیه نویسی

حاشیه نویسی ها ممکن است پارامتر داشته باشند و یا نداشته باشند. پارامتر می تواند یک معنی اصلی ساده (رشته ها، اعداد، بولین، تهی) ، یک آرایه، یک لیست درهم و یا حاشیه نویسی دیگر باشد:

```php
<?php

/**
 * Simple Annotation
 *
 * @SomeAnnotation
 */

/**
 * Annotation with parameters
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Annotation with named parameters
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Passing an array
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Passing a hash as parameter
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Nested arrays/hashes
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Nested Annotations
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

<a name='usage'></a>

## کاربرد عملی

بعدا، مثال های کاربردی از حاشیه نویسی در نرم افزارهای PHP را توضیح خواهیم داد:

<a name='usage-cache'></a>

### مخزن توانمندساز با حاشیه نویسی

بیایید وانمود کنیم که واپای زیر را ایجاد کرده ایم و شما می خواهید یک پلاگین ایجاد کنید که اگر آخرین اقدام انجام شده قابل ذخیره باشد، ذخیره سازی را به صورت خودکار شروع کند. اول از همه، ما یک پلاگین را در خدمات نمایندگی ثبت می کنیم تا وقتی یک مسیر اجرا می شود، مطلع شود:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // Attach the plugin to 'dispatch' events
    $eventsManager->attach(
        'dispatch',
        new CacheEnablerPlugin()
    );

    $dispatcher = new MvcDispatcher();

    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};
```

`مخزن پلاگین فعال` یک پلاگین است که هر عملی را که در توزیع کننده امکاناتی، که اگر نیاز باشد عمل ذخیره سازی را فعال می کند، متوقف می سازد:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

/**
 * Enables the cache for a view if the latest
 * executed action has the annotation @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * This event is executed before every route is executed in the dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Parse the annotations in the method currently executed
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Check if the method has an annotation 'Cache'
        if ($annotations->has('Cache')) {
            // The method has the annotation 'Cache'
            $annotation = $annotations->get('Cache');

            // Get the lifetime
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Check if there is a user defined cache key
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Enable the cache for the current method
            $this->view->cache($options);
        }
    }
}
```

حالا می توانیم حاشیه نویسی را در یک واپا استفاده کنیم:

```php
<?php

use Phalcon\Mvc\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {

    }

    /**
     * This is a comment
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * This is a comment
     *
     * @Cache(key='my-key', lifetime=86400)
     */
    public function showAction($slug)
    {
        $this->view->article = Articles::findFirstByTitle($slug);
    }
}
```

<a name='usage-access-management'></a>

### مناطق خصوصی/عمومی در حاشیه نویسی

شما می توانید از حاشیه نویسی برای اینکه به ACL اطلاع دهید کدام واپاها به مناطق اجرایی تعلق دارند، استفاده کنید:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Possible controller class name
        $controllerName = $dispatcher->getControllerClass();

        // Possible method name
        $actionName = $dispatcher->getActiveMethod();

        // Get annotations in the controller class
        $annotations = $this->annotations->get($controllerName);

        // The controller is private?
        اگر ($annotations->getClassAnnotations()->has('Private')) {
            // بررسی کنید آیا متغیر جلسه فعال است?
            if (!$this->session->get('auth')) {

                // The user is no logged redirect to login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Continue normally
        return true;
    }
}
```

<a name='adapters'></a>

## آداپتورهای حاشیه نویسی

این مولفه از آداپتورها برای ذخیره کردن یا ذخیره نکردن حاشیه نویسی تجزیه و پردازش شده استفاده می کند؛ بنابراین، توسعه عملکرد یا فراهم کردن امکانات برای توسعه/آزمایش:

| کلاس                                   | توضیحات                                                                                                                                                                                     |
| -------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `فالکون/حاشیه نویسی/آداپتور/حافظه`     | این حاشیه نویسی ها فقط در حافظه ذخیره می شوند. هنگامیکه درخواست پایان می یابد، نهانگاه با بارگذاری دوباره حاشیه نویسی در هر درخواست، پاکسازی می شود. این آداپتور برای مرحله توسعه مناسب است |
| `فالکون/حاشیه نویسی/آداپتور/فایل`      | حاشیه نویسی های تجزیه و پردازش شده به طور دائمی در فایل های PHP که عملکرد را توسعه می دهد، ذخیره می شوند. این آداپتور باید همراه با نهانگاه بایت کد استفاده شود.                            |
| `فالکون/حاشیه نویسی/آداپتور/ای پی سی`  | حاشیه نویسی های تجزیه و پردازش شده بطور دائمی در حافظه APC که عملکرد را توسعه می دهد، ذخیره می شوند. این یک آداپتور سریع است                                                                |
| `فالکون/حاشیه نویسی/آداپتور/مخزن ایکس` | حاشیه نویسی های پردازش شده بطور دائمی در مخزن ایکس که عملکرد را توسعه می دهد، ذخیره می شوند. این نیز یک آداپتور سریع می باشد                                                                |

<a name='adapters-custom'></a>

### پیاده سازی آداپتورهای خود را

واسط `فالکون/حاشیه نویسی/آداپتور رابط` باید به منظور ایجاد آداپتورهای حاشیه نویسی خود یا گسترش آنهایی که وجود دارند، اجرا شود.

<a name='resources'></a>

## منابع خارجی

* [آموزش: ایجاد یک مدل سفارشی آغازگر با استفاده از حاشیه نویسی](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)