<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <div class="tlt">기업탐색</div>
            <div class="company_search_icon"><a href="/search/action?keyword=&type=company"><img src="/static/www/img/main/m_sh_icon.png"></a></div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cs_bnBox-->
    <div class="cs_bnBox">
        <!--s contBox-->
        <div class="contBox overflow">
            <div class="overflow">
                <!--s txtBox-->
                <div class="txtBox">
                    지금 <span class="b"><?= $data['comCnt'] ?>개의 기업이 하이버프</span>에서<br />
                    <span class="b point">모의인터뷰 진행 중</span>
                </div>
                <!--e txtBox-->
                <a href="/interview/mock" class="btnBox">전체보기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
            </div>
        </div>
        <!--e contBox-->
    </div>
    <!--e cs_bnBox-->

    <!--s cs_bn_slBox-->
    <div class="cs_bn_slBox">
        <!--s cs_bn_sl-->
        <div class="cs_bn_sl">
            <a href="/board/rest/detail/7"><div class="item"><img src="/static/www/img/sub/cs_bn01.png"></div></a>
            <!-- <div class="item"><img src="/static/www/img/sub/cs_bn01.png"></div>
            <div class="item"><img src="/static/www/img/sub/cs_bn01.png"></div> -->
        </div>
        <!--e cs_bn_sl-->
    </div>
    <!--e cs_bn_slBox-->


    <!--s contBox-->
    <div class="cont">
        <!--s perfit_bn-->
        <div class="perfit_bn mg_t70">
            <a href="/interview/ready"><img src="/static/www/img/main/perfit_bn.png"></a>
        </div>
        <!--e perfit_bn-->

        <!--s mtltBox-->
        <div class="mtltBox mt_t70">
            <div class="mtlt">좋아하실 만한 기업을 모아봤어요</div>
        </div>
        <!--e mtltBox-->

        <!--s gbwBox-->
        <div class="gbwBox gbwBox2">
            <ul>
                <?php
                foreach ($data['companyTag'] as $val) :
                ?>
                    <li>
                        <a href="/company/tag?tagCheck%5B%5D=<?= $val['idx'] ?>">
                            <div class="img"><img src="/static/www/img/main/test_img02.jpg"></div>
                            <!--s abs_txtBox-->
                            <div class="abs_txtBox">
                                <div class="abs_txt"> # <?= $val['tag_txt'] ?></div>
                            </div>
                            <!--e abs_txtBox-->
                        </a>
                    </li>
                <?php
                endforeach
                ?>
            </ul>
        </div>
        <!--e gbwBox-->

        <!--s perfit_moreBtn-->
        <div class="perfit_moreBtn">
            <a href="/company/tag">전체보기</a>
        </div>
        <!--e perfit_moreBtn-->


        <!--s mtltBox-->
        <div class="mtltBox mt_t70">
            <div class="mtlt">AI인터뷰로 적극 채용중인 기업</div>
        </div>
        <!--e mtltBox-->

        <!--s team_mbBox-->
        <div class="team_mbBox">
            <!--s team_mb_Ul-->
            <div class="team_mb_Ul">
                <!--s team_mb_sl-->
                <div class="team_mb_sl">
                    <!--s 무한루프-->
                    <?php if (count($data['company']) != 0 && $data['company']) : ?>
                        <?php
                        foreach ($data['company'] as $key => $val) :
                        ?>
                            <div class="item">
                                <!--s itemBox-->
                                <div class="itemBox">
                                    <a href="/company/detail/<?= $val['idx'] ?>">
                                        <div class="img"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                    </a>

                                    <!--s txtBox-->
                                    <div class="txtBox">
                                        <a href="javascript:void(0)">
                                            <div class="tlt"><?= $val['com_name'] ?></div>

                                            <div class="gtxtBox mg_t10">
                                                <div class="gtxt"><?= $val['com_industry'] ?> <span>|</span> <?= $val['com_address'] ?></div>
                                            </div>
                                        </a>

                                        <div class="gBtn">
                                            <a href="/search/action?keyword=<?= $val['com_name'] ?>&type=recruit">채용공고 <?= $val['recCnt'] ?>건 보러가기</a>
                                        </div>
                                    </div>
                                    <!--e txtBox-->

                                    <!--s bookmark_iconBox-->
                                    <div class="bookmark_iconBox">
                                        <?php if ($data['isLogin'] == 0) : ?>
                                            <button class="bookmark_icon btn-scrap off" tabindex="0"><span class="blind">스크랩</span></button>
                                        <?php else : ?>
                                            <?php if ($data['ckLike'][$key] == 0) : ?>
                                                <button id="favCom<?= $key ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-scrap="add" data-state="company" data-idx="<?= $val['idx'] ?>" data-key="<?= $key ?>"><span class="blind">스크랩</span></button>
                                            <?php else : ?>
                                                <button id="favCom<?= $key ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-scrap="delete" data-state="company" data-idx="<?= $val['idx'] ?>" data-key="<?= $key ?>"><span class="blind">스크랩</span></button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <!--e bookmark_iconBox-->
                                </div>
                                <!--e itemBox-->
                            </div>
                        <?php
                        endforeach
                        ?>
                    <?php else : ?>
                        <div>채용중인 공고가 없습니다.</div>
                    <?php endif; ?>
                    <!--e 무한루프-->
                </div>
                <!--e team_mb_sl-->
            </div>
            <!--e team_mb_Ul-->
        </div>
        <!--e team_mbBox-->
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<script>
    const memIdx = '<?= $data['memIdx'] ?>';

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