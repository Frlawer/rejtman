<?php

/*
  |--------------------------------------------------------------------------
  | En este array se ponen todas las vistas permitidas, sin el .php
  |--------------------------------------------------------------------------
  | Las vistas son archivos que vas a incluir en cada seccion de tu app.
  | Por ejemplo Home, Quienes Somos, Ayuda, etc. etc...
 */
$arr = array('inicio','nosotros', 'cita', 'submitform','pruebas', 'prueba','pending','success','failure');
/*
  |--------------------------------------------------------------------------
  | Si queres mostrar errores de php en pantalla, ponela en SI sino en NO
  |--------------------------------------------------------------------------
  |
 */
define('MOSTRAR_ERRORES', 'SI');//SI ó NO

/*
  |--------------------------------------------------------------------------
  | TOKEN MP APP ID 225380343 
  |--------------------------------------------------------------------------
  |
 */
define('PROD_ACCESS_TOKEN', 'TEST-573726d7-18f9-4c7b-82a6-75f4f81edb3d');//SI ó NO

/*
  |--------------------------------------------------------------------------
  | TOKEN SECURE MP
  |--------------------------------------------------------------------------
  |
 */
define('PROD_ACCESS_TOKEN_SECURE', 'TEST-5503571218052849-112616-65aa2d57f976a8ee270c33da123e129c-225380343');//SI ó NO


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
