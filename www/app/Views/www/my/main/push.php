<?php
// print_r($data['PushInfo']);
// return;
?>
<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">푸시 알림 설정</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first pd_b0">
        <!--s mypageUl-->
        <ul class="mypageUl mypageUl_setting">
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">추천 채용정보</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['recommend'] == "Y") :
                                $checkR = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkR = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="Recommend" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['recommend'] ?>" <?= $checkR ?>>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">공지사항/이벤트알림</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['notice_event'] == "Y") :
                                $checkNE = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkNE = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="NoticeEvent" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['notice_event'] ?>" <?= $checkNE ?>>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
        </ul>
        <!--e mypageUl-->
    </div>
    <!--e gray_bline_first-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first pd_b0">
        <!--s mypageUl-->
        <ul class="mypageUl mypageUl_setting">
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">내 리포트 기업이 열람</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['report_read'] == "Y") :
                                $checkrRR = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkrRR = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="reportRead" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['report_read'] ?>" <?= $checkrRR ?>>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">기업 제안 도착</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['company_proposal'] == "Y") :
                                $checkCP = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkCP = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="companyProposal" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['company_proposal'] ?>" <?= $checkCP ?>>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">재응시 요청 수락</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['retry_request_accept'] == "Y") :
                                $checkRRA = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkRRA = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="retryRequestAccept" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['retry_request_accept'] ?>" <?= $checkRRA ?>>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
        </ul>
        <!--e mypageUl-->
    </div>
    <!--e gray_bline_first-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first pd_b0">
        <!--s mypageUl-->
        <ul class="mypageUl mypageUl_setting">
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">즐겨찾기한 공고 마감 1일전</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['scrap_deadline'] == "Y") :
                                $checkRRA = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkRRA = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="scrapDeadline" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['scrap_deadline'] ?>" $checkSD>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
            <li>
                <!--s st_box-->
                <div class="st_box">
                    <div class="txt fl">즐겨찾기한 기업의 신규 공고</div>

                    <!--s toggleBox-->
                    <div class="toggleBox fr">
                        <div class="lcs_wrap">
                            <?php if ($data['PushInfo']['scrap_new_recurit'] == "Y") :
                                $checkSNR = "checked";
                                $lcs = "lcs_on";
                            else :
                                $checkSNR = "";
                                $lcs = "lcs_off";
                            endif;
                            ?>
                            <input type="checkbox" id="scrapNewRecurit" class="lcs_check" autocomplete="off" value="<?= $data['PushInfo']['scrap_new_recurit'] ?>" <?= $checkSNR ?>>
                            <div class="lcs_switch  <?=$lcs?> lcs_checkbox_switch">
                                <!-- 클래스에 lcs_on lcs_off로 설정됨 -->
                                <div class="lcs_cursor"></div>
                            </div>
                        </div>
                    </div>
                    <!--e toggleBox-->
                </div>
                <!--e st_box-->
            </li>
        </ul>
        <!--e mypageUl-->
    </div>
    <!--e gray_bline_first-->
</div>
<!--e #scontent-->
<?= csrf_field() ?>
<script>
    let check_arr = [];
    //체크박스
    $(document).ready(function(e) {
        $('.toggleBox input').lc_switch();

        // triggered each time a field changes status
        $(document).on('lcs-statuschange', '.lcs_check', function() {
            let status = ($(this).is(':checked')) ? 'checked' : 'unchecked',
                subj = ($(this).attr('type') == 'radio') ? 'radio #' : 'checkbox #',
                num = ($(this).is(':checked')) ? $(this).val('Y') : $(this).val('N');
            push();
        });
    });

    function push() {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");

        $.ajax({
            type: 'POST',
            url: '/api/my/push/alarm',
            data: {
                'Recommend': $('#Recommend').val(),
                'NoticeEvent': $('#NoticeEvent').val(),
                'reportRead': $('#reportRead').val(),
                'companyProposal': $('#companyProposal').val(),
                'retryRequestAccept': $('#retryRequestAccept').val(),
                'scrapDeadline': $('#scrapDeadline').val(),
                'scrapNewRecurit': $('#scrapNewRecurit').val(),
                '<?= csrf_token() ?>': emlCsrf.val(),
                'postCase': 'alarmCheck',
                'BackUrl': '/',
            },
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    
                } else {
                    alert(data.messages);
                    return false;
                }
                return true;
            },
            error: function(e) {
                alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                return;
            }
        }) //ajax;
    }
</script>