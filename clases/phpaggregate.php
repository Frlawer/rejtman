<?php
## ####################################### ##
##                                         ##
##  ----------- PHPAggregate -----------   ##
##                                         ##
##  PHP Aggregate Validation Functions     ##
##  for PHP 4 y PHP 5                      ##
##                                         ##
##  @version                               ##
##  Beta 1.1.1 (21.08.2011)                ##
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
    (ES) Información completa sobre esta librería en
    (EN) Complete info about this library (in spanish only) at
    http://eugeniabahit.blogspot.com/search/label/PHPAggregate%20Beta%201
*/

# validate if a string has between n1 and n2 chars, with or without white spaces
function is_strlen_between($string='', $min=1, $max=255, $allow_ws=false) {
    $has_ws = strpos($string, ' ');
    if($allow_ws == true || ($allow_ws == false && $has_ws === false)) {
        $strlen = strlen($string);
        if($strlen >= $min && $strlen <= $max) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

# validate if an string is alphabetic
function is_alphabetic($string) {
    $regEx = '/^[a-zA-záéíóúñÁÉÍÓÚÑ]*$/';
    return preg_match($regEx, $string);
}

# validate if an string is alphanumeric
function is_alphanumeric($string) {
    $regEx = '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ]*$/';
    return preg_match($regEx, $string);
}

# validate if a numerical string
function is_only_numbers($string, $allow_dash=false) {
    if($allow_dash == true) {
        $regEx = '/^\d{1}(\-?\ ?\d+){1,}$/';
    } else {
        $regEx = '/^\d+$/';
    }
    return preg_match($regEx, $string);
}

# validate an e-mail address.
function is_email($email='') {
    $regEx = '/^[a-z|A-Z][a-z|A-Z|0-9|\.|\_]{0,}@';
    $regEx .= '[a-z|A-Z][a-z|A-Z|0-9|\-]{1,}\.[a-z]{2,3}(\.[a-z]{2})?$/';
    return preg_match($regEx, $email);
}

# validate a convencional password.
function is_password($password, $min=6, $max=18) {
    $regEx = '/^[a-z|A-Z|0-9]{'.$min.','.$max.'}$/';
    return preg_match($regEx, $password);
}

# -----------------------------------------------------------
# aliasses of is_password
# -----------------------------------------------------------
function is_aZ9_between($string, $min=6, $max=18) {
    is_password($string, $min, $max);
}

function is_aZ9_password($password, $min=6, $max=18) {
    is_password($password, $min, $max);
}
# -----------------------------------------------------------


# validate a secure password
function is_secure_password($password, $min=8, $max=64) {
    $strlen = is_strlen_between($password, $min, $max);
    if($strlen == false) { return 0; exit(); }

    $requerid_chrs = array('/[a-z]/'=>0, '/[A-Z]/'=>0, '/[0-9]/'=>0,
                           '/[\!|\#|\$|\%|\&|\/|\?|\¿|\¡|\*|\+|\_|\-|\-|\@]/'=>0
                          );

    for($i=0;$i<strlen($password);$i++) {
        $regEx_not_found = 0;
        foreach ($requerid_chrs as $regEx=>$value) {
            if(preg_match($regEx, $password[$i]) == false) {
                $regEx_not_found++;
            } else {
                $requerid_chrs[$regEx] += 1;
            }
        }
        if($regEx_not_found > 3) { return 0; exit(); } //invalid char found
    }
    if(in_array(0, $requerid_chrs, true) == true) {
        return 0;
    } else {
        return 1;
    }
}

# validate an IP address
function is_ip($ip) {
    $regEx = '/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]';
    $regEx .= '\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2';
    $regEx .= '[0-4]\d|25[0-5])$/';
    return preg_match($regEx, $ip);
}

# validate a nickname
function is_nickname($user, $min=6, $max=12) {
    $strlen = is_strlen_between($user, $min, $max);
    if($strlen == false) { return 0; exit(); }
    $regEx = '/^\w*[a-zA-Z0-9]+\w*$/';
    return preg_match($regEx, $user);
}

# validate a complete personal name
function is_personal_name($name) {
    $regEx  = '/^[A-Z]{1}(\'[A-Za-z])?[a-z]+(\ {1}(y\ )?[A-Z]{1}';
    $regEx .= '(\'[A-Za-z])?[a-z]+){0,3}$/';
    return preg_match($regEx, $name);
}

# validate a spanish date format
function is_spanish_date($date='', $separator='/') {
    return helper_date('sp', $date, $separator);
}

# validate a USA date format
function is_usa_date($date='', $separator='/') {
    return helper_date('us', $date, $separator);
}

# validate a canonical date format
function is_canonical_date($date='', $separator='/') {
    return helper_date('iso', $date, $separator);
}

# alias of is_canonical_date
function is_iso_date($date='', $separator='/') {
    return is_canonical_date($date, $separator);
}

# helper date
function helper_date($format='sp', $date='', $separator='/') {
    $strlen = is_strlen_between($date, 10, 10, false);
    if($strlen == false) { return 0; exit(); }
    switch ($separator) {
        case '/': $sep = '\/'; break;
        case '-': $sep = '\-'; break;
        case '.': $sep = '\.'; break;
        default: $sep = '\/';
    }
    switch ($format) {
        case 'sp':
            $regEx = '/^[0-9]{2}'.$sep.'[0-9]{2}'.$sep.'[0-9]{4}$/';
            break;
        case 'us':
            $regEx = '/^[0-9]{2}'.$sep.'[0-9]{2}'.$sep.'[0-9]{4}$/';
            break;
        case 'iso':
            $regEx = '/^[0-9]{4}'.$sep.'[0-9]{2}'.$sep.'[0-9]{2}$/';
            break;
        default:
            $regEx = '/^[0-9]{2}'.$sep.'[0-9]{2}'.$sep.'[0-9]{4}$/';
    }
    $preg = preg_match($regEx, $date);
    if($preg == false) { return 0; exit(); }
    $new_date = explode($separator, $date);
    switch ($format) {
        case 'sp':
            $result = checkdate($new_date[1], $new_date[0], $new_date[2]);
            break;
        case 'us':
            $result = checkdate($new_date[0], $new_date[1], $new_date[2]);
            break;
        case 'iso':
            $result = checkdate($new_date[1], $new_date[2], $new_date[0]);
            break;
        default:
            $result = checkdate($new_date[1], $new_date[0], $new_date[2]);
    }
    return $result;
}
?>
