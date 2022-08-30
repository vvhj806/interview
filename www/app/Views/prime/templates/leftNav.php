<!--s naviBox-->
<div class="naviBox">
    <!--s navi_tltBox-->
    <div class="navi_tltBox">
        <div class="icon"><i class="la la-home"></i></div>
        <div class="tlt">하이버프</div>
    </div>
    <!--e navi_tltBox-->

    <!--s navi-->
    <ul class="navi">
        <li class="mu_1">
            <div class="tlt <?= in_array('main', $data['aPage']) ? 'on' : '' ?>">
                <a href="<?= $data['url']['www'] ?>/prime/main">메인</a>
            </div>
            <div class="detail_list no_dl"></div>
        </li>

        <?php foreach ($data['leftNav'] as $val) : ?>
            <li class="mu_1">
                <?php foreach ($val as $key2 => $val2) : ?>
                    <?php if ($key2 == 0) : ?>
                        <?php if ((in_array($val2['idx'], $data['memBigMenu']) || $data['memMenuIdx'][0] == 0) && $data['memMenuIdx'][0] != null && $data['memMenuIdx'][0] != "") : ?>
                            <div class="tlt">
                                <a href="javascript:void(0)"><span><?= $val2['menu_depth_txt'] ?></span></a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <div class="detail_list">
                    <ul>
                        <?php foreach ($val as $key2 => $val2) : ?>
                            <?php if ($key2 != 0) : ?>
                                <?php if ((in_array($val2['idx'], $data['memMenuIdx']) || $data['memMenuIdx'][0] == 0) && $data['memMenuIdx'][0] != null && $data['memMenuIdx'][0] != "") : ?>
                                    <li class="mu_2 <?= $val2['menu_link'] == '/' . $data['page'] ? 'on' : '' ?>">
                                        <a href="<?= $data['url']['www'] . $val2['menu_link'] ?>"><span><?= $val2['menu_depth_txt'] ?></span></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <!--e navi-->
</div>
<!--e naviBox-->