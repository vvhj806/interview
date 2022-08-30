<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">공고 관리</h3>
                <div>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="get" id="frm" target="_self">
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>
                            <col style="width:150px">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>
                                    검색어 [회사명/지원공고명]
                                </th>
                                <td>
                                    <input name="searchText" type="text" value="<?= $data['search'] ?>">
                                    <input type="submit" value="검색">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <div class="box">
                    <!-- <p>rec_info_idx</p> -->
                    <div class="row">
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>

                            </colgroup>
                            <thead>
                                <th class="text-center">REC_IDX</th>
                                <th class="text-center">회사명</th>
                                <th class="text-center">공고명</th>
                                <th class="text-center">등록일</th>
                                <th class="text-center">보기</th>
                            </thead>
                            <tbody style="font-size: 90%;">
                                <?php foreach ($data['list'] as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['rec_idx'] ?></td>
                                        <td class="text-center"><?= $row['com_name'] ?></td>
                                        <td class="text-center"><?= $row['rec_title'] ?></td>
                                        <td class="text-center"><?= $row['rec_reg_date'] ?></td>
                                        <td class="text-center"><a href="/prime/recruit_info/c/detail/<?= $row['rec_idx'] ?>">보기</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $data['pager']->links('recruitInfo', 'front_full') ?>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    $('input[name="againType"]').on('change', function() {
        $('#frm').submit();
    });
</script>