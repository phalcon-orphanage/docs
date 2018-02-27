# Clase **Phalcon\\Http\\Response\\Headers**

*implementa* [Phalcon\Http\Response\HeadersInterface](/en/3.2/api/Phalcon_Http_Response_HeadersInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/response/headers.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Esta clase es una bolsa o contenedor para administrar las cabeceras de la respuesta

## Métodos

public **set** (*mixed* $name, *mixed* $value)

Configura una cabecera que será enviada al final de una solicitud

public **get** (*mixed* $name)

Obtiene el valor de una cabecera desde la bolsa interna

public **setRaw** (*mixed* $header)

Establece una cabecera sin procesar que será enviada al final de la solicitud

public **remove** (*mixed* $header)

Elimina una cabecera que será enviada al final de la solicitud

public **send** ()

Envía las cabeceras al cliente

public **reset** ()

Restablece las cabeceras configuradas

public **toArray** ()

Devuelve las cabeceras actuales como un arreglo

public static **__set_state** (*array* $data)

Restaura un objeto \\Phalcon\\Http\\Response\\Headers