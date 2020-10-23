<?php
require_once('./clases/categoria.php');
function getTierOne(){
	$result = new Categoria();
	$result->ObtenerIdPadre();
	foreach ($result->rows as $key => $dat) {
		echo '<option value="'.$dat['id'].'">'.$dat['nombre'].'</option>';
	}
}
if(isset($_GET['func']) && $_GET['func'] == "drop_1"){
	drop_1($_GET['drop_var']);
}

function drop_1($drop_var){
	$result = new Categoria();
	$result->ObtenerCategoriaHijos($drop_var);
	echo '<select name="tier_two" id="tier_two" required><option value="" disabled="disabled" selected="selected">Escoge una</option>';
		foreach ($result->rows as $key2) {
			echo '<option value="'.$key2['id'].'">'.$key2['nombre'].'</option>';
		}
	echo '</select>';
}