<?php
require_once('conn.php');
class Horario extends DBconn {
	var $horario_id;
	var	$horarior_hora;

	function __construct(
		$horario_id = 0,
        $horarior_hora = 0
        )
	{
		$this->horario_id = $horario_id;
		$this->horarior_hora = $horarior_hora;
	}


    function insert() {
        $this->query = "INSERT INTO cita (
			horarior_hora,
			abogada_id,
			) VALUES(
			'".$this->horarior_hora."',
			'".$this->abogada_id."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM horario WHERE horario_id = '".$this->horario_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE horario SET
			horarior_hora = '".$this->horarior_hora."',
			abogada_id = '".$this->abogada_id."'
			WHERE horario_id = ".$this->horario_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM horario ORDER BY horario_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }
    
    public function selectId($id) {
        $this->query = "SELECT * FROM horario WHERE horarior_id =  '".$id."'";
        $this->get_results_from_query();
    }
	
}