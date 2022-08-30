<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">PER<span class="point">FIT</span> 한 기업 찾기</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s pft_imgBox-->
    <div class="pft_imgBox">
        <!--s pft_imgcont-->
        <div class="pft_imgcont">
            <!--s pft_imgtxt-->
            <div class="pft_imgtxt">
                내 AI인터뷰, 어디에 지원해야<br />
                합격률이 높을까?<br /><br />

                하이버프 인공지능이<br />
                내 AI리포트를 기반으로 <br />
                나와 가장 잘 맞는 채용을 찾아드려요
            </div>
            <!--e pft_imgtxt-->

            <div class="pft_img"><img src="/static/www/img/sub/perfit_img.png"></div>
        </div>
        <!--e pft_imgcont-->
    </div>
    <!--e pft_imgBox-->

    <!--s cont-->
    <div class="cont">
        <!--s mtltBox-->
        <div class="mtltBox">
            <div class="mtlt">
                나의 [<?= $data['jobText'] ?>] 리포트에 <br />
                <span class="point b">관심있어할 기업</span>
            </div>
        </div>
        <!--e mtltBox-->

        <!--s perfitUl-->
        <ul class="perfitUl">
            <!--s 무한루프-->
            <?php
            foreach ($data['comInfo'] as $key => $val) :
            ?>

                <li>
                    <!--s itemBox-->
                    <div class="itemBox">
                        <a href="/company/detail/<?= $val[0]['idx'] ?>">
                            <div class="img">
                                <span class="ai_txt">A.I. 추천</span>
                                <img src="<?= $data['url']['media'] ?><?= $val[0]['file_save_name'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                            </div>
                        </a>

                        <!--s txtBox-->
                        <div class="txtBox">
                            <a href="javascript:void(0)">
                                <div class="tlt"><?= $val[0]['com_name'] ?></div>
                            </a>
                            <div class="gtxt"><?= $val[0]['com_address'] ?></div>

                            <!--s gBtn-->
                            <div class="gBtn">
                                <a href="/search/action?keyword=<?= $val[0]['com_name'] ?>&type=recruit">채용공고 <?= $val[0]['recCnt'] ?>건 보러가기</a>
                            </div>
                            <!--e gBtn-->
                        </div>
                        <!--e txtBox-->

                        <!--s bookmark_iconBox-->
                        <div class="bookmark_iconBox">
                            <?php if ($data['scrapCom'][$key] == 1) : ?>
                                <button id="favCom<?= $key ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-scrap="delete" data-state="company" data-idx="<?= $val[0]['idx'] ?>" data-key="<?= $key ?>"><span class="blind">스크랩</span></button>
                            <?php else : ?>
                                <button id="favCom<?= $key ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-scrap="add" data-state="company" data-idx="<?= $val[0]['idx'] ?>" data-key="<?= $key ?>"><span class="blind">스크랩</span></button>
                            <?php endif; ?>
                        </div>
                        <!--e bookmark_iconBox-->
                    </div>
                    <!--e itemBox-->
                </li>

            <?php
            endforeach
            ?>
            <!--e 무한루프-->
        </ul>
        <!--e perfitUl-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<script>
    const memIdx = '<?= $data['memIdx'] ?>';

    $('.btn-scrap').on('click', function() {
        if (!'<?= $data['memIdx'] ?>') {
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
                            let favCom = $('#favCom' + key);
                            favCom.removeClass('off');
                            favCom.addClass('on');
                        }
                    } else if (strStrap == 'delete') {
                        if (state == 'company') {
                            let favCom = $('#favCom' + key);
                            favCom.removeClass('on');
                            favCom.addClass('off');
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