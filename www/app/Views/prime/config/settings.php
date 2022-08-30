<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">개인정보처리방침</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/config/settings/action">
                        <?= csrf_field() ?>
                        <input type="hidden" name="postCase" value="config_wrtie">
                        <input type="hidden" name="idx" value="<?= $data['agreement']['idx'] ?>">
                        <input type="hidden" name="cfgType" value="A">
                        <input type="hidden" name="backUrl" value="/prime/config/settings">
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
                                            <input class="form-check-input" type="radio" name="cfgUseYN" id="inlineRadio1" value="Y" <?= $data['agreement']['cfg_useYN'] == 'Y' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio1">사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cfgUseYN" id="inlineRadio2" value="N" <?= $data['agreement']['cfg_useYN'] == 'N' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio2">미사용</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>내용</td>
                                    <td>
                                        <textarea name="cfgContent" class="form-control" rows="3" placeholder=""><?= $data['agreement']['cfg_content'] ?></textarea>
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
                    <form id="frm" method="post" action="/prime/config/settings/action">
                        <?= csrf_field() ?>
                        <input type="hidden" name="postCase" value="config_wrtie">
                        <input type="hidden" name="idx" value="<?= $data['terms']['idx'] ?>">
                        <input type="hidden" name="cfgType" value="T">
                        <input type="hidden" name="backUrl" value="/prime/config/settings">
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
                                            <input class="form-check-input" type="radio" name="cfgUseYN" id="inlineRadio1" value="Y" <?= $data['terms']['cfg_useYN'] == 'Y' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio1">사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cfgUseYN" id="inlineRadio2" value="N" <?= $data['terms']['cfg_useYN'] == 'N' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio2">미사용</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>내용</td>
                                    <td>
                                        <textarea name="cfgContent" class="form-control" rows="3" placeholder=""><?= $data['terms']['cfg_content'] ?></textarea>
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

<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">개인정보수집 동의항목 설정</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/config/settings/action">
                        <?= csrf_field() ?>
                        <input type="hidden" name="postCase" value="config_wrtie">
                        <input type="hidden" name="idx" value="<?= $data['private']['idx'] ?>">
                        <input type="hidden" name="cfgType" value="P">
                        <input type="hidden" name="backUrl" value="/prime/config/settings">
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
                                            <input class="form-check-input" type="radio" name="cfgUseYN" id="inlineRadio1" value="Y" <?= $data['private']['cfg_useYN'] == 'Y' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio1">사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cfgUseYN" id="inlineRadio2" value="N" <?= $data['private']['cfg_useYN'] == 'N' ? 'checked=""' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio2">미사용</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>내용</td>
                                    <td>
                                        <textarea name="cfgContent" class="form-control" rows="3" placeholder=""><?= $data['private']['cfg_content'] ?></textarea>
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