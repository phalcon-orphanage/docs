---
layout: article
language: 'en'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component
<hr/>

## Adapters
This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface which provides the ability to easily switch back-ends, or use multiple adapters if necessary. The adapters supported are:

- [Phalcon\Logger\Adapter\Stream](api/Phalcon_Logger_Adapter_Stream)
- [Phalcon\Logger\Adapter\Syslog](api/Phalcon_Logger_Adapter_Syslog)
- [Phalcon\Logger\Adapter\Noop](api/Phalcon_Logger_Adapter_Noop)

### Stream
This adapter is used when we want to log messages to a particular file stream. This adapter combines the v3 `Stream` and `File` ones. Usually this is the most used one: logging to a file in the file system.

### Syslog
This adapter sends messages to the system log. The syslog behavior may vary from one operating system to another.

### Noop
This is a black hole adapter. It sends messages to *infinity and beyond*! This adapter is used mostly for testing or if you want to joke with a colleague.

<a name='adapters-factory'></a>
### Factory
*This component is not working as expected for the time being. We will need to refactor it to align with the new implementation* [#13672](https://github.com/phalcon/cphalcon/issues/13672)

