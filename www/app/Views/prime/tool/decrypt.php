<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">암호화 / 복호화</h3>
                <div>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="get" id="frm" target="_self">
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>
                            <col style="width:50px">
                            <col style="width:150px">
                            <col style="width:150px">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>암호화1</th>
                                <td><input name='encode1' class='asd' placeholder="encode" value='<?= $data['encode1']['before'] ?>'><button>암호화</button></td>
                                <td>결과: <?= $data['encode1']['after'] ?? '없음' ?></td>
                            </tr>
                            <tr>
                                <th>복호화1</th>
                                <td><input name='decode1' class='asd' placeholder="decode" value='<?= $data['decode1']['before'] ?>'><button>복호화</button></td>
                                <td>결과: <?= $data['decode1']['after'] ?? '없음' ?></td>
                            </tr>

                            <tr>
                                <th>1.5 암호화</th>
                                <td><input name='encode2' class='asd' placeholder="encode" value='<?= $data['encode2']['before'] ?>'><button>암호화</button></td>
                                <td>결과: <?= $data['encode2']['after'] ?? '없음' ?></td>
                            </tr>
                            <tr>
                                <th>1.5 복호화</th>
                                <td><input name='decode2' class='asd' placeholder="decode" value='<?= $data['decode2']['before'] ?>'><button>복호화</button></td>
                                <td>결과: <?= $data['decode2']['after'] ?? '없음' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<style>
    .asd {
        width: 80%;
    }
</style>