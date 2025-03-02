<?php
    require_once $title == 'Dashboard' ? '../Configs/Config.php' : '../../Configs/Config.php';

    class RolesController {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function list($limite=null) {
            $limites = $limite ? "LIMIT $limite" : "";
            $stmt = $this->pdo->query("SELECT * FROM roles ORDER BY id DESC $limites");
            return $stmt->fetchAll();
        }

        public function create($nombre) {
            $sql = "INSERT INTO roles (nombre) VALUES (?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre]);
        }

        public function read($id) {
            $sql = "SELECT * FROM roles WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public function readRolesByUser($idUser) {
            $sql = "SELECT rol_id FROM empleados_rol WHERE empleado_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$idUser]);
            return $stmt->fetchAll();
        }

        public function update($id, $nombre) {
            $sql = "UPDATE roles SET nombre = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre, $id]);
        }

        public function delete($id) {
            $empleadosRol = "SELECT * FROM empleados_rol WHERE rol_id = $id";
            if ($this->pdo->query($empleadosRol)->rowCount() > 0) {
                return ['error' => true, 'message' => "No se puede eliminar el rol porque tiene empleados asignados. Primero debe eliminar los empleados asignados a este rol."];
            }
            $sql = "DELETE FROM roles WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return ['error' => false, 'message' => "Rol eliminado.", 'res' => $stmt->execute([$id])];
        }
    }
?>
