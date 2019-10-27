# AplicationGuaye

_El siguiente proyecto se trata de una aplicación web, los módulos implementados son los siguientes:_
**Módulo com CRUD completo de un Blog para el restaurante.**
**Módulo com CRUD completo de petición para reservaciones de eventos para los clientes.**
**Módulo com CRUD completo de menú de comidas diarias.**

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._


### Pre-requisitos 📋

```
navegadores actuales (Chrome, Mozilla).
Un servidor local para conectarse con php. 
Motor de base de datos MySql.
Puede usar xampp server, wampp server o el de preferencia.
```
## :earth_africa: Navegadores Soportados

* Chrome/Chromium 76+
* Firefox 60+

## Ejecutando las pruebas ⚙️
**Módulo de usuario** 
_1. Registo_\
_2. Inicio se sesión_\
_3. Actualización de datos de usuario_\
_4. Deshanilitar usuario_\
_Usarios y claves_\
_tnx = tnx_\
_edw = edw01_\
_lozado = lozado_\
_kelvin = kelvin_\
_admon = admin_\
_moderador = moderador_\
_ka = piv_

**Módulo del Blog**  
_1. Postear un nuevo blog_\
_2. Ver todos los post del blog, cualquier usuario_\
_3. Editar un post existente del blog, sólo podrá hacerlo el usuario que lo posteó_\
_4. Eliminar un post existente del blog, sólo podrá hacerlo el usuario que lo posteó_

**Módulo de eventos** 
_1. Registo de un nuevo evento, sólo disponibles para usuarios atenticados como clientes._\
_2. Consultar los eventos, sólo se visualizarán los del usuario autenticado._\
_3. Editar eventos._\
	3.1 Sólo se editará el evento del usuario autenticado 
	3.2 No se podrá editar un evento con alguna fecha que haya pasado.
_4. Eliminar events.
	3.1 Sólo se eliminará el evento del usuario autenticado 
	3.2 No se podrá eliminar un evento con alguna fecha que haya pasado._\

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


### Proyecto funcional ⌨️

_Ubique los archivos del proyecto en la carpeta que especifica la plataforma que le habilita su servidor en el caso de desarrollo._\
_Xampp -> C:xampp/htdocs/_\
_Configuración del proyecto "PHP"_\
_Wampp -> C:wamp/www/_\
_Configurar el archivo config.php __Ubicación -> app/config/config.php__\
```php

// Defina la zona horaria
date_default_timezone_set('America/Guayaquil');

//Configure la ubicacón del directorio raíz del proyecto
define("BASEPATH", IS_LOCAL ? '/aplicationRestaurantGuaye/' : '/aplicationRestaurantGuaye/');

// Configurar su puerto de internet, por defecto coloque el puerto 80
define('PORT'               , "80");

// Defina la ruta, por lo general es http://127.0.0.1 (localhost), para producción modifique segunda dirección
define('URL'                , IS_LOCAL ?'http://127.0.0.1:'.PORT.BASEPATH :"http://192.168.1.8:".PORT.BASEPATH);

//Base de datos
// Defina la ruta, por lo general es http://127.0.0.1 (localhost)
// Defina su puerto, en caso de ser necesario
define('DB_HOST'            , 'http://127.0.0.1:3306');
// Defina el nombre de la base de datos, usuario y contraseña.
define('DB_NAME'            , 'guaye');
define('DB_USER'            , 'root');
define('DB_PASS'            , 'root');
```

## Construido con 🛠️

* [PHP](http://php.net/manual/es/index.php) - Lenguaje de programación del lado del servidor
* [JavaScript](https://developer.mozilla.org/es/docs/Web/JavaScript) - Lenguaje de programación del lado del cliente
* [HTML 5](https://developer.mozilla.org/es/docs/HTML/HTML5) - Lenguaje de enmarcado
* [SASS](https://sass-lang.com/) - Preprocesador de css
* [CSS 3](https://developer.mozilla.org/es/docs/Archive/CSS3) - Lenguaje de hojas de estilos
* [MySql](https://www.mysql.com/) - Motor de base de datos

* [momentjs](https://momentjs.com/docs/) - Librería de javascript para el manejo de fechas.
* [toastr](https://github.com/CodeSeven/toastr) - Librería de javascript para el manejo de mensajes de alerta personalizadas.
* [toastr](https://github.com/firebase/php-jwt) - Librería de php para el uso de codificación y descodificaci+on de token.


## Contribuyendo 🖇️

## Autores ✒️
_Actualización del proyecto_

* **Edward Reyes** - *Actualizó el proyecto aplicando librerías de js y php, actualización de peticiones ajax a fetch.* - [edw-rys](https://github.com/edw-rys)

_Iniciaron el proyecto_
* **Edward Reyes** - *Trabajó con el módulo del blog y estilizado del aplicativo* - [edw-rys](https://github.com/edw-rys)
* **Cristian Lozado** - *Trabajó con el módulo de eventos*
* **Klevin Castro** - *Trabajó con el módulo de menú diario* 

---

### Screenshot ⌨️
__Index__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_1.png)

__Login__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_01.png)

__Registro de usuario__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_00.png)


__Vista del perfil de un usuario común o el aut+enticado__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_8.png)

__Configuraciones de una cuenta de usuario__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_9.png)

__Búsqueda de cuentas de usuario__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_10.png)

__Búsqueda de cuentas de usuario (Versión móvil)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_10_movil.png)

__Menú dirario (vista para usuario no administrador)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_2.png)

__Menú dirario (vista para usuario administrador)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_2admin.png)

__Blog__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_3.png)

__Postear nueva receta en el blog__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_4.png)

__Opciones de un post__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_5.png)

__pciones de un post para un usuario tipo moderador__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_5moderador.png)

__Visualizar un post (Vista en ordenador)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_6.png)

__Visualizar un post (Vista en Dispotivos móviles pequeños)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_6_movil.png)

__Vista de eventos por usuario (Vista en ordenador)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_7.png)

__Vista de eventos por usuario (Vista en Dispotivos móviles pequeños)__
![alt text](https://raw.githubusercontent.com/edw-rys/aplicationRestaurantGuaye/master/assets/img/pictures/screenshot/number_7_movil.png)
