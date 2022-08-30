<div class="top_shBox">
    <span id="searchclear2" class='searchclear'><img src="/static/www/img/sub/list_close.png"></span>
    <div class="iconBox"><button type="button"><img src="/static/www/img/main/m_sh_icon.png"></button></div>
    <input name='' type="text" id="searchinput2" class="top_sh_inp" autocomplete='off' placeholder="직무 키워드를 검색해 보세요.">
</div>

<script>
    let jsonCategory = '<?= json_encode($data['job'], true) ?>';
    let jsonOriginalCategory = '<?= json_encode($data['original'], true) ?>';
    let searchCategory = [];
    let searchInput = $('#searchinput2'),
        $clearIpt = $('#searchclear2');

    $(document).ready(function() {
        jsonCategory = JSON.parse(jsonCategory);
        jsonOriginalCategory = JSON.parse(jsonOriginalCategory);

        for (let depth1 in jsonCategory['job_depth_3']) {
            for (let depth2 in jsonCategory['job_depth_3'][depth1]) {
                for (let depth3 in jsonCategory['job_depth_3'][depth1][depth2]) {
                    searchCategory[jsonCategory['job_depth_3'][depth1][depth2][depth3]['idx']] =
                        `[${jsonCategory['job_depth_1'][depth1]['jobName']}] [${jsonCategory['job_depth_2'][depth1][depth2]['jobName']}] - ${jsonCategory['job_depth_3'][depth1][depth2][depth3]['jobName']}`;
                }
            }
        }
    });

    $(document).on('click', function(event) {
        if (event.target.id != 'searchinput2') {
            if (!$('.cate_search_pop').hasClass('hide')) {
                $('.cate_search_pop').addClass('hide');
            }
        }
    });

    searchInput.on('input', function(event) { //검색시 닫기버튼이 생성됨
        let keyword = $(this).val();
        const onkey = event['originalEvent']['data'];

        if (!keyword) {
            $('.cate_search_pop').addClass('hide');
            return;
        }
        $('#searchclear2').toggle(Boolean(keyword));

        if (keyword.length >= 1 && !in_array(onkey, filter) && !in_array(onkey, [null, " "])) {
            keyword = keyword.toLocaleLowerCase();
            getSearch(keyword);
        }
    });

    searchInput.on('click', function() { // 검색 인풋 클릭
        let keyword = $(this).val();
        if (keyword) {
            keyword = keyword.toLowerCase();
            getSearch(keyword);
        }
    });

    $(document).on('click', '.cate_search_pop > .cate_search_list > li', function() { //검색 단어 클릭
        const idx = $(this).data('search');
        const depth1ScrollTap = $('.first_duty');
        const depth3ScrollTap = $('.second_duty');

        const depth1 = $(`#J${jsonOriginalCategory[idx]['job_depth_1']}`); // depth1
        depth1.prop('checked', true).trigger('change');
        const depth1nowTop = depth1.closest('li').position().top;
        searchScroll(depth1ScrollTap, depth1nowTop);

        const depth3 = $(`#D${jsonOriginalCategory[idx]['job_depth_1']}${jsonOriginalCategory[idx]['job_depth_2']}${jsonOriginalCategory[idx]['job_depth_3']}`); //depth2
        depth3.prop('checked', true).trigger('change');
        const depth2nowTop = depth3.closest('li').position().top;
        const depth3nowTop = depth3.closest('ul').closest('li').position().top;
        searchScroll(depth3ScrollTap, depth2nowTop + depth3nowTop);
    });

    $clearIpt.toggle(Boolean(searchInput.val()));
    $clearIpt.click(function() {
        $('#searchinput2').val('').focus();
        $(this).hide();
    });
</script>