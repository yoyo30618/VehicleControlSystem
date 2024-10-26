<?php
include_once('conn_mysql.php');

if (isset($_GET['carId'])) {
    $carId = $_GET['carId'];
    
    // 撈取位置資料
    $sqlLoc = "SELECT * FROM `carrecord` WHERE `CarID` = ? AND `TopicMode` = 'loc' ORDER BY `Record` DESC LIMIT 50";
    $stmtLoc = $db_link->prepare($sqlLoc);
    $stmtLoc->bind_param("s", $carId);
    $stmtLoc->execute();
    $resultLoc = $stmtLoc->get_result();
    
    $route = array();
    while ($rowLoc = $resultLoc->fetch_assoc()) {
        list($lat, $lng) = explode(',', $rowLoc['Record']);
        $route[] = array(
            'lat' => $lat,
            'lng' => $lng,
            'time' => $rowLoc['DateTime']
        );
    }
    $route = array_reverse($route);

    // 撈取電壓資料
    $sqlV = "SELECT * FROM `carrecord` WHERE `CarID` = ? AND `TopicMode` = 'v' ORDER BY `DateTime` DESC LIMIT 50";
    $stmtV = $db_link->prepare($sqlV);
    $stmtV->bind_param("s", $carId);
    $stmtV->execute();
    $resultV = $stmtV->get_result();
    
    $voltageData = array();
    while ($rowV = $resultV->fetch_assoc()) {
        $voltageData[] = array(
            'voltage' => $rowV['Record'],
            'time' => $rowV['DateTime']
        );
    }
    $voltageData = array_reverse($voltageData);

    header('Content-Type: application/json');
    echo json_encode(array('route' => $route, 'voltageData' => $voltageData));
} else {
    echo json_encode(array('error' => 'No car ID provided'));
}
?>
