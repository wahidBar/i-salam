<?php

$setting = app\models\Setting::find()->one();
$icons = \Yii::$app->request->baseUrl . "/uploads/setting/" . $setting->logo;
$categories = app\models\KategoriBerita::find()->all();
$kategori_pendanaans = app\models\KategoriPendanaan::find()->all();
?>
<style>
  .navbar .nav__item .nav__item-link {
    color: #282828;
    line-height: 30px !important;
    padding-left: 15px;
    margin-left: -10px;
    ;
  }
</style>
<header id="header" class="header header-transparent">
  <nav class="navbar navbar-expand-lg sticky-navbar">
    <div class="container">
      <a href="<?= Yii::$app->request->baseUrl ?>">
        <img src="<?= $icons ?>" class="logo-header logo-light" alt="logo">
        <img src="<?= $icons ?>" class="logo-header logo-dark" alt="logo">
      </a>
      <button class="navbar-toggler" type="button">
        <span class="menu-lines"><span></span></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavigation">
        <ul class="navbar-nav ml-auto">
          <li class="nav__item">
            <a href="<?= Yii::$app->request->baseUrl ?>" class="nav__item-link">Home</a>
          </li><!-- /.nav-item -->
          <!-- <li class="nav__item">
            <a href="<?= Yii::$app->request->baseUrl . "/home/ziswaf" ?>" class="nav__item-link">Ziswaf</a>
          </li> -->
          <!-- /.nav-item -->
          <li class="nav__item">
            <a href="<?= Yii::$app->request->baseUrl . "/home/program" ?>" class="nav__item-link">Wakaf</a>
          </li>
          <li class="nav__item">
            <a href="<?= Yii::$app->request->baseUrl . "/home/news" ?>" class="nav__item-link">Berita</a>
          </li>
          <!-- <li class="nav__item with-dropdown">
            <a href="<?= \Yii::$app->request->baseUrl . "/home/news/" ?>" class="dropdown-toggle nav__item-link">
              <div class="d-none d-lg-block">
                Berita <i class="fa fa-angle-down"></i>
              </div>
              <div class="d-none d-md-block d-sm-block d-block d-lg-none">
                Berita</i>
              </div>
            </a>
            <i class="fa fa-angle-right" data-toggle="dropdown"></i>
            <ul class="dropdown-menu">              
              <?php foreach ($categories as $kategori) {  ?>
                <li class="nav__item"><a href="<?= \Yii::$app->request->baseUrl . "/home/news?kategori=" . $kategori->nama ?>" class="nav__item-link text-dark"><?= $kategori->nama ?></a></li>
              <?php } ?>
            </ul>
          </li> -->
          <!-- <li class="nav__item with-dropdown">
            <a href="<?= \Yii::$app->request->baseUrl . "/home#" ?>" class="dropdown-toggle nav__item-link">
              <div class="d-none d-lg-block">
                Layanan <i class="fa fa-angle-down"></i>
              </div>
              <div class="d-none d-md-block d-sm-block d-block d-lg-none">
                Layanan</i>
              </div>
            </a>
            <i class="fa fa-angle-right" data-toggle="dropdown"></i>
            <ul class="dropdown-menu">
              <li class="nav__item"><a href="<?= \Yii::$app->request->baseUrl . "/home/rekening" ?>" class="nav__item-link text-dark">Daftar Rekening</a></li>

              <li class="nav__item"><a href="<?= \Yii::$app->request->baseUrl . "/home/report" ?>" class="nav__item-link text-dark">Anual Report</a></li>

            </ul>
          </li> -->
          <li class="nav__item">
            <a href="<?= Yii::$app->request->baseUrl . "/home/report" ?>" class="nav__item-link">Layanan</a>
          </li>
          <li class="nav__item with-dropdown">
            <a href="<?= \Yii::$app->request->baseUrl . "/home#" ?>" class="dropdown-toggle nav__item-link">
              <div class="d-none d-lg-block">
                Tentang Kami <i class="fa fa-angle-down"></i>
              </div>
              <div class="d-none d-md-block d-sm-block d-block d-lg-none">
                Tentang Kami</i>
              </div>
            </a>
            <i class="fa fa-angle-right" data-toggle="dropdown"></i>
            <ul class="dropdown-menu">
              <li class="nav__item"><a href="<?= \Yii::$app->request->baseUrl . "/home/visi" ?>" class="nav__item-link text-dark">Visi Misi</a></li>

              <li class="nav__item"><a href="<?= \Yii::$app->request->baseUrl . "/home/organisasi" ?>" class="nav__item-link text-dark">Organisasi</a></li>

              <li class="nav__item"><a href="<?= \Yii::$app->request->baseUrl . "/home/kontak" ?>" class="nav__item-link text-dark">Kontak</a></li>

            </ul>
          </li>
          <?php if (Yii::$app->user->identity->id == null) { ?>
            <!-- <li class="nav__item">
              <a href="<?= Yii::$app->request->baseUrl . "/site/login" ?>" class="nav__item-link" style="color: black;">Login</a>
            </li> -->
            <li class="nav__item">
              <a id="btn-login" class="nav__item-link" style="color: black;">Login</a>
            </li>
            <li class="nav__item">
              <a id="btn-registrasi" class="nav__item-link" style="color: black;">Daftar</a>
            </li>
          <?php } else { ?>
            <li class="nav__item">
              <a href="<?= Yii::$app->request->baseUrl . "/home/profile" ?>" class="nav__item-link" style="color: black;">Akun Saya</a>
            </li><!-- /.nav-item -->
            <li class="nav__item">
              <a href="<?= Yii::$app->request->baseUrl . "/site/logout" ?>" class="nav__item-link" style="color: black;">Logout</a>
            </li><!-- /.nav-item -->
          <?php } ?>

          <?php if (Yii::$app->user->identity->role_id == 1) { ?>

            <li class="nav__item">
            <a href="<?= Yii::$app->request->baseUrl . "/site/index" ?>" class="nav__item-link" style="color: black;">Halaman Admin</a>
            </li>
          <?php } ?>
        </ul><!-- /.navbar-nav -->
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navabr -->
</header><!-- /.Header -->