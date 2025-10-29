<?php
require_once __DIR__ . '/../config/dbConnection.php';

/**
 * Get count of available drivers
 * Returns the number of verified drivers with active user status
 */
function getAvailableDriversCount() {
    $available_drivers = 0;
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        $sql = "SELECT COUNT(DISTINCT d.driver_id) as driver_count 
                FROM drivers d 
                INNER JOIN users u ON d.user_id = u.user_id 
                WHERE d.verification_status = 'verified' 
                AND u.status = 'active' 
                AND u.user_type = 'driver'";
        
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $available_drivers = $row['driver_count'];
        }
        $conn->close();
    }
    
    return $available_drivers;
}

// Get the count
$available_drivers = getAvailableDriversCount();
?>
