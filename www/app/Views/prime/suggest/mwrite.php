<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">일반회원 제안 상세 <?= $data['userType'] ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/suggest/m/action/<?= $data['userType'] ?>/">
                        <input type="hidden" name="backUrl" value="/prime/member/write/" />
                        <input type="hidden" name="postCase" value="member_write" />
                        <?= csrf_field() ?>
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                                <col style="background-color: #ccc;width: 150px">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>제안 수정하기</td>
                                    <td>
                                        <a href='/prime/suggest/c/write/<?= $data['suggestList']['sugIdx'] ?>'>제안 수정하기</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안번호</td>
                                    <td>
                                        <?= $data['suggestList']['sugIdx'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안유형</td>
                                    <td>
                                        <?= $data['suggestList']['sugType'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>메세지</td>
                                    <td>
                                        <?= $data['suggestList']['msg'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>담당자 상태</td>
                                    <td>
                                        <?= $data['suggestList']['managerStat'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>담당자 이름</td>
                                    <td>
                                        <?= $data['suggestList']['managerName'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안 시작일</td>
                                    <td>
                                        <?= $data['suggestList']['sugStartDate'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안 종료일</td>
                                    <td>
                                        <?= $data['suggestList']['sugEndDate'] ?>
                                    </td>
                                </tr>
                                <?php if ($data['userType'] === 'user') : ?>
                                    <tr>
                                        <td>유저 정보 바로가기</td>
                                        <td>
                                            <a href='/prime/member/write/m/<?= $data['suggestList']['memIdx'] ?>'>바로가기</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>유저 상태값</td>
                                        <td>
                                            <select name='cfg_sug_mem_app_stat'>
                                                <option value='P' <?= $data['suggestList']['appStat'] === 'P' ? 'selected' : '' ?>>확인중</option>
                                                <option value='Y' <?= $data['suggestList']['appStat'] === 'Y' ? 'selected' : '' ?>>수락</option>
                                                <option value='N' <?= $data['suggestList']['appStat'] === 'N' ? 'selected' : '' ?>>거절</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>유저 상태값</td>
                                        <td>
                                            <select name='cfg_sug_mem_app_type'>
                                                <option value='A' <?= $data['suggestList']['appType'] === 'A' ? 'selected' : '' ?>>경력 불일치</option>
                                                <option value='B' <?= $data['suggestList']['appType'] === 'B' ? 'selected' : '' ?>>희망 지굼 불일치</option>
                                                <option value='C' <?= $data['suggestList']['appType'] === 'C' ? 'selected' : '' ?>>희망 업종 불일치</option>
                                                <option value='D' <?= $data['suggestList']['appType'] === 'D' ? 'selected' : '' ?>>희망 근무 조건 불일치</option>
                                                <option value='Z' <?= $data['suggestList']['appType'] === 'Z' ? 'selected' : '' ?>>기타</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>유저 메세지</td>
                                        <td>
                                            <input name='cfg_sug_mem_app_massage' value='<?= $data['suggestList']['appMsg'] ?>'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>면접 장소</td>
                                        <td>
                                            <input name='cfg_sug_address' value='<?= $data['suggestList']['address'] ?>'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>약속 날짜</td>
                                        <td>
                                            <input name='cfg_sug_promise_date' value='<?= $data['suggestList']['promiseDate'] ?>'>
                                        </td>
                                    </tr>

                                <?php elseif ($data['userType'] === 'notUser') : ?>
                                    <tr>
                                        <td>인터뷰 제목</td>
                                        <td>
                                            <input name='sug_app_title' value='<?= $data['suggestList']['appTitle'] ?>'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>인터뷰 보러가기</td>
                                        <td>
                                            <a href='/prime/interview/view/detail/<?= $data['suggestList']['appIdx'] ?>'>인터뷰 보러 가기</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>유저 이름</td>
                                        <td>
                                            <input name='sug_app_name' value='<?= $data['suggestList']['memName'] ?>'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>유저 번호</td>
                                        <td>
                                            <input name='sug_app_phone' value='<?= $data['suggestList']['memTel'] ?>'>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>재응시요청 확인여부</td>
                                    <td>
                                        <?php if ($data['suggestList']['ag_req_com'] == 'Y') : ?>
                                            요청 확인함
                                        <?php elseif ($data['suggestList']['ag_req_com'] == 'N') : ?>
                                            요청 확인전
                                        <?php else : ?>
                                            재응시요청 안함
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($data['suggestList']['ag_req_com']) : ?>
                                    <tr>
                                        <td>재응시요청 수락여부</td>
                                        <td>
                                            <?php if ($data['suggestList']['ag_req_com'] == 'Y' && $data['suggestList']['ag_req_stat'] == 'Y') : ?>
                                                재응시요청 수락
                                            <?php elseif ($data['suggestList']['ag_req_com'] == 'Y' && $data['suggestList']['ag_req_stat'] == 'N') : ?>
                                                재응시요청 거절
                                            <?php else : ?>
                                                재응시요청중
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>재응시요청 사유</td>
                                        <td>
                                            <?= $data['suggestList']['ag_req_reason'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>재응시요청일</td>
                                        <td><?= $data['suggestList']['ag_req_reg_date'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <input type="submit" value="저장" class="btn btn-success float-right">
                    </form>

                    <?php if (!$data['suggestList']['ag_req_com']) : ?>
                        <form action="/prime/suggest/m/again/action/<?= $data['userType'] ?>/<?= $data['suggestIdx'] ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="text" name="reason" placeholder="재응시요청사유">
                            <button type="submit">재응시요청 보내기</button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<!-- /.row -->