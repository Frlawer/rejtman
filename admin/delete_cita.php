<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "No tienes permisos para realizar esta acción";
    	header('location: citas.php');
        exit;

	}
    $customer_id = $del_id;

    $db = getDbInstance();
    $db->where('cita_id', $customer_id);
    $status = $db->delete('cita');
    
    if ($status) 
    {
        $_SESSION['info'] = "Cita eliminada correctamente!";
        header('location: citas.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "No se pudo eliminar la cita";
    	header('location: citas.php');
        exit;

    }
    
}