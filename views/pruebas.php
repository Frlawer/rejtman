			<!-- Main -->
            <div class="wrapper style1">

<div class="container">
    <article id="main" class="special">
        <?php
        require_once('./clases/area.php');
        require_once('./clases/cita.php');
        require_once('./clases/abogada.php');
        require_once('./clases/hora.php');
        require_once('./clases/cliente.php');
        require_once('./clases/cuenta.php');
    
        $data_cuenta = new Cuenta();
        $data_cuenta->selectAbogadaId(1);
        $datos_cuenta = $data_cuenta->rows;
        
        
        var_dump($datos_cuenta);

        foreach ($datos_cuenta as $key => $value) {
            echo '<h3>'.$value['cuenta_nombre'].'<h3>';
        }
        
        ?>
    </article>
    <hr />
</div>

</div>
