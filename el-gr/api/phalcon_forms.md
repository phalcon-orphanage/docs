---
layout: default
language: 'el-gr'
version: '4.0'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/AbstractElement.zep)

| Namespace | Phalcon\Forms\Element | | Uses | InvalidArgumentException, Phalcon\Forms\Form, Phalcon\Forms\Exception, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Tag, Phalcon\Validation\ValidatorInterface | | Implements | ElementInterface |

This is a base class for form elements

## Properties

```php
//
protected attributes;

//
protected filters;

//
protected form;

//
protected label;

//
protected messages;

//
protected name;

//
protected options;

/**
 * @var array
 */
protected validators;

//
protected value;

```

## Methods

Phalcon\Forms\Element constructor

```php
public function __construct( string $name, array $attributes = [] );
```

Magic method __toString renders the widget without attributes

```php
public function __toString(): string;
```

Adds a filter to current list of filters

```php
public function addFilter( string $filter ): ElementInterface;
```

Adds a validator to the element

```php
public function addValidator( ValidatorInterface $validator ): ElementInterface;
```

Adds a group of validators

```php
public function addValidators( array $validators, bool $merge = bool ): ElementInterface;
```

Appends a message to the internal message list

```php
public function appendMessage( MessageInterface $message ): ElementInterface;
```

Clears element to its default value

```php
public function clear(): ElementInterface;
```

Returns the value of an attribute if present

```php
public function getAttribute( string $attribute, mixed $defaultValue = null ): mixed;
```

Returns the default attributes for the element

```php
public function getAttributes(): array;
```

Returns the default value assigned to the element

```php
public function getDefault(): mixed;
```

Returns the element filters

```php
public function getFilters();
```

Returns the parent form to the element

```php
public function getForm(): Form;
```

Returns the element label

```php
public function getLabel(): string;
```

Returns the messages that belongs to the element The element needs to be attached to a form

```php
public function getMessages(): Messages;
```

Returns the element name

```php
public function getName(): string;
```

Returns the value of an option if present

```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```

Returns the options for the element

```php
public function getUserOptions(): array;
```

Returns the validators registered for the element

```php
public function getValidators(): ValidatorInterface[];
```

Returns the element's value

```php
public function getValue(): mixed;
```

Checks whether there are messages attached to the element

```php
public function hasMessages(): bool;
```

Generate the HTML to label the element

```php
public function label( array $attributes = [] ): string;
```

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element parameters

```php
public function prepareAttributes( array $attributes = [], bool $useChecked = bool ): array;
```

Sets a default attribute for the element

```php
public function setAttribute( string $attribute, mixed $value ): ElementInterface;
```

Sets default attributes for the element

```php
public function setAttributes( array $attributes ): ElementInterface;
```

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST

```php
public function setDefault( mixed $value ): ElementInterface;
```

Sets the element filters

```php
public function setFilters( mixed $filters ): ElementInterface;
```

Sets the parent form to the element

```php
public function setForm( Form $form ): ElementInterface;
```

Sets the element label

```php
public function setLabel( string $label ): ElementInterface;
```

Sets the validation messages related to the element

```php
public function setMessages( Messages $messages ): ElementInterface;
```

Sets the element name

```php
public function setName( string $name ): ElementInterface;
```

Sets an option for the element

```php
public function setUserOption( string $option, mixed $value ): ElementInterface;
```

Sets options for the element

```php
public function setUserOptions( array $options ): ElementInterface;
```

<h1 id="forms-element-check">Class Phalcon\Forms\Element\Check</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Check.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Check

Component INPUT[type=check] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-date">Class Phalcon\Forms\Element\Date</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Date.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Component INPUT[type=date] for forms

## Methods

Renders the element widget returning html

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-elementinterface">Interface Phalcon\Forms\Element\ElementInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/ElementInterface.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Forms\Form, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Validation\ValidatorInterface |

Interface for Phalcon\Forms\Element classes

## Methods

Adds a filter to current list of filters

```php
public function addFilter( string $filter ): ElementInterface;
```

Adds a validator to the element

```php
public function addValidator( ValidatorInterface $validator ): ElementInterface;
```

Adds a group of validators

```php
public function addValidators( array $validators, bool $merge = bool ): ElementInterface;
```

Appends a message to the internal message list

```php
public function appendMessage( MessageInterface $message ): ElementInterface;
```

Clears every element in the form to its default value

```php
public function clear(): ElementInterface;
```

Returns the value of an attribute if present

```php
public function getAttribute( string $attribute, mixed $defaultValue = null ): mixed;
```

Returns the default attributes for the element

```php
public function getAttributes(): array;
```

Returns the default value assigned to the element

```php
public function getDefault(): mixed;
```

Returns the element's filters

```php
public function getFilters();
```

Returns the parent form to the element

```php
public function getForm(): Form;
```

Returns the element's label

```php
public function getLabel(): string;
```

Returns the messages that belongs to the element The element needs to be attached to a form

```php
public function getMessages(): Messages;
```

Returns the element's name

```php
public function getName(): string;
```

Returns the value of an option if present

```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```

Returns the options for the element

```php
public function getUserOptions(): array;
```

Returns the validators registered for the element

```php
public function getValidators(): ValidatorInterface[];
```

Returns the element's value

```php
public function getValue(): mixed;
```

Checks whether there are messages attached to the element

```php
public function hasMessages(): bool;
```

Generate the HTML to label the element

```php
public function label(): string;
```

Returns an array of prepared attributes for Phalcon\Tag helpers according to the element's parameters

```php
public function prepareAttributes( array $attributes = [], bool $useChecked = bool ): array;
```

Renders the element widget

```php
public function render( array $attributes = [] ): string;
```

Sets a default attribute for the element

```php
public function setAttribute( string $attribute, mixed $value ): ElementInterface;
```

Sets default attributes for the element

```php
public function setAttributes( array $attributes ): ElementInterface;
```

Sets a default value in case the form does not use an entity or there is no value available for the element in _POST

```php
public function setDefault( mixed $value ): ElementInterface;
```

Sets the element's filters

```php
public function setFilters( mixed $filters ): ElementInterface;
```

Sets the parent form to the element

```php
public function setForm( Form $form ): ElementInterface;
```

Sets the element label

```php
public function setLabel( string $label ): ElementInterface;
```

Sets the validation messages related to the element

```php
public function setMessages( Messages $messages ): ElementInterface;
```

Sets the element's name

```php
public function setName( string $name ): ElementInterface;
```

Sets an option for the element

```php
public function setUserOption( string $option, mixed $value ): ElementInterface;
```

Sets options for the element

```php
public function setUserOptions( array $options ): ElementInterface;
```

<h1 id="forms-element-email">Class Phalcon\Forms\Element\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Email.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Email

Component INPUT[type=email] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-file">Class Phalcon\Forms\Element\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/File.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Component INPUT[type=file] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-hidden">Class Phalcon\Forms\Element\Hidden</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Hidden.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Hidden

Component INPUT[type=hidden] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-numeric">Class Phalcon\Forms\Element\Numeric</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Numeric.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Numeric

Component INPUT[type=number] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-password">Class Phalcon\Forms\Element\Password</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Password.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Password

Component INPUT[type=password] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-radio">Class Phalcon\Forms\Element\Radio</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Radio.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Radio

Component INPUT[type=radio] for forms

## Methods

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-select">Class Phalcon\Forms\Element\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Select.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag\Select | | Extends | AbstractElement |

Phalcon\Forms\Element\Select

Component SELECT (choice) for forms

## Properties

```php
//
protected optionsValues;

```

## Methods

Phalcon\Forms\Element constructor

```php
public function __construct( string $name, mixed $options = null, mixed $attributes = null );
```

Adds an option to the current options

```php
public function addOption( mixed $option ): ElementInterface;
```

Returns the choices' options

```php
public function getOptions();
```

Renders the element widget returning HTML

```php
public function render( array $attributes = [] ): string;
```

Set the choice's options

```php
public function setOptions( mixed $options ): ElementInterface;
```

<h1 id="forms-element-submit">Class Phalcon\Forms\Element\Submit</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Submit.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Component INPUT[type=submit] for forms

## Methods

Renders the element widget

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-text">Class Phalcon\Forms\Element\Text</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/Text.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Text

Component INPUT[type=text] for forms

## Methods

Renders the element widget

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-element-textarea">Class Phalcon\Forms\Element\TextArea</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Element/TextArea.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Component TEXTAREA for forms

## Methods

Renders the element widget

```php
public function render( array $attributes = [] ): string;
```

<h1 id="forms-exception">Class Phalcon\Forms\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Exception.zep)

| Namespace | Phalcon\Forms | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Forms will use this class

<h1 id="forms-form">Class Phalcon\Forms\Form</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Form.zep)

| Namespace | Phalcon\Forms | | Uses | Countable, Iterator, Phalcon\Di\Injectable, Phalcon\Di\DiInterface, Phalcon\Filter\FilterInterface, Phalcon\Forms\Element\ElementInterface, Phalcon\Html\Attributes, Phalcon\Html\Attributes\AttributesInterface, Phalcon\Messages\Messages, Phalcon\Tag, Phalcon\Validation, Phalcon\Validation\ValidationInterface | | Extends | Injectable | | Implements | Countable, Iterator, AttributesInterface |

This component allows to build forms using an object-oriented interface

## Properties

```php
/**
 * @var Attributes | null
 */
protected attributes;

//
protected data;

//
protected elements;

//
protected elementsIndexed;

//
protected entity;

//
protected messages;

//
protected position;

//
protected options;

//
protected validation;

```

## Methods

Phalcon\Forms\Form constructor

```php
public function __construct( mixed $entity = null, array $userOptions = [] );
```

Adds an element to the form

```php
public function add( ElementInterface $element, string $position = null, bool $type = null ): Form;
```

Binds data to the entity

```php
public function bind( array $data, mixed $entity, mixed $whitelist = null ): Form;
```

Clears every element in the form to its default value

```php
public function clear( mixed $fields = null ): Form;
```

Returns the number of elements in the form

```php
public function count(): int;
```

Returns the current element in the iterator

```php
public function current(): ElementInterface | bool;
```

Returns an element added to the form by its name

```php
public function get( string $name ): ElementInterface;
```

Returns the form's action

```php
public function getAction(): string;
```

Get Form attributes collection

```php
public function getAttributes(): Attributes;
```

Returns the form elements added to the form

```php
public function getElements(): ElementInterface[];
```

Returns the entity related to the model

```php
public function getEntity();
```

Returns a label for an element

```php
public function getLabel( string $name ): string;
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
public function getMessages(): Messages | array;
```

Returns the messages generated for a specific element

```php
public function getMessagesFor( string $name ): Messages;
```

Returns the value of an option if present

```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```

Returns the options for the element

```php
public function getUserOptions(): array;
```

```php
public function getValidation()
```

Gets a value from the internal related entity or from the default value

```php
public function getValue( string $name ): mixed | null;
```

Check if the form contains an element

```php
public function has( string $name ): bool;
```

Check if messages were generated for a specific element

```php
public function hasMessagesFor( string $name ): bool;
```

Validates the form

```php
public function isValid( mixed $data = null, mixed $entity = null ): bool;
```

Returns the current position/key in the iterator

```php
public function key(): int;
```

Generate the label of an element added to the form including HTML

```php
public function label( string $name, array $attributes = null ): string;
```

Moves the internal iteration pointer to the next position

```php
public function next(): void;
```

Removes an element from the form

```php
public function remove( string $name ): bool;
```

Renders a specific item in the form

```php
public function render( string $name, array $attributes = [] ): string;
```

Rewinds the internal iterator

```php
public function rewind(): void;
```

Sets the form's action

```php
public function setAction( string $action ): Form;
```

Set form attributes collection

```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```

Sets the entity related to the model

```php
public function setEntity( mixed $entity ): Form;
```

Sets an option for the form

```php
public function setUserOption( string $option, mixed $value ): Form;
```

Sets options for the element

```php
public function setUserOptions( array $options ): Form;
```

```php
public function setValidation( $validation )
```

Check if the current element in the iterator is valid

```php
public function valid(): bool;
```

<h1 id="forms-manager">Class Phalcon\Forms\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Forms/Manager.zep)

| Namespace | Phalcon\Forms |

Forms Manager

## Properties

```php
//
protected forms;

```

## Methods

Creates a form registering it in the forms manager

```php
public function create( string $name, mixed $entity = null ): Form;
```

Returns a form by its name

```php
public function get( string $name ): Form;
```

Checks if a form is registered in the forms manager

```php
public function has( string $name ): bool;
```

Registers a form in the Forms Manager

```php
public function set( string $name, Form $form ): Manager;
```