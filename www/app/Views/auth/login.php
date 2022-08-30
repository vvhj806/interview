<?php
#localinterviewr에 테스트 22.05.10
#테스트 후 php 파일 따로 빼서 만들기

// #GOOGLE 22.05.13 완료
// define('GOOGLE_CLIENT_ID', '265440924719-5a242gqtatmolvgino9l4vtr7jpnnq2u.apps.googleusercontent.com');
// define('GOOGLE_CLIENT_SECRET', 'lXPgmBWQO3QUuLcoddTK9ifp');
define('GOOGLE_CLIENT_ID', '485316476575-4ocd3pbjtm27vgn7uma0u21b9lr054ig.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/google/web/call');

#KAKAO 21.06.02 완료
define('KAKAO_CLIENT_ID', 'c622851e95a98fbe13ba6a94d0598a5b');
define('KAKAO_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/kakao/web/call');

#NAVER 21.06.03 완료
define('NAVER_CLIENT_ID', 'xgw7omXoMTrWdMLU9cw2');
define('NAVER_CLIENT_SECRET', 'Xd1WE28MgA');
define('NAVER_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/naver/web/call');

#APPLE 21.06.02 완료
define('APPLE_CLIENT_ID', 'interview.bluevisor.com');
define('APPLE_CLIENT_SECRET', '6LFD4FPL6S');
// define('APPLE_REDIRECT_URI', 'https://' . $_SERVER["HTTP_HOST"] . '/sns/apple/web/call');
define('APPLE_REDIRECT_URI', 'https://api.highbuff.com/interview/20/call_back.php');
?>

<script>
    let broswerInfo = navigator.userAgent;
    //sns로그인 주소
    let inputMustName = {
        'id': {
            'msg': '아이디는 필수 입니다.'
        },
        'password': {
            'msg': '패스워드는 필수 입니다.'
        }
    };

    var apple_login_url = "<?= 'https://appleid.apple.com/auth/authorize?response_type=code&response_mode=form_post&client_id=' . APPLE_CLIENT_ID . '&redirect_uri=' . urlencode(APPLE_REDIRECT_URI) . '&scope=name%20email' ?>";
    var kakao_login_url = "<?= 'https://kauth.kakao.com/oauth/authorize?client_id=' . KAKAO_CLIENT_ID . '&redirect_uri=' . urlencode(KAKAO_REDIRECT_URI) . '&response_type=code'; ?>";
    var naver_login_url = "<?= 'https://nid.naver.com/oauth2.0/authorize?client_id=' . NAVER_CLIENT_ID . '&response_type=code&redirect_uri=' . urlencode(NAVER_REDIRECT_URI) . '&state=RAMDOM_STATE' ?>";
    var google_login_url = "<?= 'https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&scope=profile%20email&redirect_uri=' . urlencode(GOOGLE_REDIRECT_URI) . '&state=highbuff&nonce=1' ?>";

    $(function() {
        $("#frm").on("submit", function(event) {
            event.preventDefault();
            let msg = [];
            let ck = false;
            let data = {};
            $.each(inputMustName, function(k, v) {
                if (!$('input[name="' + k + '"]').val() && msg.length == 0) {
                    msg.push(v.msg);
                    ck = true;
                } else {
                    data[k] = $('input[name="' + k + '"]').val();
                }
            });
            if (ck) {
                alert(msg);
                return;
            }
            this.submit();
        });
    });

    function kakao() {
        // alert('서비스 준비중 입니다.');
        // return false;
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.kakao_login("login");
        } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.kakao_login.postMessage("login");
        } else {
            window.open(kakao_login_url, '_blank', 'width=480,height=640');
            return false;
        }
    }

    function apple() {
        if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.apple_login.postMessage("login");
        } else if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            location.href = apple_login_url;
        } else {
            location.href = apple_login_url;
        }
    }

    function google() {
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.google_login("login");
        } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.google_login.postMessage("login");
        } else {
            window.open(google_login_url, '_blank', 'width=480,height=640');
            return false;
        }
    }

    function naver() {
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.naver_login("login");
        } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.naver_login.postMessage("login");
        } else {
            window.open(naver_login_url, '_blank', 'width=480,height=640');
            return false;
        }
    }
</script>

<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">로그인</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="contBox">
        <!--s loginBox-->
        <div class="loginBox">
            <!--s tabs-->
            <ul class="logtab wd_2 mg_t0 mg_b60 c">
                <li class="on" rel="tab1"><a href="javascript:void(0)">일반회원</a></li>
                <li rel="tab2"><a href="javascript:void(0)" onclick="alert2('서비스 준비중 입니다.')">기업회원</a></li>
            </ul>
            <!--e tabs-->

            <form id="frm" method="post" action="/login/action">
                <?= csrf_field() ?>
                <input type="hidden" name="type" value="M">
                <!--s login_inpBox-->
                <div class="login_inpBox">
                    <!--s #tab1 일반회원-->
                    <div id="tab1" class="tab_content fast">
                        <!--s login_inpBox-->
                        <div class="login_inp_box">
                            <div class="inp"><input type="email" name="id" id="login_id" class="frm_input wps_100 required" placeholder="아이디(이메일)  입력"></div>
                            <div class="inp"><input type="password" name="password" id="login_pw" class="frm_input wps_100 required" placeholder="패스워드 입력"></div>
                        </div>
                        <!--e login_inpBox-->
                    </div>
                    <!--e #tab1 일반회원-->

                    <button type="submit" class="btn_submit">로그인</button>

                    <div class="kakaoBtn2 c">
                        <a href="javascript:void(0)" onclick="kakao()"><span class="icon"><img src="/static/www/img/sub/kakao_icon.png"></span>카카오로 3초만에 시작하기</a>
                    </div>
                    <?php if ($data['device'] == 'ios') : ?>
                        <div class="kakaoBtn2 c">
                            <a href="javascript:void(0)" onclick="apple()" class="appleBtn"><span class="icon"><img src="/static/www/img/sub/sns_apple.png"></span>Apple로 시작하기</a>
                        </div>
                    <?php endif; ?>

                    <!--s log_lpl-->
                    <ul class="log_lpl c">
                        <li><a href="join">회원가입</a></li>
                        <li><a href="login/find/person/id">아이디/패스워드 찾기</a></li>
                    </ul>
                    <!--e log_lpl-->

                </div>
                <!--e login_inpBox-->
            </form>

            <!--s login_snsBox-->
            <div class="login_snsBox c">
                <div class="tltBox">
                    <div class="tlt">SNS계정으로 로그인</div>
                </div>

                <!--s sns_loginUl-->
                <ul class="sns_loginUl mg_t50">
                    <li><a href="javascript:void(0)" class="sns_google" onclick="google()"><img src="/static/www/img/sub/sns_google.png"></a></li>
                    <li><a href="javascript:void(0)" class="sns_naver" onclick="naver()"><img src="/static/www/img/sub/sns_naver.png"></a></li>
                    <?php if ($data['device'] != 'ios') : ?>
                        <li><a href="javascript:void(0)" class="sns_apple" onclick="apple()"><img src="/static/www/img/sub/sns_apple.png"></a></li>
                    <?php endif; ?>
                </ul>
                <!--e sns_loginUl-->
            </div>
            <!--e login_snsBox-->
        </div>
        <!--e loginBox-->
    </div>
    <!--e cont-->

</div>
<!--e #scontent-->