---
layout: default
language: 'ru-ru'
version: '4.0'
title: 'New Feature Request'
keywords: 'new feature request, nfr'
---

# New Feature Request

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

NFR - это короткий документ, объясняющий, как должен быть подан запрос на новую функцию, как он может быть реализован и как он поможет основным разработчикам, и другим понять как его реализовать.

NFR содержит: * Рекомендуемый синтаксис * Предложенные имена классов и методы * Описание, описывающее использование * Как это может принести пользу фреймворку и сообществу * Если функция уже реализована в других фреймворках, краткое объяснение того, как это было реализовано, и его преимущества

In the following cases a new feature request will be rejected **if**: * The feature makes the framework slow * The feature does not provide any additional value to the framework * The NFR is not clear, bad documentation, unclear explanation, etc. * The NFR has not been discussed with the Team or voted by the community * The NFR does not follow the current guidelines/philosophy of the framework * The NFR affects/breaks applications developed in current/older versions of the framework * The original poster does not provide feedback/input when requested * It's technically impossible to implement * It can only be used in the development/testing stages * Submitted/proposed classes/components don't follow the [Single Responsibility Principle](https://en.wikipedia.org/wiki/Single_responsibility_principle) * Uses static methods - (not allowed)

Для отправки NFR вам не нужно предоставлять Zephir или C код, а также разрабатывать функцию. New Feature requests explain the goal of the intended implementation and start a discussion on how best to implement it.

All NFRs should be posted as a new issue on [GitHub](https://github.com/phalcon/cphalcon/issues). Please make sure to use the prefix `[NFR]` in the title of your issue.