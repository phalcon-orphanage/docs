过滤与清理（Filtering and Sanitizing）
======================================

清理用户输入是软件开发中很重要的一个环节。信任或者忽略对用户输入数据作清理可能会导致
对应用内容（主要是用户数据），甚至你应用所处在的服务器的非法访问。

.. figure:: ../_static/img/sql.png
   :align: center

`Full image (from xkcd)`_

此 :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` 组件提供了一系列通用可用的过滤器和数据清理助手。它提供了围绕于PHP过滤扩展的面向对象包装。

内置过滤器类型（Types of Built-in Filters）
-------------------------------------------
以下是该容器提供的内置过滤器：

+-----------+---------------------------------------------------------------------------+
| 名称      | 描述                                                                      |
+===========+===========================================================================+
| string    | 去除标签和HTML实体,包括单双引号                                           |
+-----------+---------------------------------------------------------------------------+
| email     | 删掉除字母、数字和 !#$%&*+-/=?^_`{\|}~@.[] 外的全部字符                   |
+-----------+---------------------------------------------------------------------------+
| int       | 删掉除R数字、加号、减号外的全部字符                                       |
+-----------+---------------------------------------------------------------------------+
| float     | 删掉除数字、点号和加号、减号外的全部字符                                  |
+-----------+---------------------------------------------------------------------------+
| alphanum  | 删掉除[a-zA-Z0-9]外的全部字符                                             |
+-----------+---------------------------------------------------------------------------+
| striptags | 调用 strip_tags_ 方法                                                     |
+-----------+---------------------------------------------------------------------------+
| trim      | 调用 trim_  方法                                                          |
+-----------+---------------------------------------------------------------------------+
| lower     | 调用 strtolower_ 方法                                                     |
+-----------+---------------------------------------------------------------------------+
| upper     | 调用 strtoupper_  方法                                                    |
+-----------+---------------------------------------------------------------------------+

清理数据（Sanitizing data）
---------------------------
清理是指从一个值中移除特定字符的过程，此过程对用户和应用不是必须，也不是他们想得到的。
通过清理输入，我们确保了应用的完整性和正确性。

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // 返回 "someone@example.com"
    $filter->sanitize("some(one)@exa\mple.com", "email");

    // 返回 "hello"
    $filter->sanitize("hello<<", "string");

    // 返回 "100019"
    $filter->sanitize("!100a019", "int");

    // 返回 "100019.01"
    $filter->sanitize("!100a019.01a", "float");


在控制器中使用清理（Sanitizing from Controllers）
-------------------------------------------------
当接收到GET或POST的数据时（通过请求对象），你可以在控制器中访问一个 :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` 对象。
第一个参数是等待获得变量的名字，第二个参数是将应用在此变量的过滤器。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // 从输入中清理price
            $price = $this->request->getPost("price", "double");

            // 从输入中清理email
            $email = $this->request->getPost("customerEmail", "email");
        }
    }

过滤动作参数（Filtering Action Parameters）
-------------------------------------------
接下来的示例演示了在一个控制器的动作中如何清理动作的参数：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($productId)
        {
            $productId = $this->filter->sanitize($productId, "int");
        }
    }

过滤数据（Filtering data）
--------------------------
此外， :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` 也提供了可以进行删除或者修改输入数据以满足我们需要的格式的过滤器。

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // 返回 "Hello"
    $filter->sanitize("<h1>Hello</h1>", "striptags");

    // 返回 "Hello"
    $filter->sanitize("  Hello   ", "trim");

Combining Filters
-----------------
You can also run multiple filters on a string at the same time by passing an array of filter identifiers as the second parameter:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // 返回 "Hello"
    $filter->sanitize(
        "   <h1> Hello </h1>   ",
        [
            "striptags",
            "trim",
        ]
    );

创建过滤器（Creating your own Filters）
---------------------------------------
你可以将你自己的过滤器添加到 :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` 。过滤器的方法可以是匿名函数：

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // 使用匿名函数
    $filter->add(
        "md5",
        function ($value) {
            return preg_replace("/[^0-9a-f]/", "", $value);
        }
    );

    // 利用md5过滤器清理
    $filtered = $filter->sanitize($possibleMd5, "md5");

或者，如果你愿意，你可以在类中实现过滤器：

.. code-block:: php

    <?php

    use Phalcon\Filter;

    class IPv4Filter
    {
        public function filter($value)
        {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }
    }

    $filter = new Filter();

    // 使用对象
    $filter->add(
        "ipv4",
        new IPv4Filter()
    );

    // 利用"ipv4"过滤器清理
    $filteredIp = $filter->sanitize("127.0.0.1", "ipv4");

复杂的过滤与清理（Complex Sanitizing and Filtering）
----------------------------------------------------
你可以使用PHP本身提供的优秀过滤器扩展。请查看对应的文档： `PHP文档上的数据过滤器`_

自定义过滤器（Implementing your own Filter）
--------------------------------------------
如需创建你自己的过滤器并代替Phalcon提供的过滤器，你需要实现 :doc:`Phalcon\\FilterInterface <../api/Phalcon_FilterInterface>` 接口。

.. _Full image (from xkcd): http://xkcd.com/327/
.. _PHP文档上的数据过滤器: http://www.php.net/manual/en/book.filter.php
.. _strip_tags: http://www.php.net/manual/en/function.strip-tags.php
.. _trim: http://www.php.net/manual/en/function.trim.php
.. _strtolower: http://www.php.net/manual/en/function.strtolower.php
.. _strtoupper: http://www.php.net/manual/en/function.strtoupper.php
