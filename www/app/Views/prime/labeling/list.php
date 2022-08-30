<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">지원자 목록 <span><?= $data['count'] ?>명</span></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                        <col style="width:10%">
                    </colgroup>
                    <tbody>
                        <tr>
                            <form method="get" id="frm1" target="_self">
                                <th>
                                    <select id="labeler_lists" name='lbIdx'>
                                        <option value=''>현재 작업중인 라벨러 확인</option>
                                        <?php foreach ($data['labeler'] as $row) : ?>
                                            <option value='<?= $row['memIdx'] ?>' <?= $data['labelIdx'] == $row['memIdx'] ? 'selected' : '' ?>><?= $row['memId'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </th>
                            </form>
                        </tr>
                        <tr>
                            <th>라벨러 아이디</th>
                            <td><?= $data['session']['id'] ?></td>
                        </tr>
                        <tr>
                            <form method="post" id="frm2" action="/prime/labeling/list/action">
                                <?= csrf_field() ?>
                                <th>라벨러 상태 [ON / OFF]</th>
                                <td><input type='checkbox' name='lbStat' <?= $data['stat'] ? 'checked' : '' ?>></td>
                            </form>
                        </tr>
                        <tr>
                            <form method="get" id="frm3" target="self">
                                <th>검색</th>
                                <td><input type='number' name='lbSearch' value='<?= $data['search'] ?>' placeholder="번호"><button type='submit'>검색</button></td>
                            </form>
                        </tr>
                    </tbody>
                </table>

                <div class="box">
                    <?= $data['pager']->links('applier', 'front_full') ?>
                    <div class="row">
                        <ul>
                            <?php if ($data['stat']) : ?>
                                <?php foreach ($data['list'] as $row) : ?>
                                    <li>
                                        <a href="detail/<?= $row['appIdx'] ?>">
                                            <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $row['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                        </a>
                                        <a href='detail/<?= $row['appIdx'] ?>'>
                                            <div></div>
                                            <?= $row['appIdx'] ?> / <?= $row['jobText'] ?>
                                            <div style='color : black;'><?= $row['memId'] ?></div>
                                            <div style='color : black;'><?= $row['appStat'] ?></div>
                                            <div style='color : black;'>STT 교정: <?= ($row['sttLog'] ?? false) ? $row['sttLog']['memId'] : '안됨' ?></div>
                                            <div><?= $row['appRegDate'] ?></div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?php foreach ($data['list'] as $row) : ?>
                                    <li>
                                        <a href='javascript:alert("라벨러 상태를 체크해 주세요.")'>
                                            <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $row['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                        </a>
                                        <a href='javascript:alert("라벨러 상태를 체크해 주세요.")'>
                                            <div></div>
                                            <?= $row['appIdx'] ?> / <?= $row['jobText'] ?>
                                            <div style='color : black;'><?= $row['memId'] ?></div>
                                            <div style='color : black;'><?= $row['appStat'] ?></div>
                                            <div><?= $row['appRegDate'] ?></div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?= $data['pager']->links('applier', 'front_full') ?>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    $('select[name="lbIdx"]').on('change', function() {
        $('#frm1').submit();
    });

    $('input[name="lbStat"]').on('change', function() {
        $('#frm2').submit();
    });
</script>
<style>
    .imgBox {
        height: 200px;
    }

    .imgBox>img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .box>.row>ul>li {
        border: 1px black solid;
        padding: 0.5rem;
    }

    @media screen and (max-width:480px) {
        .box>.row>ul {
            width: 100%;
        }

        .box>.row>ul>li {
            width: 100%;
        }

        .imgBox {
            height: 10vh;
        }

        .row {
            padding: 0.5rem;
            margin: 0px;
        }

        table {
            font-size: 0.5rem;
        }
    }
</style>