<?php
require_once('conn.php');
class Cita extends DBconn {
	var $cita_id;
	var	$area_id;
	var	$abogada_id;
	var	$cita_nombre;
	var	$cita_email;
	var	$cita_tel;
	var	$cita_fecha;
	var	$horario_id;
	var	$cita_desc;

	function __construct(
		$cita_id = 0,
		$area_id = 0,
		$abogada_id = 0,
		$cita_nombre = '',
		$cita_email = '',
		$cita_tel = '',
		$cita_fecha = '',
		$horario_id = 0,
		$cita_desc = ''
		)
	{
		$this->cita_id = $cita_id;
		$this->area_id = $area_id;
		$this->abogada_id = $abogada_id;
		$this->cita_nombre = $cita_nombre;
		$this->cita_email = $cita_email;
		$this->cita_tel = $cita_tel;
		$this->cita_fecha = $cita_fecha;
		$this->horario_id = $horario_id;
		$this->cita_desc = $cita_desc;
	}


    function insert() {
        $this->query = "INSERT INTO `cita` (
			`cita_id`, 
			`area_id`, 
			`abogada_id`, 
			`cita_nombre`, 
			`cita_email`, 
			`cita_tel`,
			`cita_fecha`, 
			`horario_id`, 
			`cita_desc`
		) VALUES (
			NULL, 
			$this->area_id, 
			$this->abogada_id, 
			$this->cita_nombre, 
			$this->cita_email,
			$this->cita_tel, 
			$this->cita_fecha, 
			$this->horario_id, 
			$this->cita_desc
			);";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM cita WHERE cita_id = '".$this->cita_id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE cita SET
			area_id = '".$this->area_id."',
			abogada_id = '".$this->abogada_id."',
			cita_nombre = '".$this->cita_nombre."',
			cita_email = '".$this->cita_email."',
			cita_tel = '".$this->cita_tel."',
			cita_fecha = '".$this->cita_fecha."',
			horario_id = '".$this->horario_id."',
			cita_desc = '".$this->cita_desc."'
			WHERE cita_id = ".$this->cita_id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM cita ORDER BY cita_id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
	}
	
}