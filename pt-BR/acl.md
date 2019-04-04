---
layout: default
language: 'pt-br'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Access Control Lists (ACL)](acl-overview)
- [Creating an ACL](acl-setup)
- [Adding Roles](acl-adding-roles)
- [Adding Components](acl-adding-components)
- [Defining Access Controls](acl-access-controls)
- [Querying an ACL](acl-querying)
- [Function based access](acl-function-based-access)
- [Objects as role name and component name](acl-objects)
- [Roles Inheritance](acl-roles-inheritance)
- [Serializing ACL lists](acl-serialization)
- [Events](acl-events)
- [Implementing your own adapters](acl-custom-adapters)

* * *

## Access Control Lists (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](https://en.wikipedia.org/wiki/Access_control_list) (ACL) allow an application to control access to its areas and the underlying objects from requests.

In short, ACLs have two objects: The object that needs access, and the object that we need access to. In the programming world, these are usually referred to as Roles and Components. In the Phalcon world, we use the terminology [Role](api/Phalcon_Acl_Role) and [Component](api/Phalcon_Acl_Component).

> **Use Case**
> 
> An accounting application needs to have different groups of users have access to various areas of the application.
> 
> **Role** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Component** - Login page - Admin page - Invoices page - Reports page
{:.alert .alert-info}

As seen above in the use case, an [Role](api/Phalcon_Acl_Role) is defined as who needs to access a particular [Component](api/Phalcon_Acl_Component) i.e. an area of the application. A [Component](api/Phalcon_Acl_Component) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific roles to be bound to specific components.