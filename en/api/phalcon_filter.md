---
layout: default
language: 'en'
version: '5.0'
title: 'Phalcon\Filter'
---

* [Phalcon\Filter\Exception](#filter-exception)
* [Phalcon\Filter\Filter](#filter-filter)
* [Phalcon\Filter\FilterFactory](#filter-filterfactory)
* [Phalcon\Filter\FilterInterface](#filter-filterinterface)
* [Phalcon\Filter\Sanitize\AbsInt](#filter-sanitize-absint)
* [Phalcon\Filter\Sanitize\Alnum](#filter-sanitize-alnum)
* [Phalcon\Filter\Sanitize\Alpha](#filter-sanitize-alpha)
* [Phalcon\Filter\Sanitize\BoolVal](#filter-sanitize-boolval)
* [Phalcon\Filter\Sanitize\Email](#filter-sanitize-email)
* [Phalcon\Filter\Sanitize\FloatVal](#filter-sanitize-floatval)
* [Phalcon\Filter\Sanitize\IntVal](#filter-sanitize-intval)
* [Phalcon\Filter\Sanitize\Lower](#filter-sanitize-lower)
* [Phalcon\Filter\Sanitize\LowerFirst](#filter-sanitize-lowerfirst)
* [Phalcon\Filter\Sanitize\Regex](#filter-sanitize-regex)
* [Phalcon\Filter\Sanitize\Remove](#filter-sanitize-remove)
* [Phalcon\Filter\Sanitize\Replace](#filter-sanitize-replace)
* [Phalcon\Filter\Sanitize\Special](#filter-sanitize-special)
* [Phalcon\Filter\Sanitize\SpecialFull](#filter-sanitize-specialfull)
* [Phalcon\Filter\Sanitize\StringVal](#filter-sanitize-stringval)
* [Phalcon\Filter\Sanitize\StringValLegacy](#filter-sanitize-stringvallegacy)
* [Phalcon\Filter\Sanitize\Striptags](#filter-sanitize-striptags)
* [Phalcon\Filter\Sanitize\Trim](#filter-sanitize-trim)
* [Phalcon\Filter\Sanitize\Upper](#filter-sanitize-upper)
* [Phalcon\Filter\Sanitize\UpperFirst](#filter-sanitize-upperfirst)
* [Phalcon\Filter\Sanitize\UpperWords](#filter-sanitize-upperwords)
* [Phalcon\Filter\Sanitize\Url](#filter-sanitize-url)
* [Phalcon\Filter\Validation](#filter-validation)
* [Phalcon\Filter\Validation\AbstractCombinedFieldsValidator](#filter-validation-abstractcombinedfieldsvalidator)
* [Phalcon\Filter\Validation\AbstractValidator](#filter-validation-abstractvalidator)
* [Phalcon\Filter\Validation\AbstractValidatorComposite](#filter-validation-abstractvalidatorcomposite)
* [Phalcon\Filter\Validation\Exception](#filter-validation-exception)
* [Phalcon\Filter\Validation\ValidationInterface](#filter-validation-validationinterface)
* [Phalcon\Filter\Validation\Validator\Alnum](#filter-validation-validator-alnum)
* [Phalcon\Filter\Validation\Validator\Alpha](#filter-validation-validator-alpha)
* [Phalcon\Filter\Validation\Validator\Between](#filter-validation-validator-between)
* [Phalcon\Filter\Validation\Validator\Callback](#filter-validation-validator-callback)
* [Phalcon\Filter\Validation\Validator\Confirmation](#filter-validation-validator-confirmation)
* [Phalcon\Filter\Validation\Validator\CreditCard](#filter-validation-validator-creditcard)
* [Phalcon\Filter\Validation\Validator\Date](#filter-validation-validator-date)
* [Phalcon\Filter\Validation\Validator\Digit](#filter-validation-validator-digit)
* [Phalcon\Filter\Validation\Validator\Email](#filter-validation-validator-email)
* [Phalcon\Filter\Validation\Validator\Exception](#filter-validation-validator-exception)
* [Phalcon\Filter\Validation\Validator\ExclusionIn](#filter-validation-validator-exclusionin)
* [Phalcon\Filter\Validation\Validator\File](#filter-validation-validator-file)
* [Phalcon\Filter\Validation\Validator\File\AbstractFile](#filter-validation-validator-file-abstractfile)
* [Phalcon\Filter\Validation\Validator\File\MimeType](#filter-validation-validator-file-mimetype)
* [Phalcon\Filter\Validation\Validator\File\Resolution\Equal](#filter-validation-validator-file-resolution-equal)
* [Phalcon\Filter\Validation\Validator\File\Resolution\Max](#filter-validation-validator-file-resolution-max)
* [Phalcon\Filter\Validation\Validator\File\Resolution\Min](#filter-validation-validator-file-resolution-min)
* [Phalcon\Filter\Validation\Validator\File\Size\Equal](#filter-validation-validator-file-size-equal)
* [Phalcon\Filter\Validation\Validator\File\Size\Max](#filter-validation-validator-file-size-max)
* [Phalcon\Filter\Validation\Validator\File\Size\Min](#filter-validation-validator-file-size-min)
* [Phalcon\Filter\Validation\Validator\Identical](#filter-validation-validator-identical)
* [Phalcon\Filter\Validation\Validator\InclusionIn](#filter-validation-validator-inclusionin)
* [Phalcon\Filter\Validation\Validator\Ip](#filter-validation-validator-ip)
* [Phalcon\Filter\Validation\Validator\Numericality](#filter-validation-validator-numericality)
* [Phalcon\Filter\Validation\Validator\PresenceOf](#filter-validation-validator-presenceof)
* [Phalcon\Filter\Validation\Validator\Regex](#filter-validation-validator-regex)
* [Phalcon\Filter\Validation\Validator\StringLength](#filter-validation-validator-stringlength)
* [Phalcon\Filter\Validation\Validator\StringLength\Max](#filter-validation-validator-stringlength-max)
* [Phalcon\Filter\Validation\Validator\StringLength\Min](#filter-validation-validator-stringlength-min)
* [Phalcon\Filter\Validation\Validator\Uniqueness](#filter-validation-validator-uniqueness)
* [Phalcon\Filter\Validation\Validator\Url](#filter-validation-validator-url)
* [Phalcon\Filter\Validation\ValidatorCompositeInterface](#filter-validation-validatorcompositeinterface)
* [Phalcon\Filter\Validation\ValidatorFactory](#filter-validation-validatorfactory)
* [Phalcon\Filter\Validation\ValidatorInterface](#filter-validation-validatorinterface)

<h1 id="filter-exception">Class Phalcon\Filter\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Exception.zep)

| Namespace  | Phalcon\Filter |
| Extends    | \Exception |

Phalcon\Filter\Exception

Exceptions thrown in Phalcon\Filter will use this class



<h1 id="filter-filter">Class Phalcon\Filter\Filter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Filter.zep)

| Namespace  | Phalcon\Filter |
| Implements | FilterInterface |

Lazy loads, stores and exposes sanitizer objects

@method absint(mixed $input): int
@method alnum(mixed $input): string
@method alpha(mixed $input): string
@method bool(mixed $input): bool
@method email(string $input): string
@method float(mixed $input): float
@method int(string $input): int
@method lower(string $input): string
@method lowerfirst(string $input): string
@method regex(mixed $input, mixed $pattern, mixed $replace): mixed
@method remove(mixed $input, mixed $replace): mixed
@method replace(mixed $input, mixed $source, mixed $target): mixed
@method special(string $input): string
@method specialfull(string $input): string
@method string(string $input): string
@method striptags(string $input): string
@method trim(string $input): string
@method upper(string $input): string
@method upperFirst(string $input): string
@method upperWords(string $input): string|null
@method url(string $input): string|null

@property array $mapper
@property array $services


## Constants
```php
const FILTER_ABSINT = absint;
const FILTER_ALNUM = alnum;
const FILTER_ALPHA = alpha;
const FILTER_BOOL = bool;
const FILTER_EMAIL = email;
const FILTER_FLOAT = float;
const FILTER_INT = int;
const FILTER_LOWER = lower;
const FILTER_LOWERFIRST = lowerfirst;
const FILTER_REGEX = regex;
const FILTER_REMOVE = remove;
const FILTER_REPLACE = replace;
const FILTER_SPECIAL = special;
const FILTER_SPECIALFULL = specialfull;
const FILTER_STRING = string;
const FILTER_STRIPTAGS = striptags;
const FILTER_TRIM = trim;
const FILTER_UPPER = upper;
const FILTER_UPPERFIRST = upperfirst;
const FILTER_UPPERWORDS = upperwords;
const FILTER_URL = url;
```

## Properties
```php
/**
 * @var array
 */
protected mapper;

/**
 * @var array
 */
protected services;

```

## Methods

```php
public function __call( string $name, array $args );
```
Magic call to make the helper objects available as methods.


```php
public function __construct( array $mapper = [] );
```
Filter constructor.


```php
public function get( string $name ): mixed;
```
Get a service. If it is not in the mapper array, create a new object,
set it and then return it.


```php
public function has( string $name ): bool;
```
Checks if a service exists in the map array


```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = bool ): mixed;
```
Sanitizes a value with a specified single or set of sanitizers


```php
public function set( string $name, mixed $service ): void;
```
Set a new service to the mapper array


```php
protected function init( array $mapper ): void;
```
Loads the objects in the internal mapper array




<h1 id="filter-filterfactory">Class Phalcon\Filter\FilterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/FilterFactory.zep)

| Namespace  | Phalcon\Filter |
| Uses       | Phalcon\Filter\Filter |

Class FilterFactory

@package Phalcon\Filter


## Methods

```php
public function newInstance(): FilterInterface;
```
Returns a Locator object with all the helpers defined in anonymous
functions


```php
protected function getServices(): array;
```
Returns the available adapters




<h1 id="filter-filterinterface">Interface Phalcon\Filter\FilterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/FilterInterface.zep)

| Namespace  | Phalcon\Filter |

Lazy loads, stores and exposes sanitizer objects


## Methods

```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = bool ): mixed;
```
Sanitizes a value with a specified single or set of sanitizers




<h1 id="filter-sanitize-absint">Class Phalcon\Filter\Sanitize\AbsInt</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/AbsInt.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\AbsInt

Sanitizes a value to absolute integer


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-alnum">Class Phalcon\Filter\Sanitize\Alnum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Alnum.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Alnum

Sanitizes a value to an alphanumeric value


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-alpha">Class Phalcon\Filter\Sanitize\Alpha</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Alpha.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Alpha

Sanitizes a value to an alpha value


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-boolval">Class Phalcon\Filter\Sanitize\BoolVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/BoolVal.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\BoolVal

Sanitizes a value to boolean


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-email">Class Phalcon\Filter\Sanitize\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Email.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Email

Sanitizes an email string


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-floatval">Class Phalcon\Filter\Sanitize\FloatVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/FloatVal.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\FloatVal

Sanitizes a value to float


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-intval">Class Phalcon\Filter\Sanitize\IntVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/IntVal.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\IntVal

Sanitizes a value to integer


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-lower">Class Phalcon\Filter\Sanitize\Lower</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Lower.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Lower

Sanitizes a value to lowercase


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-lowerfirst">Class Phalcon\Filter\Sanitize\LowerFirst</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/LowerFirst.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\LowerFirst

Sanitizes a value to lcfirst


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-regex">Class Phalcon\Filter\Sanitize\Regex</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Regex.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Regex

Sanitizes a value performing preg_replace


## Methods

```php
public function __invoke( mixed $input, mixed $pattern, mixed $replace );
```





<h1 id="filter-sanitize-remove">Class Phalcon\Filter\Sanitize\Remove</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Remove.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Remove

Sanitizes a value removing parts of a string


## Methods

```php
public function __invoke( mixed $input, mixed $replace );
```





<h1 id="filter-sanitize-replace">Class Phalcon\Filter\Sanitize\Replace</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Replace.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Replace

Sanitizes a value replacing parts of a string


## Methods

```php
public function __invoke( mixed $input, mixed $from, mixed $to );
```





<h1 id="filter-sanitize-special">Class Phalcon\Filter\Sanitize\Special</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Special.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Special

Sanitizes a value special characters


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-specialfull">Class Phalcon\Filter\Sanitize\SpecialFull</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/SpecialFull.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\SpecialFull

Sanitizes a value special characters (htmlspecialchars() and ENT_QUOTES)


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-stringval">Class Phalcon\Filter\Sanitize\StringVal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/StringVal.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Sanitizes a value to string


## Methods

```php
public function __invoke( string $input ): string;
```





<h1 id="filter-sanitize-stringvallegacy">Class Phalcon\Filter\Sanitize\StringValLegacy</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/StringValLegacy.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Sanitizes a value to string using `filter_var()`. The filter provides
backwards compatibility with versions prior to v5. For PHP higher or equal to
8.1, the filter will remain the string unchanged. If anything other than a
string is passed, the method will return false


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-sanitize-striptags">Class Phalcon\Filter\Sanitize\Striptags</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Striptags.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Striptags

Sanitizes a value striptags


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-trim">Class Phalcon\Filter\Sanitize\Trim</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Trim.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Trim

Sanitizes a value removing leading and trailing spaces


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-upper">Class Phalcon\Filter\Sanitize\Upper</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Upper.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Upper

Sanitizes a value to uppercase


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-upperfirst">Class Phalcon\Filter\Sanitize\UpperFirst</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/UpperFirst.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\UpperFirst

Sanitizes a value to ucfirst


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-upperwords">Class Phalcon\Filter\Sanitize\UpperWords</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/UpperWords.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\UpperWords

Sanitizes a value to uppercase the first character of each word


## Methods

```php
public function __invoke( string $input );
```





<h1 id="filter-sanitize-url">Class Phalcon\Filter\Sanitize\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Sanitize/Url.zep)

| Namespace  | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Url

Sanitizes a value url


## Methods

```php
public function __invoke( mixed $input );
```





<h1 id="filter-validation">Class Phalcon\Filter\Validation</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation.zep)

| Namespace  | Phalcon\Filter |
| Uses       | Phalcon\Di\Di, Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Filter\FilterInterface, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Filter\Validation\ValidationInterface, Phalcon\Filter\Validation\Exception, Phalcon\Filter\Validation\ValidatorInterface, Phalcon\Filter\Validation\AbstractCombinedFieldsValidator |
| Extends    | Injectable |
| Implements | ValidationInterface |

Allows to validate data using custom or built-in validators


## Properties
```php
/**
 * @var array
 */
protected combinedFieldsValidators;

/**
 * @var mixed
 */
protected data;

/**
 * @var object|null
 */
protected entity;

/**
 * @var array
 */
protected filters;

/**
 * @var array
 */
protected labels;

/**
 * @var Messages|null
 */
protected messages;

/**
 * List of validators
 *
 * @var array
 */
protected validators;

/**
 * Calculated values
 *
 * @var array
 */
protected values;

```

## Methods

```php
public function __construct( array $validators = [] );
```
Phalcon\Filter\Validation constructor


```php
public function add( mixed $field, ValidatorInterface $validator ): ValidationInterface;
```
Adds a validator to a field


```php
public function appendMessage( MessageInterface $message ): ValidationInterface;
```
Appends a message to the messages list


```php
public function bind( mixed $entity, mixed $data ): ValidationInterface;
```
Assigns the data to an entity
The entity is used to obtain the validation values


```php
public function getData(): mixed
```



```php
public function getEntity(): mixed;
```
Returns the bound entity


```php
public function getFilters( string $field = null ): mixed | null;
```
Returns all the filters or a specific one


```php
public function getLabel( mixed $field ): string;
```
Get label for field


```php
public function getMessages(): Messages;
```
Returns the registered validators


```php
public function getValidators(): array;
```
Returns the validators added to the validation


```php
public function getValue( string $field ): mixed | null;
```
Gets the a value to validate in the array/object data source


```php
public function getValueByData( mixed $data, string $field ): mixed | null;
```
Gets the a value to validate in the array/object data source


```php
public function getValueByEntity( mixed $entity, string $field ): mixed | null;
```
Gets the a value to validate in the object entity source


```php
public function rule( mixed $field, ValidatorInterface $validator ): ValidationInterface;
```
Alias of `add` method


```php
public function rules( mixed $field, array $validators ): ValidationInterface;
```
Adds the validators to a field


```php
public function setEntity( mixed $entity ): void;
```
Sets the bound entity


```php
public function setFilters( mixed $field, mixed $filters ): ValidationInterface;
```
Adds filters to the field


```php
public function setLabels( array $labels ): void;
```
Adds labels for fields


```php
public function setValidators( array $validators )
```



```php
public function validate( mixed $data = null, mixed $entity = null ): Messages;
```
Validate a set of data according to a set of rules


```php
protected function preChecking( mixed $field, ValidatorInterface $validator ): bool;
```
Internal validations, if it returns true, then skip the current validator




<h1 id="filter-validation-abstractcombinedfieldsvalidator">Abstract Class Phalcon\Filter\Validation\AbstractCombinedFieldsValidator</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/AbstractCombinedFieldsValidator.zep)

| Namespace  | Phalcon\Filter\Validation |
| Extends    | AbstractValidator |

This is a base class for combined fields validators



<h1 id="filter-validation-abstractvalidator">Abstract Class Phalcon\Filter\Validation\AbstractValidator</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/AbstractValidator.zep)

| Namespace  | Phalcon\Filter\Validation |
| Uses       | Phalcon\Support\Helper\Arr\Whitelist, Phalcon\Messages\Message, Phalcon\Filter\Validation |
| Implements | ValidatorInterface |

This is a base class for validators


## Properties
```php
/**
    * Message template
    *
    * @var string|null
    */
protected template;

/**
    * Message templates
    *
    * @var array
    */
protected templates;

/**
 * @var array
 */
protected options;

```

## Methods

```php
public function __construct( array $options = [] );
```
Phalcon\Filter\Validation\Validator constructor


```php
public function getOption( string $key, mixed $defaultValue = null ): mixed;
```
Returns an option in the validator's options
Returns null if the option hasn't set


```php
public function getTemplate( string $field = null ): string;
```
Get the template message


```php
public function getTemplates(): array;
```
Get templates collection object


```php
public function hasOption( string $key ): bool;
```
Checks if an option is defined


```php
public function messageFactory( Validation $validation, mixed $field, array $replacements = [] ): Message;
```
Create a default message by factory


```php
public function setOption( string $key, mixed $value ): void;
```
Sets an option in the validator


```php
public function setTemplate( string $template ): ValidatorInterface;
```
   Set a new template message
   
   


```php
public function setTemplates( array $templates ): ValidatorInterface;
```
   Clear current templates and set new from an array,
   
   


```php
abstract public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation


```php
protected function allowEmpty( mixed $field, mixed $value ): bool;
```
Checks if field can be empty.


```php
protected function prepareCode( string $field ): int;
```
Prepares a validation code.


```php
protected function prepareLabel( Validation $validation, string $field ): mixed;
```
Prepares a label for the field.




<h1 id="filter-validation-abstractvalidatorcomposite">Abstract Class Phalcon\Filter\Validation\AbstractValidatorComposite</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/AbstractValidatorComposite.zep)

| Namespace  | Phalcon\Filter\Validation |
| Uses       | Phalcon\Filter\Validation |
| Extends    | AbstractValidator |
| Implements | ValidatorCompositeInterface |

This is a base class for combined fields validators


## Properties
```php
/**
 * @var array
 */
protected validators;

```

## Methods

```php
public function getValidators(): array
```



```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-exception">Class Phalcon\Filter\Validation\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Exception.zep)

| Namespace  | Phalcon\Filter\Validation |
| Extends    | \Exception |

Exceptions thrown in Phalcon\Filter\Validation\* classes will use this class



<h1 id="filter-validation-validationinterface">Interface Phalcon\Filter\Validation\ValidationInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/ValidationInterface.zep)

| Namespace  | Phalcon\Filter\Validation |
| Uses       | Phalcon\Di\Injectable, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages |

Interface for the Phalcon\Filter\Validation component


## Methods

```php
public function add( mixed $field, ValidatorInterface $validator ): ValidationInterface;
```
Adds a validator to a field


```php
public function appendMessage( MessageInterface $message ): ValidationInterface;
```
Appends a message to the messages list


```php
public function bind( mixed $entity, mixed $data ): ValidationInterface;
```
Assigns the data to an entity
The entity is used to obtain the validation values


```php
public function getEntity(): mixed;
```
Returns the bound entity


```php
public function getFilters( string $field = null ): mixed | null;
```
Returns all the filters or a specific one


```php
public function getLabel( string $field ): string;
```
Get label for field


```php
public function getMessages(): Messages;
```
Returns the registered validators


```php
public function getValidators(): array;
```
Returns the validators added to the validation


```php
public function getValue( string $field ): mixed | null;
```
Gets the a value to validate in the array/object data source


```php
public function rule( mixed $field, ValidatorInterface $validator ): ValidationInterface;
```
Alias of `add` method


```php
public function rules( string $field, array $validators ): ValidationInterface;
```
Adds the validators to a field


```php
public function setFilters( string $field, mixed $filters ): ValidationInterface;
```
Adds filters to the field


```php
public function setLabels( array $labels ): void;
```
Adds labels for fields


```php
public function validate( mixed $data = null, mixed $entity = null ): Messages;
```
Validate a set of data according to a set of rules




<h1 id="filter-validation-validator-alnum">Class Phalcon\Filter\Validation\Validator\Alnum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Alnum.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Check for alphanumeric character(s)

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Alnum as AlnumValidator;

$validator = new Validation();

$validator->add(
    "username",
    new AlnumValidator(
        [
            "message" => ":field must contain only alphanumeric characters",
        ]
    )
);

$validator->add(
    [
        "username",
        "name",
    ],
    new AlnumValidator(
        [
            "message" => [
                "username" => "username must contain only alphanumeric characters",
                "name"     => "name must contain only alphanumeric characters",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must contain only letters and numbers;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-alpha">Class Phalcon\Filter\Validation\Validator\Alpha</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Alpha.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Check for alphabetic character(s)

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Alpha as AlphaValidator;

$validator = new Validation();

$validator->add(
    "username",
    new AlphaValidator(
        [
            "message" => ":field must contain only letters",
        ]
    )
);

$validator->add(
    [
        "username",
        "name",
    ],
    new AlphaValidator(
        [
            "message" => [
                "username" => "username must contain only letters",
                "name"     => "name must contain only letters",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must contain only letters;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-between">Class Phalcon\Filter\Validation\Validator\Between</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Between.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Validates that a value is between an inclusive range of two values.
For a value x, the test is passed if minimum<=x<=maximum.

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Between;

$validator = new Validation();

$validator->add(
    "price",
    new Between(
        [
            "minimum" => 0,
            "maximum" => 100,
            "message" => "The price must be between 0 and 100",
        ]
    )
);

$validator->add(
    [
        "price",
        "amount",
    ],
    new Between(
        [
            "minimum" => [
                "price"  => 0,
                "amount" => 0,
            ],
            "maximum" => [
                "price"  => 100,
                "amount" => 50,
            ],
            "message" => [
                "price"  => "The price must be between 0 and 100",
                "amount" => "The amount must be between 0 and 50",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be within the range of :min to :max;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-callback">Class Phalcon\Filter\Validation\Validator\Callback</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Callback.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\ValidatorInterface, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Calls user function for validation

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Callback as CallbackValidator;
use Phalcon\Filter\Validation\Validator\Numericality as NumericalityValidator;

$validator = new Validation();

$validator->add(
    ["user", "admin"],
    new CallbackValidator(
        [
            "message" => "There must be only an user or admin set",
            "callback" => function($data) {
                if (!empty($data->getUser()) && !empty($data->getAdmin())) {
                    return false;
                }

                return true;
            }
        ]
    )
);

$validator->add(
    "amount",
    new CallbackValidator(
        [
            "callback" => function($data) {
                if (!empty($data->getProduct())) {
                    return new NumericalityValidator(
                        [
                            "message" => "Amount must be a number."
                        ]
                    );
                }
            }
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must match the callback function;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-confirmation">Class Phalcon\Filter\Validation\Validator\Confirmation</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Confirmation.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Exception, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks that two values have the same value

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Confirmation;

$validator = new Validation();

$validator->add(
    "password",
    new Confirmation(
        [
            "message" => "Password doesn't match confirmation",
            "with"    => "confirmPassword",
        ]
    )
);

$validator->add(
    [
        "password",
        "email",
    ],
    new Confirmation(
        [
            "message" => [
                "password" => "Password doesn't match confirmation",
                "email"    => "Email doesn't match confirmation",
            ],
            "with" => [
                "password" => "confirmPassword",
                "email"    => "confirmEmail",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be the same as :with;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation


```php
final protected function compare( string $a, string $b ): bool;
```
Compare strings




<h1 id="filter-validation-validator-creditcard">Class Phalcon\Filter\Validation\Validator\CreditCard</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/CreditCard.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks if a value has a valid credit card number

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\CreditCard as CreditCardValidator;

$validator = new Validation();

$validator->add(
    "creditCard",
    new CreditCardValidator(
        [
            "message" => "The credit card number is not valid",
        ]
    )
);

$validator->add(
    [
        "creditCard",
        "secondCreditCard",
    ],
    new CreditCardValidator(
        [
            "message" => [
                "creditCard"       => "The credit card number is not valid",
                "secondCreditCard" => "The second credit card number is not valid",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field is not valid for a credit card number;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-date">Class Phalcon\Filter\Validation\Validator\Date</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Date.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | DateTime, Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks if a value is a valid date

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Date as DateValidator;

$validator = new Validation();

$validator->add(
    "date",
    new DateValidator(
        [
            "format"  => "d-m-Y",
            "message" => "The date is invalid",
        ]
    )
);

$validator->add(
    [
        "date",
        "anotherDate",
    ],
    new DateValidator(
        [
            "format" => [
                "date"        => "d-m-Y",
                "anotherDate" => "Y-m-d",
            ],
            "message" => [
                "date"        => "The date is invalid",
                "anotherDate" => "The another date is invalid",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field is not a valid date;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-digit">Class Phalcon\Filter\Validation\Validator\Digit</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Digit.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Check for numeric character(s)

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Digit as DigitValidator;

$validator = new Validation();

$validator->add(
    "height",
    new DigitValidator(
        [
            "message" => ":field must be numeric",
        ]
    )
);

$validator->add(
    [
        "height",
        "width",
    ],
    new DigitValidator(
        [
            "message" => [
                "height" => "height must be numeric",
                "width"  => "width must be numeric",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be numeric;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-email">Class Phalcon\Filter\Validation\Validator\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Email.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks if a value has a correct e-mail format

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email as EmailValidator;

$validator = new Validation();

$validator->add(
    "email",
    new EmailValidator(
        [
            "message" => "The e-mail is not valid",
        ]
    )
);

$validator->add(
    [
        "email",
        "anotherEmail",
    ],
    new EmailValidator(
        [
            "message" => [
                "email"        => "The e-mail is not valid",
                "anotherEmail" => "The another e-mail is not valid",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be an email address;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-exception">Class Phalcon\Filter\Validation\Validator\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Exception.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Extends    | \Exception |

Exceptions thrown in Phalcon\Filter\Validation\Validator\* classes will use this
class



<h1 id="filter-validation-validator-exclusionin">Class Phalcon\Filter\Validation\Validator\ExclusionIn</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/ExclusionIn.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractValidator |

Check if a value is not included into a list of values

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\ExclusionIn;

$validator = new Validation();

$validator->add(
    "status",
    new ExclusionIn(
        [
            "message" => "The status must not be A or B",
            "domain"  => [
                "A",
                "B",
            ],
        ]
    )
);

$validator->add(
    [
        "status",
        "type",
    ],
    new ExclusionIn(
        [
            "message" => [
                "status" => "The status must not be A or B",
                "type"   => "The type must not be 1 or "
            ],
            "domain" => [
                "status" => [
                    "A",
                    "B",
                ],
                "type"   => [1, 2],
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must not be a part of list: :domain;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file">Class Phalcon\Filter\Validation\Validator\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Support\Helper\Arr\Get, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidatorComposite, Phalcon\Filter\Validation\Validator\File\MimeType, Phalcon\Filter\Validation\Validator\File\Resolution\Equal, Phalcon\Filter\Validation\Validator\File\Resolution\Max, Phalcon\Filter\Validation\Validator\File\Resolution\Min, Phalcon\Filter\Validation\Validator\File\Size\Equal, Phalcon\Filter\Validation\Validator\File\Size\Max, Phalcon\Filter\Validation\Validator\File\Size\Min |
| Extends    | AbstractValidatorComposite |

Checks if a value has a correct file

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File as FileValidator;

$validator = new Validation();

$validator->add(
    "file",
    new FileValidator(
        [
            "maxSize"              => "2M",
            "messageSize"          => ":field exceeds the max file size (:size)",
            "allowedTypes"         => [
                "image/jpeg",
                "image/png",
            ],
            "messageType"          => "Allowed file types are :types",
            "maxResolution"        => "800x600",
            "messageMaxResolution" => "Max resolution of :field is :resolution",
            "messageFileEmpty"     => "File is empty",
            "messageIniSize"       => "Ini size is not valid",
            "messageValid"         => "File is not valid",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new FileValidator(
        [
            "maxSize" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "messageSize" => [
                "file"        => "file exceeds the max file size 2M",
                "anotherFile" => "anotherFile exceeds the max file size 4M",
            "allowedTypes" => [
                "file"        => [
                    "image/jpeg",
                    "image/png",
                ],
                "anotherFile" => [
                    "image/gif",
                    "image/bmp",
                ],
            ],
            "messageType" => [
                "file"        => "Allowed file types are image/jpeg and image/png",
                "anotherFile" => "Allowed file types are image/gif and image/bmp",
            ],
            "maxResolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "messageMaxResolution" => [
                "file"        => "Max resolution of file is 800x600",
                "anotherFile" => "Max resolution of file is 1024x768",
            ],
        ]
    )
);
```


## Methods

```php
public function __construct( array $options = [] );
```
Constructor




<h1 id="filter-validation-validator-file-abstractfile">Abstract Class Phalcon\Filter\Validation\Validator\File\AbstractFile</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/AbstractFile.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks if a value has a correct file

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Size(
        [
            "maxSize"              => "2M",
            "messageSize"          => ":field exceeds the max file size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new FileValidator(
        [
            "maxSize" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "messageSize" => [
                "file"        => "file exceeds the max file size 2M",
                "anotherFile" => "anotherFile exceeds the max file size 4M",
            ],
        ]
    )
);
```


## Properties
```php
/**
 * Empty is empty
 *
 * @var string
 */
protected messageFileEmpty = Field :field must not be empty;

/**
 * File exceeds the file size set in PHP configuration
 *
 * @var string
 */
protected messageIniSize = File :field exceeds the maximum file size;

/**
 * File is not valid
 *
 * @var string
 */
protected messageValid = Field :field is not valid;

```

## Methods

```php
public function checkUpload( Validation $validation, mixed $field ): bool;
```
   Check upload
   
   


```php
public function checkUploadIsEmpty( Validation $validation, mixed $field ): bool;
```
   Check if upload is empty
   
   


```php
public function checkUploadIsValid( Validation $validation, mixed $field ): bool;
```
   Check if upload is valid
   
   


```php
public function checkUploadMaxSize( Validation $validation, mixed $field ): bool;
```
   Check if uploaded file is larger than PHP allowed size
   
   


```php
public function getFileSizeInBytes( string $size ): double;
```
   Convert a string like "2.5MB" in bytes
   
   


```php
public function getMessageFileEmpty(): string
```



```php
public function getMessageIniSize(): string
```



```php
public function getMessageValid(): string
```



```php
public function isAllowEmpty( Validation $validation, string $field ): bool;
```
Check on empty


```php
public function setMessageFileEmpty( string $messageFileEmpty )
```



```php
public function setMessageIniSize( string $messageIniSize )
```



```php
public function setMessageValid( string $messageValid )
```



```php
protected function checkIsUploadedFile( string $name ): bool;
```
Checks if a file has been uploaded; Internal check that can be
overriden in a subclass if you do not want to check uploaded files




<h1 id="filter-validation-validator-file-mimetype">Class Phalcon\Filter\Validation\Validator\File\MimeType</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/MimeType.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractFile |

Checks if a value has a correct file mime type

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\MimeType;

$validator = new Validation();

$validator->add(
    "file",
    new MimeType(
        [
            "types" => [
                "image/jpeg",
                "image/png",
            ],
            "message" => "Allowed file types are :types"
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new MimeType(
        [
            "types" => [
                "file"        => [
                    "image/jpeg",
                    "image/png",
                ],
                "anotherFile" => [
                    "image/gif",
                    "image/bmp",
                ],
            ],
            "message" => [
                "file"        => "Allowed file types are image/jpeg and image/png",
                "anotherFile" => "Allowed file types are image/gif and image/bmp",
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = File :field must be of type: :types;

```

## Methods

```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file-resolution-equal">Class Phalcon\Filter\Validation\Validator\File\Resolution\Equal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/Resolution/Equal.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File\Resolution |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Validator\File\AbstractFile |
| Extends    | AbstractFile |

Checks if a file has the right resolution

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Resolution\Equal;

$validator = new Validation();

$validator->add(
    "file",
    new Equal(
        [
            "resolution" => "800x600",
            "message"    => "The resolution of the field :field has to be equal :resolution",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Equal(
        [
            "resolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "message" => [
                "file"        => "Equal resolution of file has to be 800x600",
                "anotherFile" => "Equal resolution of file has to be 1024x768",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = The resolution of the field :field has to be equal :resolution;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file-resolution-max">Class Phalcon\Filter\Validation\Validator\File\Resolution\Max</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/Resolution/Max.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File\Resolution |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Validator\File\AbstractFile |
| Extends    | AbstractFile |

Checks if a file has the right resolution

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Resolution\Max;

$validator = new Validation();

$validator->add(
    "file",
    new Max(
        [
            "resolution"      => "800x600",
            "message"  => "Max resolution of :field is :resolution",
            "included" => true,
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Max(
        [
            "resolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "Max resolution of file is 800x600",
                "anotherFile" => "Max resolution of file is 1024x768",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = File :field exceeds the maximum resolution of :resolution;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file-resolution-min">Class Phalcon\Filter\Validation\Validator\File\Resolution\Min</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/Resolution/Min.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File\Resolution |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Validator\File\AbstractFile |
| Extends    | AbstractFile |

Checks if a file has the right resolution

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Resolution\Min;

$validator = new Validation();

$validator->add(
    "file",
    new Min(
        [
            "resolution" => "800x600",
            "message"    => "Min resolution of :field is :resolution",
            "included"   => true,
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Min(
        [
            "resolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "Min resolution of file is 800x600",
                "anotherFile" => "Min resolution of file is 1024x768",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = File :field can not have the minimum resolution of :resolution;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file-size-equal">Class Phalcon\Filter\Validation\Validator\File\Size\Equal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/Size/Equal.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File\Size |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Validator\File\AbstractFile |
| Extends    | AbstractFile |

Checks if a value has a correct file

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Equal(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the equal file size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Equal(
        [
            "size" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "file does not have the right file size",
                "anotherFile" => "anotherFile wrong file size (4MB)",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = File :field does not have the exact :size file size;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file-size-max">Class Phalcon\Filter\Validation\Validator\File\Size\Max</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/Size/Max.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File\Size |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Validator\File\AbstractFile |
| Extends    | AbstractFile |

Checks if a value has a correct file

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Max(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the max file size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Max(
        [
            "size" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "file exceeds the max file size 2M",
                "anotherFile" => "anotherFile exceeds the max file size 4M",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = File :field exceeds the size of :size;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-file-size-min">Class Phalcon\Filter\Validation\Validator\File\Size\Min</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/File/Size/Min.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\File\Size |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\Validator\File\AbstractFile |
| Extends    | AbstractFile |

Checks if a value has a correct file

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Min(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the min file size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Min(
        [
            "size" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "file exceeds the min file size 2M",
                "anotherFile" => "anotherFile exceeds the min file size 4M",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = File :field can not have the minimum size of :size;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-identical">Class Phalcon\Filter\Validation\Validator\Identical</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Identical.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks if a value is identical to other

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Identical;

$validator = new Validation();

$validator->add(
    "terms",
    new Identical(
        [
            "accepted" => "yes",
            "message" => "Terms and conditions must be accepted",
        ]
    )
);

$validator->add(
    [
        "terms",
        "anotherTerms",
    ],
    new Identical(
        [
            "accepted" => [
                "terms"        => "yes",
                "anotherTerms" => "yes",
            ],
            "message" => [
                "terms"        => "Terms and conditions must be accepted",
                "anotherTerms" => "Another terms  must be accepted",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field does not have the expected value;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-inclusionin">Class Phalcon\Filter\Validation\Validator\InclusionIn</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/InclusionIn.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractValidator |

Check if a value is included into a list of values

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\InclusionIn;

$validator = new Validation();

$validator->add(
    "status",
    new InclusionIn(
        [
            "message" => "The status must be A or B",
            "domain"  => ["A", "B"],
        ]
    )
);

$validator->add(
    [
        "status",
        "type",
    ],
    new InclusionIn(
        [
            "message" => [
                "status" => "The status must be A or B",
                "type"   => "The status must be 1 or 2",
            ],
            "domain" => [
                "status" => ["A", "B"],
                "type"   => [1, 2],
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be a part of list: :domain;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-ip">Class Phalcon\Filter\Validation\Validator\Ip</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Ip.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator, Phalcon\Messages\Message |
| Extends    | AbstractValidator |

Check for IP addresses

```php
use Phalcon\Filter\Validation\Validator\Ip as IpValidator;

$validator->add(
    "ip_address",
    new IpValidator(
        [
            "message"       => ":field must contain only ip addresses",
            "version"       => IP::VERSION_4 | IP::VERSION_6, // v6 and v4. The same if not specified
            "allowReserved" => false,   // False if not specified. Ignored for v6
            "allowPrivate"  => false,   // False if not specified
            "allowEmpty"    => false,
        ]
    )
);

$validator->add(
    [
        "source_address",
        "destination_address",
    ],
    new IpValidator(
        [
            "message" => [
                "source_address"      => "source_address must be a valid IP address",
                "destination_address" => "destination_address must be a valid IP address",
            ],
            "version" => [
                 "source_address"      => Ip::VERSION_4 | IP::VERSION_6,
                 "destination_address" => Ip::VERSION_4,
            ],
            "allowReserved" => [
                 "source_address"      => false,
                 "destination_address" => true,
            ],
            "allowPrivate" => [
                 "source_address"      => false,
                 "destination_address" => true,
            ],
            "allowEmpty" => [
                 "source_address"      => false,
                 "destination_address" => true,
            ],
        ]
    )
);
```


## Constants
```php
const VERSION_4 = FILTER_FLAG_IPV4;
const VERSION_6 = FILTER_FLAG_IPV6;
```

## Properties
```php
//
protected template = Field :field must be a valid IP address;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-numericality">Class Phalcon\Filter\Validation\Validator\Numericality</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Numericality.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Check for a valid numeric value

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Numericality;

$validator = new Validation();

$validator->add(
    "price",
    new Numericality(
        [
            "message" => ":field is not numeric",
        ]
    )
);

$validator->add(
    [
        "price",
        "amount",
    ],
    new Numericality(
        [
            "message" => [
                "price"  => "price is not numeric",
                "amount" => "amount is not numeric",
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field does not have a valid numeric format;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-presenceof">Class Phalcon\Filter\Validation\Validator\PresenceOf</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/PresenceOf.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Validates that a value is not null or empty string

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\PresenceOf;

$validator = new Validation();

$validator->add(
    "name",
    new PresenceOf(
        [
            "message" => "The name is required",
        ]
    )
);

$validator->add(
    [
        "name",
        "email",
    ],
    new PresenceOf(
        [
            "message" => [
                "name"  => "The name is required",
                "email" => "The email is required",
            ],
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field is required;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-regex">Class Phalcon\Filter\Validation\Validator\Regex</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Regex.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Allows validate if the value of a field matches a regular expression

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Regex as RegexValidator;

$validator = new Validation();

$validator->add(
    "created_at",
    new RegexValidator(
        [
            "pattern" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
            "message" => "The creation date is invalid",
        ]
    )
);

$validator->add(
    [
        "created_at",
        "name",
    ],
    new RegexValidator(
        [
            "pattern" => [
                "created_at" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
                "name"       => "/^[a-z]$/",
            ],
            "message" => [
                "created_at" => "The creation date is invalid",
                "name"       => "The name is invalid",
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field does not match the required format;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-stringlength">Class Phalcon\Filter\Validation\Validator\StringLength</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/StringLength.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation\AbstractValidator, Phalcon\Filter\Validation\AbstractValidatorComposite, Phalcon\Filter\Validation\Validator\StringLength\Max, Phalcon\Filter\Validation\Validator\StringLength\Min, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractValidatorComposite |

Validates that a string has the specified maximum and minimum constraints
The test is passed if for a string's length L, min<=L<=max, i.e. L must
be at least min, and at most max.
Since Phalcon v4.0 this validator works like a container

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\StringLength as StringLength;

$validator = new Validation();

$validation->add(
    "name_last",
    new StringLength(
        [
            "max"             => 50,
            "min"             => 2,
            "messageMaximum"  => "We don't like really long names",
            "messageMinimum"  => "We want more than just their initials",
            "includedMaximum" => true,
            "includedMinimum" => false,
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new StringLength(
        [
            "max" => [
                "name_last"  => 50,
                "name_first" => 40,
            ],
            "min" => [
                "name_last"  => 2,
                "name_first" => 4,
            ],
            "messageMaximum" => [
                "name_last"  => "We don't like really long last names",
                "name_first" => "We don't like really long first names",
            ],
            "messageMinimum" => [
                "name_last"  => "We don't like too short last names",
                "name_first" => "We don't like too short first names",
            ],
            "includedMaximum" => [
                "name_last"  => false,
                "name_first" => true,
            ],
            "includedMinimum" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```


## Methods

```php
public function __construct( array $options = [] );
```
Constructor




<h1 id="filter-validation-validator-stringlength-max">Class Phalcon\Filter\Validation\Validator\StringLength\Max</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/StringLength/Max.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\StringLength |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractValidator |

Validates that a string has the specified maximum constraints
The test is passed if for a string's length L, L<=max, i.e. L must
be at most max.

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

$validator = new Validation();

$validation->add(
    "name_last",
    new Max(
        [
            "max"      => 50,
            "message"  => "We don't like really long names",
            "included" => true
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new Max(
        [
            "max" => [
                "name_last"  => 50,
                "name_first" => 40,
            ],
            "message" => [
                "name_last"  => "We don't like really long last names",
                "name_first" => "We don't like really long first names",
            ],
            "included" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must not exceed :max characters long;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-stringlength-min">Class Phalcon\Filter\Validation\Validator\StringLength\Min</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/StringLength/Min.zep)

| Namespace  | Phalcon\Filter\Validation\Validator\StringLength |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractValidator |

Validates that a string has the specified minimum constraints
The test is passed if for a string's length L, min<=L, i.e. L must
be at least min.

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\StringLength\Min;

$validator = new Validation();

$validation->add(
    "name_last",
    new Min(
        [
            "min"     => 2,
            "message" => "We want more than just their initials",
            "included" => true
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new Min(
        [
            "min" => [
                "name_last"  => 2,
                "name_first" => 4,
            ],
            "message" => [
                "name_last"  => "We don't like too short last names",
                "name_first" => "We don't like too short first names",
            ],
            "included" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be at least :min characters long;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validator-uniqueness">Class Phalcon\Filter\Validation\Validator\Uniqueness</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Uniqueness.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Mvc\Model, Phalcon\Mvc\ModelInterface, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractCombinedFieldsValidator, Phalcon\Filter\Validation\Exception |
| Extends    | AbstractCombinedFieldsValidator |

Check that a field is unique in the related table

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Uniqueness as UniquenessValidator;

$validator = new Validation();

$validator->add(
    "username",
    new UniquenessValidator(
        [
            "model"   => new Users(),
            "message" => ":field must be unique",
        ]
    )
);
```

Different attribute from the field:
```php
$validator->add(
    "username",
    new UniquenessValidator(
        [
            "model"     => new Users(),
            "attribute" => "nick",
        ]
    )
);
```

In model:
```php
$validator->add(
    "username",
    new UniquenessValidator()
);
```

Combination of fields in model:
```php
$validator->add(
    [
        "firstName",
        "lastName",
    ],
    new UniquenessValidator()
);
```

It is possible to convert values before validation. This is useful in
situations where values need to be converted to do the database lookup:

```php
$validator->add(
    "username",
    new UniquenessValidator(
        [
            "convert" => function (array $values) {
                $values["username"] = strtolower($values["username"]);

                return $values;
            }
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be unique;

/**
 * @var array|null
 */
private columnMap;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation


```php
protected function getColumnNameReal( mixed $record, string $field ): string;
```
The column map is used in the case to get real column name


```php
protected function isUniqueness( Validation $validation, mixed $field ): bool;
```



```php
protected function isUniquenessModel( mixed $record, array $field, array $values );
```
Uniqueness method used for model




<h1 id="filter-validation-validator-url">Class Phalcon\Filter\Validation\Validator\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/Validator/Url.zep)

| Namespace  | Phalcon\Filter\Validation\Validator |
| Uses       | Phalcon\Messages\Message, Phalcon\Filter\Validation, Phalcon\Filter\Validation\AbstractValidator |
| Extends    | AbstractValidator |

Checks if a value has a url format

```php
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Url as UrlValidator;

$validator = new Validation();

$validator->add(
    "url",
    new UrlValidator(
        [
            "message" => ":field must be a url",
        ]
    )
);

$validator->add(
    [
        "url",
        "homepage",
    ],
    new UrlValidator(
        [
            "message" => [
                "url"      => "url must be a url",
                "homepage" => "homepage must be a url",
            ]
        ]
    )
);
```


## Properties
```php
//
protected template = Field :field must be a url;

```

## Methods

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validatorcompositeinterface">Interface Phalcon\Filter\Validation\ValidatorCompositeInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/ValidatorCompositeInterface.zep)

| Namespace  | Phalcon\Filter\Validation |
| Uses       | Phalcon\Filter\Validation |

This is a base class for combined fields validators


## Methods

```php
public function getValidators(): array;
```
Executes the validation


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation




<h1 id="filter-validation-validatorfactory">Class Phalcon\Filter\Validation\ValidatorFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/ValidatorFactory.zep)

| Namespace  | Phalcon\Filter\Validation |
| Uses       | Phalcon\Factory\AbstractFactory |
| Extends    | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt
file that was distributed with this source code.


## Methods

```php
public function __construct( array $services = [] );
```
TagFactory constructor.


```php
public function newInstance( string $name ): ValidatorInterface;
```
Creates a new instance


```php
protected function getExceptionClass(): string;
```



```php
protected function getServices(): array;
```
Returns the available adapters




<h1 id="filter-validation-validatorinterface">Interface Phalcon\Filter\Validation\ValidatorInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Filter/Validation/ValidatorInterface.zep)

| Namespace  | Phalcon\Filter\Validation |
| Uses       | Phalcon\Filter\Validation |

Interface for Phalcon\Filter\Validation\AbstractValidator


## Methods

```php
public function getOption( string $key, mixed $defaultValue = null ): mixed;
```
Returns an option in the validator's options
Returns null if the option hasn't set


```php
public function getTemplate( string $field ): string;
```
   Get the template message
   
   


```php
public function getTemplates(): array;
```
   Get message templates
   
   


```php
public function hasOption( string $key ): bool;
```
Checks if an option is defined


```php
public function setTemplate( string $template ): ValidatorInterface;
```
   Set a new template message
   
   


```php
public function setTemplates( array $templates ): ValidatorInterface;
```
   Clear current template and set new from an array,
   
   


```php
public function validate( Validation $validation, mixed $field ): bool;
```
Executes the validation


