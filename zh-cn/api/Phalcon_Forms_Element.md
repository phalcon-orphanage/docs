---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Forms\Element'
---
# Abstract class **Phalcon\Forms\Element**

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element.zep)

这是表单元素的基类

## 方法

public **__construct** (*string* $name, [*array* $attributes])

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form)

将父级表单设置为该元素

public **getForm** ()

返回父窗体元素

public **setName** (*mixed* $name)

设置的元素名称

public **getName** ()

返回的元素名称

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters)

设置元素的过滤器

public **addFilter** (*mixed* $filter)

将筛选器添加到当前的过滤器列表

public *mixed* **getFilters** ()

返回的元素的筛选

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge])

添加一组验证程序

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

向元素添加一个验证器

public **getValidators** ()

返回注册为该元素的验证程序

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked])

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value)

设置默认属性的元素

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue])

返回属性的值，如果存在

public **setAttributes** (*array* $attributes)

设置默认属性的元素

public **getAttributes** ()

返回元素的默认属性

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value)

设置一个元素的选项

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue])

返回选项的值，如果存在

public **setUserOptions** (*array* $options)

该元素的设置选项

public **getUserOptions** ()

返回的元素的选项

public **setLabel** (*mixed* $label)

设置元素标签

public **getLabel** ()

返回的元素标签

public **label** ([*array* $attributes])

生成的 HTML 元素的标签

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value)

窗体不使用实体或有可用的没有价值 _POST 中的元素的情况下设置一个默认值

public **getDefault** ()

返回分配给该元素的默认值

public **getValue** ()

返回的元素的值

public **getMessages** ()

返回属于的元素元素需要将其附加到窗体的消息

public **hasMessages** ()

检查是否有消息附加到元素

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group)

设置与元素相关的验证消息

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

将消息追加到内部消息列表

public **clear** ()

清除每个元素的形式为其默认值

public **__toString** ()

Magic method __toString renders the widget without attributes

abstract public **render** ([*mixed* $attributes]) inherited from [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

...