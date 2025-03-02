<?php
    $title = 'Editar Rol';
    require_once '../../Configs/Config.php';
    require_once '../../Controllers/RolesController.php';

    $id = $_GET['id'] ?? null;
    $rolesController = new RolesController($pdo);
    $dataRol = $rolesController->read($id);
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            echo json_encode(["success" => false, "message" => "ID del área no recibido."]);
            exit;
        }
    
        $id = intval($_POST['id']);
        $nombre = $_POST['nombre'];
    
        $actualizarRol = $rolesController->update($id, $nombre);
        if ($actualizarRol) {
            echo json_encode(["success" => true, "message" => "Rol actualizado con éxito.", "data" => $actualizarRol]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar el rol.", "data" => '']);
        }
        exit;
    }
?>

    <div id="alertDiv"></div>
    <div class="modal fade" id="editarRolModal" tabindex="-1" aria-labelledby="editarRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarRolLabel">Editar Rol:</h1>
                <button id="cerrarModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form id="editarRolForm" action="Editar.php" method="POST">
                    <div class="row">
                        <div class="col-3 mb-4 text-end">
                            <label class="form-label">Rol</label>
                        </div>
                        <div class="col-9 mb-4">
                            <input type="text" class="form-control" name="id" value="<?= htmlspecialchars($dataRol['id'] ?? '') ?>"  style="display: none;">
                            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($dataRol['nombre'] ?? '') ?>" placeholder="Rol">
                            <div class="text-danger"><?= $errors['nombre'] ?? '' ?></div>
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
            $("#editarRolForm").submit(function(event) {
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
