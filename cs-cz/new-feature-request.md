---
layout: default
language: 'cs-cz'
version: '4.0'
title: 'Požadavek na funkcionalitu'
keywords: 'new feature request, nfr'
---

# Požadavek na funkcionalitu

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

[List of NRFs](new-feature-request-list)

A NFR is a short document explaining how a new feature request must be submitted, how it can be implemented, and how it can help core developers and others to understand and implement it.

A NFR contains: * Suggested syntax * Suggested class names and methods * A description detailing the usage * How it can benefit the framework and the community * If the feature is already implemented in other frameworks, a short explanation of how that was implemented and its advantages

In the following cases a new feature request will be rejected **if**: * The feature makes the framework slow * The feature does not provide any additional value to the framework * The NFR is not clear, bad documentation, unclear explanation, etc. * The NFR has not been discussed with the Team or voted by the community * The NFR does not follow the current guidelines/philosophy of the framework * The NFR affects/breaks applications developed in current/older versions of the framework * The original poster does not provide feedback/input when requested * It's technically impossible to implement * It can only be used in the development/testing stages * Submitted/proposed classes/components don't follow the [Single Responsibility Principle](https://en.wikipedia.org/wiki/Single_responsibility_principle) * Uses static methods - (not allowed)

To send a NFR you do not need to provide Zephir or C code or develop the feature. New Feature requests explain the goal of the intended implementation and start a discussion on how best to implement it.

All NFRs should be posted as a new issue on [GitHub](https://github.com/phalcon/cphalcon/issues). Please make sure to use the prefix `[NFR]` in the title of your issue.