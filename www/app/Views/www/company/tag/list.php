<form id='frm' method="GET">
    <!--s #scontent-->
    <div id="scontent">
        <!--s top_tltBox-->
        <div class="top_tltBox c">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <a href="explore">
                    <div class="backBtn"><span>뒤로가기</span></div>
                </a>
                <div class="tlt">태그 모아보기</div>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s gray_bline_first-->
        <div class="gray_bline_first gray_bline_top">
            <!--s contBox-->
            <div class="contBox">

                <div class="stltBox">
                    <div class="stlt">태그<span class='tagPoint'>0</span>개 선택됨</div>
                    <div class="plus_more_btn"><a href="javascript:void(0)" onclick="fnShowPop('tag_pop')">더보기 <i class="la la-plus"></i></a></div>
                </div>
                <!--s position_ckBox-->
                <div class="position_ckBox">
                    <ul class='tags'>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT8' type="checkbox">
                                <label for="T8">#교통비지원</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT7' type="checkbox">
                                <label for="T7">#재택근무</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT6' type="checkbox">
                                <label for="T6">#야근수당</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT5' type="checkbox">
                                <label for="T5">#자유로운연차사용</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT4' type="checkbox">
                                <label for="T4">#점심제공</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT3' type="checkbox">
                                <label for="T3">#정시퇴근</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT2' type="checkbox">
                                <label for="T2">#유연근무</label>
                            </div>
                        </li>
                        <li>
                            <div class="ck_radio">
                                <input id='fakeT1' type="checkbox">
                                <label for="T1">#자율복장</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--e position_ckBox-->
            </div>
            <!--e contBox-->
        </div>
        <!--s gray_bline_first-->

        <div class="spopBtn">
            <button type='submit' class="spop_btn02 wps_100 tag_list_btn">
                태그(<span class='tagPoint'>0</span>)개 선택완료
            </button>
        </div>

        <!--s contBox-->
        <div class="cont">
            <!--s sel_lineb-->
            <div class="sel_lineb">
                <!--s selBox-->
                <div class="selBox">
                    <!--s selectbox-->
                    <div class="selectbox">
                        <dl class="dropdown">
                            <dt><a href="javascript:void(0)" id='myclass' class="myclass">업종</a></dt>
                            <dd>
                                <ul class="dropdown2">
                                    <li>
                                        <label class="<?= ($data['sort'] == '1') ? 'on' : '' ?>">관련도순<input name='sort' type='radio' value='1' class='hide' <?= ($data['sort'] == '1') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class="<?= ($data['sort'] == '2') ? 'on' : '' ?>">규모<input name='sort' type='radio' value='2' class='hide' <?= ($data['sort'] == '2') ? 'checked' : '' ?>></label>
                                    </li>
                                    <li>
                                        <label class='<?= ($data['sort'] == '3') ? 'on' : '' ?>'>업종<input name='sort' type='radio' value='3' class='hide' <?= ($data['sort'] == '3') ? 'checked' : '' ?>></label>
                                    </li>
                                    <!-- <li>
                                        <label class='<?= ($data['sort'] == '4') ? 'on' : '' ?>'>지역<input name='sort' type='radio' value='4' class='hide' <?= ($data['sort'] == '4') ? 'checked' : '' ?>></label>
                                    </li> -->
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <!--e selectbox-->
                </div>
                <!--e selBox-->
            </div>
            <!--e sel_lineb-->

            <!--s overflow-->
            <div class="overflow mg_b30">
                <div class="fl">
                    <div class="chek_box radio">
                        <input id='hire' name="hire" type="checkBox" value="on" <?= $data['hire'] ? 'checked' : '' ?>>
                        <label for="hire" class="lbl black">지금 채용중</label>
                    </div>
                </div>

                <div class="fr mg_t5">총 <?= $data['count'] ?>건</div>
            </div>
            <!--e eoverflow-->

            <!--s perfitUl-->
            <ul class="perfitUl">
                <?php foreach ($data['list'] as $row) : ?>
                    <li>
                        <!--s itemBox-->
                        <div class="itemBox">
                            <a href="/company/detail/<?= $row['comIdx'] ?>">
                                <div class="img">
                                    <?= $row['recIdx'] ? '<span class="ai_txt ai_txt_line">채용중</span>' : '' ?>
                                    <img src="<?= $data['url']['media'] ?><?= $row['fileSave'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                </div>
                            </a>

                            <!--s txtBox-->
                            <div class="txtBox">
                                <a href="/company/detail/<?= $row['comIdx'] ?>">
                                    <div class="tlt"><?= $row['comName'] ?></div>
                                </a>

                                <div class="gtxtBox">
                                    <div class="gtxt txt_line"><?= $row['comIdustry'] ?><span>|</span><?= $row['comAddr'] ?></div>
                                </div>

                                <!--s gBtn_color-->
                                <div class="gBtn_color mg_t80">
                                    <?= $row['configTagTxt'] ? '<span class="span_txt">' . $row['configTagTxt'] . '</span>' : '' ?>
                                    <span class="num"><?= $row['tagCnt'] > 0 ? "+ {$row['tagCnt']}" : '' ?></span>
                                </div>
                                <!--e gBtn-->
                            </div>
                            <!--e gBtn_color-->

                            <!--s bookmark_iconBox-->
                            <div class="bookmark_iconBox">
                                <button type='button' class="bookmark_icon  <?= ($row['scrap'] ?? false) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $row['comIdx'] ?>' data-type='company'>
                                    <span class="blind">스크랩</span>
                                </button>
                            </div>
                            <!--e bookmark_iconBox-->
                        </div>
                        <!--e itemBox-->
                    </li>
                <?php endforeach; ?>
            </ul>
            <!--e perfitUl-->

        </div>
        <!--e contBox-->
    </div>
    <!--e #scontent-->

    <!--s 태그모달-->
    <div id="tag_pop" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont md_pop_content">
                <!--s spop_tltBox-->
                <div class="spop_tltBox mg_b15">
                    <div class="spop_tlt">태그선택하기</div>
                    <a href="javascript:void(0)" class="spop_close_btn" onclick="fnHidePop('tag_pop')"><img src="/static/www/img/sub/close_btn_icon.png"></a><!-- onclick 누르면 닫히 -->
                </div>
                <!--e spop_tltBox-->

                <!--s position_ckBox-->
                <div class="position_ckBox">
                    <ul class='tags real'>
                        <?php foreach ($data['tag'] as $row) : ?>
                            <li>
                                <input type="checkbox" name="tagCheck[]" id="T<?= $row['idx'] ?>" value="<?= $row['idx'] ?>" <?= isset($data['get']['tag']) && in_array($row['idx'], $data['get']['tag']) ? 'checked' : '' ?>>
                                <label for="T<?= $row['idx'] ?>">#<?= $row['tag_txt'] ?></label>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
                <!--e position_ckBox-->
            </div>
            <!--e pop_cont-->

            <!--s spopBtn-->
            <div class="spopBtn">
                <button type='submit' class="spop_btn02 wps_100 spop_close">
                    태그(<span class='tagPoint'>0</span>)개 선택완료
                </button>
            </div>
            <!--e spopBtn-->
        </div>
        <!--e pop_Box-->

    </div>
    <!--e 태그모달-->
</form>

<script>
    function scrap(state, memidx, idx, ele) {
        $.ajax({
            type: "GET",
            url: `/api/my/scrap/${state}/company/${memidx}/${idx}`,
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

    function getListLength(listName) {
        let iLength = $(`.real`).find('input:checkBox:checked').length;
        $(`.${listName}Point`).text(iLength);
    }

    $(document).ready(function() {
        $('.dropdown2').find('input:radio:checked').each(function() {
            let text = $(this).parents('label').text();
            $('#myclass').text(text);
        });

        $('.tags').find('input:checkBox').each(function() {
            getListLength('tag');
            let realId = $(this).attr('id');
            let check = $(this).is(':checked');
            $(`#fake${realId}`).prop('checked', check).trigger('change');
        });
    });

    $('input[name="hire"]').on('change', function() {
        $('#frm').submit();
    });

    $('input[name="sort"]').on('change', function() {
        $('#frm').submit();
    });

    $('.tags').find('input:checkBox').on('change', function() {
        getListLength('tag');
        let realId = $(this).attr('id');
        let check = $(this).is(':checked');
        $(`#fake${realId}`).prop('checked', check).trigger('change');
    });

    $('.bookmark_icon').on('click', function() {
        const emlThis = $(this);
        const memidx = '<?= $data['session']['idx'] ?>';
        const idx = emlThis.data('idx');
        if (!memidx) {
            alert('로그인이 필요한 서비스 입니다.');
            location.href = '/login';
            return;
        }
        if (emlThis.hasClass('on')) {
            scrap('delete', memidx, idx, emlThis);
        } else if (emlThis.hasClass('off')) {
            scrap('add', memidx, idx, emlThis);
        }
    });
</script>

<style>
    button {
        border: none;
    }
</style>