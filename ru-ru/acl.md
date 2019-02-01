---
layout: article
language: 'ru-ru'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Списки управления доступом (ACL)](acl-overview)
- [Создание списков контроля доступа](acl-setup)
- [Adding Operations](acl-adding-operations)
- [Adding Subjects](acl-adding-subjects)
- [Определение контроля доступа](acl-access-controls)
- [Запросы к ACL](acl-querying)
- [Доступ на основе пользовательских функций](acl-function-based-access)
- [Objects as operation name and subject name](acl-objects)
- [Наследование операций](acl-operations-inheritance)
- [Сериализация ACL списков](acl-serialization)
- [События](acl-events)
- [Реализация собственных адаптеров](acl-custom-adapters)

* * *

## Списки управления доступом (ACL)

[Phalcon\Acl](api/Phalcon_Acl) предоставляет простое и легкое управление списками контроля доступа, а также разрешениями, назначаемыми этим спискам. [Списки управления доступом](https://en.wikipedia.org/wiki/Access_control_list) (ACL) позволяют приложению управлять доступом к различным своим частям и запрошенным объектам.

Короче говоря, списки ACL имеют два объекта: объект, к которому требуется доступ, и объект, к которому нам нужен доступ. В программирование их обычно называют операциями и субъектами. In the Phalcon world, we use the terminology [Operation](api/Phalcon_Acl_Operation) and [Subject](api/Phalcon_Acl_Subject).

> **Use Case**
> 
> An accounting application needs to have different groups of users have access to various areas of the application.
> 
> **Operation** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Subject** - Login page - Admin page - Invoices page - Reports page {:.alert .alert-info}

As seen above in the use case, an [Operation](api/Phalcon_Acl_Operation) is defined as who needs to access a particular [Subject](api/Phalcon_Acl_Subject) i.e. an area of the application. A [Subject](api/Phalcon_Acl_Subject) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific operations to be bound to specific subjects.