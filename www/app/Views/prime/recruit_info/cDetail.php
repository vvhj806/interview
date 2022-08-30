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
                                    <th>회사정보</th>
                                    <td style="width: 30%;">
                                        <img src='<?= $data['url']['media'] ?><?= $data['info']['file_save_name'] ?? '/data/no_img.png' ?>' onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" style="width:40%;"><br><br>

                                        <div><?= $data['info']['com_name'] ?? '' ?></div><br>
                                        <div><a href="/prime/company/write/<?= $data['info']['comIdx'] ?? '' ?>">기업자세히보기</a></div>
                                    </td>
                                    <th>공고정보</th>
                                    <td>
                                        <?= $data['info']['rec_title'] ?><br>
                                        <a href="/prime/recruit/write/<?= $data['info']['recIdx'] ?>">공고자세히보기</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div>공고 지원자</div>
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class='text-center'>REC_INFO IDX</th>
                                    <th class='text-center'>아이디</th>
                                    <th class='text-center'>이름</th>
                                    <th class='text-center'>전화번호</th>
                                    <th class='text-center'>지원날짜</th>
                                    <th class='text-center'>인터뷰 상세보기</th>
                                    <th class='text-center'>지원내용 상세보기</th>
                                    <th class='text-center'>재응시요청상태</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['applicatnInfo'] as $row) : ?>
                                    <tr>
                                        <td class='text-center'><?= $row['recInfoIdx'] ?></td>
                                        <td class='text-center'><?= $row['mem_id'] ?></td>
                                        <td class='text-center'><?= $row['mem_name'] ?></td>
                                        <td class='text-center'><?= $row['mem_tel'] ?></td>
                                        <td class='text-center'><?= $row['res_info_reg_date'] ?></td>
                                        <td class='text-center'>
                                            <a href="/prime/interview/view/detail/<?= $row['app_idx'] ?>">자세히보기</a>
                                        </td>
                                        <td class='text-center'>
                                            <a href="/prime/recruit_info/m/detail/<?= $row['recInfoIdx'] ?>">자세히보기</a>
                                        </td>
                                        <td class='text-center'>
                                            <?php if (!$row['ag_req_com']) : ?>
                                                재응시 요청안함
                                            <?php else : ?>
                                                <?php if ($row['ag_req_com'] == 'N') : ?>
                                                    재응시요청 확인전
                                                <?php elseif ($row['ag_req_com'] == 'Y' && $row['ag_req_stat'] == 'N') : ?>
                                                    재응시 거절
                                                <?php elseif ($row['ag_req_com'] == 'Y' && $row['ag_req_stat'] == 'Y') : ?>
                                                    재응시 수락
                                                <?php else : ?>
                                                    재응시요청 확인중
                                                <?php endif; ?>
                                                <br>
                                                <a href='javascript:void(0)' id="req_detail" data-reason="<?= $row['ag_req_reason'] ?>" data-idx="<?= $row['ag_req_idx'] ?>">재응시요청 상세보기</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= $data['pager']->links('applicant', 'front_full') ?>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->
</form>

<!-- s 재응시요청 상세보기 팝업 -->
<div id="request_detail" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c" style="text-align: center;">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div>
                <p style="font-weight:bold;">재응시요청사유</p>
                <div id="reason"></div>
            </div>
            <br>
            <div>
                <form action="" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ag_rec_idx" id="ag_rec_idx" value=""><br>
                    <input type="submit" value="확인" formaction="/prime/suggest/c/again/action/confirm" />
                    <input type="submit" value="수락" formaction="/prime/suggest/c/again/action/accept" />
                    <input type="submit" value="거절" formaction="/prime/suggest/c/again/action/refuse" />
                </form>
            </div>
        </div>
        <!--e pop_cont-->

        <div class="spopBtn">
            <a href="javascript:void(0)" class="spop_btn01 wps_100 spop_close" style="width:100%;" onclick="fnHidePop('request_detail')">취소</a>
        </div>
    </div>
    <!--e pop_Box-->
</div>
<!-- e 재응시요청 상세보기 팝업 -->

<script>
    function fnShowPop(sGetName) {
        var $layer = $("#" + sGetName);
        var mHeight = $layer.find(".md_pop_content").height() / 2;
        $layer.addClass("on");
    }

    function fnHidePop(sGetName) {
        $("#" + sGetName).removeClass("on");
    }

    $('#req_detail').on('click', function() {
        let reqElm = $(this);
        let reason = reqElm.data('reason');
        let idx = reqElm.data('idx');

        $('#reason').text(reason);
        $('#ag_rec_idx').val(idx);

        fnShowPop('request_detail');
    });
</script>

<style>
    /* 팝업 띄우는 CSS 가져오기 */
    .pop_modal {
        display: none;
        z-index: 11
    }

    .pop_modal2 {
        opacity: 0;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    .pop_modal2.on {
        opacity: 1;
        z-index: 100;
    }

    .pop_modal2.wi.on {
        z-index: 999999
    }

    .pop_Box {
        position: relative;
        max-width: 768px;
        width: 100%;
        margin: 60px auto 0;
    }

    .pop_cont {
        position: relative;
        border-radius: 20px;
        overflow: hidden
    }

    .pop_tlt {
        padding: 30px 0 6px;
        background: #fff;
        color: #505bf0;
        font-size: 30px;
        font-weight: 700;
        text-align: center;
    }

    .pop_txt {
        height: 480px;
        padding: 20px 20px 0;
        font-size: 16px;
        background: #fff;
        box-sizing: border-box
    }

    .pop_txt .tlt {
        font-size: 22px;
        margin-bottom: 30px;
        color: #222
    }

    .pop_scroll_box {
        padding: 20px;
        border: 1px solid #ccc;
        height: 420px;
        overflow: hidden;
        line-height: 1.8em;
        color: #6a6a6a;
        overflow-y: scroll
    }

    .pop_close {
        cursor: pointer;
        position: absolute;
        top: -60px;
        right: 0;
        background: #505bf0;
        color: #fff;
        display: block;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 20px;
        text-align: center;
        border-radius: 50%;
    }

    .spop_Box {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 560px;
        width: 100%;
        border-radius: 20px;
        margin: 0;
        overflow: hidden;
        box-sizing: border-box
    }

    .spop_Box .spop_cont {
        position: relative;
        background: #fff;
        padding: 60px 40px;
    }

    .spop_Box .spopBtn {
        overflow: hidden
    }

    .spop_Box .spopBtn a,
    .spop_Box .spopBtn button {
        float: left;
        display: inline-block;
        height: 70px;
        line-height: 65px;
        font-size: 25px;
        width: 50%;
        font-weight: 700
    }

    .spop_Box .spopBtn.radius_none a:nth-child(1),
    .spop_Box .spopBtn.radius_none button:nth-child(1) {
        border-radius: 0 0 0 20px
    }

    .spop_Box .spopBtn.radius_none a:nth-child(2),
    .spop_Box .spopBtn.radius_none button:nth-child(2) {
        border-radius: 0 0 20px 0
    }

    .spop_Box .spopBtn .spop_btn01 {
        background: #eaeaea;
        color: #343434;
    }

    .spop_Box .spopBtn .spop_btn02 {
        background: #505bf0;
        color: #fff;
    }
</style>