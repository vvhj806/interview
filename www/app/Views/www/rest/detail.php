<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt"><?= $data['list']['bd_title'] ?></div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s lw_imgBox-->
    <div class="lw_imgBox" style="background:url(<?= $data['url']['media'] ?><?= $data['list']['file_save_name'] ?? '/data/no_img.png'?>) no-repeat 50% 0;"></div>
    <!--e lw_imgBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <!--s lw_tltBox-->
        <div class="lw_tltBox">
            <div class="tlt"><?= $data['list']['bd_title'] ?></div>
            <div class="data"><?= $data['list']['bd_reg_date'] ?></div>
        </div>
        <!--e lw_tltBox-->

        <!--s lw_txtcont-->
        <div class="lw_txtcont">
            <?= $data['list']['bd_content'] ?>
        </div>
        <!--e lw_txtcont-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->