<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">비즈 질문 관리</h3>
                <?= csrf_field() ?>
            </div>
            <!-- /.card-header -->
            <form method="post" id="frm" action="/prime/question">
                <div class="card-body">
                    <?= csrf_field() ?>
                    <div>카테고리 추가
                        <div>현재 선택된 depth1 [<span id='depth1'></span>]</div>
                        <div><input placeholder="카테고리 추가"><button type='button' class='category_add_btn' value="1">추가</button></div>
                        <ul id='depth1'>
                            <?php if (isset($data['category']['job_depth_1'])) : ?>
                                <?php foreach ($data['category']['job_depth_1'] as $depth1 => $row) : ?>
                                    <?php foreach ($row as $val) : ?>
                                        <li>
                                            <input value='<?= $val['jobName'] ?>' class='hide'>
                                            <button type='button' class='depth_btn depth1_btn' value='<?= $val['idx'] ?>' data-depth1='<?= $depth1 ?>'>
                                                <?= $val['jobName'] ?>
                                            </button>
                                            <button type='button' class='cate_update_btn' value='<?= $val['idx'] ?>'><i class="fas fa-edit"></i></button>
                                            <?php if ($val['delyn'] === 'N') : ?>
                                                <button type='button' class='cate_delete_btn' value='<?= $val['idx'] ?>'><i class="fas fa-plus make-x"></i></button>
                                            <?php elseif ($val['delyn'] === 'Y') : ?>
                                                <button type='button' class='update_active' value='<?= $val['idx'] ?>'><i class="fas fa-plus"></i></button>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </ul>
                    </div>

                    <div>카테고리 추가
                        <div>현재 선택된 depth2 [<span id='depth2'></span>]</div>
                        <div><input placeholder="카테고리 추가"><button type='button' class='category_add_btn' value="2">추가</button></div>
                        <?php if (isset($data['category']['job_depth_2'])) : ?>
                            <?php foreach ($data['category']['job_depth_2'] as $depth1 => $row) : ?>
                                <ul id='depth1-<?= $depth1 ?>' class='depth2 '>
                                    <?php foreach ($row as $depth2 => $val) : ?>
                                        <li>
                                            <input value='<?= $val['jobName'] ?>' class='hide'>
                                            <button type='button' class='depth_btn depth2_btn' value='<?= $val['idx'] ?>' data-depth2='<?= $depth2 ?>'>
                                                <?= $val['jobName'] ?>
                                            </button>
                                            <button type='button' class='cate_update_btn' value='<?= $val['idx'] ?>'><i class="fas fa-edit"></i></button>
                                            <?php if ($val['delyn'] === 'N') : ?>
                                                <button type='button' class='cate_delete_btn' value='<?= $val['idx'] ?>'><i class="fas fa-plus make-x"></i></button>
                                            <?php elseif ($val['delyn'] === 'Y') : ?>
                                                <button type='button' class='update_active' value='<?= $val['idx'] ?>'><i class="fas fa-plus"></i></button>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>

                    <div>카테고리 추가
                        <div>현재 선택된 depth3 [<span id='depth3'></span>]</div>
                        <div><input placeholder="카테고리 추가"><button type='button' class='category_add_btn' value="3">추가</button></div>
                        <?php if (isset($data['category']['job_depth_3'])) : ?>

                            <?php foreach ($data['category']['job_depth_3'] as $depth1 => $row1) : ?>

                                <?php foreach ($row1 as $depth2 => $row) : ?>

                                    <ul id='depth1-<?= $depth1 ?>-depth2-<?= $depth2 ?>' class='depth3'>
                                        <?php foreach ($row as $depth3 => $val) : ?>
                                            <li>
                                                <input value='<?= $val['jobName'] ?>' class='hide'>
                                                <button type='button' class='depth_btn depth3_btn' value='<?= $val['idx'] ?>' data-depth3='<?= $depth3 ?>'>
                                                    <?= $val['jobName'] ?>
                                                </button>
                                                <button type='button' class='cate_update_btn' value='<?= $val['idx'] ?>'><i class="fas fa-edit"></i></button>
                                                <?php if ($val['delyn'] === 'N') : ?>
                                                    <button type='button' class='cate_delete_btn' value='<?= $val['idx'] ?>'><i class="fas fa-plus make-x"></i></button>
                                                <?php elseif ($val['delyn'] === 'Y') : ?>
                                                    <button type='button' class='update_active' value='<?= $val['idx'] ?>'><i class="fas fa-plus"></i></button>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>

                                <?php endforeach; ?>

                            <?php endforeach; ?>

                        <?php endif ?>
                    </div>

                    <div>
                        <div>질문</div>
                        <div class='dd'>
                            <div>
                                <span class='now_category'></span>
                            </div>
                            <div>질문 / 질문 모범답안 / 질문유형 / 수정 / 삭제</div>
                            <ul id='question'>

                            </ul>
                            <div>
                                <span class='now_category'></span>
                                <input id='que_text' type="text" placeholder="추가할 질문을 입력해 주세요.">
                                <input id='que_best_answer' type="text" placeholder="모범 답안을 입력해 주세요.">
                                <button id='add_que' type="button">추가하기</button>
                                <select id='que_type'>
                                    <option value='C'>공통 질문</option>
                                    <option value='J'>직무 질문</option>
                                    <option value='G'>일반적인 질문</option>
                                    <option value='A'>모의인터뷰 질문</option>
                                </select>
                                <select id='lang_type'>
                                    <option value='kor'>한국어</option>
                                    <option value='eng'>영어</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.row -->


<script>
    const emlCsrf = $("input[name='csrf_highbuff']");
    let flag = true;
    let categoryIdx = 0;
    let objQuestion = {};
    let nowDpeth1 = null;
    let nowDpeth2 = null;
    let nowDpeth3 = null;

    $(document).ready(function() {
        depthChk();
    });

    //category start
    $('.category_add_btn').on('click', function() {
        const thisBtnDepth = $(this).val();
        const categoryName = $(this).prev('input').val();

        if (!categoryName) {
            alert('카테고리 이름을 입력해 주세요.');
            return
        }

        if (thisBtnDepth == 1) {
            categoryAjax('create', 'depth1', categoryName);
        } else if (thisBtnDepth == 2) {
            if (!nowDpeth1) {
                alert('depth 1을 선택해 주세요');
                return
            }

            categoryAjax('create', 'depth2', categoryName);
        } else if (thisBtnDepth == 3) {
            if (!nowDpeth1) {
                alert('depth 1을 선택해 주세요');
                return
            }
            if (!nowDpeth2) {
                alert('depth 2를 선택해 주세요');
                return
            }
            categoryAjax('create', 'depth3', categoryName);
        }
    });

    $('.depth1_btn').on('click', function() {
        nowDpeth1 = $(this).data('depth1');
        nowDpeth2 = null;
        nowDpeth3 = null;
        depthChk();
    });

    $('.depth2_btn').on('click', function() {
        nowDpeth2 = $(this).data('depth2');
        nowDpeth3 = null;
        depthChk();
    });

    $('.depth3_btn').on('click', function() {
        nowDpeth3 = $(this).data('depth3');
        depthChk();
        getQuestion($(this).val(), $(this).text());
    });

    $(document).on('click', '.cate_update_btn', function() {
        $(this).children('i').toggleClass('fa-edit');
        $(this).children('i').toggleClass('fa-pen');

        $(this).toggleClass('update_active');
        $(this).siblings('input').toggle('hide');
    });

    $(document).on('click', '.update_active', function() {
        categoryIdx = $(this).val();
        categoryAjax('update', $(this).siblings('input').val(), $(this));
    });

    $(document).on('click', '.cate_delete_btn', function() {
        categoryIdx = $(this).val();
        categoryAjax('delete');
    });
    //category end

    //que start
    $(document).on('click', '.que_update_btn', function() {
        questionAjax('update', $(this));
    });

    $(document).on('click', '.que_delete_btn', function() {
        questionAjax('delete', $(this));
    });

    $('#add_que').on('click', function() {
        if (categoryIdx) {
            questionAjax('create');
        } else {
            alert('3depth를 선택해 주세요.')
        }
    });
    //que end

    function depthChk() {
        $('.depth2').addClass('hide');
        $('.depth3').addClass('hide');
        $(`#depth1-${nowDpeth1}`).removeClass('hide');
        $(`#depth1-${nowDpeth1}-depth2-${nowDpeth2}`).removeClass('hide');
        $('#depth1').text(nowDpeth1);
        $('#depth2').text(nowDpeth2);
        $('#depth3').text(nowDpeth3);
    }

    function getQuestion(jobIdx, jobName) {
        $('.now_category').text(jobName);
        categoryIdx = jobIdx;
        if (!objQuestion[jobIdx]) {
            questionAjax('read');
        }

        apeendQuestion(jobIdx);
    }

    function apeendQuestion(jobIdx) {
        $('#question').empty();

        if (objQuestion[jobIdx]) {
            for (var key in objQuestion[jobIdx]) {
                $('#question').append(`
                <li>
                    ${key}
                    <input class='que_question'value='${objQuestion[jobIdx][key]['que_question']}'>

                    <input class='que_best_answer' value='${objQuestion[jobIdx][key]['que_best_answer']}'>

                    <select>
                        <option value="other" selected>그 외</option>
                        <option value="C" ${objQuestion[jobIdx][key]['que_type'] == 'C' ? 'selected' : ''}>공통 질문</option>
                        <option value="J" ${objQuestion[jobIdx][key]['que_type'] == 'J' ? 'selected' : ''}>직무 질문</option>
                        <option value="G" ${objQuestion[jobIdx][key]['que_type'] == 'G' ? 'selected' : ''}>일반적인 질문</option>
                        <option value="A" ${objQuestion[jobIdx][key]['que_type'] == 'A' ? 'selected' : ''}>모의인터뷰 질문</option>
                    </select>
                    <button type='button' class='que_update_btn' value="${key}"><i class="fas fa-pen"></i></button>
                    <button type='button' class='que_delete_btn' value="${key}"><i class="fas fa-plus make-x"></i></button>
                </li>`)
            }
        } else {
            $('#question').append(`<li>질문 없음</li>`);
        }
    }

    function categoryAjax(crud, exParam1 = null, exParam2 = null) {
        let ajaxUrl = `/api/category/${crud}/${categoryIdx}`;
        let ajaxObjData = {
            '<?= csrf_token() ?>': emlCsrf.val()
        };
        if (crud == 'create') {
            if (!confirm('정말로 추가 하시겠습니까?')) {
                return;
            }

            ajaxUrl = `/api/category/${crud}/${exParam1}`;

            ajaxObjData['jobText'] = exParam2;
            ajaxObjData['depth1'] = nowDpeth1;
            ajaxObjData['depth2'] = nowDpeth2;
        } else if (crud == 'update') {
            if (!confirm('정말로 변경 하시겠습니까? 변경시 자동으로 open상태가 됩니다.')) {
                return;
            }
            ajaxObjData['jobText'] = exParam1;
        } else if (crud == 'delete') {
            if (!confirm('정말로 close 하시겠습니까? \n*하위 카테고리, 질문까지 전부 close상태가 됩니다.')) {
                return;
            }
        }
        if (flag) {
            flag = false;
            $.ajax({
                url: ajaxUrl,
                type: 'post',
                dataType: "json",
                cache: false,
                async: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: ajaxObjData,
                success: function(res) {
                    flag = true;
                    emlCsrf.val(res.code.token);

                    if (crud == 'create') {

                    } else if (crud == 'update') {
                        // exParam2.addClass('make-x');
                    } else if (crud == 'delete') {}
                    alert(res.messages);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    }

    function questionAjax(crud, exParam1) {
        let queIdx = 0;
        let queText = '';
        let queType = '';

        let ajaxUrl = `/api/question/${crud}/${categoryIdx}`;
        let ajaxObjData = {
            '<?= csrf_token() ?>': emlCsrf.val()
        };
        if (crud == 'create') {
            const queType = $('#que_type').val();
            const langType = $('#lang_type').val();
            const queText = $('#que_text').val();
            const queBestAnswer = $('#que_best_answer').val();

            ajaxObjData['queText'] = queText;
            ajaxObjData['queBestAnswer'] = queBestAnswer;
            ajaxObjData['queType'] = queType;
            ajaxObjData['langType'] = langType;
        } else if (crud == 'read') {
            const emlText = $("input[name='queText']");

            ajaxObjData['queText'] = emlText.val();
        } else if (crud == 'update') {
            queIdx = exParam1.val();
            queText = exParam1.siblings('.que_question').val();
            queBestAnswer = exParam1.siblings('.que_best_answer').val();
            queType = exParam1.siblings('select').val();

            ajaxUrl = `/api/question/${crud}/${queIdx}`;

            ajaxObjData['queText'] = queText;
            ajaxObjData['queBestAnswer'] = queBestAnswer;
            ajaxObjData['queType'] = queType;
        } else if (crud == 'delete') {
            queIdx = exParam1.val();

            ajaxUrl = `/api/question/${crud}/${exParam1.val()}`;
        }

        if (flag) {
            flag = false;
            $.ajax({
                url: ajaxUrl,
                type: 'post',
                dataType: "json",
                cache: false,
                async: false,
                beforeSend: '',
                complete: '',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: ajaxObjData,
                success: function(res) {
                    flag = true;
                    emlCsrf.val(res.code.token);

                    if (crud == 'create') {
                        if (res.code.stat == 'success') {
                            objQuestion[categoryIdx][res.code.idx] = res.code.item;
                            apeendQuestion(categoryIdx);
                        }
                    } else if (crud == 'read') {
                        if (res.code.stat == 'success') {
                            objQuestion[categoryIdx] = res.code.item;
                        } else {
                            objQuestion[categoryIdx] = [];
                        }
                        return;
                    } else if (crud == 'update') {
                        objQuestion[categoryIdx][queIdx] = {
                            'que_question': queText,
                            'que_best_answer': queBestAnswer,
                            'que_type': queType
                        }
                        apeendQuestion(categoryIdx);
                    } else if (crud == 'delete') {
                        delete objQuestion[categoryIdx][queIdx];
                        apeendQuestion(categoryIdx);
                    }
                    alert(res.messages);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    }
</script>

<style>
    .now_category {
        color: red;
        font-weight: bold;
        font-size: 1rem;
    }

    .card-body {
        display: flex;
        height: 70vh;
    }

    .card-body>div {
        height: 100%;
    }

    .dd {
        background: white;
        margin: 0.5rem 1rem;
        max-height: 80%;
    }

    .que_table {
        display: block;
    }

    .que_table tr>* {
        border: 1px black solid;
    }

    .que_table>thead {
        display: block;
    }

    .que_table>tbody {
        max-height: 50vh;
        overflow-y: auto;
        display: block;
    }

    .on {
        color: red;
    }
</style>