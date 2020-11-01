<?php
require_once('conn.php');
class Abogada extends DBconn {
	var $abogdada_id;
	var $abogada_nombre;

	function __construct($abogada_id = 0, $abogada_nombre = ''){
		$this->id = $abogada_id;
		$this->abogada_nombre = $abogada_nombre;
	}

    protected function insert() {
        $this->query = "INSERT INTO abogada (
			abogada_nombre
			) VALUES(
			'".$this->abogada_nombre."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM abogada WHERE abogada_id = '".$this->abogada_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE abogada SET
			abogada_nombre = '".$this->abogada_nombre."'
			WHERE abogada_id = ".$this->abogada_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM abogada ORDER BY abogada_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function xArea($id_area){
		
		$this->query = "SELECT * FROM abogada INNER JOIN abogada_area WHERE abogada_area.area_id = ".$id_area." AND abogada_area.abogada_id = abogada.abogada_id";
    	$this->get_results_from_query();
	}

	public function horarios($abogada_id){
		$this->query = "SELECT * FROM horario INNER JOIN abogada_horario WHERE abogada_horario.abogada_id = ".$abogada_id." AND abogada_horario.horario_id = horario.horario_id";
    	$this->get_results_from_query();
	}

	public function selectId($id){
		$this->query = "SELECT * FROM abogada WHERE abogada_id = '".$id."'";
    	$this->get_results_from_query();
	}
	// SELECT * FROM horario 
// INNER JOIN abogada_horario 
// ON abogada_horario.horario_id = horario.horario_id
// AND abogada_horario.abogada_id = 3
}
