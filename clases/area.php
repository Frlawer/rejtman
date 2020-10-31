<?php
require_once('conn.php');
class Area extends DBconn {
	var $area_id;
	var $area_nombre;

	function __construct($area_id = 0, $area_nombre = ''){
		$this->area_id = $area_id;
		$this->area_nombre = $area_nombre;
	}

    protected function insert() {
        $this->query = "INSERT INTO area (
			area_nombre
			) VALUES(
			'".$this->area_nombre."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM area WHERE area_id = '".$this->area_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE area SET
			area_nombre = '".$this->area_nombre."'
			WHERE area_id = ".$this->area_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM area ORDER BY area_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }
}