<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">비즈회원 제안 상세</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <form id="frm" method="post" action="/prime/suggest/c/action<?= "/{$data['suggestIdx']}" ?>">
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
                                    <td>제안번호</td>
                                    <td>
                                        <?= $data['suggestList']['sugIdx'] ?? '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안유형 <?= $data['suggestIdx'] ? "<span class='point'>*변경불가</span>" : '' ?></td>
                                    <td>
                                        <select>
                                            <option value='A' <?= $data['suggestList']['sugType'] ?? '' === 'A' ? 'selected' : '' ?>>인터뷰제안</option>
                                            <option value='I' <?= $data['suggestList']['sugType'] ?? '' === 'I' ? 'selected' : '' ?>>대면면접제안</option>
                                            <option value='O' <?= $data['suggestList']['sugType'] ?? '' === 'O' ? 'selected' : '' ?>>이직및포지션제안</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>메세지</td>
                                    <td>
                                        <input name='sug_massage' value='<?= $data['suggestList']['msg'] ?? '' ?>'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>담당자 상태</td>
                                    <td>
                                        <select name='sug_manager'>
                                            <option value='O' <?= $data['suggestList']['managerStat'] ?? '' === 'O' ? 'selected' : '' ?>>공개</option>
                                            <option value='C' <?= $data['suggestList']['managerStat'] ?? '' === 'C' ? 'selected' : '' ?>>비공개</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>담당자 이름</td>
                                    <td>
                                        <input name='sug_manager_name' value='<?= $data['suggestList']['managerName'] ?? '' ?>'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>담당자 연락처</td>
                                    <td>
                                        <input name='sug_manager_tel' value='<?= $data['suggestList']['managerTel'] ?? '' ?>'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안 시작일</td>
                                    <td>
                                        <input type='date' name='sug_start_date' value='<?= $data['suggestList']['sugStartDate'] ?? '' ?>'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제안 종료일</td>
                                    <td>
                                        <input type='date' name='sug_end_date' value='<?= $data['suggestList']['sugEndDate'] ?? '' ?>'>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" value="저장" class="btn btn-success float-right">
                    </form>

                    <div>회원</div>
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>
                        </colgroup>
                        <thead>
                            <tr>
                                <th class='text-center'>이름</th>
                                <th class='text-center'>전화번호</th>
                                <th class='text-center'>재응시요청상태</th>
                                <th class='text-center'>재응시요청상세보기</th>
                                <th class='text-center'>제안 취소</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data['configList']) : ?>
                                <?php foreach ($data['configList'] as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['memName'] ?></td>
                                        <td class="text-center"><?= $row['memTel'] ?></td>
                                        <td class="text-center"><?= $row['againStat'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['againStat'] != '요청 없음') : ?>
                                                <a href='javascript:void(0)' id="req_detail" data-reason="<?= $row['ag_req_reason'] ?>" data-idx="<?= $row['ag_req_idx'] ?>">상세보기</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><button name='' value='<?= $row['conSugIdx'] ?>'>취소</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <td colspan="7" class="text-center">회원 유저에게 보낸 제안이 없습니다</td>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div>비회원</div>
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>
                        </colgroup>
                        <thead>
                            <tr>
                                <th class='text-center'>이름</th>
                                <th class='text-center'>전화번호</th>
                                <th class='text-center'>재응시요청상태</th>
                                <th class='text-center'>재응시요청상세보기</th>
                                <th class='text-center'>제안 취소</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data['applicantList']) : ?>
                                <?php foreach ($data['applicantList'] as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['memName'] ?></td>
                                        <td class="text-center"><?= $row['memTel'] ?></td>
                                        <td class="text-center"><?= $row['againStat'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['againStat'] != '요청 없음') : ?>
                                                <a href='javascript:void(0)' id="req_detail" data-reason="<?= $row['ag_req_reason'] ?>" data-idx="<?= $row['ag_req_idx'] ?>" data-sug-app-idx="<?= $row['appSugIdx'] ?>">상세보기</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><button name='' value='<?= $row['appSugIdx'] ?>'>취소</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <td colspan="7" class="text-center">비회원 유저에게 보낸 제안이 없습니다</td>
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
                    <input type="hidden" name="sug_app_idx" id="sug_app_idx" value=""><br>
                    <input type="submit" value="확인" formaction="/prime/suggest/c/again/action/confirm" />
                    <input type="submit" value="수락" formaction="/prime/suggest/c/again/action/accept" />
                    <input type="submit" value="거절" formaction="/prime/suggest/c/again/action/refuse" />
                </form>
            </div>
        </div>
        <!--e pop_cont-->

        <div class="spopBtn">
            <a href="#n" class="spop_btn01 wps_100 spop_close" style="width:100%;" onclick="fnHidePop('request_detail')">취소</a>
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
        let sugAppIdx =reqElm. data('sug-app-idx');

        $('#reason').text(reason);
        $('#ag_rec_idx').val(idx);
        $('#sug_app_idx').val(sugAppIdx);

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