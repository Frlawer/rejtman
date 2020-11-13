<?php 

require_once('./clases/area.php');
require_once('./clases/cita.php');
require_once('./clases/abogada.php');

$area = new Area();
$area->select();
$datos_area = $area->rows;
?>
<!-- contacto -->
<div class="contactarea wrapper" id="contactarea">
        <div class="container">
            <div class="row">
                <div class="col-5 col-12-mobile">
                    <div class="contactInfo">
                        <span>Para Nuestros Clientes Honorabes</span>
                        <h2>Consultoría Online</h2>
                        <h6>Llámenos de Lunes a Viernes de 9 a 19hs al 0260-4421819 o complete el formulario.</h6>
                        <p>Nuestro estudio, prioriza la utilización de las nuevas tecnologías, en beneficio de nuestros clientes. Así, mediante consultas a través de nuestra página web, WhatsApp y vídeollamadas logramos una eficiente y más rápida atención a quienes nos elijen.</p>
                        <a href="/cita" class="button">Solicitar Cita</a>
                    </div>
                </div>
                <div class="col-12-mobile col-7">

                    <span id='wait_1' style='display: none;position: absolute;left: 50%;' class="fa-3x"><i class="fas fa-spinner fa-spin"></i></span>
                    
                    <form class="contactForm" method="post" name="upasistencia" action="/submitform" id="g-form" >
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
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            <div class="col-12">
                                <button class="button" name="upcita" value="Solicitar cita" >Consulta</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>