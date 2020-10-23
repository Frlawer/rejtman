<?php
session_start();
/*
| incluir config.php
*/
require 'config.php';

/*
| Mostrar Errores
*/
if (defined('MOSTRAR_ERRORES')) {
    switch (MOSTRAR_ERRORES) {
        case 'SI':
        error_reporting(-1);
        ini_set('display_errors', '1');
        break;

        case 'NO':
        error_reporting(0);
        break;

        default:
        exit('Por favor ingrese un valor válido en MOSTRAR_ERRORES en config.php, los valores son: SI ó NO.');
    }
}
/*
| Incluir la conexion a la db
| En este archivo estan las conexiones a la bd y funciones de consultas preestablecidas
*/
require 'clases/conn.php';

/*
| Incluir las querys
| En este archivo estan todas las consultas a la bd
*/
require 'query.php';

/*
| Incluir el core
| En el core se encuentran todas las funciones que vamos a usar
*/
require 'core.php';


/*
| Acá se guarda en $view la vista que vamos a cargar
| La funcion url_permitidas() verifica que exista la view en el array, y que exista el archivo
| La vista que queremos cargar debemos enviarla por GET  ejemplo: index.php?view=app1
| en ese caso el sistema buscará en la carpeta views si existe el archivo app1.php
| y lo cargará haciendo un include más abajo.
*/

$view = (isset($_GET['view']) AND url_permitidas($_GET['view'], $arr)) ? $_GET['view'] : 'inicio';
/*
|--------------------------------------------------------------------------
| Titulo o nombre de la app
|--------------------------------------------------------------------------
|
*/
if (empty($_GET)) {
    define('TITULO_WEB', 'La guía más completa de Catamarca, todos los servicios, comercios y profesionales en un solo lugar');

}else{
    if ($_GET['view'] == 'rubro') {
        require_once('./clases/categoria.php');
        $urlrubro = $_GET['urlrubro'];
        $rubro = new Categoria(NULL,NULL,NULL,$urlrubro);
        $rubro->ObtenerNombre();
        // print_r($rubro->rows[0]['nombre']);
        $nombre = utf8_encode($rubro->rows[0]['nombre']);

        define('TITULO_WEB', $nombre);

    }elseif ($_GET['view'] == 'categoria') {
        require_once('./clases/categoria.php');
        $urlcat = $_GET['urlcat'];
        $cat = new Categoria(NULL,NULL,NULL,$urlcat);
        $cat->ObtenerNombre();
        $nomcat = utf8_encode($cat->rows[0]['nombre']);
        define('TITULO_WEB', $nomcat);

    }elseif($_GET['view'] == 'lugar'){
        require_once('./clases/lugar.php');
        $url = $_GET['nombre'];
        $lugar = new Lugar();
        $lugar->ObtenerLugarUrl($url);
        $datos = utf8_encode($lugar->rows[0]['nombre']);
        define('TITULO_WEB', $datos);

    }elseif ($_GET['view'] == 'agregar-lugar') {
        define('TITULO_WEB', 'Agrega tu lugar');
    }elseif ($_GET['view'] == 'contacto') {
        define('TITULO_WEB', 'Contactate con nosotros');
    }elseif ($_GET['view'] == 'publicidad') {
        define('TITULO_WEB', 'Publicita en nuestra web');
    }elseif ($_GET['view'] == 'terminos-y-condiciones') {
        define('TITULO_WEB', 'Términos y condiciones');
    }else{
        define('TITULO_WEB', 'La mejor guía geolocalizada de Catamarca');
    }
}

/*
| Incluir head
*/
include('template/head.php');


/*
| Incluir la vista
| Simplemente hace un include de la vista requerida
*/
include ('views/' . $view . '.php');

/*
| Incluir footer
*/
include('template/footer.php');