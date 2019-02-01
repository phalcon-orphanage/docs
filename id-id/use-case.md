---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Gunakan perkara

Berdasarkan dokumentasi ini kita berencana untuk membangun aplikasi akuntansi.

<a name='requirements'></a>

## Persyaratan

- MVC application menggunakan [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application)
- Menyimpan data pada database (MariaDB/MySQL)
- Menawarkan UI (User Interface) untuk pengguna dalam bekerja 
    - Login page
    - Area Administration 
        - Manajemen Cache
        - Permissions
        - CRUD Produk
        - CRUD User
    - Area departemen akuntansi 
        - Invoices
        - Customers
        - Payments
    - Area portal customer 
        - Invoices (view)
        - Payment
        - Reports

<a name='groups'></a>

## Groups - User roles

| Group          | Deskripsi                                                  |
| -------------- | ---------------------------------------------------------- |
| Guests         | Pengguna yang tidak melakukan login, pengunjung dari situs |
| Customers      | Pengguna yang dapat membeli produk                         |
| Accounting     | Pengguna dari departemen akuntansi                         |
| Managers       | Manajer departemen akuntansi                               |
| Administrators | Akses penuh keseluruhan aplikasi                           |

<a name='endpoints'></a>

## Endpoints

| Endpoint                          | Deskripsi                                                    |
| --------------------------------- | ------------------------------------------------------------ |
| `/login`                          | Path `/session/login`. Menampilkan tampilan login            |
| `/logout`                         | Path `/session/logout`. Catatan keluar, redirect ke `/login` |
| `/portal/invoices/list`           | Daftar invoice untuk customer yang login                     |
| `/portal/invoices/view/{0-9}`     | Menampilkan invoice untuk customer yang login                |
| `/portal/invoices/pay/{0-9}`      | Pembayaran invoice (payment gateway)                         |
| `/portal/reports/list`            | Daftar laporan yang tersedia untuk customer login            |
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