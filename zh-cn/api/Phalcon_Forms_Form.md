---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Forms\Form'
---
# Class **Phalcon\Forms\Form**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/form.zep)

此组件允许生成窗体使用面向对象的接口

## 方法

public **setValidation** (*mixed* $validation)

...

public **getValidation** ()

...

public **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\Forms\Form constructor

public **setAction** (*mixed* $action)

设置表单的操作

public **getAction** ()

返回表单的操作

public **setUserOption** (*string* $option, *mixed* $value)

设置表单的选项

public **getUserOption** (*string* $option, [*mixed* $defaultValue])

返回选项的值，如果存在

public **setUserOptions** (*array* $options)

该元素的设置选项

public **getUserOptions** ()

返回的元素的选项

public **setEntity** (*object* $entity)

设置实体模型相关的

public *object* **getEntity** ()

返回到模型相关的实体

public **getElements** ()

返回添加到窗体的窗体元素

public **bind** (*array* $data, *object* $entity, [*array* $whitelist])

将数据绑定到实体

public **isValid** ([*array* $data], [*object* $entity])

验证窗体

public **getMessages** ([*mixed* $byItemName])

返回生成验证中的消息

public **getMessagesFor** (*mixed* $name)

返回特定元素生成的消息

public **hasMessagesFor** (*mixed* $name)

检查是否消息生成特定元素

public **add** ([Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) $element, [*mixed* $position], [*mixed* $type])

将一个元素添加到窗体

public **render** (*string* $name, [*array* $attributes])

呈现窗体中的特定项

public **get** (*mixed* $name)

返回由其名称添加到窗体元素

public **label** (*mixed* $name, [*array* $attributes])

生成添加到窗体，包括 HTML 元素的标签

public **getLabel** (*mixed* $name)

返回元素的标签

public **getValue** (*mixed* $name)

获取一个值，从内部相关实体或从默认值

public **has** (*mixed* $name)

检查是否该窗体包含一个元素

public **remove** (*mixed* $name)

从窗体中移除一个元素

public **clear** ([*array* $fields])

清除每个元素的形式为其默认值

public **count** ()

在窗体中返回的元素的数目

public **rewind** ()

倒带内部迭代器

public **current** ()

在迭代器返回的当前元素

public **key** ()

在迭代器中返回每个该项当前的位置

public **next** ()

将内部迭代指针移动到下一个位置

public **valid** ()

检查迭代器中的当前元素是否有效

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部事件管理器

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get