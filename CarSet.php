<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <style>
        /* 覆蓋層樣式 */
        #overlay {
        color:black;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none; /* 初始隱藏 */
        z-index: 999; /* 確保在最上層 */
        }

        /* 彈出視窗樣式 */
        #popup {
        color:black;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border: 2px solid black;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        display: none; /* 初始隱藏 */
        z-index: 1000; /* 確保在覆蓋層之上 */
        }
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
            <!-- Strat Breadcrumb Area -->
            <section class="breadcrumb-area">
                <div class="breadcrumb-content text-center">
                    <h1>車輛設定</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">車輛設定</li>
                        </ol>
                    </nav>
                </div>
            </section>
            <!-- End Breadcrumb Area -->
            <br>

            <!-- Start FAQ Area -->
            <section class="faq-area section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="faq-info">
                                <h2>車輛資訊設定</h2>
                                <div class="accordion" id="accordionLavala">
                                    <!-- Single Faq -->
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0"><button class="btn-link collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">既有車輛資訊維護</button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                            data-parent="#accordionLavala">
                                            <div class="card-body">
                                                <?php
                                                include_once('conn_mysql.php');
                                                function getAllCarInfo($db_link)
                                                {// 函數：獲取所有車輛資訊
                                                    $sql = "SELECT * FROM carinfo";
                                                    $result = $db_link->query($sql);
                                                    return $result->fetch_all(MYSQLI_ASSOC);
                                                }
                                                function updateCarInfo($db_link, $id, $carID, $topicV, $topicLoc, $notice)
                                                {// 函數：更新車輛資訊
                                                    $sql = "UPDATE carinfo SET CarID = ?, Topic_V = ?, Topic_loc = ?, Notice = ? WHERE _ID = ?";
                                                    $stmt = $db_link->prepare($sql);
                                                    $stmt->bind_param("ssssi", $carID, $topicV, $topicLoc, $notice, $id);
                                                    return $stmt->execute();
                                                }
                                                function deleteCarInfo($db_link, $id)
                                                { // 函數：刪除車輛資訊
                                                    $sql = "DELETE FROM carinfo WHERE _ID = ?";
                                                    $stmt = $db_link->prepare($sql);
                                                    $stmt->bind_param("i", $id);
                                                    return $stmt->execute();
                                                }
                                                if ($_SERVER["REQUEST_METHOD"] == "POST") {// 處理表單提交
                                                    if (isset($_POST['action'])) {
                                                        $id = $_POST['id'];

                                                        if ($_POST['action'] == 'update') {
                                                            $carID = $_POST['carID'];
                                                            $topicV = $_POST['topicV'];
                                                            $topicLoc = $_POST['topicLoc'];
                                                            $notice = $_POST['notice'];
                                                            updateCarInfo($db_link, $id, $carID, $topicV, $topicLoc, $notice);
                                                        } elseif ($_POST['action'] == 'delete') {
                                                            deleteCarInfo($db_link, $id);
                                                        }
                                                    }
                                                }

                                                $carInfoData = getAllCarInfo($db_link); // 獲取所有車輛資訊
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>車輛編號</th>
                                                                <th>Topic/電壓</th>
                                                                <th>Topic/位置</th>
                                                                <th>註記</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="carInfoTableBody">
                                                            <!-- 資料會透過 JavaScript 動態插入這裡 -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Faq -->
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0"><button class="btn-link" type="button"
                                                    data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">車輛資訊新增</button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-parent="#accordionLavala">
                                            <div class="card-body">
                                                <form id="addCarForm">
                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <label for="CarID" class="form-label">車輛編號</label>
                                                            <input type="text" class="form-control" id="CarID"
                                                                name="CarID" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="Topic_V" class="form-label">Topic/電壓</label>
                                                            <input type="text" class="form-control" id="Topic_V"
                                                                name="Topic_V" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="Topic_loc" class="form-label">Topic/位置</label>
                                                            <input type="text" class="form-control" id="Topic_loc"
                                                                name="Topic_loc" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="Notice" class="form-label">註記</label>
                                                            <input type="text" class="form-control" id="Notice"
                                                                name="Notice">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-lg px-5">新增車輛</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Accordion -->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <!-- End FAQ Area -->
        <?php include_once('TempleteFiles/Footer.php'); ?>
    </div>
    <div id="popup"></div>
    <div id="overlay"></div>
    <script>
        function showPopup(message, borderColor = 'black', backgroundColor = 'white') {
            const popup = document.getElementById('popup');
            const overlay = document.getElementById('overlay');
            // Set styles and message
            popup.style.border = `2px solid ${borderColor}`;
            popup.style.backgroundColor = backgroundColor;
            popup.innerHTML = message;

            // Show the popup and overlay
            popup.style.display = 'block';
            overlay.style.display = 'block';

            // Auto-close after 5 seconds
            const timeoutId = setTimeout(closePopup, 5000);

            // Close when clicking outside the popup
            overlay.onclick = function () {
                closePopup();
                clearTimeout(timeoutId); // Prevent auto-close if already closed
            };
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>

    <script>
        function fetchCarInfo() {
            $.ajax({
                url: 'car_info_api.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    renderTable(data);
                },
                error: function (xhr, status, error) {
                    showPopup('獲取資料失敗: ' + error, 'blue', 'pink');
                }
            });
        }

        function renderTable(carInfoData) {
            const tableBody = document.getElementById('carInfoTableBody');
            tableBody.innerHTML = '';
            carInfoData.forEach(car => {
                const row = `
                <tr data-id="${car._ID}">
                    <td>${car.CarID}</td>
                    <td>${car.Topic_V}</td>
                    <td>${car.Topic_loc}</td>
                    <td>${car.Notice}</td>
                    <td>
                        <button style="width: 45%;" class="btn btn-primary btn-sm edit-btn">修改</button>
                        <button style="width: 45%;" class="btn btn-danger btn-sm delete-btn">刪除</button>
                    </td>
                </tr>
            `;
                tableBody.innerHTML += row;
            });
        }

        function enableEditing(row) {
            const cells = row.cells;
            for (let i = 0; i < cells.length - 1; i++) {
                const cell = cells[i];
                const text = cell.textContent;
                cell.innerHTML = `<input type="text" class="form-control" style="width: 100%;" value="${text}">`;

            }
            const actionCell = cells[cells.length - 1];
            actionCell.innerHTML = `
            <button style="width: 45%;" class="btn btn-success btn-sm save-btn">儲存</button>
            <button style="width: 45%;" class="btn btn-secondary btn-sm cancel-btn">取消</button>
        `;
        }

        function disableEditing(row, data) {
            const cells = row.cells;
            cells[0].textContent = data.CarID;
            cells[1].textContent = data.Topic_V;
            cells[2].textContent = data.Topic_loc;
            cells[3].textContent = data.Notice;
            cells[4].innerHTML = `
            <button style="width: 45%;" class="btn btn-primary btn-sm edit-btn">修改</button>
            <button style="width: 45%;" class="btn btn-danger btn-sm delete-btn">刪除</button>
        `;
        }

        function updateCarInfo(id, data) {
            $.ajax({
                url: 'car_info_api.php',
                type: 'POST',
                data: {
                    action: 'update',
                    id: id,
                    carID: data.CarID,
                    topicV: data.Topic_V,
                    topicLoc: data.Topic_loc,
                    notice: data.Notice
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showPopup('資料已成功更新.', 'green', 'lightyellow');
                        fetchCarInfo();  // 重新獲取資料並更新表格
                    } else {
                        showPopup('資料更新失敗: ' + response.message, 'green', 'pink');
                    }
                },
                error: function (xhr, status, error) {
                    showPopup('更新失敗: ' + error, 'green', 'pink');
                }
            });
        }

        function deleteCarInfo(id) {
            $.ajax({
                url: 'car_info_api.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showPopup('資料已成功刪除', 'red', 'lightyellow');
                        fetchCarInfo();  // 重新獲取資料並更新表格
                    } else {
                        showPopup('資料刪除失敗: ' + response.message, 'red', 'pink');
                    }
                },
                error: function (xhr, status, error) {
                    showPopup('刪除失敗: ' + error, 'red', 'pink');
                }
            });
        }

        $(document).ready(function () {
            fetchCarInfo();  // 初始載入資料

            $('#carInfoTableBody').on('click', '.edit-btn', function () {
                const row = $(this).closest('tr')[0];
                enableEditing(row);
            });

            $('#carInfoTableBody').on('click', '.delete-btn', function () {
                if (confirm('確定要刪除這筆資料嗎？')) {
                    const id = $(this).closest('tr').data('id');
                    deleteCarInfo(id);
                }
            });

            $('#carInfoTableBody').on('click', '.save-btn', function () {
                const row = $(this).closest('tr')[0];
                const id = $(row).data('id');
                const updatedData = {
                    CarID: row.cells[0].querySelector('input').value,
                    Topic_V: row.cells[1].querySelector('input').value,
                    Topic_loc: row.cells[2].querySelector('input').value,
                    Notice: row.cells[3].querySelector('input').value
                };
                updateCarInfo(id, updatedData);
            });

            $('#carInfoTableBody').on('click', '.cancel-btn', function () {
                const row = $(this).closest('tr')[0];
                const id = $(row).data('id');
                $.ajax({
                    url: 'car_info_api.php',
                    type: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function (data) {
                        disableEditing(row, data[0]);
                    },
                    error: function (xhr, status, error) {
                        showPopup('獲取DB資料失敗' + error, 'blue', 'pink');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#addCarForm').on('submit', function (e) {
                e.preventDefault();  // 防止表單的默認提交行為

                $.ajax({
                    url: 'AddCar.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showPopup(response.message, 'blue', 'lightyellow');
                            fetchCarInfo();  // 重新獲取資料並更新表格
                            document.getElementById('addCarForm').reset();
                        } else {
                            showPopup('錯誤: ' + response.message, 'blue', 'pink');
                        }
                    },
                    error: function (xhr, status, error) {
                        showPopup('發生錯誤: ' + error, 'blue', 'pink');
                    }
                });
            });
        });
    </script>
</body>

</html>