<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
<?php include_once('TempleteFiles/BasicImport.php'); ?>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['VehicleControlSystem_UserName'])) {
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
            <section class="breadcrumb-area">
                <div class="breadcrumb-content text-center">
                    <h1>車輛即時動態</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">車輛即時動態</li>
                        </ol>
                    </nav>
                </div>
            </section>
            <br>
            <section class="faq-area section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="faq-info">
                                <h2>車輛即時動態</h2>
                                <div class="accordion" id="accordionLavala">
                                    <div id="map" style="height: 600px;"></div>
                                </div><br>
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>車輛 ID</td>
                                        <td>車輛名稱</td>
                                        <td>電壓</td>
                                        <td>電壓偵測時間</td>
                                        <td>座標</td>
                                        <td>座標偵測時間</td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <?php include_once('TempleteFiles/Footer.php'); ?>
    </div>
    </div>
    <script>
        var map = L.map('map').setView([25.0330, 121.5654], 12); // 初始地圖位置

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function loadVehicleData() {
            fetch('vehicle_data.php')
                .then(response => response.json())
                .then(data => {
                    var bounds = L.latLngBounds();
                    var tableBody = document.querySelector('.table tbody');
                    tableBody.innerHTML = `<tr>
                                        <td>車輛 ID</td>
                                        <td>車輛名稱</td>
                                        <td>電壓</td>
                                        <td>電壓偵測時間</td>
                                        <td>座標</td>
                                        <td>座標偵測時間</td>
                                    </tr>`; // Clear existing table rows

                    data.forEach(vehicle => {
                        // Update map
                        if (vehicle.lat != null && vehicle.lng != null) {
                            var markerColor = vehicle.isGray ? 'gray' : 'darkgreen';
                            var circle = L.circleMarker([vehicle.lat, vehicle.lng], {
                                radius: 6,
                                fillColor: markerColor,
                                color: markerColor,
                                weight: 1,
                                opacity: 1,
                                fillOpacity: 0.6
                            }).addTo(map);

                            circle.bindPopup(`車輛 ID: ${vehicle.CarID}<br>車輛名稱: ${vehicle.Notice}<br>電壓: ${vehicle.voltage}V<br>座標: (${vehicle.lat}, ${vehicle.lng})`);

                            bounds.extend([vehicle.lat, vehicle.lng]);
                        }
                        // Update table
                        var row = document.createElement('tr');
                        $ErrorCar = false;
                        if (vehicle.voltage == 0 || vehicle.LastVoltageUpdateTime == null || vehicle.lat == null || vehicle.lng == null || vehicle.LastLocUpdateTime == null)
                            $ErrorCar = true;
                        if ($ErrorCar) {
                            row.innerHTML = `
                            <td style='background-color:red;'>${vehicle.CarID}</td>
                            <td style='background-color:red;'>${vehicle.Notice}</td>
                            <td style='background-color:red;'>狀態異常</td>
                            <td style='background-color:red;'>狀態異常</td>
                            <td style='background-color:red;'>狀態異常</td>
                            <td style='background-color:red;'>狀態異常</td>
                        `;

                        }
                        else {
                            row.innerHTML = `
                            <td>${vehicle.CarID}</td>
                            <td>${vehicle.Notice}</td>
                            <td>${vehicle.voltage}</td>
                            <td>${vehicle.LastVoltageUpdateTime}</td>
                            <td>${vehicle.lat}, ${vehicle.lng}</td>
                            <td>${vehicle.LastLocUpdateTime}</td>
                        `;

                        }
                        tableBody.appendChild(row);
                    });

                    if (bounds.isValid()) {
                        map.fitBounds(bounds);
                    }
                });
        }

        loadVehicleData();
        setInterval(loadVehicleData, 1000); // 每五分鐘自動更新
    </script>
</body>

</html>