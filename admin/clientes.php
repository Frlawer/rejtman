<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Clientes/Clientes.php';
$costumers = new Clientes();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'cliente_id';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('cliente_id', 'cliente_nombre', 'cliente_apellido', 'cliente_email', 'cliente_dni', 'cliente_tel', 'cliente_dir', 'cliente_desc');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('cliente_nombre', '%' . $search_string . '%', 'like');
	$db->orwhere('cliente_email', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('cliente', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Clientes</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_cliente.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nuevo</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Buscar</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo htmlspecialchars($search_string, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Ordenar por</label>
            <select name="filter_col" class="form-control">
                <?php
foreach ($costumers->setOrderingValues() as $opt_value => $opt_name):
	($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_by == 'Asc') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_by == 'Desc') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="3%">ID</th>
                <th width="15%">Nombre</th>
                <th width="15%">Apellido</th>
                <th width="12%">Email</th>
                <th width="5%">DNI</th>
                <th width="10%">Telefono</th>
                <th width="20%">Dirección</th>
                <th width="20%">Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['cliente_id']; ?></td>
                <td><?php echo htmlspecialchars($row['cliente_nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['cliente_apellido']); ?></td>
                <td><?php echo htmlspecialchars($row['cliente_email']); ?></td>
                <td><?php echo htmlspecialchars($row['cliente_dni']); ?></td>
                <td><?php echo htmlspecialchars($row['cliente_tel']); ?></td>
                <td><?php echo htmlspecialchars($row['cliente_dir']); ?></td>
                <td><?php echo htmlspecialchars_decode($row['cliente_desc']); ?></td>
                <td>
                    <a href="edit_cliente.php?cliente_id=<?php echo $row['cliente_id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['cliente_id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['cliente_id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_cliente.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirmar</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['cliente_id']; ?>">
                                <p>Estás segura de eliminar este cliente?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Si</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <?php endforeach;?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'clientes.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
