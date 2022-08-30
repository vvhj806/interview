<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/main">
                <div class="backBtn"><span>뒤로가기</span></div>
                <a href="javascript:void(0)" onclick="fnShowPop('again_modal')" class="top_gray_txtlink gray_txtlink">재응시 요청이란?</a>
            </a>
            <div class="tlt">지원 현황</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_tab-->
    <div class="top_tab">
        <!--s depth-->
        <ul class="depth2 wd_2_2">
            <li class="on"><a href="completed">지원 완료</a></li>
            <li><a href="again">재응시 요청</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s contBox-->
    <div class="cont">
        <!--s support_list-->
        <div class="support_list">
            <ul>

                <li class="no_list <?= $data['list'] ? 'hide' : '' ?>" style='height: auto'>
                    <!-- 리스트없을때 -->
                    <div class="ngp"><span>!</span></div>
                    지원한 공고가 없어요!
                </li>

                <?php foreach ($data['list'] as $row) : ?>
                    <li data-rec_info='<?= $row['recInfoIdx'] ?>'>
                        <!--s sp_cont-->
                        <div class="sp_cont">
                            <!--s txt_l-->
                            <div class="txt_l">
                                <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                    <div class="tlt"><?= $row['comName'] ?></div>
                                    <div class="product_desc"><?= $row['recTitle'] ?></div>

                                    <div class="gtxtBox">
                                        <div class="gtxt"><?= $row['areaDepth1'] ?> <span>|</span> <?= $row['recCareer'] ?></div>
                                    </div>
                                </a>
                            </div>
                            <!--e txt_l-->

                            <!--s txt_r-->
                            <div class="txt_r r">
                                <div class="d_day">
                                    <?php if ($row['recEndDate'] === '마감') : ?>
                                        마감
                                    <?php else : ?>
                                        <span class="point"><?= $row['recEndDate'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($row['recEndDate'] != '마감' && $row['appType'] === 'C') : ?>
                                    <?php if ($row['againReqIdx']) : ?>
                                        <button class="sp_btn">재응시 요청 중</button>
                                    <?php else : ?>
                                        <button class="sp_btn" value='again'>재응시 요청</button>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <button class="sp_btn" value='cancel'>지원 취소</button>
                            </div>
                            <!--e txt_r-->
                        </div>
                        <!--e sp_cont-->
                    </li>
                <?php endforeach; ?>
            </ul>
            <?= $data['pager']->links('completed', 'front_full') ?>
        </div>
        <!--e support_list-->
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<!--s 지원취소 모달-->
<div id="support_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div id='cancelComName' class="tlt mg_b20"></div>

            <div class="txt mg_b0">
                <span id='cancelRecTitle'></span><br />
                지원을 취소하시겠어요?
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <form id="frm1" method="post" action="/my/recruit_info/delete">
            <?= csrf_field() ?>
            <div class="spopBtn radius_none">
                <button type='button' class="spop_btn01" onclick="fnHidePop('support_pop')">아니요</button>
                <button id='cancelBtn' type='submit' name='recInfoIdx' value='' class="spop_btn02">네, 취소할래요</button>
            </div>
        </form>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 지원취소 모달-->

<!--s area_pop-->
<div id="re_examination_pop" class="pop_modal2">
    <form id="frm2" method="post" action="/my/recruit_info/againAction">
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
                            <div class="tlt l">재응시 요청하기</div>
                            <a href="javascript:void(0)">
                                <div class="countBox" onclick="fnHidePop('re_examination_pop')">취소하기</div>
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

                    <?= csrf_field() ?>
                    <div class="cont_pd cont_pd_bottom">
                        <!--s interview_pr_gytltBox-->
                        <div class="interview_pr_gytltBox gray_back">
                            <div id='againComName' class="tlt"></div>
                            <div id='againRecTitle' class="txt"></div>
                        </div>
                        <!--e interview_pr_gytltBox-->

                        <div class="stlt mg_t60"><span class="point">*</span> 요청 사유 선택</div>

                        <!--s selBox-->
                        <!-- <div class="selBox wps_100">
                            
                            <div class="selectbox wps_100">
                                <dl class="dropdown big wps_100">
                                    <dt><a href="javascript:void(0)" class="myclass">기기 오류로 인한 인터뷰 중단</a></dt>
                                    <dd>
                                        <ul class="dropdown2" style="display: none;">
                                            <li><a href="javascript:void(0)">기기 오류로 인한 인터뷰 중단</a></li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                     
                        </div> -->
                        <!--e selBox-->

                        <textarea name="memText" class="ht_40" placeholder="상세 사유를 입력해 주세요"></textarea>

                        <!--s gray_txtBox-->
                        <div class="gray_txtBox c mg_t50">
                            제출한 요청은 마이페이지 > 지원현황 > 재응시요청에서<br />
                            확인하실 수 있으며, 기업에서 요청을 수락할 시<br />
                            해당 인터뷰를 처음부터 재응시 하실 수 있습니다.
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
            <button id='againBtn' type='submit' name='recInfoIdx' value='' class="fix_btn02 wps_100">요청 제출하기</button>
        </div>
        <!--e fix_btBtn-->
    </form>
</div>
<!--e area_pop-->

<script>
    $(document).ready(function() {
        $('.sp_btn').on('click', function() {
            const thisBtn = $(this);
            const thisType = thisBtn.val();
            const thisList = thisBtn.closest('li');
            const comName = thisList.find('.tlt').text();
            const recTitle = thisList.find('.product_desc').text();
            const recInfoIdx = thisList.data('rec_info');

            $(`#${thisType}ComName`).text(comName);
            $(`#${thisType}RecTitle`).text(recTitle);
            $(`#${thisType}Btn`).val(recInfoIdx);

            if (thisType == 'cancel') {
                fnShowPop('support_pop');
            } else if (thisType == 'again') {
                fnShowPop('re_examination_pop');
            }
        });
    });
</script>
<style>
    button {
        border: none;
    }
</style>