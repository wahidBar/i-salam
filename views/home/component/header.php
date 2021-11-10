<?php 
 $setting = app\models\Setting::find()->one();
$icons = \Yii::$app->request->baseUrl . "/uploads/setting/" . $setting->logo;
?>
<header id="header" class="header header-transparent">
      <nav class="navbar navbar-expand-lg sticky-navbar">
        <div class="container">
          <a  href="<?=Yii::$app->request->baseUrl?>">
            <img src="<?= $icons ?>" style="width:65px;height:65px; margin-left:7px;" class="logo-light" alt="logo">
            <img src="<?= $icons ?>" style="width:65px;height:65px; margin-left:7px;" class="logo-dark" alt="logo">
          </a>
          <button class="navbar-toggler" type="button">
            <span class="menu-lines"><span></span></span>
          </button>
          <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav ml-auto">
            <li class="nav__item">
                <a href="<?=Yii::$app->request->baseUrl?>" class="nav__item-link active">HOME</a>
              </li><!-- /.nav-item -->
              <li class="nav__item">
                <a href="<?=Yii::$app->request->baseUrl . "/program" ?>" class="nav__item-link">PROGRAM</a>
              </li><!-- /.nav-item -->
              <li class="nav__item">
                <a href="<?=Yii::$app->request->baseUrl . "/news" ?>" class="nav__item-link">NEWS</a>
              </li><!-- /.nav-item -->
              <li class="nav__item">
                <a href="<?=Yii::$app->request->baseUrl . "/about" ?>" class="nav__item-link">ABOUT US</a>
              </li><!-- /.nav-item -->
            </ul><!-- /.navbar-nav -->
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
      </nav><!-- /.navabr -->
    </header><!-- /.Header -->