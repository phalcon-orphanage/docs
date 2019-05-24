---
layout: default
language: 'pt-br'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

- [Logging](logger-overview)
- [Adapters](logger-adapters)
- [Creating a Logger component](logger-creating)
- [Logging to Multiple adapters](logger-multiple)
- [Message Formatting](logger-message-formatting) 
    - [Line](logger-message-formatting-line)
    - [JSON](logger-message-formatting-json)
    - [Syslog](logger-message-formatting-syslog)
    - [Custom](logger-message-formatting-custom)
- [Interpolation](logger-interpolation)
- [Examples](logger-examples)

* * *

# Logging

[Phalcon\Logger](api/Phalcon_Logger) is a component providing logging services for applications. It offers logging to different back-ends using different adapters. It also offers transaction logging, configuration options and different logging formats. You can use the [Phalcon\Logger](api/Phalcon_Logger) for any logging need your application has, from debugging processes to tracing application flow.

![](/assets/images/implements-psr--3-orange.svg)

The [Phalcon\Logger](api/Phalcon_Logger) has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). This allows you to use the [Phalcon\Logger](api/Phalcon_Logger) to any application that utilizes a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

In v3, the logger was incorporating the adapter in the same component. So in essence when creating a logger object, the developer was creating an adapter (file, stream etc.) with logger functionality.

For v4, we rewrote the component to implement only the logging functionality and to accept one or more adapters that would be responsible for doing the work of logging. This immediately offers compatibility with [PSR-3](https://www.php-fig.org/psr/psr-3/) and separates the responsibilities of the component. It also offers an easy way to attach more than one adapter to the logging component so that logging to multiple adapters can be achieved. By using this implementation we have reduced the code necessary for this component and removed the old `Logger\Multiple` component.