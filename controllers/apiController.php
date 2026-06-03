<?php
// controllers/ApiController.php
require_once 'config/Database.php';

class ApiController {
    private $db;

    public function __construct() {
        // Inicializáljuk a PDO kapcsolatot
        $this->db = Database::getConnection();
    }

    public function processNfc() {
        // Ha nem érkezett UID, azonnal elutasítjuk
        if (!isset($_GET['uid'])) {
            echo "DENIED";
            exit;
        }

        $uid = trim($_GET['uid']);
        $door_id = 1; // Alapértelmezett bejárati ajtó ID

        try {
            // Meghívjuk a javított MySQL tárolt eljárást
            $stmt = $this->db->prepare("CALL CheckIncedoAccess(:uid, :door_id, @p_result)");
            $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
            $stmt->bindParam(':door_id', $door_id, PDO::PARAM_INT);
            $stmt->execute();

            // Kiolvassuk az eredményt
            $output = $this->db->query("SELECT @p_result AS access_decision")->fetch();
            $decision = $output['access_decision'] ?? 'DENIED';

            echo ($decision === 'GRANT') ? "GRANT" : "DENIED";

        } catch (PDOException $e) {
            echo "DENIED"; // Hiba esetén biztonsági okokból zárunk
        }
        exit;
    }
}