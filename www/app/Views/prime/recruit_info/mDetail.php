<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<form id="frm" method="post" action="">
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">지원 정보</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="box">
                        <input type="hidden" name="backUrl" value="/prime/company/write/" />
                        <input type="hidden" name="postCase" value="company_write" />
                        <?= csrf_field() ?>
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>지원 회사명</th>
                                    <td style="width: 40%;">
                                        <img src='<?= $data['url']['media'] ?><?= $data['info']['file_save_name'] ?? '/data/no_img.png' ?>' onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" style="width:40%;"><br><br>
                                        <div><?= $data['info']['com_name'] ?></div><br>
                                        <div><a href="/prime/company/write/<?= $data['info']['com_idx'] ?>">기업자세히보기</a></div>
                                    </td>
                                    <th>지원 공고명</th>
                                    <td>
                                        <?= $data['info']['rec_title'] ?><br><br>
                                        <div><a href="/prime/recruit/write/<?= $data['info']['rec_idx'] ?>">공고자세히보기</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>지원자 ID</th>
                                    <td>
                                        <?= $data['info']['mem_id'] ?>
                                    </td>
                                    <th>지원자 이름</th>
                                    <td>
                                        <?= $data['info']['mem_name'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>지원자 연락처</th>
                                    <td>
                                        <?= $data['info']['mem_tel'] ?>
                                    </td>
                                    <th>지원일</th>
                                    <td>
                                        <?= $data['info']['res_info_reg_date'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>인터뷰 지원 상태</th>
                                    <td>
                                        <?php if ($data['info']['app_type'] == "M") : ?>
                                            내인터뷰로 지원
                                        <?php elseif ($data['info']['app_type'] == "C") : ?>
                                            기업인터뷰로 지원
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>지원 첨부파일</th>
                                    <td>
                                        <?php foreach ($data['chumbuFile'] as $fileKey => $fileVal) : ?>
                                            <div>
                                                <div>첨부파일 <?= $fileKey + 1 ?></div>
                                                <div>
                                                    <a href="<?= $data['url']['media'] ?><?= $fileVal['file_save_name'] ?>" download="<?= $fileVal['file_org_name'] ?>"><?= $fileVal['file_org_name'] ?> 다운로드</a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>지원영상</th>
                                    <td>
                                        <a href=" /prime/interview/view/detail/<?= $data['info']['app_idx'] ?>">지원영상 보러가기</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>재응시요청여부</th>
                                    <td>
                                        <?php if ($data['info']['ag_req_com']) : ?>
                                            Y
                                        <?php else : ?>
                                            N
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($data['info']['ag_req_com']) : ?>
                                    <tr>
                                        <th>재응시요청사유</th>
                                        <td><?= $data['info']['ag_req_reason'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>재응시요확인여부</th>
                                        <td>
                                            <?= $data['info']['ag_req_com'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>재응시요청수락여부</th>
                                        <td>
                                            <?php if ($data['info']['ag_req_stat'] == 'Y' && $data['info']['ag_req_com'] == 'Y') : ?>
                                                재응시요청 수락
                                            <?php elseif ($data['info']['ag_req_stat'] == 'N' && $data['info']['ag_req_com'] == 'Y') : ?>
                                                재응시요청 거절
                                            <?php else : ?>
                                                <?php if ($data['info']['ag_req_com']) : ?>
                                                    재응시요청중
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>재응시요청일</th>
                                        <td><?= $data['info']['ag_req_reg_date'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->
</form>

<?php if (!$data['info']['ag_req_com']) : ?>
    <form action="/prime/suggest/m/again/action/recruit/<?= $data['recInfoIdx'] ?>" method="post">
        <?= csrf_field() ?>
        <input type="text" name="reason" placeholder="재응시요청사유">
        <button type="submit">재응시요청 보내기</button>
    </form>
<?php endif; ?>