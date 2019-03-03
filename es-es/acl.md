---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Listas de control de acceso (ACL)](acl-overview)
- [Creando una ACL](acl-setup)
- [Agregando Roles](acl-adding-roles)
- [Agregando Componentes](acl-adding-components)
- [Definición de Controles de Acceso](acl-access-controls)
- [Consultando una ACL](acl-querying)
- [Function based access](acl-function-based-access)
- [Objects as role name and component name](acl-objects)
- [Roles Inheritance](acl-roles-inheritance)
- [Serializando listas ACL](acl-serialization)
- [Eventos](acl-events)
- [Implementando sus propios adaptadores](acl-custom-adapters)

* * *

## Listas de control de acceso (ACL)

[Phalcon\Acl](api/Phalcon_Acl) proporciona una fácil y ligera gestión de las ACL, así como los permisos que se les asignan. [Listas de Control de Acceso](https://en.wikipedia.org/wiki/Access_control_list) (ACL) permiten a una aplicación controlar el acceso a sus áreas y a los objetos subyacentes de las solicitudes.

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