<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">비즈 질문 관리</h3>
                <?= csrf_field() ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div style='width:29%; display:inline-block; background:#ddd;'>
                    <div>카테고리 선택
                        <div>
                            <button id='categoryBtn' type='button'>추가</button>
                            <input name='categoryName' type="text">
                        </div>
                    </div>
                    <ul id='category' class='dd'>
                        <li class='on' data-category-idx='0'>전체</li>
                        <?php foreach ($data['list'] as $val) : ?>
                            <li data-category-idx='<?= $val['idx'] ?>'>
                                <input value="<?= $val['com_que_category'] ?>">
                                <button>수정</button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div style='width:70%; display:inline-block; background:#ddd;'>
                    <div>질문</div>
                    <div class='dd'>
                        <div>전체 <input name='queText' type="text" placeholder="질문 키워드를 입력하세요."></div>
                        <ul id='question'>
                            <?php foreach ($data['queList'] as $val) : ?>
                                <li data-question-idx='<?= $val['idx'] ?>'>
                                    <input value="<?= $val['que_question'] ?>">
                                    <button>수정</button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div><input type="text" placeholder="추가할 질문을 입력해 주세요."><button type="text">추가하기</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    let flag = true;
    let categoryIdx = 0;
    $('#categoryBtn').on('click', function() {
        getAjax();
    });

    $(document).on('click', '#category > li', function() {
        $('#category > li').removeClass('on');
        $(this).addClass('on');
        categoryIdx = $(this).data('category-idx');
        readQuestion();
    });

    $('input[name="queText"]').on('keyup', function() {
        readQuestion();
    });

    function getAjax() {
        const emlCsrf = $("input[name='csrf_highbuff']");
        const emlText = $("input[name='categoryName']");
        if (flag && emlText.val()) {
            flag = false;
            $.ajax({
                url: `/api/question/category/create/1`,
                type: 'post',
                dataType: "json",
                cache: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                    'strCategoryName': emlText.val(),
                },
                success: function(res) {
                    if (res.code.stat || res.code.stat == 'success') {
                        flag = true;
                        emlCsrf.val(res.code.token);
                        categoryList(emlText.val());
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
        }
    }

    function readQuestion() {
        const emlCsrf = $("input[name='csrf_highbuff']");
        const emlText = $("input[name='queText']");
        if (flag) {
            flag = false;
            $.ajax({
                url: `/api/question/read/${categoryIdx}`,
                type: 'post',
                dataType: "json",
                cache: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                    'queText': emlText.val(),
                },
                success: function(res) {
                    $('#question').empty();
                    flag = true;
                    emlCsrf.val(res.code.token);
                    if (res.code.stat == 'success') {
                        const itemLeng = res.code.item.length;
                        const item = res.code.item;
                        for (let i = 0; i < itemLeng; i++) {
                            questionList(item[i]['que_question']);
                        }
                    }else{
                        questionList('없음');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
        }
    }

    function categoryList(text) {
        $('#category').append(`<li>${text}</li>`)
    }

    function questionList(text) {
        $('#question').append(`<li>${text}</li>`)
    }
</script>

<style>
    .dd {
        background: white;
        margin: 0.5rem 1rem;
    }

    .on {
        color: red;
    }
</style>