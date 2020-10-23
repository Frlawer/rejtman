<?php
require_once('conn_class.php');
class User extends DBconnClass {
	var $id;
	var	$nick;
	var	$pass;
	var	$nombre;
	var	$email;
	var	$activo;

	function __construct(
		$id = 0,
		$nick = '',
		$pass = '',
		$nombre = '',
		$email = '',
		$activo = 0
		)
	{
		$this->id = $id;
		$this->nick = $nick;
		$this->pass = $pass;
		$this->nombre = $nombre;
		$this->email = $email;
		$this->activo = $activo;
	}


    function insert() {
        $this->query = "INSERT INTO user (
        	nick,
        	pass,
        	nombre,
        	email,
        	activo) VALUES (
        	'".$this->nick."',
        	'".$this->pass."',
        	'".$this->nombre."',
        	'".$this->email."',
        	'0'
        	);";
        $this->execute_single_query();
    }

    protected function delete() {
        $this->query = "DELETE FROM user WHERE id = ".$this->id;
        $this->execute_single_query();
    }

    protected function update() {
        $this->query = "UPDATE user SET
			nick = '".$this->nick."',
			pass = '".$this->pass."',
			nombre = '".$this->nombre."',
			email = '".$this->email."',
			activo = '".$this->activo."'
			WHERE id = ".$this->id."";
        $this->execute_single_query();
    }

    public function select() {
        $this->query = "SELECT * FROM user ORDER BY id";
        $this->get_results_from_query();
        // retorna un array con los resultados $this->rows;
    }

    public function selectNickEmail() {
        $this->query = "SELECT * FROM user WHERE nick = ".$this->nick." or email = ".$this->email."";
        $this->get_results_from_query2();
    }

	public function selectAllActivo($activo){
		$this->query = "SELECT * FROM user WHERE activo = '".$activo."'";
    	$this->get_results_from_query();
	}

	public function selectId($id){
		$this->query = "SELECT * FROM user WHERE id = '".$id."'";
    	$this->get_results_from_query();
	}

	public function insertUser(){
		$this->insert();
	}

}