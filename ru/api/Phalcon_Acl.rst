Абстрактный класс **Phalcon\\Acl**
===============================

Этот компонент позволяет управлять списками ACL. Список управления доступом (ACL) представляет собой список разрешений, прикрепленных к объекту. ACL определяет, какие пользователи или системные процессы имеют доступ к объектам, 
а также какие операции разрешены на данных объектах.
.. code-block:: php

    <?php

    $acl = new Phalcon\Acl\Adapter\Memory();
    
    // Действие по умолчанию запретить доступ
    $acl->setDefaultAction(Phalcon\Acl::DENY);
    
    // Создать несколько ролей
    $roleAdmins = new Phalcon\Acl\Role('Administrators', 'Super-User role');
    $roleGuests = new Phalcon\Acl\Role('Guests');
    
    // Добавить роль "Гости" в acl
    $acl->addRole($roleGuests);
    
    // Добавить роль "Дизайнеры" в acl
    $acl->addRole('Designers');
    
    // Определить Ресурс "Клиенты"
    $customersResource = new Phalcon\Acl\Resource('Customers', 'Customers management');
    
    // Добавить Ресурс  "Клиенты" с парой операций
    $acl->addResource($customersResource, 'search');
    $acl->addResource($customersResource, array('create', 'update'));
    
    // Установить уровень доступа для ролей в ресурсы
    $acl->allow('Guests', 'Customers', 'search');
    $acl->allow('Guests', 'Customers', 'create');
    $acl->deny('Guests', 'Customers', 'update');
    
    // Проверить, имеет ли роль доступ к операций
    $acl->isAllowed('Guests', 'Customers', 'edit'); //Returns 0
    $acl->isAllowed('Guests', 'Customers', 'search'); //Returns 1
    $acl->isAllowed('Guests', 'Customers', 'create'); //Returns 1



Константы
---------

*integer* **ALLOW**

*integer* **DENY**

