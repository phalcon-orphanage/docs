---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Validation'
---
# Class **Phalcon\Validation**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\ValidationInterface](Phalcon_ValidationInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation.zep)

カスタムまたは内蔵のバリデーターを使用してデータを検証できます

## メソッド

public **getData** ()

...

public **setValidators** (*mixed* $validators)

...

public **__construct** ([*array* $validators])

Phalcon\Validation constructor

public [Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) **validate** ([*array* | *object* $data], [*object* $entity])

一連のルールに従ってデータのセットを検証する

public **add** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

フィールドにバリデーターを追加します。

public **rule** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

`add`メソッドのエイリアス

public **rules** (*mixed* $field, *array* $validators)

フィールドにバリデーターを追加します。

public [Phalcon\Validation](Phalcon_Validation) **setFilters** (*string* $field, *array* | *string* $filters)

フィールドにフィルタを追加する

public *mixed* **getFilters** ([*string* $field])

すべてのフィルタまたは特定のフィルタを返します。

public **getValidators** ()

バリデーションに追加されたバリデータを返します。

public **setEntity** (*object* $entity)

バインドされたエンティティを設定する

public *object* **getEntity** ()

バインドされたエンティティを返す

public **setDefaultMessages** ([*array* $messages])

バリデーターにデフォルトのメッセージを追加する

public **getDefaultMessage** (*mixed* $type)

バリデーター型のデフォルトメッセージを取得する

public **getMessages** ()

登録済みのバリデータを返します。

public **setLabels** (*array* $labels)

フィールドのラベルを追加します

public *string* **getLabel** (*string* $field)

フィールドのラベルを取得します。

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

メッセージをメッセージリストに追加します

public [Phalcon\Validation](Phalcon_Validation) **bind** (*object* $entity, *array* | *object* $data)

エンティティにデータを割り当てます。

public *mixed* **getValue** (*string* $field)

配列/オブジェクトデータソースで検証する値を取得します。

protected **preChecking** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

内部のバリデーションがtrueを返した場合は、現在のバリデータをスキップします。

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

内部イベントマネージャーを返します

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get