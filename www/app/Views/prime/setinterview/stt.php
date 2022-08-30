<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">STT 사전 작업</h3>
                <?= csrf_field() ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                    <colgroup>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>검색 (<?= $data['count'] ?>)</th>
                        </tr>
                        <tr>
                            <td>
                                <form method="get" id="frm1" target="_self">
                                    <div><input type='text' name='keyword' value='<?= $data['keyword'] ?>' placeholder="검색"><button type='submit'>검색</button></div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <form method="post" id="frm2" action="stt/insert/action">
                                        <?= csrf_field() ?>
                                        <input type='text' name='phrase' placeholder="phrase">
                                        <button type='submit'>추가</button>
                                    </form>
                                    <!-- <form method="post" id="frm3">
                                        <button type='submit'>서버 업데이트</button>
                                    </form> -->
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <form method="get" id="frm1" target="_self">
                                    <div><input type='text' name='keyword' value='' placeholder="질문 검색"><button type='submit'>검색</button></div>
                                </form>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                <!-- /.card-body -->
            </div>

            <div class="card-body">
                <form method="post" id="frm" action="stt/delete/action">
                    <?= csrf_field() ?>
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>

                        </colgroup>
                        <thead>
                            <tr>
                                <th class='text-center'><input id='allChk' type='checkbox'>전체 선택 (<button type='submit'>삭제하기</button>)</th>
                                <th class='text-center'>고유번호</th>
                                <th class=''>phrase</th>
                                <th class=''>complete</th>
                                <th class=''>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['interactiveList'] as $row) : ?>
                                <tr>
                                    <td class='text-center'>
                                        <input name='phraseIdx[]' type='checkbox' value='<?= $row['idx'] ?>'>
                                    </td>
                                    <td class='text-center'>
                                        <?= $row['idx'] ?>
                                    </td>
                                    <td class=''>
                                        <?= $row['phrase'] ?>
                                    </td>
                                    <td class=''>
                                        <?= $row['complete'] ?>
                                    </td>
                                    <td class=''>
                                        <?= $row['datetime'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
                <?= $data['pager']->links('phrase', 'front_full') ?>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->