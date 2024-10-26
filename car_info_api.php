<?php
include_once('conn_mysql.php');

// 處理 GET 請求 - 獲取車輛資訊
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM carinfo WHERE _ID = ?";
        $stmt = $db_link->prepare($sql);
        $stmt->bind_param("i", $id);
    } else {
        $sql = "SELECT * FROM carinfo";
        $stmt = $db_link->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($data);
}

// 處理 POST 請求 - 更新或刪除車輛資訊
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];

    if ($action === 'update') {
        $carID = $_POST['carID'];
        $topicV = $_POST['topicV'];
        $topicLoc = $_POST['topicLoc'];
        $notice = $_POST['notice'];

        $sql = "UPDATE carinfo SET CarID = ?, Topic_V = ?, Topic_loc = ?, Notice = ? WHERE _ID = ?";
        $stmt = $db_link->prepare($sql);
        $stmt->bind_param("ssssi", $carID, $topicV, $topicLoc, $notice, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => '資料已成功更新']);
        } else {
            echo json_encode(['success' => false, 'message' => '更新失敗: ' . $stmt->error]);
        }
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM carinfo WHERE _ID = ?";
        $stmt = $db_link->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => '資料已成功刪除']);
        } else {
            echo json_encode(['success' => false, 'message' => '刪除失敗: ' . $stmt->error]);
        }
    }
}

// 關閉資料庫連接
$db_link->close();
?>