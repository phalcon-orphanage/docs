---
layout: default
language: 'en'
version: '4.0'
title: 'Html'
keywords: 'html, attributes, tag, tag factory'
---
# Filter
<hr/>
![](/assets/images/document-status-stable-success.svg)

## Overview
Overview

![](/assets/images/content/filter-sql.png)


## Attributes
## Breadcrumbs
## TagFactory
This component creates a new locator with predefined filters attached to it. Each filter is lazy loaded for maximum performance. To instantiate the factory and retrieve the [Phalcon\Filter][filter-filter] with the preset sanitizers you need to call `newInstance()`

```php
<?php

use Phalcon\Filter\FilterFactory;

$factory = new FilterFactory();

$locator = $factory->newInstance();
```

You can now use the locator wherever you need and sanitize content as per the needs of your application. 

