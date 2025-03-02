<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?php echo isset($title) ? htmlspecialchars($title) : 'Juan Pérez Nexura'; ?></title>
        <link rel="icon" href="<?php echo $title == 'Dashboard' ? '../Assets/Images/Icon.png' : '../../Assets/Images/Icon.png' ?>" />
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo $title == 'Dashboard' ? '..' : '../../' ?>">Inicio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Empleados
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="<?php echo $title == 'Dashboard' ? './Empleados/Crear.php' : '../Empleados/Crear.php' ?>">Crear Empleados</a></li>
                            <li><a class="nav-link" href="<?php echo $title == 'Dashboard' ? './Empleados/index.php' : '../Empleados/index.php' ?>">Listar Empleados</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Áreas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="<?php echo $title == 'Dashboard' ? './Areas/Crear.php' : '../Areas/Crear.php' ?>">Crear Áreas</a></li>
                            <li><a class="nav-link" href="<?php echo $title == 'Dashboard' ? './Areas/index.php' : '../Areas/index.php' ?>">Listar Áreas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Roles
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="<?php echo $title == 'Dashboard' ? './Roles/Crear.php' : '../Roles/Crear.php' ?>">Crear Roles</a></li>
                            <li><a class="nav-link" href="<?php echo $title == 'Dashboard' ? './Roles/index.php' : '../Roles/index.php' ?>">Listar Roles</a></li>
                        </ul>
                    </li>
                </div>
                </div>
            </div>
        </nav>

        <div class="container">
