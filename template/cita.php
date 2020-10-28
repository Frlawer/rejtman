<?php 
require('./clases/area.php');
$area = new Area();
$area->select();
$datos_area = $area->rows;


	
require_once('./clases/abogada.php');

$post = (isset($_POST['area']) && !empty($_POST['area'])) &&
        (isset($_POST['abogada']) && !empty($_POST['abogada'])) &&
        (isset($_POST['email']) && !empty($_POST['email'])) &&
        (isset($_POST['name']) && !empty($_POST['name'])) &&
        (isset($_POST['fecha']) && !empty($_POST['fecha'])) &&
        (isset($_POST['hora']) && !empty($_POST['hora'])) &&
        (isset($_POST['description']) && !empty($_POST['description'])) &&
        (isset($_POST['phone']) && !empty($_POST['phone']));
        
if ( $post ) {
    $area = htmlspecialchars($_POST["area"]);
    $abogada = htmlspecialchars($_POST["abogada"]);
    $email = htmlspecialchars($_POST["email"]);
    $name = htmlspecialchars($_POST["name"]);
    $fecha = htmlspecialchars($_POST["fecha"]);
    $hora = htmlspecialchars($_POST["hora"]);
    $description = htmlspecialchars($_POST["description"]);
    $phone = htmlspecialchars($_POST["phone"]);

    $cita = new Abogada
}else {
    header("Location: ./");
}
    $lugar = new Lugar(
        NULL,
        $persona,
        $nombre,
        $cat,
        $dir,
        $tel,
        $web,
        $fb,
        $tw,
        $email,
        $ruta,
        $coord,
        $url,
        $text,
        0,
        1,
        $fecha
        );
    
    $lugar->insert();

// email a mi
    require './mail/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $mail->From = 'hola@miguiacatamarca.com';
    $mail->FromName = 'Mi Guia Catamarca';
    $mail->addAddress('hola@miguiacatamarca.com', 'Mi Guia Catamarca');
    $mail->addReplyTo('hola@miguiacatamarca.com', 'Mi Guia Catamarca');
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo local agregado a Mi guia catamarca';
    $mail->Body = '<h1>Ha sido agregado un nuevo local</h1><p>'.$nombre.'</p><p>'.$email.'</p><p>'.$persona.'</p><p><a href="http://miguiacatamarca.com/lugar/'.$url.'">Url</a></p><p><img src="http://miguiacatamarca.com/images/u/'.$ruta.'.jpg" width="400px"></p>';
    $mail->AltBody = 'Ha sido agregado un nuevo local '.$nombre.' '.$email.' '.$persona.' ';

    if(!$mail->send()){echo 'Error: '.$mail->ErrorInfo;}

// email a cliente
    $mail2 = new PHPMailer;
    $mail2->From = 'hola@miguiacatamarca.com';
    $mail2->FromName = 'Mi Guia Catamarca';
    $mail2->addAddress($email, $persona);
    $mail2->addReplyTo('hola@miguiacatamarca.com', 'Mi Guia Catamarca');
    $mail2->isHTML(true);
    $mail2->Subject = 'Has agregado tu comercio a Mi Guia Catamarca';
    $mail2->Body = '<h1 style="text-align:center"><a href="http://miguiacatamarca.com"><img src="http://miguiacatamarca.com/images/logo.png" alt="Mi Guía Catamarca"></a></h1>
        <h2>Gracias por agregar tu comercio a Mi Gu&iacute;a Catamarca!</h2>
        <p>Ya puedes invitar a tus amigos a visitarlo compartiendo este <a href="http://miguiacatamarca.com/lugar/'.$url.'">enlace</a>:</p>
        <p>Recuerda que si deseas agregar una imagen solo debes etiquetar a @miguiacatamarca en Facebook o Twitter con la foto y te la cargamos.</p>
        <p>Si crees que cometiste un error al cargar tus datos no dudes en escribirnos un mensaje a <a href="mailto:editar@miguiacatamarca.com">editar@MiGuiaCatamarca.com</a></p>
        <p>Este es un mensaje automático. Si deseas contactarnos utiliza nuestro formulario de<a href="http://www.miguiacatamarca.com/contacto"> Contacto</a></p>
        <p>Si usted no solicitó agregar su comercio a Mi Gu&iacute;a Catamarca, envienos un email a <a href="mailto:reclamos@miguiacatamarca.com">reclamos@miguiacatamarca.com</a>.</p><br>
        <p>© 2014 Mi Gu&iacute;a Catamarca. Todos los derechos reservados</p>
    ';
    $mail2->AltBody = 'Gracias por agregar tu comercio a Mi Gu&iacute;a Catamarca! Ya puedes invitar a tus amigos a visitarlo compartiendo este enlace. Recuerda que si deseas agregar una imagen solo debes etiquetar a @miguiacatamarca en Facebook o Twitter con la foto y te la cargamos. Si crees que cometiste un error al cargar tus datos no dudes en escribirnos un mensaje a editar@miguiacatamarca.com. Este es un mensaje automático. Si deseas contactarnos utiliza nuestro formulario: http://miguiacatamarca.com/contacto. Si usted no solicitó agregar su comercio a Mi Gu&iacute;a Catamarca, envienos un email a reclamos@miguiacatamarca.com. © 2014 Mi Gu&iacute;a Catamarca. Todos los derechos reservados';

    if(!$mail2->send()){

        echo 'Error: '.$mail2->ErrorInfo;
        
    }else{

        echo'<h2>Gracias por agregar tu lugar.!</h2><h3>Tus datos fueron cargados correctamente</h3><p>Recibiras un email con los datos del mismo para que puedas compartirlo.!</p><p>Un administrador revisará los mismos para dar de alta tu lugar</p><p>También puedes revisar nuestras propuestas publicitarias <a href="/publicidad">AQUÍ</a></p>';

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
                    <form class="contactForm" method="post" name="upasistencia" action="" >
                        <div class="row">
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <select class="form-control" name="area" id="drop_1">
                                        <option value="0" selected="selected">Selecciona Area</option>
                                        <?php 
                                        foreach ($datos_area as $key => $value) {
                                        ?>    
                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['valor']; ?></option><?php } ?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <select id='result_1'><option value="">Selecciona Abogada</option></select>
                                    <span id='wait_1' style='display: none;position: absolute;left: 50%;' class="fa-3x">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>

                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="formInput">
                                    <input placeholder="Tu nombre" name="name" class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <input placeholder="Correo electrónico" name="email" class="form-control" type="email" value="">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">
                                    <input placeholder="Teléfono" name="phone" class="form-control" type="phone" value="">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">	
                                    <input placeholder="Fecha" name="fecha" type="text" id="datepicker">
                                </div>
                            </div>
                            <div class="col-6 col-12-mobile">
                                <div class="formInput">	
                                <input type="time" name="hora" value="09:00:00" min="09:00:00" max="12:00:00" step="60">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="formInput">
                                    <textarea class="form-control" placeholder="Descripción del caso..." name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit">Consulta</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>