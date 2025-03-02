<?php
    $title = 'Editar Empleado';
    require_once '../../Configs/Config.php';
    require_once '../../Controllers/EmpleadoController.php';
    require_once '../../Controllers/AreasController.php';
    require_once '../../Controllers/RolesController.php';

    $id = $_GET['id'] ?? null;
    $areasController = new AreasController($pdo);
    $rolesController = new RolesController($pdo);
    $areas = $areasController->list();
    $roles = $rolesController->list();
    
    $empleadoController = new EmpleadoController($pdo);
    $dataEmpleado = $empleadoController->read($id);
    $rolesEmpleado = $rolesController->readRolesByUser($id);
    $rolesEmpleadoIds = array_column($rolesEmpleado, 'rol_id');
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            echo json_encode(["success" => false, "message" => "ID del empleado no recibido."]);
            exit;
        }
    
        $id = intval($_POST['id']);
        $dataEmpleado = $empleadoController->read($id);
    
        $nombre = trim($_POST['nombre']) ?: $dataEmpleado['nombre'];
        $email = trim($_POST['email']) ?: $dataEmpleado['email'];
        $sexo = $_POST['sexo'] ?? $dataEmpleado['sexo'];
        $area = intval($_POST['area']) ?: $dataEmpleado['area_id'];
        $descripcion = trim($_POST['descripcion']) ?: $dataEmpleado['descripcion'];
        $boletin = isset($_POST['boletin']) ? 1 : 0;
        $rolesSeleccionados = $_POST['roles'] ?? [];
    
        $actualizarEmpleado = $empleadoController->update($id, $nombre, $email, $sexo, $area, $boletin, $descripcion, $rolesSeleccionados);
        if ($actualizarEmpleado) {
            echo json_encode(["success" => true, "message" => "Empleado actualizado con éxito.", "data" => $actualizarEmpleado]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el empleado.", "data" => '']);
        }
        exit;
    }
?>

    <div id="alertDiv"></div>
    <div class="modal fade" id="editarEmpleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarEmpleadoLabel">Editar Empleado:</h1>
                <button id="cerrarModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form id="editarEmpleadoForm" action="Editar.php" method="POST">
                    <div class="row">
                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Nombre completo</label>
                        </div>
                        <div class="col-9 mb-4">
                            <input type="text" class="form-control" name="id" value="<?= htmlspecialchars($dataEmpleado['id'] ?? '') ?>"  style="display: none;">
                            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($dataEmpleado['nombre'] ?? '') ?>" placeholder="Nombre completo del empleado">
                            <div class="text-danger"><?= $errors['nombre'] ?? '' ?></div>
                        </div>

                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Correo electrónico</label>
                        </div>
                        <div class="col-9 mb-4">
                            <input type="text" class="form-control" name="email" value="<?= htmlspecialchars($dataEmpleado['email'] ?? '') ?>" placeholder="Correo electrónico">
                            <div class="text-danger"><?= $errors['email'] ?? '' ?></div>
                        </div>

                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Sexo</label>
                        </div>
                        <div class="col-9 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="M" name="sexo" id="sexoM" <?= (isset($dataEmpleado['sexo']) && $dataEmpleado['sexo'] == 'M') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sexoM">Masculino</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="F" name="sexo" id="sexoF" <?= (isset($dataEmpleado['sexo']) && $dataEmpleado['sexo'] == 'F') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sexoF">Femenino</label>
                            </div>
                            <div class="text-danger"><?= $errors['sexo'] ?? '' ?></div>
                        </div>

                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Área</label>
                        </div>
                        <div class="col-9 mb-4">
                            <select class="form-select" name="area">
                                <option value="" disabled>Seleccionar área</option>
                                <?php foreach ($areas as $area): ?>
                                    <option value="<?= $area['id']; ?>" <?= (isset($dataEmpleado['area_id']) && $dataEmpleado['area_id'] == $area['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($area['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="text-danger"><?= $errors['area'] ?? '' ?></div>
                        </div>

                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Descripción</label>
                        </div>
                        <div class="col-9 mb-4">
                            <textarea class="form-control" name="descripcion"><?= htmlspecialchars($dataEmpleado['descripcion'] ?? '') ?></textarea>
                            <div class="text-danger"><?= $errors['descripcion'] ?? '' ?></div>
                        </div>

                        <div class="col-9 offset-3 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="boletin" value="1" <?= (isset($dataEmpleado['boletin']) && $dataEmpleado['boletin'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Deseo recibir boletín informativo</label>
                            </div>
                        </div>

                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Roles</label>
                        </div>
                        <div class="col-9 mb-4">
                            <?php foreach ($roles as $rol): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $rol['id']; ?>" name="roles[]" 
                                        <?= in_array($rol['id'], $rolesEmpleadoIds) ? 'checked' : '' ?>>
                                    <label class="form-check-label"><?= htmlspecialchars($rol['nombre']); ?></label>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-danger"><?= $errors['roles'] ?? '' ?></div>
                        </div>

                        <div class="col-9 offset-3 mb-4">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#editarEmpleadoForm").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "editar.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $("#cerrarModal").click();
                            $("#alertDiv").html('<div class="alert alert-success mt-3">' + response.message + '</div>');
                            setTimeout(function() {
                                window.location.href = "./";
                            }, 1000);
                        } else {
                            $("#alertDiv").html('<div class="alert alert-danger mt-3">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la petición AJAX: ", error);
                        $("#alertDiv").html('<div class="alert alert-danger mt-3">Ocurrió un error al actualizar.</div>');
                    }
                });
            });
        });
    </script>
