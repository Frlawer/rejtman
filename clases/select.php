<?php
require_once('abogada.php');
if(isset($_GET['func']) && $_GET['func'] == "drop_1"){
	drop_1($_GET['drop_var']);
}

function drop_1($drop_var){
	$result = new Abogada();
	$result->xArea($drop_var);
	echo '<select name="abogada" id="abogada" required><option value="" disabled="disabled" selected="selected">Escoge una Abogada</option>';

	foreach ($result->rows as $key => $dat) {
		echo '<option value="'.$dat['id'].'">'.$dat['nombre'].'</option>';
	}
}