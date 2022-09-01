---
layout: default
language: 'ko-kr'
version: '5.0'
title: 'Breadcrumbs'
keywords: 'html, breadcrumbs, tag, tag factory'
---

# HTML Components
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요
A common piece of HTML that is present in many web applications is the breadcrumbs. These are links separated by a space or by the `/` character usually, that represent the tree structure of an application. The purpose is to give users another easy visual way to navigate throughout the application.

An example is an application that has an `admin` module, an `invoices` area and a `view invoice` page. Usually, you would select the `admin` module, then from the links you will choose `invoices` (list) and then clicking on one of the invoices in the list, you can view it. To represent this tree like structure, the breadcrumbs displayed could be:

```php
Home / Admin / Invoices / Viewing Invoice [1234]
```
Each of the words above (apart from the last one) are links to the respective pages. This way the user can quickly navigate back to a different area without having to click the back button or use another menu.

[Phalcon\Html\Breadcrumbs][html-breadcrumbs] offers functionality to add text and URLs. The resulting HTML when calling `render()` will have each breadcrumb enclosed in `<dt>` tags, while the whole string is enclosed in `<dl>` tags.

### Methods
```php
public function add(
    string $label, 
    string $link = ""
): Breadcrumbs
```
Adds a new crumb.

In the example below, add a crumb with a link and then add a crumb without a link (normally the last one)

```php
$breadcrumbs
    ->add("Home", "/")
    ->add("Users")
;
```

```php
public function clear(): void
```
Clears the crumbs

```php
$breadcrumbs->clear()
```

```php
public function getSeparator(): string
```
Returns the separator used for the breadcrumbs

```php
public function remove(string $link): void
```
Removes crumb by url.

In the example below remove a crumb by URL and also remove a crumb without an url (last link)

```php
$breadcrumbs->remove("/admin/user/create");
$breadcrumbs->remove();
```

```php
public function render(): string
```
Renders and outputs breadcrumbs HTML. The template used is:

```html
<dl>
    <dt><a href="Hyperlink">Text</a></dt> / 
    <dt><a href="Hyperlink">Text</a></dt> / 
    <dt>Text</dt>
</dl>
```
The last set crumb will not have a link and will only have its text displayed. Each crumb is wrapped in `<dt></dt>` tags. The whole collection is wrapped in `<dl></dl>` tags. You can use them in conjunction with CSS to format the crumbs on screen according to the needs of your application.

```php
echo $breadcrumbs->render();
```

```php
public function setSeparator(string $separator)
```
The default separator between the crumbs is `/`. You can set a different one if you wish using this method.

```php
$breadcrumbs->setSeparator('-');
```

```php
public function toArray(): array
```
Returns the internal breadcrumbs array

[html-breadcrumbs]: api/phalcon_html#html-breadcrumbs
