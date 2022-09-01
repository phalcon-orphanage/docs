---
layout: default
language: 'es-es'
version: '5.0'
title: 'Migas de Pan'
keywords: 'html, breadcrumbs, tag, tag factory'
---

# HTML Components
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Una pieza común de HTML que está presente en muchas aplicaciones web son las migas de pan. Son enlaces separados normalmente por un espacio o por el carácter `/`, que representa la estructura jerárquica de una aplicación. El propósito es dar a los usuarios otra forma visual sencilla para navegar por la aplicación.

Un ejemplo es una aplicación que tiene un módulo `admin`, un área `facturas` y una página `ver factura`. Usualmente, seleccionarías el módulo `admin`, entonces desde los enlaces seleccionarías `facturas` (lista) y entonces pulsando sobre una de las facturas de la lista, podrías verla. Para representar esta estructura jerárquica, las migas de pan mostradas podrían ser:

```php
Inicio / Admin / Facturas / Viendo Factura [1234]
```
Cada una de las palabras anteriores (excepto la última) son enlaces a sus respectivas páginas. De esta forma, el usuario puede navegar rápidamente hacia las diferentes áreas sin tener que volver atrás o usar otro menú.

[Phalcon\Html\Breadcrumbs][html-breadcrumbs] offers functionality to add text and URLs. El HTML resultante cuando se llama a `render()` tendrá cada miga de pan encerrada en etiquetas `<dt>`, mientras que la cadena global lo estará en etiquetas `<dl>`.

### Métodos
```php
public function add(
    string $label, 
    string $link = ""
): Breadcrumbs
```
Añade una nueva miga.

En el ejemplo posterior, añade una miga con un enlace y luego añade una miga sin enlace (normalmente el último)

```php
$breadcrumbs
    ->add("Home", "/")
    ->add("Users")
;
```

```php
public function clear(): void
```
Limpia las migas

```php
$breadcrumbs->clear()
```

```php
public function getSeparator(): string
```
Devuelve el separador usado para las migas de pan

```php
public function remove(string $link): void
```
Elimina una miga por url.

En el ejemplo posterior elimina una miga mediante URL y también elimina una miga sin url (último enlace)

```php
$breadcrumbs->remove("/admin/user/create");
$breadcrumbs->remove();
```

```php
public function render(): string
```
Renderiza y muestra las migas de pan HTML. La plantilla usada es:

```html
<dl>
    <dt><a href="Hyperlink">Texto</a></dt> / 
    <dt><a href="Hyperlink">Texto</a></dt> / 
    <dt>Texto</dt>
</dl>
```
El último conjunto de migas no tendrá enlace y sólo mostrará su texto. Cada miga está envuelta en etiquetas `<dt></dt>`. La colección entera está envuelta en etiquetas `<dl></dl>`. Puede usarlas en conjunto con CSS para formatear las migas en pantalla acorde a las necesidades de su aplicación.

```php
echo $breadcrumbs->render();
```

```php
public function setSeparator(string $separator)
```
El separador por defecto entre las migas es `/`. Puede configurar uno diferente si lo desea usando este método.

```php
$breadcrumbs->setSeparator('-');
```

```php
public function toArray(): array
```
Devuelve el vector de migas de pan interno

[html-breadcrumbs]: api/phalcon_html#html-breadcrumbs
