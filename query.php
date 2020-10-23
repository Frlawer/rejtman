<?php
/*
  |--------------------------------------------------------------------------
  | Setea las var de session
  |--------------------------------------------------------------------------
  |
 */
function set_datos($yo, $row) {
    $_SESSION['id'] = $yo['id'];
    $_SESSION['nombre'] = $yo['nombre'];
    $_SESSION['apellido'] = $yo['apellido'];
    $_SESSION['usuario'] = $yo['usuario'];
    $_SESSION['email'] = $yo['email'];
    $_SESSION['id_afiliado'] = $yo['id_afiliado'];
    $_SESSION['categoria'] = $yo['categoria'];
    return TRUE;
}

/*
  |--------------------------------------------------------------------------
  | Saber si existe el usuario en nuestra db
  |--------------------------------------------------------------------------
  |
 */

function get_existencia_usuario($id) {

    $sql = "SELECT id FROM usuarios WHERE id = $id  LIMIT 1";
    if (mysqli_stmt_num_rows($sql)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/*
  |--------------------------------------------------------------------------
  | Registrar al usuario en nuestra db si no lo está
  |--------------------------------------------------------------------------
  |
 */

function registrar_usuario($fuid) {
    $sql = "
            INSERT INTO usuarios
            (
                usr_user,
                usr_nombre,
                usr_apellido,
                usr_nacimiento,
                usr_email,
                usr_ciudad,
                usr_password
            )
            VALUES
            (
                '" . $_SESSION['user'] . "',
                '" . $_SESSION['nombre'] . "',
                '" . $_SESSION['apellido'] . "',
                '" . $_SESSION['nacimiento'] . "',
                '" . $_SESSION['email'] . "',
                '" . $_SESSION['ciudad'] . "',
                '" . $_SESSION['password'] . "'
            )

            ";
    insertarDatos($sql);
}

/*
  |--------------------------------------------------------------------------
  | Datos de un usuario de nuestra db (NO FACEBOOK)
  |--------------------------------------------------------------------------
  |
 */

function get_usuario($fuid) {
    $sql = "SELECT * FROM usuarios WHERE fuid = $fuid  LIMIT 1";
    return consultarArray($sql);
}