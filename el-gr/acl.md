---
layout: default
language: 'el-gr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Λίστες ελέγχου πρόσβασης (ACL)](acl-overview)
- [Δημιουργώντας Λίστες Ελέγχου Πρόσβασης](acl-setup)
- [Adding Roles](acl-adding-roles)
- [Adding Components](acl-adding-components)
- [Καθορισμός ελέγχων πρόσβασης](acl-access-controls)
- [Αναζητώντας ένα ACL](acl-querying)
- [Πρόσβαση βασισμένη σε λειτουργίες](acl-function-based-access)
- [Objects as role name and component name](acl-objects)
- [Roles Inheritance](acl-roles-inheritance)
- [Σειρογραφία Λίστες ACL](acl-serialization)
- [Γεγονότα](acl-events)
- [Implementing your own adapters](acl-custom-adapters)

* * *

## Λίστες ελέγχου πρόσβασης (ACL)

Το [Phalcon \ Acl](api/Phalcon_Acl) παρέχει μια εύκολη και ελαφριά διαχείριση των ACL καθώς και τα δικαιώματα που τους συνοδεύουν. [Οι λίστες ελέγχου πρόσβασης](https://en.wikipedia.org/wiki/Access_control_list) (ACL) επιτρέπουν σε μια εφαρμογή να ελέγχει την πρόσβαση στις περιοχές της και τα αντικείμενα από τα αιτήματα.

Εν ολίγοις, οι ACL έχουν δύο αντικείμενα: το αντικείμενο που χρειάζεται πρόσβαση, και το αντικείμενο που χρειαζόμαστε την πρόσβαση. In the programming world, these are usually referred to as Roles and Components. In the Phalcon world, we use the terminology [Role](api/Phalcon_Acl_Role) and [Component](api/Phalcon_Acl_Component).

> **Use Case**
> 
> Μια εφαρμογή λογιστικής χρειάζεται διαφορετικές ομάδες χρηστών να έχουν πρόσβαση σε διάφορες περιοχές της εφαρμογής.
> 
> **Role** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Component** - Login page - Admin page - Invoices page - Reports page
{:.alert .alert-info}

As seen above in the use case, an [Role](api/Phalcon_Acl_Role) is defined as who needs to access a particular [Component](api/Phalcon_Acl_Component) i.e. an area of the application. A [Component](api/Phalcon_Acl_Component) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific roles to be bound to specific components.