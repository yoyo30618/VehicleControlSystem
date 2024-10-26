<?php
include_once('conn_mysql.php');

header('Content-Type: application/json');  // 設置響應類型為 JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carID = $_POST['CarID'];
    $topic_V = $_POST['Topic_V'];
    $topic_loc = $_POST['Topic_loc'];
    $notice = $_POST['Notice'];
    $isUsed = 1; // 預設值

    $sql = "INSERT INTO `carinfo`(`CarID`, `Topic_V`, `Topic_loc`, `IsUsed`, `Notice`) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $db_link->prepare($sql);    // 使用預處理語句來防止 SQL 注入
    $stmt->bind_param("sssis", $carID, $topic_V, $topic_loc, $isUsed, $notice);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '資料已成功插入數據庫']);
    } else {
        echo json_encode(['success' => false, 'message' => '錯誤: ' . $stmt->error]);
    }

    $stmt->close();
    $db_link->close();
} else {
    echo json_encode(['success' => false, 'message' => '無效的請求方法']);
}
?>