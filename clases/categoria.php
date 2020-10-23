<?php
require_once('conn.php');
class Categoria extends DBconn {
	var $id;
	var $nombre;
	var $id_padre;
	var $url;

	function __construct($id = 0, $nombre = '', $id_padre = 0, $url = ''){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->id_padre = $id_padre;
		$this->url = $url;
	}

    protected function insert() {
        $this->query = "INSERT INTO categoria (
			nombre,
			id_padre,
			url
			) VALUES(
			'".$this->nombre."',
			'".$this->id_padre."',
			'".$this->url."'
			)";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM categoria WHERE id = '".$this->id."'";
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE categoria SET
			nombre = '".$this->nombre."',
			id_padre = '".$this->id_padre."',
			url = '".$this->url."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM categoria ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

	public function ObtenerCategoriaHijos($id_padre){
		$this->query = "SELECT * FROM categoria WHERE id_padre = '".$id_padre."' ORDER BY nombre";
    	$this->get_results_from_query();
	}

	public function ObtenerNombreId($id){
		$this->query = "SELECT * FROM categoria WHERE id = '".$id."'";
    	$this->get_results_from_query();
	}

	function ObtenerNombre(){
		$this->query = "SELECT * FROM categoria WHERE url = '".$this->url."' LIMIT 1";
    	$this->get_results_from_query();
	}

	function ObtenerLetra($letra,$id_padre){
		$this->query = "SELECT * FROM categoria WHERE nombre REGEXP '^".$letra."' AND id_padre = '".$id_padre."'";
    	$this->get_results_from_query();
	}

	function ObtenerIdPadre(){
		$this->query = "SELECT id,nombre FROM categoria WHERE id_padre = 0";
    	$this->get_results_from_query();
	}



	function ListarCategoriasClientes($id){
		$conexion = new ConexionBD();
		$query = "SELECT DISTINCT categoria.id, categoria.letra, categoria.nombre, categoria.id_rubro, categoria.url FROM categoria, clientes WHERE categoria.id = clientes.id and categoria.id_rubro = '".$id_rubro."' ORDER BY letra";

		$result = $conexion->ejecutarsentencia($query);
		$resultados = array();
		while ($row = mysql_fetch_array($result)) {
			$registro = array();
			$registro['id'] = $row['id'];
			$registro['nombre'] = $row['nombre'];
			$registro['id_padre'] = $row['id_padre'];
			$registro['url'] = $row['url'];
			array_push($resultados,$registro);

		}
		mysql_free_result($result);
		return $resultados;
	}

	function ObtenerCategoriaId(){
		$conexionBaseDatos = new ConexionBD();

		$sql = "SELECT * FROM categoria WHERE id = ".$this->id." LIMIT 1";

		$result = $conexionBaseDatos->ejecutarsentencia($sql);
		while ($row = mysqli_fetch_array($result)) {
			$this->id = $row['id'];
			$this->nombre = $row['nombre'];
			$this->id_padre = $row['id_padre'];
			$this->url = $row['url'];

		}
		mysql_free_result($result);
	}

	function Obtener(){
		$conexionBaseDatos = new ConexionBD();

		$sql = "SELECT * FROM categoria WHERE id = '".$this->id."'";

		$result = $conexionBaseDatos->ejecutarsentencia($sql);

		while ($row = mysql_fetch_array($result)) {
			$this->id = $row['id_cat'];
			$this->nombre = $row['nombre_cat'];
			$this->letra = $row['letra_cat'];
			$this->rubro = $row['id_rubro'];
			$this->url = $row['url_cat'];
		}
		mysql_free_result($result);
	}

	function getExistenciaCategoria($id) {

		$sql = "SELECT id FROM categoria WHERE id = '".$id."'  LIMIT 1";
		if (mysql_num_rows($sql)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function BusquedaCategoria($busqueda){
		$this->query = "SELECT * FROM categoria WHERE MATCH (nombre) AGAINST ('*".$busqueda."*' IN BOOLEAN MODE)";
    	$this->get_results_from_query();
	}
}