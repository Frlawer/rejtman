<?php
require_once('conn_class.php');
class Tipo extends DBconnClass {
	var $id;
	var	$nombre;
	var	$padre;
	var	$url;

	function __construct(
		$id = 0,
		$nombre = '',
		$padre = 0,
		$url = ''
		)
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->padre = $padre;
		$this->url = $url;
	}


    function insert() {
        $this->query = "INSERT INTO tipo (
			nombre,
			padre,
			url
			) VALUES(
			'".$this->nombre."',
			'".$this->padre."',
			'".$this->url."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM tipo WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE tipo SET
			nombre = '".$this->nombre."',
			padre = '".$this->padre."',
			url = '".$this->url."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM tipo ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function selectAllUrl($url){
		$this->query = "SELECT * FROM tipo WHERE url = '".$url."'";
    	$this->get_results_from_query();
	}

	public function selectHijosId($id){
		$this->query = "SELECT * FROM tipo WHERE padre = '".$id."'";
    	$this->get_results_from_query();
	}

	public function selectPadreId($cat_padre){
		$this->query = "SELECT * FROM tipo WHERE id = '".$cat_padre."'";
    	$this->get_results_from_query();
	}

	public function selectCatId($id_cat){
		$this->query = "SELECT * FROM tipo WHERE id = '".$id_cat."'";
    	$this->get_results_from_query();
	}
}