<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="description" content="<?= $setting->nama_web ?>">
  <link href="<?= $icon ?>" rel="icon">
  <title><?= $setting->nama_web ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700%7cPoppins:400,600,700&display=swap">
  <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/template/assets/css/libraries.css" />
  <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/template/assets/css/style.css" />
</head>

<body>
  <div class="wrapper">
    <!-- =========================
        Header
    =========================== -->
    <?= $this->render('component/header') ?>

    <!-- ============================
        Slider
    ============================== -->
    <section id="slider1" class="slider slider-1">
      <div class="owl-carousel thumbs-carousel carousel-arrows" data-slider-id="slider1" data-dots="false" data-autoplay="true" data-nav="true" data-transition="fade" data-animate-out="fadeOut" data-animate-in="fadeIn">
        <div class="slide-item align-v-h bg-overlay">
          <div class="bg-img"><img src="<?= $bg_login ?>" alt="img"></div>
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="slide__content">
                  <h2 class="slide__title"><?= $setting->judul_web ?></h2>
                  <p class="slide__desc"><?= $setting->slogan_web ?></p>
                  <a href="#" class="btn btn__primary btn__hover2 mr-30">GET NOW</a>
                  <a href="#" class="btn btn__white">CONTACT US</a>
                </div><!-- /.slide-content -->
              </div><!-- /.col-lg-8 -->
            </div><!-- /.row -->
          </div><!-- /.container -->
        </div><!-- /.slide-item -->
      </div><!-- /.carousel -->
    </section><!-- /.slider -->

    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto">
          <div class="card" style="border: 1px solid rgb(0 0 0 / 80%);border-radius: 1.5rem;">
            <div class="card-body">
              <div class="row">
                <div class="col-4 text-center text-dark">
                  <img src="<?= \Yii::$app->request->baseUrl . "/uploads/icons/give.png" ?>" width="80px" alt="">
                  <p class="p-2" style="font-size: 3rem;"><?= $count_program ?></p>
                  <p style="font-size: 1rem;">Jumlah Program<p>
                </div>
                <div class="col-4 text-center text-dark">
                  <img src="<?= \Yii::$app->request->baseUrl . "/uploads/icons/donation.png" ?>" width="80px" alt="">
                  <p class="p-2" style="font-size: 3rem;">4</p>
                  <p style="font-size: 1rem;">Jumlah Penerima Wakaf<p>
                </div>
                <div class="col-4 text-center text-dark">
                  <img src="<?= \Yii::$app->request->baseUrl . "/uploads/icons/community.png" ?>" width="80px" alt="">
                  <p class="p-2" style="font-size: 3rem;"><?= $count_wakif ?></p>
                  <p style="font-size: 1rem;">Jumlah Wakaf<p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ========================
        Services
    =========================== -->
    <section id="services" class="services pb-90">
      <div class="container">
        <div class="row heading heading-2 mb-40">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <!-- <span class="heading__subtitle" style="color:orange;">Tentang Kami</span> -->
          </div><!-- /.col-lg-12 -->
          <div class="col-sm-12 col-md-12 col-lg-6">
            <h2 class="heading__title" style="color:orange;">Tentang Kami</h2>
            <!-- <br> -->
            <img src="<?= $icon ?>" class="logo" alt="logo" style="width:35%;">
          </div><!-- /.col-lg-5 -->
          <div class="col-sm-12 col-md-12 col-lg-6 ">
            <p class="heading__desc"><?= $setting->tentang_kami ?></p>
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <center>
          <h1>Lebih Dekat Dengan Kami</h1>
        </center>
        <div class="row text-center">
          <?php foreach ($organisasis as $organisasi) { ?>
            <div class="col-sm-6 col-md-6 col-lg-4">
              <div class="service-item">
                <div class="service__icon"><a class="navbar-brand" href="#">
                    <img src="<?= \Yii::$app->request->baseUrl . "/uploads/organisasi/" . $organisasi->foto; ?>" class="logo-light" alt="foto">

                  </a></div>
                <div class="service__content">
                  <h4 class="service__title"><?= $organisasi->nama ?></h4>
                  <h6 class="service__title"><?= $organisasi->jabatan ?></h6>
                  <p class="service__desc"><?= $organisasi->quotes ?></p>
                  <a href="#" class="btn btn__white">
                    <!-- <span>Read More</span><i class="icon-arrow-right"></i> -->
                  </a>
                </div>
              </div><!-- /.service-item -->
            </div><!-- /.col-lg-4 -->
          <?php } ?>
        </div><!-- /.row -->

      </div><!-- /.container -->
    </section><!-- /.Services -->
    <!-- =========================== 
      fancybox Carousel
    ============================= -->
    <section id="fancyboxCarousel" class="fancybox-layout4 fancybox-carousel bg-overlay bg-overlay-gradient-secondary-2">
      <div class="bg-img"><img src="<?= \Yii::$app->request->BaseUrl ?>/template/assets/images/backgrounds/5.jpg" alt="background"></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 offset-lg-3">
            <div class="heading text-center mb-40">
              <!-- <span class="heading__subtitle">Our Features</span> -->
              <h2 class="heading__title color-white">LEMBAGA PENERIMA WAKAF KAMI</h2>
              <!-- <p class="heading__desc">We continue to pursue that same vision in today's complex, uncertain world,
                working every day to earn our customers’ trust!</p> -->
            </div><!-- /.heading -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="carousel owl-carousel carousel-arrows" data-slide="4" data-slide-md="2" data-slide-sm="1" data-autoplay="true" data-nav="true" data-dots="false" data-space="20" data-loop="true" data-speed="800">
              <!-- fancybox item #1 -->
              <?php foreach ($lembagas as $lembaga) { ?>
                <div class="fancybox-item">
                  <div class="fancybox__icon">
                    <a class="navbar-brand" href="#">
                      <img src="<?= \Yii::$app->request->baseUrl . "/uploads/lembaga_penerima/" . $lembaga->foto; ?>" class="logo-light" alt="foto">

                    </a>
                  </div><!-- /.fancybox-icon -->
                  <div class="fancybox__content">
                    <!-- <h4 class="fancybox__title">Transparent Pricing</h4> -->
                    <!-- <p class="fancybox__desc">International supply chains involves challenging regulations.</p> -->
                  </div><!-- /.fancybox-content -->
                </div><!-- /.fancybox-item -->
              <?php } ?>
            </div><!-- /.carousel -->
          </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section><!-- /.fancybox Carousel -->

    <!-- ========================
        Request Quote Tabs
    =========================== -->
    <?php

    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    ?>
    <section id="requestQuoteTabs" class="request-quote request-quote-tabs p-0">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="request__form">
              <nav class="nav nav-tabs">
                <!-- <a class="nav__link active" data-toggle="tab" href="#quote">Request A Quote</a>
                <a class="nav__link" data-toggle="tab" href="#track">Track & Trace</a> -->
              </nav>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="quote">
                  <div class="request-quote-panel">
                    <div class="request__form-body">
                      <div class="row">

                        <div class="contact-form">

                          <?php $form = ActiveForm::begin(
                            [
                              'id' => 'HubungiKami',
                              'layout' => 'horizontal',
                              'enableClientValidation' => true,
                              'errorSummaryCssClass' => 'error-summary alert alert-error'
                            ]
                          );
                          ?>
                          <div class="form-row">

                            <div class="col-12 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'nama', [
                                  'template' => '
            {label}
            {input}
            {error}
        ',
                                  'inputOptions' => [
                                    'class' => 'form-control'
                                  ],
                                  'labelOptions' => [
                                    'class' => ''
                                  ],
                                  'options' => ['tag' => false]
                                ])->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>
                              </div>
                            </div>
                            <div class="col-12 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'nomor_hp', [
                                  'template' => '
            {label}
            {input}
            {error}
        ',
                                  'inputOptions' => [
                                    'class' => 'form-control'
                                  ],
                                  'labelOptions' => [
                                    'class' => ''
                                  ],
                                  'options' => ['tag' => false]
                                ])->textInput(['maxlength' => true, 'placeholder' => 'Nomor Handphone']) ?>
                              </div>
                            </div>
                            <div class="col-12 col-md-4">
                              <div class="form-group">
                                <?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
                                $form->field($model, 'tema_hubungi_kami_id', [
                                  'template' => '
      {label}
      {input}
      {error}
  ',
                                  'inputOptions' => [
                                    'class' => 'form-control'
                                  ],
                                  'labelOptions' => [
                                    'class' => ''
                                  ],
                                  'options' => ['tag' => false]
                                ])->dropDownList(
                                  \yii\helpers\ArrayHelper::map(app\models\TemaHubungiKami::find()->all(), 'id', 'nama_tema'),
                                  [
                                    'prompt' => 'Select',
                                    'disabled' => (isset($relAttributes) && isset($relAttributes['tema_hubungi_kami_id'])),
                                  ]
                                ); ?>
                              </div>
                            </div>
                            <?php echo $form->errorSummary($model); ?>

                            <div class="col-12 text-center">
                              <?= Html::submitButton('<i class="fa fa-save"></i> Simpan', ['class' => 'btn btn-primary']); ?>
                            </div>
                          </div>

                          <?php ActiveForm::end(); ?>
                          <div class="contact-form-result"></div>
                        </div>
                      </div>
                    </div><!-- /.request__form-body -->
                    <div class="widget widget-download bg-theme" style="background-color: orange !important;">
                      <div class="widget__content">
                        <h5>HUBUNGI KAMI</h5>
                        <p>Ingin Menyapa?Ingin tahu lebih banyak tentang kami?Hubungi kami atau kiriman email kepada kami,dari kami akan segera menghubungi Anda Kembali</p>
                        <!-- <a href="#" class="btn btn__secondary btn__hover2 btn__block">
                          <span>Download 2019 Brochure</span><i class="icon-arrow-right"></i>
                        </a> -->
                      </div><!-- /.widget__content -->
                    </div><!-- /.widget-download -->
                  </div><!-- /.request-quote-panel-->
                </div><!-- /.tab -->
              </div><!-- /.tab-content -->
            </div><!-- /.request-form -->
          </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section><!-- /.Request Quote Tabs -->

    <!-- ========================= 
            Testimonial #1
    =========================  -->
    <section id="testimonial" class="testimonial testimonial-1 text-center pt-80 pb-70">
      <div class="bg-img"><img src="<?= \Yii::$app->request->BaseUrl ?>/template/assets/images/backgrounds/2.png" alt="background"></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 offset-lg-3">
            <div class="heading mb-50">
              <span class="heading__subtitle">What Peoples Say!</span>
              <h2 class="heading__title">Testimonials</h2>
            </div><!-- /.heading -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-10 offset-lg-1">
            <div class="carousel owl-carousel carousel-arrows carousel-dots" data-slide="1" data-slide-md="1" data-slide-sm="1" data-autoplay="true" data-nav="true" data-dots="true" data-space="0" data-loop="true" data-speed="800">
              <!-- Testimonial #1 -->
              <?php foreach($testimonials as $testi) { ?>
              <div class=" testimonial-item">
                <div class="testimonial__thumb">
                  <img src="<?= \Yii::$app->request->BaseUrl . "/uploads/testimonials/" . $testi->gambar?>"alt="author thumb">
                </div><!-- /.testimonial-thumb -->
                <div class="testimonial__content">
                  <p class="testimonial__desc"><?= $testi->isi ?></p>
                </div><!-- /.testimonial-content -->
                <div class="testimonial__meta">
                  <p><?= $testi->nama ?></p>
                  <p class="testimonial__meta-desc"><?= $testi->jabatan ?></p>
                </div><!-- /.testimonial-meta -->
              </div><!-- /. testimonial-item -->
             <?php } ?>
            </div>
          </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section><!-- /.testimonial1 -->

    <!-- =====================
       Clients 1
    ======================== -->
    <section id="clients1" class="clients clients-1 border-top">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">

          </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section><!-- /.clients 1 -->

    <!-- ======================
           banner 3
      ========================= -->

    <!-- ======================
      Blog Grid
    ========================= -->

    <!-- ========================= 
            contact 1
      =========================  -->


    <!-- ========================
            Footer
    ========================== -->

    <?= $this->render('component/footer') ?>

    <div class="module__search-container">
      <i class="fa fa-times close-search"></i>
      <form class="module__search-form">
        <input type="text" class="search__input" placeholder="Type Words Then Enter">
        <button class="module__search-btn"><i class="fa fa-search"></i></button>
      </form>
    </div><!-- /.module-search-container -->

    <button id="scrollTopBtn"><i class="fa fa-long-arrow-up"></i></button>
  </div><!-- /.wrapper -->

  <script src="<?= \Yii::$app->request->BaseUrl ?>/template/assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?= \Yii::$app->request->BaseUrl ?>/template/assets/js/plugins.js"></script>
  <script src="<?= \Yii::$app->request->BaseUrl ?>/template/assets/js/main.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV6HOHjE9XM8IbEaL6ZMZdW8e0tavsOL8&libraries=places&region=id&language=en&sensor=false"></script>

  <script>
    var marker;

    function initialize() {

      // Variabel untuk menyimpan informasi (desc)
      var infoWindow = new google.maps.InfoWindow;

      //  Variabel untuk menyimpan peta Roadmap
      var mapOptions = {
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }

      // Pembuatan petanya
      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

      // Variabel untuk menyimpan batas kordinat
      var bounds = new google.maps.LatLngBounds();

      // Pengambilan data dari database
      <?php

      $nama = $setting->nama_web;
      $lat = $setting->latitude;
      $lon = $setting->longitude;

      echo ("addMarker($lat, $lon, '<b>$nama</b>');\n");

      ?>

      // Proses membuat marker 
      function addMarker(lat, lng, info) {
        var lokasi = new google.maps.LatLng(lat, lng);
        bounds.extend(lokasi);
        var marker = new google.maps.Marker({
          map: map,
          position: lokasi
        });
        map.fitBounds(bounds);
        bindInfoWindow(marker, map, infoWindow, info);
      }

      // Menampilkan informasi pada masing-masing marker yang diklik
      function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
          infoWindow.setContent(html);
          infoWindow.open(map, marker);
        });
      }

    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
</body>

</html>