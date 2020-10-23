<?php

/*
  |--------------------------------------------------------------------------
  | En este array se ponen todas las vistas permitidas, sin el .php
  |--------------------------------------------------------------------------
  | Las vistas son archivos que vas a incluir en cada seccion de tu app.
  | Por ejemplo Home, Quienes Somos, Ayuda, etc. etc...
 */
$arr = array('inicio','terminos-y-condiciones','lugar','categoria','contacto','rubro','busquedas','contactocliente','agregar-lugar','publicidad','pruebas','noticias');
/*
  |--------------------------------------------------------------------------
  | Si queres mostrar errores de php en pantalla, ponela en SI sino en NO
  |--------------------------------------------------------------------------
  |
 */
define('MOSTRAR_ERRORES', 'NO');//SI ó NO


/*
  |--------------------------------------------------------------------------
  | Esta es la base url de la app, fuera de facebook, osea la del dominio.
  |--------------------------------------------------------------------------
  |
 */
define('BASE_URL','http://miguiacatamarca.com/');

/*
  |--------------------------------------------------------------------------
  | Ruta del servidor de las vistas
  |--------------------------------------------------------------------------
  |
 */
define("RUTA_VISTAS",getcwd().DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
/*
  |--------------------------------------------------------------------------
  | key facebook y twitter
  |--------------------------------------------------------------------------
  |
 */
$configfb = array(
  'app_id' => '510154989074719',
  'app_secret' => '0492e401d53cfc6de6ff9569a5f1f337',
  'scopes' => array('email','read_friendlists','user_online_presence')
);