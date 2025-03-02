<?php
    $title = "Roles de la empresa"; 
    include '../../Components/Head.php';
    require_once '../../Configs/Config.php';
    require_once '../../Controllers/RolesController.php';

    $rolesController = new RolesController($pdo);
    if (isset($_GET['delete']) && isset($_GET['id'])) {
        $res = $rolesController->delete($_GET['id']);
        if ($res['error']) {
            echo '<div id="alertDelete" class="alert alert-danger mt-3" role="alert">' . $res['message'] . '</div>';
            echo '<script>setTimeout(function(){ $("#alertDelete").hide() }, 4000);</script>';
        } else {
            echo '<div id="alertDelete" class="alert alert-success mt-3" role="alert">Rol eliminado con éxito.</div>';
            echo '<script>setTimeout(function(){ $("#alertDelete").hide() }, 2000);</script>';
        }
    }

    $roles = $rolesController->list();
?>
    <div class="container mt-5">
        <h2>Lista de Roles</h2>
        <a href="Crear.php" class="btn btn-primary mb-3 float-end"><i class="fa-solid fa-user-plus pe-2"></i>Crear</a>
        <table class="table table-striped">
            <tr>
                <th><i class="fa-solid fa-briefcase pe-2"></i>Rol</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?php echo $rol['nombre']; ?></td>
                    <td class="text-center">
                        <button class="btn btn-link" onclick="abrirModalEditar(<?php echo $rol['id']; ?>)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="Index.php?delete&id=<?php echo $rol['id']; ?>" id="eliminar<?php echo $rol['id']; ?>" class="text-danger text-decoration-none" onclick="return confirm('¿Estás seguro de eliminar este rol?');"><i class="fa-solid fa-trash-can"></i></a>
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
                    $("#editarRolModal").modal("show");
                }
            });
        }
    </script>

<?php include '../../Components/BodyHtml.php'; ?>