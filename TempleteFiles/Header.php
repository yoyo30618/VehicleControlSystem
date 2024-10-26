<header class="header">
  <div class="header-top-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="header-top">
            <div class="tag-text">
              <span>一句強而有力的簡介</span>
            </div>
            <div class="certified-text">
              <span>一些編號之類的</span>
            </div>
            <div class="social-area">
              <ul class="social-list list-style">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header-bottom">
    <div class="container">
      <div class="row">
        <div class="header-info">
          <nav class="navbar navbar-expand-lg navbar-dark">
            <a href="index.php"><img src="img/logo/logo.png" alt="logo" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item active"><a class="nav-link" href="index.php">首頁</a></li>
                    <?php 
                      if (isset($_COOKIE['VehicleControlSystem_UserName'])) {
                        echo "<li class='nav-item'><a class='nav-link' href='CarSet.php'>車輛設定</a></li>";
                        echo "<li class='nav-item'><a class='nav-link' href='CarStauts.php'>車輛即時動態</a></li>";
                        echo "<li class='nav-item'><a class='nav-link' href='CarHistory.php'>車輛歷史資訊</a></li>";
                      }
                ?>
                <li class="nav-item"><a class="nav-link" href="ContactUs.php">聯絡我們</a></li>
                <li class="nav-item">
                  <div class="login-btn">
                    <?php 
                      if (!isset($_COOKIE['VehicleControlSystem_UserName'])) {
                        echo "<a class='btn' href='login.php'>登入</a>";
                      }
                      else{
                        echo "<a class='btn' href='logout.php'>".$_COOKIE['VehicleControlSystem_Notice']." 登出</a>";
                      }
                    ?>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</header>