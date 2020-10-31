<?php
require_once('conn.php');
class Cita extends DBconn {
	var $cliente_id;
	var	$cliente_nombre;
	var	$cliente_tel;
	var	$cliente_dir;
	var	$cliente_email;
	var	$cliente_desc;

	function __construct(
		$cliente_id = 0,
		$cliente_nombre = 0,
		$cliente_tel = 0,
		$cliente_dir = '',
		$cliente_email = '',
		$cliente_desc = ''
		)
	{
		$this->cliente_id = $cliente_id;
		$this->cliente_nombre = $cliente_nombre;
		$this->cliente_tel = $cliente_tel;
		$this->cliente_dir = $cliente_dir;
		$this->cliente_email = $cliente_email;
		$this->cliente_desc = $cliente_desc;
	}


    function insert() {
        $this->query = "INSERT INTO cita (
			cliente_nombre,
			cliente_tel,
			cliente_dir,
			cliente_email,
			cliente_desc
			) VALUES(
			'".$this->cliente_nombre."',
			'".$this->cliente_tel."',
			'".$this->cliente_dir."',
			'".$this->cliente_email."',
			'".$this->cliente_desc."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM cliente WHERE cliente_id = '".$this->cliente_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE cita SET
			cliente_nombre = '".$this->cliente_nombre."',
			cliente_tel = '".$this->cliente_tel."',
			cliente_dir = '".$this->cliente_dir."',
			cliente_email = '".$this->cliente_email."',
			cliente_desc = '".$this->cliente_desc."'
			WHERE cliente_id = ".$this->cliente_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM cliente ORDER BY cliente_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }
    
}
