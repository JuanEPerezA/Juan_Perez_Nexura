<?php
    $title = "Listar Empleados"; 
    include '../../Components/Head.php';
    require_once '../../Configs/Config.php';
    require_once '../../Controllers/EmpleadoController.php';

    $empleadosController = new EmpleadoController($pdo);
    if (isset($_GET['delete']) && isset($_GET['id'])) {
        $empleadosController->delete($_GET['id']);
        echo '<div id="alertDelete" class="alert alert-success mt-3" role="alert">Empleado eliminado con éxito.</div>';
        echo '<script>setTimeout(function(){ $("#alertDelete").hide() }, 2000);</script>';
    }

    $empleados = $empleadosController->index();
?>
    <div class="container mt-5">
        <h2>Lista de Empleados</h2>
        <a href="Crear.php" class="btn btn-primary mb-3 float-end"><i class="fa-solid fa-user-plus pe-2"></i>Crear</a>
        <table class="table table-striped">
            <tr>
                <th><i class="fa-solid fa-user pe-2"></i>Nombre</th>
                <th><i class="fa-solid fa-at pe-2"></i>Email</th>
                <th><i class="fa-solid fa-venus-mars pe-2"></i>Sexo</th>
                <th><i class="fa-solid fa-briefcase pe-2"></i>Área</th>
                <th><i class="fa-solid fa-envelope pe-2"></i>Boletín</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo $empleado['nombre']; ?></td>
                    <td><?php echo $empleado['email']; ?></td>
                    <td><?php echo $empleado['sexo']; ?></td>
                    <td><?php echo $empleado['area']; ?></td>
                    <td><?php echo $empleado['boletin']; ?></td>
                    <td class="text-center">
                        <button class="btn btn-link" onclick="abrirModalEditar(<?php echo $empleado['id']; ?>)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <a href="Index.php?delete&id=<?php echo $empleado['id']; ?>" id="eliminar<?php echo $empleado['id']; ?>" class="text-danger text-decoration-none" onclick="return confirm('¿Estás seguro de eliminar este empleado?');"><i class="fa-solid fa-trash-can"></i></a>
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
                    $("#editarEmpleadoModal").modal("show");
                }
            });
        }
    </script>

<?php include '../../Components/BodyHtml.php'; ?>