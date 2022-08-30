<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">맞춤법 확인</h3>
                <?= csrf_field() ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>검색 (<?= $data['count'] ?>)</th>
                        </tr>
                        <tr>
                            <td>
                                <form method="get" id="frm1" target="_self">
                                    <div><input type='text' name='keyword' value='<?= $data['keyword'] ?>' placeholder="질문 검색"><button type='submit'>검색</button></div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- /.card-body -->
            </div>

            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                        <col style='width:50%'>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th style='text-align:right;'>
                                <span class='key1'><i class="fas fa-circle"></i> 맞춤법</span>
                                <span class='key2'><i class="fas fa-circle"></i> 표준어 의심</span>
                            </th>
                            <th style='text-align:left;'>
                                <span class='key3'><i class="fas fa-circle"></i> 띄어쓰기</span>
                                <span class='key4'><i class="fas fa-circle"></i> 통계적 교정</span>
                            </th>
                        </tr>
                        <?php foreach ($data['queList'] as $row) : ?>
                            <tr>
                                <td class='text-center'>
                                    <?= $row['que_question'] ?>
                                </td>
                                <td class=''>
                                    <input class='hide' value='<?= $row['que_question'] ?>' style="width:80%">
                                    <span>
                                        <?php foreach ($row['que_spell_check'] as $key => $val) : ?>
                                            <span class='key<?= $val ?>'><?= $key ?></span>
                                        <?php endforeach; ?>
                                    </span>
                                    <button class='create' type='button'><i class="fas fa-edit"></i></button>
                                    <button class='update hide' type='submit' value='<?= $row['idx'] ?>'><i class="fas fa-pen"></i></button>
                                    <button class='delete hide' type='submit' value='<?= $row['idx'] ?>'><i class="fas fa-plus make-x"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $data['pager']->links('question', 'front_full') ?>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    let flag = true;
    const emlCsrf = $("input[name='csrf_highbuff']");
    $(document).on('click', '.create', function() {
        const thisEle = $(this);
        thisEle.siblings('input').toggle();
        thisEle.siblings('span').toggle();
        thisEle.siblings('.update').toggle();
        thisEle.siblings('.delete').toggle();
        thisEle.toggle();
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