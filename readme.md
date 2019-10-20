# AplicationGuaye

_El siguiente proyecto se trata de una aplicación web, los módulos implementados son los siguientes:_
**Módulo com CRUD completo de un Blog para el restaurante.**
**Módulo com CRUD completo de petición para reservaciones de eventos para los clientes.**
**Módulo com CRUD completo de menú de comidas diarias.**

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._


### Pre-requisitos 📋

_Que cosas necesitas para el funcionamiento._

```
Cualquier navegador navegador actual.
Un servidor local para conectarse con php. 
Motor de base de datos MySql.
```

## Ejecutando las pruebas ⚙️
**Módulo de usuario** _Por completar_
_1. Registo_\
_2. Inicio se sesión_\
_Usarios y claves_\
_tnx = tnx_
_edw = edw01_
_lozado = lozado_
_kelvin = kelvin_
_admon = admin_
_moderador = moderador_
_ka = piv_

**Módulo del Blog**  
_1. Postear un nuevo blog_
_3. Ver todos los post del blog, cualquier usuario_
_3. Editar un post existente del blog, sólo podrá hacerlo el usuario que lo posteó_
_4. Eliminar un post existente del blog, sólo podrá hacerlo el usuario que lo posteó_

**Módulo de eventos** 
_1. Registo de un nuevo evento, sólo disponibles para usuarios atenticados como clientes._
2. Consultar los eventos, sólo se visualizarán los del usuario autenticado.
3. Editar eventos.
	3.1 Sólo se editará el evento del usuario autenticado 
	3.2 No se podrá editar un evento con alguna fecha que haya pasado.
4. Eliminar events.
	3.1 Sólo se eliminará el evento del usuario autenticado 
	3.2 No se podrá eliminar un evento con alguna fecha que haya pasado._

**Módulo de Menú diario** 
_1. Visualización del menú.
	1.1 Para usuarios no autenticados y atenticados como tipo clientes podrán visualizar las útlimas comidas guardadas de la última fecha a su guardado o actualización.
	1.2 El usuario tipo administador puede visualizar en una tabla todas las comidas registradas separadas por fecha.
	**Sólo usuarios autenticados como administrador tienen disponibles las siguientes opciones. **
2. Registro de comidas por menú.
	2.1 Sólo un usuario tipo administrador tiene habilitada esta opción.
3. Edición de una comida ya existente.
	3.1 Sólo un usuario tipo administrador tiene habilitada esta opción.
	3.2 El administrador sólo podrá actualizar un dato siempre y cuándo se él que lo registró y la fecha sea la del día actual.
4. Eliminación de comidas por menú
	4.1 Sólo un usuario tipo administrador tiene habilitada esta opción.
	4.2 El administrador sólo podrá eliminar un dato siempre y cuándo se él que lo registró y la fecha sea la del día actual._


### Y las pruebas de estilo de codificación ⌨️

```
	por definirse.
```

## Construido con 🛠️

* [PHP](http://php.net/manual/es/index.php) - Lenguaje de programación del lado del servidor
* [JavaScript](https://developer.mozilla.org/es/docs/Web/JavaScript) - Lenguaje de programación del lado del cliente
* [HTML 5](https://developer.mozilla.org/es/docs/HTML/HTML5) - Lenguaje de enmarcado
* [CSS 3](https://developer.mozilla.org/es/docs/Archive/CSS3) - Lenguaje de hojas de estilos
* [MySql](https://www.mysql.com/) - Motor de base de datos

## Contribuyendo 🖇️

Por favor lee el [CONTRIBUTING.md](https://gist.github.com/villanuevand/xxxxxx) para detalles de nuestro código de conducta, y el proceso para enviarnos pull requests.


## Autores ✒️

_Menciona a todos aquellos que ayudaron a levantar el proyecto desde sus inicios_

* **Edward Reyes** - *Trabajó con el módulo del blog y estilizado del aplicativo* - [edw-rys](https://github.com/edw-rys)
* **Cristian Lozado** - *Trabajó con el módulo de eventos*
* **Klevin Castro** - *Trabajó con el módulo de menú diario* 

---
