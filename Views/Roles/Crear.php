<?php
    $title = "Crear Empleado"; 
    include '../../Components/Head.php';
    require_once '../../Configs/Config.php';
    require_once '../../Controllers/RolesController.php';

    $rolesController = new RolesController($pdo);

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $crearArea = $rolesController->create($nombre);
        if ($crearArea) {
            echo '<div class="alert alert-success mt-3" role="alert">Registro creado con éxito.</div>';
            echo '<script>
                setTimeout(function() {
                    window.location.href = "./";
                }, 2500);
            </script>';
        } else {
            echo '<div class="alert alert-danger mt-3" role="alert">Error al crear el registro. Intenta de nuevo.</div>';
        }
    }
    ?>

    <div class="container mt-5">
        <form id="empleadoForm" action="Crear.php" method="POST">
            <div class="row">
                <div class="col-11 offset-1">
                    <h1>Crear Rol</h1>
                </div>
                <div class="col-11 offset-1">
                    <div class="alert alert-info">Los campos con asteriscos (*) son obligatorios</div>
                </div>

                <div class="col-3 mb-4 text-end">
                    <label class="form-label">Rol *</label>
                </div>
                <div class="col-9 mb-4">
                    <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Rol">
                    <div class="text-danger"><?= $errors['nombre'] ?? '' ?></div>
                </div>

                <div class="col-9 offset-3 mb-4">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]{3,254}$/u.test(value);
            }, "El nombre solo puede contener letras con o sin tilde y espacios.");

            $("#empleadoForm").validate({
                rules: {
                    area: {
                        required: true,
                        lettersonly: true
                    },
                },
                messages: {
                    area: {
                        required: "El nombre es obligatorio"
                    },
                },
                errorElement: "div",
                errorClass: "text-danger",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                onkeyup: function(element) { $(element).valid(); },
                onfocusout: function(element) { $(element).valid(); },
                onclick: function(element) { $(element).valid(); }
            });
        });
    </script>

<?php include '../../Components/BodyHtml.php'; ?>
