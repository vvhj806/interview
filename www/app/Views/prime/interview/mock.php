<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">모의 인터뷰 관리</h3>
                <?= csrf_field() ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>모의 인터뷰<?= $data['count'] ?></th>
                            <td></td>
                        </tr>
                        <tr>
                            <form id='frm1' method="get" target="_self">
                                <td>

                                    <input name="searchText" type="text" value="<?= $data['searchText'] ?>" placeholder="기업명, 직무명으로 검색하세요.">
                                    <button type='submit'>검색</button>

                                </td>
                                <td>
                                    <input id='orderApply' type='checkbox' name='orderApply' <?= $data['orderApply'] === 'on' ? 'checked' : '' ?>><label for='orderApply'>응시횟수 많은순</label>
                                    <a href='mock/write'><button type='button'>등록</button></a>
                                </td>
                            </form>
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
                <form method="post" id="frm2" action="interactive/delete/action">
                    <?= csrf_field() ?>
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>

                        </colgroup>
                        <thead>
                            <tr>
                                <th class='text-center'><input id='allChk' type='checkbox'></th>
                                <th class='text-center'>인터뷰 번호</th>
                                <th class='text-center'>기업명</th>
                                <th class='text-center'>규모</th>
                                <th class='text-center'>직무</th>
                                <th class='text-center'>지역</th>
                                <th class='text-center'>응시횟수</th>
                                <th class='text-center'>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['mockList'] as $row) : ?>
                                <tr>
                                    <td class='text-center'><input name='interIdx' type='checkbox' value='<?= $row['i_idx'] ?>'></td>
                                    <td class='text-center'><?= $row['i_idx'] ?></td>
                                    <td class='text-center'><a href='/prime/company/write/<?= $row['comIdx'] ?>'><?= $row['comName'] ?></a></td>
                                    <td class='text-center'><?= $row['comForm'] ?></td>
                                    <td class='text-center'><?= $row['job_depth_text'] ?></td>
                                    <td class='text-center'><?= $row['comAddress'] ?></td>
                                    <td class='text-center'><?= $row['applierCount'] ?></td>
                                    <td class='text-center'><?= $row['interRegDate'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>

                <?= $data['pager']->links('practiceList', 'front_full') ?>

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

    $('input[name="orderApply"]').on('change', function() {
        $('#frm1').submit();
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