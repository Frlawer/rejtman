<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "No tienes permisos para realizar esta acción";
    	header('location: clientes.php');
        exit;

	}
    $customer_id = $del_id;

    $db = getDbInstance();
    $db->where('cliente_id', $customer_id);
    $status = $db->delete('cliente');
    
    if ($status) 
    {
        $_SESSION['info'] = "Cliente eliminado correctamente!";
        header('location: clientes.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "No se pudo eliminar el cliente";
    	header('location: clientes.php');
        exit;

    }
    
}