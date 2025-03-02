<?php
    require_once $title == 'Dashboard' ? '../Configs/Config.php' : '../../Configs/Config.php';

    class AreasController {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function list($limite=null) {
            $limites = $limite ? "LIMIT $limite" : "";
            $stmt = $this->pdo->query("SELECT * FROM areas ORDER BY id DESC $limites");
            return $stmt->fetchAll();
        }

        public function create($nombre) {
            $sql = "INSERT INTO areas (nombre) VALUES (?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombre]);
        }

        public function read($id) {
            $sql = "SELECT * FROM areas WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public function update($id, $nombres) {
            $sql = "UPDATE areas SET nombre = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nombres, $id]);
        }

        public function delete($id) {
            $empleadosRol = "SELECT * FROM empleados WHERE area_id = $id";
            if ($this->pdo->query($empleadosRol)->rowCount() > 0) {
                return ['error' => true, 'message' => "No se puede eliminar el área porque tiene empleados asignados. Primero debe eliminar los empleados asignados a este área."];
            }
            $sql = "DELETE FROM areas WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return ['error' => false, 'message' => "área eliminada.", 'res' => $stmt->execute([$id])];
        }
    }
?>
