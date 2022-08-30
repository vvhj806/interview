<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">
                <?= $data['suggest']['sug_type'] ?> 제안
                <input id='member' type='hidden' value="<?= $data['session']['idx'] ?>">
            </div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="cont cont_pd_bottom">

        <!--s support_list-->
        <div class="support_list c">
            <ul>
                <li>
                    <!--s sp_cont-->
                    <div class="sp_cont">
                        <!--s txt_l-->
                        <div class="txt_l wps_100">
                            <a href="javascript:void(0)">
                                <div class="tlt"><?= $data['suggest']['com_name'] ?></div>
                                <div class="product_desc"></div>

                                <div class="gtxtBox">
                                    <div class="gtxt"><?= $data['suggest']['sug_type'] ?> 제안이 도착했습니다</div>
                                </div>
                            </a>
                        </div>
                        <!--e txt_l-->

                        <div class="BtnBox mg_t30">
                            <a href="/company/detail/<?= $data['suggest']['comIdx'] ?>" class="btn btn02 wps_100">기업정보 보기</a>
                        </div>
                    </div>
                    <!--e sp_cont-->
                </li>
            </ul>
        </div>
        <!--e support_list-->

        <!--s gy_infoBox-->
        <div class="gy_infoBox mg_b15">
            <div class="iconBox">
                <div class="img"><img src="/static/www/img/sub/gy_info_icon01.png"></div>
            </div>

            <div class="txtBox"><?= $data['suggest']['sug_massage'] ?></div>
        </div>
        <!--e gy_infoBox-->

        <?php if ($data['suggest']['sug_manager'] === 'O') : ?>
            <!--s gy_infoBox-->
            <div class="gy_infoBox">
                <div class="iconBox">
                    <div class="img"><img src="/static/www/img/sub/gy_info_icon02.png"></div>
                </div>

                <div class="txtBox">
                    담당자: <?= $data['suggest']['sug_manager_name'] ?>
                    <br>연락처: <?= $data['suggest']['sug_manager_tel'] ?>
                </div>
            </div>
            <!--e gy_infoBox-->
        <?php endif; ?>

        <div class="itv_pr_preview_btn c mg_t40 mg_b70"><a href="javascript:void(0)" class="a_line" onclick="fnShowPop('cut_off_pop')">이 기업 차단하기</a></div>

        <!--s fix_btBox-->
        <div class="fix_btBox fix_btBtn2 <?= $data['suggest']['sug_end_date'] < date('Y.m.d') ? 'hide' : '' ?>">
            <div class="fix_btBtn">
                <a href="javascript:void(0)" class="fix_btn01 fix_btn01_gray" onclick="fnShowPop('refusal_pop')">거절하기</a>
                <a href="javascript:void(0)" class="fix_btn02">
                    <div class="lh11 mg_tt <?= $data['suggest']['sug_type'] != '인터뷰' ? 'ok' : 'interviewSubmit'  ?>">
                        제안 승낙<?= $data['suggest']['sug_type'] === '인터뷰' ? '하고 인터뷰 시작하기' : '' ?>
                        <div class="data"><?= $data['suggest']['sug_end_date'] ?> 까지</div>
                    </div>
                </a>
            </div>
        </div>
        <!--e fix_btBox-->

    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<!--s 기업차단 모달-->
<div id="cut_off_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="tlt mg_b20">기업차단하기</div>

            <div class="txt mg_b0">
                <?= $data['suggest']['com_name'] ?>을 차단하시겠어요?<br /><br />

                나의 AI리포트 열람 및 <br />
                모든 제안 보내기가 차단됩니다.
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <a href="#n" class="spop_btn01" onclick="fnHidePop('cut_off_pop')">취소</a>
            <button type='button' value='<?= $data['suggest']['comIdx'] ?>' class="spop_btn02">차단하기</button>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 기업차단 모달-->
<script>
    $(document).ready(function() {
        $('.ok').on('click', function() {
            fnShowPop('accept_pop');
        });

        $('.interviewSubmit').on('click', function() {
            $('#frm1').submit();
        });

        $("form").on("submit", function(event) {
            event.preventDefault();
            if ($(this).attr('id') == 'frm2') {

                if (!$('input[name="refuseType"]:checked').val()) {
                    return alert('거절 사유는 필수입니다.');
                }
            }
            if (!confirm('승낙 하시겠습니까?')) {
                return;
            }
            this.submit();
        });

        $('.spop_btn02').on('click', function() {
            const comIdx = $(this).val();
            const memIdx = $('#member').val();
            $.ajax({
                type: 'GET',
                url: `/api/my/restrictions/add/${memIdx}/${comIdx}`,
                success: function(data) {
                    alert(data.messages);
                    return;
                },
                error: function(e) {
                    alert(e.responseJSON.messages);
                    return;
                },
                timeout: 5000
            }); //ajax
            fnHidePop('cut_off_pop');
        })
    });
</script>

<style>
    button {
        border: none;
    }
</style>