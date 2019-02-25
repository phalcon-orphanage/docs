---
layout: article
language: 'es-es'
version: '4.0'
category: 'installation'
---
# Instalación

* * *

## Requerimentos

### PSR

Phalcon requiere la extensión PSR. La extensión se puede descargar y compilar desde [este repositorio de GitHub](https://github.com/jbboehr/php-psr). Las instrucciones de instalación están disponibles en el `README` del repositorio. Una vez que la extensión haya sido compilada y esté disponible en su sistema, necesitará cargarla a su `php.ini`. Necesitarás añadir esta línea:

```ini
extension=psr.so
```

antes

```ini
extension=phalcon.so
```

Alternativamente algunas distribuciones añaden un prefijo numérico en los archivos `ini`. Si ese es el caso, elija un número alto para Phalcon (por ejemplo `50-phalcon.ini`).