<script>
    $(document).ready(function() {

        $('#reportBtnBox > button').on('click', function() {
            if ($(this).val() == 'ok') {
                if (selectIdx) {
                    location.href = `share?report=${selectIdx}#share_type`;
                } else {
                    alert2('리포트를 선택해주세요.');
                }
            } else if ($(this).val() == 'no') {
                fnHidePop('changeReport');
            }
        });

        $('.change_resume').on('click', function() {
            if (!$('input[name="updateIdx"]').val()) {
                return alert2('인터뷰(리포트)를 선택해 주세요.');
            }
            fnShowPop('changeResume');
        });

        $('#resumeBtnBox > button').on('click', function() {
            if ($(this).val() == 'ok') {
                $('.resume_fileBox > ul > li').empty();
                $('.resume_fileBox > ul > li').append(selectResumeEle);
                $('.resume_fileBox').removeClass('hide');
                $('.resume_fileBox').find('.resumeBtns').removeClass('hide');
                $(`.rs_chkBox[data-idx="${selectResumeIdx}"]`).addClass('hide');
                fnHidePop('changeResume');
            } else if ($(this).val() == 'no') {
                fnHidePop('changeResume');
            }
        });

        $(document).on('click', '.deleteResume', function() {
            const thisList = $(this).closest('li');
            thisList.empty();
            thisList.text('이력서를 첨부해 주세요.');
            $('input[name="resume"]').val('');
        });

        $('#reportSelect').on('click', function() {
            fnShowPop('changeReport');
        });

        $("#sub").on("click", function() {
            if (!$('input[name="updateIdx"]').val()) {
                return alert2('인터뷰(리포트)를 선택해 주세요.');
            }

            if ($('input[name="resume"]').val() == '' || $('input[name="resume"]').val() == null) {
                return alert2('이력서를 선택해주세요.');
            }

            if ($('#shareOn').is(':checked')) {
                fnShowPop('alert_pop');
            } else {
                $('#frm').submit();
            }
        });

    });
</script>
<form id="frm" method="POST" action="/report/share/action/report">
    <?= csrf_field() ?>

    <!--s scontent-->
    <div id="scontent">
        <!--s top_tltBox-->
        <div class="top_tltBox c">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <a href="/report">
                    <div class="backBtn"><span>뒤로가기</span></div>
                </a>
                <div class="tlt">종합 리포트 설정</div>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s contBox-->
        <div class="cont pd_t0">
            <!--s 인터뷰(리포트) 선택-->
            <div class="stltBox mg_t30">
                <?= ($data['report']['app_type'] ?? false) === 'C' ? "<div class='red_txt mg_b15'>! 기업 인터뷰는 공개 설정이 불가능합니다.</div>" : '' ?>
                <div class="stlt fl">인터뷰(리포트) 선택 <span class="point">*필수</span></div>
                <?= ($data['report'] ?? false) ? "<div class='stlt_stxt fr'><a id='reportSelect' class='a_line'>변경</a></div>" : '' ?>
            </div>

            <?php if ($data['report'] ?? false) : ?>
                <input type='hidden' name='updateIdx' value='<?= $data['report']['idx'] ?>'>
                <!--s itv_pr_reportBox-->
                <div class="itv_pr_reportBox">
                    <!--s company_top_txt-->
                    <div class="company_top_txt">
                        <span class="ctt01"><?= $data['report']['app_share_text'] ?></span>
                    </div>
                    <!--e company_top_txt-->

                    <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $data['report']['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                    <a href='detail/<?= $data['report']['idx'] ?>'>
                        <!--s txtBox-->
                        <div class="txtBox">
                            <div class="class"><?= $data['report']['repo_analysis']['grade'] ?></div>
                            <div class="tlt">[<?= $data['report']['job_depth_text'] ?>]</div>
                            <div class="question">질문 <?= $data['queCount'] ?>개</div>

                            <div class="data"><?= $data['report']['app_reg_date'] ?></div>
                        </div>
                        <!--e txtBox-->
                    </a>

                    <a href='detail/<?= $data['report']['idx'] ?>' class="itv_btn"><img src="/static/www/img/sub/itv_pr_pop_arrow_r.png"></a>
                </div>
                <!--e itv_pr_reportBox-->
            <?php else : ?>
                <div class="pl_btn c mg_t35"><a id='reportSelect'>+ 리포트 선택하기</a></div>
            <?php endif; ?>

            <!--s 이력서 첨부-->
            <div class="stltBox mg_t70">
                <div class="stlt fl">이력서 첨부 <span class="point">*필수</span></div>
                <div class="stlt_stxt fr"><a href="javascript:void(0)" class="a_line change_resume">변경</a></div>
            </div>

            <?php if ($data['report']['res_idx'] ?? false) : ?>
                <!--s gray_fileBox-->
                <div class="gray_fileBox resume_fileBox">
                    <ul>
                        <li>
                            <input type="hidden" name="resume" value="<?= $data['report']['res_idx'] ?>">
                            <div class="tlt"><?= $data['report']['res_title'] ?></div>
                            <div class="txt"><?= $data['report']['res_reg_date'] ?> 작성</div>
                            
                            <div class="resumeBtns">
                                <a href="/my/resume/modify/<?= $data['report']['resume_idx'] ?>?data=set_report&app=<?= $data['appIdx']?>">
                                    <div class="arrow"><img src="/static/www/img/sub/itv_pr_file_arrow.png"></div>
                                </a>
                                <div class="close deleteResume"><img src="/static/www/img/sub/itv_pr_file_close.png"></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--e gray_fileBox-->
            <?php else : ?>
                <!--s gray_fileBox-->
                <div class="gray_fileBox resume_fileBox">
                    <ul>
                        <li>
                            <input type="hidden" name="resume" value="">
                            이력서를 첨부해 주세요.
                        </li>
                    </ul>
                </div>
                <!--e gray_fileBox-->
            <?php endif; ?>

            <div class="pl_btn c mg_t35"><a href="/my/resume">+ 새로 작성하기</a></div>
            <!--e 이력서 첨부-->

        </div>
        <!--e contBox-->

        <!--s fix_btBtn2-->
        <div class="fix_btBtn2">
            <div class="fix_btBtn">
                <button id='sub' type='button' class="fix_btn02 wps_100 <?= ($data['report']['app_type'] ?? false) ? '' : 'fail01' ?>">저장하기</button>
            </div>
        </div>
        <!--e fix_btBtn2-->
    </div>
    <!--e scontent-->
</form>

<style>
    a,
    .resumeBtns {
        cursor: pointer;
    }
</style>