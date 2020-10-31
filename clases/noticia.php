<?php
require_once('conn.php');
class Horario extends DBconn {
	var $horario_id;
	var	$horario_hora;

	function __construct(
		$horario_id = 0,
		$horario_hora = "",
		)
	{
		$this->horario_id = $horario_id;
		$this->horario_hora = $horario_hora;
	}


    function insert() {
        $this->query = "INSERT INTO horario (
			horario_hora,
			) VALUES(
			'".$this->horario_hora."',
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM horario WHERE horario_id = '".$this->horario_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE horario SET
			horario_hora = '".$this->horario_hora."'
			WHERE horario_id = ".$this->horario_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM horario ORDER BY horario_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
	}
	
}
