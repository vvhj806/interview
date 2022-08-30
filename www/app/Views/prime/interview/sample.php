<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">샘플 인터뷰</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                        <col style="width:15%">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>정렬</th>
                            <td>
                                <form method="get" id="frm1" target="_self">
                                    <input id='orderCount' type='checkbox' name='orderCount' <?= $data['get'] === 'on' ? 'checked' : '' ?>><label for='orderCount'>조회수 높은 순</label>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <form method="post" id="frm2" action="/prime/interview/sample/action">
                                <?= csrf_field() ?>
                                <th>샘플 인터뷰 등록</th>
                                <td><input type='number' name='applierIdx' value='' placeholder="인터뷰 고유 번호" required><button type='submit'>등록</button></td>
                            </form>
                        </tr>
                    </tbody>
                </table>

                <form method="post" id="frm" action="">
                    <?= csrf_field() ?>
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>
                            <col class="wps_5">
                            <col class="wps_20">
                            <col class="wps_20">
                            <col class="wps_10">
                            <col class="wps_10">
                            <col class="wps_10">
                            <col class="wps_10">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class='text-center'>고유번호</th>
                                <th class='text-center'>이미지</th>
                                <th class='text-center'>점수</th>
                                <th class='text-center'>직무</th>
                                <th class='text-center'>조회수</th>
                                <th class='text-center'>등록일</th>
                                <th class='text-center'>자세히 보기</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['sampleList'] as $row) : ?>
                                <tr>
                                    <td class='text-center'><?= $row['idx'] ?></td>
                                    <td class='text-center'>
                                        <div class='img_box'><img src='<?= $data['url']['media'] ?><?= $row['file_save_name'] ?>' class="img"></div>
                                    </td>
                                    <td class='text-center'><?= $row['repo_analysis']['grade'] ?> / <?= $row['repo_analysis']['sum'] ?></td>
                                    <td class='text-center'><?= $row['job_depth_text'] ?></td>
                                    <td class='text-center'><?= $row['app_count'] ?></td>
                                    <td class='text-center'><?= $row['app_reg_date'] ?></td>
                                    <td class='text-center'><a href="/prime/interview/view/detail/<?= $row['idx'] ?>">보기</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>

                <?= $data['pager']->links('sample', 'front_full') ?>

                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<script>
    $('input[name="orderCount"]').on('change', function() {
        $('#frm1').submit();
    });
</script>
<style>
    .img_box {
        /* width: 20%; */
        height: 350px;
        /* display: inline-block; */
    }

    .img {
        object-fit: contain;
        width: 100%;
        height: 100%;
    }
</style>