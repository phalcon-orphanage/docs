---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Forms\Element\Text'
---
# Class **Phalcon\Forms\Element\Text**

*extends* abstract class [Phalcon\Forms\Element](Phalcon_Forms_Element)

*implements* [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/element/text.zep)

组件的输入 [type=text] 的形式

## 方法

public **render** ([*array* $attributes])

呈现元素小部件

public **__construct** (*string* $name, [*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Phalcon\Forms\Element constructor

public **setForm** ([Phalcon\Forms\Form](Phalcon_Forms_Form) $form) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

将父级表单设置为该元素

public **getForm** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回父窗体元素

public **setName** (*mixed* $name) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置的元素名称

public **getName** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回的元素名称

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setFilters** (*array* | *string* $filters) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置元素的过滤器

public **addFilter** (*mixed* $filter) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

将筛选器添加到当前的过滤器列表

public *mixed* **getFilters** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回的元素的筛选

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **addValidators** (*array* $validators, [*mixed* $merge]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

添加一组验证程序

public **addValidator** ([Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

向元素添加一个验证器

public **getValidators** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回注册为该元素的验证程序

public **prepareAttributes** ([*array* $attributes], [*mixed* $useChecked]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setAttribute** (*string* $attribute, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置默认属性的元素

public *mixed* **getAttribute** (*string* $attribute, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回属性的值，如果存在

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置默认属性的元素

public **getAttributes** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回元素的默认属性

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setUserOption** (*string* $option, *mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置一个元素的选项

public *mixed* **getUserOption** (*string* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回选项的值，如果存在

public **setUserOptions** (*array* $options) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

该元素的设置选项

public **getUserOptions** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回的元素的选项

public **setLabel** (*mixed* $label) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置元素标签

public **getLabel** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回的元素标签

public **label** ([*array* $attributes]) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

生成的 HTML 元素的标签

public [Phalcon\Forms\ElementInterface](Phalcon_Forms_ElementInterface) **setDefault** (*mixed* $value) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

窗体不使用实体或有可用的没有价值 _POST 中的元素的情况下设置一个默认值

public **getDefault** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回分配给该元素的默认值

public **getValue** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回的元素的值

public **getMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

返回属于的元素元素需要将其附加到窗体的消息

public **hasMessages** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

检查是否有消息附加到元素

public **setMessages** ([Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) $group) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

设置与元素相关的验证消息

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message) inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

将消息追加到内部消息列表

public **clear** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

清除每个元素的形式为其默认值

public **__toString** () inherited from [Phalcon\Forms\Element](Phalcon_Forms_Element)

Magic method __toString renders the widget without attributes