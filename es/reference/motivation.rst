Nuestra motivación
==================

Hay muchos frameworks para PHP hoy en día, pero ninguno como Phalcon (en serio).

Casi todos los programadores preferimos usar un framework. Esto debido a que nos proporcionan una gran funcionalidad que esta probada
y lista para usar, al mismo tiempo no repitiendonos y reusando código. Sin embargo, los frameworks requieren incluir muchos archivos
e interpretar miles de lineas de código en cada petición. Esta operación hace que las aplicaciones sean más lentas por consiguiente
impactando la experiencia de usuario.

La pregunta
-----------
¿Porqué no podemos tener un framework robusto con todas sus ventajas y pocas desventajas?

Esta es la razón por la que Phalcon nace!

Durante los últimos meses, hemos investigado extensivamente el comportamiento de PHP, buscando areas donde sea posible optimizar cosas (grandes o pequeñas).
Al entender el Zend Engine, hemos podido remover validaciones innecesarias, compactando código, realizando optimizaciones y generando
soluciones de bajo nivel para conseguir el mayor rendimiento posible.

¿Porqué?
--------
* El uso de frameworks se ha vuelto obligatorio en el desarrollo profesional con PHP
* Los frameworks nos proporcionan una filosofía y estructura para mantener proyectos escribiendo menos código haciendo así nuestro trabajo más divertido

¿Cómo funciona PHP?
-------------------
* PHP tiene tipificación dinámica/débil. Esto significa que para una simple operación (2 + "2"), PHP chequea ambos operadores para efectuar posibles conversiones
* PHP es interprado y no compilado. La mayor desventaja es la perdida de rendimiento
* Cada vez que se accede a un script en PHP este debe ser interpretado
* Si un cache de bytecode (como APC) no es usado, la sintaxis de cada archivo es revisada en cada petición

¿Cómo trabajan los frameworks tradicionales para PHP?
----------------------------------------------------

* Muchos archivos con clases y funciones se leen en cada petición. La lectura de disco impacta el rendimiento
* Muchos frameworks usan autoloaders para incrementar el rendimiento (para cargar y ejecutar solo el código requirido)
* La carga contínua de archivos más su interpretación es costosa en términos de rendimiento
* El código del framework normalmente no cambia entre peticiones, sin embargo una aplicación debe cargarlo e interpretarlo con cada petición

¿Cómo trabaja una extensión en C para PHP?
------------------------------------------

* Las extensiones en C se cargan una vez junto con PHP al iniciar el servicio/demonio de PHP
* Las clases y funciones proporcionadas por la extensión están listas para ser usadas por cualquier aplicación
* El código no es interpretado porque ya está compilado para una plataforma y procesador específicos

¿Cómo trabaja Phalcon?
----------------------

* Los componentes están libremente acoplados. Con Phalcon, nada está impuesto: tienes la libertad de usar todo el framework, o solo las partes que necesites
* Optimizaciones de bajo nivel ayudan a reducir la sobrecarga requerida para correr aplicaciones MVC
* Las operaciones con base de datos se efectuán con la máxima eficiencia al usar un ORM para PHP escrito en C
* Phalcon accede directamente a las estructuras internas de PHP optimizando además cada ejecucion

Conclusión
----------
Phalcon es un esfuerzo para construir el framework más rápido para PHP, al mismo tiempo ofrecer una herramienta sencilla y robusta para crear aplicaciones web sin preocuparse por el rendimiento. Esperamos lo difrutes!

