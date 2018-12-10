# Class **Phalcon\\Validation**

*extends* abstract class [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\ValidationInterface](/en/3.2/api/Phalcon_ValidationInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

カスタムまたは内蔵のバリデーターを使用してデータを検証できます

## メソッド

public **getData** ()

...

public **setValidators** (*mixed* $validators)

...

public **__construct** ([*array* $validators])

Phalcon\\Validation のコンストラクタ

public [Phalcon\Validation\Message\Group](/en/3.2/api/Phalcon_Validation_Message_Group) **validate** ([*array* | *object* $data], [*object* $entity])

一連のルールに従ってデータのセットを検証する

public **add** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface) $validator)

フィールドにバリデーターを追加します。

public **rule** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface) $validator)

`add`メソッドのエイリアス

public **rules** (*mixed* $field, *array* $validators)

フィールドにバリデーターを追加します。

public [Phalcon\Validation](/en/3.2/api/Phalcon_Validation) **setFilters** (*string* $field, *array* | *string* $filters)

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

public **appendMessage** ([Phalcon\Validation\MessageInterface](/en/3.2/api/Phalcon_Validation_MessageInterface) $message)

メッセージをメッセージリストに追加します

public [Phalcon\Validation](/en/3.2/api/Phalcon_Validation) **bind** (*object* $entity, *array* | *object* $data)

エンティティにデータを割り当てます。

public *mixed* **getValue** (*string* $field)

配列/オブジェクトデータソースで検証する値を取得します。

protected **preChecking** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface) $validator)

内部のバリデーションがtrueを返した場合は、現在のバリデータをスキップします。

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

DIをセットします。

public **getDI** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

内部のDIを返します。

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

イベントマネージャーをセットします

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

内部イベントマネージャーを返します

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/en/3.2/api/Phalcon_Di_Injectable)

マジックメソッド __get