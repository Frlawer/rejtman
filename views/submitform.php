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

if (isset($_POST['action']) && ($_POST['action'] == 'process')) {

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = '6LcPR-IZAAAAACXBHIICa7eTDByjy1thNMK2BxDc'; 
    $recaptcha_response = $_POST['recaptcha_response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha); 
    
    if($recaptcha->score >= 0.7){
    
        if(isset($_POST['submit']) == 'Solicitar cita'){

            if ($_POST['abogada'] == '' && $_POST['hora'] == '') {
        
                echo 'Alguno de los datos no fue correctamente completado';
                
            }else{
                // seteo las post
                $area = $_POST['area'];
                $abogada = $_POST['abogada'];
                $nombre = htmlentities($_POST['nombre'], ENT_QUOTES, "UTF-8");
                $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
                $tel = $_POST['tel'];
                $date = date_create($_POST['fecha']);
                $fecha = date_format($date, 'm-d-Y');
                // $fecha_dato = new DateTime($_POST['fecha']);
                // $fecha = $fecha_dato->format('m-d-Y');
                $hora = $_POST['hora'];
                $desc = htmlentities($_POST['desc'], ENT_QUOTES, "UTF-8");
                
                // instancio nueva cita con los datos y la subo a la db
                $cita = new Cita(null, $area, $abogada, $nombre, $email, $tel, $fecha, $hora, $desc);
                $cita->insert();
                    
                
                // email para abogada
                $mail = new PHPMailer;
                $mail->From = 'contacto@estudiomrejtman.com.ar';
                $mail->FromName = 'Estudio Jurídico Martinez Rejtman & Asoc.';
                // $mail->addAddress('contacto@estudiomrejtman.com.ar', 'Estudio Jurídico Martinez Rejtman & Asoc.');
                $mail->addAddress('frlawer@gmail.com', 'Estudio Jurídico Martinez Rejtman & Asoc.');
                $mail->isHTML(true);
                $mail->Subject = 'Nueva cita programada.';
                $mail->Body = '<p>El cliente '.$nombre.' solicitó una cita con '.$abogada.'</p><p>En la fecha '.$fecha.'</p><p>La hora '.$hora.'</p><p>El area a tratar es '.$area.'</p><p>Datos del cliente: '.$email.', '.$tel.', '.$tel.'</p>';
                $mail->AltBody = 'Nueva cita de '.$nombre.', '.$email.', '.$tel.', '.$fecha.', '.$hora.', '.$desc;
                
                if(!$mail->send()){echo 'Error: '.$mail->ErrorInfo;}
                
                // email a cliente
                $mail2 = new PHPMailer;
                // $mail2->From = 'contacto@estudiomrejtman.com.ar';
                $mail2->From = 'frlawer@gmail.com';
                $mail2->FromName = 'Estudio Martinez Rejtman & Asoc.';
                $mail2->addAddress($email);
                // $mail2->addReplyTo('contacto@estudiomrejtman.com.ar','Estudio Martinez Rejtman & Asoc.');
                $mail2->addReplyTo('frlawer@gmail.com','Estudio Martinez Rejtman & Asoc.');
                $mail2->isHTML(true);
                $mail2->Subject = 'Solicitaste una cita con Martinez Rejtman & Asoc.';
                $mail2->Body = '<h1 style="text-align:center">Cita con Martinez Rejtman & Asoc.</h1>
                <h2>¡Gracias por solicitar una cita con nuestro Staff!</h2>
                <p>Los pasos a seguir son los siguientes:</p>
                <p>Recuerda que debes abonar la consulta anticipadamente a través de los siguientes medios de pago.</p>
                <p>Si usted no solicitó una cita envienos un email a <a href="mailto:contacto@estudiomrejtman.com.ar">contacto@estudiomrejtman.com.ar</a>.</p>
                <p>© 2020 Estudio Jurídico Martinez Rejtman & Asoc. Todos los derechos reservados</p>
                ';
                
                if(!$mail2->send()){
                    
                    echo 'Error: '.$mail2->ErrorInfo;
                        
                }else{
                    
                    echo'<div class="msj-ok"><h2>Gracias por solicitar tu cita con nuestras abogadas. En breve recibirás un email con los datos necesarios para poder concretar tu asesoramiento</a></p></div>';
                    
                }
                
            }
        
        }
    } else {
    
        echo '<div class="msj-nok"><h2>El Formulario no fue completado correctamente</h2></div>';
    
    }

}