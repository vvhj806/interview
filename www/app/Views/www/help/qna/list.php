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
            <li><a href="faq">FAQ</a></li>
            <li class="on"><a href="javascript:void(0);">1:1문의</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <?php
    // <div class="gray_bline_first">
    //     <div class="contBox">
    //         <div class="BtnBox">
    //             <a href="qna/write" class="btn btn02 wps_100">+ 새 문의 작성하기</a>
    //         </div>
    //     </div>
    // </div>
    ?>

    <?php if (false) : ?>
        <!--s contBox-->
        <div class="cont cont_pd_bottom">
            <div class="stlt">나의 문의내역 <?= $data['total'] ?? 0 ?>건</div>
            <!--s inq_list-->
            <div class="inq_list">
                <?php if ($data['list'] ?? false) : ?>
                    <!--s 무한루프-->
                    <?php foreach ($data['list'] as $val) : ?>
                        <!--s inq_contBox-->
                        <div class="inq_contBox">

                            <!--s inq_cont-->
                            <div class="inq_cont">
                                <div class="data"><?= $val['qna_reg_date'] ?></div>
                                <!--s inq_txt-->
                                <div class="inq_txt">
                                    <div> <?= $val['qna_title'] ?></div>
                                    <?= $val['qna_question'] ?>
                                    <br /><br />
                                    <div class="pic_fileBox">
                                        <?php if ($val['file_idx_data_1']) : ?>
                                            <div class="pic_file">
                                                <div class="pic_file_cont">
                                                    <div class="img"><img src="https://media.highbuff.com/data/uploads<?= $val['file_idx_data_1'] ?>"></div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($val['file_idx_data_2']) : ?>
                                            <div class="pic_file">
                                                <div class="pic_file_cont">
                                                    <div class="img"><img src="https://media.highbuff.com/data/uploads<?= $val['file_idx_data_2'] ?>"></div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($val['file_idx_data_3']) : ?>
                                            <div class="pic_file">
                                                <div class="pic_file_cont">
                                                    <div class="img"><img src="https://media.highbuff.com/data/uploads<?= $val['file_idx_data_3'] ?>"></div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($val['file_idx_data_4']) : ?>
                                            <div class="pic_file">
                                                <div class="pic_file_cont">
                                                    <div class="img"><img src="https://media.highbuff.com/data/uploads<?= $val['file_idx_data_4'] ?>"></div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <!--e inq_txt-->
                            </div>
                            <!--e inq_cont-->

                            <?php if ($val['qna_answer']) : ?>
                                <!--s inq_review-->
                                <div class="inq_review">
                                    <!--s inq_review_cont-->
                                    <div class="inq_review_cont">
                                        <div class="data"> <?= $val['qna_mod_date'] ?></div>

                                        <div class="inq_review_txt">
                                            <?= $val['qna_answer'] ?>
                                            <br /><br />
                                            <img src="/static/www/img/main/test_img.jpg">
                                        </div>
                                    </div>
                                    <!--e inq_review_cont-->
                                </div>
                                <!--e inq_review-->
                            <?php endif; ?>

                        </div>
                        <!--e inq_contBox-->
                    <?php endforeach; ?>
                    <!--e 무한루프-->
                <?php else : ?>
                    <!--s inq_contBox 내용이 없을때-->
                    <div class="inq_contBox">
                        <!--s inq_cont-->
                        <div class="inq_cont c">
                            <!--s inq_txt-->
                            <div class="inq_txt">
                                <span class="point font24">1:1 문의 내역이 없어요.</span><br /><br />

                                궁금하신 점은 <br />
                                새 문의 작성하기를 통해 <br />
                                언제든 말씀해주세요 !
                            </div>
                            <!--e inq_txt-->
                        </div>
                        <!--e inq_cont-->
                    </div>
                    <!--e inq_contBox 내용이 없을때-->
                <?php endif; ?>
            </div>
            <!--e inq_list-->

            <?= $data['pager']->links('qna', 'front_full') ?>
        </div>
        <!--e contBox-->
    <?php else : ?>
        <div class='gray_bline_first help_box'>
            <div style='width:50%'>
                <div class='img_box kakao'>
                    <img src='/static/www/img/sub/kakao.webp' style='width:100%'>
                </div>
                <p class='big kakao'>카카오채널 연결하기</p>
            </div>
            <div style='width:50%'>
                <div class='img_box'>
                    <img src='/static/www/img/sub/help.png' style='width:100%'>
                </div>
                <p class='big'>고객 센터 1855-4549</p>
                <p class='mini'>운영시간 10:00 ~ 18:00 </p>
                <p class='mini'>(상담사 연결이 지연될 수 있습니다.)</p>
            </div>
        </div>
    <?php endif; ?>

</div>
<!--e #scontent-->
<script>
    $('.kakao').on('click', function() {
        if (window.navigator.userAgent.indexOf("APP_Highbuff_Android") != -1) {
            window.interview.kakaoQnA('https://pf.kakao.com/_leLgK/chat');
        } else if (window.navigator.userAgent.indexOf("APP_Highbuff_IOS") != -1) {
            webkit.messageHandlers.kakaoQnA.postMessage('https://pf.kakao.com/_leLgK/chat');
        } else {
            location.href = 'https://pf.kakao.com/_leLgK/chat';
        }
    });
</script>
<style>
    .help_box {
        display: flex;
        text-align: center;
        justify-content: space-evenly;
    }

    .help_box>div:first-child {
        border-right: 1px solid #ddd;
    }

    .help_box>div:last-child {
        border-left: 1px solid #ddd;
    }

    .kakao {
        cursor: pointer;
    }

    .img_box {
        width: 50%;
        margin: 0 auto;
        margin-bottom: 1.5rem;
    }

    .img_box>img {
        border-radius: 1rem;
    }

    .big {
        font-size: 1.5rem;
    }

    .mini {
        font-size: 1rem;
        color: #787878;
    }

    @media screen and (max-width:768px) {
        .img_box {
            margin-bottom: 1.25rem;
        }

        .big {
            font-size: 1.25rem;
        }

        .mini {
            font-size: 0.75rem;
        }
    }

    @media screen and (max-width:480px) {
        .img_box {
            margin-bottom: 1rem;
        }

        .big {
            font-size: 1rem;
        }

        .mini {
            font-size: 0.5rem;
        }
    }
</style>