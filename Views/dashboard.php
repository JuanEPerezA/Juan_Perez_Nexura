<?php
    $title = "Dashboard"; 
    include'../Components/Head.php';
    require_once'../Configs/Config.php';
    require_once'../Controllers/EmpleadoController.php';
    require_once'../Controllers/AreasController.php';
    require_once'../Controllers/RolesController.php';

    $empleadosController = new EmpleadoController($pdo);
    $empleados = $empleadosController->index(10);

    $areasController = new AreasController($pdo);
    $areas = $areasController->list(10);

    $rolesController = new RolesController($pdo);
    $roles = $rolesController->list(10);
?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <a href="Empleados/Index.php" style="text-decoration: none; font-size: xx-large;">Lista de Empleados</a>
                <table class="table table-striped">
                    <tr>
                        <th><i class="fa-solid fa-user pe-2"></i>Nombre</th>
                        <th><i class="fa-solid fa-at pe-2"></i>Email</th>
                        <th><i class="fa-solid fa-venus-mars pe-2"></i>Sexo</th>
                        <th><i class="fa-solid fa-briefcase pe-2"></i>Área</th>
                    </tr>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?php echo $empleado['nombre']; ?></td>
                            <td><?php echo $empleado['email']; ?></td>
                            <td><?php echo $empleado['sexo']; ?></td>
                            <td><?php echo $empleado['area']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-3">
                <a href="Areas/Index.php" style="text-decoration: none; font-size: xx-large;">Áreas de la empresa</a>
                <table class="table table-striped">
                    <tr>
                        <th><i class="fa-solid fa-briefcase pe-2"></i>Área</th>
                    </tr>
                    <?php foreach ($areas as $area): ?>
                        <tr>
                            <td><?php echo $area['nombre']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-3">
                <a href="Roles/Index.php" style="text-decoration: none; font-size: xx-large;">Roles de la empresa</a>
                <table class="table table-striped">
                    <tr>
                        <th><i class="fa-solid fa-briefcase pe-2"></i>Rol</th>
                    </tr>
                    <?php foreach ($roles as $rol): ?>
                        <tr>
                            <td><?php echo $rol['nombre']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

<?php include '../Components/BodyHtml.php'; ?>