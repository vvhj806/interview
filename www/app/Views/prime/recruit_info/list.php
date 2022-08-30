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
                                    <?php if ($data['state'] == 'm') : ?>
                                        검색어 [회원 ID / 이름 / 연락처]
                                    <?php elseif ($data['state'] == 'c') : ?>
                                        검색어 [회사명/지원공고명]
                                    <?php endif; ?>
                                </th>
                                <td>
                                    <input name="searchText" type="text" value="<?= $data['search'] ?>">
                                    <input type="submit" value="검색">

                                    <?php if ($data['state'] == 'm') : ?>
                                        <label><input type='radio' name='againType' value='noAgain' <?= $data['againType'] === 'noAgain' ? 'checked' : '' ?>>재응시요청 없음</label>
                                        <label><input type='radio' name='againType' value='again' <?= $data['againType'] === 'again' ? 'checked' : '' ?>>재응시 요청</label>
                                    <?php endif; ?>
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
                                <th class="text-center">REC_INFO_IDX</th>
                                <th class="text-center">ID</th>
                                <th class="text-center">이름</th>
                                <th class="text-center">연락처</th>
                                <th class="text-center">지원 회사명</th>
                                <th class="text-center">지원 공고명</th>
                                <th class="text-center">지원상태</th>
                                <th class="text-center">등록일</th>
                                <th class="text-center">재응시요청여부</th>
                                <th class="text-center">재응시요확인여부</th>
                                <th class="text-center">재응시요청수락여부</th>
                                <th class="text-center">보기</th>
                            </thead>
                            <tbody style="font-size: 90%;">
                                <?php foreach ($data['list'] as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['rec_info_idx'] ?></td>
                                        <td class="text-center"><?= $row['mem_id'] ?></td>
                                        <td class="text-center"><?= $row['mem_name'] ?></td>
                                        <td class="text-center"><?= $row['mem_tel'] ?></td>
                                        <td class="text-center"><?= $row['com_name'] ?></td>
                                        <td class="text-center"><?= $row['rec_title'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['app_type'] == "M") : ?>
                                                내인터뷰
                                            <?php elseif ($row['app_type'] == "C") : ?>
                                                기업인터뷰
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= $row['res_info_reg_date'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['ag_req_com']) : ?>
                                                Y
                                            <?php else : ?>
                                                N
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $row['ag_req_com'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['ag_req_stat'] == 'Y' && $row['ag_req_com'] == 'Y') : ?>
                                                재응시요청 수락
                                            <?php elseif ($row['ag_req_stat'] == 'N' && $row['ag_req_com'] == 'Y') : ?>
                                                재응시요청 거절
                                            <?php else : ?>
                                                <?php if ($row['ag_req_com']) : ?>
                                                    재응시요청중
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center"><a href="/prime/recruit_info/detail/<?= $data['state'] ?>/<?= $row['rec_info_idx'] ?>">보기</a></td>
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