<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">일반회원 재응시요청 관리</h3>
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
                                <th>검색 [결과수(<? //= $data['list'] ? $data['count'] : '0' 
                                            ?>)]</th>
                                <td>
                                    <input name="searchText" type="text" value="<?= $data['searchText'] ?>" placeholder="회원 번호, ID, 전화번호, 이름으로 검색">
                                    <button type="submit">검색</button>
                                    <label><input type='radio' name='againType' value='recruit' <?= $data['againType'] === 'recruit' ? 'checked' : '' ?>>공고 재응시</label>
                                    <label><input type='radio' name='againType' value='biz' <?= $data['againType'] === 'biz' ? 'checked' : '' ?>>비즈 재응시</label>
                                    <a href='write' class="btn btn-primary float-right"></a>
                                </td>
                            </tr>
                            <tr>
                                <th>정렬</th>
                                <td>
                                    <select name='order'>
                                        <option value='ag_req_idx' <?= $data['order']['column'] === 'ag_req_idx' ? 'selected' : '' ?>>순번</option>
                                        <option value='mem_name' <?= $data['order']['column'] === 'mem_name' ? 'selected' : '' ?>>이름</option>
                                    </select>
                                    <label>오름차순<input type='radio' name='orderType' value='ASC' <?= $data['order']['type'] === 'ASC' ? 'checked' : '' ?>></label>
                                    <label>내림차순<input type='radio' name='orderType' value='DESC' <?= $data['order']['type'] === 'DESC' ? 'checked' : '' ?>></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <div class="box">
                    <p>리스트</p>
                    <div class="row">
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <thead>
                                <th class="text-center">회사명</th>
                                <th class="text-center">보기/수정</th>
                            </thead>
                            <tbody>
                                <?php if ($data['list']) : ?>
                                    <?php foreach ($data['list'] as $row) : ?>

                                        <tr>
                                            <td class="text-center"><?= $row['com_name'] ?? '' ?></td>
                                            <td class="text-center"><a href="/prime/again/c/write/<?=$row['com_idx']?>">보기</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <td colspan="7" class="text-center">검색결과가 없습니다 다시 검색해 주세요.</td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $data['pager']->links('again', 'front_full') ?>
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
    $('select[name="order"]').on('change', function() {
        $('#frm').submit();
    });
    $('input[name="orderType"]').on('change', function() {
        $('#frm').submit();
    });
</script>