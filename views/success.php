<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Código para procesar el formulario
if (array_key_exists('email', $_SESSION)) {

    // require './vendor/autoload.php';
    require 'mail/Exception.php';
    require 'mail/PHPMailer.php';
    require 'mail/SMTP.php';

    require_once('./clases/area.php');
    require_once('./clases/cita.php');
    require_once('./clases/abogada.php');
    require_once('./clases/hora.php');
    require_once('./clases/cliente.php');
    require_once('./clases/cuenta.php');
    
// guardo los datos de la trasnaccion mp

   var_dump($_GET);


    // seteo las session
    
    $nombre = htmlentities($_SESSION['nombre'], ENT_QUOTES, "UTF-8");
    $apellido = htmlentities($_SESSION['apellido'], ENT_QUOTES, "UTF-8");
    $email = htmlentities($_SESSION['email'], ENT_QUOTES, "UTF-8");
    $dni = htmlentities($_SESSION['dni'], ENT_QUOTES, "UTF-8");
    $tel = htmlentities($_SESSION['tel'], ENT_QUOTES, "UTF-8");
    $area = $_SESSION['area'];
    $abogada = $_SESSION['abogada'];
    $date = date_create($_SESSION['fecha']);
    $fecha_db = date_format($date, 'Y-m-d');
    $fecha = date_format($date, 'm-d-Y');
    $horario = $_SESSION['hora'];
    $dir = 'direccion';
    $desc = htmlentities($_SESSION['desc'], ENT_QUOTES, "UTF-8");
    
    require_once './admin/lib/MysqliDb/MysqliDb.php';


    $cliente = getDbInstance();
    $data = Array (
        "cliente_nombre" => $nombre,
        "cliente_apellido" => $apellido,
        "cliente_email" => $email,
        "cliente_dni" => $dni,
        "cliente_tel" => $tel,
        "cliente_dir" => $dir,
        "cliente_desc" => $desc
    );
    $data['create_at'] = date('Y-m-d H:i:s');
    $id = $cliente->insert ('cliente', $data);

    // Cargo cliente BD
    // $upcliente = new Cliente(null, $nombre, $apellido, $email, $dni, $tel, ' ', $desc);
    // $upcliente->insert();
    
    // Cargo la Cita a BD
    $cita = getDbInstance();
    
    $datacita = Array (
        "area_id" => $area,
        "abogada_id" => $abogada,
        "cita_nombre" => $nombre,
        "cita_email" => $email,
        "cita_tel" => $tel,
        "cita_fecha" => $fecha_db,
        "horario_id" => $horario,
        "cita_desc" => $desc,
    );
    $datacita['create_at'] = date('Y-m-d H:i:s');

    $up = $cita->insert('cita', $datacita);
    // $cita2 = new Cita(null, $area, $abogada, $nombre, $email, $tel, $fecha_db, $horario, $desc);
    // $cita2->insert();
    
    // consulto datos para envíar email a abogada

    $data_area = new Area();
    $data_area->selectId($area);
    $datos_area = $data_area->rows[0];

    $data_abogada = new Abogada();
    $data_abogada->selectId($abogada);
    $datos_abogada = $data_abogada->rows[0];

    $data_hora = new Horario();
    $data_hora->selectId($horario);
    $datos_hora = $data_hora->rows[0];

    $data_cuenta = new Cuenta();
    $data_cuenta->selectAbogadaId($abogada);
    $datos_cuenta = $data_cuenta->rows;

    // email para abogada

    $mail = new PHPMailer;

    $mail->CharSet = 'UTF-8';
    $mail->setFrom('contacto@estudiomartinezrejtman-asoc.com.ar', NOMBRE_ESTUDIO);
    $addresses = [
        '1' => 'luciaeschler@estudiomartinezrejtman-asoc.com.ar',
        '2' => 'jaeljulian@estudiomartinezrejtman-asoc.com.ar',
        '3' => 'martamrejtman@estudiomartinezrejtman-asoc.com.ar',
    ];
    if (array_key_exists('abogada', $_SESSION) && array_key_exists($_SESSION['abogada'], $addresses)) {
        $mail->addAddress($datos_abogada['abogada_email']);
    } else {
        $mail->addAddress('contacto@estudiomartinezrejtman-asoc.com.ar');
    }
    // $mail->addAddress($datos_abogada['abogada_email'] , NOMBRE_ESTUDIO);
    $mail->Subject = 'Nueva cita programada.';
    $mail->isHTML(true);
    $mail->Body = '<p>El cliente '.$nombre.' '.$apellido.' solicitó una cita con '.$datos_abogada['abogada_nombre'].'</p><p>En la fecha '.$_SESSION['fecha'].'</p><p>La hora '.$datos_hora['horario_hora'].'</p><p>El area a tratar es '.$datos_area['area_nombre'].'</p><p>Datos del cliente: Email: '.$email.', Telefono: '.$tel.', Descripción: '.$desc.'</p>';
    
    if(!$mail->send()){
        echo 'Error: '.$mail->ErrorInfo;
        echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>Email a abogada falló</a></h2><div class="button text-right "><a href="/" class="scrolly">Volver a inicio</a></div></div></div></div></div>';
    }
    
    // email a cliente
    $mail2 = new PHPMailer;
    
    $mail2  ->CharSet = 'UTF-8';
    $mail2->setFrom('contacto@estudiomartinezrejtman-asoc.com.ar', NOMBRE_ESTUDIO);
    $mail2->addAddress($email);
    $mail2->isHTML(true);
    $mail2->Subject = 'Solicitaste una cita con '.NOMBRE_ESTUDIO;
    $mail2->Body = '<h1 style="text-align:center">Cita con '.NOMBRE_ESTUDIO.'</h1><h2>¡Gracias por solicitar una cita con nuestro Staff!</h2><p>Los pasos a seguir son los siguientes:</p><p>Si recibiste este email significa que la consulta fue abonada correctamente, y la cita fue programada en el día solicitado. En cualquier situación que no sea posible realizar la misma nos pondremos en contacto con ud. para informar cualquier cambio realizado.</p>';
    $mail2->Body .= '</p><p>Si usted no solicitó una cita envienos un email a <a href="mailto:contacto@estudiomartinezrejtman-asoc.com.ar">contacto@estudiomartinezrejtman-asoc.com.ar</a>.</p><p>© 2020 '.NOMBRE_ESTUDIO.' Todos los derechos reservados</p>';
    
    if(!$mail2->send()){
        echo 'Error: '.$mail->ErrorInfo;
    }

    session_destroy();
} 
?>
<!-- contacto -->
<div class="contactarea wrapper" id="contactarea">
        <div class="container">
            <div class="row">
                <div class="col-6 col-12-mobile">
                    <div class="contactInfo">
                        <span>Pago finalizado!</span>
                        <h2>Recibimos tu pago, tu cita fue agendada correctamente.</h2>
                        <h6>Debes revisar tu Email para conocer el procedimiento.</h6>
                        <p>A veces la tarjeta es rechazada o el metodo de pago no fue aprovado por MP, otro problema frecuente es que tengas activado un bloqueador de publicidad en tu navegador que no permite finalizar el pago, desactivalo y recarga la página nuevamente.</p>
                        <a href="/" class="button">Volver a inicio.</a>
                    </div>
                </div>
                <div class="col-12-mobile col-6">
                    <span class="image lateral">
                        <img src="images/img04.jpg" alt="">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>