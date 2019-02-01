---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Assets\Filters\Jsmin'
---
# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/filters/jsmin.zep)

删除字符对 JavaScript 无关紧要的。 将删除注释。 选项卡会替换为空格。 回车换行符将被替换。 大多数的空格和换行符将被删除。

## 方法

public **filter** (*mixed* $content)

过滤器使用 JSMIN 的内容