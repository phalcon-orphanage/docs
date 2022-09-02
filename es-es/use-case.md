---
layout: default
language: 'es-es'
version: '4.0'
title: 'Caso de Uso'
keywords: 'caso de uso, ejemplos'
---

# Caso de Uso

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

A través de esta documentación vamos a asumir que estamos construyendo una aplicación contable.

## Requerimentos

- Aplicación MVC usando [Phalcon\Mvc\Application](application)
- Almacenar datos en una base de datos (MariaDB/MySQL)
- Ofrecer una UI para que trabajen los usuarios 
    - Página de Login
    - Área de administración 
        - Gestión de caché
        - Permisos
        - CRUD de productos
        - CRUD de usuarios
    - Área de departamento de contabilidad 
        - Facturas
        - Clientes
        - Pagos
    - Área portal del cliente 
        - Facturas (vista)
        - Pago
        - Informes

## Grupos - Roles de Usuario

| Grupo           | Descripción                                            |
| --------------- | ------------------------------------------------------ |
| Invitados       | Usuarios que no están conectados, visitantes del sitio |
| Clientes        | Usuarios que han comprado productos                    |
| Contabilidad    | Usuarios del departamento de contabilidad              |
| Gestores        | Gestores del departamento de contabilidad              |
| Administradores | Acceso total a toda la aplicación                      |

## Puntos Finales

| Punto Final                       | Descripción                                                              |
| --------------------------------- | ------------------------------------------------------------------------ |
| `/login`                          | Ruta `/session/login`. Presenta la página de inicio de sesión            |
| `/logout`                         | Ruta `/session/logout`. Cierra la sesión de usuario, redirige a `/login` |
| `/portal/invoices/list`           | Lista facturas para el cliente conectado actualmente                     |
| `/portal/invoices/view/{0-9}`     | Ver factura para el cliente conectado actualmente                        |
| `/portal/invoices/pay/{0-9}`      | Pagar factura (pasarela de pago)                                         |
| `/portal/reports/list`            | Lista informes disponibles para el cliente conectado                     |
| `/portal/reports/view/{0-9}`      | Ver informe para este cliente                                            |
| `/accounting/invoices/add`        | Añadir nueva factura                                                     |
| `/accounting/invoices/edit/{0-9}` | Editar una factura                                                       |
| `/accounting/invoices/view/{0-9}` | Ver una factura                                                          |
| `/accounting/invoices/list`       | Listar todas las facturas                                                |
| `/accounting/invoices/void/{0-9}` | Anular una factura                                                       |
| `/admin/cache/view`               | Ver todos los elementos de caché                                         |
| `/admin/cache/delete/{0-9}`       | Borrar un elemento de caché                                              |
| `/admin/cache/void`               | Anular toda la caché                                                     |
| `/admin/permissions/list`         | Mostrar los permisos actuales                                            |
| `/admin/permissions/add`          | Añadir un nuevo permiso                                                  |
| `/admin/permissions/edit/{0-9}`   | Editar un permiso                                                        |
| `/admin/products/list`            | Listar todos los productos                                               |
| `/admin/products/add`             | Añadir un producto                                                       |
| `/admin/products/edit/{0-9}`      | Editar un producto                                                       |
| `/admin/products/delete/{0-9}`    | Borrar un producto                                                       |
| `/admin/products/view/{0-9}`      | Ver un producto                                                          |
| `/admin/users/list`               | Listar todos los usuarios                                                |
| `/admin/users/add`                | Añadir un usuario                                                        |
| `/admin/users/edit/{0-9}`         | Editar un usuario                                                        |
| `/admin/users/delete/{0-9}`       | Borrar un usuario                                                        |
| `/admin/users/view/{0-9}`         | Ver un usuario                                                           |
