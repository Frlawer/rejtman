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

if(isset($_POST['upcita']) == 'Solicitar cita'){

    
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
        $mail->addAddress('contacto@estudiomrejtman.com.ar', 'Estudio Jurídico Martinez Rejtman & Asoc.');
        $mail->isHTML(true);
        $mail->Subject = 'Nueva cita programada.';
        $mail->Body = '<p>El cliente '.$nombre.' solicitó una cita con '.$abogada.'</p><p>En la fecha '.$fecha.'</p><p>La hora '.$hora.'</p><p>El area a tratar es '.$area.'</p><p>Datos del cliente: '.$email.', '.$tel.', '.$tel.'</p>';
        $mail->AltBody = 'Nueva cita de '.$nombre.', '.$email.', '.$tel.', '.$fecha.', '.$hora.', '.$desc;
        
        if(!$mail->send()){echo 'Error: '.$mail->ErrorInfo;}
        
        // email a cliente
        $mail2 = new PHPMailer;
        $mail2->From = 'contacto@estudiomrejtman.com.ar';
        $mail2->FromName = 'Estudio Martinez Rejtman & Asoc.';
        $mail2->addAddress($email);
        $mail2->addReplyTo('contacto@estudiomrejtman.com.ar','Estudio Martinez Rejtman & Asoc.');
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


}else{
    
    ?>
<!-- contacto -->
<div class="contactarea wrapper" id="contactarea">
        <div class="container">
            <div class="row">
                <div class="col-5 col-12-mobile">
                    <div class="contactInfo">
                        <span>Para Nuestros Clientes Honorabes</span>
                        <h2>Consultoría Online</h2>
                        <h6>Llámenos las 24 horas del día, los 7 días de la semana al 0260-4421819 o complete el formulario.</h6>
                        <p>Es un hecho establecido desde hace mucho tiempo que un lector se distraerá con el contenido legible de una página al mirar su diseño. El punto de usar Lorem Ipsum es que tiene un inglés más o menos capaz.</p>
                    </div>
                </div>
                <div class="col-12-mobile col-7">

                    <span id='wait_1' style='display: none;position: absolute;left: 50%;' class="fa-3x"><i class="fas fa-spinner fa-spin"></i></span>
                    
                    <form class="contactForm" method="post" name="upasistencia" action="" >
                        <div class="row">
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <select class="form-control" name="area" id="drop_1">
                                        <option value="0" selected="selected">Selecciona Area</option>
                                        <?php 
                                        foreach ($datos_area as $key => $value) {
                                            ?>    
                                        <option value="<?php echo $value['area_id'] ?>"><?php echo $value['area_nombre']; ?></option><?php } ?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <select name="abogada" id="abogada" required>
                                        <option value="" disabled selected>Escoge una Abogada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="formInput">
                                    <input placeholder="Tu nombre" name="nombre" class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <input placeholder="Correo electrónico" name="email" class="form-control" type="email" value="">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <input placeholder="Teléfono" name="tel" class="form-control" type="phone" value="">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">	
                                    <input placeholder="Fecha" name="fecha" type="text" id="datepicker">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">	
                                    <select name="hora" id="hora" required>
                                        <option value="" disabled selected>Selecciona horario</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="formInput">
                                    <textarea class="form-control" placeholder="Descripción del caso..." name="desc"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="button" type="submit"vvalue='Solicitar cita'  name='upcita'>Consulta</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }