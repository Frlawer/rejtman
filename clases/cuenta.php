<?php
require_once('conn.php');
class Cuenta extends DBconn {
	var $cuenta_id;
	var $cuenta_nombre;
	var $cuenta_datos;
	var $abogada_id;

	function __construct($cuenta_id = 0, $cuenta_nombre = '', $cuenta_datos = '', $abogada_id = ''){
		$this->cuenta_id = $cuenta_id;
		$this->cuenta_nombre = $cuenta_nombre;
		$this->cuenta_datos = $cuenta_datos;
		$this->abogada_id = $abogada_id;
	}

    protected function insert() {
        $this->query = "INSERT INTO cuenta (
			cuenta_nombre,
            cuenta_datos,
            abogada_id
			) VALUES(
			'".$this->cuenta_nombre."',
			'".$this->cuenta_datos."',
			'".$this->abogada_id."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM cuenta WHERE cuenta_id = '".$this->cuenta_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE cuenta SET
			cuenta_nombre = '".$this->cuenta_nombre."'
			cuenta_datos = '".$this->cuenta_datos."'
			abogada_id = '".$this->abogada_id."'
			WHERE cuenta_id = ".$this->cuenta_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM cuenta ORDER BY cuenta_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
	}
	
	public function selectAbogadaId($id){
		$this->query = "SELECT * FROM cuenta WHERE abogada_id = '".$id."'";
    	$this->get_results_from_query();
	}
}