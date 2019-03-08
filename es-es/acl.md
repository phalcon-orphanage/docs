---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Listas de Control de Acceso (ACL)

* * *

- [Listas de control de acceso (ACL)](acl-overview)
- [Creando una ACL](acl-setup)
- [Agregando Roles](acl-adding-roles)
- [Agregando Componentes](acl-adding-components)
- [Definición de Controles de Acceso](acl-access-controls)
- [Consultando una ACL](acl-querying)
- [Acceso basado en una función](acl-function-based-access)
- [Objetos como nombre de rol y nombre de componente](acl-objects)
- [Herencia de roles](acl-roles-inheritance)
- [Serializando listas ACL](acl-serialization)
- [Eventos](acl-events)
- [Implementando sus propios adaptadores](acl-custom-adapters)

* * *

## Listas de control de acceso (ACL)

[Phalcon\Acl](api/Phalcon_Acl) proporciona una fácil y ligera gestión de las ACL, así como los permisos que se les asignan. [Listas de Control de Acceso](https://en.wikipedia.org/wiki/Access_control_list) (ACL) permiten a una aplicación controlar el acceso a sus áreas y a los objetos subyacentes de las solicitudes.

En resumen, las ACL tienen dos objetos: El objeto que necesita acceso, y el objeto al que necesitamos acceder. En el mundo de la programación, estos se denominan habitualmente Roles y Componentes. En el mundo de Phalcon, usamos la terminología [Rol](api/Phalcon_Acl_Role) y [Componente](api/Phalcon_Acl_Component).

> **Caso de Uso**
> 
> Una aplicación contable necesita tener diferentes grupos de usuarios que tengan acceso a varias áreas de la aplicación.
> 
> **Rol** - Acceso al Administrador - Acceso al Departamento de Contabilidad - Acceso al Gestor - Acceso al Invitado
> 
> **Componente** - Página de inicio de sesión - Página de administración - Página de facturas - Página de reportes
{:.alert .alert-info}

Como se ha visto arriba en el caso de uso, un [Role](api/Phalcon_Acl_Role) se define como quién necesita acceder a un [Component](api/Phalcon_Acl_Component) en particular, es decir, un área de la aplicación. Un [Component](api/Phalcon_Acl_Component) se define como el área de la aplicación que necesita ser accedida.

Usando el componente [Phalcon\Acl](api/Phalcon_Acl), podemos atar estos dos juntos, y fortalecer la seguridad de nuestra aplicación, permitiendo que sólo los roles específicos estén vinculados a componentes específicos.