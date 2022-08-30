<!--s #scontent-->
<div id="changeReport" class="pop_modal2">
    <div class="pop_full_cont pop_full">
        <!--s top_tltBox-->
        <div class="top_tltBox c">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <div class="tlt">AI리포트 변경</div>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s contBox-->
        <div class="cont cont_pd_bottom" style='overflow:scroll; height:100%; padding: 0px 1rem 250px 1rem'>
            <!--s big_itv_pr_report_list-->
            <div class="big_itv_pr_report_list">
                <?= csrf_field() ?>
                <input type='hidden' name='report_page' value='<?= $data['pager'] ?>'>

                <li class="no_list <?= $data['report'] ? 'hide' : '' ?>" style='height: auto'>
                    <!-- 리스트없을때 -->
                    <div class="ngp"><span>!</span></div>
                    A.I. 리포트가 없어요!
                </li>

                <?php foreach ($data['report'] as $repoVal) : ?>
                    <!--s big_itv_pr_report2-->
                    <div class="big_itv_pr_report2">
                        <!--s itv_pr_reportBox-->
                        <div class="itv_pr_reportBox">
                            <?php if ($repoVal['app_share'] == 0) : ?>
                                <div class="top_txt">비공개</div>
                            <?php else : ?>
                                <div class="top_txt">공개</div>
                            <?php endif; ?>

                            <input type="hidden" name="report" value="<?= $repoVal['idx'] ?>">

                            <a href="javascript:void(0)">
                                <div class="imgBox"><img src="https://media.highbuff.com<?= $repoVal['file_save_name'] ?>"></div>
                            </a>
                            <a href="javascript:void(0)">
                                <!--s txtBox-->
                                <div class="txtBox">
                                    <div class="class"><?= $repoVal['repo_analysis'] ?></div>
                                    <div class="tlt">[ <?= $repoVal['job_depth_text'] ?> ]</div>
                                    <div class="question">질문 <?= $repoVal['queCount'] ?>개</div>
                                    <div class="data"><?= $repoVal['app_reg_date'] ?></div>
                                </div>
                                <!--e txtBox-->
                            </a>

                            <a href="/report/detail/<?= $repoVal['idx'] ?>" class="itv_btn"><img src="/static/www/img/sub/itv_pr_pop_arrow_r.png"></a>

                            <!--s rs_chkBox-->
                            <div class="rs_chkBox hide" data-idx='<?= $repoVal['idx'] ?>'>
                                <div class="chk_icon point"><i class="la la-check"></i></div>
                            </div>
                            <!--e rs_chkBox-->
                        </div>
                        <!--e itv_pr_reportBox-->
                    </div>
                    <!--e big_itv_pr_report2-->
                <?php endforeach ?>
            </div>
        </div>
        <!--e contBox-->


    </div>
    <!--s ard_btnBox-->
    <div class="fix_btnMod ard_btnBox " style='z-index:4;'>
        <!--s ard_btn_cont-->
        <div class="ard_btn_cont">
            <!--s ard_btn-->
            <div class="BtnBox mg_t0 " id="reportBtnBox">
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
    let selectIdx = '';
    let selectEle = '';
    let list = '';
    let scrollFlag = true;

    $(document).on('click', '.big_itv_pr_report2', function() {
        $('.rs_chkBox').addClass('hide');
        let thisEle = $(this).find('.rs_chkBox');
        thisEle.removeClass('hide');
        selectIdx = thisEle.data('idx');
        selectEle = $(this).html();
    });

    $('.cont_pd_bottom').scroll(function() {
        if (scrollFlag) {
            let height = $(this).prop('scrollHeight') - 100;
            let nowHeight = $(this).scrollTop() + $(this).innerHeight();
            let csrfEle = $("input[name='csrf_highbuff']");
            let pageEle = $('input[name="report_page"]');
            if (height < nowHeight) {
                scrollFlag = false;
                $.ajax({
                    type: 'POST',
                    url: `/report/change?page_report=${pageEle.val()}`,
                    data: {
                        '<?= csrf_token() ?>': csrfEle.val(),
                    },
                    async: false,
                    success: function(data) {
                        let json = JSON.parse(data);
                        $('.big_itv_pr_report_list').append(json['view']);

                        for (let i = 0, max = json['view'].length; i < max; i++) {
                            repoApeend(json['view'][i]);
                        }

                        csrfEle.val(json['code']['token']);
                        pageEle.val(json['next']);

                        if (json['code']['stat'] == 'last') {
                            $('.big_itv_pr_report_list').append('마지막 페이지 입니다.');
                            return scrollFlag = false;
                        }
                        scrollFlag = true;
                    },
                    error: function(e) {
                        return;
                    },
                    timeout: 5000
                }); //ajax
            }
        }
    })

    function repoApeend(aData) {
        let share = '공개';
        if (aData['app_share'] == 0) {
            share = '비공개';
        }
        $('.big_itv_pr_report_list').append(
            `<div class="big_itv_pr_report2">
                <div class="itv_pr_reportBox">
                    <div class="top_txt">${share}</div>

                    <input type="hidden" name="report" value="${ aData['idx'] }">

                    <a href="javascript:void(0)">
                        <div class="imgBox"><img src="https://media.highbuff.com${ aData['file_save_name'] }"></div>
                    </a>
                    <a href="javascript:void(0)">
                        <div class="txtBox">
                            <div class="class">${ aData['repo_analysis'] }</div>
                            <div class="tlt">[ ${ aData['job_depth_text'] } ]</div>
                            <div class="question">질문 ${ aData['queCount'] }개</div>
                            <div class="data">${ aData['app_reg_date'] }</div>
                        </div>
                    </a>

                    <a href="report/detail${ aData['idx'] }" class="itv_btn"><img src="/static/www/img/sub/itv_pr_pop_arrow_r.png"></a>

                    <div class="rs_chkBox hide" data-idx='${ aData['idx'] }'>
                        <div class="chk_icon point"><i class="la la-check"></i></div>
                    </div>
                </div>
            </div>`
        );

    }
</script>