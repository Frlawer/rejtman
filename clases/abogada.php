<?php
require_once('conn.php');
class Abogada extends DBconn {
	var $id;
	var $nombre;

	function __construct($id = 0, $nombre = ''){
		$this->id = $id;
		$this->nombre = $nombre;
	}

    protected function insert() {
        $this->query = "INSERT INTO abogada (
			nombre
			) VALUES(
			'".$this->nombre."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM abogada WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE abogada SET
			nombre = '".$this->nombre."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM abogada ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function xArea($id_area){
		$this->query = "SELECT * FROM abogada INNER JOIN abogada_area WHERE abogada_area.area_re = ".$id_area." AND abogada_area.abogado_re = abogada.id";
    	$this->get_results_from_query();
	}

	public function horarios($abogada_id){
		$this->query = "SELECT * FROM horarios INNER JOIN abogada_horarios WHERE abogada_horarios.abogada_re = ".$abogada_id." AND horarios.id_hora = abogada_horarios.hora_re";
    	$this->get_results_from_query();
	}

	public function selectId($id){
		$this->query = "SELECT * FROM abogada WHERE id = '".$id."'";
    	$this->get_results_from_query();
	}
}