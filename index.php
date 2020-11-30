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