<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/main">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">고객센터</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_tab-->
    <div class="top_tab">
        <!--s depth-->
        <ul class="depth2 wd_2_2">
            <li class="on"><a href="javascript:void(0);">FAQ</a></li>
            <li><a href="qna">1:1문의</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s faq_list-->
    <div class="faq_list cont">
        <!--s 무한루프-->
        <?php foreach ($data['list'] as $val) : ?>
            <div class="faq_tlt">
                <div class="tltBox">
                    <div class="tlt"><?= $val['faq_question'] ?></div>
                </div>
            </div>
            <div class="faq_txt">
                <?= $val['faq_answer'] ?>
            </div>
        <?php endforeach; ?>
        <!--s 무한루프-->
    </div>
    <!--e faq_list-->
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
</script>