<?php
// 작업 후 옮기기
#GOOGLE 22.05.13 완료
define('GOOGLE_CLIENT_ID', '485316476575-4ocd3pbjtm27vgn7uma0u21b9lr054ig.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/google/web/leave');
#KAKAO 21.06.02 완료
define('KAKAO_CLIENT_ID', 'c622851e95a98fbe13ba6a94d0598a5b');
define('KAKAO_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/kakao/web/leave');
#NAVER 21.06.03 완료
define('NAVER_CLIENT_ID', 'xgw7omXoMTrWdMLU9cw2');
define('NAVER_CLIENT_SECRET', 'Xd1WE28MgA');
define('NAVER_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/naver/web/leave');
#APPLE 21.06.02 완료
define('APPLE_CLIENT_ID', 'interview.bluevisor.com');
define('APPLE_CLIENT_SECRET', '6LFD4FPL6S');
define('APPLE_REDIRECT_URI', 'https://api.highbuff.com/interview/20/leave_auth.php');
?>

<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">회원탈퇴</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <?php if ($data['sns'] == '' || $data['sns'] == null) : ?>
        <!--s contBox-->
        <div class="cont cont_pd_bottom">
            <!--s bigtlt-->
            <div class="bigtlt b c">
                본인 확인을 위해<br />
                <span class="point">비밀번호</span>를 입력해주세요
            </div>
            <!--e bigtlt-->

            <form id="frm" method="POST" action="/my/leave/password/action">
                <?= csrf_field() ?>
                <input type="hidden" name="postCase" value="check_password">
                <input type="hidden" name="backUrl" value="/my/leave">
                <input type="password" name="password" class="wps_100" maxlength="20" placeholder="비밀번호 입력">

                <!--s BtnBox-->
                <div class="BtnBox">
                    <button type="submit" id="confirm" class="btn btn01 wps_100">확인</button>
                </div>
                <!--e BtnBox-->
            </form>
        </div>
        <!--e contBox-->
    <?php else : ?>
        <!--s contBox-->
        <div class="cont cont_pd_bottom">
            <!--s bigtlt-->
            <div class="bigtlt b c">
                SNS 계정탈퇴를 위해<br />
                하단의 <span class="point"> SNS 본인인증</span> 버튼을 눌러<br />
                본인인증을 해주세요.
            </div>
            <!--e bigtlt-->

            <?php if ($data['sns'] == 'G') : ?>
                <div class="kakaoBtn2 c">
                    <a href="javascript:void(0)" onclick="google()" class="googleBtn"><span class="icon"><img src="/static/www/img/sub/sns_google.png"></span>구글 SNS 본인인증</a>
                </div>
            <?php elseif ($data['sns'] == 'K') : ?>
                <div class="kakaoBtn2 c">
                    <a href="javascript:void(0)" onclick="kakao()"><span class="icon"><img src="/static/www/img/sub/kakao_icon.png"></span>카카오 SNS 본인인증</a>
                </div>
            <?php elseif ($data['sns'] == 'N') : ?>
                <div class="kakaoBtn2 c">
                    <a href="javascript:void(0)" onclick="naver()" class="naverBtn"><span class="icon"><img src="/static/www/img/sub/sns_naver.png"></span>네이버 SNS 본인인증</a>
                </div>
            <?php elseif ($data['sns'] == 'A') : ?>
                <div class="kakaoBtn2 c">
                    <a href="javascript:void(0)" onclick="apple()" class="appleBtn"><span class="icon"><img src="/static/www/img/sub/sns_apple.png"></span>Apple SNS 본인인증</a>
                </div>
            <?php endif; ?>
        </div>
        <!--e contBox-->
    <?php endif; ?>
</div>
<!--e #scontent-->

<script>
    let broswerInfo = navigator.userAgent;
    var apple_login_url = "<?= 'https://appleid.apple.com/auth/authorize?response_type=code&response_mode=form_post&client_id=' . APPLE_CLIENT_ID . '&redirect_uri=' . urlencode(APPLE_REDIRECT_URI) . '&scope=name%20email' ?>";
    var kakao_login_url = "<?= 'https://kauth.kakao.com/oauth/authorize?client_id=' . KAKAO_CLIENT_ID . '&redirect_uri=' . urlencode(KAKAO_REDIRECT_URI) . '&response_type=code'; ?>";
    var naver_login_url = "<?= 'https://nid.naver.com/oauth2.0/authorize?client_id=' . NAVER_CLIENT_ID . '&response_type=code&redirect_uri=' . urlencode(NAVER_REDIRECT_URI) . '&state=RAMDOM_STATE' ?>";
    var google_login_url = "<?= 'https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&scope=profile%20email&redirect_uri=' . urlencode(GOOGLE_REDIRECT_URI) . '&state=highbuff&nonce=1' ?>";

    $(function() {
        $("form").on("submit", function(event) {
            event.preventDefault();

            if ($('input[name="password"]').val().length < 2) {
                return alert('비밀번호를 8자리 이상 입력해주세요.');
            }

            this.submit();
        });
    });

    function kakao() {
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.kakao_login("leave");
        } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.kakao_leave.postMessage("");
        } else {
            window.open(kakao_login_url, '_blank', 'width=480,height=640');
            return false;
        }
    }

    function apple() {
        if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.apple_leave.postMessage("");
        } else if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            location.href = apple_login_url;
        } else {
            location.href = apple_login_url;
        }
    }

    function google() {
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.google_login("leave");
        } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.google_leave.postMessage("");
        } else {
            window.open(google_login_url, '_blank', 'width=480,height=640');
            return false;
        }
    }

    function naver() {
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.naver_login("leave");
        } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.naver_leave.postMessage("");
        } else {
            window.open(naver_login_url, '_blank', 'width=480,height=640');
            return false;
        }
    }
</script>