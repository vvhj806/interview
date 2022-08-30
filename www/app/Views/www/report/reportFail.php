<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">A.I. 리포트</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->


    <!--s id_videoBox-->
    <div class="id_videoBox gray_back mg_b40">
        <!--s contBox-->
        <div class="contBox">

            <!--s id_video_slBox-->
            <div class="id_video_slBox">
                <!--s id_video_sl-->
                <div class="id_video_sl">
                    <?php foreach ($data['S'] as $index => $row) : ?>
                        <div class="item" data-videoIndex='<?= $index ?>'>
                            <div class="playBox" id="playBox" style="display: block;">
                                <div class="playBtn" id="playVideoBtn_<?= $index ?>" style=""><img src="/static/www/img/sub/id_video_play_btn.png"></div>
                                <div class="item">
                                    <video class="videoContent videoRotate" preload="metadata" src="<?= $data['url']['media'] . $data['videoPath'] . $row['videoName'] ?>#t=0.5"></video>
                                </div>
                                <div class="playBox_bg"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <!--e id_video_sl-->
            </div>
            <!--e id_video_slBox-->
            <?php if ($data['T']['appStat'] == 3) : ?>
                <div class="ai_rpv_txtBox wBox mg_t40 c">
                    <!--s 분석중일때-->
                    <div class="ai_rpv_analyzing">
                        <div class="img mg_b20"><img src="/static/www/img/sub/ai_rpv_analysis_icon.png"></div>
                        <div class="stlt mg_b0">
                            AI가 열심히<br />
                            점수를 분석하고 있어요!
                        </div>
                    </div>
                    <!--e 분석중일때-->
                </div>
            <?php endif; ?>
            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox mg_t40">
                <div class="txt gray">
                    죄송합니다. 본 영상은 분석 데이터가 부족하여 A.I. <br />
                    분석 결과 리포트가 발행되지 않았습니다.<br /><br />
                    혹시 인터뷰를 진행하면서 불편한점이 있으셨나요?<br />
                    이용도중 불편한 점이나 아쉬운 점이 있으시다면 언제든지 말씀해주세요!
                </div>

                <div class="itv_telBox mg_t20">
                    <i class="la la-phone"></i> <a href='/help/qna'>고객센터 링크</a>
                </div>

                <div class="ai_rpv_iq_icon"><img src="/static/www/img/sub/ai_rpv_iq_icon.png"></div>
            </div>
            <!--e wBox-->
        </div>
        <!--e contBox-->
    </div>
    <!--e id_videoBox-->
</div>
<!--e #scontent-->

<script>
    $(".videoContent").on("ended", function() {
        let playbtn = $(this).parents('div:eq(1)').children('div:eq(0)');
        playbtn.css("display", "");
    });


    $('.playBtn').on('click', function() {
        let videoPlay = $(this).parents().children('div:eq(1)').children('video');
        videoPlay.get(0).play();
        $(this).parents().children('div:eq(2)').css("display", "none");
        $(this).css("display", "none");
    });

    $('.videoContent').on('click', function() {
        let playbtn = $(this).parents('div:eq(1)').children('div:eq(0)');
        playbtn.css("display", "");
        $(this).get(0).pause();
    })
</script>