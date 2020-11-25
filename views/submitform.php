<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// $msj = '';
// $msj1 = '';
// $msj2 = '';
/**
 * submit envio de email
 * $_POST['area'];
 * $_POST['abogada'];
 * $_POST['nombre'];
 * $_POST['email'];
 * $_POST['tel'];
 * $_POST['fecha'];
 * $_POST['hora'];
 * $_POST['desc'];
 */

// Recaptchaa!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$recaptcha_secret = RECAPTCHA_KEY; 
$recaptcha_response = $_POST['recaptcha_response']; 
$url = 'https://www.google.com/recaptcha/api/siteverify'; 

$data = array( 'secret' => $recaptcha_secret, 'response' => $recaptcha_response, 'remoteip' => $_SERVER['REMOTE_ADDR'] ); 
$curlConfig = array( CURLOPT_URL => $url, CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => $data ); 
$ch = curl_init(); 
curl_setopt_array($ch, $curlConfig); 
$response = curl_exec($ch); 
curl_close($ch);

$jsonResponse = json_decode($response);
if ($jsonResponse->success === true) { 
    // Código para procesar el formulario

    if (array_key_exists('email', $_POST)) {
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
            
            // Cargo cliente BD

            $cliente = new Cliente(null, $_POST['nombre'], $_POST['tel'], '', $_POST['email'], '');
            $cliente->insert();

            // seteo las post

            $area = $_POST['area'];
            $abogada = $_POST['abogada'];
            $nombre = htmlentities($_POST['nombre'], ENT_QUOTES, "UTF-8");
            $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
            $tel = $_POST['tel'];
            $date = date_create($_POST['fecha']);
            $fecha_db = date_format($date, 'Y-m-d');
            $fecha = date_format($date, 'm-d-Y');
            $horario = $_POST['hora'];
            $desc = htmlentities($_POST['desc'], ENT_QUOTES, "UTF-8");
            
            // Cargo la Cita a BD

            $cita = new Cita(null, $area, $abogada, $nombre, $email, $tel, $fecha_db, $horario, $desc);
            $cita->insert();

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
            if (array_key_exists('abogada', $_POST) && array_key_exists($_POST['abogada'], $addresses)) {
                $mail->addAddress($datos_abogada['abogada_email']);
            } else {
                $mail->addAddress('contacto@estudiomartinezrejtman-asoc.com.ar');
            }
            // $mail->addAddress($datos_abogada['abogada_email'] , NOMBRE_ESTUDIO);
            $mail->addAddress('frlawer@gmail.com', NOMBRE_ESTUDIO);
            $mail->Subject = 'Nueva cita programada.';
            $mail->isHTML(true);
            $mail->Body = '<p>El cliente '.$nombre.' solicitó una cita con '.$datos_abogada['abogada_nombre'].'</p><p>En la fecha '.$_POST['fecha'].'</p><p>La hora '.$datos_hora['horario_hora'].'</p><p>El area a tratar es '.$datos_area['area_nombre'].'</p><p>Datos del cliente: Email: '.$email.', Telefono: '.$tel.', Descripción: '.$desc.'</p>';
            
            if(!$mail->send()){
                echo 'Error: '.$mail->ErrorInfo;
                echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>Email a abogada falló</a></h2><div class="button text-right "><a href="/" class="scrolly">Volver a inicio</a></div></div></div></div></div>';
            }else{
                // echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>Msj abogada enviado</a></h2><div class="button text-right ">
                // <a href="/" class="scrolly">Volver a inicio</a>
                // </div></div></div></div></div>'; 
                //  'Error: '.$mail->ErrorInfo;}
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
                echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>Msj cliente error</a></h2><div class="button text-right "><a href="/" class="scrolly">Volver a inicio</a></div></div></div></div></div>';
            }else{
                // echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>msj cliente enviado.</a></h2><div class="button text-right ">
                // <a href="/" class="scrolly">Volver a inicio</a>
                // </div></div></div></div></div>';
            }
            echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h3>Gracias por solicitar tu cita con nuestras abogadas. En breve recibirás un email con los datos necesarios para poder concretar tu asesoramiento</a></h3><a class="button text-right "><a href="/" class="scrolly">Volver a inicio</a></a></div></div></div></div>';

        }else{
            echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>Email invalido</a></h2><div class="button text-right "><a href="/" class="scrolly">Volver a inicio</a></div></div></div></div></div>';
        } 
        // if (!empty($msj) || !empty($msj1) || !empty($msj2)) {
        //     header('Location : estudiomartinezrejtman-asoc.com.ar/cita');
        // } 
}