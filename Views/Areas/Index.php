<?php
    $title = "Áras de la empresa"; 
    include '../../Components/Head.php';
    require_once '../../Configs/Config.php';
    require_once '../../Controllers/AreasController.php';

    $areasController = new AreasController($pdo);
    if (isset($_GET['delete']) && isset($_GET['id'])) {
        $res = $areasController->delete($_GET['id']);
        if ($res['error']) {
            echo '<div id="alertDelete" class="alert alert-danger mt-3" role="alert">' . $res['message'] . '</div>';
            echo '<script>setTimeout(function(){ $("#alertDelete").hide() }, 4000);</script>';
        } else {
            echo '<div id="alertDelete" class="alert alert-success mt-3" role="alert">Área eliminado con éxito.</div>';
            echo '<script>setTimeout(function(){ $("#alertDelete").hide() }, 2000);</script>';
        }
    }

    $areas = $areasController->list();
?>
    <div class="container mt-5">
        <h2>Lista de Áreas</h2>
        <a href="Crear.php" class="btn btn-primary mb-3 float-end"><i class="fa-solid fa-user-plus pe-2"></i>Crear</a>
        <table class="table table-striped">
            <tr>
                <th><i class="fa-solid fa-briefcase pe-2"></i>Área</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($areas as $area): ?>
                <tr>
                    <td><?php echo $area['nombre']; ?></td>
                    <td class="text-center">
                        <button class="btn btn-link" onclick="abrirModalEditar(<?php echo $area['id']; ?>)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="Index.php?delete&id=<?php echo $area['id']; ?>" id="eliminar<?php echo $area['id']; ?>" class="text-danger text-decoration-none" onclick="return confirm('¿Estás seguro de eliminar esta área?');"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div id="editarModalDiv"></div>

    <script>
        function abrirModalEditar(id) {
            $.ajax({
                url: 'Editar.php?id=' + id,
                success: function (data) {
                    $("#editarModalDiv").html(data);
                    $("#editarAreaModal").modal("show");
                }
            });
        }
    </script>

<?php include '../../Components/BodyHtml.php'; ?>