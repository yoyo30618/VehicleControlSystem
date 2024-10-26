<!DOCTYPE html>
<html lang="en">

<head>
    <title>車輛歷史資訊</title>
    <?php include_once('TempleteFiles/BasicImport.php'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>

<style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media screen and (max-width: 600px) {
            .table-responsive {
                font-size: 14px;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <?php
        session_start();
        if(!isset($_SESSION['VehicleControlSystem_UserName'])){
            echo "<script>
                alert('您尚未登入，將跳轉回首頁。');
                window.location.href = 'index.php';
            </script>";
            exit(); // 結束腳本執行
        }
    ?>
    <div class="wrapper-content">
        <div class="wrapper">
            <?php include_once('TempleteFiles/Header.php'); ?>
            <!-- Start Breadcrumb Area -->
            <section class="breadcrumb-area">
                <div class="breadcrumb-content text-center">
                    <h1>車輛歷史資訊</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">車輛歷史資訊</li>
                        </ol>
                    </nav>
                </div>
            </section>
            <!-- End Breadcrumb Area -->
            <br>

            <!-- Start Vehicle History Area -->
            <section class="vehicle-history-area section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="faq-info">
                                <h2>車輛歷史資訊</h2>
                                <div class="accordion" id="accordionVehicles">
                                    <div class="form-group">
                                        <label for="carSelect">選擇車輛：</label>
                                        <select id="carSelect" class="form-control">
                                            <option value="">所有車輛</option>
                                        </select>
                                    </div>
                                    <div class="accordion" id="accordionLavala">
                                        <div id="map" style="height: 400px;"></div>
                                    </div><br>
                                    <?php
                                    include_once('conn_mysql.php');
                                    function getVehiclesWithHistory($db_link)
                                    {
                                        $sql = "SELECT DISTINCT c.CarID, c.Topic_V, c.Topic_loc, c.Notice 
                                                FROM carinfo c ORDER BY c.CarID";
                                        $result = $db_link->query($sql);
                                        $vehicles = [];
                                        while ($row = $result->fetch_assoc()) {
                                            $carID = $row['CarID'];
                                            $vehicles[$carID] = $row;
                                            $historySql = "SELECT * FROM carrecord WHERE CarID = ? ORDER BY DateTime DESC";
                                            $stmt = $db_link->prepare($historySql);
                                            $stmt->bind_param("s", $carID);
                                            $stmt->execute();
                                            $historyResult = $stmt->get_result();
                                            $vehicles[$carID]['history'] = $historyResult->fetch_all(MYSQLI_ASSOC);
                                        }
                                        return $vehicles;
                                    }

                                    $vehicles = getVehiclesWithHistory($db_link);
                                    foreach ($vehicles as $carID => $vehicle):
                                        ?>
                                        <!-- Single Vehicle -->
                                        <div class="card">
                                            <div class="card-header" id="heading<?php echo $carID; ?>">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                        data-target="#collapse<?php echo $carID; ?>" aria-expanded="true"
                                                        aria-controls="collapse<?php echo $carID; ?>">
                                                        車輛編號: <?php echo $vehicle['Notice'] . " - " . $carID; ?>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse<?php echo $carID; ?>" class="collapse"
                                                aria-labelledby="heading<?php echo $carID; ?>"
                                                data-parent="#accordionVehicles">
                                                <div class="card-body">
                                                    <h6>車輛資訊：</h6>
                                                    <p>Topic/電壓: <?php echo $vehicle['Topic_V']; ?></p>
                                                    <p>Topic/位置: <?php echo $vehicle['Topic_loc']; ?></p>
                                                    <p>註記: <?php echo $vehicle['Notice']; ?></p>
                                                    <h6>歷史記錄：</h6>
                                                    <canvas id="voltageChart<?php echo $carID; ?>" width="400"
                                                        height="200"></canvas>
                                                    <div class="table-responsive">
                                                    <!-- Voltage Chart -->
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>記錄時間</th>
                                                                <th>資訊</th>
                                                                <th>紀錄模式</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($vehicle['history'] as $record): ?>
                                                                <tr>
                                                                    <td><?php echo $record['DateTime']; ?></td>
                                                                    <td><?php echo $record['Record']; ?></td>
                                                                    <td><?php echo $record['TopicMode'] == 'loc' ? '經緯度' : '電壓'; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Vehicle History Area -->
            <?php include_once('TempleteFiles/Footer.php'); ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.collapse').on('show.bs.collapse', function () {
                $(this).closest('.card').find('.btn-link').addClass('active');
            });

            $('.collapse').on('hide.bs.collapse', function () {
                $(this).closest('.card').find('.btn-link').removeClass('active');
            });
        });
    </script>
    <script>
        var map = L.map('map').setView([25.0330, 121.5654], 12);
        var markers = {};
        var routeLayer;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function loadVehicleData() {
            fetch('vehicle_data.php')
                .then(response => response.json())
                .then(data => {
                    var bounds = L.latLngBounds();
                    var carSelect = document.getElementById('carSelect');

                    data.forEach(vehicle => {
                        // Update map
                        if (vehicle.lat != null && vehicle.lng != null) {
                            var markerColor = vehicle.isGray ? 'gray' : 'darkgreen';
                            if (markers[vehicle.CarID]) {
                                markers[vehicle.CarID].setLatLng([vehicle.lat, vehicle.lng]);
                            } else {
                                markers[vehicle.CarID] = L.circleMarker([vehicle.lat, vehicle.lng], {
                                    radius: 6,
                                    fillColor: markerColor,
                                    color: markerColor,
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 0.6
                                }).addTo(map);
                            }

                            markers[vehicle.CarID].bindPopup(`車輛 ID: ${vehicle.CarID}<br>車輛名稱: ${vehicle.Notice}<br>電壓: ${vehicle.voltage}V<br>座標: (${vehicle.lat}, ${vehicle.lng})`);

                            bounds.extend([vehicle.lat, vehicle.lng]);
                        }

                        // Update car select options
                        if (!carSelect.querySelector(`option[value="${vehicle.CarID}"]`)) {
                            var option = document.createElement('option');
                            option.value = vehicle.CarID;
                            option.textContent = `${vehicle.CarID} - ${vehicle.Notice}`;
                            carSelect.appendChild(option);
                        }
                    });

                    if (bounds.isValid()) {
                        map.fitBounds(bounds);
                    }
                });
        }

        function loadVehicleRoute(carId) {
            if (routeLayer) {
                map.removeLayer(routeLayer);
            }

            fetch(`get_vehicle_route.php?carId=${carId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.route && data.route.length > 0) {
                        const routeData = data.route;
                        var routeCoordinates = routeData.map(point => [point.lat, point.lng]);
                        routeLayer = L.polyline(routeCoordinates, { color: 'blue' }).addTo(map);
                        map.fitBounds(routeLayer.getBounds());
                    }
                });
        }
// 新增撈取電壓資料並繪製折線圖的功能
function loadVehicleVoltageData(carId) {
    fetch(`get_vehicle_route.php?carId=${carId}`)
        .then(response => response.json())
        .then(data => {
            if (data.voltageData && data.voltageData.length > 0) {
                const voltageData = data.voltageData;
                const ctx = document.getElementById(`voltageChart${carId}`).getContext('2d');
                if (ctx.chart) {
                    ctx.chart.destroy();
                }
                
                // 繪製新圖表
                ctx.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: voltageData.map(record => record.time),
                        datasets: [{
                            label: '電壓 (V)',
                            data: voltageData.map(record => record.voltage),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'minute'
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
}
        document.getElementById('carSelect').addEventListener('change', function () {
            var selectedCarId = this.value;
            if (selectedCarId) {
                loadVehicleRoute(selectedCarId);
            } else {
                if (routeLayer) {
                    map.removeLayer(routeLayer);
                }
                loadVehicleData();
            }
        });

// 當每個車輛的collapse展開時，載入對應的電壓資料並繪製圖表
$(document).ready(function () {
    $('.collapse').on('show.bs.collapse', function () {
        const carId = $(this).attr('id').replace('collapse', '');
        loadVehicleVoltageData(carId);  // 撈取電壓資料並繪製折線圖

        // 讓該車輛路線圖保持不變
        loadVehicleRoute(carId);
    });

    $('.collapse').on('hide.bs.collapse', function () {
        $(this).closest('.card').find('.btn-link').removeClass('active');
    });

    // 初始化載入所有車輛數據
    loadVehicleData();
    setInterval(loadVehicleData, 60000); // 每分鐘更新一次
});
    </script>
</body>

</html>