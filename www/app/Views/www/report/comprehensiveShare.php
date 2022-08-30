<script>
    $(document).ready(function() {
        $('input[type="radio"]').on('change', function() {
            if ($(this).val() === 'off') {
                $('input[name="shareCompany"]').prop('checked', false);
            } else if ($(this).attr('name') === 'shareCompany') {
                $('#shareOn').prop('checked', true);
            }
        });

        $("#sub").on("click", function() {
            // if (!$('input[name="updateIdx"]').val()) {
            //     return alert2('리포트를 선택해주세요.');
            // }

            if ($('#shareOn').is(':checked')) {
                fnShowPop('alert_pop');
            } else {
                $('#frm').submit();
            }
        });

    });
</script>
<form id="frm" method="POST" action="/report/share/action/comprehensive">
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
                <div class="tlt">공개설정</div>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s contBox-->
        <div class="cont pd_t0">
            <div id='share_type' class="stltBox mg_t70"></div>

            <!--s line_btnBox-->
            <div class="line_btnBox c mg_t0">
                <input id='suggest' type='radio' class='hide' name='shareCompany' value='all' <?= (($data['report']['app_share_company'] ?? false) === '2') ? 'checked' : '' ?>>
                <label for='suggest' class="wps_100">
                    <div class="line_btn_tlt">기업에게 바로 제안받기요!</div>
                    <div class="line_btn_txt">연락처와 리포트를 모두 공개합니다</div>
                </label>

                <input id='phone' type='radio' class='hide' name='shareCompany' value='half' <?= (($data['report']['app_share_company'] ?? false) === '1') ? 'checked' : '' ?>>
                <label for='phone' class="wps_100">
                    <div class="line_btn_tlt">제안 먼저 확인하기!</div>
                    <div class="line_btn_txt">연락처를 제외하고 공개됩니다</div>
                </label>
                <input id='shareOn' type='radio' class='hide' name='share' value='on' <?= (($data['report']['app_share'] ?? false) === '1') ? 'checked' : '' ?>>
                <label for='shareOn' class="wps_100">
                    <div class="line_btn_tlt">내 리포트 자랑하기!</div>
                    <div class="line_btn_txt">
                        연락처와 인적사항을 제외한 내 리포트가<br />
                        다른 지원자에게 공개됩니다
                    </div>
                </label>
                <input id='shareOff' type='radio' class='hide' name='share' value='off' <?= (($data['report']['app_share'] ?? false) === '0') ? 'checked' : '' ?>>
                <label for='shareOff' class="wps_100">
                    <div class="line_btn_tlt">비공개하기</div>
                    <div class="line_btn_txt">내 연락처와 AI리포트를 공개하지 않습니다</div>
                </label>
            </div>
            <!--e line_btnBox-->
            <input type='hidden' name='updateIdx' value='<?= $data['report']['idx'] ?>'>
        </div>
        <!--e contBox-->

        <!--s fix_btBtn2-->
        <div class="fix_btBtn2">
            <div class="fix_btBtn">
                <button id='sub' type='button' class="fix_btn02 wps_100 <?= ($data['report']['app_type'] ?? false) ? '' : 'fail01' ?>">저장</button>
            </div>
        </div>
        <!--e fix_btBtn2-->
    </div>
    <!--e scontent-->

    <!--s 알림 모달-->
    <div id="alert_pop" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="tlt mg_b20">
                    리포트 동영상이 공개됩니다.
                </div>

                <div class="txt mg_b0">
                    공개 하시겠어요?
                </div>
            </div>
            <!--e pop_cont-->

            <!--s spopBtn-->
            <div class="spopBtn radius_none">
                <a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('alert_pop')">아니요</a>
                <button type='submit' class="spop_btn02">네</button>
            </div>
            <!--e spopBtn-->
        </div>
        <!--e pop_Box-->
    </div>
    <!--s 알림 모달-->

</form>

<style>
    a,
    .resumeBtns {
        cursor: pointer;
    }
</style>