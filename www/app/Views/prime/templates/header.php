<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HIGHBUFF admin</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/font-awesome/5.8.2/css/all.min.css" />
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/fonts/line-awesome/1.1.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/prime/css/adminlte.min.css">
    <!-- design -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/prime/css/layout.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <!-- dev style -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/prime/css/dev.css">
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?= $data['url']['menu'] ?>/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery Ui -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- jquery-validation -->
    <script src="<?= $data['url']['menu'] ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script>
        const csrfName = '<?= csrf_token() ?>';
    </script>
    <!-- 공용JS -->
    <script src="<?= $data['url']['menu'] ?>/static/prime/js/function.js"></script>
    <!-- 카테고리JS -->
    <script src="<?= $data['url']['menu'] ?>/static/www/js/category.js"></script>
    <!-- bowser -->
    <script src="<?= $data['url']['menu'] ?>/plugins/bowser/bundled.js"></script>

    <script src="<?= $data['url']['menu'] ?>/static/prime/js/layout.js"></script>
    <?php
    //bowser.js 사용법
    // var info = bowser.parse(window.navigator.userAgent);
    // console.log(info)
    ?>
    <!-- Bootstrap 4 -->
    <script src="<?= $data['url']['menu'] ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= $data['url']['menu'] ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= $data['url']['menu'] ?>/plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= $data['url']['menu'] ?>/static/prime/js/adminlte.min.js"></script>
    <!-- common App -->
    <script src="<?= $data['url']['menu'] ?>/static/prime/js/common.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="<?= $data['url']['menu'] ?>/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= $data['url']['menu'] ?>/static/prime/js/pages/dashboard.js"></script>
    <!-- ckeditor  -->
    <script src="<?= $data['url']['menu'] ?>/plugins/ckeditor/ckeditor.js"></script>

    <!-- 슬라이드 -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/slick/slick.css">
    <script src="<?= $data['url']['menu'] ?>/plugins/slick/slick.js"></script>
</head>

<body class="navi_body <?= $data['page'] === 'prime/main' ? 'contBg' : '' ?>" style='position: relative;'>
    <div id="wrap">
        <div id="container_wrap">