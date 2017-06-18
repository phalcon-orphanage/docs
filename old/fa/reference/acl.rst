دسترسی به کنترل لیست ها Access Control Lists (ACL)
==========================

:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` یک مدیریت آسان و سبک از ACL  ها و همچنین مجوز اتصال به آنها را فراهم میکند .برای مثال یک یوزر به چه صفحات و کنترلر ها و اکشن هایی دسترسی داشته باشد و یک مدیر به چه بخش هایی. `Access Control Lists`_ (ACL)به برنامه اجازه میدهد تا دسترسی به محیط ها و ابجکت های اساسی را از طریق یک درخواست کنترل کند.شما تشویق می کنیم بیشتر در مورد روش ACL  مطالعه کنید تا بیشتر با مفاهیم آن اشنا شوید.

به طور خلاصه ACL  ها Role ها  و  Resources  رو دارند .  Resources ابجکت های هستند که  توسط ACL ها برای انها سطح دسترسی  تعریف شده را رعایت میکنند.

ساخت یک ACL
---------------
این کامپوننت طراحی شده تا ابندا در حافظه کار کند.این عمل سهولت استفاده و سرعت دسترسی به لیستی از هر خصوصیت را فراهم میکند..  :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` این سازنده به عنوان اولین پارامتر یک آدابتور برای بازیابی اطاعات مربوط به لیستی از کنترل ها است.به عنوان مثال استفاده از ادابتور حافظه به شرح زیر میباشد:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

به طور پیشفرض  :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` اجازه دسترسی به اکشن در  Resources را میدهد زیرا هنوز تعریف نشده است . برای افزایش سطح امنیتی لیست دسترسی ها ما میتوانیم یک ثابت  "Deny"  به عنوان سطح دسترسی پیشفرض تعریف کنیم.

.. code-block:: php

    <?php

    use Phalcon\Acl;

    // به طور پیشفرض دسترسی به اکشن "deny" است
    $acl->setDefaultAction(
        Acl::DENY
    );

اضافه کردن یک رول به ACL
-----------------------
یک Role یا یک Role یک ابجکت است در لیست دسترسی ها که میتواند یا نمیتواند اجازه دسترسی به Resource  خاصت را را پیدا کند.به عنوان مثال ، ما Role های به عنوان گروهی از مردم در سازمان را تعریف میکنیم .  The :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` این کلاس برای ساخت Role ها رول ها در یک روش ساختار یافته تر است.بیایید برخی از Role ها  را اضافه کنید به لیستی که اخیرا ساخته شده:

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ایجاد برخی از Role ها 
    // پارامتر اول نام Role ایجاد شده است و پارامتر دوم توضیحات ویژگی.
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // اضافه کردن روله "Guests" به ACL
    $acl->addRole($roleGuests);

    //  اضافه کردن یک روله "Designers" به ACL بدون کلاسه Phalcon\Acl\Role
    $acl->addRole("Designers");

همانطور که می بینید، نقشمستقیم و بدون استفاده یک نمونه تعریف شده است.

اضافه کردن Resource 
----------------
Resources ابجکت هایی هستند که با دسترسی ها کنترل میشوند . معمولا  Resources برنامه های Mvc به کنترل کننده مراجعه میکنند.اگر چه این اجباری نیست., :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource  این کلاس میتواند در تعریف  Resources استفاده شود . این مهم است که ACL بفهمد که هنگام اضافه کردن اقدامات مرتبط  یا عملیات یک Resource چه چیزی را باید کنترل کند.

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    //  تعریف Resource "Customers" 
    $customersResource = new Resource("Customers");

    // اضافه کردن Resource  "customers" با یک جفت عملیات

    $acl->addResource(
        $customersResource,
        "search"
    );

    $acl->addResource(
        $customersResource,
        [
            "create",
            "update",
        ]
    );

Defining Access Controls
------------------------
حالا که ما  Resources  و Role ها  را داریم زمان آن است که ACL رو تعریف کنیم . برای مثال کدام Role به کدام Resource دسترسی داشته باشد. قسمت بسیار مهم میباشد به ویژه اینکه سطح دسترسی پیشفرض خودش   "allow"  یا  "deny"در نظر گرفته است.

.. code-block:: php

    <?php

    // تنظیم کردن سطح دسترسی برای Role ها در منایع.

    $acl->allow("Guests", "Customers", "search");

    $acl->allow("Guests", "Customers", "create");

    $acl->deny("Guests", "Customers", "update");

:code:`allow()`   این متد تعیین میکند که یک Role خاصی به یک Resource اعطا گردیده است. :code:`deny()` این متد مخالف است.

Querying an ACL
---------------
هنگامی که فهرست به طور کامل تعریف شده است. ما می توانیم پرس و جو کنیم برسی کنیم اگر یک Role دارد اجازه بدهیم  یا نه.

.. code-block:: php

    <?php

    // بررسی کنید که آیا کاربر دسترسی به عملیات دارد

    // Returns 0
    $acl->isAllowed("Guests", "Customers", "edit");

    // Returns 1
    $acl->isAllowed("Guests", "Customers", "search");

    // Returns 1
    $acl->isAllowed("Guests", "Customers", "create");

دسترسی مبتنی بر عملکرد
---------------------
همچنین شما می توانید چهارمین  پارامتر را به تابع سفارشی خود اضافه کنید که باید یک مقدار بولین برگرداند.زمانی که میخواید ازش استفاده کنید متد :code:`isAllowed()`  را صدا بزنید. شما میتونید ان را به عنوان ارایه انجمنی با متد :code:`isAllowed()` رد کنید بع عنوان چهارمین آرگومان که کلیده پارامتر نام است در تابع تعریف شده.

.. code-block:: php

    <?php
    // سطح دسترسی را برای تابع سفارشی  با Role در  Resources تنظیم میکند .
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // بررسی میکند که آیا یک  Role دسترسی به عملیات با تابع سفارشی دارد.

    // بر میگرداند  true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 4,
        ]
    );

    // بر میگرداند  false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 3,
        ]
    );

اگر شما  ارائه ندهید هیچ پارامتری را در متد :code:`isAllowed()`  رفتار پیش فرض خواهد بود  :code:`Acl::ALLOW` و شما میتوانید ان را با متد :code:`setNoArgumentsDefaultAction()` تغییر بدهید.

.. code-block:: php

    use Phalcon\Acl;

    <?php
    // سطح دسترسی را برای تابع سفارشی  با Role در  Resources تنظیم میکند .
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // بررسی میکند که آیا یک  Role دسترسی به عملیات با تابع سفارشی دارد.

    // برمیگرداند  true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

    // تغییر دادن اقدام پیشفرض بدون ارگومان ها
    $acl->setNoArgumentsDefaultAction(
        Acl::DENY
    );

    // برگرداندن  false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

ابجکت ها مثل نام Role و نام Resource
--------------------------------------
شما میتوانید ابجکت ها را از تابع عبور بدید مثل :code:`roleName`  و  :code:`resourceName`  .باید پیاده سازی کنید کلاس های خودتان را  :doc:`Phalcon\\Acl\\RoleAware <../api/Phalcon_Acl_RoleAware>` برای  :code:`roleName` و :doc:`Phalcon\\Acl\\ResourceAware <../api/Phalcon_Acl_ResourceAware>` برای :code:`resourceName`  
  کلاس :code:`UserRole` مان

.. code-block:: php

    <?php

    use Phalcon\Acl\RoleAware;

    //کلاسی را که میخواهیم به عنوان roleName استفاده کنیم را ساختیم 
    class UserRole implements RoleAware
    {
        protected $id;

        protected $roleName;

        public function __construct($id, $roleName)
        {
            $this->id       = $id;
            $this->roleName = $roleName;
        }

        public function getId()
        {
            return $this->id;
        }

        // اجرا شدن تابع از طریق Role های ثبت شده 
        public function getRoleName()
        {
            return $this->roleName;
        }
    }

و کلاس کد ما  :code:`ModelResource`

.. code-block:: php

    <?php

    use Phalcon\Acl\ResourceAware;

    // ساخت کلاسی که میخواهیم از آن به عنوان resourceName استفاده کنیم
    class ModelResource implements ResourceAware
    {
        protected $id;

        protected $resourceName;

        protected $userId;

        public function __construct($id, $resourceName, $userId)
        {
            $this->id           = $id;
            $this->resourceName = $resourceName;
            $this->userId       = $userId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        // اجرا شدن تابع از طریق  Resources ثبت شده
        public function getResourceName()
        {
            return $this->resourceName;
        }
    }

سپس شما میتوانی از آن در تابع  :code:`isAllowed()` استفاده کنی.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // تنظیم کردن سطح دسترسی برای Role در Resource
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

    // ساختن ابجکت های فراهم شده  roleName و  resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // بررسی میکند آیا ابجکت user شما دسترسی به عملیات در ابجکت های model دارد

    //  برگرداندن  false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // برگرداندن  true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // برگرداندن  true
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

همچنین شما میتوانید به ان ابجکت در تابع سفارشی دسترسی داشته باشید. :code:`allow()`  یا  :code:`deny()`.
انها به طور اتوماتیک به پارامتر هایشان بر اساس تابع اتصال برقرار میکنند. 

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // سطح دسترسی را برای Role داخل Resource با تابع سفارشی تنظیم میکند  
    $acl->allow(
        "Guests",
        "Customers",
        "search",
// کلاس های  User و  Model ضروری هستند     function (UserRole $user, ModelResource $model) { 
            return $user->getId == $model->getUserId();
        }
    );

    $acl->allow(
        "Guests",
        "Customers",
        "create"
    );

    $acl->deny(
        "Guests",
        "Customers",
        "update"
    );

    // ساختن ابجکت های ارائه شدی roleName  و  resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // بررسی میکند که آیا یک  Role دسترسی به عملیات با تابع سفارشی دارد.

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns false
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

شما هنوز میتوانید هر پارامتر سفارشی را به تابع اضافه کنید و  عبور بدید ارایه انجمنی را در متد :code:`isAllowed()` اگرچه ترتیب مهم نیست.

Role ها  و وراثت 
-----------------
با استفاده از وراثت انها شما میتوانید Role های با ساختار پیچیده بسازید که:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`  ان را فراهم میکند . Role ها می توانند از Role های دیگر به ارث ببرند.به این ترتیب اجازه دسترسی به بالا شاخه ها و زیر شاخه ها را در Resource میدهد. با استفاده از وراثت Role و شما نیاز داری عبور بدهی نقشه به ارث برده را به عنوان دومین پارامتر از متد فراخوانی شده و زمانی که ان Role به لیست اضافه شد.
.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // ساخت بعضی Role ها

    $roleAdmins = new Role("Administrators", "Super-User role");

    $roleGuests = new Role("Guests");

    // Add "Guests" role to ACL
    $acl->addRole($roleGuests);

    // Add "Administrators" role inheriting from "Guests" its accesses
    $acl->addRole($roleAdmins, $roleGuests);

مرتب سازی لیست ACL
---------------------

به منظور بهبود عملکرد  :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` نمونه می توان مرتب شود و در APC  ، سشن ، فایل متنی ویا یک جدول پایگاه داده ذخیره شود.به طوری که آنها میتوانند اجرا شوند هر جا بدون اینکه نیاز به فراخانی دوباره داشته باشند در کل لیست.شما به صورت زیر میتوانید انجام بدهید :

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // بررسی میکند که آیا  اطلاعات ACL  وجود دارد
    if (!is_file("app/security/acl.data")) {
        $acl = new AclList();

        // ... تعریف  roles, resources, access, etc

        // ذخیره مرتب لیست به فایل ساده
        file_put_contents(
            "app/security/acl.data",
            serialize($acl)
        );
    } else {
        // بازیابی ابجکت های ACL از فایل های مرتب شده
        $acl = unserialize(
            file_get_contents("app/security/acl.data")
        );
    }

    // استفاده از لیست  ACL به عنوان نیاز
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

توصیه میشود در استفاده از Memory adapter در طول توسعه و استفاده از یکی از آداپتور های دیگر در تولیدات .

ACL Events
----------
 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` قادر به ارسال event به :doc:`EventsManager <events>` است اگر ان یک حاضر است. eventها هستند علت استفاده از این نو ع "Acl".بعضی از event ها  مقدار بولین false را بر میگردانند که میتواند عملیات فعال را متوقف کند.

+-------------------+---------------------------------------------------------+---------------------+
| Event Name        | Triggered                                               | Can stop operation? |
+===================+=========================================================+=====================+
| beforeCheckAccess | Triggered before checking if a role/resource has access | Yes                 |
+-------------------+---------------------------------------------------------+---------------------+
| afterCheckAccess  | Triggered after checking if a role/resource has access  | No                  |
+-------------------+---------------------------------------------------------+---------------------+

در مثال زیر نشان میدهد چطور شنوندگان به این بخش ضمیمه میشوند:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // درست کردن یک مدیر رویداد
    $eventsManager = new EventsManager();

// ضمیمه یک شنونده برای نوع "ACL"
    $eventsManager->attach(
        "acl:beforeCheckAccess",
        function (Event $event, $acl) {
            echo $acl->getActiveRole();

            echo $acl->getActiveResource();

            echo $acl->getActiveAccess();
        }
    );

    $acl = new AclList();

    // Setup the $acl
    // ...

    // اتصال eventsManager  به ACL پکیج
    $acl->setEventsManager($eventsManager);

اجرای آداپتورهای خود
------------------------------
The :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` interface must be implemented in order
to create your own ACL adapters or extend the existing ones.

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
