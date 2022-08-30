<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<?php
print_r($data['list']);
?>

<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">비즈회원 재응시요청 관리</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/suggest/m/action//">
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
                                    <td>기업명</td>
                                    <td>
                                        <?= $data['comName'] ?>
                                        <a href="/prime/company/write/<?= $data['comIdx'] ?>">자세히보기</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class='text-center'>재응시요청 회원이름</th>
                                    <th class='text-center'>공고명 / 제안명</th>
                                    <th class='text-center'>재응시요청상태</th>
                                    <th class='text-center'>재응시 날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['list'] as $val) : ?>
                                    <tr>
                                        <th class='text-center'>재응시요청 회원이름</th>
                                        <th class='text-center'>공고명 / 제안명</th>
                                        <th class='text-center'>재응시요청상태</th>
                                        <th class='text-center'>재응시 날짜</th>
                                    </tr>
                                <?php endforeach; ?>
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