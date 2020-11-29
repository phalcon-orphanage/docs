---
layout: default
language: 'nl-nl'
version: '4.0'
title: 'Generating a backtrace'
keywords: 'backtrace, debugging, segmentation faults'
---

# Generating a Backtrace

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

Phalcon is compiled into a C extension loaded on your web server. Because of that, bugs lead to segmentation faults, causing Phalcon to crash some of your web server processes.

For debugging these segmentation faults a stacktrace is required. Creating a stack trace requires a special build of php and some steps need to be done to generate a trace that allows the Phalcon team to debug this behavior.

Please follow this guide to understand how to generate the backtrace.

<https://bugs.php.net/bugs-generating-backtrace.php>

<https://bugs.php.net/bugs-generating-backtrace-win32.php>