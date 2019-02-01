---
layout: article
language: 'zh-cn'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [访问控制列表 (ACL)](acl-overview)
- [创建 ACL](acl-setup)
- [Adding Operations](acl-adding-operations)
- [Adding Subjects](acl-adding-subjects)
- [定义访问控制](acl-access-controls)
- [查询ACL](acl-querying)
- [基于访问控制的自定义函数](acl-function-based-access)
- [Objects as operation name and subject name](acl-objects)
- [Operations Inheritance](acl-operations-inheritance)
- [序列化 ACL 列表](acl-serialization)
- [事件](acl-events)
- [实现自己的适配器](acl-custom-adapters)

* * *

## 访问控制列表 (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](https://en.wikipedia.org/wiki/Access_control_list) (ACL) allow an application to control access to its areas and the underlying objects from requests.

In short, ACLs have two objects: The object that needs access, and the object that we need access to. In the programming world, these are usually referred to as Operations and Subjects. In the Phalcon world, we use the terminology [Operation](api/Phalcon_Acl_Operation) and [Subject](api/Phalcon_Acl_Subject).

> **Use Case**
> 
> An accounting application needs to have different groups of users have access to various areas of the application.
> 
> **Operation** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Subject** - Login page - Admin page - Invoices page - Reports page {:.alert .alert-info}

As seen above in the use case, an [Operation](api/Phalcon_Acl_Operation) is defined as who needs to access a particular [Subject](api/Phalcon_Acl_Subject) i.e. an area of the application. A [Subject](api/Phalcon_Acl_Subject) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific operations to be bound to specific subjects.