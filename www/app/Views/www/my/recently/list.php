<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">최근 본 공고</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="cont">
        <form id="frm" method="post" action="/my/recently/delete">
            <?= csrf_field() ?>
            <div class="stltBox mg_b20">
                <div class="stlt_stxt r">
                    <a href="javascript:void(0)" id='submit' class="a_line <?= $data['list'] ? '' : 'hide' ?>">삭제하기</a>
                </div>
            </div>

            <!--s perfitUl-->
            <ul class="perfitUl">

                <li class="no_list <?= $data['list'] ? 'hide' : '' ?>" style='height: auto'>
                    <!-- 리스트없을때 -->
                    <div class="ngp"><span>!</span></div>
                    최근 본 공고가 없어요!
                </li>

                <!--s 무한루프-->
                <?php foreach ($data['list'] as $val) : ?>
                    <li>
                        <!--s itemBox-->
                        <div class="itemBox">
                            <a href="javascript:void(0)">
                                <div class="chek_box checkbox">
                                    <input name="recIdx[]" type="checkbox" value="<?= $val['recIdx'] ?>">
                                    <label class="lbl"></label>
                                </div>
                            </a>
                            <div class="img">
                                <a href="/jobs/detail/<?= $val['recIdx'] ?>">
                                    <img src="<?= $data['url']['media'] ?><?= $val['fileComLogo'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                </a>
                                <a href="/jobs/detail/<?= $val['recIdx'] ?>" class="jwBtn">지원하기</a>
                            </div>

                            <!--s txtBox-->
                            <div class="txtBox">
                                <a href="/jobs/detail/<?= $val['recIdx'] ?>">
                                    <div class="tlt"><?= $val['comName'] ?></div>
                                </a>
                                <div class="product_desc"><?= $val['recTitle'] ?></div>

                                <div class="gtxtBox">
                                    <div class="gtxt"><?= $val['area_depth_text_1'] ?><span>|</span><?= $val['recCareer'] ?></div>
                                    <div class="gdata"><?= $val['recEndDate'] ?></div>
                                </div>

                                <?php if (in_array($val['recApply'], ['M', 'A'])) : ?>
                                    <!--s gBtn_color-->
                                    <div class="gBtn_color">
                                        <a href="/jobs/detail/<?= $val['recIdx'] ?>">내 인터뷰로 지원 가능</a>
                                    </div>
                                    <!--e gBtn-->
                                <?php endif; ?>
                            </div>
                            <!--e gBtn_color-->

                            <!--s bookmark_iconBox-->
                            <div class="bookmark_iconBox">
                                <button type='button' class="bookmark_icon  <?= ($val['scrap'] ?? false) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $val['recIdx'] ?>' data-type='recruit'>
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
        </form>
        <?php
        if ($data['list']) {
            $data['pager']->links('recently', 'front_full');
        }
        ?>
    </div>
    <!--e contBox-->
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
        $('input[name="recIdx[]"]:checked').each(function() {
            $(this).prop("checked", false);
        });
    })

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

    $('#submit').on('click', function() {
        if ($('input[name="recIdx[]"]:checked').length > 0) {
            $('#frm').submit();
        } else {
            alert('하나 이상 선택해 주세요.');
        }
    });
</script>