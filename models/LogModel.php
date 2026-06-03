<?php
require_once 'config/Database.php';

class LogModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getLatestLogs($limit = 12) {
        $stmt = $this->db->prepare("SELECT * FROM access_logs ORDER BY timestamp DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
