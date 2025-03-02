<?php
include '../../Components/Head.php';
require_once '../../Configs/Config.php';
require_once '../../Controllers/AreasController.php';
require_once '../../Controllers/RolesController.php';
require_once '../../Controllers/EmpleadoController.php';

$areasController = new AreasController($pdo);
$rolesController = new RolesController($pdo);
$empleadoController = new EmpleadoController($pdo);
$areas = $areasController->list();
$roles = $rolesController->list();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $sexo = $_POST['sexo'] ?? '';
    $area = $_POST['area'] ?? '';
    $descripcion = trim($_POST['descripcion']);
    $boletin = isset($_POST['boletin']) ? 1 : 0;
    $rolesSeleccionados = $_POST['roles'] ?? [];

    if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,254}$/u", $nombre)) {
        $errors['nombre'] = "El nombre solo puede contener letras con o sin tilde y espacios.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "El formato del correo electrónico no es válido.";
    }
    if ($sexo !== 'M' && $sexo !== 'F') {
        $errors['sexo'] = "Debe seleccionar un género.";
    }
    if (!filter_var($area, FILTER_VALIDATE_INT)) {
        $errors['area'] = "Debe seleccionar un área válida.";
    }
    if (strlen($descripcion) < 4) {
        $errors['descripcion'] = "La descripción debe tener al menos 4 caracteres.";
    }
    if (empty($rolesSeleccionados)) {
        $errors['roles'] = "Debe seleccionar al menos un rol.";
    }

    if (empty($errors)) {
        $registrarObra = $empleadoController->create($nombre, $email, $sexo, $area, $boletin, $descripcion, $rolesSeleccionados);
        if ($registrarObra) {
            echo '<div class="alert alert-success" role="alert">Registro creado con éxito.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error al crear el registro. Intenta de nuevo.</div>';
        }
    }
}
?>

<div class="container mt-5">
    <form id="empleadoForm" action="Crear.php" method="POST">
        <div class="row">
            <div class="col-11 offset-1">
                <h1>Crear Empleado</h1>
            </div>
            <div class="col-11 offset-1">
                <div class="alert alert-info">Los campos con asteriscos (*) son obligatorios</div>
            </div>

            <div class="col-3 mb-4 text-end">
                <label class="form-label">Nombre completo *</label>
            </div>
            <div class="col-9 mb-4">
                <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Nombre completo del empleado">
                <div class="text-danger"><?= $errors['nombre'] ?? '' ?></div>
            </div>

            <div class="col-3 mb-4 text-end">
                <label class="form-label">Correo electrónico *</label>
            </div>
            <div class="col-9 mb-4">
                <input type="text" class="form-control" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Correo electrónico">
                <div class="text-danger"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div class="col-3 mb-4 text-end">
                <label class="form-label">Sexo *</label>
            </div>
            <div class="col-9 mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="M" name="sexo" id="sexoM" <?= (isset($_POST['sexo']) && $_POST['sexo'] == 'M') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="sexoM">Masculino</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="F" name="sexo" id="sexoF" <?= (isset($_POST['sexo']) && $_POST['sexo'] == 'F') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="sexoF">Femenino</label>
                </div>
                <div class="text-danger"><?= $errors['sexo'] ?? '' ?></div>
            </div>

            <div class="col-3 mb-4 text-end">
                <label class="form-label">Área *</label>
            </div>
            <div class="col-9 mb-4">
                <select class="form-select" name="area">
                    <option value="" disabled <?= empty($_POST['area']) ? 'selected' : '' ?>>Seleccionar área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= $area['id']; ?>" <?= (isset($_POST['area']) && $_POST['area'] == $area['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($area['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-danger"><?= $errors['area'] ?? '' ?></div>
            </div>

            <div class="col-3 mb-4 text-end">
                <label class="form-label">Descripción *</label>
            </div>
            <div class="col-9 mb-4">
                <textarea class="form-control" name="descripcion"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
                <div class="text-danger"><?= $errors['descripcion'] ?? '' ?></div>
            </div>

            <div class="col-3 mb-4 text-end">
                <label class="form-label">Roles *</label>
            </div>
            <div class="col-9 mb-4">
                <?php foreach ($roles as $rol): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $rol['id']; ?>" name="roles[]" <?= (isset($_POST['roles']) && in_array($rol['id'], $_POST['roles'])) ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= htmlspecialchars($rol['nombre']); ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="text-danger"><?= $errors['roles'] ?? '' ?></div>
            </div>

            <div class="col-9 offset-3 mb-4">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $("#empleadoForm").validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 254,
                lettersonly: true
            },
            email: {
                required: true,
                email: true
            },
            sexo: {
                required: true
            },
            area: {
                required: true
            },
            descripcion: {
                required: true,
                minlength: 10
            },
            "roles[]": {
                required: true
            }
        },
        messages: {
            nombre: {
                required: "El nombre es obligatorio",
                minlength: "Debe tener al menos 3 caracteres",
                maxlength: "No puede superar los 254 caracteres"
            },
            email: {
                required: "El correo es obligatorio",
                email: "El formato del correo electrónico no es válido"
            },
            sexo: {
                required: "Debe seleccionar un género"
            },
            area: {
                required: "Debe seleccionar un área"
            },
            descripcion: {
                required: "Debe proporcionar una descripción",
                minlength: "Debe tener al menos 4 caracteres"
            },
            "roles[]": {
                required: "Debe seleccionar al menos un rol"
            }
        },
        errorElement: "div",
        errorClass: "text-danger",
        errorPlacement: function(error, element) {
            if (element.attr("name") == "sexo") {
                error.insertBefore(element.closest('.form-check'));
            } else if (element.attr("name") == "roles[]") {
                error.insertBefore(element.closest('.form-check'));
            } else {
                error.insertAfter(element);
            }
        }
    });
});
</script>

<?php include '../../Components/BodyHtml.php'; ?>
