<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home</title>
  <style>
        .map-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            text-align:center;
            width:100%;
        }
    </style>
</head>
<?php include_once('TempleteFiles/BasicImport.php'); ?>

<body>
  <div class="wrapper-content">
    <div class="wrapper">
      <?php include_once('TempleteFiles/Header.php'); ?>
      <!-- Strat Breadcrumb Area -->
      <section class="breadcrumb-area">
        <div class="breadcrumb-content text-center">
          <h1>聯絡我們</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
              <li class="breadcrumb-item active" aria-current="page">聯絡我們</li>
            </ol>
          </nav>
        </div>
      </section>
      <!-- End Breadcrumb Area -->

      <!-- Start Contact Area -->
      <section class="contact-area section-padding">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="contact-address">
                <div class="contact-single">
                  <div class="contact-icon">
                    <span class="flaticon-placeholder"></span>
                  </div>
                  <h4>聯絡地址</h4>
                  <p>地址地址地址地址地址地址地址地址地址地址地址地址地址地址</p>
                </div>
                <div class="contact-single">
                  <div class="contact-icon">
                    <span class="flaticon-email"></span>
                  </div>
                  <h4>電子信箱</h4>
                  <p><a href="mailto:rogahn.jeanne@hotmail.com">信箱信箱信箱信箱信箱信箱信箱信箱信箱信箱信箱信箱信箱</a></p>
                </div>
                <div class="contact-single">
                  <div class="contact-icon">
                    <span class="flaticon-call"></span>
                  </div>
                  <h4>連絡電話</h4>
                  <p><a>電話電話電話電話電話電話電話電話電話電話電話電話電話</a></p>
                </div>
              </div>
            </div>
          </div><br>
          <div class="map-responsive" >
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.7793447967238!2d121.0656671111714!3d22.736441429289286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346fb9476f5d5c37%3A0x39a51f204cad3662!2z5ZyL56uL6Ie65p2x5aSn5a24!5e0!3m2!1szh-TW!2stw!4v1728207300510!5m2!1szh-TW!2stw"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </section>
      <?php include_once('TempleteFiles/Footer.php'); ?>
    </div>
</body>
</html>