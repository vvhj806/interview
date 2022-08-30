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
            <li><a href="completed">지원 완료</a></li>
            <li class="on"><a href="again">재응시 요청</a></li>
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
                    재응시 요청이 없어요!
                </li>

                <?php foreach ($data['list'] as $row) : ?>
                    <li data-rec_idx='<?= $row['recIdx'] ?>' data-que_count='<?= $row['queCount'] ?>'>
                        <!--s sp_cont-->
                        <div class="sp_cont">
                            <!--s txt_l-->
                            <div class="txt_l">
                                <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                    <div class="tlt"><?= $row['comName'] ?></div>
                                    <div class="product_desc"><?= $row['recTitle'] ?></div>

                                    <div class="gtxtBox">
                                        <div class="black">요청 사유 : <?= $row['textMem'] ?></div>
                                        <div class="gtxt"><?= $row['againDate'] ?></div>
                                    </div>
                                </a>
                            </div>
                            <!--e txt_l-->

                            <!--s stateBox-->
                            <div class="stateBox">
                                <span class="<?= $row['hrStateCode'] ?>"><?= $row['hrState'] ?></span>
                            </div>
                            <!--e stateBox-->

                        </div>
                        <!--e sp_cont-->
                        <?php if ($row['hrStateCode'] === 'st03') : ?>
                            <!--s state_btnBox-->
                            <div class="state_btnBox state_btnBox01">
                                <div class="txt"><?= $row['endDate'] ?>까지 재응시 가능</div>
                                <a href="javascript:void(0)" class="sp_btn02">인터뷰 재응시하기</a>
                            </div>
                            <!--e state_btnBox-->
                        <?php elseif ($row['hrStateCode'] === 'st04') : ?>
                            <?php if ($row['hrState'] === '마감') : //응시기간지남 ?> 
                                <!--s state_btnBox-->
                                <div class="state_btnBox state_btnBox02">
                                    <div class="txt"><?= $row['endDate'] ?>까지</div>
                                </div>
                                <!--e state_btnBox-->
                            <?php else : // 거절 ?>
                                <!--s state_btnBox-->
                                <div class="state_btnBox state_btnBox02">
                                    <div class="txt">*기업에서 재응시 요청을 거절하였습니다</div>
                                </div>
                                <!--e state_btnBox-->
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!--e support_list-->
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<!--s 기업 인터뷰로 클릭시 모달-->
<div id="company_interveiw_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box top_radius_none c">
        <!--s pop_cont-->
        <div class="spop_cont pd_t0">
            <!--s spop_cpn_tltBox-->
            <div class="spop_cpn_tltBox">
                <span id='modalComName' class="spop_cpn_tlt"></span>
                <span id='modalRecTitle' class="spop_cpn_txt"></span>
            </div>
            <!--e spop_cpn_tltBox-->

            <div class="tlt">기업 인터뷰</div>

            <div class="txt mg_b10">
                <?= $data['session']['name'] ?> 님께 묻고 싶은<br />
                <span class="b point"><span id='modalQueCount'></span>개</span>의 질문들로 구성되어 있어요<br /><br />
                편안한 마음으로 응시해 주세요 :)
            </div>

            <div class="stxt mg_b25">*재응시 가능</div>
            <div class="stxt black">
                *인터뷰 완료 후, 바로 지원하지 않아도 괜찮아요!<br />
                분석 결과는 A.I.리포트에서 확인하실 수 있습니다
            </div>

            <!--s spop_lineBox-->
            <div class="spop_lineBox mg_t30">
                <div class="spl_tlt">비공개 인터뷰</div>
                <div class="spl_txt">해당 인터뷰는 공개 처리 및 타 공고 지원이 불가능해요</div>
            </div>
            <!--e spop_lineBox-->
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <a href="javascript:void(0)" onclick="fnHidePop('company_interveiw_pop')" class="spop_btn01">다음에 지원하기</a>
            <button id='modalBtn' type='button' value='' class="spop_btn02">지금 시작하기</button>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--e 기업 인터뷰로 클릭시 모달-->

<script>
    $(document).ready(function() {
        $('.sp_btn02').on('click', function() {
            const thisBtn = $(this);
            const thisList = thisBtn.closest('li');
            const comName = thisList.find('.tlt').text();
            const recTitle = thisList.find('.product_desc').text();
            const recIdx = thisList.data('rec_idx');
            const queCount = thisList.data('que_count');

            $(`#modalComName`).text(comName);
            $(`#modalRecTitle`).text(recTitle);
            $(`#modalBtn`).val(recIdx);
            $(`#modalQueCount`).text(queCount);

            fnShowPop('company_interveiw_pop');
        });

        $('#modalBtn').on('click', function() {
            const recIdx = $(this).val();
            location.href = `/interview/ready?rec=${recIdx}`;
        });
    });
</script>

<style>
    button {
        border: none;
    }
</style>