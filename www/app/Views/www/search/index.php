<script>
    function deleteKeyword(type, keyword, ele) {
        $.ajax({
            type: 'GET',
            url: `search/keyword/delete/${type}/${keyword}`,
            success: function(data) {
                if (type == 'one') {
                    ele.remove();
                }
                if (data.status == 201) {
                    $('.keywords_box').empty();
                    $('.keywords_box').append(`<div class="kwd_none_txt">최근검색어가 없습니다.</div>`);
                }
            },
            error: function(e) {
                alert('이미 삭제된 검색어입니다.');
                return;
            },
            timeout: 5000
        }); //ajax
    }
    $(document).ready(function() {
        let $ipt = $('#searchinput'),
            $clearIpt = $('#searchclear');

        $ipt.keyup(function() { //검색시 닫기버튼이 생성됨
            $('#searchclear').toggle(Boolean($(this).val()));
        });

        $clearIpt.toggle(Boolean($ipt.val()));
        $clearIpt.click(function() {
            $('#searchinput').val('').focus();
            $(this).hide();
        });

        $('.deleteKeyword').on('click', function() {
            let keyword = $(this).val();
            let thisList = $(this).parents('li');
            deleteKeyword('one', keyword, thisList);
        });

        $('#delete_all').on('click', function() {
            deleteKeyword('all', null, null);
        });
    });
</script>
<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox overflow">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>

            <!--s top_shBox-->
            <div class="top_shBox">
                <form id="frm" method="get" action="/search/action">
                    <span id="searchclear" class='searchclear'><img src="/static/www/img/sub/list_close.png"></span>
                    <div class="iconBox"><button type="submit"><img src="/static/www/img/main/m_sh_icon.png"></button></div>
                    <input name='keyword' type="text" id="searchinput" class="top_sh_inp" placeholder="직무, 회사명, 공고명으로 검색해보세요">
                </form>
            </div>
            <!--e top_shBox-->
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="contBox cont_pd_none">
        <!--s stltBox-->
        <div class="stltBox">
            <div class="stlt fl">최근검색어</div>
            <div id='delete_all' class="stlt_stxt fr"><a href="javascript:void(0)">전체삭제</a></div>
        </div>
        <!--e stltBox-->

        <!--s keywords_box-->
        <div class="keywords_box">
            <!--s depth-->
            <ul id='keyword_box' class="depth">
                <?php
                if ($data['keyword']) :
                    foreach ($data['keyword'] as $val) : ?>
                        <li>
                            <a href="search/action?keyword=<?= $val ?>" class="kwd"><?= $val ?></a>
                            <button type='button' value='<?= $val ?>' class="kwd_close deleteKeyword">
                                <i class="la la-times"></i>
                            </button>
                        </li>
                    <?php endforeach;
                else : ?>
                    <div class="kwd_none_txt">최근검색어가 없습니다.</div>
                <?php endif; ?>
                <div id='keyword'></div>
            </ul>
            <!--e depth-->
        </div>
        <!--e keywords_box-->

        <div class="stlt c mg_t80">나만의 희망 근무조건이 있나요?</div>

        <!--s BtnBox-->
        <div class="BtnBox mg_t30">
            <a href="search/action?deepSearchChk=on&keyword=&type=deepSearch" class="btn btn02 wps_100">상세조건으로 검색하기<span class="arrow_r"><img src="/static/www/img/sub/blue_arrow_r.png"></span></a>
        </div>
        <!--e BtnBox-->

        <?php if ($data['list']) : ?>
            <div class="stlt mg_t60">추천검색어 </div>
            <!--s swordUl-->
            <ul class="swordUl">
                <?php foreach ($data['list'] as $row) : ?>
                    <li><a href="search/action?keyword=<?= $row['text'] ?>"><?= $row['text'] ?></a></li>
                <?php endforeach; ?>
            </ul>
            <!--e swordUl-->
        <?php endif; ?>
    </div>
    <!--e contBox-->

</div>
<!--e #scontent-->

<style>
    .deleteKeyword {
        border: none;
        color: #505bf0;
    }
</style>