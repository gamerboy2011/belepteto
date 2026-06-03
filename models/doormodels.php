<?php
require_once 'config/Database.php';

class DoorModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllDoors() {
        return $this->db->query("SELECT * FROM doors")->fetchAll();
    }

    public function getDoorMode($id) {
        $stmt = $this->db->prepare("SELECT mode FROM doors WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public function updateDoorMode($id, $mode) {
        $stmt = $this->db->prepare("UPDATE doors SET mode = ? WHERE id = ?");
        return $stmt->execute([$mode, $id]);
    }
}