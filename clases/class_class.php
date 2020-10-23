<?php
require_once 'conn_class.php';
class Clasificado extends DBconnClass {
	var $id;
	var $nombre;
	var $categoria;
	var	$titulo;
	var	$texto;
	var	$telefono;
	var	$email;
	var	$img;
	var	$vistas;
	var	$destacado;
	var	$fecha;

	function __construct(
		$id = 0,
		$nombre = 0,
		$categoria = 0,
		$titulo = '',
		$texto = '',
		$telefono = '',
		$email = '',
		$img = '',
		$vistas = 0,
		$destacado = 0,
		$fecha = 0
	)
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->categoria = $categoria;
		$this->titulo = $titulo;
		$this->texto = $texto;
		$this->telefono = $telefono;
		$this->email = $email;
		$this->img = $img;
		$this->vistas = $vistas;
		$this->destacado = $destacado;
		$this->fecha = $fecha;
	}


    protected function insert() {
        $this->query = "INSERT INTO clasificado (
			nombre,
			categoria,
			titulo,
			texto,
			telefono,
			email,
			img,
			vistas,
			destacado,
			fecha
			) VALUES(
			'".$this->nombre."',
			'".$this->categoria."',
			'".$this->titulo."',
			'".$this->texto."',
			'".$this->telefono."',
			'".$this->email."',
			'".$this->img."',
			'".$this->vistas."',
			'".$this->destacado."',
			'".$this->fecha."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM clasificado WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    public function update() {
        $this->query = "UPDATE clasificado SET nombre = ".$this->nombre.", categoria = ".$this->categoria.", titulo = '".$this->titulo."', texto = '".$this->texto."', telefono = '".$this->telefono."', email = '".$this->email."', img = '".$this->img."', vistas = ".$this->vistas.", destacado = ".$this->destacado.", fecha = ".$this->fecha." WHERE id = ".$this->id;
        $this->execute_single_query();
    }

    public function updateCount() {
    	$this->query = "UPDATE clasificado SET vistas = vistas +1 WHERE id = ".$this->id;
    	$this->get_results_from_query2();
    }

    public function updateCount2($id) {
    	$this->query = "UPDATE clasificado SET vistas = vistas +1 WHERE id = ".$id;
    	$this->get_results_from_query2();
    }

    public function select() {
        $this->query = "SELECT * FROM clasificado ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

    public function selectUltimos() {
        $this->query = "SELECT * FROM clasificado ORDER BY id DESC LIMIT 10";
        $this->get_results_from_query();
    }

    public function selectUltimos5() {
        $this->query = "SELECT * FROM clasificado ORDER BY id DESC LIMIT 5";
        $this->get_results_from_query();
    }

    public function selectMasVistos() {
        $this->query = "SELECT * FROM clasificado ORDER BY vistas DESC LIMIT 10";
        $this->get_results_from_query();
    }

	public function selectAllCat($id_cat){
		$this->query = "SELECT * FROM clasificado WHERE categoria = ".$id_cat." ORDER BY id DESC";
    	$this->get_results_from_query();
    }

	public function selectClassId($id){
		$this->query = "SELECT * FROM clasificado WHERE id = ".$id." LIMIT 1";
    	$this->get_results_from_query();
    }

	public function getMasVistosCat($cat){
		$this->query = "SELECT * FROM clasificado WHERE categoria = ".$cat." ORDER BY vistas DESC LIMIT 6";
    	$this->get_results_from_query();
    }

    public function insertar(){
    	$this->insert();
    }
}