<?php
// index.php - THE INBOUND ROUTER

// Globális hibajelentés bekapcsolása fejlesztéshez (XAMPP-on belül nagyon hasznos)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// JAVÍTÁS #3: Ha az Arduino hívja (uid paraméterrel), azonnal leválasztjuk az API-ra
if (isset($_GET['uid'])) {
    require_once 'controllers/ApiController.php';
    $api = new ApiController();
    $api->processNfc();
    exit;
}

// Minden egyéb esetben (ha böngészőből nyitják meg) az Admin felület vezérlőjét indítjuk el
require_once 'controllers/AdminController.php';
$admin = new AdminController();
$admin->handleRequest();