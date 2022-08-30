<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">상호 대화형 질문 관리</h3>
                <?= csrf_field() ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>상호 대화형 질문 (<?= $data['count'] ?>)</th>
                        </tr>
                        <tr>
                            <th>엑셀로 추가</th>
                        </tr>
                        <tr>
                            <td>
                                <form method="post" enctype="multipart/form-data" action="interactive/excel/action">
                                    <?= csrf_field() ?>
                                    <input type="file" name="upload_file">
                                    <button type='submit'>업로드</button>
                                </form>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <form method="get" id="frm1" target="_self">
                                    <div><input type='text' name='keyword' value='' placeholder="질문 검색"><button type='submit'>검색</button></div>
                                </form>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                <!-- /.card-body -->
            </div>

            <div class="card-body">
                <form method="post" id="frm" action="interactive/delete/action">
                    <?= csrf_field() ?>
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>

                        </colgroup>
                        <thead>
                            <tr>
                                <th class='text-center'><input id='allChk' type='checkbox'>전체 선택 (<button type='submit'>삭제하기</button>)</th>
                                <th class='text-center'>고유번호</th>
                                <th class=''>point_word</th>
                                <th class=''>negative_word</th>
                                <th class=''>question</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['interactiveList'] as $row) : ?>
                                <tr>
                                    <td class='text-center'>
                                        <input name='interativeIdx[]' type='checkbox' value='<?= $row['idx'] ?>'>
                                    </td>
                                    <td class='text-center'>
                                        <?= $row['idx'] ?>
                                    </td>
                                    <td class=''>
                                        <?= $row['point_word'] ?>
                                    </td>
                                    <td class=''>
                                        <?= $row['negative_word'] ?>
                                    </td>
                                    <td class=''>
                                        <?= $row['question'] ?>
                                    </td>
                                    <td class=''>
                                        <!-- <input class='hide' value='' style="width:80%">
                                    <span>

                                    </span>
                                    <button class='create' type='button'><i class="fas fa-edit"></i></button>
                                    <button class='update hide' type='submit' value=''><i class="fas fa-pen"></i></button>
                                    <button class='delete hide' type='submit' value=''><i class="fas fa-plus make-x"></i></button> -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
                <?= $data['pager']->links('interactive', 'front_full') ?>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    let flag = true;
    const emlCsrf = $("input[name='csrf_highbuff']");
    $('#allChk').on('change', function() {
        const boolChk = $(this).is(':checked');
        $('input[name="interativeIdx[]"]').prop('checked', boolChk);
    });

    $(document).on('click', '.update', function() {
        if (!confirm('정말로 변경 하시겠습니까?')) {
            return;
        }
        questionAjax('update', $(this));
    });

    $(document).on('click', '.delete', function() {
        const thisEle = $(this);
        thisEle.siblings('input').toggle();
        thisEle.siblings('span').toggle();
        thisEle.siblings('.update').toggle();
        thisEle.siblings('.create').toggle();
        thisEle.toggle();
        // if (!confirm('정말로 삭제 하시겠습니까?')) {
        //     return;
        // }
        // questionAjax('delete', $(this));
    });

    function questionAjax(crud, ele) {
        let ajaxUrl = `/api/question/${crud}/${ele.val()}`;
        let ajaxObjData = {
            '<?= csrf_token() ?>': emlCsrf.val()
        };

        if (crud == 'update') {
            ajaxObjData['queText'] = ele.siblings('input').val();
            ajaxObjData['queType'] = 'spell';
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
                    if (crud == 'update') {} else if (crud == 'delete') {}
                    alert(res.messages);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }
</script>

<style>
    .key1 {
        color: #ff5757;
    }

    .key2 {
        color: #b22af8;
    }

    .key3 {
        color: #02c73c;
    }

    .key4 {
        color: #2facea;
    }
</style>