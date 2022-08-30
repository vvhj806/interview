<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/interview/profile/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>">
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
                <?php foreach ($data['getAllfile'] as $key => $val) : ?>
                    <li>
                        <div class="chek_box checkbox" style="z-index:1">
                            <input id="<?= $val['idx'] ?>" name="seletImg" type="checkbox" value="<?= $val['Enidx'] ?>">
                            <label for="<?= $val['idx'] ?>" class="lbl"></label>
                        </div>
                        <img src="<?= $data['url']['media'] . $val['file_save_name'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" class="photoFit">
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
        <!--e prf_fileUl-->
        <!--s BtnBox-->
        <div class="BtnBox">
            <button id="complete" type="button" class="btn btn01 wps_100">선택완료</button>
            <form action="/interview/profile/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>" method="POST" id="existForm">
                <?= csrf_field() ?>
                <input name="fileIdx" id="fileIdx" type="hidden" value="">
                <input name="selectType" value="E" type="hidden">
                <input name="postCase" id="postCase" value="existFile" type="hidden">
                <input name="backUrl" value="/" type="hidden">
            </form>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e cont-->
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
        const fileIdx = $("input:checkbox[name='seletImg']:checked").val();
        if (!fileIdx) {
            alert('프로필을 선택해주세요');
            return;
        }
        $("#fileIdx").val(fileIdx);
        $("#existForm").submit();
    });
</script>