<?php
class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $host = '127.0.0.1'; $db = 'belepteto_rendszer'; $user = 'root'; $pass = '';
            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Adatbázis hiba: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}