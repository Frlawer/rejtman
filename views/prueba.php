<?php
// SDK de Mercado Pago
require './vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('TEST-7859083094183615-112618-bc6769d4071f027497af557d99d66374-678313240');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();
$preference->back_urls = array(
    "success" => "http://estudiomartinezrejtman-asoc.com.ar/success",
    "failure" => "http://estudiomartinezrejtman-asoc.com.ar/failure",
    "pending" => "http://estudiomartinezrejtman-asoc.com.ar/pending"
);
$preference->auto_return = "approved";

$preference->payment_methods = array(
    "excluded_payment_types" => array(
      array("id" => "ticket")
    ),
    "installments" => 2
  );

$datos = array();
for($x=0;$x<1;$x++){
    $item = new MercadoPago\Item();
    $item->title = 'Consulta Jurídica';
    $item->quantity = 1;
    $item->unit_price = 1300;
    $item->description = "Cita con abogadas de nuestro Staff.";
    $item->category_id = "service";
    $datos[] = $item;
}

$preference->items = $datos;

$preference->save();

// curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer TEST-5503571218052849-112616-65aa2d57f976a8ee270c33da123e129c-225380343" "https://api.mercadopago.com/users/test_user" -d "{'site_id':'MLA'}"
// Abogadas {"id":678313240,"nickname":"TEST6NYR7XP9","password":"qatest5802","site_status":"active","email":"test_user_55739071@testuser.com"}
// TEST-3ba5264a-4351-46bc-a78c-4f3148158db0
// TEST-7859083094183615-112618-bc6769d4071f027497af557d99d66374-678313240

// Clientes {"id":678312087,"nickname":"TESTMF3EZEVE","password":"qatest948","site_status":"active","email":"test_user_36139729@testuser.com"}

// Tarjetas
// Mastercard	5031 7557 3453 0604	123	11/25
// Visa	4509 9535 6623 3704	123	11/25
// American Express	3711 803032 57522	1234	11/25

// APRO: Pago aprobado.
// CONT: Pago pendiente.
// OTHE: Rechazado por error general.
// CALL: Rechazado con validación para autorizar.
// FUND: Rechazado por monto insuficiente.
// SECU: Rechazado por código de seguridad inválido.
// EXPI: Rechazado por problema con la fecha de expiración.
// FORM: Rechazado por error en formulario

?>


<div class="contactarea wrapper" id="contactarea">
	<div class="container">
		<div class="row">
			<div class="button col-12">
				<a href="<?php echo $preference->init_point; ?>">Pagar con Mercado Pago</a>
			</div>
		</div>
	</div>
</div>