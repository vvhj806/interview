<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
    <title>HIGHBUFF interview</title>
    <!-- 아이콘 폰트 -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/fonts/line-awesome/1.1/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- design -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/layout.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <?php
    $aUni = $data['uniUrl'];
    if ($data['page'] == '/'  || in_array($data['page'], $aUni)) : //대학교
        //메인에서만 보이게
    ?>
        <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/main.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <?php elseif ($data['page'] == '/splash') :
        // 스플레시에서만 보이게 앱 미구현
    ?>
        <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/splash.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/animated.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/common.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/sub.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <!-- dev -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/dev.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">
    <!-- jQuery -->
    <script src="<?= $data['url']['menu'] ?>/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery.easing -->
    <script src="<?= $data['url']['menu'] ?>/plugins/jquery.easing/jquery.easing.min.js"></script>
    <!-- jquery-validation -->
    <script src="<?= $data['url']['menu'] ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <!-- 공용JS -->
    <script src="<?= $data['url']['menu'] ?>/static/www/js/function.js"></script>
    <!-- 카테고리JS -->
    <script src="<?= $data['url']['menu'] ?>/static/www/js/category.js"></script>
    <!-- design -->
    <?php if ($data['page'] == '/'  || in_array($data['page'], $aUni)) : //대학교
        //메인에서만 보이게
    ?>
        <script src="<?= $data['url']['menu'] ?>/static/www/js/main.js"></script>
    <?php else :
        // 스플레시에서만 보이게 앱 미구현
    ?>
        <script src="<?= $data['url']['menu'] ?>/static/www/js/layout.js"></script>
    <?php endif; ?>
    <!-- bowser -->
    <script src="<?= $data['url']['menu'] ?>/plugins/bowser/bundled.js"></script>

    <?php if ($data['use']['lodash']) : ?>
        <!-- lodash -->
        <script src="<?= $data['url']['menu'] ?>/plugins/lodash/lodash.min.js"></script>
    <?php endif; ?>
    <?php if ($data['use']['socketIo']) : ?>
        <?php
        //integrity 해시 생성 - 해시 생성방법 잘못됨(수정필요)
        //$integrity = 'sha384-' . base64_encode(hash('sha384', "https://localinterviewr.highbuff.com/plugins/socketio/socket.io.min.js", true));
        //script, link 태그 속성으로 integrity 속성 처리시 위변조 방지
        //integrity="" crossorigin="anonymous"
        ?>

        <!-- socket io -->
        <script src="<?= $data['url']['menu'] ?>/plugins/socketio/socket.io.min.js"></script>
        <script src="<?= $data['url']['menu'] ?>/plugins/socketio/socketio_custom.js"></script>
    <?php endif; ?>
    <?php if ($data['use']['fileUpload']) : ?>
        <!-- file upload -->
        <script src="<?= $data['url']['menu'] ?>/plugins/fileupload/fileupload.js"></script>
    <?php endif; ?>
    <!-- 체크버튼 -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/switch/lc_switch.css">
    <script src="<?= $data['url']['menu'] ?>/plugins/switch/lc_switch.js"></script>
    <!-- 슬라이드 -->
    <link rel="stylesheet" href="<?= $data['url']['menu'] ?>/plugins/slick/slick.css">
    <script src="<?= $data['url']['menu'] ?>/plugins/slick/slick.js"></script>
    <!-- 모달 -->
    <script src="<?= $data['url']['menu'] ?>/plugins/modal/moaModal.minified.js"></script>
    <script src="<?= $data['url']['menu'] ?>/plugins/modal/Sweefty.js"></script>
    <?php
    /*
        * http://dean.edwards.name/packer/
        var userInfo = {};
        userInfo.bowser = bowser.parse(window.navigator.userAgent);
        userInfo.isLogin = '<?= $data['session']['idx'] ? 'Y' : 'N' ?>';
        */
    ?>
    <script>
        //internet explorer check
        <?php if (($data['browser']['permission'] ?? true)) : // ie접근제한 경고 주석
        ?>
            if ((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (navigator.userAgent.toLowerCase().indexOf("msie") != -1)) {
                alert('인터넷 익스플로러는 지원하지 않습니다. 크롬 브라우저를 사용해주세요. 문의사항은 카카오톡 채널 [하이버프 인터뷰]로 부탁드립니다.');
            }
        <?php endif; ?>

        eval(function(p, a, c, k, e, r) {
            e = String;
            if (!''.replace(/^/, String)) {
                while (c--) r[c] = k[c] || c;
                k = [function(e) {
                    return r[e]
                }];
                e = function() {
                    return '\\w+'
                };
                c = 1
            };
            while (c--)
                if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
            return p
        }('2 0={};0.1=1.3(4.5.6);0.7=\'8\';', 9, 9, 'userInfo|bowser|var|parse|window|navigator|userAgent|isLoginYN|<?= $data['session']['idx'] ? 'Y' : 'N' ?>'.split('|'), 0, {}))
    </script>
</head>

<body class="<?= $data['class']['body'] ?>">
    <!--s #wrap-->
    <div id="wrap">
        <div id='alert'></div>