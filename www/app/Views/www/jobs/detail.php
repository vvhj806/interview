<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt"><?= $data['job']['rec_title'] ?></div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s rcm_vslBox-->
    <div class="rcm_vslBox">
        <?php if ($data['job']['rec_airecruit_yn'] == 'Y') : ?>
            <div class="img_txt">AI인터뷰로 적극 채용중</div>
        <?php endif; ?>

        <!--s control_box-->
        <!-- <div class="control_box">
            <span class="pagingInfo"></span>
        </div> -->
        <!--e control_box-->

        <!--s rcm_vsl-->
        <div class="rcm_vsl">
            <div class="item"><img src="<?= $data['url']['media'] ?><?= $data['job']['file_save_name'] ?? "/data/no_img.png" ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" style=""></div>
            <!-- <div class="item"><img src="<?= $data['url']['menu'] ?>/storage/uploads?path=<?= $data['comImg'] ?>"></div> -->
            <!-- <div class="item"><img src="/static/www/img/main/test_img02.jpg"></div>
            <div class="item"><img src="/static/www/img/main/test_img02.jpg"></div>
            <div class="item"><img src="/static/www/img/main/test_img02.jpg"></div> -->
        </div>
        <!--e rcm_vsl-->
    </div>
    <!--e rcm_vslBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first">
        <!--s contBox-->
        <div class="contBox">
            <!--s rcm_info01-->
            <div class="rcm_info01 c">
                <!--s rcm_tltBox-->
                <div class="rcm_tltBox">
                    <div class="tlt"><?= $data['job']['rec_title'] ?></div>
                    <div class="txt"><?= $data['job']['com_name'] ?> <span>|</span> <?= $data['job']['com_address'] ?> </div>
                </div>
                <!--e rcm_tltBox-->

                <!--s data_iconUl-->
                <ul class="data_iconUl">
                    <!-- 학력 -->
                    <?php if (!empty($data['config']['recruit']['education'][$data['job']['rec_education']])) : ?>
                        <li>
                            <div class="icon"><img src="/static/www/img/sub/rcm_vicon01.png"></div>
                            <div class="txt"><?= $data['config']['recruit']['education'][$data['job']['rec_education']] ?></div>
                        </li>
                    <?php endif; ?>
                    <!-- (경력:C,신입:N) -->
                    <?php if (!empty($data['job']['rec_career'])) : ?>
                        <li>
                            <div class="icon"><img src="/static/www/img/sub/rcm_vicon02.png"></div>
                            <div class="txt">
                                <?php if ($data['job']['rec_career'] == 'C') : ?>
                                    경력
                                <?php else : ?>
                                    신입
                                <?php endif;  ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <!-- (고용형태) -->
                    <?php if (!empty($data['workType'][0])) : ?>
                        <li>
                            <div class="icon"><img src="/static/www/img/sub/rcm_vicon03.png"></div>
                            <div class="txt">
                                <?php
                                foreach ($data['workType'] as $key => $val) :
                                ?>
                                    <span><?= $data['config']['recruit']['work_type'][$val] ?? '' ?></span>
                                <?php
                                endforeach
                                ?>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
                <!--e data_iconUl-->
            </div>
            <!--e rcm_info01-->

            <!--s rcm_info02-->
            <div class="rcm_info02">
                <!--s position_ckBox-->
                <div class="position_ckBox">
                    <?php if ($data['tag'][0] != '' && $data['tag'][0] != null) : ?>
                        <ul>
                            <?php
                            foreach ($data['tag'] as $tagKey => $row) : ?>
                                <li>
                                    <div class="ck_radio">
                                        <input type="checkbox" id="" name="c">
                                        <label for="">#<?= $row ?></label>
                                    </div>
                                </li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <!--e position_ckBox-->

                <div class="stlt mg_t60">
                    <span class="point">
                        <?php
                        foreach ($data['categories'] as $key => $val) :
                        ?>
                            <span>[<?= $val ?>] </span>
                        <?php
                        endforeach
                        ?>
                    </span><br />
                    인터뷰로 지원할 수 있어요
                </div>

                <!--s rcm_lineBox-->
                <div class="rcm_lineBox">
                    <div class="tlt">지원방법</div>
                    <div class="txt">
                        <?php if ($data['job']['rec_apply'] == 'M') : ?>
                            내인터뷰로 지원
                        <?php elseif ($data['job']['rec_apply'] == 'C') : ?>
                            기업인터뷰로 지원 (질문 <?= $data['queCnt'] ?>개)
                        <?php else : ?>
                            내인터뷰로 지원<br />
                            기업인터뷰로 지원 (질문 <?= $data['queCnt'] ?>개)
                        <?php endif; ?>
                    </div>
                </div>
                <!--e rcm_lineBox-->
            </div>
            <!--e rcm_info02-->
        </div>
        <!--e contBox-->
    </div>
    <!--e gray_bline_first-->

    <?= $data['job']['rec_info'] ?>

    <!--s gray_bline_first-->
    <div class="gray_bline_first gray_bline_top">
        <!--s contBox-->
        <div class="contBox">
            <div class="stlt">접수기간</div>
            <!--s rcm_vdataUl-->
            <ul class="rcm_vdataUl">
                <li class="first">
                    <span class="tlt">시작일</span>
                    <span class="txt"><?= $data['recStartDate'] ?></span>
                </li>
                <li class="last">
                    <span class="tlt">마감일</span>
                    <span class="txt"><?= $data['recEndtDate'] ?></span>
                </li>
            </ul>
            <!--e rcm_vdataUl-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first gray_bline_top" id="com_location">
        <!--s contBox-->
        <div class="contBox">
            <div class="stlt">위치</div>

            <!--s rcm_vmapBox-->
            <div class="rcm_vmapBox">
                <div class="address"><?= $data['job']['com_address'] ?></div>
                <div id="map" style="width:100%;height:300px;z-index:10"></div>
            </div>
            <!--e rcm_vmapBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first gray_bline_top">
        <!--s contBox-->
        <div class="contBox">
            <div class="stlt">기업정보</div>
            <!--s gy_lineBox-->
            <div class="gy_lineBox">
                <!--s imgBox-->
                <div class="imgBox">
                    <!-- <div class="img"><img src="/static/www/img/main/test_img.jpg"></div> -->
                    <div class="img"><img src="<?= $data['url']['media'] ?><?= $data['comImg'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                    <div class="name"><?= $data['job']['com_name'] ?></div>
                </div>
                <!--e imgBox-->
                <div class="moreBox">
                    <a href="/company/detail/<?= $data['job']['com_idx'] ?>">자세히</a>
                </div>
            </div>
            <!--e gy_lineBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <?php if ($data['randomInfo']) : ?>
        <!--s gray_bline_first-->
        <div class="gray_bline_first">
            <!--s contBox-->
            <div class="cont pd_0">
                <div class="stlt">이 공고는 어때요?</div>

                <!--s perfitUl-->
                <ul class="perfitUl">
                    <?php
                    foreach ($data['randomInfo'] as $randomKey => $row) :
                    ?>
                        <li>
                            <!--s itemBox-->
                            <div class="itemBox">
                                <a href="/jobs/detail/<?= $row['idx'] ?>">
                                    <div class="img">
                                        <img src="<?= $data['url']['media'] ?><?= $row['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                        <!-- <img src="/static/www/img/main/test_img.jpg"> -->
                                    </div>
                                </a>

                                <!--s txtBox-->
                                <div class="txtBox">
                                    <a href="/jobs/detail/<?= $row['idx'] ?>">
                                        <div class="tlt"><?= $row['com_name'] ?></div>
                                    </a>
                                    <div class="product_desc"><?= $row['rec_title'] ?></div>

                                    <div class="gtxtBox">
                                        <div class="gtxt"><?= $row['area_depth_text_1'] ?> <span>|</span> <?= $row['area_depth_text_2'] ?></div>
                                        <div class="gdata"><?= $row['rec_end_date']  ?></div>
                                    </div>

                                    <!--s gBtn_color-->
                                    <div class="gBtn_color">
                                        <a href="javascript:void(0)">내 인터뷰로 지원 가능</a>
                                    </div>
                                    <!--e gBtn-->
                                </div>
                                <!--e gBtn_color-->

                                <!--s bookmark_iconBox-->
                                <div class="bookmark_iconBox">

                                    <?php if (!$data['isLogin']) : ?>
                                        <button id="" class="bookmark_icon off btn-scrap" tabindex="0"><span class="blind">스크랩</span></button>
                                    <?php else : ?>
                                        <?php if ($data['recScrap'][$randomKey] == 0) : ?>
                                            <button id="favorite<?= $randomKey ?>" class="bookmark_icon off btn-scrap" tabindex="0" data-scrap="add" data-state="recruit" data-idx="<?= $row['idx'] ?>" data-key="<?= $randomKey ?>"><span class="blind">스크랩</span></button>
                                        <?php else : ?>
                                            <button id="favorite<?= $randomKey ?>" class="bookmark_icon on btn-scrap" tabindex="0" data-scrap="delete" data-state="recruit" data-idx="<?= $row['idx'] ?>" data-key="<?= $randomKey ?>"><span class="blind">스크랩</span></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <!--e bookmark_iconBox-->
                            </div>
                            <!--e itemBox-->
                        </li>
                    <?php
                    endforeach
                    ?>
                </ul>
                <!--e perfitUl-->
            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->
    <?php endif; ?>

    <!--s 지원완료했을때 모달-->
    <div id="completion_pop" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="tlt point">이미 이 공고에 지원하셨어요! </div>

                <div class="txt mg_b10">
                    지원 취소 및 기업인터뷰 재응시 요청은<br />
                    마이페이지 > 지원현황을 확인해 주세요
                </div>
            </div>
            <!--e pop_cont-->

            <!--s spopBtn-->
            <div class="spopBtn">
                <a href="javascript:void(0)" class="spop_btn02 wps_100 spop_close">확인하러 가기</a>
            </div>
            <!--e spopBtn-->
        </div>
        <!--e pop_Box-->
    </div>
    <!--s 지원완료했을때 모달-->

    <!--s support_pop-->
    <div id="support_md" class="support_pop">
        <!--s support_popcont-->
        <div class="support_popcont md_pop_content">
            <div class="btnBox">
                <a href="javascript:void(0)" class="spp_btn01" id="myInterviewApp" data-state='M'>내 인터뷰로 지원</a>
                <a href="javascript:void(0)" class="spp_btn02" id="comInterviewApp" data-state='C'>기업 인터뷰로 지원</a>
            </div>
        </div>
        <!--e support_popcont-->
    </div>
    <!--e support_pop-->

    <!--s fix_btBox-->
    <div class="fix_btBox fix_btBtn2">
        <div class="fix_btBtn">

            <?php if (!$data['isLogin']) : ?>
                <a href="javascript:void(0)" id="pageRecScrap" class="fix_btn01 btn-scrap">
                    <span class="scrap_icon"></span>
                    스크랩
                </a>
            <?php else : ?>
                <?php if ($data['pageRecScrap'] == 'N') : ?>
                    <a href="javascript:void(0)" id="pageRecScrap" class="fix_btn01 btn-scrap" data-scrap="add" data-state="recruit" data-idx="<?= $data['currentRecidx'] ?>" data-key="O">
                        <span class="scrap_icon"></span>
                        스크랩
                    </a>
                <?php else : ?>
                    <a href="javascript:void(0)" id="pageRecScrap" class="fix_btn01 scrap_on btn-scrap" data-scrap="delete" data-state="recruit" data-idx="<?= $data['currentRecidx'] ?>" data-key="O">
                        <span class="scrap_icon"></span>
                        스크랩
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <!--s 스크랩 됐을때 a 버튼에 scrap_on 클래스 추가함 컬러가 바뀜-->
            <!-- <a href="javascript:void(0)" class="fix_btn02" id="fnShowPop" onclick="fnShowPop('support_md')">지원하기</a> -->

            <?php if ($data['applyState'] == 'Y') : ?>
                <?php if ($data['applyCnt'] >= $data['job']['rec_apply_count']) : ?>
                    <a href="javascript:void(0)" class="fix_btn02" onclick="alert('해당공고의 지원가능 횟수를 초과하였습니다')">지원하기</a>
                <?php else : ?>
                    <a href="javascript:void(0)" class="fix_btn02" id="fnShowPop">지원하기</a>
                <?php endif; ?>
            <?php elseif ($data['applyState'] == 'N') : ?>
                <a href="javascript:void(0)" class="fix_btn02" id="">지원기간이 지났습니다.</a>
            <?php endif; ?>

            <?= view_cell('\App\Controllers\Interview\WwwController::footerView', ['page' => 'recruit']) ?>
            <!--s 지원 중복 아닐때 onclick-->
            <!-- <a href="javascript:void(0)" class="fix_btn02" onclick="fnShowPop('completion_pop')">지원하기</a> -->
            <!--s 지원완료했을떼 onclick 일단 주석으로 걸어둠-->
        </div>
    </div>

    <!--e fix_btBox-->
</div>
<!--e #scontent-->

<!--s 내 인터뷰로 지원 클릭시 모달-->
<div id="my_interveiw_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <!--s 회원 + 인터뷰가 하나도 없는 경우-->
            <div id="haveNot">
                <div class="txt">
                    인터뷰 생성 후 지원이 가능해요!<br />
                    새 인터뷰를 시작하시겠어요?<br /><br />

                    <?php
                    foreach ($data['categories'] as $cateKey => $cateVal) :
                    ?>
                        <span class="point b">[<?= $cateVal ?>]</span>
                    <?php
                    endforeach
                    ?>

                </div>

                <!--s spopBtn-->
                <div class="spopBtn mg_t40">
                    <a href="/interview/ready?type=A&rec=<?= $data['currentRecidx'] ?>" class="btn01 wps_100">네 좋아요</a>
                    <a href="javascript:void(0)" class="btn02 wps_100 mg_t10" onclick="fnHidePop('my_interveiw_pop')">다음에 지원할께요</a>
                </div>
                <!--e spopBtn-->
            </div>
            <!--e 회원 + 인터뷰가 하나도 없는 경우-->


            <!--s 회원 + 관련 직무 인터뷰가 없는 경우-->
            <div id="haveNotSame">
                <div class="txt">
                    앗, 보유하고 있는<br />
                    <?php
                    foreach ($data['categories'] as $cateKey => $cateVal) :
                    ?>
                        <span class="point b">[<?= $cateVal ?>]</span>
                    <?php
                    endforeach
                    ?>
                    <br />인터뷰가 없어요.<br /><br />

                    새 인터뷰 시작 페이지로 <br />
                    이동하시겠어요?
                </div>

                <!--s spopBtn-->
                <div class="spopBtn mg_t40">
                    <a href="/interview/ready?type=A&rec=<?= $data['currentRecidx'] ?>" class="btn01 wps_100">네 좋아요</a>
                    <a href="javascript:void(0)" class="btn02 wps_100 mg_t10" onclick="moveApplyPage()">그냥 지원할께요</a>
                    <a href="javascript:void(0)" class="btn02 wps_100 mg_t10" onclick="fnHidePop('my_interveiw_pop')">취소</a>
                </div>
                <!--e spopBtn-->
            </div>
            <!--e 회원 + 관련 직무 인터뷰가 없는 경우-->
        </div>
        <!--e pop_cont-->
    </div>
    <!--e pop_Box-->
</div>
<!--e 내 인터뷰로 지원 클릭시 모달-->


<!--s 기업 인터뷰로 클릭시 모달-->
<div id="company_interveiw_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box top_radius_none c">
        <!--s pop_cont-->
        <div class="spop_cont pd_t0">
            <!--s spop_cpn_tltBox-->
            <div class="spop_cpn_tltBox">
                <span class="spop_cpn_tlt"><?= $data['job']['com_name'] ?></span>
                <span class="spop_cpn_txt"><?= $data['job']['rec_title'] ?></span>
            </div>
            <!--e spop_cpn_tltBox-->

            <div class="tlt">기업 인터뷰</div>

            <div class="txt mg_b10">
                <?= $data['memberName'] ?> 님께 묻고 싶은<br />
                <span class="b point"><?= $data['queCnt'] ?>개</span>의 질문들로 구성되어 있어요<br />
                답변시간은 <span class="b point"><?= $data['answerTime'] ?>초</span> 입니다<br /><br />


                편안한 마음으로 응시해 주세요 :)
            </div>

            <div class="stxt mg_b25">*응시 가능 횟수 : <?= (int)$data['job']['rec_apply_count'] - (int)$data['applyCnt'] ?>회</div>
            <div class="stxt black">
                *인터뷰 완료 후, 바로 지원하지 않아도 괜찮아요!<br />
                분석 결과는 AI리포트에서 확인하실 수 있습니다
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
            <a href="/interview/ready?rec=<?= $data['currentRecidx'] ?>" class="spop_btn02 jy_interview_pr_pop_open" onclick="fnHidePop('company_interveiw_pop')">지금 시작하기</a>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>

<form action="/jobs/detailAction" method="post" id="apply">
    <?= csrf_field() ?>
    <input type="hidden" id="recIdx" name="recIdx[]">
    <input type="hidden" id="state" name="state">
    <input type="hidden" id="backUrl" name="backUrl" value="/jobs/detail/<?= $data['aData']['idx'] ?>">
    <input type="hidden" id="postCase" name="postCase" value="detail_view">
</form>

<!-- 카카오지도 API -->
<!-- <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a2f74deda739622a9c80f1f0c6adb899"></script> -->
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a2f74deda739622a9c80f1f0c6adb899&libraries=services"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>

<script>
    const detailIdx = '<?= $data['aData']['idx'] ?>';
    const applyState = '<?= $data['job']['rec_apply'] ?>';
    const applierCategory = '<?= $data['applierCategory'] ?>';
    const category = '<?= json_encode($data['categories']) ?>';
    const companyName = '<?= $data['job']['com_name'] ?>';
    const recTitle = '<?= $data['job']['rec_title'] ?>';
    const memName = '<?= $data['memberName'] ?>';
    const applyCount = '<?= $data['job']['rec_apply_count'] ?>';
    const queCnt = '<?= $data['queCnt'] ?>';
    const recIdx = '<?= $data['recIdx'] ?>';
    const memIdx = '<?= $data['memIdx'] ?>';
    const address = '<?= $data['job']['com_address'] ?>';
    let interviewState = applyState;

    $(document).ready(function() {
        if (applierCategory == 'none') { //보유한 인터뷰가 없는경우
            $('#haveNot').show();
            $('#haveNotSame').hide();
        } else if (applierCategory == 'not') { //보유한 인터뷰는 있지만 카테고리에 맞는게 없는경우
            $('#haveNot').hide();
            $('#haveNotSame').show();
        } else if (applierCategory == 'get') {
            $('#haveNot').hide();
            $('#haveNotSame').hide();
        }

        if (address == '' || address == null) {
            $('#com_location').hide();
        }

        kakaoMap();

        $('#support_md').css('bottom', $('.fix_btBtn').outerHeight());
    });

    function kakaoMap() {
        var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
            mapOption = {
                center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
                level: 3 // 지도의 확대 레벨
            };

        // 지도를 생성합니다    
        var map = new kakao.maps.Map(mapContainer, mapOption);

        // 주소-좌표 변환 객체를 생성합니다
        var geocoder = new kakao.maps.services.Geocoder();

        // 주소로 좌표를 검색합니다
        geocoder.addressSearch(address, function(result, status) {
            // 정상적으로 검색이 완료됐으면 
            if (status === kakao.maps.services.Status.OK) {
                var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                var marker = new kakao.maps.Marker({ // 결과값으로 받은 위치를 마커로 표시합니다
                    map: map,
                    position: coords
                });
                // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                map.setCenter(coords);
            }
        });
    }

    $('.btn-scrap').on('click', function() {
        if (!'<?= $data['isLogin'] ?>') {
            alert('로그인이 필요한 서비스 입니다.');
            location.href = '/login';
            return;
        } else {
            const emlThis = $(this);
            const strStrap = emlThis.data('scrap');
            const iState = emlThis.data('state');
            const iRecOrComIdx = emlThis.data('idx');
            const iKey = emlThis.data('key');

            scrap(iState, iRecOrComIdx, iKey, strStrap);

            emlThis.data('scrap', strStrap == 'add' ? 'delete' : 'add');
        }
    });

    function scrap(state, recOrComIdx, key, strStrap) {
        $.ajax({
            type: "GET",
            url: `/api/my/scrap/${strStrap}/${state}/${memIdx}/${recOrComIdx}`,
            data: {
                'csrf_highbuff': $('input[name="csrf_highbuff"]').val(),
            },
            success: function(data) {
                if (data.status == 200) {
                    $('input[name="csrf_highbuff"]').val(data.code.token);
                    if (strStrap == 'add') {
                        if (state == 'recruit') {
                            if (key == 'O') {
                                $('#pageRecScrap').addClass('scrap_on');
                            } else {
                                let favorite = $('#favorite' + key);
                                favorite.removeClass('off');
                                favorite.addClass('on');
                            }
                        }
                    } else if (strStrap == 'delete') {
                        if (state == 'recruit') {
                            if (key == 'O') {
                                $('#pageRecScrap').removeClass('scrap_on');
                            } else {
                                let favorite = $('#favorite' + key);
                                favorite.removeClass('on');
                                favorite.addClass('off');
                            }
                        }
                    }
                } else {
                    alert(data.messages);
                }
            },
            error: function(e) {
                alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 '하이버프'로 문의 부탁드립니다.");
                return;
            },
        })
    }

    $('#fnShowPop').on('click', function() {
        if (applierCategory == 'beforeLogin') {
            alert('로그인이 필요한 서비스 입니다.');
            location.href = '/login';
            return;
        } else {
            if (applyState == 'M') {
                if (applierCategory == 'get') {
                    moveApplyPage();
                } else {
                    fnShowPop('my_interveiw_pop');
                }
            } else if (applyState == 'C') {
                fnShowPop('company_interveiw_pop');
            } else {
                fnShowPop('support_md');
            }
        }
    });

    $('#myInterviewApp').on('click', function() {
        const emlThis = $(this);
        const itvState = emlThis.data('state');
        interviewState = itvState;

        if (applierCategory == 'get') {
            moveApplyPage();
        } else {
            fnShowPop('my_interveiw_pop');
        }
    });

    $('#comInterviewApp').on('click', function() {
        if (queCnt == 0) {
            alert('기업인터뷰가 존재하지 않습니다.');
        } else {
            const emlThis = $(this);
            const itvState = emlThis.data('state');
            interviewState = itvState;

            fnShowPop('company_interveiw_pop');
        }
    });

    function moveApplyPage() {
        $('#state').val(interviewState);
        $('#recIdx').val(`${detailIdx}`);
        $('#apply').submit();
    }
</script>

<style>
    .slick-slide {
        height: 28vw;
    }

    @media screen and (max-width:768px) {
        .slick-slide {
            height: 55vw;
            padding: 15px;
        }
    }

    @media screen and (max-width:480px) {
        .slick-slide {
            height: 56vw;
            padding: 15px;
        }
    }
</style>