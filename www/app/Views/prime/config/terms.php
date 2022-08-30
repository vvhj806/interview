<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">이용약관</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/config/terms/action">
                        <?= csrf_field() ?>
                        <input type="hidden" name="cfg_type" value="T">
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
                                            <input class="form-check-input" type="radio" name="cfg_useYN" id="inlineRadio1" value="Y" <?= $data['terms']['cfg_useYN'] == 'Y' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio1">사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cfg_useYN" id="inlineRadio2" value="N" <?= $data['terms']['cfg_useYN'] == 'N' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio2">미사용</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>내용</td>
                                    <td>
                                        <textarea name="cfg_content" class="form-control" rows="3" placeholder=""><?= $data['terms']['cfg_content'] ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="submit" value="저장" class="btn btn-success float-right">
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->