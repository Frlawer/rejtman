<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Citas/Citas.php';
$costumers = new Citas();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET,  'order_by');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'cita_id';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
// joins inner
$db->join('area a','c.area_id = a.area_id','INNER');
$db->join('abogada b','c.abogada_id = b.abogada_id','INNER');
$db->join('horario h','c.horario_id = h.horario_id','INNER');

// SELECT *
// FROM cita c INNER JOIN area a
// ON c.area_id = a.area_id INNER JOIN abogada b
// ON c.abogada_id = b.abogada_id INNER JOIN horario h
// ON c.horario_id = h.horario_id

$select = array('c.cita_id', 'a.area_nombre', 'b.abogada_nombre', 'c.cita_nombre', 'c.cita_email', 'c.cita_tel', 'c.cita_fecha', 'h.horario_hora', 'c.cita_desc');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('cita_nombre', '%' . $search_string . '%', 'like');
	$db->orwhere('cita_email', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('cita c', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Citas</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_cita.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nueva</a>
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
                <th width="2%">ID</th>
                <th width="15%">Area</th>
                <th width="15%">Abogada</th>
                <th width="15%">Nombre</th>
                <th width="15%">Email</th>
                <th width="10%">Teléfono</th>
                <th width="7%">Fecha</th>
                <th width="5%">Hora</th>
                <th width="16%">Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['cita_id']; ?></td>
                <td><?php echo htmlspecialchars($row['area_nombre']); ?></td>
                <td><?php echo htmlspecialchars_decode($row['abogada_nombre']); ?></td>
                <td><?php echo htmlspecialchars_decode($row['cita_nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['cita_email']); ?></td>
                <td><?php echo htmlspecialchars($row['cita_tel']); ?></td>
                <td><?php echo date_format(new DateTime($row['cita_fecha']), 'd-m-Y'); ?></td>
                <td><?php echo htmlspecialchars($row['horario_hora']); ?></td>
                <td><?php echo htmlspecialchars_decode($row['cita_desc']); ?></td>
                <td>
                    <a href="edit_cita.php?cita_id=<?php echo $row['cita_id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['cita_id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['cita_id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_cita.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirmar</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['cita_id']; ?>">
                                <p>Estás segúra de eliminar esta Cita?</p>
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
    <?php echo paginationLinks($page, $total_pages, 'citas.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
