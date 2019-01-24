---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/annotation.zep)

یک حاشیه نویسی تنها در یک مجموعه حاشیه نویسی نمایان می شود

## روش ها

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

public **getName** ()

نام حاشیه نویسی را برمی گرداند

public *mixed* **getExpression** (*array* $expr)

یک علامت حاشیه نویسی را حل می کند

عمومی *آرایه* **getExprArguments** ()

آرگومان های بیان را بدون حل کردن بازمی گرداند

عمومی *آرایه* **دریافت استدلال** ()

استدلال بیان را بازمیگرداند

عمومی **شماره استدلال** ()

تعدادی از استدلال هایی که حاوی حاشیه نویسی است را برمی گرداند

public *mixed* **getArgument** (*int* | *string* $position)

یک استدلال را در یک موقعیت خاص بازگرداند

public *boolean* **hasArgument** (*int* | *string* $position)

یک استدلال را در یک موقعیت خاص بازگرداند

public *mixed* **getNamedArgument** (*mixed* $name)

یک استدلال نامیده می شود

public *mixed* **getNamedParameter** (*mixed* $name)

بازگرداندن یک پارامتر به نام