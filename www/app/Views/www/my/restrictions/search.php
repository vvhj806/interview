<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/restrictions">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">
                차단 기업 추가
                <input id='member' type='hidden' value="<?= $data['session']['idx'] ?>">
            </div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="cont cont_pd_bottom">

        <!--s top_tltBox-->
        <div class="top_tltBox mg_b40">
            <!--s top_tltcont-->
            <div class="top_tltcont top_tltcont2">
                <!--s top_shBox-->
                <div class="top_shBox top_shBox2">
                    <span id="searchclear" class='searchclear' style="display: none;"><img src="/static/www/img/sub/list_close.png"></span>
                    <div class="iconBox"><button type="search"><img src="/static/www/img/main/m_sh_icon.png"></button></div>
                    <form method="self">
                        <input type="text" id="searchinput" name="keyword" class="top_sh_inp" value='<?= $data['keyword'] ?? '' ?>' placeholder="직무, 회사명, 공고명으로 검색해보세요">
                    </form>
                </div>
                <!--e top_shBox-->
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->
        <!--s sel_lineb-->
        <div class="sel_lineb">
            <div class="mg_b10">검색결과 <span class="point b"><span id='total'><?= $data['allCount'] ?></span>건</span></div>
        </div>
        <!--e sel_lineb-->

        <!--s cut_off_list-->
        <div class="cut_off_list">
            <ul>
                <li class="no_list <?= $data['list'] ? 'hide' : '' ?>" style='height: auto'>
                    <!-- 리스트없을때 -->
                    <div class="ngp"><span>!</span></div>
                    해당하는 기업이 없어요!
                </li>
                <?php foreach ($data['list'] as $val) : ?>
                    <li>
                        <a href='/company/detail/<?= $val['comIdx'] ?>' class="txt"><?= $val['comName'] ?></a>
                        <button value='<?= $val['comIdx'] ?>' class="co_btn">차단하기</button>
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
    //검색시 닫기버튼이 생성됨
    let $ipt = $('#searchinput'),
        $clearIpt = $('#searchclear');

    $ipt.keyup(function() {
        $('#searchclear').toggle(Boolean($(this).val()));
    });

    $clearIpt.toggle(Boolean($ipt.val()));
    $clearIpt.click(function() {
        $('#searchinput').val('').focus();
        $(this).hide();
    });
    
    $('.co_btn').on('click', function() {
        const comIdx = $(this).val();
        const memIdx = $('#member').val();
        const thisBox = $(this).closest('li');
        if (flag) {
            flag = false;
            $.ajax({
                type: 'GET',
                url: `/api/my/restrictions/add/${memIdx}/${comIdx}`,
                success: function(data) {
                    flag = true;
                    thisBox.remove();
                    const total = $('#total').text();
                    $('#total').text(total - 1);
                    alert2(data.messages);
                    return;
                },
                error: function(e) {
                    alert(e.responseJSON.messages);
                    location.reload();
                    return;
                },
                timeout: 5000
            }); //ajax
        }
    })
</script>

<style>
    button {
        border: none;
        height: 100%;
    }
</style>