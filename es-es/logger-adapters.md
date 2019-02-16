---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Componente Registro

* * *

## Adaptadores

El componente registro hace uso de diversos adaptadores para guardar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente de backend o utilizar múltiples adaptadores en caso de ser necesario. Los adaptadores disponibles son:

- [Phalcon\Logger\Adapter\Stream](api/Phalcon_Logger_Adapter_Stream)
- [Phalcon\Logger\Adapter\Syslog](api/Phalcon_Logger_Adapter_Syslog)
- [Phalcon\Logger\Adapter\Noop](api/Phalcon_Logger_Adapter_Noop)

### Stream (flujo)

Se usa para registrar mensajes en un archivo de flujo. Combina los adaptadores de v3 `Stream` y `File`. Es el de uso más extendido: llevar el registro en un archivo del sistema de archivos.

### Syslog (Registro del sistema)

Se usa para guardar los mensajes en el registro del sistema (*Syslog*). El comportamiento del *syslog* puede variar de un sistema operativo a otro.

### Noop (No operación)

Este adaptador es un agujero negro: ¡Envía mensajes al *infinito y más allá!* Se usa especialmente para pruebas --o para hacerle una broma a un colega.

<a name='adapters-factory'></a>

### Factory (Fábrica)

*Este adaptador no está funcionando como se espera todavía*: Está en proceso de refactorización de tal manera que pueda integrarse a la nueva implementación. Ver caso [#13672](https://github.com/phalcon/cphalcon/issues/13672)