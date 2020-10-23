<?php
require_once('conn.php');
class Lugar extends DBconn {
	var $id;
	var	$persona;
	var	$nombre;
	var	$categoria;
	var	$direccion;
	var	$telefono;
	var	$web;
	var	$fb;
	var	$tw;
	var	$email;
	var	$img;
	var	$coord;
	var	$url;
	var	$descrip;
	var	$dest;
	var	$online;
	var	$fecha;

	function __construct(
		$id = 0,
		$persona = '',
		$nombre = '',
		$categoria = 0,
		$direccion = '',
		$telefono = '',
		$web = '',
		$fb = '',
		$tw = '',
		$email = '',
		$img = '',
		$coord = '',
		$url = '',
		$descrip = '',
		$dest = 0,
		$online = 0,
		$fecha = ''
		)
	{
		$this->id = $id;
		$this->persona = $persona;
		$this->nombre = $nombre;
		$this->categoria = $categoria;
		$this->direccion = $direccion;
		$this->telefono = $telefono;
		$this->web = $web;
		$this->fb = $fb;
		$this->tw = $tw;
		$this->email = $email;
		$this->img = $img;
		$this->coord = $coord;
		$this->url = $url;
		$this->descrip = $descrip;
		$this->dest = $dest;
		$this->online = $online;
		$this->fecha = $fecha;
	}


    function insert() {
        $this->query = "INSERT INTO lugar (
			persona,
			nombre,
			categoria,
			direccion,
			telefono,
			web,
			fb,
			tw,
			email,
			img,
			coord,
			url,
			descrip,
			dest,
			online,
			fecha
			) VALUES(
			'".$this->persona."',
			'".$this->nombre."',
			'".$this->categoria."',
			'".$this->direccion."',
			'".$this->telefono."',
			'".$this->web."',
			'".$this->fb."',
			'".$this->tw."',
			'".$this->email."',
			'".$this->img."',
			'".$this->coord."',
			'".$this->url."',
			'".$this->descrip."',
			'".$this->dest."',
			'".$this->online."',
			'".$this->fecha."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM lugar WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE lugar SET
			nombre = '".$this->nombre."',
			id_padre = '".$this->id_padre."',
			url = '".$this->url."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM lugar ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function ListarLugarCategoria($idcategoria){
		$this->query = "SELECT * FROM lugar WHERE lugar.categoria = ".$idcategoria." AND lugar.online = 1 ORDER BY id";
    	$this->get_results_from_query();
	}

	function ObtenerNombre(){
		$this->query = "SELECT * FROM categoria WHERE url = '".$this->url."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenerLugarUrl($url){
		$this->query = "SELECT * FROM lugar WHERE url = '".$url."'";
    	$this->get_results_from_query();
	}

	function ObtenerLugarimg(){
		$this->query = "SELECT * FROM lugar WHERE img != '' ORDER BY RAND() LIMIT 8";
    	$this->get_results_from_query();
	}

	function ObtenerLugarMail(){
		$this->query = "SELECT * FROM lugar WHERE id = '".$this->id."'";
    	$this->get_results_from_query();
	}

	function UltimosLugares(){
		$this->query = "SELECT * FROM lugar WHERE online = 1 ORDER BY id DESC LIMIT 6";
    	$this->get_results_from_query();
	}

	function ObtenerIdPadre($id){
		$this->query = "SELECT categoria.id_padre FROM categoria WHERE id = '".$id."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenerCoords(){
		$this->query = "SELECT lugar.coord, lugar.nombre, lugar.direccion, lugar.url, lugar.categoria, lugar.img FROM lugar WHERE lugar.coord != ''";
    	$this->get_results_from_query();
    }

	function ObtenerCoordsRubro($id){
		$this->query = "SELECT lugar.coord, lugar.nombre, lugar.direccion, lugar.url, lugar.categoria, lugar.img FROM lugar WHERE lugar.categoria = ".$id."";
    	$this->get_results_from_query();
	}

	function A($id){
		$this->query = "SELECT lugar.id, lugar.coord, lugar.nombre, lugar.direccion, lugar.url, lugar.categoria, lugar.img FROM lugar INNER JOIN categoria on lugar.categoria = categoria.id WHERE lugar.coord != '' AND categoria.id_padre = ".$id."";
    	$this->get_results_from_query();
	}

	function Destacados(){
		$this->query = "SELECT * FROM lugar WHERE dest = 1 LIMIT 6";
    	$this->get_results_from_query();
	}

	function BusquedaLugar($busqueda){
		$this->query = "SELECT * FROM lugar WHERE MATCH (nombre,descrip) AGAINST ('*".$busqueda."*' IN BOOLEAN MODE)";
    	$this->get_results_from_query();
	}

	function SelectLugarXRubro($rubro){
		$this->query = "SELECT * FROM lugar WHERE id_padre = ".$rubro." ORDER BY RAND() LIMIT 8";
    	$this->get_results_from_query();
	}

}