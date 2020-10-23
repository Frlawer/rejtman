<?php
require_once('conn.php');
class Q extends DBconn {
    var $q;

    function __construct($q = ''){
        $this->q = $q;
    }

    public function Qcat(){
        $this->query = "SELECT *, MATCH (nombre) AGAINST ('".$this->q."') AS rel FROM categoria WHERE MATCH (nombre) AGAINST ('".$this->q."')";
        $this->get_results_from_query();
    }

    public function Qlug(){
        $this->query = "SELECT *, MATCH (nombre) AGAINST ('".$this->q."') AS rel FROM lugar WHERE MATCH (nombre) AGAINST ('".$this->q."')";
        $this->get_results_from_query();
    }
}