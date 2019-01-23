---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Flash\Session'
---
# Class **Phalcon\Flash\Session**

*extends* abstract class [Phalcon\Flash](Phalcon_Flash)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\FlashInterface](Phalcon_FlashInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/flash/session.zep)

临时存储的消息将在会话中，然后在下一个请求可以打印消息

## 方法

protected **_getSessionMessages** (*mixed* $remove, [*mixed* $type])

返回临时储存会话中储存的消息

protected **_setSessionMessages** (*array* $messages)

设置临时储存会话中存储的消息

public **message** (*mixed* $type, *mixed* $message)

向心事储存会话中添加消息

public **has** ([*mixed* $type])

检查是否有消息

public **getMessages** ([*mixed* $type], [*mixed* $remove])

返回临时储存会话的消息

public **output** ([*mixed* $remove])

输出临时储存会话中储存的消息

public **clear** ()

清除临时储存会话中的消息

public **__construct** ([*mixed* $cssClasses]) inherited from [Phalcon\Flash](Phalcon_Flash)

Phalcon\Flash constructor

public **getAutoescape** () inherited from [Phalcon\Flash](Phalcon_Flash)

Returns the autoescape mode in generated html

public **setAutoescape** (*mixed* $autoescape) inherited from [Phalcon\Flash](Phalcon_Flash)

Set the autoescape mode in generated html

public **getEscaperService** () inherited from [Phalcon\Flash](Phalcon_Flash)

Returns the Escaper Service

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService) inherited from [Phalcon\Flash](Phalcon_Flash)

Sets the Escaper Service

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Flash](Phalcon_Flash)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Flash](Phalcon_Flash)

返回内部依赖注入器

public **setImplicitFlush** (*mixed* $implicitFlush) inherited from [Phalcon\Flash](Phalcon_Flash)

Set whether the output must be implicitly flushed to the output or returned as string

public **setAutomaticHtml** (*mixed* $automaticHtml) inherited from [Phalcon\Flash](Phalcon_Flash)

Set if the output must be implicitly formatted with HTML

public **setCssClasses** (*array* $cssClasses) inherited from [Phalcon\Flash](Phalcon_Flash)

Set an array with CSS classes to format the messages

public **error** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML error message

```php
<?php

$flash->error("This is an error");

```

public **notice** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML notice/information message

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML success message

```php
<?php

$flash->success("The process was finished successfully");

```

public **warning** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML warning message

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Outputs a message formatting it with HTML

```php
<?php

$flash->outputMessage("error", $message);

```