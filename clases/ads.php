<?php
require_once('conn.php');
class Ads extends DBconn {
	var $id;
	var $id_lugar;
	var $img;
	var $url;
	var $online;
	var $fecha;

	function __construct(
		$id = 0,
		$id_lugar = 0,
		$img = '',
		$url = '',
		$online = 0,
		$fecha = ''
		)
	{
		$this->id = $id;
		$this->id_lugar = $id_lugar;
		$this->img= $img;
		$this->url = $url;
		$this->online = $online;
		$this->fecha = $fecha;
	}


    protected function insert() {
        $this->query = "INSERT INTO ads (
			id_lugar,
			img,
			url,
			online,
			fecha
			) VALUES(
			'".$this->id_lugar."',
			'".$this->img."',
			'".$this->url."',
			'".$this->online."',
			'".$this->fecha."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM ads WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE ads SET
        	id_lugar = '".$this->id_lugar."',
			img = '".$this->img."',
			url = '".$this->url."',
			online = '".$this->online."',
			fecha = '".$this->fecha."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM ads ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function ListarAdsOnline(){
		$this->query = "SELECT * FROM ads WHERE ads.online = 1 ORDER BY id";
    	$this->get_results_from_query();
	}

	function ObtenerAds($id){
		$this->query = "SELECT * FROM ads WHERE id = '".$this->id."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObteneradsMail(){
		$this->query = "SELECT * FROM ads WHERE id = '".$this->id."'";
    	$this->get_results_from_query();
	}

	function Ultimosadses(){
		$this->query = "SELECT * FROM ads ORDER BY id DESC LIMIT 6";
    	$this->get_results_from_query();
	}

	function ObtenerIdPadre($id){
		$this->query = "SELECT categoria.id_padre FROM categoria WHERE id = '".$id."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenerCoords(){
		$this->query = "SELECT ads.coord, ads.nombre, ads.direccion, ads.url, ads.categoria, ads.img FROM ads";
    	$this->get_results_from_query();
	}

	function Destacados(){
		$this->query = "SELECT * FROM ads WHERE dest = 1 LIMIT 3";
    	$this->get_results_from_query();
	}

	function getExistenciaCategoria($id) {

		$sql = "SELECT id FROM categoria WHERE id = '".$id."'  LIMIT 1";
		if (mysql_num_rows($sql)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}