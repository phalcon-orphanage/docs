* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

# Požadavek na funkcionalitu

NFR je krátký dokument, který vysvětluje, jak posílat požadavky na novou funkcionalitu, jak může být implementována a jak může pomoci vývojářům frameworku a ostatním porozumnět implementaci.

A NFR contains: * Suggested syntax * Suggested class names and methods * A short documentation * If the feature is already implemented in other frameworks, a short explanation of how that was implemented and its advantages

V následujících případech bude požadavek na funkcionalitu zamítnut: * Funkcionalita způsobí že framework bude pomalý * Funkcionalita nemá přidanou hodnotu pro framework * NFR dokument není jasný, špatně popsaný, špatná dokumentace, apod. * The NFR doesn't follow the current guidelines/philosophy of the framework * The NFR affects/breaks applications developed in current/older versions of the framework * The original poster doesn't provide feedback/input when requested * It's technically impossible to implement * It can only be used in the development/testing stages * Submitted/proposed classes/components don't follow the [Single Responsibility Principle](https://en.wikipedia.org/wiki/Single_responsibility_principle) * Static methods aren't allowed

To send a NFR you don't need to provide Zephir or C code or develop the feature. New Feture requests explain the goal of the intended implementation and open discussion on how best to implement it.

All NFRs should be posted as a new issue on [Github](https://github.com/phalcon/cphalcon/issues).