# Phalcon Framework Documentation

## Welcome

This is the repository for the Phalcon documentation. Our documentation is
hosted on [Read The Docs](http://www.readthedocs.org) which is automatically
updated when any changes are made to this repository.

You are welcome to fork this repository and add, correct, enhance the
documentation yourselves.

The documentation written using [reStructuredText](http://sphinx.pocoo.org/rest.html) and is available in 8 different languages:

* [English](https://docs.phalconphp.com/en/latest/index.html)
* [Chinese](https://docs.phalconphp.com/zh/latest/index.html)
* [French](https://docs.phalconphp.com/fr/latest/index.html)
* [Japanese](https://docs.phalconphp.com/ja/latest/index.html)
* [Polish](https://docs.phalconphp.com/pl/latest/index.html)
* [Portuguese](https://docs.phalconphp.com/pt/latest/index.html)
* [Russian](https://docs.phalconphp.com/ru/latest/index.html)
* [Spanish](https://docs.phalconphp.com/es/latest/index.html)

## API
The API is automatically generated from the C sources using the following command:

```
$ php scripts/gen-api.php
```

If you find an error or want to improve it, please send a pull request to https://github.com/phalcon/cphalcon

## How to update translations

Update base RST files and `transifex/strings/en.json`:

```
$ php generate-trstrings.php
```

Update `transifex/strings/<lang>.json`.

Then update language RST files:

```
$ php update-rst.php <lang>
```

And build html:

```
$ cd <lang>
$ make html
```

## Limitations

### Tables

Only simple [grid tables](http://docutils.sourceforge.net/docs/ref/rst/restructuredtext.html#grid-tables) like below are supported.

```
+----------+----------+----------+
| Column A | Column B | Column C |
+==========+==========+==========+
| Item A   | Item B   | Item C   |
+----------+----------+----------+
| Item A   | Item B   | Item C   |
+----------+----------+----------+
```

And you should escape `|` in data as `\|`.

Spanning columns and rows is not supported.

[Simple tables](http://docutils.sourceforge.net/docs/ref/rst/restructuredtext.html#simple-tables) are not supported.
