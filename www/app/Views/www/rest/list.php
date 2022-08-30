<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">쉬어가는 가벼운 글</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont">
        <!--s sub_tab-->
        <div class="sub_tab">
            <!--s depth-->
            <ul class="depth">
                <li class='<?= $data['selectCategory'] === 'all' ? 'on' : '' ?>'><a href="?category=all">전체</a></li>
                <?php foreach ($data['category'] as $val) : ?>
                    <li class='<?= $data['selectCategory'] === $val['idx'] ? 'on' : '' ?>'>
                        <a href="?category=<?= $val['idx'] ?>">
                            <?= $val['rest_txt'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!--e depth-->
        </div>
        <!--e sub_tab-->

        <!--s gbwBox-->
        <div class="gbwBox">
            <ul>
                <?php foreach ($data['list'] as $val) : ?>
                    <li>
                        <a href="/board/rest/detail/<?= $val['idx'] ?>">
                            <div class="img"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                            <div class="txt">
                                <?= $val['bd_title'] ?>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!--e gbwBox-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->