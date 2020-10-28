<?php
require_once('conn.php');
class Area extends DBconn {
	var $id;
	var $valor;

	function __construct($id = 0, $valor = ''){
		$this->id = $id;
		$this->valor = $valor;
	}

    protected function insert() {
        $this->query = "INSERT INTO area (
			valor
			) VALUES(
			'".$this->valor."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM area WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE area SET
			valor = '".$this->valor."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM area ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function ObtenerCategoriaHijos($id_padre){
		$this->query = "SELECT * FROM categoria WHERE id_padre = '".$id_padre."' ORDER BY nombre";
    	$this->get_results_from_query();
	}

	public function selectId($id){
		$this->query = "SELECT * FROM area WHERE id = '".$id."'";
    	$this->get_results_from_query();
	}

	function ObtenerNombre(){
		$this->query = "SELECT * FROM categoria WHERE url = '".$this->url."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenerLetra($letra,$id_padre){
		$this->query = "SELECT * FROM categoria WHERE nombre REGEXP '^".$letra."' AND id_padre = '".$id_padre."'";
    	$this->get_results_from_query();
	}

	function ObtenerIdPadre(){
		$this->query = "SELECT id,nombre FROM categoria WHERE id_padre = 0";
    	$this->get_results_from_query();
	}
}