<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './mail/Exception.php';
require './mail/PHPMailer.php';
require './mail/SMTP.php';


require_once('./clases/area.php');
require_once('./clases/cita.php');
require_once('./clases/abogada.php');

$area = new Area();
$area->select();
$datos_area = $area->rows;

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

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = RECAPTCHA_KEY; 
    $recaptcha_response = $_POST['recaptcha_response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha); 
    
    if($recaptcha->score >= 0.7){
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
            $mail->From = 'contacto@estudiomrejtman.com.ar';
            $mail->FromName = NOMBRE_ESTUDIO;
            // $mail->addAddress('contacto@estudiomrejtman.com.ar', NOMBRE_ESTUDIO);
            $mail->addAddress('frlawer@gmail.com', NOMBRE_ESTUDIO);
            $mail->isHTML(true);
            $mail->Subject = 'Nueva cita programada.';
            $mail->Body = '<p>El cliente '.$nombre.' solicitó una cita con '.$abogada.'</p><p>En la fecha '.$fecha.'</p><p>La hora '.$hora.'</p><p>El area a tratar es '.$area.'</p><p>Datos del cliente: '.$email.', '.$tel.', '.$tel.'</p>';
            $mail->AltBody = 'Nueva cita de '.$nombre.', '.$email.', '.$tel.', '.$fecha.', '.$hora.', '.$desc;
            
            if(!$mail->send()){echo 'Error: '.$mail->ErrorInfo;}else{

            }
            
            // email a cliente
            $mail2 = new PHPMailer;
            $mail2->From = 'contacto@estudiomrejtman.com.ar';
            $mail2->FromName = NOMBRE_ESTUDIO;
            $mail2->addAddress($email);
            // $mail2->addReplyTo('contacto@estudiomrejtman.com.ar', NOMBRE_ESTUDIO);
            $mail2->addReplyTo('frlawer@gmail.com', NOMBRE_ESTUDIO);
            $mail2->isHTML(true);
            $mail2->Subject = 'Solicitaste una cita con '.NOMBRE_ESTUDIO.'.';
            $mail2->Body = '<h1 style="text-align:center">Cita con '.NOMBRE_ESTUDIO.'.</h1>
            <h2>¡Gracias por solicitar una cita con nuestro Staff!</h2>
            <p>Los pasos a seguir son los siguientes:</p>
                            <p>Recuerda que debes abonar la consulta anticipadamente a través de los siguientes medios de pago.</p>
                            <p>Si usted no solicitó una cita envienos un email a <a href="mailto:contacto@estudiomrejtman.com.ar">contacto@estudiomrejtman.com.ar</a>.</p>
                            <p>© 2020 '.NOMBRE_ESTUDIO.' Todos los derechos reservados</p>';
            
            if(!$mail2->send()){echo 'Error: '.$mail2->ErrorInfo;}else{
                
                echo'<div class="msj-ok"><h2>Gracias por solicitar tu cita con nuestras abogadas. En breve recibirás un email con los datos necesarios para poder concretar tu asesoramiento</a></p></div>';
                
            }
        }
    }else{
        echo '<div class="msj-nok"><h2>El Formulario no fue completado correctamente</h2></div>';
    }
} else {
    // Código para aviso de error 
    echo '<div class="msj-nok"><h2>El Formulario no fue completado correctamente</h2></div>'; 
}