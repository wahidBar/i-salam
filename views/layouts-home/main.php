<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */
// \app\assets\HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <?php
    $setting = \app\models\Setting::find()->one();
    ?>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="<?= $setting->nama_web ?>">
    <link href="<?= Yii::$app->urlManager->baseUrl . '/uploads/setting/' . $setting->logo ?>" rel="icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($setting->judul_web) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
    </script>
    <?php \app\assets\HomeAsset::register($this); ?>
    <script>
        var baseUrl = "<?= Yii::$app->urlManager->baseUrl ?>";
    </script>
    <?php $this->head() ?>
    <style>
        #modal-registrasi .modal-header .close {
            padding: 0;
            margin: 0;
        }

        #modal-registrasi {
            background: rgba(0, 0, 0, .65);
        }

        #modal-registrasi .modal-content,
        #modal-registrasi .modal-header {
            background: transparent;
            border: 0;
            border-radius: 0;
        }

        #modal-registrasi .modal-header,
        #modal-registrasi .modal-header h2 {
            color: #fff;
        }

        #modal-registrasi .modal-body {
            background: white;
            border-radius: 1.5rem;
            margin-bottom: 2rem;
        }

        #modal-registrasi .close {
            color: white;
        }


        #modal-login .modal-header .close {
            padding: 0;
            margin: 0;
        }

        #modal-login {
            background: rgba(0, 0, 0, .65);
        }

        #modal-login .modal-content,
        #modal-login .modal-header {
            background: transparent;
            border: 0;
            border-radius: 0;
        }

        #modal-login .modal-header,
        #modal-login .modal-header h2 {
            color: #fff;
        }

        #modal-login .modal-body {
            background: white;
            border-radius: 1.5rem;
            margin-bottom: 2rem;
        }

        #modal-login .close {
            color: white;
        }

        #modal-forgot .modal-header .close {
            padding: 0;
            margin: 0;
        }

        #modal-forgot {
            background: rgba(0, 0, 0, .65);
        }

        #modal-forgot .modal-content,
        #modal-forgot .modal-header {
            background: transparent;
            border: 0;
            border-radius: 0;
        }

        #modal-forgot .modal-header,
        #modal-forgot .modal-header h2 {
            color: #fff;
        }

        #modal-forgot .modal-body {
            background: white;
            border-radius: 1.5rem;
            margin-bottom: 2rem;
        }

        #modal-forgot .close {
            color: white;
        }

        #page-loader {
            background: #f8f8f8;
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 99999;
        }

        .page-loader__spin {
            width: 35px;
            height: 35px;
            position: absolute;
            top: 50%;
            left: 50%;
            border-top: 6px solid #222;
            border-right: 6px solid #222;
            border-bottom: 6px solid #222;
            border-left: 6px solid #f1a401;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            -webkit-animation: spinner 1000ms infinite linear;
            -moz-animation: spinner 1000ms infinite linear;
            -o-animation: spinner 1000ms infinite linear;
            animation: spinner 1000ms infinite linear;
            z-index: 100000;
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>
    <?php $this->beginBody() ?>
    <!-- <div id="page-loader">
        <div class="page-loader__inner">
            <div class="page-loader__spin"></div>
        </div>
    </div> -->
    <div class="wrapper">
        <?= $this->render('header') ?>
        <?= $this->render(
            'content.php',
            [
                'content' => $content,
            ]
        ) ?>
    </div>
    <?= $this->render('footer') ?>
    <button id="scrollTopBtn"><i class="fas fa-chevron-circle-up"></i></button>

    <?php $this->endBody() ?>
    <!-- <?php $this->registerJsFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyCV6HOHjE9XM8IbEaL6ZMZdW8e0tavsOL8&libraries=places&region=id&language=en&sensor=false"); ?> -->
</body>

<?php
\app\components\Modal::begin([
    'id' => 'modal-registrasi',
    'header' => '<div style=\'text-align:center;width:100%\'><h2 style="text-transform: inherit;"> iSalam</h2></div>'
]);
?>
<div id="modal-body"></div>
<?php \app\components\Modal::end() ?>

<?php
\app\components\Modal::begin([
    'id' => 'modal-login',
    'header' => '<div style=\'text-align:center;width:100%\'><h2 style="text-transform: inherit;"> iSalam</h2></div>'
]);
?>
<div id="modal-body2"></div>
<?php \app\components\Modal::end() ?>

<?php
\app\components\Modal::begin([
    'id' => 'modal-forgot',
    'header' => '<div style=\'text-align:center;width:100%\'><h2 style="text-transform: inherit;"> iSalam</h2></div>'
]);
?>
<div id="modal-body3"></div>
<?php \app\components\Modal::end() ?>

<script>
    var marker;

    <?php
    $lat = $setting->latitude;
    $lon = $setting->longitude;
    ?>
    var lat = <?php echo $lat ?>;
    var lng = <?php echo $lon ?>;
    var map = L.map("map-canvas").setView([lat, lng], 13);
    marker = L.marker([lat, lng]).addTo(map);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiZGVmcmluZHIiLCJhIjoiY2s4ZTN5ZjM0MDFrNzNsdG1tNXk2M2dlMSJ9.YXJM0PTu8PSsCCtYVjJNmw'
    }).addTo(map);
    var map2 = L.map("map-canvas2").setView([lat, lng], 13);
    marker2 = L.marker([lat, lng]).addTo(map2);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiZGVmcmluZHIiLCJhIjoiY2s4ZTN5ZjM0MDFrNzNsdG1tNXk2M2dlMSJ9.YXJM0PTu8PSsCCtYVjJNmw'
    }).addTo(map2);
</script>
<script>
    $(window).ready(() => {
        try {

            $('#btn-user-login').on('click', async () => {
                let response = await fetch("<?= Url::to(['/login'], false) ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                response = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, 'text/html');
                $("#modal-body2").html(response);
                // $("#modal-login").modal("show")
                $("#modal-login").attr("style", "padding-right: 17px; display: block;overflow:auto")
                $("#modal-login").attr("class", "fade modal show");
                document.querySelector("#modal-login .close").addEventListener("click", () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                })
                document.querySelector("#modal-login #btn-forgot").addEventListener("click", async () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                })
            });
            $('#btn-user-login2').on('click', async () => {
                let response = await fetch("<?= Url::to(['/login'], false) ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                response = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, 'text/html');
                $("#modal-body2").html(response);
                // $("#modal-login").modal("show")
                $("#modal-login").attr("style", "padding-right: 17px; display: block;overflow:auto")
                $("#modal-login").attr("class", "fade modal show");
                document.querySelector("#modal-login .close").addEventListener("click", () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                })
                document.querySelector("#modal-login #btn-forgot").addEventListener("click", async () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                })
            });
            $('#btn-user-registrasi').on('click', async () => {
                let response = await fetch("<?= Url::to(['/registrasi'], false) ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                response = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, 'text/html');
                $("#modal-body").html(response);
                // $("#modal-registrasi").modal("show")
                $("#modal-registrasi").attr("style", "padding-right: 17px; display: block;overflow:auto")
                $("#modal-registrasi").attr("class", "fade modal show");
                document.querySelector("#modal-registrasi .close").addEventListener("click", () => {
                    $("#modal-registrasi").removeAttr("style")
                    $("#modal-registrasi").attr("class", "fade modal");
                })
            });
            $('#btn-registrasi').on('click', async () => {
                let response = await fetch("<?= Url::to(['/registrasi'], false) ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                response = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, 'text/html');
                $("#modal-body").html(response);
                // $("#modal-registrasi").modal("show")
                $("#modal-registrasi").attr("style", "padding-right: 17px; display: block;overflow:auto")
                $("#modal-registrasi").attr("class", "fade modal show");
                document.querySelector("#modal-registrasi .close").addEventListener("click", () => {
                    $("#modal-registrasi").removeAttr("style")
                    $("#modal-registrasi").attr("class", "fade modal");
                })
            });

            $('#btn-login').on('click', async () => {
                let response = await fetch("<?= Url::to(['/login'], false) ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                response = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, 'text/html');
                $("#modal-body2").html(response);
                // $("#modal-login").modal("show")
                $("#modal-login").attr("style", "padding-right: 17px; display: block;overflow:auto")
                $("#modal-login").attr("class", "fade modal show");
                document.querySelector("#modal-login .close").addEventListener("click", () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                })
                document.querySelector("#modal-login #btn-forgot").addEventListener("click", async () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                    let response = await fetch("<?= Url::to(['/site/lupa-password'], false) ?>", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    response = await response.text();
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(response, 'text/html');
                    console.log(response)
                    $("#modal-body3").html(response);
                    $("#modal-forgot").attr("style", "padding-right: 17px; display: block;overflow:auto")
                    $("#modal-forgot").attr("class", "fade modal show");
                    document.querySelector("#modal-forgot .close").addEventListener("click", () => {
                        $("#modal-forgot").removeAttr("style")
                        $("#modal-forgot").attr("class", "fade modal");
                    })
                    document.querySelector("#modal-login #btn-forgot").addEventListener("click", () => {
                        $("#modal-login").attr("class", "fade modal");
                    })

                })
            });
            $('#btn-user-login-header').on('click', async () => {
                let response = await fetch("<?= Url::to(['/login'], false) ?>", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                response = await response.text();
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, 'text/html');
                $("#modal-body2").html(response);
                // $("#modal-login").modal("show")
                $("#modal-login").attr("style", "padding-right: 17px; display: block;overflow:auto")
                $("#modal-login").attr("class", "fade modal show");
                document.querySelector("#modal-login .close").addEventListener("click", () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                })
                document.querySelector("#modal-login #btn-forgot").addEventListener("click", async () => {
                    $("#modal-login").removeAttr("style")
                    $("#modal-login").attr("class", "fade modal");
                    let response = await fetch("<?= Url::to(['/site/lupa-password'], false) ?>", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    response = await response.text();
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(response, 'text/html');
                    console.log(response)
                    $("#modal-body3").html(response);
                    $("#modal-forgot").attr("style", "padding-right: 17px; display: block;overflow:auto")
                    $("#modal-forgot").attr("class", "fade modal show");
                    document.querySelector("#modal-forgot .close").addEventListener("click", () => {
                        $("#modal-forgot").removeAttr("style")
                        $("#modal-forgot").attr("class", "fade modal");
                    })
                    document.querySelector("#modal-login #btn-forgot").addEventListener("click", () => {
                        $("#modal-login").attr("class", "fade modal");
                    })

                })
            });

        } catch (error) {
            console.log(error)
        }
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dropdown-submenu a.test').on("click", function(e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
    // $(window).on("load", function() {
    //     $("#page-loader").fadeOut("slow");
    // });
</script>

</html>
<?php $this->endPage() ?>