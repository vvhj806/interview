<style>
    .top_tab .depth2 li label {
        width: 100%;
    }
</style>
<script>
    function appendList(areaOrJob, idx, nameArray, exParam = null) {
        let id = areaOrJob == 'area' ? 'A' : 'J';
        let list = `
				<li data-${areaOrJob}Idx='${idx}'>
					<a class="kwd">${nameArray[idx]}</a>
                    <label for='${id}${idx}'class="kwd_close">
                        <i class="la la-times"></i>
                    </label>
				</li>`

        if (areaOrJob == 'job') {
            list = `
				<li data-${areaOrJob}Idx='${idx}'>
					<a class="kwd">${nameArray}</a>
                    <label for='${exParam}'class="kwd_close">
                        <i class="la la-times"></i>
                    </label>
				</li>`
        }
        $(`.${areaOrJob}Depth`).slick('slickAdd', list);
        $(`#${areaOrJob}Depth2`).append(list);
    }

    function resetModal(areaOrDuty) {
        $('#' + areaOrDuty + '_pop').find('input:checkBox:checked').each(function() {
            let thisValue = $(this).val();
            $(this).prop('checked', false).trigger('change');
        });
    }

    function getListLength(listName) {
        let iLength = $(`.${listName}Depth2`).find('input:checkBox:checked').length;
        if (listName == 'tag') {
            $(`.${listName}Point`).html(iLength);
            return true;
        } else if (listName == 'job') {
            iLength = $('input[name="depth3[]"]:checked').length;
        }
        if (iLength <= 10) {
            $(`.${listName}Point`).html(iLength);
            return true;
        } else {
            alert2('최대 10개까지 선택 가능합니다.');
            return false;
        }
    }

    function scrap(state, type, memidx, idx, ele) {
        $.ajax({
            type: "GET",
            url: `/api/my/scrap/${state}/${type}/${memidx}/${idx}`,
            success: function(data) {
                if (data.status == 200) {
                    if (state == 'add') {
                        ele.removeClass('off');
                        ele.addClass('on');
                    } else if (state == 'delete') {
                        ele.removeClass('on');
                        ele.addClass('off');
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

    $(document).ready(function() {
        //data init
        let deepSearchChk = '<?= (isset($data['deepSearchChk']))  ?>';
        let strCareer = '<?= $data['strCareer'] ?? ''  ?>';
        let strPayType = '<?= $data['strPayType'] ?? '' ?>';
        let strApply = '<?= $data['strApply'] ?? '' ?>';
        let iCareerMonth = $('input[name="iCareerMonth"]');
        let iQueCount = $('input[name="iQueCount"]');
        let iPayUnit = $('input[name="iPayUnit"]');
        let $ipt = $('#searchinput'),
            $clearIpt = $('#searchclear');

        $(function() { // 시작시 실행
            if (deepSearchChk) {
                fnShowPop('d_search_md');
            }

            if (strCareer == 'old') {
                iCareerMonth.attr('disabled', false);
            }

            if (strApply == 'you') {
                iQueCount.attr('disabled', false);
            }

            if (strPayType == 'after') {
                iPayUnit.attr('disabled', true);
            }
            getListLength('workType');

            const bottomHeight = $('.ard_btnBox').outerHeight();

            $('.dropdown2').find('input:radio:checked').each(function() {
                let text = $(this).parents('label').text();
                $('.myclass').text(text);
            });

            $('.tagDepth2').find('input:checkBox:checked').each(function() {
                getListLength('tag');
                let realId = $(this).attr('id');
                $(`#fake${realId}`).prop('checked', true).trigger('change');
            });

            $('.areaDepth2').find('input:checkBox:checked').each(function() {
                getListLength('area');
                let thisValue = $(this).val();
                appendList('area', thisValue, areaName);
            });

            $('input[name="depth3[]"]:checked').each(function() {
                const ul = $(this).closest('ul');
                const bottomHeight = $('#jobsArd').outerHeight();
                const thisValue = $(this).val();

                depth3IsOn(ul);
                $('.jobDepth2').css("padding-bottom", `${bottomHeight+50}px`);
                $('.jobDepth1').css("padding-bottom", `${bottomHeight+50}px`);
                getListLength('job');
                appendList('job', thisValue, $(this).next('label').text(), $(this).attr('id'));
            });
        }); //시작시 실행 끝

        $ipt.keyup(function() { //검색시 닫기버튼이 생성됨
            $('#searchclear').toggle(Boolean($(this).val()));
        });

        $clearIpt.toggle(Boolean($ipt.val()));
        $clearIpt.click(function() {
            $('#searchinput').val('').focus();
            $(this).hide();
        });

        $('.bookmark_icon').on('click', function() {
            const emlThis = $(this);
            const type = emlThis.data('type');
            const memidx = '<?= $data['session']['idx'] ?>';
            const idx = emlThis.data('idx');
            if (!memidx) {
                alert('로그인이 필요한 서비스 입니다.');
                location.href = '/login';
                return;
            }
            if ($(this).hasClass('on')) {
                scrap('delete', type, memidx, idx, emlThis);
            } else if ($(this).hasClass('off')) {
                scrap('add', type, memidx, idx, emlThis);
            }
        });

        $('input[name*="aWorkType"]').on('change', function() {
            getListLength('workType');
        });

        $('input[name="applied"]').on('change', function() {
            $('#frm').submit();
        });

        $('input[name="hire"]').on('change', function() {
            $('#frm').submit();
        });

        $('input[name="sort"]').on('change', function() {
            $('#frm').submit();
        });

        $('input[name="type"]').on('change', function() {
            $('#frm').submit();
        });

        $('.tap').on('click', function() {
            $('#frm').submit();
        });

        $('#reset').on('click', function() {
            resetModal('area');
            resetModal('duty');
            $('#d_search_md').find('input:checked').each(function() {
                if ($(this).attr('name') === 'type') {

                } else {
                    $(this).prop('checked', false).trigger('change');
                }
            });
            $('#d_search_md').find('input[type="number"]').each(function() {
                $(this).val('');
                $(this).attr('disabled', true);
            });
        });

        $('input[name="strCareer"]').on('click', function() {
            $(this).val() != 'old' ? iCareerMonth.attr('disabled', true) : iCareerMonth.attr('disabled', false);
        });

        $('input[name="strApply"]').on('click', function() {
            $(this).val() != 'you' ? iQueCount.attr('disabled', true) : iQueCount.attr('disabled', false);
        });

        $('input[name="strPayType"]').on('change', function() {
            if ($(this).val() === 'after') {
                $('input[type="radio"][name="strPayType"]').prop('checked', false);
                iPayUnit.attr('disabled', true)
            } else {
                $('input[type="checkBox"][name="strPayType"]').prop('checked', false);
                iPayUnit.attr('disabled', false);
            }
        });
    });
    $(document).on('change', 'input[name^="aEducation"]', function() {
        if ($(this).attr('id') == 'eduNone') {
            $('#edu_ul').find('input').prop('checked', false);
        } else {
            $('#eduNone').prop('checked', false);
        }
    });
</script>

<form id="frm" method="get" action="/search/action">
    <!--s #scontent-->
    <div id="scontent">
        <!--s top_tltBox-->
        <div class="top_tltBox overflow">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <a href="/search">
                    <div class="backBtn"><span>뒤로가기</span></div>
                </a>

                <!--s top_shBox-->
                <div class="top_shBox">
                    <span id="searchclear" class='searchclear'><img src="/static/www/img/sub/list_close.png"></span>
                    <div class="iconBox"><button type="submit"><img src="/static/www/img/main/m_sh_icon.png"></button></div>
                    <input type="text" id="searchinput" name="keyword" class="top_sh_inp" placeholder="직무, 회사명, 공고명으로 검색해보세요" value='<?= ($data['keyword'] ?? false) ? $data['keyword'] : '' ?>'>
                </div>
                <!--e top_shBox-->
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <?php if ($data['type'] != 'deepSearch') : ?>

            <!--s top_tab-->
            <div class="top_tab">
                <!--s depth-->
                <ul class="depth2 wd_2_2">
                    <li>
                        <input id='recruit' type='radio' name='type' value='recruit' style='display:none' <?= ($data['type'] === 'recruit') ? 'checked' : '' ?>>
                        <label for='recruit' class='tap'>공고 (<?= $data['count']['recruit'] ?? '' ?>)</label>
                    </li>
                    <li>
                        <input id='company' type='radio' name='type' value='company' style='display:none' <?= ($data['type'] === 'company') ? 'checked' : '' ?>>
                        <label for='company' class='tap'>기업 (<?= $data['count']['company']  ?? '' ?>)</label>
                    </li>
                </ul>
                <!--e depth-->
            </div>
            <!--e top_tab-->

        <?php endif; ?>

        <?php if ($data['type'] === 'recruit') : ?>
            <!--s sel_lineb-->
            <div class="sel_lineb">
                <!--s selBox-->
                <div class="selBox">
                    <!--s selectbox-->
                    <div class="selectbox">
                        <dl class="dropdown">
                            <dt><a href="javascript:void(0)" class="myclass">공고명순</a></dt>
                            <dd>
                                <ul class="dropdown2" style="display:none;">
                                    <li>
                                        <label class="<?= ($data['sort'] == '1') ? 'on' : '' ?>">공고명순 <input name='sort' type='radio' value='1' style='display:none' <?= ($data['sort'] == '1') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '2') ? 'on' : '' ?>'>최근등록순 <input name='sort' type='radio' value='2' style='display:none' <?= ($data['sort'] == '2') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '3') ? 'on' : '' ?>'>마감임박순 <input name='sort' type='radio' value='3' style='display:none' <?= ($data['sort'] == '3') ? 'checked' : '' ?>></label>
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <!--e selectbox-->
                </div>
                <!--e selBox-->
            </div>
            <!--e sel_lineb-->

            <!--s 라디오박스 필터-->
            <div class="overflow mg_b30">
                <div class="fl">
                    <div class="chek_box radio mg_r15">
                        <input id='applied' name="applied" type="checkBox" value="on" <?= $data['applied'] ? 'checked' : '' ?>>
                        <label for="applied" class="lbl black">내 인터뷰로 지원 가능</label>
                    </div>
                </div>

                <div class="fr mg_t5">
                    <div class="filterBox">
                        <a class="d_search_pop_open" onclick="fnShowPop('d_search_md')">
                            <span class="txt">상세 검색</span>
                            <span class="icon"><img src="/static/www/img/sub/filter_icon.png"></span>
                        </a>
                    </div>
                </div>
            </div>
            <!--e 라디오박스 필터-->
        <?php elseif ($data['type'] === 'company') : ?>
            <!--s sel_lineb-->
            <div class="sel_lineb">
                <!--s selBox-->
                <div class="selBox">
                    <!--s selectbox-->
                    <div class="selectbox">
                        <dl class="dropdown">
                            <dt><a href="javascript:void(0)" class="myclass">공고명순</a></dt>
                            <dd>
                                <ul class="dropdown2" style="display:none;">
                                    <li>
                                        <label class="<?= ($data['sort'] == '6') ? 'on' : '' ?>">공고명순<input name='sort' type='radio' value='6' class='hide' <?= ($data['sort'] == '6') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '7') ? 'on' : '' ?>'>업종<input name='sort' type='radio' value='7' class='hide' <?= ($data['sort'] == '7') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '8') ? 'on' : '' ?>'>지역<input name='sort' type='radio' value='8' class='hide' <?= ($data['sort'] == '8') ? 'checked' : '' ?>></label>
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <!--e selectbox-->
                </div>
                <!--e selBox-->
            </div>
            <!--e sel_lineb-->

            <!--s 라디오박스 필터-->
            <div class="mg_b30">
                <div class="chek_box radio">
                    <input id='hire' name="hire" type="checkBox" value="on" <?= $data['hire'] ? 'checked' : '' ?>>
                    <label for="hire" class="lbl black">지금 채용중</label>
                </div>
            </div>
            <!--e 라디오박스 필터-->
        <?php elseif ($data['type'] === 'deepSearch') : ?>

            <!--s sel_lineb-->
            <div class="sel_lineb">
                <span class="mg_r10">총 <?= $data['count']['deepSearch'] ?? '' ?>건</span>
                <!--s selBox-->
                <div class="selBox">
                    <!--s selectbox-->
                    <div class="selectbox">
                        <dl class="dropdown">
                            <dt><a href="javascript:void(0)" class="myclass">공고명순</a></dt>
                            <dd>
                                <ul class="dropdown2">
                                    <li>
                                        <label class="<?= ($data['sort'] == '1') ? 'on' : '' ?>">공고명순 <input name='sort' type='radio' value='1' style='display:none' <?= ($data['sort'] == '1') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '2') ? 'on' : '' ?>'>최근등록순 <input name='sort' type='radio' value='2' style='display:none' <?= ($data['sort'] == '2') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '3') ? 'on' : '' ?>'>마감임박순 <input name='sort' type='radio' value='3' style='display:none' <?= ($data['sort'] == '3') ? 'checked' : '' ?>></label>
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <!--e selectbox-->
                </div>
                <!--e selBox-->
            </div>
            <!--e sel_lineb-->

            <!--s 라디오박스 필터-->
            <div class="overflow mg_b30">
                <div class="fr mg_t5">
                    <div class="filterBox">
                        <a class="d_search_pop_open" onclick="fnShowPop('d_search_md')">
                            <?php if ($data['type'] === 'deepSearch') : ?>
                                <span class="txt point">상세 검색 적용중</span>
                            <?php else : ?>
                                <span class="txt">상세 검색</span>
                            <?php endif; ?>

                            <span class="icon"><img src="/static/www/img/sub/filter_icon.png"></span>
                        </a>
                    </div>
                </div>
            </div>
            <!--e 라디오박스 필터-->
        <?php endif; ?>

        <div class='cont'>
            <!--s perfitUl-->
            <ul class="perfitUl">
                <!--s 무한루프-->
                <?php if ($data['recruitList'] ?? false) : ?>
                    <?php foreach ($data['recruitList'] as $key => $val) : ?>
                        <li>
                            <!--s itemBox-->
                            <div class="itemBox">
                                <a href='<?= $data['type'] === 'company' ?  '/company/detail/' : '/jobs/detail/' ?><?= $val['idx'] ?>'>
                                    <div class="img">
                                        <?= ($val['r_idx'] ?? false) ? '<span class="ai_txt ai_txt_line">채용중</span>' : '' ?>
                                        <img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? "/data/no_img.png" ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                    </div>
                                </a>

                                <!--s txtBox-->
                                <div class="txtBox">
                                    <a href='<?= $data['type'] === 'company' ?  '/company/detail/' : '/jobs/detail/' ?><?= $val['idx'] ?>'>
                                        <div class="tlt"><?= $val['com_name'] ?></div>
                                    </a>
                                    <?php if ($data['type'] != 'company') : ?>
                                        <div class="product_desc"><?= $val['rec_title'] ?></div>
                                    <?php endif; ?>

                                    <div class="gtxtBox">
                                        <div class="gtxt"><?= $val['com_address'] ?><?= $data['type'] != 'company' ? "<span>|</span>{$val['rec_career']}" : '' ?></div>
                                        <div class="gdata"><?= $data['type'] != 'company' ? $val['rec_end_date'] : '' ?></div>
                                    </div>

                                    <!--s gBtn_color-->
                                    <?php if ($data['type'] === 'company' && ($val['com_practice_interview'] === 'Y')) : ?>
                                        <div class="gBtn_color mg_t80">
                                            <a href="javascript:void(0)">모의 인터뷰 가능</a>
                                        </div>
                                    <?php elseif ($val['applied'] ?? false) : ?>
                                        <div class="gBtn_color">
                                            <a href='/jobs/detail/<?= $val['idx'] ?>'>내 인터뷰로 지원 가능</a>
                                        </div>
                                    <?php endif; ?>
                                    <!--e gBtn-->
                                </div>
                                <!--e gBtn_color-->

                                <!--s bookmark_iconBox-->
                                <div class="bookmark_iconBox">
                                    <button type='button' class="bookmark_icon  <?= ($val['scrap'] ?? false) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $val['idx'] ?>' data-type='<?= $data['type'] === 'company' ? 'company' : 'recruit' ?>'>
                                        <span class="blind">스크랩</span>
                                    </button>
                                </div>
                                <!--e bookmark_iconBox-->
                            </div>
                            <!--e itemBox-->
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li class="no_list">
                        <!-- 리스트없을때 -->
                        <div class="ngp"><span>!</span></div>
                        찾으시는 검색 결과가 없어요!
                    </li>
                <?php endif; ?>
                <!--e 무한루프-->
            </ul>
            <?= $data['pager']->links('search', 'front_full') ?>
            <!--e perfitUl-->
        </div>

        <?php if (!$data['recruitList'] && $data['type'] != 'company') : ?>
            <!--s cont_pd_bottom-->
            <div class="cont">
                <!--s 공고 추천-->
                <div class="contBox">
                    <div class="stlt">대신 이런 공고는 어떠세요?</div>
                </div>

                <!--s acmBox-->
                <div class="acmBox">
                    <!--s acm_sl-->
                    <div class="acm_sl">
                        <!--s 무한루프-->
                        <?php foreach ($data['otherList'] as $val) : ?>
                            <!--s item-->
                            <div class="item">
                                <a href="/jobs/detail/<?= $val['rec_idx'] ?>">
                                    <div class="imgBox">
                                        <div class="bookmark_iconBox">
                                            <button type='button' class="bookmark_icon  <?= ($val['scrap'] ?? false) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $val['rec_idx'] ?>' data-type='recruit'>
                                                <span class="blind">스크랩</span>
                                            </button>
                                        </div>

                                        <div class="img"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? "/data/no_img.png" ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                    </div>

                                    <div class="txtBox">
                                        <div class="tlt"><?= $val['com_name'] ?></div>
                                        <div class="product_desc"><?= $val['rec_title'] ?></div>
                                        <div class="gtxt"><?= $val['com_address'] ?></div>
                                    </div>
                                </a>
                            </div>
                            <!--e item-->
                        <?php endforeach; ?>
                        <!--e 무한루프-->
                    </div>
                    <!--e acm_sl-->
                </div>
                <!--e acmBox-->
                <!--e 공고 추천-->
            </div>
            <!--e cont_pd_bottom-->
        <?php elseif (!$data['recruitList'] && $data['type'] === 'company') : ?>
            <!--s cont_pd_bottom-->
            <div class="cont">
                <!--s 기업 추천-->
                <div class="contBox">
                    <div class="stlt">대신 이런 기업은 어떠세요? </div>
                </div>

                <!--s cptBox-->
                <div class="cptBox">
                    <!--s cpt_sl-->
                    <div class="cpt_sl c">
                        <!--s 무한루프-->
                        <?php foreach ($data['otherList'] as $val) : ?>
                            <!--s item-->
                            <div class="item">
                                <a href="/company/detail/<?= $val['com_idx'] ?>">
                                    <div class="bookmark_iconBox">
                                        <button type='button' class="bookmark_icon  <?= ($val['scrap'] ?? false) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $val['com_idx'] ?>' data-type='company'>
                                            <span class="blind">스크랩</span>
                                        </button>
                                    </div>
                                    <span class="ai_txt">A.I. 추천</span>

                                    <div class="img"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? "/data/no_img.png" ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" style="margin-left: unset;"></div>

                                    <div class="txtBox">
                                        <div class="tlt"><?= $val['com_name'] ?></div>
                                        <div class="gtxt"><?= $val['com_industry'] ?><span>|</span><?= $val['com_address'] ?></div>

                                        <!-- <span class="ai_txt_line">채용중</span> -->
                                    </div>
                                </a>
                            </div>
                            <!--e item-->
                        <?php endforeach; ?>
                        <!--e 무한루프-->
                    </div>
                    <!--e cpt_sl-->
                </div>
                <!--e cptBox-->
                <!--e 기업 추천-->
            </div>
            <!--e cont_pd_bottom-->
        <?php endif; ?>