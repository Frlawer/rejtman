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
                    <span>Para Nuestros Clientes Honorables</span>
                    <h2>Consultoría Online</h2>
                    <h6>Llámenos de Lunes a Viernes de 9 a 19hs al 0260-4421819 o complete el formulario.</h6>
                    <p>Nuestro estudio, prioriza la utilización de las nuevas tecnologías, en beneficio de nuestros clientes. Así, mediante consultas a través de nuestra página web, WhatsApp y vídeollamadas logramos una eficiente y más rápida atención a quienes nos eligen.</p>
                    <a href="/cita" class="button">Solicitar Cita</a>
                </div>
            </div>
            <div class="col-12-mobile col-7">
                
                <form class="contactForm" method="post" name="upasistencia" action="./prueba" id="g-form" >
                    <div class="row">
                        
                        <!-- NOMBRE -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">
                                <label for="nombre">Nombre</label>
                                <input placeholder="Tu nombre" name="nombre" class="form-control" type="text" value="">
                            </div>
                        </div>
                        
                        <!-- APELLIDO -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">
                                <label for="apellido">Apellido:</label>
                                <input placeholder="Apellido" name="apellido" class="form-control" type="text" value="">
                            </div>
                        </div>
                        
                        <!-- EMAIL -->
                        <div class="col-12">
                            <div class="formInput">
                                <label for="email">Email:</label>
                                <input placeholder="Correo electrónico" name="email" class="form-control" type="email" value="">
                            </div>
                        </div>
                        
                        <!-- DNI -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">
                                <label for="dni">DNI:</label>
                                <input placeholder="DNI" name="dni" class="form-control" type="number" value="">
                            </div>
                        </div>
                        
                        <!-- TELEFONO -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">
                                <label for="tel">Teléfono:</label>
                                <input type="tel" name="tel" pattern="[0-9]{10}" class="form-control" >
                            </div>
                        </div>
                        
                        <!-- AREA -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">
                                <label for="area">Area Jurídica:</label>
                                <select class="form-control" name="area" id="drop_1">
                                    <option value="0" selected="selected">Selecciona Area</option>
                                    <?php 
                                    foreach ($datos_area as $key => $value) {
                                        ?>    
                                    <option value="<?php echo $value['area_id'] ?>"><?php echo $value['area_nombre']; ?></option><?php } ?>
                                </select>
                                
                            </div>
                        </div>
                        
                        <!-- SPIN -->
                        <span id='wait_1' style='display: none;position: fixed;left: 50%;' class="fa-3x"><i class="fas fa-spinner fa-spin"></i></span>

                        <!-- ABOGADA -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">
                                <label for="abogada">Abogada</label>
                                <select name="abogada" id="abogada" required class="form-control" >
                                    <option value="" disabled selected>Escoge una Abogada</option>
                                </select>
                            </div>
                        </div>

                        <!-- FECHA -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">	
                                <label for="fecha">Fecha:</label>
                                <input placeholder="Fecha" name="fecha" type="text" id="datepicker" class="form-control" >
                            </div>
                        </div>

                        <!-- HORA -->
                        <div class="col-6 col-12-mobile">
                            <div class="formInput">	
                                <label for="hora">Hora:</label>
                                <select name="hora" id="hora" required class="form-control" >
                                    <option value="" disabled selected>Selecciona horario</option>
                                </select>
                            </div>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <div class="col-12">
                            <div class="formInput">
                                <label for="desc">Descripción:</label>
                                <textarea class="form-control" placeholder="Descripción del caso..." name="desc"></textarea>
                            </div>
                        
                        </div>
                        <!-- RECAPCHA -->
                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        
                        <!-- BOTON -->
                        <div class="col-12">
                            <button class="button" name="upcita" value="Solicitar cita" >Consulta</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>