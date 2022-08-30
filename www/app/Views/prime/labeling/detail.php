<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">지원자 목록</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>

                    </colgroup>
                    <tbody>
                        <tr>
                            <th>
                                <?php if ($data['labeler']) : ?>
                                    <a href='/prime/labeling/score/<?= $data['list']['idx'] ?>'>채점하기</a>
                                <?php else : ?>
                                    <a href='javascript:alert("채점하기를 체크해 주세요.")'>채점하기</a>
                                <?php endif; ?>
                            </th>
                        </tr>
                        <tr>
                            <th><a href='/prime/interview/view/detail/<?= $data['list']['idx'] ?>'>인터뷰 정보 확인하기</a></th>
                        </tr>
                        <tr>
                            <th>내 아이디</th>
                            <td><?= $data['session']['id'] ?></td>
                        </tr>
                        <tr>
                            <th>채점한 라벨러 아이디</th>
                            <td><?= $data['labeler']['memId'] ?? '없음' ?></td>
                        </tr>
                        <?php if (!$data['labeler']) : ?>
                            <form method="post" id="frm" action="/prime/labeling/detail/action/<?= $data['list']['idx'] ?>">
                                <?= csrf_field() ?>
                                <tr>
                                    <th>채점하기</th>
                                    <td><input type='checkbox' name='lbStat' <?= $data['labeler'] ? 'checked' : '' ?>></td>
                                </tr>
                            </form>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="box">
                    <div class="row">
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>

                            </colgroup>
                            <thead>
                                <th class="text-center">사진</th>
                                <th class="text-center">USER ID</th>
                                <th class="text-center">직군/직무</th>
                                <th class="text-center">면접 시간 설정 값</th>
                                <th class="text-center">등록일</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $data['list']['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = ' <?= $data['url']['media'] ?>/data/no_img.png'">
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $data['list']['mem_id'] ?></td>
                                    <td class="text-center"><?= $data['list']['job_depth_text'] ?></td>
                                    <td class="text-center"><?= $data['list']['repo_answer_time'] ?? 30 ?>초</td>
                                    <td class="text-center"><?= $data['list']['app_reg_date'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    $('input[name="lbStat"]').on('change', function() {
        $('#frm').submit();
    });
</script>

<style>
    .imgBox {
        max-width: 300px;
    }

    img {
        width: 100%;
        height: 100%;
    }
</style>