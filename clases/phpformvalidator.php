<?php
## ####################################### ##
##                                         ##
##  --------- PHPFormValidator ---------   ##
##                                         ##
##  PHP class for forms validation         ##
##  (for PHP 5)                            ##
##                                         ##
##  @version                               ##
##  Beta 1 (26.07.2011)                    ##
##                                         ##
##  @author                                ##
##  Eugenia Bahit                          ##
##  http://eugeniabahit.blogspot.com/      ##
##                                         ##
##  @licence                               ##
##  LGPL                                   ##
##                                         ##
## ####################################### ##

/*
    IMPORTANTE: Esta clase requiere PHPAggregate:
    http://eugeniabahit.blogspot.com/search/label/PHPAggregate%20Beta%201
    Modificar línea 34 para importar PHPAggregate

    IMPORTANT: This class require PHPAggregate:
    http://eugeniabahit.blogspot.com/search/label/PHPAggregate%20Beta%201
    Change line 34 in order to import PHPAggregate

    Info about PHPFormValidator at / Info sobre PHPFormValidator en
    http://eugeniabahit.blogspot.com/search/label/PHPFormValidator
*/
    require_once('phpaggregate.php');

class FormValidator {

    # Class constants
    const FV_SAID = 'validate_form() method said: I can not continue because <br>';
    const DEV_ERR_FOUND = 'Encontré un error de programación en los argumentos recibidos:<br> ';
    const UNEXPECTED_ERROR = 'Unexpected error';
    const NO_GET_DATA = 'No $_GET data recived:Se produce cuando habiendo indicado a PHPFormValidator que el método de envío de datos del formulario es GET, el método constructor no recibe ninguna data vía $_GET';
    const NO_POST_DATA = 'No $_POST data recived:Se produce cuando habiendo indicado a PHPFormValidator que el método de envío de datos del formulario es POST, el método constructor no recibe ninguna data vía $_POST';
    const NO_ARGS = 'Arguments are not sufficient in the fields options:Se produce cuando la función de validación de datos llamada para comprobar un determinado campo, no encuentra los argumentes suficientes para ejecutarse.';
    const EXIT_CALLED = 'Warning: The execution was stopped!<br>';
    const WRONG_ARGS = 'Los argumentos son erróneos:Para cada campo, PHPFormValidator espera una string con el nombre del tipo de datos y una variable booleana (TRUE o FALSE) para saber si el campo es o no obligatorio (es decir, si el usuario tiene la obligación de rellenar dicho campo). Cuando PHPFormValidator se encuentra con que el primer argumento del campo, no es una string o el segundo, no es boolean, retornará el error "Arguments are wrong"';
    const UNKNOW_TYPE = '\'%s\' is an unknown data type:Se produce cuando el tipo de datos indicado para un determinado campo, no es un tipo de datos conocido (ver más arriba, la tabla: "Tipos de datos admitidos").';
    const FIELD_NOT_FOUND = '\'%s\' was not found in the received array data:Se produce cuando se ha indicado el nombre de un campo inexistente. En este caso, se recomienda verificar la ortografía del nombre del campo indicado en [field_name], pues frecuente que este error se produzca por un error de tipeado.';
    const FIELD_WITHOUT_DATA = 'Can not be null';
    const FIELD_WRONG_DATA = 'Corrobora los datos ingresados.';

    # Protected class properties
    protected $field_list = array();
    protected $method = 'POST';
    protected $data = array();

    # Protected static class properties
    protected static $allowed_types = array(
             'alphabetic'=>'is_alphabetic',
             'alphanumeric'=>'is_alphanumeric',
             'numeric'=>'is_only_numbers',
             'email'=>'is_email',
             'password'=>'is_password',
             'secure_password'=>'is_secure_password',
             'ip'=>'is_ip',
             'nickname'=>'is_nickname',
             'username'=>'is_nickname', // alias of nickname
             'personal_name'=>'is_personal_name',
             'spanish_date'=>'is_spanish_date',
             'usa_date'=>'is_usa_date',
             'date'=>'is_usa_date', // alias of usa_date
             'iso_date'=>'is_iso_date',
             'canonical_date'=>'is_canonical_date',
             'string'=>'is_strlen_between',
             'boolean'=>'is_bool'
            );

    # Public class properties
    public $invalid_fields = NULL;
    public $form_data = array();

    # Constructor method
    function __construct($method='POST', $field_list=array()) {
        $this->field_list = $field_list;
        $this->method = $method;
        $this->set_method();
        $this->set_data();
        $this->validate_form();
    }

    # Other helpers and methods
    protected function set_method() {
        if($this->method != 'POST' && $this->method != 'GET') {
            $this->method = 'POST';
        }
    }

    protected function set_data() {
        $data = array();
        if($this->method == 'GET') {
            if(!$_GET) {
                $this->stop(self::NO_GET_DATA);
            } else {
                $data = $_GET;
            }
        } else if($this->method == 'POST') {
            if(!$_POST) {
                $this->stop(self::NO_POST_DATA);
            } else {
                $data = $_POST;
            }
        }
        $this->data = $data;
    }

    protected function helper_count_args() {
        $args = func_get_args();
        if(count($args) < 1) {
            $this->stop(self::NO_ARGS);
        } else {
            if(count($args[0])<2) {
                $this->stop(self::NO_ARGS);
            } else {
                $this->helper_type_args($args[0]);
            }
        }
    }

    protected function helper_type_args($args) {
        if(!is_string($args[0])) {
            $this->stop(self::WRONG_ARGS);
        }
        if(!is_bool($args[1])) {
            $this->stop(self::WRONG_ARGS);
        }
    }

    protected function helper_allowed_type($type='') {
        if(!array_key_exists($type, self::$allowed_types)) {
            $this->stop(self::UNKNOW_TYPE, $type);
        }
    }

    protected function helper_field_name($field_name='') {
        if(!array_key_exists($field_name, $this->data)) {
            $this->stop(self::FIELD_NOT_FOUND, $field_name);
        }
    }

    protected function helper_field_value($field_name, $requerid) {
        if(!$this->data[$field_name] && ($requerid)) {
            $this->invalid_fields[$field_name] = self::FIELD_WITHOUT_DATA;
        }
    }

    protected function helper_prepare_options($options=array()) {
        if(count($options)>2) {
            array_shift($options);
            array_shift($options);
        }
        return $options;
    }

    protected function helper_args($options, $string) {
        $args = $options;
        array_shift($args);
        array_shift($args);
        array_unshift($args, $string);
        return $args;
    }

    protected function stop($reason='', $string='') {
        if(!$reason) {
            $reason = self::UNEXPECTED_ERROR;
        }
        $reason = str_replace('%s', $string, $reason);
        $message = self::EXIT_CALLED.chr(10).self::FV_SAID;
        $message .= self::DEV_ERR_FOUND.chr(10).$reason;
        die($message);
    }

    # Compilator method for validation form
    protected function validate_form() {
        foreach($this->field_list as $field_name=>$options) {
            $this->helper_count_args($options);
            $this->helper_allowed_type($options[0]);
            $this->helper_field_name($field_name);
            $this->helper_field_value($field_name, $options[1]);
            $string = $this->data[$field_name];
            $func = self::$allowed_types[$options[0]];
            if($string) {
                $args = $this->helper_args($options, $string);
                $result = call_user_func_array($func, $args);
                if(!$result) {
                    $this->invalid_fields[$field_name] = self::FIELD_WRONG_DATA;
                }
            }
            $this->form_data = $this->data;
        }
    }
}