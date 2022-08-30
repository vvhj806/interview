<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">공지사항</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s faq_list-->
    <div class='cont'>
        <div class="faq_list">
            <?php if (count($data['noticeList'])) : ?>
                <!--s 무한루프-->
                <?php foreach ($data['noticeList'] as $val) : ?>
                    <div class="faq_tlt">
                        <div class="tltBox">
                            <div class="tlt"><?= $val['bd_title'] ?></div>
                            <div class="data"><?= $val['bd_reg_date'] ?></div>
                        </div>
                    </div>
                    <div class="faq_txt">
                        <?= $val['bd_content'] ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="tltBox">작성된 게시물이 없습니다</div>
            <?php endif; ?>
            <!--e 무한루프-->
        </div>
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