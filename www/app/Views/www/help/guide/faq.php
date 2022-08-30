<?php
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
            <li class="on"><a href="/help/guide/faq">FAQ</a></li>
            <li><a href="/help/guide/sample">샘플인터뷰</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s contBox-->
    <div class="contBox mg_b60">
        <!-- 소개내용 -->
    </div>
    <!--e contBox-->

    <!--s contBox-->
    <div class="contBox">
        <div class="stlt">자주 묻는 질문</div>

        <!--s sub_tab-->
        <div class="sub_tab">
            <!--s depth-->
            <ul id='depth_list' class="depth">
                <?php foreach ($data['getFaq'] as $key => $val) : ?>
                    <?php if ($key == 0) : ?>
                        <li class="on" rel="tab<?= $key ?>"><a href="javascript:void(0)"><?= $val['faq_txt'] ?></a></li>
                    <?php else : ?>
                        <li rel="tab<?= $key ?>"><a href="javascript:void(0)"><?= $val['faq_txt'] ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <!--e depth-->
        </div>
        <!--e sub_tab-->
    </div>
    <!--e contBox-->

    <!--s faq_list-->
    <?php foreach ($data['getFaq'] as $key => $val) : ?>
        <?php if ($key == 0) :
            $style = "";
        else :
            $style = "display:none";
        endif;
        ?>
        <div class="faq_list" id="tab<?= $key ?>" style="<?=$style?>">
            <!--s 무한루프-->
            <?php foreach ($data['faqList' . $val['idx']] as $listKey => $listVal) : ?>
                <div class="faq_tlt">
                    <div class="tltBox">
                        <div class="tlt"><?= $listVal['faq_question'] ?></div>
                    </div>
                </div>
                <div class="faq_txt">
                    <?= $listVal['faq_answer'] ?>
                </div>
            <?php endforeach; ?>
            <!--s 무한루프-->
        </div>
    <?php endforeach; ?>
    <!--e faq_list-->


    <!--s contBox-->
    <div class="cont pd_t60">
        <div class="stlt c mg_t60">지금 바로 시작해볼까요?</div>

        <div class="BtnBox">
            <button type="submit" class="btn btn01 wps_100" id="goInterview"><span class="faq_mic_icon"><img src="/static/www/img/sub/mic_icon.png"></span>새 인터뷰 시작하기</button>
        </div>
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->
<script>
    $('.faq_tlt').on('click', function() {
        function slideDown(target) {
            slideUp();
            $(target).addClass('active').next().slideDown();
        }

        function slideUp() {
            $('.faq_tlt').removeClass('active').next().slideUp();
        };
        $(this).hasClass('active') ? slideUp() : slideDown($(this));
    })

    $("#depth_list li").on("click", function() {
        $("#depth_list li").removeClass("on");
        $(this).addClass("on");
        let activeTab = $(this).attr("rel");
        $('.faq_list').hide();
        $("#" + activeTab).show();
    });

    $("#goInterview").on('click', function() {
		if ("<?= $data['recIdx'] ?>") {
			location.href = "/interview/ready?rec=<?= $data['recIdx'] ?>";
		} else if ("<?= $data['mockIdx'] ?>") {
			location.href = "/interview/ready?mock=<?= $data['mockIdx'] ?>";
		} else if ("<?= $data['cMockIdx'] ?>") {
			location.href = "/interview/ready?cmock=<?= $data['cMockIdx'] ?>";
		} else {
			location.href = "/interview/ready";
		}
	});
</script>