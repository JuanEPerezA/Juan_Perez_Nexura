<?php
    require_once $title == 'Dashboard' ? '../Configs/Config.php' : '../../Configs/Config.php';

    class EmpleadoController {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function index($limite=null) {
            // $stmt = $this->pdo->query("SELECT e.id, e.nombre, e.email, CASE WHEN e.sexo = 'M' THEN 'Masculino' WHEN e.sexo = 'F' THEN 'Femenino' END AS sexo, a.nombre area, CASE WHEN e.boletin = 0 THEN 'No' WHEN e.boletin = 1 THEN 'Si' END AS boletin, e.descripcion, r.nombre rol FROM empleados e INNER JOIN areas a ON e.area_id = a.id INNER JOIN empleados_rol er ON e.id = er.empleado_id INNER JOIN roles r ON er.rol_id = r.id ORDER BY id DESC"); // Mostrar roles (Se quitó este query, ya que en el PDF de la prueba tecnica no se mostraba, quería mostrarlo como un "plus", pero no sabría si quisieran que se mostrarar todos los roles de un usuario en la misma fila de la tabla separado por comas, o si por ejemplo el empleado tiene 2 roles, se mostrar 2 veces en la tabla, entonces por ende se quitó para dejar el listado igual que el de la imagen del PDF).
            $limites = $limite ? "LIMIT $limite" : "";
            $stmt = $this->pdo->query("SELECT e.id, e.nombre, e.email, CASE WHEN e.sexo = 'M' THEN 'Masculino' WHEN e.sexo = 'F' THEN 'Femenino' END AS sexo, a.nombre area, CASE WHEN e.boletin = 0 THEN 'No' WHEN e.boletin = 1 THEN 'Si' END AS boletin, e.descripcion FROM empleados e INNER JOIN areas a ON e.area_id = a.id  ORDER BY id DESC $limites");
            return $stmt->fetchAll();
        }

        public function create($nombre, $email, $sexo, $area, $boletin, $descripcion, $roles) {
            $errors = [];
            
            if (empty($nombre) || !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,254}$/u", $nombre)) {
                $errors[] = "El nombre debe contener solo letras y espacios.";
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El correo electrónico no es válido.";
            }

            if ($sexo !== 'M' && $sexo !== 'F') {
                $errors[] = "Debe seleccionar un sexo válido.";
            }

            if (!filter_var($area, FILTER_VALIDATE_INT)) {
                $errors[] = "Debe seleccionar un área válida.";
            }

            if (strlen($descripcion) < 4) {
                $errors[] = "La descripción debe tener al menos 4 caracteres.";
            }

            if (empty($roles)) {
                $errors[] = "Debe seleccionar al menos un rol.";
            }
            
            if (!empty($errors)) {
                return $errors;
            }

            $sql = "INSERT INTO empleados (nombre, email, sexo, area_id, boletin, descripcion) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $email, $sexo, $area, $boletin, $descripcion]);
            $empleadoId = $this->pdo->lastInsertId();
            foreach ($roles as $rol) {
                $sql = "INSERT INTO empleados_rol (empleado_id, rol_id) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$empleadoId, $rol]);
            }
            return $empleadoId;
        }

        public function read($id) {
            $sql = "SELECT id, nombre, email, sexo, area_id, boletin, descripcion FROM empleados e WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public function update($id, $nombre, $email, $sexo, $area, $boletin, $descripcion, $roles) {
            if (empty($nombre) || !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,254}$/u", $nombre)) {
                $errors[] = "El nombre debe contener solo letras y espacios.";
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El correo electrónico no es válido.";
            }
            
            if (!empty($errors)) {
                return $errors;
            }
            
            $sql = "UPDATE empleados SET nombre = ?, email = ?, sexo = ?, area_id = ?, boletin = ?, descripcion = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $email, $sexo, $area, $boletin, $descripcion, $id]);
            
            $queryRoles = "SELECT rol_id FROM empleados_rol WHERE empleado_id = ?";
            $stmt2 = $this->pdo->prepare($queryRoles);
            $stmt2->execute([$id]);
            $rolesActuales = $stmt2->fetchAll();
            $rolesActuales = array_map(function($rol) {
                return $rol['rol_id'];
            }, $rolesActuales);

            sort($rolesActuales);
            sort($roles);

            if ($rolesActuales != $roles) {
                $sql = "DELETE FROM empleados_rol WHERE empleado_id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id]);
                foreach ($roles as $rol) {
                    $sql = "INSERT INTO empleados_rol (empleado_id, rol_id) VALUES (?, ?)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([$id, $rol]);
                }

            }

            $query = $this->pdo->query("SELECT e.id, e.nombre, e.email, CASE WHEN e.sexo = 'M' THEN 'Masculino' WHEN e.sexo = 'F' THEN 'Femenino' END AS sexo, a.nombre area, CASE WHEN e.boletin = 0 THEN 'No' WHEN e.boletin = 1 THEN 'Si' END AS boletin, e.descripcion FROM empleados e INNER JOIN areas a ON e.area_id = a.id  ORDER BY id DESC");
            return $query->fetchAll();
        }

        public function delete($id) {
            $sqlFK = "DELETE FROM empleados_rol WHERE empleado_id = ?";
            $stmtFK = $this->pdo->prepare($sqlFK);
            $stmtFK->execute([$id]);
            $sql = "DELETE FROM empleados WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
        }
    }
?>
