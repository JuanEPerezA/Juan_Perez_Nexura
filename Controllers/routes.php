<?php
    require_once 'EmpleadoController.php';
    $controller = new EmpleadoController($pdo);

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     if (isset($_POST['create'])) {
    //         $controller->create($_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['celular']);
    //         header('Location: ../Views/index.php');
    //         exit();
    //     } elseif (isset($_POST['update'])) {
    //         $controller->update($_POST['id'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['celular']);
    //         header('Location: ../Views/index.php');
    //         exit();
    //     }
    // } elseif (isset($_GET['delete'])) {
    //     $controller->delete($_GET['id']);
    //     header('Location: ../Views/index.php');
    //     exit();
    // }
?>
