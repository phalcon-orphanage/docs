---
layout: default
language: 'en'
version: '4.0'
title: 'Use Case'
keywords: 'use case, examples'
---

# Use Case

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

Throughout this documentation we are going to assume that we are building an accounting application.

## Requirements

- MVC application using [Phalcon\Mvc\Application](application)
- Store data in a database (MariaDB/MySQL)
- Offer a UI for users to work 
    - Login page
    - Administration area 
        - Cache management
        - Permissions
        - Products CRUD
        - Users CRUD
    - Accounting department area 
        - Invoices
        - Customers
        - Payments
    - Customer portal area 
        - Invoices (view)
        - Payment
        - Reports

## Groups - User Roles

| Group          | Description                                        |
| -------------- | -------------------------------------------------- |
| Guests         | Users that are not logged in, visitors to the site |
| Customers      | Users that have purchased products                 |
| Accounting     | Users of the accounting department                 |
| Managers       | Accounting department managers                     |
| Administrators | Full access to the whole application               |

## Endpoints

| Endpoint                          | Description                                                  |
| --------------------------------- | ------------------------------------------------------------ |
| `/login`                          | Path `/session/login`. Presents the login screen             |
| `/logout`                         | Path `/session/logout`. Logs user out, redirects to `/login` |
| `/portal/invoices/list`           | List invoices for the currently logged in customer           |
| `/portal/invoices/view/{0-9}`     | View invoice for the currently logged in customer            |
| `/portal/invoices/pay/{0-9}`      | Pay invoice (payment gateway)                                |
| `/portal/reports/list`            | List available reports for the logged in customer            |
| `/portal/reports/view/{0-9}`      | View report for this customer                                |
| `/accounting/invoices/add`        | Add new invoice                                              |
| `/accounting/invoices/edit/{0-9}` | Edit an invoice                                              |
| `/accounting/invoices/view/{0-9}` | View an invoice                                              |
| `/accounting/invoices/list`       | List all invoices                                            |
| `/accounting/invoices/void/{0-9}` | Void an invoice                                              |
| `/admin/cache/view`               | View all cache items                                         |
| `/admin/cache/delete/{0-9}`       | Delete a cache item                                          |
| `/admin/cache/void`               | Void the whole cache                                         |
| `/admin/permissions/list`         | Show the current permissions                                 |
| `/admin/permissions/add`          | Add a new permission                                         |
| `/admin/permissions/edit/{0-9}`   | Edit a permission                                            |
| `/admin/products/list`            | List all products                                            |
| `/admin/products/add`             | Add a product                                                |
| `/admin/products/edit/{0-9}`      | Edit a product                                               |
| `/admin/products/delete/{0-9}`    | Delete a product                                             |
| `/admin/products/view/{0-9}`      | View a product                                               |
| `/admin/users/list`               | List all users                                               |
| `/admin/users/add`                | Add a user                                                   |
| `/admin/users/edit/{0-9}`         | Edit a user                                                  |
| `/admin/users/delete/{0-9}`       | Delete a user                                                |
| `/admin/users/view/{0-9}`         | View a user                                                  |