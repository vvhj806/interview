<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">기업 관리</h3>
                <div>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                        <col style="width:150px">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>검색어</th>
                            <td>
                                <form method="get" id="frm" action="/prime/company/list">
                                    <input name="searchText" type="text" value="<?= $data['searchText']?>" placeholder="아이디, 기업명, 연락처로 검색하세요.">
                                    <input type="submit" value="검색">
                                    <a href='write' class="btn btn-primary float-right">기업 등록</a>
                                    <!-- <span class="float-right">
                                        <input id='stat' name='stat' value='I' type='checkbox'> <label for='stat'></label>
                                    </span> -->
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="box">
                    <p>리스트</p>
                    <div class="row">
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                            </colgroup>
                            <thead>
                                <th class="text-center">ID</th>
                                <th class="text-center">기업명</th>
                                <th class="text-center">담당자 / ID</th>
                                <th class="text-center">이미지</th>
                                <th class="text-center">연락처</th>
                                <th class="text-center">진행 공고 / 전체 공고</th>
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
                                                <td class="text-center"><?= $row['comIdx'] ?></td>
                                                <td class="text-center"><a href='write/<?= $row['comIdx'] ?>'><?= $row['comName'] ?></a></td>
                                                <td class="text-center"><?= $row['memName'] ?> / <?= $row['memId'] ?></td>
                                                <td class="text-center"><img src="<?= $data['url']['media'] ?><?= $row['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></td>
                                                <td class="text-center"><?= $row['comTel'] ?></td>
                                                <td class="text-center"> <?= $row['ingCnt']  ?? 0 ?> / <?= $row['recCnt'] ?></td>
                                                <td class="text-center"><?= $row['regDate'] ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">기업이 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </form>
                            </tbody>
                        </table>
                    </div>
                    <?= $data['pager']->links('company', 'front_full') ?>
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

<style>
    td>img {
        width: 200px;
        height: 100%;
    }

    .text-center {
        vertical-align: middle !important;
    }
</style>