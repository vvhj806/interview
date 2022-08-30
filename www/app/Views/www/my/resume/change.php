<!--s #scontent-->
<div id="changeResume" class="pop_modal2">
    <!-- <div id="changeResume"> -->
    <div class="pop_full_cont pop_full">
        <!--s top_tltBox-->
        <div class="top_tltBox c">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <div class="tlt">내 이력서</div>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s contBox-->
        <div class="cont cont_pd_bottom" style='overflow:scroll; height:100%; padding: 0px 1rem 250px 1rem'>

            <!--s resume_list-->
            <div class="resume_list">
                <ul>
                    <!--s 무한루프-->
                    <?php foreach ($data['resumeList'] as $resumeVal) : ?>
                        <li class="resumeList">
                            <div>
                                <input type="hidden" name="resume" value="<?= $resumeVal['res_idx'] ?? ''?>">
                                <!-- <div class="tlt">[ IT. 솔루션영업 ]</div> -->
                                <div class="product_desc"><?= $resumeVal['res_title'] ?></div>
                                <div class="data"><?= $resumeVal['res_reg_date'] ?> 작성</div>

                                <div class="hide resumeBtns">
                                    <a href='/my/resume/modify/<?= $resumeVal['res_idx'] ?>?data=set_report&app=<?= $data['appIdx']?>'>
                                        <div class="arrow"><img src="/static/www/img/sub/itv_pr_file_arrow.png"></div>
                                    </a>
                                    <div class="close deleteResume"><img src="/static/www/img/sub/itv_pr_file_close.png"></div>
                                </div>

                                <!--s rs_chkBox-->
                                <div class="rs_chkBox hide" data-idx='<?= $resumeVal['res_idx'] ?? ''?>'>
                                    <div class="chk_icon point"><i class="la la-check"></i></div>
                                </div>
                                <!--e rs_chkBox-->
                            </div>
                        </li>
                    <?php endforeach ?>
                    <!--e 무한루프-->
                </ul>
            </div>
            <!--e resume_list-->



        </div>
        <!--e contBox-->
    </div>
    <!--s ard_btnBox-->
    <div class="ard_btnBox fix_btnMod" style='z-index:4;'>
        <!--s ard_btn_cont-->
        <div class="ard_btn_cont">
            <!--s ard_btn-->
            <div class="BtnBox mg_t0" id="resumeBtnBox">
                <button type='button' class="btn btn02 areaBtn" value='no'>닫기</button>
                <button type='button' class="btn btn01 areaBtn" value='ok'>확인</button>
            </div>
            <!--e ard_btn-->
        </div>
        <!--e ard_btn_cont-->
    </div>
    <!--e ard_btnBox-->
</div>
<!--e #scontent-->

<script>
    let selectResumeIdx = '';
    let selectResumeEle = '';

    $('.resumeList').on('click', function() {
        $('.rs_chkBox').addClass('hide');
        let thisEle = $(this).find('.rs_chkBox');
        thisEle.removeClass('hide');
        selectResumeIdx = thisEle.data('idx');
        selectResumeEle = $(this).html();

    });
</script>