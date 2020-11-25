<?php

/*
  |--------------------------------------------------------------------------
  | En este array se ponen todas las vistas permitidas, sin el .php
  |--------------------------------------------------------------------------
  | Las vistas son archivos que vas a incluir en cada seccion de tu app.
  | Por ejemplo Home, Quienes Somos, Ayuda, etc. etc...
 */
$arr = array('inicio','nosotros', 'cita', 'submitform','pruebas');
/*
  |--------------------------------------------------------------------------
  | Si queres mostrar errores de php en pantalla, ponela en SI sino en NO
  |--------------------------------------------------------------------------
  |
 */
define('MOSTRAR_ERRORES', 'SI');//SI ó NO

/*
  |--------------------------------------------------------------------------
  | Si queres mostrar errores de php en pantalla, ponela en SI sino en NO
  |--------------------------------------------------------------------------
  |
 */
define('PROD_ACCESS_TOKEN', 'TEST-c9f635c4-9c1b-44f0-81fe-ffcd938db150');//SI ó NO


/*
  |--------------------------------------------------------------------------
  | Esta es la base url de la app, fuera de facebook, osea la del dominio.
  |--------------------------------------------------------------------------
  |
 */
define('BASE_URL','http://www.estudiomartinezrejtman-asoc.com.ar/');

/*
  |--------------------------------------------------------------------------
  | Nombre de la Empresa.
  |--------------------------------------------------------------------------
  |
 */
define('NOMBRE_ESTUDIO','Estudio Jur&iacute;dico Mart&iacute;nez Rejtman &amp; Asoc.');


/*
  |--------------------------------------------------------------------------
  | Clave Recaptcha.
  |--------------------------------------------------------------------------
  |
 */
define('RECAPTCHA_KEY','6LcPR-IZAAAAACXBHIICa7eTDByjy1thNMK2BxDc');

/*
  |--------------------------------------------------------------------------
  | Ruta del servidor de las vistas
  |--------------------------------------------------------------------------
  |
 */
define("RUTA_VISTAS",getcwd().DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
