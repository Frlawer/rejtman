<?php
require_once('conn.php');
class Noticia extends DBconn {
	var $id;
	var	$categoria;
	var	$titulo;
	var	$txt;
	var	$email;
	var	$img;
	var	$persona;
	var	$url;
	var	$fecha;

	function __construct(
		$id = 0,
		$categoria = 0,
		$titulo = '',
		$txt = '',
		$email = '',
		$img = '',
		$persona = '',
		$url = '',
		$fecha = ''
		)
	{
		$this->id = $id;
		$this->categoria = $categoria;
		$this->titulo = $titulo;
		$this->txt = $txt;
		$this->email = $email;
		$this->img = $img;
		$this->persona = $persona;
		$this->url = $url;
		$this->fecha = $fecha;
	}


    function insert() {
        $this->query = "INSERT INTO noticia (
			categoria,
			titulo,
			txt,
			email,
			img,
			persona,
			url,
			fecha
			) VALUES(
			'".$this->categoria."',
			'".$this->titulo."',
			'".$this->txt."',
			'".$this->email."',
			'".$this->img."',
			'".$this->persona."',
			'".$this->url."',
			'".$this->fecha."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM noticia WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE noticia SET
			nombre = '".$this->nombre."',
			id_padre = '".$this->id_padre."',
			url = '".$this->url."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM noticia ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function ListarLugarCategoria($idcategoria){
		$this->query = "SELECT * FROM noticia WHERE categoria = ".$idcategoria." ORDER BY id";
    	$this->get_results_from_query();
	}


}