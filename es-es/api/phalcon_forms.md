---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/AbstractElement.zep)

| Namespace | Phalcon\Forms\Element | | Uses | InvalidArgumentException, Phalcon\Forms\Form, Phalcon\Forms\Exception, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Tag, Phalcon\Validation\ValidatorInterface | | Implements | ElementInterface |

Esta es una clase base para elementos de formulario

## Propiedades

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

## Métodos

```php
public function __construct( string $name, array $attributes = [] );
```

Phalcon\Forms\Element constructor

```php
public function __toString(): string;
```

El método mágico __toString renderiza el widget sin atributos

```php
public function addFilter( string $filter ): ElementInterface;
```

Añade un filtro a la lista actual de filtros

```php
public function addValidator( ValidatorInterface $validator ): ElementInterface;
```

Añade una validación al elemento

```php
public function addValidators( array $validators, bool $merge = bool ): ElementInterface;
```

Añade un grupo de validaciones

```php
public function appendMessage( MessageInterface $message ): ElementInterface;
```

Añade un mensaje a la lista interna de mensajes

```php
public function clear(): ElementInterface;
```

Restablece el elemento a su valor por defecto

```php
public function getAttribute( string $attribute, mixed $defaultValue = null ): mixed;
```

Devuelve el valor de un atributo si existe

```php
public function getAttributes(): array;
```

Devuelve los valores por defecto de los atributos del elemento

```php
public function getDefault(): mixed;
```

Devuelve el valor por defecto asignado al elemento

```php
public function getFilters();
```

Devuelve los filtros del elemento

```php
public function getForm(): Form;
```

Devuelve el formulario padre al elemento

```php
public function getLabel(): string;
```

Devuelve la etiqueta del elemento

```php
public function getMessages(): Messages;
```

Devuelve los mensajes que pertenecen al elemento El elemento necesita ser parte de un formulario

```php
public function getName(): string;
```

Devuelve el nombre del elemento

```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```

Devuelve el valor de una opción si existe

```php
public function getUserOptions(): array;
```

Devuelve las opciones del elemento

```php
public function getValidators(): ValidatorInterface[];
```

Devuelve los validadores registrados para el elemento

```php
public function getValue(): mixed;
```

Devuelve el valor del elemento

```php
public function hasMessages(): bool;
```

Comprueba si hay mensajes vinculados al elemento

```php
public function label( array $attributes = [] ): string;
```

Genera el HTML para etiquetar al elemento

```php
public function prepareAttributes( array $attributes = [], bool $useChecked = bool ): array;
```

Devuelve un vector de atributos preparados para ayudantes Phalcon\Tag en base a los parámetros de los elementos

```php
public function setAttribute( string $attribute, mixed $value ): ElementInterface;
```

Establece un atributo predeterminado para el elemento

```php
public function setAttributes( array $attributes ): ElementInterface;
```

Establece atributos predeterminados para el elemento

```php
public function setDefault( mixed $value ): ElementInterface;
```

Establece un valor predeterminado en caso de que el formulario no use una entidad o no tenga ningún valor disponible para el elemento en el _POST

```php
public function setFilters( mixed $filters ): ElementInterface;
```

Establece los filtros del elemento

```php
public function setForm( Form $form ): ElementInterface;
```

Establece el formulario padre del elemento

```php
public function setLabel( string $label ): ElementInterface;
```

Establece la etiqueta del elemento

```php
public function setMessages( Messages $messages ): ElementInterface;
```

Establece los mensajes de validación relacionados con el elemento

```php
public function setName( string $name ): ElementInterface;
```

Establece el nombre del elemento

```php
public function setUserOption( string $option, mixed $value ): ElementInterface;
```

Establece una opción para el elemento

```php
public function setUserOptions( array $options ): ElementInterface;
```

Establece las opciones para el elemento

<h1 id="forms-element-check">Class Phalcon\Forms\Element\Check</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Check.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Check

Componente INPUT[type=check] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-date">Class Phalcon\Forms\Element\Date</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Date.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Componente INPUT[type=date] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo html

<h1 id="forms-element-elementinterface">Interface Phalcon\Forms\Element\ElementInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/ElementInterface.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Forms\Form, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Validation\ValidatorInterface |

Interfaz para clases Phalcon\Forms\Element

## Métodos

```php
public function addFilter( string $filter ): ElementInterface;
```

Añade un filtro a la lista actual de filtros

```php
public function addValidator( ValidatorInterface $validator ): ElementInterface;
```

Añade una validación al elemento

```php
public function addValidators( array $validators, bool $merge = bool ): ElementInterface;
```

Añade un grupo de validaciones

```php
public function appendMessage( MessageInterface $message ): ElementInterface;
```

Añade un mensaje a la lista interna de mensajes

```php
public function clear(): ElementInterface;
```

Restaura cada elemento del formulario a su valor predeterminado

```php
public function getAttribute( string $attribute, mixed $defaultValue = null ): mixed;
```

Devuelve el valor de un atributo si existe

```php
public function getAttributes(): array;
```

Devuelve los valores por defecto de los atributos del elemento

```php
public function getDefault(): mixed;
```

Devuelve el valor por defecto asignado al elemento

```php
public function getFilters();
```

Devuelve los filtros del elemento

```php
public function getForm(): Form;
```

Devuelve el formulario padre al elemento

```php
public function getLabel(): string;
```

Devuelve la etiqueta del elemento

```php
public function getMessages(): Messages;
```

Devuelve los mensajes que pertenecen al elemento El elemento necesita adjuntarse a un formulario

```php
public function getName(): string;
```

Devuelve el nombre del elemento

```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```

Devuelve el valor de una opción si existe

```php
public function getUserOptions(): array;
```

Devuelve las opciones del elemento

```php
public function getValidators(): ValidatorInterface[];
```

Devuelve los validadores registrados para el elemento

```php
public function getValue(): mixed;
```

Devuelve el valor del elemento

```php
public function hasMessages(): bool;
```

Comprueba si hay mensajes vinculados al elemento

```php
public function label(): string;
```

Genera el HTML para etiquetar al elemento

```php
public function prepareAttributes( array $attributes = [], bool $useChecked = bool ): array;
```

Devuelve un vector de atributos preparados para los ayudantes Phalcon\Tag en base a los parámetros de los elementos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento

```php
public function setAttribute( string $attribute, mixed $value ): ElementInterface;
```

Establece un atributo predeterminado para el elemento

```php
public function setAttributes( array $attributes ): ElementInterface;
```

Establece los atributos predeterminados para el elemento

```php
public function setDefault( mixed $value ): ElementInterface;
```

Establece un valor predeterminado en caso de que el formulario no use una entidad o no tenga ningún valor disponible para el elemento en el _POST

```php
public function setFilters( mixed $filters ): ElementInterface;
```

Establece los filtros del elemento

```php
public function setForm( Form $form ): ElementInterface;
```

Establece el formulario padre del elemento

```php
public function setLabel( string $label ): ElementInterface;
```

Establece la etiqueta del elemento

```php
public function setMessages( Messages $messages ): ElementInterface;
```

Establece los mensajes de validación relacionados con el elemento

```php
public function setName( string $name ): ElementInterface;
```

Establece el nombre del elemento

```php
public function setUserOption( string $option, mixed $value ): ElementInterface;
```

Establece una opción para el elemento

```php
public function setUserOptions( array $options ): ElementInterface;
```

Establece las opciones para el elemento

<h1 id="forms-element-email">Class Phalcon\Forms\Element\Email</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Email.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Email

Componente INPUT[type=email] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-file">Class Phalcon\Forms\Element\File</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/File.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Componente INPUT[type=file] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-hidden">Class Phalcon\Forms\Element\Hidden</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Hidden.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Hidden

Componente INPUT[type=hidden] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-numeric">Class Phalcon\Forms\Element\Numeric</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Numeric.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Numeric

Componente INPUT[type=number] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-password">Class Phalcon\Forms\Element\Password</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Password.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Password

Componente INPUT[type=password] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-radio">Class Phalcon\Forms\Element\Radio</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Radio.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Radio

Componente INPUT[type=radio] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

<h1 id="forms-element-select">Class Phalcon\Forms\Element\Select</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Select.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag\Select | | Extends | AbstractElement |

Phalcon\Forms\Element\Select

Componente SELECT (elección) para formularios

## Propiedades

```php
//
protected optionsValues;

```

## Métodos

```php
public function __construct( string $name, mixed $options = null, mixed $attributes = null );
```

Constructor Phalcon\Forms\Element

```php
public function addOption( mixed $option ): ElementInterface;
```

Añade una opción a las opciones actuales

```php
public function getOptions();
```

Devuelve las opciones de selección

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento devolviendo HTML

```php
public function setOptions( mixed $options ): ElementInterface;
```

Establece las opciones a elegir

<h1 id="forms-element-submit">Class Phalcon\Forms\Element\Submit</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Submit.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Componente INPUT[type=submit] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento

<h1 id="forms-element-text">Class Phalcon\Forms\Element\Text</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/Text.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Phalcon\Forms\Element\Text

Componente INPUT[type=text] para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento

<h1 id="forms-element-textarea">Class Phalcon\Forms\Element\TextArea</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Element/TextArea.zep)

| Namespace | Phalcon\Forms\Element | | Uses | Phalcon\Tag | | Extends | AbstractElement |

Componente TEXTAREA para formularios

## Métodos

```php
public function render( array $attributes = [] ): string;
```

Renderiza el widget del elemento

<h1 id="forms-exception">Class Phalcon\Forms\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Exception.zep)

| Namespace | Phalcon\Forms | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Forms usarán esta clase

<h1 id="forms-form">Class Phalcon\Forms\Form</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Form.zep)

| Namespace | Phalcon\Forms | | Uses | Countable, Iterator, Phalcon\Di\Injectable, Phalcon\Di\DiInterface, Phalcon\Filter\FilterInterface, Phalcon\Forms\Element\ElementInterface, Phalcon\Html\Attributes, Phalcon\Html\Attributes\AttributesInterface, Phalcon\Messages\Messages, Phalcon\Tag, Phalcon\Validation, Phalcon\Validation\ValidationInterface | | Extends | Injectable | | Implements | Countable, Iterator, AttributesInterface |

Este componente permite construir formularios usando un interfaz orientado a objetos

## Propiedades

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

## Métodos

```php
public function __construct( mixed $entity = null, array $userOptions = [] );
```

Constructor Phalcon\Forms\Form

```php
public function add( ElementInterface $element, string $position = null, bool $type = null ): Form;
```

Añade un elemento al formulario

```php
public function bind( array $data, mixed $entity, mixed $whitelist = null ): Form;
```

Vincula datos a la entidad

```php
public function clear( mixed $fields = null ): Form;
```

Restaura cada elemento del formulario a sus valores predeterminados

```php
public function count(): int;
```

Devuelve el número de elementos del formulario

```php
public function current(): ElementInterface | bool;
```

Devuelve el elemento actual de la iteración

```php
public function get( string $name ): ElementInterface;
```

Devuelve un elemento añadido al formulario por su nombre

```php
public function getAction(): string;
```

Devuelve la acción del formulario

```php
public function getAttributes(): Attributes;
```

Devuelve la colección de atributos del Formulario

```php
public function getElements(): ElementInterface[];
```

Devuelve los elementos añadidos al formulario

```php
public function getEntity();
```

Devuelve la entidad relacionada con el modelo

```php
public function getLabel( string $name ): string;
```

Devuelve una etiqueta para un elemento

```php
public function getMessages(): Messages | array;
```

Devuelve los mensajes generados en la validación.

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

Devuelve los mensajes generados para un elemento específico

```php
public function getUserOption( string $option, mixed $defaultValue = null ): mixed;
```

Devuelve el valor de una opción si existe

```php
public function getUserOptions(): array;
```

Devuelve las opciones del elemento

```php
public function getValidation()
```

```php
public function getValue( string $name ): mixed | null;
```

Obtiene un valor de la entidad interna relacionada o del valor por defecto

```php
public function has( string $name ): bool;
```

Comprueba si el formulario contiene un elemento

```php
public function hasMessagesFor( string $name ): bool;
```

Comprueba si se han generado mensajes para un elemento específico

```php
public function isValid( mixed $data = null, mixed $entity = null ): bool;
```

Valida el formulario

```php
public function key(): int;
```

Devuelve la posición/clave actual del iterador

```php
public function label( string $name, array $attributes = null ): string;
```

Genera la etiqueta de un elemento añadido al formulario incluyendo HTML

```php
public function next(): void;
```

Mueve el puntero interno de iteración a la siguiente posición

```php
public function remove( string $name ): bool;
```

Elimina un elemento del formulario

```php
public function render( string $name, array $attributes = [] ): string;
```

Renderiza un objeto específico en el formulario

```php
public function rewind(): void;
```

Rebobina el iterador interno

```php
public function setAction( string $action ): Form;
```

Establece la acción del formulario

```php
public function setAttributes( Attributes $attributes ): AttributesInterface;
```

Establece la colección de atributos del formulario

```php
public function setEntity( mixed $entity ): Form;
```

Establece la entidad relacionada con el modelo

```php
public function setUserOption( string $option, mixed $value ): Form;
```

Establece una opción para el formulario

```php
public function setUserOptions( array $options ): Form;
```

Establece las opciones para el elemento

```php
public function setValidation( $validation )
```

```php
public function valid(): bool;
```

Comprueba si el elemento actual en el iterador es válido

<h1 id="forms-manager">Class Phalcon\Forms\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Forms/Manager.zep)

| Namespace | Phalcon\Forms |

Gestor de Formularios

## Propiedades

```php
//
protected forms;

```

## Métodos

```php
public function create( string $name, mixed $entity = null ): Form;
```

Crea un formulario registrándolo en el gestor de formularios

```php
public function get( string $name ): Form;
```

Devuelve un formulario por su nombre

```php
public function has( string $name ): bool;
```

Comprueba si un formulario está registrado en el gestor de formularios

```php
public function set( string $name, Form $form ): Manager;
```

Registra un formulario en el Gestor de Formularios
