<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">공고 관리</h3>
                <div>
                    <span>총 <?= $data['recStat']['total'] ?>개</span>
                    <span>진행중: <?= $data['recStat']['ing'] ?>개</span>
                    <span>승인 대기중: <?= $data['recStat']['wait'] ?>개</span>
                    <span>승인거부: <?= $data['recStat']['no'] ?>개</span>
                    <span>마감: <?= $data['recStat']['end'] ?>개</span>
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
                                <th>검색어 [갯수(<?= $data['count'] ?>)]</th>
                                <td>
                                    <input name="searchText" type="text" value="<?= $data['searchText'] ?>">
                                    <input type="submit" value="검색">
                                    <button id='accept_btn' type='button' class="btn btn-primary">(<span>0</span>)개 승인하기</button>
                                    <a href='write' class="btn btn-primary float-right">공고 등록</a>
                                    <span class="float-right">
                                        <input id='stat' name='stat' value='I' type='checkbox' <?= $data['stat'] === 'I' ? 'checked' : '' ?>> <label for='stat'>승인 대기 공고만 보기</label>
                                    </span>
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
                                <th class="text-center"><input id='chk_box' type='checkbox'></th>
                                <th class="text-center">ID</th>
                                <th class="text-center">기업명</th>
                                <th class="text-center">공고명</th>
                                <th class="text-center">직군/직무</th>
                                <th class="text-center">지역</th>
                                <th class="text-center">인터뷰분류</th>
                                <th class="text-center">접수 마감일</th>
                                <th class="text-center">상태</th>
                                <th class="text-center">조회수</th>
                                <th class="text-center">지원자 수</th>
                                <th class="text-center">등록일</th>
                            </thead>
                            <tbody>
                                <form method="post" id="frm2" action="/prime/recruit/accept">
                                    <?= csrf_field() ?>
                                    <?php
                                    if (count($data['list'])) :
                                        foreach ($data['list'] as $row) :
                                    ?>
                                            <tr>
                                                <td class="text-center"><input type='checkbox' name='recIdx[]' value='<?= $row['recIdx'] ?>'></td>
                                                <td class="text-center"><?= $row['recIdx'] ?></td>
                                                <td class="text-center"><?= $row['comName'] ?></td>
                                                <td class="text-center"><a href='write/<?= $row['recIdx'] ?>'><?= $row['recTitle'] ?></a></td>
                                                <td class="text-center"><?= $row['job_depth_text'] ?></td>
                                                <td class="text-center"><?= $row['area_depth_text_1'] . $row['area_depth_text_2'] ?></td>
                                                <td class="text-center"><?= $row['recApply'] ?></td>
                                                <td class="text-center"><?= $row['recEndDate'] ?></td>
                                                <td class="text-center"><?= $row['recStat'] ?></td>
                                                <td class="text-center"><?= $row['recHit'] ?></td>
                                                <td class="text-center"><?= $row['recCnt'] ?></td>
                                                <td class="text-center"><?= $row['recRegDate'] ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">공고가 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </form>
                            </tbody>
                        </table>
                    </div>
                    <?= $data['pager']->links('recruit', 'front_full') ?>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    let checkedLength = 0;
    $('input[name="stat"]').on('change', function() {
        $('#frm').submit();
    })

    $('#chk_box').on('change', function() {
        const boolChecked = $(this).is(':checked');
        $('input[name="recIdx[]"]').prop('checked', boolChecked).trigger('change');
    })

    $('input[name="recIdx[]"]').on('change', function() {
        checkedLength = $('input[name="recIdx[]"]:checked').length;
        $('#accept_btn > span').text(checkedLength);
    });

    $('#accept_btn').on('click', function() {
        if (!checkedLength) {
            alert('한개 이상');
            return false;
        }
        $('#frm2').submit();
    });

    function statChk() {

    }
</script>