<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">이벤트</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_tab-->
    <div class="top_tab">
        <!--s depth-->
        <ul class="depth">
            <li class="<?= $data['stat'] === 'ing' ? 'on' : '' ?>"><a href="?stat=ing">진행중인 이벤트</a></li>
            <li class="<?= $data['stat'] === 'end' ? 'on' : '' ?>"><a href="?stat=end">종료된 이벤트</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s cont-->
    <div class="contBox">
        <!--s event_list-->
        <div class="event_list">
            <ul>
                <?php if (count($data['eventList'])) : ?>
                    <?php foreach ($data['eventList'] as $val) : ?>
                        <li>
                            <a href="event/<?= $val['idx'] ?>">
                                <img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                            </a>
                            <?= $val['bd_start_date'] ?> ~ <?= $val['bd_end_date'] ?>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li>진행중인 이벤트가 없습니다</li>
                <?php endif; ?>
            </ul>
        </div>
        <!--e event_list-->
        <?= $data['pager']->links('event', 'front_full') ?>
    </div>
    <!--e cont-->

</div>
<!--e #scontent-->