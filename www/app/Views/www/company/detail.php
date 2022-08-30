<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">회사소개</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first gray_bline_top">
        <!--s contBox-->
        <div class="contBox">
            <!--s company_logoBox-->
            <div class="company_logoBox c mg_b80">
                <div class="logo_img"><img src="<?= $data['url']['media'] ?><?= $data['info']['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>

                <div class="rcm_tltBox mg_t20 mg_b0">
                    <div class="tlt"><?= $data['info']['com_name'] ?></div>
                </div>

                <!--s company_txt-->
                <div class="company_txt">
                    <?php if (count($data['companyRec']) != 0) : ?>
                        <span>현재 채용중</span>
                    <?php endif; ?>

                    <?php if ($data['info']['com_practice_interview'] == 'Y') : ?>
                        <span>모의 인터뷰</span>
                    <?php endif; ?>
                </div>
                <!--e company_txt-->
            </div>
            <!--e company_logoBox-->

            <!--s rcm_info02-->
            <div class="rcm_info02">
                <!--s position_ckBox-->
                <div class="position_ckBox">
                    <ul>
                        <?php foreach ($data['companyTag'] as $key => $val) : ?>
                            <li>
                                <div class="ck_radio">
                                    <input type="checkbox" id="c<?= $key ?>" name="<?= $key ?>">
                                    <label for="">#<?= $val['tag_txt'] ?></label>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <!--e position_ckBox-->

                <div class="stlt mg_t60">
                    <?php if (count($data['companyRec']) != 0) : ?>
                        <span class="point">[현재 채용중]</span><br />
                        인터뷰로 지원할 수 있어요
                    <?php else : ?>
                        <?= $data['info']['com_name'] ?>입니다.
                    <?php endif; ?>
                </div>

                <!--s company_slBox-->
                <div class="company_slBox mg_t30">
                    <!--s company_sl-->
                    <div class="company_sl">
                        <?php foreach ($data['companyFile'] as $val) : ?>
                            <div class="item"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                        <?php endforeach  ?>
                    </div>
                    <!--e company_sl-->
                </div>
                <!--e company_slBox-->
            </div>
            <!--e rcm_info02-->
        </div>
        <!--e contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first gray_bline_top">
        <!--s contBox-->
        <div class="contBox pop_moreBox">
            <div class="stlt">회사소개</div>
            <?= $data['introduceText'] ?>

            <?php if (mb_strlen($data['info']['com_introduce'], "UTF-8") > 150) : ?>
                <!-- s 더보기 -->
                <!--s more_tlt-->
                <div class="more_tlt">
                    <div class="perfit_moreBtn">
                        <a href="javascript:void(0)">더보기 <span class="arrow"><i class="la la-angle-down"></i></span></a>
                    </div>
                </div>
                <!--e more_tlt-->

                <!--s more_cont 숨긴 내용들-->
                <div class="more_cont">
                    <?= $data['introduceMoreText'] ?>
                </div>
                <!--e more_cont 숨긴 내용들-->
                <!-- s 더보기 -->
            <?php endif; ?>

            <?php if ($data['info']['com_video_url']) : ?>
                <!--s company_videoBox-->
                <div class="company_videoBox mg_t50">
                    <!-- 유튜브 링크 첨부시 설명필요 (오른쪽 버튼 -> 소스코드복사 -> src="" 안에 링크 입력) -->
                    <iframe src="<?= $data['info']['com_video_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%;height:300px;"></iframe>
                </div>
                <!--e company_videoBox-->
            <?php endif; ?>
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <?php if (count($data['companyRec']) != 0) : ?>
        <!--s gray_bline_first-->
        <div class="gray_bline_first gray_bline_top">
            <!--s contBox-->
            <div class="cont<?= $data['companyNews'] || $data['info']['com_practice_interview'] == 'Y' ? 'Box' : '' ?>">
                <div class="stlt">지금 동료 모집 중</div>
                <!--s perfitUl-->
                <ul class="perfitUl">
                    <!--s 무한루프-->
                    <?php foreach ($data['companyRec'] as $recKey => $recVal) : ?>
                        <li>
                            <!--s itemBox-->
                            <div class="itemBox">
                                <a href="/jobs/detail/<?= $recVal['idx'] ?>">
                                    <div class="img">
                                        <img src="<?= $data['url']['media'] ?><?= $recVal['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                    </div>
                                </a>

                                <!--s txtBox-->
                                <div class="txtBox">
                                    <a href="javascript:void(0)">
                                        <div class="tlt"><?= $recVal['rec_title'] ?></div>
                                    </a>
                                    <div class="product_desc"><?= $data['info']['com_name'] ?></div>
                                    <!-- <div class="product_desc">(공고idx) <?= $recVal['idx'] ?></div> -->

                                    <div class="gtxtBox">
                                        <?php foreach ($data['recruitKor'][$recKey]['area'] as $areaKey => $areaVal) : ?>
                                            <div class="gtxt"><?= $areaVal['area_depth_text_1'] ?>.<?= $areaVal['area_depth_text_2'] ?></div>
                                        <?php endforeach ?>
                                    </div>

                                    <!--s gBtn_color-->
                                    <div class="gBtn_color">
                                        <a href="javascript:void(0)">지원가능</a>
                                    </div>
                                    <!--e gBtn-->
                                </div>
                                <!--e gBtn_color-->

                                <!--s bookmark_iconBox-->
                                <div class="bookmark_iconBox">
                                    <?php if (!$data['isLogin']) : ?>
                                        <button class="bookmark_icon btn-scrap off" tabindex="0"><span class="blind">스크랩</span></button>
                                    <?php else : ?>
                                        <?php if ($data['getRecScrap'][$recKey] == 0) : ?>
                                            <button id="favorite<?= $recKey ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-scrap="add" data-state="recruit" data-idx="<?= $recVal['idx'] ?>" data-key="<?= $recKey ?>"><span class="blind">스크랩</span></button>
                                        <?php else : ?>
                                            <button id="favorite<?= $recKey ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-scrap="delete" data-state="recruit" data-idx="<?= $recVal['idx'] ?>" data-key="<?= $recKey ?>"><span class="blind">스크랩</span></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <!--e bookmark_iconBox-->
                            </div>
                            <!--e itemBox-->
                        </li>
                    <?php endforeach ?>
                    <!--e 무한루프-->
                </ul>
                <!--e perfitUl-->
            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->
    <?php endif; ?>

    <?php if ($data['info']['com_practice_interview'] == 'Y') : ?>
        <!--s gray_bline_first-->
        <div class="gray_bline_first gray_bline_top">
            <!--s contBox-->
            <div class="cont<?= $data['companyNews'] ? 'Box' : '' ?>">
                <div class="stlt">모의 인터뷰 응시 가능</div>

                <!--s resume_list-->
                <div class="resume_list c">
                    <ul>
                        <?php foreach ($data['comMock'] as $mockKey => $mockVal) : ?>
                            <li class="mock" data-category="<?= $mockVal['job_depth_text'] ?>" data-idx="<?= $mockVal['idx'] ?>" data-title="<?= $mockVal['inter_name'] ?>" data-qcnt="<?= $data['mockQueCnt'][$mockKey] ?>">
                                <a href="javascript:void(0)">
                                    <span class="tlt">[<?= $mockVal['job_depth_text'] ?>]</span>
                                    <span class="data"><?= $mockVal['inter_name'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!--e resume_list-->
            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->
    <?php endif; ?>

    <?php if ($data['companyNews']) : ?>
        <!--s gray_bline_first-->
        <div class="gray_bline_first">
            <!--s contBox-->
            <div class="cont pd_0">
                <div class="stlt">이곳의 최신 소식을 알려드릴께요</div>

                <!--s resume_list-->
                <div class="resume_list">
                    <ul>
                        <!--s 무한루프-->
                        <?php foreach ($data['companyNews'] as $key => $val) : ?>
                            <li>
                                <a href="<?= $val['news_link'] ?>" target="_blank">
                                    <div class="tlt"><?= $val['news_title'] ?></div>
                                    <div class="data">출처: <?= $val['news_referance'] ?></div>
                                </a>
                            </li>
                        <?php endforeach ?>
                        <!--e 무한루프-->
                    </ul>
                </div>
                <!--e resume_list-->
            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->
    <?php endif; ?>

    <!--s fix_btBox-->
    <div class="fix_btBox fix_btBtn2">
        <div class="fix_btBtn">

            <?php if ($data['isLogin'] == 0) : ?>
                <a href="javascript:void(0)" class="fix_btn02 wps_100 btn-scrap">이 기업 담아놓기</a>
            <?php else : ?>
                <?php if ($data['scrapComState'] == 0) : ?>
                    <a href="javascript:void(0)" id="comScrap" class="fix_btn02 wps_100 btn-scrap" data-scrap="add" data-state="company" data-idx="<?= $data['comIdx'] ?>">이 기업 담아놓기</a>
                <?php else : ?>
                    <a href="javascript:void(0)" id="comScrap" class="fix_btn02 wps_100 btn-scrap" data-scrap="delete" data-state="company" data-idx="<?= $data['comIdx'] ?>">이미 담아놓은 기업입니다.</a>
                <?php endif; ?>
            <?php endif; ?>

            <?= view_cell('\App\Controllers\Interview\WwwController::footerView', ['page' => 'company']) ?>
        </div>
    </div>
    <!--e fix_btBox-->
</div>
<!--e #scontent-->

<!--s 기업 인터뷰로 클릭시 모달-->
<div id="mock_test_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <!--s selBox-->
            <div class="selBox wps_100 mg_b30">
                <div class="selectbox wps_100">
                    <div class="wps_100 txt mg_b10" id="MockTitle"></div>
                </div>
            </div>
            <!--e selBox-->

            <div class="txt mg_b10">
                <span id="companyName"><?= $data['info']['com_name'] ?></span>에서<br />
                [<span id="jobDepth"></span>] 지원자에게 묻는<br />
                <span class="point b" id="QueCount"></span>개의 질문들로 구성되어 있어요
            </div>

            <!-- <div class="stxt mg_b25">*응시 가능 횟수 : 1회</div> -->
            <div class="stxt black">
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
            <a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('mock_test_pop')">다음에 하기</a>
            <a href="javascript:void(0)" class="spop_btn02" id="nowStart">지금 시작하기</a>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--e 기업 인터뷰로 클릭시 모달-->

<script>
    const memIdx = '<?= $data['memIdx'] ?>';
    let scrapComState = '<?= $data['scrapComState'] ?>';

    $(document).ready(function() {
        //더보기
        $('.more_tlt').on('click', function() {
            $('.more_tlt').addClass('active');
            $('.more_cont').show();
        })
    });

    $('.mock').on('click', function() {
        const emlThis = $(this);
        const iIdx = emlThis.data('idx');
        const strCategory = emlThis.data('category');
        const strTitle = emlThis.data('title');
        const strQcnt = emlThis.data('qcnt');

        $('#MockTitle').text(`[${strCategory}] ${strTitle}`);
        $('#jobDepth').text(strCategory);
        $('#QueCount').text(strQcnt);
        $('#nowStart').attr('href', '/interview/ready?cmock=' + iIdx);


        fnShowPop('mock_test_pop');
    });

    $('#favBeforeLogin').on('click', function() {
        alert('로그인이 필요한 서비스 입니다.');
        location.href = '/login';
    });

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
                        if (state == 'company') {
                            $('#comScrap').text('이미 담아놓은 기업입니다.');
                        } else if (state == 'recruit') {
                            let favorite = $('#favorite' + key);
                            favorite.removeClass('off');
                            favorite.addClass('on');
                        }
                    } else if (strStrap == 'delete') {
                        if (state == 'company') {
                            $('#comScrap').text('이 기업 담아놓기');
                        } else if (state == 'recruit') {
                            let favorite = $('#favorite' + key);
                            favorite.removeClass('on');
                            favorite.addClass('off');
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
</script>