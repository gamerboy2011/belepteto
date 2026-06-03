<?php
// controllers/AdminController.php
require_once 'models/DoorModel.php';
require_once 'models/LogModel.php';

class AdminController {
    public function handleRequest() {
        $tab = $_GET['tab'] ?? 'dashboard';
        $doorModel = new DoorModel();
        $logModel = new LogModel();
        
        // 1. Távvezérlés kezelése (Gombnyomások az admin felületről)
        if (isset($_GET['change_mode']) && isset($_GET['door_id'])) {
            $doorId = (int)$_GET['door_id'];
            $newMode = $_GET['change_mode'];
            
            if (in_array($newMode, ['NORMAL', 'LOCKED', 'ALWAYS_OPEN'])) {
                $doorModel->updateDoorMode($doorId, $newMode);
            }
            
            // Visszairányítás, hogy ne ragadjon be a URL-be a parancs
            header("Location: index.php?tab=" . $tab);
            exit;
        }

        // JAVÍTÁS: Az ajtókat MINDEN esetben lekérjük, így a dashboard.php-nak is meglesz a $doors!
        $doors = $doorModel->getAllDoors();
        $logs = $logModel->getLatestLogs(12);

        // 2. Megfelelő View betöltése
        if ($tab === 'hardware') {
            require_once 'views/hardware.php';
        } else {
            require_once 'views/dashboard.php';
        }
    }
}