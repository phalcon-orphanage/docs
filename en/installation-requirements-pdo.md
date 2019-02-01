---
layout: article
language: 'en'
version: '4.0'
category: 'installation'
---
# Installation
<hr/>

## Requirements

### PDO
Since Phalcon is loosely coupled, it exposes functionality without the need for additional extensions. However certain components rely on additional extensions to work. When in need for database connectivity and access, you will need to install the `php_pdo` extension. If your RDBMS is MySql/MariaDB or Aurora, you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.
