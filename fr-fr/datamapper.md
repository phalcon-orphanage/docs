---
layout: default
title: 'Data Mapper'
keywords: 'data mapper, pdo, query builder'
---

# Data Mapper
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

> These components have been heavily influenced by [Aura PHP][auraphp] and [Atlas PHP][atlasphp] 
> 
> {: .alert .alert-warning }

## Vue d'ensemble

The Data Mapper pattern as described by [Martin Fowler][datamapper] in [Patterns of Enterprise Application Architecture][eaa] is:

> A layer of Mappers that moves data between objects and a database while keeping them independent of each other and the mapper itself. 
> 
> {: .alert .alert-info }

The `Phalcon\DataMapper` namespace contains components to help with accessing your data source, with the \[Data Mapper\]\[pattern\].

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
[eaa]: https://martinfowler.com/books/eaa.html
