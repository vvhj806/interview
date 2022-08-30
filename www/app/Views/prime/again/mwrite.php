<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">일반회원 재응시요청 관리 (<?= $data['againType'] ?>)</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/suggest/m/action/<?= $data['againType'] ?>/">
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
                                    <td>회원 아이디</td>
                                    <td>
                                        <?php if ($data['list']['mem_id'] ?? false) : ?>
                                            <?= $data['list']['mem_id'] ?? '' ?>
                                            <a href="/prime/member/write/m/<?= $data['list']['mem_idx'] ?? '' ?>">상세보기</a>
                                        <?php else : ?>
                                            없음
                                        <? endif; ?>
                                </tr>
                                <tr>
                                    <td>회원이름</td>
                                    <td>
                                        <?= $data['list']['mem_name'] ?? '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>회원 전화번호</td>
                                    <td>
                                        <?= $data['list']['mem_tel'] ?? '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>회사명</td>
                                    <td>
                                        <?= $data['list']['com_name'] ?? '' ?>
                                        <a href="/prime/company/write/<?= $data['list']['com_idx'] ?>">상세보기</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if ($data['againType'] === 'recruit') : ?>
                                            재응시요청 공고명
                                        <?php else : ?>
                                            재응시요청 제안명
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $data['list']['title'] ?? '' ?>
                                        <?php if ($data['againType'] === 'recruit') : ?>
                                            <a href="/prime/recruit/write/<?= $data['list']['rec_idx'] ?>">공고상세보기</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>재응시요청사유</td>
                                    <td>
                                        <?= $data['list']['ag_req_reason']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>재응시요청 확인여부</td>
                                    <td>
                                        <?= $data['list']['ag_req_com'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>재응시요청 수락여부</td>
                                    <td>
                                        <?php if ($data['list']['ag_req_com'] == 'Y' && $data['list']['ag_req_stat'] == 'Y') : ?>
                                            수락
                                        <?php elseif ($data['list']['ag_req_com'] == 'Y' && $data['list']['ag_req_stat'] == 'N') : ?>
                                            거절
                                        <?php else : ?>
                                            수락대기중
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>재응시 요청일</td>
                                    <td>
                                        <?= $data['list']['ag_req_reg_date'] ?? '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>인터뷰 영상</td>
                                    <td>
                                        <?php if ($data['list']['app_idx']) : ?>
                                            <a href="/prime/interview/view/detail/<?= $data['list']['app_idx'] ?>">인터뷰 자세히보기</a>
                                        <?php else : ?>
                                            인터뷰 영상이 존재하지 않습니다.
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" value="저장" class="btn btn-success float-right">
                    </form>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<!-- /.row -->