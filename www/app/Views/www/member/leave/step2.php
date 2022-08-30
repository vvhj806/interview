<script>
    let broswerInfo = navigator.userAgent;

    $(function() {
        $('#next').click(function() {
            if (!$('#agree').is(':checked')) {
                return alert('유의사항에 동의에 주세요.');
            } else {
                $('#cont1').hide();
                $('#cont2').show();
            }
        });

        $('#next2').click(function() {
            const cval = $(':radio[name="reason"]:checked').val();
            const tval = $("textarea#reasonmemo").val().trim();

            if (!$('input:radio[name=reason]').is(':checked')) {
                alert('떠나는 이유를 선택해 주세요');
                return;
            } else if (cval == '5' && tval.length == 0) {
                alert('기타사유 선택시 이유를 입력해 주세요.');
                return;
            } else {
                fnShowPop('withdrawal_pop');
            }
        });

        $('#leave').click(function() {
            if (broswerInfo.indexOf("APP_Highbuff_Android") != -1) {
                if('<?=$data['sns'] ?>' == 'G') {
                    window.interview.google_unlink();
                }
            } else if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
                if('<?=$data['sns'] ?>' == 'N') {
                    webkit.messageHandlers.naver_unlink.postMessage("");
                }
            }
            $("#frm").submit();
        });
    });
</script>


<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">회원탈퇴</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div id='cont1' class="cont cont_pd_bottom">
        <div class="stlt c">정말 하이버프를 떠나실 건가요 …? <span class="withdrawal_icon"><img src="/static/www/img/sub/withdrawal_icon.png"></span></div>

        <!--s withdrawal_txtBox-->
        <div class="withdrawal_txtBox mg_b40">
            <div class="stlt c mg_b40">혹시 이런 점이 불편하셨나요?</div>

            <div class="mg_b30">
                <div class="font25 mg_b10">알림이 너무 잦아요</div>
                <a href="/my/setting/push" class="point">푸시알림 끄기 <i class="la la-angle-right"></i></a>
            </div>

            <div class="mg_b30">
                <div class="font25 mg_b10">구직 생각이 사라졌어요</div>
                <a href="/report/share" class="point">리포트 비공개하기 <i class="la la-angle-right"></i></a>
            </div>

            <div class="font25">다른 불편사항이 있어요</div>
            <div class="stxt mg_t5 mg_b10 gray">빠르게 해결해드리도록 노력할게요! </div>
            <a href="/help/qna" class="point">1:1문의하기 <i class="la la-angle-right"></i></a>
        </div>
        <!--e withdrawal_txtBox-->

        <div class="stlt c">
            떠나시기 전, 아래 사항을<br />
            꼭 확인해 주세요
        </div>

        <!--s withdrawal_txtBox-->
        <div class="withdrawal_txtBox withdrawal_txtBox2 stxt gray leaveBox">
            <!-- 탈퇴 유의사항 -->
            <?= $data['leaveContent']['cfg_content'] ?>
        </div>
        <!--e withdrawal_txtBox-->

        <div class="chek_box checkbox mg_t20">
            <input id="agree" type="checkbox">
            <label for="agree" class="lbl black">위 내용을 모두 확인했으며, 이에 동의합니다.</label>
        </div>

        <!--s BtnBox-->
        <div class="BtnBox">
            <a href="/" class="btn btn02">취소</a>
            <button id='next' type="button" class="btn btn01">다음</button>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e contBox-->

    <!--s contBox2-->
    <div id='cont2' class="cont cont_pd_bottom hide">
        <div class="stlt">떠나시게 되는 이유를 알려주세요!</div>

        <!--s withdrawal_txtBox-->
        <div class="withdrawal_txtBox mg_b40">
            <form id="frm" method="POST" action="/my/leave/step2/action">
                <?= csrf_field() ?>
                <input type="hidden" name="postCase" value="leave_write">
                <input type="hidden" name="backUrl" value="/my/leave/step2">

                <?php foreach ($data['leave'] as $key => $val) : ?>
                    <div class="chek_box checkbox mg_b10">
                        <input id="chk<?= $key ?>" name="reason" type="radio" value='<?= $key ?>' onchange="chkEtc()">
                        <label for="chk<?= $key ?>" class="lbl black"><?= $val ?></label>
                    </div><br />
                <?php endforeach; ?>

                <div class="chek_box checkbox mg_b10">
                    <input id="chk_etc" onchange="chkEtc()" name="reason" type="radio" value='-1'>
                    <label for="chk_etc" class="lbl black">기타 (직접입력)</label>
                </div><br />

                <div class="mg_t20"><textarea name="memo" id="reasonmemo" class="ht_20 gray_bg" placeholder="문의하실 내용을 입력해 주세요" readonly></textarea></div>
            </form>
        </div>
        <!--e withdrawal_txtBox-->

        <!--s BtnBox-->
        <div class="BtnBox">
            <a href="/" class="btn btn02">취소</a>
            <button id='next2' type='button' class="btn btn01">다음</button>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e contBox2-->
</div>
<!--e #scontent-->


<!--s 탈퇴 모달-->
<div id="withdrawal_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="tlt">정말 떠나시겠어요?</div>

            <div class="txt mg_b0">
                더 좋은 서비스를 제공해드리기 위해<br />
                노력하는 하이버프가 될게요<br /><br />
                한번 더 고민해 보시면 어떨까요? <br /><br />

                <!-- <span class="stxt point">00개월간 (00일간) 재가입은 불가능해요</span> -->
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <button type='button' onclick="fnHidePop('withdrawal_pop')" class="spop_btn01">조금 더 있을게요</button>
            <button id="leave" type='button' class="spop_btn02">탈퇴하기</button>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 탈퇴 모달-->

<script>
    function chkEtc() {
        var listVar = $('input[name=reason]:checked').val();
        // console.log(listVar);
        if (listVar == '-1') {
            $("#reasonmemo").removeAttr("readonly");
            $("#reasonmemo").removeClass('gray_bg');
        } else {
            $("#reasonmemo").val('');
            $("#reasonmemo").attr("readonly", true);
            $("#reasonmemo").addClass('gray_bg');
        }
    }
</script>

<style>
    button {
        border: none;
    }

    .gray_bg {
        background-color: #efefef;
    }
</style>