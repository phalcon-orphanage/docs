访问控制列表 ACL（Access Control Lists ACL）
============================================

Phalcon在权限方面通过 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` 提供了一个轻量级的 ACL(访问控制列表). `Access Control Lists`_ (ACL)
允许系统对用户的访问权限进行控制，比如允许访问某些资源而不允许访问其它资源等。 这里我们建议开发者了解一些关于ACL的技术。

ACL有两部分组成即角色和资源。 资源即是ACL定义的权限所依附的对象。 角色即是ACL所字义的请求者的身份，ACL决定了角色对资源的访问权限，允许访问或拒绝访问。

创建 ACL（Creating an ACL）
---------------------------
这个组件起先是设计工作在内存中的， 这样做提供了更高的访问速度。 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` 构造器的第一个参数用于设置取得ACL的方式。 下面是使用内存适配器的例子：

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

默认情况下 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` 允许我们访问未定义的资源中的action，为了提高安全性， 我们设置默认访问级别为‘拒绝’。

.. code-block:: php

    <?php

    // 设置默认访问级别为拒绝
    $acl->setDefaultAction(Phalcon\Acl::DENY);

添加角色（Adding Roles to the ACL）
---------------------------------------
角色即是权限的集合体，其中定义了我们对资源的访问权限。 例如， 我们会把一个组织内的不同的人定义为不同的角色。 The :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`
类使用一种更有组织的方式来定义角色。 这里我们创建一些角色：

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // 创建角色
    // The first parameter is the name, the second parameter is an optional description.
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // 添加 "Guests" 角色到ACL
    $acl->addRole($roleGuests);

    // 添加"Designers"到ACL, 仅使用此字符串。
    $acl->addRole("Designers");

上面我们看到，我们可以直接使用字符串来定义角色。

添加资源（Adding Resources）
----------------------------
资源即是访问控制要控制的对象之一。 正常情况下在mvc中资源一般是控制器。 Phalcon中我们使用 :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` 来定义资源。
非常重要的一点即是我们把相关的action或操作添加到资源中这样ACL才知道控制什么资源。

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // 定义 "Customers" 资源
    $customersResource = new Resource("Customers");

    // 为 "customers"资源添加一组操作
    $acl->addResource($customersResource, "search");
    $acl->addResource($customersResource, array("create", "update"));

定义访问控制（Defining Access Controls）
----------------------------------------
至此我们定义了角色及资源， 现在是定义ACL的时候了，即是定义角色对资源的访问。 这个部分是极其重要的，特别是在我们设定了默认的访问级别后。

.. code-block:: php

    <?php

    // 设置角色对资源的访问级别
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

allow()方法指定了允许角色对资源的访问， deny()方法则反之。

查询 ACL（Querying an ACL）
---------------------------
一旦访问控制表定义之后， 我们就可以通过它来检查角色是否有访问权限了。

.. code-block:: php

    <?php

    // 查询角色是否有访问权限
    $acl->isAllowed("Guests", "Customers", "edit");   // Returns 0
    $acl->isAllowed("Guests", "Customers", "search"); // Returns 1
    $acl->isAllowed("Guests", "Customers", "create"); // Returns 1

角色继承（Roles Inheritance）
-----------------------------
我们可以使用 :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` 提供的继承机制来构造更复杂的角色。 Phalcon中的角色可以继承来自其它角色的
权限, 这样就可以实现更巧妙的资源访问控制。 如果要继承权限用户， 我们需要在添加角色函数的第二个参数中写上要继承的那个角色实例。

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // 创建角色
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // 添加 "Guests" 到 ACL
    $acl->addRole($roleGuests);

    // 使Administrators继承Guests的访问权限
    $acl->addRole($roleAdmins, $roleGuests);

序列化 ACL 列表（Serializing ACL lists）
------------------------------------------
为了提高性能， :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` 的实例可以被实例化到APC, session， 文本或数据库中， 这样开发者就不需要重复的
定义acl了。 下面展示了如何去做：

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // 检查ACL数据是否存在
    if (!is_file("app/security/acl.data")) {

        $acl = new AclList();

        // ... Define roles, resources, access, etc

        // 保存实例化的数据到文本文件中
        file_put_contents("app/security/acl.data", serialize($acl));
    } else {

         // 返序列化
         $acl = unserialize(file_get_contents("app/security/acl.data"));
    }

    // 使用ACL
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

It's recommended to use the Memory adapter during development and use one of the other adapters in production.

ACL 事件（ACL Events）
----------------------
如果需要的话 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` 可以发送事件到 :doc:`EventsManager <events>` 。 这里我们为acl绑定事件。
其中一些事件的处理结果如果返回了false则表示正在处理的操作会被中止。
支持如下的事件：

+-------------------+--------------------+--------------+
| 事件名            | 触发条件           | 能否中止操作 |
+===================+====================+==============+
| beforeCheckAccess | 在权限检查之前触发 | Yes          |
+-------------------+--------------------+--------------+
| afterCheckAccess  | 在权限检查之后触发 | No           |
+-------------------+--------------------+--------------+

下面的例子中展示了如何绑定事件到此组件：

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // 创建事件管理器
    $eventsManager = new EventsManager();

    // 绑定事件类型为acl
    $eventsManager->attach("acl", function ($event, $acl) {
        if ($event->getType() == "beforeCheckAccess") {
             echo   $acl->getActiveRole(),
                    $acl->getActiveResource(),
                    $acl->getActiveAccess();
        }
    });

    $acl = new AclList();

    // Setup the $acl
    // ...

    // 绑定eventsManager到ACL组件
    $acl->setEventsManager($eventManagers);

自定义适配器（Implementing your own adapters）
----------------------------------------------
开发者要创建自己的扩展或已存在适配器则需要实现此 :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` 接口。

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
