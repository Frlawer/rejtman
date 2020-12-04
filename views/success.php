<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Código para procesar el formulario
if (array_key_exists('email', $_SESSION)) {
    date_default_timezone_set('Etc/UTC');

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
        
        // seteo las session
        
        $nombre = htmlentities($_SESSION['nombre'], ENT_QUOTES, "UTF-8");
        $apellido = htmlentities($_SESSION['apellido'], ENT_QUOTES, "UTF-8");
        $email = htmlentities($_SESSION['email'], ENT_QUOTES, "UTF-8");
        $dni = $_SESSION['dni'];
        $tel = $_SESSION['tel'];
        $area = $_SESSION['area'];
        $abogada = $_SESSION['abogada'];
        $date = date_create($_SESSION['fecha']);
        $fecha_db = date_format($date, 'Y-m-d');
        $fecha = date_format($date, 'm-d-Y');
        $horario = $_SESSION['hora'];
        $desc = htmlentities($_SESSION['desc'], ENT_QUOTES, "UTF-8");
        
        // Cargo cliente BD
        $cliente2 = new Cliente(null, $nombre, $apellido, $email, $dni, $tel, ' ', $desc);
        $cliente2->insert();
        
        // Cargo la Cita a BD
        
        $cita2 = new Cita(null, $area, $abogada, $nombre, $email, $tel, $fecha_db, $horario, $desc);
        $cita2->insert();
        
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
        $mail->addAddress('frlawer@gmail.com', NOMBRE_ESTUDIO);
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
        $mail2->Body = '<h1 style="text-align:center">Cita con '.NOMBRE_ESTUDIO.'</h1><h2>¡Gracias por solicitar una cita con nuestro Staff!</h2><p>Los pasos a seguir son los siguientes:</p><p>Recuerda que debes abonar la consulta anticipadamente a través de los siguientes medios de pago.</p><p>';
        foreach ($datos_cuenta as $key => $value) {
            $mail2->Body .= '<h3>'.$value['cuenta_nombre'].'</h3>';
            $mail2->Body .= '<p>'.$value['cuenta_datos'].'</p>';
        }
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
                        <a href="/cita" class="button">Solicitar nuevamente una cita.</a>
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