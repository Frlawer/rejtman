<?php
/*
  ================================================================
    ESPAÑOL:
  ----------------------------------------------------------------
    La siguiente clase, retorna los resultados en una matriz.
    La matriz retornada, es la propiedad protegida $this->rows.
    Para acceder a esta propiedad, deberá hacerlo através de
    la clase heredada.

    Si intenta insertar, eliminar o actualizar la base de datos
    através del método $_GET, recibirá el mensaje de error
    'Method not allowed' (método no permitido), almacenado
    en la propiedad pública $this->mensaje.

    Ver ejemplos de uso en
    http://eugeniabahit.blogspot.com/search/label/DBAbstractModel
  ================================================================

*/

abstract class DBconn {

    // set from here *************************
    private static $db_host = 'localhost';
    private static $db_user = 'root';
    private static $db_pass = '';
    protected $db_name = 'c1980986_rejtman';
    public $mensaje = 'Listo!';
    // to here *******************************

    protected $query;
    public $rows = array();
    private $conn;

    # abstract methods
    # this methods must be declared in the inherited class
    # if you don't need using these methods, comment the following lines
    // abstract protected function select();
    // abstract protected function insert();
    // abstract protected function update();
    // abstract protected function delete();

    # database connect
	private function open_connection() {
	    $this->conn = new mysqli(self::$db_host, self::$db_user,
	                             self::$db_pass, $this->db_name);
	}

	# database disconnect
	private function close_connection() {
		$this->conn->close();
	}

	# Query method for INSERT, DELETE and UPDATE
	protected function execute_single_query($orm=NULL) {
	    if($_POST||$orm) {
	        $this->open_connection();
	        $this->conn->query($this->query);
	        if(!$this->conn->error) {
	            return TRUE;
	        } else {
	            $this->mensaje = $this->conn->error;
	        }
	        $this->close_connection();
	    } else {
	        $this->mensaje = 'Metodo no encontrado';
	    }
	}

	# Query method for SELECT.
	# Return an array accesable through $this->rows
	protected function get_results_from_query() {
        $this->open_connection();
        $result = $this->conn->query($this->query);
        while ($this->rows[] = $result->fetch_assoc());
        $result->close();
        $this->close_connection();
        array_pop($this->rows);
	}
}