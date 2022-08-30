<?php

isset($data['get']['updown']) ? $data['get']['updown'] : $data['get']['updown'] = 'up';
isset($data['sampleList']) ? $data['sampleList'] : $data['sampleList'] = "";

isset($data['recIdx']) ? $data['recIdx'] : $data['recIdx'] = "";
isset($data['mockIdx']) ? $data['mockIdx'] : $data['mockIdx'] = "";
isset($data['cMockIdx']) ? $data['cMockIdx'] : $data['cMockIdx'] = "";
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
            <div class="tlt">하이버프 활용법</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_tab-->
    <div class="top_tab">
        <!--s depth-->
        <ul class="depth">
            <li><a href="/help/guide/interview">이용가이드</a></li>
            <li><a href="/help/guide/faq">FAQ</a></li>
            <li class="on"><a href="/help/guide/sample">샘플인터뷰</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s contBox-->
    <div class="contBox">
        <!--s sub_tab-->
        <div class="sub_tab">
            <!--s depth2-->
            <form method="self" id="selectUpdown">
                <ul class="depth2">
                    <!-- <input type="hidden" name="cateCheck[]" val=""> -->
                    <?php foreach ($data['jobCate'] as $key => $val) : ?>
                        <input type="checkbox" name="cateCheck[]" id="cateCheck_<?= $val[0]['idx'] ?>" value="<?= $val[0]['idx'] ?>" <?= isset($data['get']['cate']) && in_array($val[0]['idx'], $data['get']['cate']) ? 'checked' : '' ?> style="display:none">
                        <li data-idx="<?= $val[0]['idx'] ?>" <?= isset($data['get']['cate']) && in_array($val[0]['idx'], $data['get']['cate']) ? 'class="on"' : '' ?>><a href="javascript:void(0)"><?= $val[0]['job_depth_text'] ?></a></li>
                    <?php endforeach ?>
                </ul>
                <!--e depth2-->

                <a href="javascript:void(0)" id="tab_more">더보기 <span class="tab_more_icon"><img src="/static/www/img/sub/arrow_bottom2.png"></span></a>
        </div>
        <!--e sub_tab-->

        <!--s ai_reportBox-->
        <div class="ai_reportBox">

            <div class="r">
                <!--s selBox-->
                <div class="selBox l">
                    <!--s selectbox-->
                    <div class="selectbox">
                        <dl class="dropdown">
                            <input type="hidden" name="updown" id="updown" value="">
                            <dt><a href="javascript:void(0)" class="myclass" id="updownText">점수 높은 순</a></dt>
                            <dd>
                                <ul class="dropdown2">
                                    <li id="up"><a href="javascript:void(0)" class="on">점수 높은 순</a></li><!-- 해당 셀렉트 박스 선택했을때 앵커에 class="on"추가 -->
                                    <li id="down"><a href="javascript:void(0)">점수 낮은 순</a></li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <!--e selectbox-->
                </div>
                <!--e selBox-->
            </div>
            <!--s ai_report_list-->
            <div class="ai_report_list sub_ai_report_list c">
                <!--s 무한루프-->
                <?php if ($data['sampleList'] != "" && $data['sampleList'] != null) : ?>
                    <?php foreach ($data['sampleList'] as $val) : ?>
                        <div class="item" id="<?= $val['idx'] ?>">
                            <a href="/report/detail/<?= $val['enIdx'] ?>">
                                <div class="img"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" alt="" style="object-fit:cover"></div>
                                <div class="classBox"><span class="point"><?= $val['analy']->grade ?></span>등급 / <span class="point"><?= number_format($val['analy']->sum, 2) ?></span>점</div>
                                <div class="jopBox"><?= $val['job_depth_text'] ?></div>
                                <?php if ($val['percent'] == "-") : ?>
                                    <div class="psBox">상위 <span class="point"><?= $val['percent'] ?> %</span></div>
                                <?php else : ?>
                                    <div class="psBox">상위 <span class="point"><?= number_format($val['percent'], 2) ?> %</span></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div>
                        해당하는 샘플인터뷰가 없습니다.
                    </div>
                <?php endif; ?>
            </div>
            <!--s ai_report_list-->
            <?php if ($data['sampleList'] != "" && $data['sampleList'] != null) : ?>
                <!--s perfit_moreBtn-->
                <div class="perfit_moreBtn" id="ai_report_more">
                    <a href="javascript:void(0)">펼쳐보기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
                </div>
                <!--e perfit_moreBtn-->
            <?php endif; ?>
        </div>
        <!--e ai_reportBox-->

        <!--s pd_t60-->
        <div class="pd_t60">
            <div class="stlt c mg_t60">지금 바로 시작해볼까요?</div>

            <div class="BtnBox" id="startInterview">
                <button type="button" class="btn btn01 wps_100"><span class="faq_mic_icon"><img src="/static/www/img/sub/mic_icon.png"></span>새 인터뷰 시작하기</button>
            </div>
        </div>
        <!--e pd_t60-->
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->
<?= csrf_field() ?>
</form>
<script>
    let pager = 4;
    let viewCount = 4;
    let cate = [];
    $(".ai_report_list .item").show();

    $('#updown').val("<?= $data['get']['updown'] ?>");
    if ("<?= $data['get']['updown'] ?>" == "up") {
        $('#up').addClass('on');
        $('#updownText').text('점수 높은 순');
        $('#down').removeClass('on');
    } else {
        $('#down').addClass('on');
        $('#updownText').text('점수 낮은 순');
        $('#up').removeClass('on');
    }



    $('#up').on('click', function() {
        $('#updown').val("up");
        $('#selectUpdown').submit();
    })
    $('#down').on('click', function() {
        $('#updown').val("down");
        $('#selectUpdown').submit();
    })

    $('#startInterview').on('click', function() {
        if ("<?= $data['recIdx'] ?>") {
            location.href = "/interview/ready?rec=<?= $data['recIdx'] ?>";
        } else if ("<?= $data['mockIdx'] ?>") {
            location.href = "/interview/ready?mock=<?= $data['mockIdx'] ?>";
        } else if ("<?= $data['cMockIdx'] ?>") {
            location.href = "/interview/ready?cmock=<?= $data['cMockIdx'] ?>";
        } else {
            location.href = "/interview/ready";
        }
    })

    $('.depth2 li').on('click', function() {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $(this).toggleClass("on");
        if ($('#cateCheck_' + $(this).data('idx')).is(':checked') == true) {
            $("input:checkbox[id='cateCheck_" + $(this).data('idx') + "']").attr("checked", false);
        } else {
            $("input:checkbox[id='cateCheck_" + $(this).data('idx') + "']").attr("checked", true);
        }
        $('#selectUpdown').submit();
    })

    $('#ai_report_more').on('click', function() {
        getAjax();
    })

    function getAjax() {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $.ajax({
            type: 'POST',
            url: '/api/interview/sample/list',
            data: {
                '<?= csrf_token() ?>': emlCsrf.val(),
                'updown': '<?= $data['get']['updown'] ?>',
                'cate': <?= json_encode($data['get']['cate']) ?>,
                'postCase': 'sampleList',
                'pager': pager,
                BackUrl: '/'
            },
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    for (var i = 0; i < data.applierList.length; i++) {
                        if (data.applierList[i].file_save_name == "" || data.applierList[i].file_save_name == null) {
                            data.applierList[i].file_save_name = '/data/no_img.png';
                        }
                        let applierListAnal = JSON.parse(data.applierList[i].repo_analysis);
                        $('.ai_report_list').append(
                            `<div class="item" id="${data.applierList[i].idx}">
                                <a href="/report/detail/${data.applierList[i].enIdx}">
                                    <div class="img"><img src="<?= $data['url']['media'] ?>${data.applierList[i].file_save_name}" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" alt="" style="object-fit:cover"></div>
                                    <div class="classBox"><span class="point">${applierListAnal.grade}</span>등급 / <span class="point">${Math.round(applierListAnal.sum * 100) / 100}</span>점</div>
                                    <div class="jopBox">${data.applierList[i].job_depth_text}</div>
                                    <div class="psBox">상위 <span class="point">${Math.round(data.applierList[i].percent *100) /100} %</span></div>
                                </a>
                            </div>
                            `
                        );
                    }
                    $(".ai_report_list .item").show();
                    pager += 4;

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
</script>