<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">지원자 회원정보</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/member/add/action">
                        <?= csrf_field() ?>
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                                <col style="background-color: #ccc;width: 150px">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>회원타입</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="M">
                                            <label class="form-check-label" for="inlineRadio1">지원자</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="C">
                                            <label class="form-check-label" for="inlineRadio2">기업</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>아이디</td>
                                    <td>
                                        <input type="text" name="id">
                                    </td>
                                </tr>
                                <tr>
                                    <td>패스워드</td>
                                    <td>
                                        <input type="password" name="password">
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