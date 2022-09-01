---
layout: default
language: 'en'
version: '5.0'
title: 'Data Mapper'
keywords: 'data mapper, pdo, query builder'
---
# Data Mapper
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

> These components have been heavily influenced by [Aura PHP][auraphp] and [Atlas PHP][atlasphp] 
{: .alert .alert-warning }

## Overview

The Data Mapper pattern as described by [Martin Fowler][datamapper] in [Patterns of Enterprise Application Architecture][eaa] is:

> A layer of Mappers that moves data between objects and a database while keeping them independent of each other and the mapper itself.
{: .alert .alert-info }

The `Phalcon\DataMapper` namespace contains components to help with accessing your data source, with the [Data Mapper][pattern].

## PDO

### Connection

One of the components required by this implementation is a PDO connector. The [Phalcon\DataMapper\Pdo\Connection][datamapper-pdo-connection] offers a wrapper to PHP's PDO implementation, making it easier to maintain connections.

**Connecting to a source**

### Connection - Decorated
### ConnectionLocator

### Profiler
## Query
### Factory
### Delete
### Insert
### Select
### Update

[auraphp]: https://github.com/auraphp
[atlasphp]: https://github.com/atlasphp
[datamapper]: https://martinfowler.com/eaaCatalog/dataMapper.html
[datamapper-pdo-connection]: api/phalcon_datamapper#datamapper-pdo-connection
[datamapper-pdo-connection-abstractconnection]: api/phalcon_datamapper#datamapper-pdo-connection-abstractconnection
[datamapper-pdo-connection-connectioninterface]: api/phalcon_datamapper#datamapper-pdo-connection-connectioninterface
[datamapper-pdo-connection-decorated]: api/phalcon_datamapper#datamapper-pdo-connection-decorated
[datamapper-pdo-connection-pdointerface]: api/phalcon_datamapper#datamapper-pdo-connection-pdointerface
[datamapper-pdo-connectionlocator]: api/phalcon_datamapper#datamapper-pdo-connectionlocator
[datamapper-pdo-connectionlocatorinterface]: api/phalcon_datamapper#datamapper-pdo-connectionlocatorinterface
[datamapper-pdo-exception-cannotdisconnect]: api/phalcon_datamapper#datamapper-pdo-exception-cannotdisconnect
[datamapper-pdo-exception-connectionnotfound]: api/phalcon_datamapper#datamapper-pdo-exception-connectionnotfound
[datamapper-pdo-exception-exception]: api/phalcon_datamapper#datamapper-pdo-exception-exception
[datamapper-pdo-profiler-memorylogger]: api/phalcon_datamapper#datamapper-pdo-profiler-memorylogger
[datamapper-pdo-profiler-profiler]: api/phalcon_datamapper#datamapper-pdo-profiler-profiler
[datamapper-pdo-profiler-profilerinterface]: api/phalcon_datamapper#datamapper-pdo-profiler-profilerinterface
[datamapper-query-abstractconditions]: api/phalcon_datamapper#datamapper-query-abstractconditions
[datamapper-query-abstractquery]: api/phalcon_datamapper#datamapper-query-abstractquery
[datamapper-query-bind]: api/phalcon_datamapper#datamapper-query-bind
[datamapper-query-delete]: api/phalcon_datamapper#datamapper-query-delete
[datamapper-query-insert]: api/phalcon_datamapper#datamapper-query-insert
[datamapper-query-queryfactory]: api/phalcon_datamapper#datamapper-query-queryfactory
[datamapper-query-select]: api/phalcon_datamapper#datamapper-query-select
[datamapper-query-update]: api/phalcon_datamapper#datamapper-query-update
[eaa]: https://martinfowler.com/books/eaa.html
