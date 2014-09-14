Abstract class **Phalcon\\Acl**
===============================

这个组件允许你管理访问控制列表(ACL)，ACL是一个被赋予权限对象的列表。ACL可以指定哪个用户或者系统进程授权访问权限对象，也可以授权授权访问其他选项。  
（译者注：翻译得有点拗口，简单点说，这个主要是做权限控制用的，一般用于admin后台不同角色、用户的权限管理）  

.. code-block:: php

    <?php

    //创建ACL对象
    $acl = new Phalcon\Acl\Adapter\Memory();

    //设置默认是拒绝访问的规则
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    //创建一些角色
    $roleAdmins = new Phalcon\Acl\Role('Administrators', 'Super-User role');
    $roleGuests = new Phalcon\Acl\Role('Guests');

    //把"Guests"角色添加到ACL中
    $acl->addRole($roleGuests);

    //添加"Designers"角色到ACL中
    $acl->addRole('Designers');

    //定义"Customers"资源
    $customersResource = new Phalcon\Acl\Resource('Customers', 'Customers management');

    //把"Customers"资源的search、create、update操作添加到ACL
    $acl->addResource($customersResource, 'search');
    $acl->addResource($customersResource, array('create', 'update'));

    //设置哪些角色可以访问对应的操作
    $acl->allow('Guests', 'Customers', 'search');
    $acl->allow('Guests', 'Customers', 'create');
    $acl->deny('Guests', 'Customers', 'update');

    //判断角色是否被授权访问指定资源的操作
    $acl->isAllowed('Guests', 'Customers', 'edit'); //Returns 0
    $acl->isAllowed('Guests', 'Customers', 'search'); //Returns 1
    $acl->isAllowed('Guests', 'Customers', 'create'); //Returns 1



常量(Constants)
---------

*integer* **ALLOW**

*integer* **DENY**

