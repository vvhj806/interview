<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox">
        <!--s top_tltcont-->
        <div class="top_tltcont c">
            <div class="tlt">채용</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <form id='frm' method="self">
        <!--s top_tltBox-->
        <div class="top_tltBox">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <!--s top_shBox-->
                <div class="top_shBox top_shBox2">
                    <span id="searchclear" class='searchclear'><img src="/static/www/img/sub/list_close.png"></span>
                    <div class="iconBox"><button type="submit" value="검색"><img src="/static/www/img/main/m_sh_icon.png"></button></div>
                    <input name="searchText" type="text" id="searchinput" class="top_sh_inp" value="<?= $data['search']['text'] ?? '' ?>" placeholder="직무, 회사명, 공고명으로 검색해보세요">
                </div>
                <!--e top_shBox-->
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s contBox-->
        <div class="contBox mg_t50">
            <!--s sel_lineb-->
            <div class="sel_lineb">
                <!--s selBox-->
                <div class="selBox">
                    <!--s selectbox-->
                    <div class="selectbox">
                        <dl class="dropdown">
                            <dt><a href="#n" class="myclass">조회순</a></dt>
                            <dd>
                                <ul class="dropdown2">
                                    <li>
                                        <label class="<?= isset($data['searchOrder']) && $data['searchOrder'] == "rec_hit" ? 'on' : '' ?>">조회순
                                            <input name='searchOrder' type='radio' value='rec_hit' style='display:none' <?= isset($data['searchOrder']) && $data['searchOrder'] == "rec_hit" ? 'checked' : '' ?>>
                                        </label>
                                    </li>
                                    <li>
                                        <label class='<?= isset($data['searchOrder']) && $data['searchOrder'] == "rec_reg_date" ? 'on' : '' ?>'>최근등록순
                                            <input name='searchOrder' type='radio' value='rec_reg_date' style='display:none' <?= isset($data['searchOrder']) && $data['searchOrder'] == "rec_reg_date" ? 'checked' : '' ?>>
                                        </label>
                                    </li>
                                    <li>
                                        <label class='<?= isset($data['searchOrder']) && $data['searchOrder'] == "rec_end_date" ? 'on' : '' ?>'>마감임박순
                                            <input name='searchOrder' type='radio' value='rec_end_date' style='display:none' <?= isset($data['searchOrder']) && $data['searchOrder'] == "rec_end_date" ? 'checked' : '' ?>>
                                        </label>
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
                    <div class="chek_box radio">
                        <input id='myitv' name="searchMyApply" type="checkbox" id="searchMyApply" value="M" <?= (isset($data['searchMyApply']) && $data['searchMyApply'] == true) ? 'checked' : '' ?> onChange="this.form.submit()">
                        <label for="myitv" class="lbl black">내 인터뷰로 지원 가능</label>
                    </div>
                </div>

                <div class="fr mg_t5 mg_2">
                    <div class="filterBox">
                        <a href="/search/action?deepSearchChk=on&keyword=&type=deepSearch" class="d_search_pop_open"><span class="txt">더 자세한 조건으로 검색하기</span> <span class="icon"><img src="/static/www/img/sub/filter_icon.png"></span></a>
                    </div>
                </div>
            </div>
            <!--e 라디오박스 필터-->

        </div>
        <!--e contBox-->
    </form>

    <?php if ($data['interest'] === false) : ?>
        <a href='/my/interest/main'>
            <!--s rcm_bnBox-->
            <div class="rcm_bnBox white">
                <!--s contBox-->
                <div class="contBox overflow">
                    <!--s txtBox-->
                    <div class="txtBox">
                        <p>어떤 포지션에서 일하고 싶나요?</p>
                        관심사 입력하고, 맞춤 공고 확인하기
                    </div>
                    <!--e txtBox-->

                    <div class="img"><img src="/static/www/img/sub/rcm_icon.png"></div>
                </div>
                <!--e contBox-->
            </div>
            <!--e rcm_bnBox-->
        </a>
    <?php endif; ?>

    <!--s cont-->
    <div class="cont">
        <!--s perfitUl-->
        <ul class="perfitUl">
            <!--s 무한루프-->
            <?php if (empty($data['recruit'])) : ?>
                <!-- 리스트없을때 -->
                <li class="no_list">
                    <div class="ngp"><span>!</span></div>
                    찾으시는 검색 결과가 없어요!
                </li>
            <?php endif; ?>

            <?php foreach ($data['recruit'] as $row) : ?>
                <li>
                    <!--s itemBox-->
                    <div class="itemBox">
                        <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                            <div class="img">
                                <img src="<?= $data['url']['media'] ?><?= $row['fileComLogo'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                            </div>
                        </a>

                        <!--s txtBox-->
                        <div class="txtBox">
                            <a href="/jobs/detail/<?= $row['recIdx'] ?>">
                                <div class="tlt"><?= $row['comName'] ?></div>
                            </a>
                            <div class="product_desc"><?= $row['recTitle'] ?></div>

                            <div class="gtxtBox">
                                <div class="gtxt"><?= $row['area_depth_text_1'] ?><span>|</span><?= $row['recCareer'] ?></div>
                                <div class="gdata"><?= $row['recEndDate'] ?></div>
                            </div>

                            <?php if ($row['recApply'] != '') : ?>
                                <div class="gBtn_color">
                                    <a href="/jobs/detail/<?= $row['recIdx'] ?>">내 인터뷰로 지원 가능</a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!--s bookmark_iconBox-->
                        <div class="bookmark_iconBox">
                            <button type='button' class="bookmark_icon  <?= isset($row['scrap']) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $row['recIdx'] ?>'>
                                <span class="blind">스크랩</span>
                            </button>
                        </div>
                        <!--e bookmark_iconBox-->
                    </div>
                    <!--e itemBox-->
                </li>
            <?php endforeach; ?>
            <!--e 무한루프-->
        </ul>
        <!--e perfitUl-->

        <!--s paging-->
        <?= $data['pager']->links('jobsList', 'front_full') ?>
        <!--e paging-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<script>
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
        //검색시 닫기버튼이 생성됨
        let $ipt = $('#searchinput'),
            $clearIpt = $('#searchclear');

        $ipt.keyup(function() {
            $('#searchclear').toggle(Boolean($(this).val()));
        });

        $clearIpt.toggle(Boolean($ipt.val()));
        $clearIpt.click(function() {
            $('#searchinput').val('').focus();
            $(this).hide();
        });

        $('.bookmark_icon').on('click', function() { // 북마크
            const emlThis = $(this);
            const type = 'recruit';
            const memidx = '<?= $data['memberIdx'] ?? false ?>';
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

        $('input[name="searchOrder"]').on('change', function() { // 드롭다운 바뀔때마다
            $('#frm').submit();
        });

        //시작시 실행
        $('.dropdown2').find('input:radio:checked').each(function() {
            let text = $(this).parents('label').text();
            $('.myclass').text(text);
        });
        //시작시 실행 끝
    });
</script>