---
layout: article
language: 'en'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component
<hr/>

## Message Formatting
This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

- [Phalcon\Logger\Formatter\Line](api/Phalcon_Logger_Formatter_Line)
- [Phalcon\Logger\Formatter\Json](api/Phalcon_Logger_Formatter_Json)
- [Phalcon\Logger\Formatter\Syslog](api/Phalcon_Logger_Formatter_Syslog)
