<?php
include_once('conn_mysql.php');

try {
    $sql = "WITH LatestRecords AS (
    SELECT 
        c1.CarID,
        c1.TopicMode,
        c1.DateTime AS LastUpdateTime,
        c1.Record
    FROM carrecord c1
    JOIN (
        SELECT CarID, TopicMode, MAX(DateTime) AS LastUpdateTime
        FROM carrecord
        WHERE TopicMode IN ('v', 'loc')
        GROUP BY CarID, TopicMode
    ) c2 ON c1.CarID = c2.CarID 
          AND c1.TopicMode = c2.TopicMode
          AND c1.DateTime = c2.LastUpdateTime
)
SELECT 
    carinfo.CarID,
    v.LastUpdateTime AS LastVoltageUpdateTime,
    loc.LastUpdateTime AS LastLocUpdateTime,
    CASE 
        WHEN loc.LastUpdateTime < v.LastUpdateTime 
             AND TIMESTAMPDIFF(MINUTE, loc.LastUpdateTime, v.LastUpdateTime) > 5
        THEN NULL 
        ELSE loc.Record 
    END AS LastLocRecord,
    CASE 
        WHEN loc.LastUpdateTime > v.LastUpdateTime 
             AND TIMESTAMPDIFF(MINUTE, loc.LastUpdateTime, v.LastUpdateTime) > 5
        THEN NULL 
        ELSE v.Record 
    END AS LastVoltageRecord,
    carinfo.Notice,
    carinfo.IsUsed
FROM carinfo
LEFT JOIN LatestRecords v ON v.CarID = carinfo.CarID AND v.TopicMode = 'v'
LEFT JOIN LatestRecords loc ON loc.CarID = carinfo.CarID AND loc.TopicMode = 'loc'
WHERE carinfo.IsUsed = 1;
";

    $stmt = $db_link->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($CarID, $LastVoltageUpdateTime, $LastLocUpdateTime, $LastLocRecord, $LastVoltageRecord,$Notice,$IsUsed);

    $vehicles = [];
    while ($stmt->fetch()) {
        // 計算是否超過10分鐘沒有更新
        $lastUpdateTime = $LastLocUpdateTime ?? $LastVoltageUpdateTime;
        $timeDiff = time() - strtotime($lastUpdateTime);
        $isGray = $timeDiff > 600; // 超過10分鐘

        // 假設 Record 包含座標並以 "lat,lng" 格式存儲
        if ($LastLocRecord) {
            list($lat, $lng) = explode(',', $LastLocRecord);
        } else {
            $lat = $lng = null;
        }

        $voltage = (float) $LastVoltageRecord;

        $vehicles[] = [
            'CarID' => $CarID,
            'lat' => $lat,
            'lng' => $lng,
            'voltage' => $voltage,
            'isGray' => $isGray,
            'Notice' => $Notice,
            'IsUsed' => $IsUsed,
            'LastVoltageUpdateTime' => $LastVoltageUpdateTime,
            'LastLocUpdateTime' => $LastLocUpdateTime
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($vehicles);

} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
