<?php
require_once('conn.php');
class Cita extends DBconn {
	var $id;
	var	$area;
	var	$abogada;
	var	$name;
	var	$email;
	var	$phone;
	var	$fecha;
	var	$hora;
	var	$description;

	function __construct(
		$id = 0,
		$area = 0,
		$abogada = 0,
		$name = '',
		$email = '',
		$phone = '',
		$fecha = '',
		$hora = '',
		$description = ''
		)
	{
		$this->id = $id;
		$this->area = $area;
		$this->abogada = $abogada;
		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
		$this->fecha = $fecha;
		$this->hora = $hora;
		$this->description = $description;
	}


    function insert() {
        $this->query = "INSERT INTO cita (
			area,
			abogada,
			name,
			email,
			phone,
			fecha,
			hora,
			description
			) VALUES(
			'".$this->area."',
			'".$this->abogada."',
			'".$this->name."',
			'".$this->email."',
			'".$this->phone."',
			'".$this->fecha."',
			'".$this->hora."',
			'".$this->description."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM cita WHERE id_cita = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE cita SET
			area = '".$this->area."',
			abogada = '".$this->abogada."',
			name = '".$this->name."',
			email = '".$this->email."',
			phone = '".$this->phone."',
			fecha = '".$this->fecha."',
			hora = '".$this->hora."',
			description = '".$this->description."'
			WHERE id_cita = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM cita ORDER BY id_cita";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function ListarcitaCategoria($idcategoria){
		$this->query = "SELECT * FROM cita WHERE cita.categoria = ".$idcategoria." AND cita.online = 1 ORDER BY id";
    	$this->get_results_from_query();
	}

	function ObtenerNombre(){
		$this->query = "SELECT * FROM categoria WHERE url = '".$this->url."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenercitaUrl($url){
		$this->query = "SELECT * FROM cita WHERE url = '".$url."'";
    	$this->get_results_from_query();
	}

	function Obtenercitaimg(){
		$this->query = "SELECT * FROM cita WHERE img != '' ORDER BY RAND() LIMIT 8";
    	$this->get_results_from_query();
	}

	function ObtenercitaMail(){
		$this->query = "SELECT * FROM cita WHERE id = '".$this->id."'";
    	$this->get_results_from_query();
	}

	function Ultimoscitaes(){
		$this->query = "SELECT * FROM cita WHERE online = 1 ORDER BY id DESC LIMIT 6";
    	$this->get_results_from_query();
	}

	function ObtenerIdPadre($id){
		$this->query = "SELECT categoria.id_padre FROM categoria WHERE id = '".$id."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenerCoords(){
		$this->query = "SELECT cita.coord, cita.nombre, cita.direccion, cita.url, cita.categoria, cita.img FROM cita WHERE cita.coord != ''";
    	$this->get_results_from_query();
    }

	function ObtenerCoordsRubro($id){
		$this->query = "SELECT cita.coord, cita.nombre, cita.direccion, cita.url, cita.categoria, cita.img FROM cita WHERE cita.categoria = ".$id."";
    	$this->get_results_from_query();
	}

	function A($id){
		$this->query = "SELECT cita.id, cita.coord, cita.nombre, cita.direccion, cita.url, cita.categoria, cita.img FROM cita INNER JOIN categoria on cita.categoria = categoria.id WHERE cita.coord != '' AND categoria.id_padre = ".$id."";
    	$this->get_results_from_query();
	}

	function Destacados(){
		$this->query = "SELECT * FROM cita WHERE dest = 1 LIMIT 6";
    	$this->get_results_from_query();
	}

	function Busquedacita($busqueda){
		$this->query = "SELECT * FROM cita WHERE MATCH (nombre,descrip) AGAINST ('*".$busqueda."*' IN BOOLEAN MODE)";
    	$this->get_results_from_query();
	}

	function SelectcitaXRubro($rubro){
		$this->query = "SELECT * FROM cita WHERE id_padre = ".$rubro." ORDER BY RAND() LIMIT 8";
    	$this->get_results_from_query();
	}

}