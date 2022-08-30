<!--s refusal_pop-->
<div id="refusal_pop" class="pop_modal2">
    <form id="frm2" method="POST" action="/my/suggest/refuse/<?= $data['suggestIdx'] ?>">
        <?= csrf_field() ?>
        <!--s pop_full-->
        <div class="pop_full">
            <!--s pop_full_cont-->
            <div class="pop_full_cont">
                <!--s pop_full_cont2-->
                <div class="pop_full_cont2">
                    <!--s top_tltBox-->
                    <div class="top_tltBox c">
                        <!--s top_tltcont-->
                        <div class="top_tltcont">
                            <div class="tlt l">제안 거절하기</div>
                            <a href="javascript:void(0)">
                                <div class="countBox" onclick="fnHidePop('refusal_pop')">취소하기</div>
                            </a>
                        </div>
                        <!--e top_tltcont-->
                    </div>
                    <!--e top_tltBox-->
                </div>
                <!--e pop_full_cont2-->

                <!--s pop_full_scroll-->

                <div class="pop_full_scroll">
                    <!--s cont_pd-->
                    <div class="cont_pd cont_pd_bottom">
                        <!--s selBox-->
                        <div class="selBox wps_100">
                            <!--s selectbox-->
                            <div class="selectbox wps_100">
                                <dl class="dropdown big wps_100">
                                    <dt><a href="javascript:void(0)" id='drop' class="myclass">거절사유 선택</a></dt>
                                    <dd>
                                        <ul class="dropdown2" style="display: none;">
                                            <li><label>거절사유 선택<input name='refuseType' class='hidden' type='radio' value=''></label></li>
                                            <li><label>경력 불일치<input name='refuseType' class='hidden' type='radio' value='A'></label></li>
                                            <li><label>희망 직무 불일치<input name='refuseType' class='hidden' type='radio' value='B'></label></li>
                                            <li><label>희망 업종 불일치<input name='refuseType' class='hidden' type='radio' value='C'></label></li>
                                            <li><label>희망근무조건 불일치<input name='refuseType' class='hidden' type='radio' value='D'></label></li>
                                            <li><label>기타<input name='refuseType' class='hidden' type='radio' value='Z'></label></li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                            <!--e selectbox-->
                        </div>
                        <!--e selBox-->

                        <textarea name="massage" class="ht_40" placeholder="상세 내용 입력 (선택)"></textarea>

                        <!--s gray_txtBox-->
                        <div class="gray_txtBox c mg_t50">
                            *안심하세요! 거절에 따른 불이익은 전혀 없습니다.
                        </div>
                        <!--e gray_txtBox-->
                    </div>
                    <!--e cont_pd-->


                </div>

                <!--e pop_full_scroll-->
            </div>
            <!--e pop_full_cont-->
        </div>
        <!--e pop_full-->
        <!--s fix_btBtn-->
        <div class="fix_btBtn fix_btnMod">
            <button type='submit' class="fix_btn02 wps_100">제출</button>
        </div>
        <!--e fix_btBtn-->
    </form>
</div>
<!--e refusal_pop-->
<script>
    $('.dropdown2 > li').on('click', function() {
        let text = $(this).text();
        $('#drop').text(text);
        $('.dropdown2').hide();
    });
</script>