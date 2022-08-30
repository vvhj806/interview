<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt"><?= $data['eventList']['bd_title'] ?></div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->
    
    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <!--s lw_txtcont-->
        <div class="lw_txtcont">
            <?= $data['eventList']['bd_content'] ?>
        </div>
        <!--e lw_txtcont-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<style>
    figure > img{
        width: 100% !important;
    }
</style>