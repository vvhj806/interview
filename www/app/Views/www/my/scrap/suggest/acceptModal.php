<!--s accept_pop-->
<div id="accept_pop" class="pop_modal2">
    <form id="frm1" method="POST" action="/my/suggest/accept<?= $data['suggest']['sug_type'] === '인터뷰' ? 'Interview' : '' ?>/<?= $data['suggestIdx'] ?>">
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
                            <div class="tlt l">제안 승낙하기</div>
                            <a href="javascript:void(0)">
                                <div class="countBox" onclick="fnHidePop('accept_pop')">취소하기</div>
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
                        <textarea name="massage" class="ht_40" placeholder="상세 내용 입력 (선택)"></textarea>
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
<!--e accept_pop-->