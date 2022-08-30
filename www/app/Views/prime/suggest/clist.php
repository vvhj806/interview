<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">비즈회원 제안 관리</h3>
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
                                <th>검색 [결과수(<?= $data['suggestList'] ? $data['count'] : '0' ?>)]</th>
                                <td>
                                    <input name="searchText" type="text" value="<?= $data['searchText'] ?>" placeholder="제안번호, 회사이름, 공고제목으로 검색">
                                    <button type="submit">검색</button>
                                    <a href='write' class="btn btn-primary float-right">제안보내기</a>
                                </td>
                            </tr>
                            <tr>
                                <th>정렬</th>
                                <td>
                                    <select name='order'>
                                        <option value='sugIdx' <?= $data['order']['column'] === 'sugIdx' ? 'selected' : '' ?>>제안 번호</option>
                                        <option value='mem_id' <?= $data['order']['column'] === 'mem_id' ? 'selected' : '' ?>>아이디</option>
                                        <option value='mem_name' <?= $data['order']['column'] === 'mem_name' ? 'selected' : '' ?>>이름</option>
                                        <option value='mem_reg_date' <?= $data['order']['column'] === 'mem_reg_date' ? 'selected' : '' ?>>발송일</option>
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
                            <colgroup>
                                <!-- <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%"> -->
                            </colgroup>
                            <thead>
                                <th class="text-center">제안 번호</th>
                                <th class="text-center">회사</th>
                                <th class="text-center">공고</th>
                                <th class="text-center">제안 타입</th>
                                <th class="text-center">회원 제안 수</th>
                                <th class="text-center">비회원 제안 수</th>
                                <th class="text-center">제안 종료일</th>
                                <th class="text-center">수정</th>
                            </thead>
                            <tbody>
                                <?php if ($data['suggestList']) : ?>
                                    <?php foreach ($data['suggestList'] as $row) : ?>
                                        <tr>
                                            <td class="text-center"><a href='write/<?= $row['sugIdx'] ?>'><?= $row['sugIdx'] ?></a></td>
                                            <td class="text-center"><a href='/prime/company/write/<?= $row['comIdx'] ?>'><?= $row['comName'] ?></a></td>
                                            <td class="text-center"><?= $row['recIdx'] ?></td>
                                            <td class="text-center"><?= $row['sugType'] ?></td>
                                            <td class="text-center"><?= $row['conCnt'] ?></td>
                                            <td class="text-center"><?= $row['appCnt'] ?></td>
                                            <td class="text-center"><?= $row['sugEndDate'] ?></td>
                                            <td class="text-center"><a href='write/<?= $row['sugIdx'] ?>'>수정</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <td colspan="7" class="text-center">해당하는 지원자가 없습니다 다시 검색해 주세요.</td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $data['suggestList'] ? $data['pager']->links('suggest', 'front_full') : '' ?>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    $('input[name="userType"]').on('change', function() {
        $('#frm').submit();
    });
    $('select[name="order"]').on('change', function() {
        $('#frm').submit();
    });
    $('input[name="orderType"]').on('change', function() {
        $('#frm').submit();
    });
</script>