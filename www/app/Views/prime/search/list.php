<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">추천 검색어</h3> 
                <span>   총 <?= $data['count'] ?>개</span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>새 추천 검색어 등록</th>
                        </tr>
                        <tr>
                            <td>
                                <form method="post" id="frm1" action="write">
                                    <?= csrf_field() ?>
                                    <div><input type='text' name='keyword' placeholder="추천 검색어"><button type='submit'>등록하기</button></div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="box">
                    <div class="row" style='display:block'>
                        <form method="post" id="frm1">
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>
                                    <col style="width: 20%">
                                    <col style="width: 60%">
                                    <col style="width: 20%">
                                </colgroup>
                                <thead>
                                    <th class="text-center">순서</th>
                                    <th class="text-center">검색어</th>
                                    <th class="text-center">삭제</th>
                                </thead>
                                <tbody id='sortable'>
                                    <button id='save_btn' class='hide' type='submit' formaction="update">변경</button>
                                    <?= csrf_field() ?>
                                    <?php foreach ($data['list'] as $val) : ?>
                                        <tr>
                                            <td class="text-center index">
                                                <input readonly name='index[]' value='<?= $val['order_index'] ?>'>
                                                <input type='hidden' name='update_idx[]' value='<?= $val['idx'] ?>'>
                                            </td>
                                            <td class="text-center"><?= $val['text'] ?></td>
                                            <td class="text-center"><button type='submit' name='idx' value='<?= $val['idx'] ?>' formaction="delete">삭제하기</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    $(document).ready(function() {
        $("#sortable").sortable({
            placeholder: "itemBoxHighlight",
            stop: function(event, ui) {
                $('#save_btn').show();
                $('#sortable').find('.index').children('input[name="index[]"]').each(function(i) {
                    $(this).val(i + 1);
                });
            }
        });
        $("#sortable").disableSelection();
    });
</script>