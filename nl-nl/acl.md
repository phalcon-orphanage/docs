---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Toegangscontrolelijst (ACL)](acl-overview)
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

## Toegangscontrolelijst (ACL)

[Phalcon\Acl](api/Phalcon_Acl) biedt een eenvoudige en lichtgewicht beheer van toegangscontrole en machtigingen. [Toegangscontrolelijsten](https://en.wikipedia.org/wiki/Access_control_list) (ACL) geven een applicatie toegang tot de gebieden en de onderliggende objecten van aanvragen.

Kortom, ACL's heeft twee objecten: Het object dat toegang nodig heeft, en het object we toegang tot willen. In the programming world, these are usually referred to as Roles and Components. In the Phalcon world, we use the terminology [Role](api/Phalcon_Acl_Role) and [Component](api/Phalcon_Acl_Component).

> **Use Case**
> 
> Een boekhoudkundige toepassing moet verschillende groepen gebruikers toegang geven tot verschillende gebieden van de toepassing.
> 
> **Role** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Component** - Login page - Admin page - Invoices page - Reports page
{:.alert .alert-info}

As seen above in the use case, an [Role](api/Phalcon_Acl_Role) is defined as who needs to access a particular [Component](api/Phalcon_Acl_Component) i.e. an area of the application. A [Component](api/Phalcon_Acl_Component) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific roles to be bound to specific components.