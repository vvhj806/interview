<?php
isset($data['position']) ? $position = $data['position'] : $position = [];
isset($data['sugAppInfo']) ? $data['sugAppInfo'] : $data['sugAppInfo']['sug_end_date'] = "";
?>

<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt"></div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom c">
        <?php if ($position == null) : ?>
            <!--s bigtlt-->
            <div class="bigtlt bigtlt_mg_b">
                인공지능과 함께<br />
                <?php if ($data['sugAppIdx']) : ?>
                    인터뷰를 시작해 볼까요?<br /><br />
                    현재 <?= $data['text'] ?> 위해 자동 선택된 분야는<br />
                    <span class="point b"><?= $data['sugAppInfo']['sug_app_title'] ?></span> 입니다. <br>
                    인터뷰 응시기한은 <span class="point b" id="end"></span> 까지 입니다.

                <?php else : ?>
                    새 인터뷰를 시작해 볼까요?<br /><br />

                    인터뷰는 이렇게 진행되어요.
                <?php endif; ?>
            </div>
            <!--e bigtlt-->
        <?php else : ?>
            <!--s bigtlt-->
            <div class="bigtlt bigtlt_mg_b">
                인공지능과 함께<br />
                인터뷰를 시작해 볼까요?<br /><br />

                현재 <?= $data['text'] ?> 위해 자동 선택된 직무는<br />
                <span class="point b">
                    <?php foreach ($data['position'] as $key => $val) : ?>
                        [<?= $val ?>]
                    <?php endforeach; ?>
                </span>
                입니다
            </div>
            <!--e bigtlt-->
        <?php endif; ?>

        <!--s itv_prUl-->
        <div class="itv_prUl ul_4">
            <ul>
                <li>
                    <div class="iconBox">
                        <div class="icon"><img src="/static/www/img/sub/itv_pr_icon00.png"></div>
                    </div>
                    <p>포지션 선택</p>
                </li>
                <li>
                    <div class="iconBox">
                        <div class="icon"><img src="/static/www/img/sub/itv_pr_icon01.png"></div>
                    </div>
                    <p>프로필 지정</p>
                </li>
                <li>
                    <div class="iconBox">
                        <div class="icon"><img src="/static/www/img/sub/itv_pr_icon02.png"></div>
                    </div>
                    <p>인터뷰 진행</p>
                </li>
                <li>
                    <div class="iconBox">
                        <div class="icon"><img src="/static/www/img/sub/itv_pr_icon03.png"></div>
                    </div>
                    <p>AI리포트 발행</p>
                </li>
            </ul>
        </div>
        <!--e itv_prUl-->

        <!--s itv_pr_gray_txt-->
        <div class="itv_pr_gray_txt">
            *인터뷰 길이에 따라 리포트 발행까지<br />
            최소 5분에서 최대 30분까지 소요될 수 있어요
        </div>
        <!--e itv_pr_gray_txt-->
        <?php if (!$position || $data['mockIdx'] != "" || $data['cMockIdx'] != "") : ?>
            <!--s itv_pr_grayBox-->
            <div class="itv_pr_grayBox">
                공개 전 인터뷰는<br />
                나만 볼 수 있으니 안심하세요 !<br />
                그럼, 시작해볼까요 ?
            </div>
            <!--e itv_pr_grayBox-->
        <?php else : ?>
            <!--s itv_pr_grayBox-->
            <div class="itv_pr_grayBox">
                인터뷰 완료 후 ,<br />
                바로 지원하지 않아도 괜찮아요 !<br />
                완료한 인터뷰는 AI리포트에서 확인할 수 있어요
            </div>
            <!--e itv_pr_grayBox-->
        <?php endif; ?>
        <div class="itv_pr_imgBox"><img src="/static/www/img/sub/itv_pr_img.png" class="wps_100"></div>

        <?php if (empty($data['sugAppIdx'] ?? '')) : ?>
            <div class="chek_box checkbox">
                <a href="/help/guide/interview">
                    <div class="lbl black b">시작하기 전, 가이드 보러가기 <span class="arrow"><i class="la la-angle-right"></i></span></div>
                </a>
            </div>
        <?php endif; ?>
        
        <form action="/interview/typeAction" method="POST" id="company">
            <?= csrf_field() ?>
            <input name="rec" id="rec" value="<?= $data['recIdx'] ?>" type="hidden">
            <input name="mock" id="mock" value="<?= $data['mockIdx'] ?>" type="hidden">
            <input name="cmock" id="cmock" value="<?= $data['cMockIdx'] ?>" type="hidden">
            <input name="sug" id="sug" value="<?= $data['sugAppIdx'] ?>" type="hidden">
            <input name="cateIdx" id="cateIdx" value="" type="hidden">
            <input name="appType" id="appType" value="C" type="hidden">
            <input name="appBrowserName" id="appBrowserName" value="" type="hidden">
            <input name="appBrowserVersion" id="appBrowserVersion" value="" type="hidden">
            <input name="appPlatform" id="appPlatform" value="" type="hidden">
            <input name="postCase" value="type" type="hidden">
            <input name="backUrl" value="/" type="hidden">

            <!--s BtnBox-->
            <div class="BtnBox" id="goType">
                <a href="/interview/type?type=<?= $data['type'] ?>&rec=<?= $data['recIdx'] ?>" class="btn btn01 wps_100">포지션 선택 후 인터뷰 시작하기</a>
            </div>
            <!--e BtnBox-->
            <!--s BtnBox-->
            <div class="BtnBox" id="goProfile">
                <a href="javascript:" class="btn btn01 wps_100">프로필 지정 후 인터뷰 시작하기</a>
            </div>
            <!--e BtnBox-->
        </form>
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->
<script src="<?= $data['url']['menu'] ?>/plugins/bowser/bundled.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
    let info = bowser.parse(window.navigator.userAgent);
    getClientInfo();

    if ("<?= $data['recIdx'] ?>" == 0) {
        $('#goType').show();
        $('#goProfile').hide();
        if (("<?= $data['mockIdx'] ?>" != "" && "<?= $data['mockIdx'] ?>" != null) || ("<?= $data['cMockIdx'] ?>" != null && "<?= $data['cMockIdx'] ?>" != "") || ("<?= $data['sugAppIdx'] ?>" != null && "<?= $data['sugAppIdx'] ?>" != "")) {
            $('#goType').hide();
            $('#goProfile').show();
            $('#appType').val('A');
            if ("<?= $data['sugAppIdx'] ?>") {
                $('#appType').val('B');
                $('#end').text(moment('<?= $data['sugAppInfo']['sug_end_date'] ?>').format('YYYY-MM-DD'));
            }
            // if($data['sugAppInfo']){
            //     // $('#end').text(moment('<//?=$data['sugAppInfo']['sug_end_date']?>').format('YYYY-MM-DD HH:mm:ss'));
            // }
        }
    } else {
        $('#goType').hide();
        $('#goProfile').show();
        if ('<?= $data['type'] ?>' == 'A') {
            $('#appType').val('M');
        }
    }
    // $('#start').text(moment('<//?=$data['sugAppInfo']['sug_start_date']?>').format('YYYY-MM-DD HH:mm:ss'));
    $('#goProfile').on('click', function() {
        if (info.platform.type == 'desktop') {
            $('#company').submit();
        } else {
            const emlCsrf = $("input[name='<?= csrf_token() ?>']");
            $.ajax({
                type: 'POST',
                url: '/api/interview/ready',
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                    'rec': $('#rec').val(),
                    'mock': $('#mock').val(),
                    'cmock': $('#cmock').val(),
                    'sug': $('#sug').val(),
                    'cateIdx': $('#cateIdx').val(),
                    'appType': $('#appType').val(),
                    'appBrowserName': $('#appBrowserName').val(),
                    'appBrowserVersion': $('#appBrowserVersion').val(),
                    'appPlatform': $('#appPlatform').val(),
                    'postCase': 'readySubmit',
                    'memIdx': '<?= $data['session']['idx'] ?>',
                    BackUrl: '/'
                },
                success: function(data) {
                    emlCsrf.val(data.code.token);
                    if (data.status == 200) {
                        let biz = Number(1);
                        if (("<?= $data['mockIdx'] ?>" != "" && "<?= $data['mockIdx'] ?>" != null) || ("<?= $data['cMockIdx'] ?>" != null && "<?= $data['cMockIdx'] ?>" != "")) { //모의인터뷰 또는 기업 모의 인터뷰
                            biz = Number(0);
                        }

                        let app_ary = {
                            "applier_idx": data.applyIdx,
                            "biz": biz,
                            "user_name": data.memName,
                            "c_name": data.c_name
                        };
                        if (window.navigator.userAgent.indexOf("APP_Highbuff_Android") != -1) {
                            window.interview.interviewStart(JSON.stringify(app_ary));
                        } else if (window.navigator.userAgent.indexOf("APP_Highbuff_IOS") != -1) {
                            webkit.messageHandlers.interviewStart.postMessage(JSON.stringify(app_ary));
                        } else {
                            location.href = "/interview/profile/" + data.applyIdx + "/" + data.memIdx;
                        }
                    } else {
                        alert(data.messages);

                        return false;
                    }
                    return true;
                },
                error: function(e) {
                    alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                    return;
                }
            }) //ajax;

        }
    });
    // 클라이언트 정보
    function getClientInfo() {
        $("#appBrowserName").val(info.browser.name);
        $('#appBrowserVersion').val(info.browser.version);
        $('#appPlatform').val(info.platform.type);
    }
</script>