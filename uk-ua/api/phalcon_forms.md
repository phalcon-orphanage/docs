---
layout: default
title: 'Phalcon\Forms'
---

* [Phalcon\Forms\Element\AbstractElement](#forms-element-abstractelement)
* [Phalcon\Forms\Element\Check](#forms-element-check)
* [Phalcon\Forms\Element\Date](#forms-element-date)
* [Phalcon\Forms\Element\ElementInterface](#forms-element-elementinterface)
* [Phalcon\Forms\Element\Email](#forms-element-email)
* [Phalcon\Forms\Element\File](#forms-element-file)
* [Phalcon\Forms\Element\Hidden](#forms-element-hidden)
* [Phalcon\Forms\Element\Numeric](#forms-element-numeric)
* [Phalcon\Forms\Element\Password](#forms-element-password)
* [Phalcon\Forms\Element\Radio](#forms-element-radio)
* [Phalcon\Forms\Element\Select](#forms-element-select)
* [Phalcon\Forms\Element\Submit](#forms-element-submit)
* [Phalcon\Forms\Element\Text](#forms-element-text)
* [Phalcon\Forms\Element\TextArea](#forms-element-textarea)
* [Phalcon\Forms\Exception](#forms-exception)
* [Phalcon\Forms\Form](#forms-form)
* [Phalcon\Forms\Manager](#forms-manager)

<h1 id="forms-element-abstractelement">Abstract Class Phalcon\Forms\Element\AbstractElement</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/AbstractElement.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | InvalidArgumentException, Phalcon\Di\DiInterface, Phalcon\Di\Di, Phalcon\Filter\Validation\ValidatorInterface, Phalcon\Forms\Form, Phalcon\Forms\Exception, Phalcon\Html\Escaper, Phalcon\Html\TagFactory, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages | | Implements | ElementInterface |

This is a base class for form elements


## Властивості
```php
/**
 * @var array
 */
protected attributes;

/**
 * @var array
 */
protected filters;

/**
 * @var Form|null
 */
protected form;

/**
 * @var string|null
 */
protected label;

/**
 * @var string
 */
protected method = inputText;

/**
 * @var Messages
 */
protected messages;

/**
 * @var string
 */
protected name;

/**
 * @var array
 */
protected options;

/**
 * @var TagFactory|null
 */
protected tagFactory;

/**
 * @var array
 */
protected validators;

/**
 * @var mixed|null
 */
protected value;

```

## Методи

```php
public function __construct( string $name, array $attributes = [] );
```
Constructor


```php
public function __toString(): string;
```
Magic method __toString renders the widget without attributes


```php
public function addFilter( string $filter ): ElementInterface;
```
Adds a filter to current list of filters


```php
public function addValidator( ValidatorInterface $validator ): ElementInterface;
```
Adds a validator to the element


```php
public function addValidators( array $validators, bool $merge = bool ): ElementInterface;
```
Adds a group of validators


```php
public function appendMessage( MessageInterface $message ): ElementInterface;
```
Appends a message to the internal message list


```php
public function clear(): ElementInterface;
```
Clears element to its default value


```php
public function getAttribute( string $attribute, mixed $defaultValue = null ): mixed;
```
Returns the value of an attribute if present


```php
public function getAttributes(): array;
```
Returns the default attributes for the element


```php
public function getDefault(): mixed;
```
Returns the default value assigned to the element


```php
public function getFilters();
```
Returns the element filters


```php
public function getForm(): Form;
```
Returns the parent form to the element


```php
public function getLabel(): string;
```
Returns the element label


```php
public function getMessages(): Messages;
```
Returns the messages that belongs to the element The element needs to be attached to a form


```php
public function getName(): string;
```
Returns the element name


```php
public function getTagFactory(): TagFactory | null;
```
Returns the tagFactory; throws exception if not present


```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```
Returns the value of an option if present


```php
public function getUserOptions(): array;
```
Returns the options for the element


```php
public function getValidators(): ValidatorInterface[];
```
Returns the validators registered for the element


```php
public function getValue(): mixed;
```
Returns the element's value


```php
public function hasMessages(): bool;
```
Checks whether there are messages attached to the element


```php
public function label( array $attributes = [] ): string;
```
Generate the HTML to label the element


```php
public function render( array $attributes = [] ): string;
```
Renders the element widget returning HTML


```php
public function setAttribute( string $attribute, mixed $value ): ElementInterface;
```
Sets a default attribute for the element


```php
public function setAttributes( array $attributes ): ElementInterface;
```
Sets default attributes for the element


```php
public function setDefault( mixed $value ): ElementInterface;
```
Sets a default value in case the form does not use an entity or there is no value available for the element in _POST


```php
public function setFilters( mixed $filters ): ElementInterface;
```
Sets the element filters


```php
public function setForm( Form $form ): ElementInterface;
```
Sets the parent form to the element


```php
public function setLabel( string $label ): ElementInterface;
```
Sets the element label


```php
public function setMessages( Messages $messages ): ElementInterface;
```
Sets the validation messages related to the element


```php
public function setName( string $name ): ElementInterface;
```
Sets the element name


```php
public function setTagFactory( TagFactory $tagFactory ): AbstractElement;
```
Sets the TagFactory


```php
public function setUserOption( string $option, mixed $value ): ElementInterface;
```
Sets an option for the element


```php
public function setUserOptions( array $options ): ElementInterface;
```
Sets options for the element


```php
protected function getLocalTagFactory(): TagFactory;
```
Returns the tagFactory; throws exception if not present




<h1 id="forms-element-check">Class Phalcon\Forms\Element\Check</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Check.zep)

| Namespace  | Phalcon\Forms\Element | | Extends    | AbstractElement |

Component INPUT[type=check] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputCheckbox;

```


<h1 id="forms-element-date">Class Phalcon\Forms\Element\Date</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Date.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=date] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputDate;

```


<h1 id="forms-element-elementinterface">Interface Phalcon\Forms\Element\ElementInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/ElementInterface.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Forms\Form, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Filter\Validation\ValidatorInterface |

Interface for Phalcon\Forms\Element classes


## Методи

```php
public function addFilter( string $filter ): ElementInterface;
```
Adds a filter to current list of filters


```php
public function addValidator( ValidatorInterface $validator ): ElementInterface;
```
Adds a validator to the element


```php
public function addValidators( array $validators, bool $merge = bool ): ElementInterface;
```
Adds a group of validators


```php
public function appendMessage( MessageInterface $message ): ElementInterface;
```
Appends a message to the internal message list


```php
public function clear(): ElementInterface;
```
Clears every element in the form to its default value


```php
public function getAttribute( string $attribute, mixed $defaultValue = null ): mixed;
```
Returns the value of an attribute if present


```php
public function getAttributes(): array;
```
Returns the default attributes for the element


```php
public function getDefault(): mixed;
```
Returns the default value assigned to the element


```php
public function getFilters();
```
Returns the element's filters


```php
public function getForm(): Form;
```
Returns the parent form to the element


```php
public function getLabel(): string;
```
Returns the element's label


```php
public function getMessages(): Messages;
```
Returns the messages that belongs to the element The element needs to be attached to a form


```php
public function getName(): string;
```
Returns the element's name


```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```
Returns the value of an option if present


```php
public function getUserOptions(): array;
```
Returns the options for the element


```php
public function getValidators(): ValidatorInterface[];
```
Returns the validators registered for the element


```php
public function getValue(): mixed;
```
Returns the element's value


```php
public function hasMessages(): bool;
```
Checks whether there are messages attached to the element


```php
public function label(): string;
```
Generate the HTML to label the element


```php
public function render( array $attributes = [] ): string;
```
Renders the element widget


```php
public function setAttribute( string $attribute, mixed $value ): ElementInterface;
```
Sets a default attribute for the element


```php
public function setAttributes( array $attributes ): ElementInterface;
```
Sets default attributes for the element


```php
public function setDefault( mixed $value ): ElementInterface;
```
Sets a default value in case the form does not use an entity or there is no value available for the element in _POST


```php
public function setFilters( mixed $filters ): ElementInterface;
```
Sets the element's filters


```php
public function setForm( Form $form ): ElementInterface;
```
Sets the parent form to the element


```php
public function setLabel( string $label ): ElementInterface;
```
Sets the element label


```php
public function setMessages( Messages $messages ): ElementInterface;
```
Sets the validation messages related to the element


```php
public function setName( string $name ): ElementInterface;
```
Sets the element's name


```php
public function setUserOption( string $option, mixed $value ): ElementInterface;
```
Sets an option for the element


```php
public function setUserOptions( array $options ): ElementInterface;
```
Sets options for the element




<h1 id="forms-element-email">Class Phalcon\Forms\Element\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Email.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=email] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputEmail;

```


<h1 id="forms-element-file">Class Phalcon\Forms\Element\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/File.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=file] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputFile;

```


<h1 id="forms-element-hidden">Class Phalcon\Forms\Element\Hidden</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Hidden.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=hidden] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputHidden;

```


<h1 id="forms-element-numeric">Class Phalcon\Forms\Element\Numeric</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Numeric.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=number] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputNumeric;

```


<h1 id="forms-element-password">Class Phalcon\Forms\Element\Password</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Password.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=password] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputPassword;

```


<h1 id="forms-element-radio">Class Phalcon\Forms\Element\Radio</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Radio.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=radio] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputRadio;

```


<h1 id="forms-element-select">Class Phalcon\Forms\Element\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Select.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag\Select | | Extends    | AbstractElement |

Component SELECT (choice) for forms


## Властивості
```php
/**
 * @var object|array|null
 */
protected optionsValues;

```

## Методи

```php
public function __construct( string $name, mixed $options = null, array $attributes = [] );
```
Constructor


```php
public function addOption( mixed $option ): ElementInterface;
```
Adds an option to the current options


```php
public function getOptions();
```
Returns the choices' options


```php
public function render( array $attributes = [] ): string;
```
Renders the element widget returning HTML


```php
public function setOptions( mixed $options ): ElementInterface;
```
Set the choice's options


```php
protected function prepareAttributes( array $attributes = [] ): array;
```
Returns an array of prepared attributes for Phalcon\Html\TagFactory helpers according to the element parameters




<h1 id="forms-element-submit">Class Phalcon\Forms\Element\Submit</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Submit.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component INPUT[type=submit] for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputSubmit;

```


<h1 id="forms-element-text">Class Phalcon\Forms\Element\Text</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Text.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Forms\Exception | | Extends    | AbstractElement |

Component INPUT[type=text] for forms



<h1 id="forms-element-textarea">Class Phalcon\Forms\Element\TextArea</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/TextArea.zep)

| Namespace  | Phalcon\Forms\Element | | Uses       | Phalcon\Tag | | Extends    | AbstractElement |

Component TEXTAREA for forms


## Властивості
```php
/**
 * @var string
 */
protected method = inputTextarea;

```


<h1 id="forms-exception">Class Phalcon\Forms\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Exception.zep)

| Namespace  | Phalcon\Forms | | Extends    | \Exception |

Exceptions thrown in Phalcon\Forms will use this class



<h1 id="forms-form">Class Phalcon\Forms\Form</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Form.zep)

| Namespace  | Phalcon\Forms | | Uses       | Countable, Iterator, Phalcon\Di\Injectable, Phalcon\Di\DiInterface, Phalcon\Filter\FilterInterface, Phalcon\Forms\Element\ElementInterface, Phalcon\Html\Attributes, Phalcon\Html\Attributes\AttributesInterface, Phalcon\Html\TagFactory, Phalcon\Messages\Messages, Phalcon\Tag, Phalcon\Filter\Validation, Phalcon\Filter\Validation\ValidationInterface | | Extends    | Injectable | | Implements | Countable, Iterator, AttributesInterface |

This component allows to build forms using an object-oriented interface


## Властивості
```php
/**
 * @var AttributesInterface|null
 */
protected attributes;

/**
 * @var array
 */
protected data;

/**
 * @var array
 */
protected filteredData;

/**
 * @var array
 */
protected elements;

/**
 * @var array
 */
protected elementsIndexed;

/**
 * @var object|null
 */
protected entity;

/**
 * @var Messages|array|null
 */
protected messages;

/**
 * @var int
 */
protected position = 0;

/**
 * @var array
 */
protected options;

/**
 * @var TagFactory|null
 */
protected tagFactory;

/**
 * @var ValidationInterface|null
 */
protected validation;

/**
 * @var array
 */
protected whitelist;

```

## Методи

```php
public function __construct( mixed $entity = null, array $userOptions = [] );
```
Phalcon\Forms\Form constructor


```php
public function add( ElementInterface $element, string $position = null, bool $type = null ): Form;
```
Adds an element to the form


```php
public function bind( array $data, mixed $entity = null, array $whitelist = [] ): Form;
```
Binds data to the entity


```php
public function clear( mixed $fields = null ): Form;
```
Clears every element in the form to its default value


```php
public function count(): int;
```
Returns the number of elements in the form


```php
public function current(): mixed;
```
Returns the current element in the iterator


```php
public function get( string $name ): ElementInterface;
```
Returns an element added to the form by its name


```php
public function getAction(): string;
```
Returns the form's action


```php
public function getAttributes(): Attributes;
```
   Get Form attributes collection

```php
public function getElements(): ElementInterface[];
```
Returns the form elements added to the form


```php
public function getEntity();
```
Returns the entity related to the model


```php
public function getFilteredValue( string $name ): mixed | null;
```
Gets a value from the internal filtered data or calls getValue(name)


```php
public function getLabel( string $name ): string;
```
Returns a label for an element


```php
public function getMessages(): Messages | array;
```
Returns the messages generated in the validation.

```php
if ($form->isValid($_POST) == false) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        echo $message, "<br>";
    }
}
```


```php
public function getMessagesFor( string $name ): Messages;
```
Returns the messages generated for a specific element


```php
public function getTagFactory(): TagFactory | null;
```
Returns the tagFactory object


```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```
Returns the value of an option if present


```php
public function getUserOptions(): array;
```
Returns the options for the element


```php
public function getValidation(): ValidationInterface | null;
```
return ValidationInterface|null


```php
public function getValue( string $name ): mixed | null;
```
Gets a value from the internal related entity or from the default value


```php
public function getWhitelist(): array;
```
return array


```php
public function has( string $name ): bool;
```
Check if the form contains an element


```php
public function hasMessagesFor( string $name ): bool;
```
Check if messages were generated for a specific element


```php
public function isValid( mixed $data = null, mixed $entity = null, array $whitelist = [] ): bool;
```
Validates the form


```php
public function key(): int;
```
Returns the current position/key in the iterator


```php
public function label( string $name, array $attributes = [] ): string;
```
Generate the label of an element added to the form including HTML


```php
public function next(): void;
```
Moves the internal iteration pointer to the next position


```php
public function remove( string $name ): bool;
```
Removes an element from the form


```php
public function render( string $name, array $attributes = [] ): string;
```
Renders a specific item in the form


```php
public function rewind(): void;
```
Rewinds the internal iterator


```php
public function setAction( string $action ): Form;
```
Sets the form's action


```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```
   Set form attributes collection

```php
public function setEntity( mixed $entity ): Form;
```
Sets the entity related to the model


```php
public function setTagFactory( TagFactory $tagFactory ): Form;
```
Sets the tagFactory for the form


```php
public function setUserOption( string $option, mixed $value ): Form;
```
Sets an option for the form


```php
public function setUserOptions( array $options ): Form;
```
Sets options for the element


```php
public function setValidation( ValidationInterface $validation ): Form;
```
Sets the default validation


```php
public function setWhitelist( array $whitelist ): Form;
```
Sets the default whitelist


```php
public function valid(): bool;
```
Check if the current element in the iterator is valid




<h1 id="forms-manager">Class Phalcon\Forms\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Manager.zep)

| Namespace  | Phalcon\Forms |

Forms Manager


## Властивості
```php
/**
 * @var array
 */
protected forms;

```

## Методи

```php
public function create( string $name, mixed $entity = null ): Form;
```
Creates a form registering it in the forms manager


```php
public function get( string $name ): Form;
```
Returns a form by its name


```php
public function has( string $name ): bool;
```
Checks if a form is registered in the forms manager


```php
public function set( string $name, Form $form ): Manager;
```
Registers a form in the Forms Manager


