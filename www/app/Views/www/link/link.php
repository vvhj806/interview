<?php
isset($data['checkAppApplierStat']) ? $data['checkAppApplierStat'] : $data['checkAppApplierStat']['app_iv_stat'] = null;
?>

<form action="/linkInterview/linkAction" method="POST" id="urlInterview">
    <?= csrf_field() ?>
    <input type="hidden" name="memId" value="<?= $data['memId'] ?>">
    <input type="hidden" name="memName" value="<?= $data['memName'] ?>">
    <input type="hidden" name="memTel" value="<?= $data['applicantInfo']['sug_app_phone'] ?>">
    <input type="hidden" name="enAppIdx" value="<?= $data['enAppIdx'] ?>">
    <!--s #scontent-->
    <div id="scontent">
        <!--s gray_bline_first-->
        <div class="gray_bline_first mg_t20 c">
            <!--s contBox-->
            <div class="contBox">
                <div class="top_jbBox c mg_t35">
                    <div class="txt">
                        <div class="font23 mg_b10 black">
                            <?= $data['memName'] ?? '사용자' ?>님의<br />
                            <span class="point">A.I. 인터뷰 정보</span>를 확인해 주세요
                        </div>
                    </div>
                </div>

            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->

        <!--s cont-->
        <div class="cont cont_pd_bottom">
            <!--s inp_dlBox-->
            <div class="inp_dlBox inp_dlBox_line">
                <dl class="inp_dl">
                    <dt class="point">지원기업</dt>
                    <dd><?= $data['getSuggestInfo']['com_name'] ?></dd>
                </dl>
                <dl class="inp_dl">
                    <dt class="point">지원분야</dt>
                    <dd><?= $data['applicantInfo']['sug_app_title'] ?></dd>
                </dl>
                <dl class="inp_dl">
                    <dt class="point">인터뷰 응시기한</dt>
                    <dd><?= $data['endDate'] ?> 까지</dd>
                </dl>
            </div>
            <!--e inp_dlBox-->

            <?php if ($data['checkPersonal'] != 'Y' || $data['checkPersonal'] == '') : ?>
                <div class="chek_box checkbox">
                    <input id="agree" class="chk-each" name="mem_personal_agree" type="checkbox" value="Y" onchange="startAgreeCk()">
                    <label for="agree" class="lbl"><a href="javascript:;" class="bline pop_chek02 color_black">이용약관</a> 및 <a href="javascript:;" class="bline pop_chek01 color_black">개인정보 처리방침</a>에 동의(필수)</label>
                </div>
            <?php endif; ?>

            <?php if (!$data['checkAppApplierStat']['app_iv_stat'] || $data['checkAppApplierStat']['app_iv_stat'] < 2 || !$data['checkAppApplier']['app_idx']) : ?>

                <!--s BtnBox-->
                <div class="BtnBox">
                    <a href="javascript:void(0)" class="btn btn01" onclick="startItv()">확인</a>
                    <a href="javascript:void(0)" class="btn btn03" onclick="alert('인터뷰를 진행하셔야 결과보기가 가능합니다. 확인을 눌러 인터뷰를 진행해주세요.')">결과보기</a>
                </div> 
                <!--e BtnBox-->

            <?php else : ?>
                <?php $inter_opportunity_n = ''; ?>
                <!--s BtnBox-->
                <div class="BtnBox">
                    <?php if ($data['againRequest']) : ?>
                        <a href="javascript:void(0)" class="btn btn01" id="requestState">재응시요청중</a>
                    <?php else : ?>
                        <?php if ($data['applicantInfo']['inter_opportunity_yn'] == 'Y') : ?>
                            <a href="javascript:void(0)" class="btn btn01" onclick="fnShowPop('retake_pop')">재응시요청</a>
                        <?php else :
                            $inter_opportunity_n = 'style="width: 100%;"';
                        endif; ?>
                    <?php endif; ?>
                    <?php if ($data['checkAppApplierStat']['app_iv_stat'] == 4) : ?>
                        <a href="javascript:void(0)" class="btn btn02" id="resultPage" <?= $inter_opportunity_n ?>>결과보기</a>
                    <?php else : ?>
                        <a href="javascript:void(0)" class="btn btn03" onclick="alert('<?= $data['checkAppApplierStat']['app_iv_stat'] == 3 ? 'A.I. 채점 중입니다. 완료 후 확인하실 수 있습니다.' : ($data['checkAppApplierStat']['app_iv_stat'] == 5 ? '인터뷰가 A.I. 분석불가입니다. 재응시 불가능한 인터뷰입니다. 문의사항은 담당자에게 연락바랍니다.' :'인터뷰를 완료하지 못하고 종료되었습니다. 재응시 불가능한 인터뷰입니다. 문의사항은 담당자에게 연락바랍니다.') ?>')" <?= $inter_opportunity_n ?>>결과보기</a>
                    <?php endif; ?>
                </div>
                <!--e BtnBox-->
            <?php endif; ?>
        </div>
        <!--e cont-->
    </div>
    <!--e #scontent-->


    <!--s 확인 모달-->
    <div id="confirm_pop" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="tlt">꼭 확인해주세요</div>

                <div class="txt gray mg_b0">
                    A.I. 면접영상과 음성데이터는<br />
                    귀하가 지원한 기업에게만 제공이 되며,<br />
                    채용전형이 종료되면 삭제하실 수 있습니다.
                </div>
            </div>
            <!--e pop_cont-->

            <!--s spopBtn-->
            <div class="spopBtn radius_none">
                <a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('confirm_pop')">닫기</a>
                <a href="javascript:void(0)" class="spop_btn02" id="startInterview">시작하기</a>
            </div>
            <!--e spopBtn-->
        </div>
        <!--e pop_Box-->
    </div>
    <!--s 확인 모달-->

    <!--s 확인 모달-->
    <div id="retake_pop" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="tlt mg_b10">재응시 요청</div>
                <div class="txt gray">재응시 요청 사유를 작성해주세요</div>

                <textarea name="" id="requestText" placeholder=" 내용을 입력해 주세요"></textarea>
            </div>
            <!--e pop_cont-->

            <!--s spopBtn-->
            <div class="spopBtn radius_none">
                <a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('retake_pop')">닫기</a>
                <a href="javascript:void(0)" class="spop_btn02" id="request">요청하기</a>
            </div>
            <!--e spopBtn-->
        </div>
        <!--e pop_Box-->
    </div>
    <!--s 확인 모달-->
</form>

<script>
    let agreeCk = 0;

    if ("<?= $data['checkPersonal'] ?>" == 'Y' && "<?= $data['checkPersonal'] ?>" != '') {
        agreeCk = 1;
    }

    function startItv() {
        if (agreeCk == 0) {
            alert('이용약관 및 개인정보 처리방침에 동의해주세요.');
        } else {
            fnShowPop('confirm_pop');
        }
    }

    function startAgreeCk() {
        if ($('#agree').is(':checked') == true) {
            agreeCk = 1;
        } else {
            agreeCk = 0;
        }
    }

    $('#startInterview').on('click', function() {
        if ('<?= $data['applyWhether'] ?>' == 'Y') {
            $('#urlInterview').submit();
        } else {
            alert('응시기한이 지났습니다.');
        }
    });

    $('#requestState').on('click', function() {
        alert('재응시요청중입니다');
    })

    $('#resultPage').on('click', function() {
        location.href = '/report/detail2/' + '<?= $data['enApplierIdx'] ?>';
    });

    $('#request').on('click', function() {
        let requestText = $('#requestText').val();

        if (requestText == '' || requestText == null) {
            alert('내용을 입력해주세요.');
        } else {
            $.ajax({
                type: "POST",
                url: `/api/link/requestAction`,
                data: {
                    'csrf_highbuff': $('input[name="csrf_highbuff"]').val(),
                    'requestText': requestText,
                    'sugAppIdx': '<?= $data['enAppIdx'] ?>',
                    'comIdx': '<?= $data['getSuggestInfo']['com_idx'] ?>',
                },
                success: function(data) {
                    if (data.status == 200) {
                        alert('재응시요청이 완료되었습니다.');
                        location.reload();
                    } else {
                        alert(data.messages);
                    }
                },
                error: function(e) {
                    params['emlCsrf'].val(e.responseJSON.code.token);
                    alert(e.responseJSON.messages);
                },
            }) //ajax
        }
    });
</script>