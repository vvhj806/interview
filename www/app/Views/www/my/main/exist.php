<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">기존 프로필에서 선택</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="contBox c">
        <!--s prf_fileUl-->
        <div class="prf_fileUl">
            <ul>
                <?php foreach ($data['profile'] as $key => $val) : ?>
                    <li>
                        <div class="chek_box checkbox">
                            <input id="<?= $val['idx'] ?>" name="seletImg" type="checkbox" value="<?=$val['Enidx']?>">
                            <label for="<?= $val['idx'] ?>" class="lbl"></label>
                        </div>
                        <img src="<?= $data['url']['media'] . $val['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!--e prf_fileUl-->
    </div>
    <!--e cont-->
    <!--s BtnBox-->
    <div class="BtnBox">
        <button id="complete" type="button" class="btn btn01 wps_100">선택완료</button>
    </div>
    <!--e BtnBox-->
</div>
<!--e #scontent-->
<script>
    $('input[type="checkbox"][name="seletImg"]').on('click', function() {
        if ($(this).prop('checked')) {
            $('input[type="checkbox"][name="seletImg"]').prop('checked', false);
            $(this).prop('checked', true);
        }
    });

    $('#complete').on('click', function() {
        const fileIdx = $("input:checkbox[name='seletImg']:checked").attr('value');
        location.href = "/my/modify?file=" + fileIdx;
    });
</script>