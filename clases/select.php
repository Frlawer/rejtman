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
		echo '<option value="'.$dat['abogada_id'].'">'.$dat['abogada_nombre'].'</option>';
	}
	echo '</select>';
}

if(isset($_GET['func']) && $_GET['func'] == "horas"){
	horas($_GET['abogadaid']);
}

function horas($abogadaid){
	$datos = new Abogada();
	$datos->horarios($abogadaid);
	echo '<select name="hora" id="hora" required><option value="" disabled selected>Selecciona horario</option>';
	foreach ($datos->rows as $key => $dat) {
		echo '<option value="'.$dat['horario_id'].'">'.$dat['horario_hora'].'</option>';
	}
	echo '</select>';
}