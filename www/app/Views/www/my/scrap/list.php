<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <div class="tlt">스크랩</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_jbBox-->
    <div class="top_jbBox c">
        <div id='rTitle' class="txt">AI가 진단하는 내 면접 습관 완벽 분석</div>
    </div>
    <!--e top_jbBox-->

    <!--s contBox-->
    <div class="contBox">
        <!--s BtnBox-->
        <div class="BtnBox mg_t30">
            <a href="/my/scrap/recruit" class="btn <?= $data['aData']['type'] === 'recruit' ? 'btn01' : 'btn03' ?>">담은 공고
                <span id='recruit_count'><?= $data['count']['R'] ?></span>건</a>
            <a href="/my/scrap/company" class="btn <?= $data['aData']['type'] === 'company' ? 'btn01' : 'btn03' ?>">담은 기업
                <span id='company_count'><?= $data['count']['C'] ?></span>개</a>
            <!--버튼 on할때는 btn03에서 btn02로 변경 -->
        </div>
        <!--e BtnBox-->
    </div>
    <!--e contBox-->

    <!--s cont-->
    <div class="cont">
        <?php if ($data['aData']['type'] == 'recruit') : ?>
            <!--s 공고리스트-->
            <?php if (count($data['list']) > 0) : ?>
                <!--s sel_lineb-->
                <div class="sel_lineb">
                    <!--s selBox-->
                    <div class="selBox">
                        <!--s selectbox-->
                        <div class="selectbox">
                            <dl class="dropdown">
                                <dt><a href="javascript:void(0)" id='myclass' class="myclass"></a></dt>
                                <dd>
                                    <ul class="dropdown2">
                                        <li><a href="?type=jobs" class="<?= $data['recruitType'] === 'jobs' ? 'on' : '' ?>">직무별 모아보기</a></li>
                                        <li><a href="?type=time" class="<?= $data['recruitType'] === 'time' ? 'on' : '' ?>">즐겨찾기순</a></li>
                                        <li><a href="?type=end" class="<?= $data['recruitType'] === 'end' ? 'on' : '' ?>">마감임박순</a></li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                        <!--e selectbox-->
                    </div>
                    <!--e selBox-->
                </div>
                <!--e sel_lineb-->

            <?php endif; ?>

            <?php if (count($data['list']) == 0) : ?>
                <li class="no_list">
                    <!-- 리스트없을때 -->
                    아직 담은 공고가 없어요 <br />
                    마음에 드는 공고를 카트에 담아주세요 !

                    <!--s BtnBox-->
                    <div class="BtnBox mg_t30">
                        <a href="/jobs/list" class="btn btn01 white fon24 wps_100">추천 공고 탐색하러 가기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
                    </div>
                    <!--e BtnBox-->
                </li>
            <?php else : ?>
                <div id='no_list'></div>
            <?php endif; ?>

            <?php if ($data['recruitType'] === 'jobs') : ?>
                <?php foreach ($data['list'] as $job => $val) : ?>
                    <!--s 체크박스 필터-->
                    <div class="mg_b30 box<?= $job ?>">
                        <div class="chek_box checkbox">
                            <input id='jobinput<?= $job ?>' name='allcheck' value='<?= $job ?>' type="checkbox">
                            <label for="jobinput<?= $job ?>" class="lbl black"><?= $val[0]['jobText'] ?></label>
                        </div>
                    </div>
                    <!--e 체크박스 필터-->

                    <form method="post" action="/jobs/detailAction" id="form<?= $job ?>" class='box<?= $job ?>'>
                        <?= csrf_field() ?>
                        <input type="hidden" name="state" value="M">
                        <input type="hidden" name="postCase" value="scrap_write">
                        <input type="hidden" name="backUrl" value="/my/scrap/<?= $data['aData']['type'] ?>">
                        <!--s perfitUl-->
                        <ul class="perfitUl">
                            <!--s 무한루프-->
                            <?php foreach ($val as $row) : ?>
                                <li id="list_<?= $row['recIdx'] ?>">
                                    <!--s itemBox-->
                                    <div class="itemBox">
                                        <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                            <?php if (in_array($row['recApply'], ['M', 'A']) && ($row['recEndDate'] != '마감')) : ?>
                                                <div class="chek_box checkbox">
                                                    <input type="checkbox" name="recIdx[]" class="check-scrap-idx" value="<?= $row['recIdx'] ?>" data-jobidx='<?= $job ?>'>
                                                    <label for="" class="lbl"></label>
                                                </div>
                                            <?php endif; ?>

                                            <div class="img">
                                                <img src="<?= $data['url']['media'] ?><?= $row['fileComLogo'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                                <?php if (($row['recEndDate'] != '마감')) : ?>
                                                    <a href="/jobs/detail/<?= $row['recIdx'] ?>" class="jwBtn">지원하기</a>
                                                <?php endif; ?>
                                            </div>
                                        </a>

                                        <!--s txtBox-->
                                        <div class="txtBox">
                                            <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                                <div class="tlt"><?= $row['comName'] ?></div>
                                            </a>
                                            <div class="product_desc"><?= $row['recTitle'] ?></div>

                                            <div class="gtxtBox">
                                                <div class="gtxt"><?= $row['areaDepth1'] . '.' . $row['areaDepth2'] ?><span>|</span><?= $row['recCareer'] ?></div>
                                                <div class="gdata"><?= $row['recEndDate'] ?></div>
                                            </div>

                                            <?php if (in_array($row['recApply'], ['M', 'A']) && ($row['recEndDate'] != '마감')) : ?>
                                                <!--s gBtn_color-->
                                                <div class="gBtn_color">
                                                    <a href="/jobs/detail/<?= $row['recIdx'] ?>">내 인터뷰로 지원 가능</a>
                                                </div>
                                                <!--e gBtn-->
                                            <?php endif; ?>
                                        </div>
                                        <!--e gBtn_color-->

                                        <!--s bookmark_iconBox-->
                                        <div class="bookmark_iconBox">
                                            <button type='button' class="bookmark_icon on btn-scrap-delete" tabindex="0" data-idx="<?= $row['recIdx'] ?>" data-type="recruit" data-jobidx='<?= $job ?>'><span class="blind">스크랩</span></button>
                                        </div>
                                        <!--e bookmark_iconBox-->
                                    </div>
                                    <!--e itemBox-->
                                </li>
                            <?php endforeach; ?>
                            <!--e 무한루프-->
                        </ul>

                        <!--s more_tlt-->
                        <div class="more_tlt mg_b50">
                            <div id='job<?= $job ?>' class="perfit_moreBtn">
                                <button type='submit' class="interview_pr_pop_open"><?= $val[0]['jobText'] ?> <span id='jobtext<?= $job ?>'></span> 지원하기</button>
                            </div>
                        </div>
                        <!--e more_tlt-->

                    </form>
                    <!--e perfitUl-->
                <?php endforeach; ?>
            <?php else : ?>
                <form method="post" action="/jobs/detailAction">
                    <?= csrf_field() ?>
                    <input type="hidden" name="state" value="M">
                    <input type="hidden" name="postCase" value="scrap_write">
                    <input type="hidden" name="backUrl" value="/my/scrap/<?= $data['aData']['type'] ?>">
                    <!--s perfitUl-->
                    <ul class="perfitUl">
                        <!--s 무한루프-->
                        <?php foreach ($data['list'] as $row) : ?>
                            <li id="list_<?= $row['recIdx'] ?>">
                                <!--s itemBox-->
                                <div class="itemBox">
                                    <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                        <?php if (in_array($row['recApply'], ['M', 'A']) && ($row['recEndDate'] != '마감')) : ?>
                                            <div class="chek_box checkbox">
                                                <input type="checkbox" name="recIdx[]" class="check-scrap-idx" value="<?= $row['recIdx'] ?>" data-jobidx='<?= $row['jobIdx'] ?>'>
                                                <label for="" class="lbl"></label>
                                            </div>
                                        <?php endif; ?>

                                        <div class="img">
                                            <img src="<?= $data['url']['media'] ?><?= $row['fileComLogo'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                            <?php if (($row['recEndDate'] != '마감')) : ?>
                                                <a href="/jobs/detail/<?= $row['recIdx'] ?>" class="jwBtn">지원하기</a>
                                            <?php endif; ?>
                                        </div>
                                    </a>

                                    <!--s txtBox-->
                                    <div class="txtBox">
                                        <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                            <div class="tlt"><?= $row['comName'] ?></div>
                                        </a>
                                        <div class="product_desc"><?= $row['recTitle'] ?></div>

                                        <div class="gtxtBox">
                                            <div class="gtxt"><?= $row['areaDepth1'] . '.' . $row['areaDepth2'] ?><span>|</span><?= $row['recCareer'] ?></div>
                                            <div class="gdata"><?= $row['recEndDate'] ?></div>
                                        </div>

                                        <?php if (in_array($row['recApply'], ['M', 'A']) && ($row['recEndDate'] != '마감')) : ?>
                                            <!--s gBtn_color-->
                                            <div class="gBtn_color">
                                                <a href="/jobs/detail/<?= $row['recIdx'] ?>">내 인터뷰로 지원 가능</a>
                                            </div>
                                            <!--e gBtn-->
                                        <?php endif; ?>
                                    </div>
                                    <!--e gBtn_color-->

                                    <!--s bookmark_iconBox-->
                                    <div class="bookmark_iconBox">
                                        <button type='button' class="bookmark_icon on btn-scrap-delete" tabindex="0" data-idx="<?= $row['recIdx'] ?>" data-type="recruit" data-jobidx='<?= $row['jobIdx'] ?>'><span class="blind">스크랩</span></button>
                                    </div>
                                    <!--e bookmark_iconBox-->
                                </div>
                                <!--e itemBox-->
                            </li>
                        <?php endforeach; ?>
                        <!--e 무한루프-->
                    </ul>

                    <!--s more_tlt-->
                    <div class="more_tlt mg_b50">
                        <div class="perfit_moreBtn">
                            <button type='submit' class="interview_pr_pop_open"><span></span> 지원하기</button>
                        </div>
                    </div>
                    <!--e more_tlt-->
                </form>
            <?php endif; ?>
            <!--e 공고리스트-->

        <?php elseif ($data['aData']['type'] == 'company') : ?>
            <!--s 기업리스트-->
            <?= csrf_field() ?>
            <?php if (count($data['list']) > 0) : ?>
                <!--s 라디오박스 필터-->
                <div class="mg_b30">
                    <div class="chek_box radio mg_r15">
                        <input type="radio" name="radio_interview" value="recruit" id="radio_recruit" <?= $data['get']['recruit'] === 'Y' ? 'checked' : '' ?>>
                        <label for="radio_recruit" class="lbl black">지금 채용중</label>
                    </div>

                    <div class="chek_box radio">
                        <input type="radio" name="radio_interview" value="practice" id="radio_practice" <?= $data['get']['practice'] === 'Y' ? 'checked' : '' ?>>
                        <label for="radio_practice" class="lbl black">모의 인터뷰 응시 가능</label>
                    </div>
                </div>
                <!--e 라디오박스 필터-->
            <?php endif; ?>

            <!--s perfitUl-->
            <ul class="perfitUl">
                <!--s 무한루프-->
                <?php foreach ($data['list'] as $row) : ?>
                    <li id="list_<?= $row['comIdx'] ?>">
                        <!--s itemBox-->
                        <div class="itemBox">
                            <a href="/company/detail/<?= $row['comIdx'] ?>">
                                <div class="img">
                                    <?php if (isset($row['recIdx'])) : ?>
                                        <span class="ai_txt ai_txt_line">채용중</span>
                                    <?php endif; ?>
                                    <img src="<?= $data['url']['media'] ?><?= $row['fileComLogo'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                    <?php if ($row['comPractice'] == 'Y') : ?>
                                        <a href="/interview/mock?searchText=<?= $row['comName'] ?>#mock_list" class="jwBtn jwBtn2">모의 인터뷰 하기</a>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <!--s txtBox-->
                            <div class="txtBox">
                                <a href="/company/detail/<?= $row['comIdx'] ?>">
                                    <div class="tlt"><?= $row['comName'] ?></div>
                                </a>
                                <div class="gtxtBox mg_t10">
                                    <div class="gtxt"><?= $row['comIndustry'] ?></div>
                                </div>
                                <div class="product_desc mg_t10"><?= $row['comAddress'] ?></div>
                            </div>
                            <!--e gBtn_color-->

                            <!--s bookmark_iconBox-->
                            <div class="bookmark_iconBox">
                                <button type='button' class="bookmark_icon on btn-scrap-delete" tabindex="0" data-idx="<?= $row['comIdx'] ?>" data-type="company"><span class="blind">스크랩</span></button>
                            </div>
                            <!--e bookmark_iconBox-->
                        </div>
                        <!--e itemBox-->
                    </li>
                <?php endforeach;
                if (count($data['list']) == 0) : ?>
                    <li class="no_list">
                        <!-- 리스트없을때 -->
                        아직 담은 기업이 없어요 <br />
                        마음에 드는 기업을 카트에 담아주세요 !

                        <!--s BtnBox-->
                        <div class="BtnBox mg_t30">
                            <a href="/company/explore" class="btn btn01 white fon24 wps_100">추천 기업 탐색하러 가기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
                        </div>
                        <!--e BtnBox-->
                    </li>
                <?php endif; ?>
                <!--e 무한루프-->
            </ul>
            <!--e perfitUl-->

            <!--e 기업리스트-->
        <?php endif; ?>
        <?= $data['pager']->links('scrap', 'front_full')  ?>
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<script>
    function deleteAjax(memIdx, idx, scrapType, jobIdx) {
        const emlCsrf = $("input[name='csrf_highbuff']");
        $.ajax({
            url: `/api/my/scrap/delete/${scrapType}/${memIdx}/${idx}`,
            type: 'post',
            dataType: "json",
            cache: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                '<?= csrf_token() ?>': emlCsrf.val()
            },
            success: function(res) {
                if (res.code.stat || res.code.stat == 'success') {
                    emlCsrf.val(res.code.token);
                    $(`#list_${idx}`).remove();
                    const iListCount = $('.bookmark_icon ').length;
                    $(`#${scrapType}_count`).text(iListCount);
                    if (scrapType === 'recruit') {
                        const iInputLength = $(`input[data-jobidx="${jobIdx}"]`).length;
                        if (iInputLength === 0) {
                            $('.box' + jobIdx).remove();
                        }
                    }
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
        });
    }

    const aTitle = ['AI가 진단하는 내 면접 습관 완벽 분석', '웃는 얼굴은 면접관에게 호감을 줍니다.', '오늘도 활기찬 하루를 시작해보아요', '오늘의 목표는 무엇인가요?', '편안한 마음으로 이야기해요.'];
    const iRandom = Math.floor(Math.random() * aTitle.length);

    $(document).ready(function() {
        $('#rTitle').text(aTitle[iRandom]);

        $(".btn-scrap-delete").on("click", function() {
            const scrapType = $(this).data('type');
            const idx = $(this).data('idx');
            const memIdx = '<?= $data['session']['idx'] ?>';
            let thisjobIdx = $(this).data('jobidx');
            if (!idx || !memIdx) {
                return false;
            }
            if (scrapType == 'recruit' || scrapType == 'company') {
                deleteAjax(memIdx, idx, scrapType, thisjobIdx);
                return true;
            }
            return false;
        })

        <?php if ($data['aData']['type'] == 'recruit') : ?>

            $('.dropdown2').find('.on').each(function() {
                let text = $(this).text();
                $('#myclass').text(text);
            });

            $('input[name="allcheck"]').on('change', function() {
                let thisChecked = $(this).prop('checked');
                let jobIdx = $(this).val();
                $(`#form${jobIdx}`).find('input[type=checkbox]').each(function() {
                    $(this).prop('checked', thisChecked).trigger('change');
                });
            });

            $('input[name="recIdx[]"').on('change', function() {
                let jobIdx = $(this).data('jobidx');
                let iCheckedLength = $(`input:checked[data-jobidx="${jobIdx}"]`).length;
                $(`#jobtext${jobIdx}`).text(iCheckedLength + '건 한꺼번에');
                if (iCheckedLength == 0) {
                    $(`#jobtext${jobIdx}`).text('');
                    $(`#job${jobIdx}`).closest('.perfit_moreBtn').removeClass('on');
                    return;
                }
                $(`#job${jobIdx}`).closest('.perfit_moreBtn').addClass('on');
            });

            $("form").submit(function() {
                const thisFormLength = $(this).find('input:checked').length
                if (thisFormLength == 0) {
                    alert("공고를 선택해주세요.");
                    return false;
                }
            });

        <?php elseif ($data['aData']['type'] == 'company') : ?>
            $('input[name="radio_interview"]:checked').on('click', function() {
                $(this).prop('checked', false).trigger('change');
            });

            $("input[name=radio_interview]").on("change", function() {
                const strInterview = $('input[name="radio_interview"]:checked').val();
                location.href = `/my/scrap/company?${strInterview}=Y`;
            })
        <?php endif; ?>
    })
</script>
<style>
    .interview_pr_pop_open {
        background: #ffffff;
    }
</style>