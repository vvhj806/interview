<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="suggest">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">
                차단기업 목록
                <a href="restrictions/search" class="top_gray_txtlink gray_txtlink">기업 검색</a>
                <input id='member' type='hidden' value="<?= $data['session']['idx'] ?>">
            </div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="cont">
        <!--s cut_off_list-->
        <div class="cut_off_list">
            <ul>
                <li class="no_list <?= $data['list'] ? 'hide' : '' ?>" style='height: auto'>
                    <!-- 리스트없을때 -->
                    <div class="ngp"><span>!</span></div>
                    차단한 기업이 없어요!
                </li>
                <?php foreach ($data['list'] as $val) : ?>
                    <li>
                        <div class="txt"><?= $val['comName'] ?></div>
                        <button value='<?= $val['comIdx'] ?>' class="co_btn">차단해제</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!--e cut_off_list-->

        <?= $data['pager']->links('restrictions_company', 'front_full') ?>
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<script>
    let flag = true;
    $('.co_btn').on('click', function() {
        const thisEle = $(this);
        const comIdx = thisEle.val();
        const memIdx = $('#member').val();
        if (flag) {
            flag = false;
            $.ajax({
                type: 'GET',
                url: `/api/my/restrictions/delete/${memIdx}/${comIdx}`,
                success: function(data) {
                    flag = true;
                    thisEle.closest('li').remove();
                    const listLength = $('.cut_off_list').find('li').length;
                    if (listLength == 1) {
                        $('.no_list').removeClass('hide');
                    }
                    alert2(data.messages);
                    return;
                },
                error: function(e) {
                    alert(e.messages);
                    location.reload();
                    return;
                },
                timeout: 5000
            }); //ajax
        }
    });
</script>

<style>
    button {
        border: none;
        height: 100%;
    }
</style>