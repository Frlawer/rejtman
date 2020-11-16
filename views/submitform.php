<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './mail/Exception.php';
require './mail/PHPMailer.php';
require './mail/SMTP.php';


require_once('./clases/area.php');
require_once('./clases/cita.php');
require_once('./clases/abogada.php');
require_once('./clases/hora.php');

$area = new Area();
$area->selectId($_POST['area']);
$datos_area = $area->rows;

$abogada = new Abogada();
$abogada->selectId($_POST['abogada']);
$datos_abogada = $abogada->rows;

$hora = new Horario();
$hora->selectId($_POST['hora']);
$datos_hora = $hora->rows;

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
    
    if(isset($_POST['upcita']) == 'Solicitar cita'){
        
        if ($_POST['abogada'] == '' && $_POST['hora'] == '') {
            
            echo '<h2>Revisa los datos completados, debes rellenar todos</h2>';
            
        }else{
            
            // seteo las post
            $area = $_POST['area'];
            $abogada = $_POST['abogada'];
            $nombre = htmlentities($_POST['nombre'], ENT_QUOTES, "UTF-8");
            $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
            $tel = $_POST['tel'];
            $date = date_create($_POST['fecha']);
            $fecha_db = date_format($date, 'Y-m-d');
            $fecha = date_format($date, 'm-d-Y');
            $hora = $_POST['hora'];
            $desc = htmlentities($_POST['desc'], ENT_QUOTES, "UTF-8");
            
            // instancio nueva cita con los datos y la subo a la db
            $cita = new Cita(null, $area, $abogada, $nombre, $email, $tel, $fecha_db, $hora, $desc);
            $cita->insert();
            
            // email para abogada

            $mail = new PHPMailer;

            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->isSMTP(); 
            $mail->Host = 'c1980986.ferozo.com'; 
            $mail->SMTPAuth = true;  
            $mail->Username = 'contacto@estudiomartinezrejtman-asoc.com.ar'; 
            $mail->Password = 'Rejtman2020'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 465;

            $mail->setLanguage('es', '\mail\language\phpmailer.lang-es.php');
            $mail->setFrom('contacto@estudiomartinezrejtman-asoc.com.ar', 'NOMBRE_ESTUDIO');
            // $mail->addAddress('contacto@estudiomartinezrejtman-asoc.com.ar', NOMBRE_ESTUDIO);
            $mail->addAddress('frlawer@gmail.com', 'NOMBRE_ESTUDIO');
            $mail->isHTML(true);
            $mail->Subject = 'Nueva cita programada.';
            $mail->Body = '<p>El cliente '.$nombre.' solicitó una cita con '.$abogada.'</p><p>En la fecha '.$fecha.'</p><p>La hora '.$hora.'</p><p>El area a tratar es '.$area.'</p><p>Datos del cliente: '.$email.', '.$tel.', '.$tel.'</p>';
            $mail->AltBody = 'Nueva cita de '.$nombre.', '.$email.', '.$tel.', '.$fecha.', '.$hora.', '.$desc;
            
            if(!$mail->send()){echo 'Error: '.$mail->ErrorInfo;}
            
            // email a cliente
            $mail2 = new PHPMailer;

            $mail2->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail2->isSMTP(); 
            $mail2->Host = 'c1980986.ferozo.com'; 
            $mail2->SMTPAuth = true;  
            $mail2->Username = 'contacto@estudiomartinezrejtman-asoc.com.ar'; 
            $mail2->Password = 'Rejtman2020'; 
            $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail2->Port = 465;
            $mail2->setLanguage('es', '\mail\language\phpmailer.lang-es.php');
            
            $mail2->setFrom('contacto@estudiomartinezrejtman-asoc.com.ar', NOMBRE_ESTUDIO);
            $mail2->addAddress($email);
            // $mail2->addReplyTo('contacto@estudiomartinezrejtman-asoc.com.ar', NOMBRE_ESTUDIO);
            $mail2->addReplyTo('frlawer@gmail.com', NOMBRE_ESTUDIO);
            $mail2->isHTML(true);
            $mail2->Subject = 'Solicitaste una cita con '.NOMBRE_ESTUDIO.'.';
            $mail2->Body = '<h1 style="text-align:center">Cita con '.NOMBRE_ESTUDIO.'.</h1>
            <h2>¡Gracias por solicitar una cita con nuestro Staff!</h2>
            <p>Los pasos a seguir son los siguientes:</p>
            <p>Recuerda que debes abonar la consulta anticipadamente a través de los siguientes medios de pago.</p>
            <p>Si usted no solicitó una cita envienos un email a <a href="mailto:contacto@estudiomartinezrejtman-asoc.com.ar">contacto@estudiomartinezrejtman-asoc.com.ar</a>.</p>
            <p>© 2020 '.NOMBRE_ESTUDIO.' Todos los derechos reservados</p>';
            
            if(!$mail2->send()){echo 'Error: '.$mail2->ErrorInfo;}else{
                
                echo '<div class="wrapper"><div class="container"><div class="row"><div class="msj-ok"><h2>Gracias por solicitar tu cita con nuestras abogadas. En breve recibirás un email con los datos necesarios para poder concretar tu asesoramiento</a></h2><div class="button text-right ">
                <a href="/" class="scrolly">Volver a inicio</a>
                </div></div></div></div></div>';
                
            }
        }
    }else{ echo '<div class="msj-nok"><h2>El Formulario no fue completado correctamente</h2></div>'; }
} else {
    // Código para aviso de error 
    echo '<div class="msj-nok"><h2>El Formulario no fue completado correctamente</h2></div>'; 
    // Código para aviso de error
    echo '<div class="msj-nok"><h2>El Formulario no fue completado correctamente</h2></div>';
    
}
