<!--s itv_duty_pop-->
<div id="itv_duty_pop" class="ard_md">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">
                <!--s top_shBox-->
                <?= view_cell('\App\Libraries\CategoryLib::jobSearch') ?>
                <!--e top_shBox-->
            </div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <div class='cate_search_pop'>
        <ul class='cate_search_list'>

        </ul>
    </div>

    <!--s pop_full-->
    <div class="pop_full">
        <!--s pop_full_cont-->
        <div class="pop_full_cont">
            <!--s pop_full_cont2-->
            <div class="pop_full_cont2">
                <!--s top_tltBox-->
                <div class="top_tltBox c">

                </div>
                <!--e top_tltBox-->
            </div>
            <!--e pop_full_cont2-->

            <?php if ($data['myCategory']) : ?>
                <div class="bigtlt bigtlt_mg_b">
                    <span class="point b"><?= $data['myCategory']['job_depth_text'] ?></span> 을 추천해드릴께요
                </div>
                <div class="gray">
                    * 추천 직군은 첫번째로 설정된 직군입니다
                </div>
            <?php endif; ?>

            <!--s ardBox-->
            <div class="ardBox">
                <?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'only', 'checked' => [$data['myCategory']['idx'] ?? '']]) ?>
            </div>
            <!--e ardBox-->
        </div>
        <!--e pop_full_cont-->
    </div>
    <!--s pop_full-->
    <!--s ard_btnBox-->
    <div class="ard_btnBox fix_btnMod">
        <!--s ard_btn_cont-->
        <div class="ard_btn_cont">
            <form action="/interview/typeAction" method="POST" id="next_form">
                <?= csrf_field() ?>
                <input name="rec" id="rec" value="" type="hidden">
                <input name="mock" id="mock" value="" type="hidden">
                <input name="cmock" id="cmock" value="" type="hidden">
                <input name="sug" id="sug" value="" type="hidden">
                <input name="cateIdx" id="cateIdx" value="" type="hidden">
                <input name="appType" id="appType" value="M" type="hidden">
                <input name="appBrowserName" id="appBrowserName" value="" type="hidden">
                <input name="appBrowserVersion" id="appBrowserVersion" value="" type="hidden">
                <input name="appPlatform" id="appPlatform" value="" type="hidden">
                <input name="postCase" value="type" type="hidden">
                <input name="backUrl" value="/" type="hidden">
            </form>
            <!--s ard_btn-->
            <div class="BtnBox mg_t40">
                <a href="javascript:" class="btn btn01 wps_100" id="next">다음</a>
            </div>
            <!--e ard_btn-->
        </div>
        <!--e ard_btn_cont-->
    </div>
    <!--e ard_btnBox-->
</div>
<!--e itv_duty_pop-->

<script src="<?= $data['url']['menu'] ?>/plugins/bowser/bundled.js"></script>
<script>
    let type_txt1 = "";
    let type_txt2 = "";
    let info = bowser.parse(window.navigator.userAgent);

    $(document).ready(function() {
        const bottomHeight = $('.fix_btnMod').outerHeight();
        $('.ard_1th').css("padding-bottom", `${bottomHeight}px`);
        $('.ard_2th').css("padding-bottom", `${bottomHeight}px`);

        getClientInfo();
    });

    $('input[name="depth1"]').on('change', function() { //depth1
        $('input[name="depth3[]"]').prop('checked', false).trigger('change');
    });

    $("#next").on("click", function() {
        type_txt2 = $('input[name="depth3[]"]:checked').val()
        if (!type_txt2) {
            alert2("세부 카테고리를 선택해주세요");
        } else {
            $("#cateIdx").val(type_txt2);

            if (info.platform.type == 'desktop') {
                $("#next_form").submit();
            } else {
                const emlCsrf = $("input[name='<?= csrf_token() ?>']");
                $.ajax({
                    type: 'POST',
                    url: '/api/interview/type',
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
                        'postCase': 'typeSubmit',
                        'memIdx': '<?= $data['session']['idx'] ?>',
                        'BackUrl': '/'
                    },
                    success: function(data) {
                        emlCsrf.val(data.code.token);
                        if (data.status == 200) {
                            let app_ary = {
                                "applier_idx": data.applyIdx,
                                "biz": 0,
                                "user_name": data.memName,
                                "c_name": ""
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
        }
    });

    // 클라이언트 정보
    function getClientInfo() {
        $("#appBrowserName").val(info.browser.name);
        $('#appBrowserVersion').val(info.browser.version);
        $('#appPlatform').val(info.platform.type);
    }
</script>

<style>
    body {
        overflow: hidden;
    }

    label::after {
        display: none !important;
    }
</style>