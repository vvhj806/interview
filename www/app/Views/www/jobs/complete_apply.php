<form action="/jobs/applyAtOnce" method="post" id="once">
    <!--s #scontent-->
    <div id="scontent">

        <!--s cont-->
        <div class="cont cont_pd_bottom">
            <div class="itv_pr_cp mg_b50"><img src="/static/www/img/sub/interview_pr_cp_img.png" class="wps_100"></div>

            <div class="c">
                <!--s bigtlt-->
                <div class="stlt">
                    <span class="point b">지원이 완료되었습니다!</span>
                    <br><br>
                    <?php
                    foreach ($data['recruitTitles'] as $key => $val) :
                    ?>
                        <div class="mg_t5">[<?= $data['recruitTitles'][$key]['rec_title'] ?>]</div>
                    <?php
                    endforeach
                    ?>
                </div>
                <!--e bigtlt-->

                <div class="mg_t10">지원현황은 마이페이지에서 확인해주세요</div>
            </div>

            <!--s ard_btn-->
            <div class="BtnBox mg_t60">
                <a href="/my/recruit_info/completed" class="btn btn01">지원현황 보기</a>
                <a href="/" class="btn btn02">메인으로</a>
            </div>
            <!--e ard_btn-->

            <?php if ($data['randomInfo']) : ?>

                <div class="contBox l mg_t100">
                    <div class="stlt">아래 공고에도 동시에 지원하시겠어요?</div>
                </div>

                <div id='result' style="display: none;"></div>

                <!--s acmBox-->
                <div class="acmBox">
                    <!--s acm_sl-->
                    <div class="acm_sl">
                        <!--s 무한루프-->

                        <?php
                        foreach ($data['randomInfo'] as $key => $val) :
                        ?>
                            <!--s item-->
                            <div class="item">
                                <a href="javascript:void(0)">
                                    <div class="chek_box checkbox">
                                        <input type="checkbox" id="recruitCheck<?= $data['randomInfo'][$key]['idx'] ?>" name="recruitCheck" value="<?= $data['randomInfo'][$key]['idx'] ?>" onchange="recCheck()">
                                        <label for="recruitCheck<?= $data['randomInfo'][$key]['idx'] ?>" class="lbl"></label>
                                    </div>
                                    <div class="imgBox">
                                        <div class="bookmark_iconBox">

                                            <?php if ($data['scrap'][$key] == 0) : ?>
                                                <button type="button" class="bookmark_icon off" id="favorite<?= $key ?>" tabindex="0" onclick="insertScrap('<?= $data['randomInfo'][$key]['idx'] ?>', '<?= $key ?>')"><span class="blind">스크랩</span></button>
                                            <?php else : ?>
                                                <button type="button" class="bookmark_icon on" id="favorite<?= $key ?>" tabindex="0" onclick="deleteScrap('<?= $data['randomInfo'][$key]['idx'] ?>', '<?= $key ?>')"><span class="blind">스크랩</span></button>
                                            <?php endif; ?>

                                        </div>

                                        <div class="img"><img src="<?= $data['url']['media'] ?><?= $data['randomInfo'][$key]['file_save_name'] ?? '/data/no_img.png'?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                    </div>

                                    <div class="txtBox">
                                        <!-- <div class="tlt">(공고 idx) <?= $data['randomInfo'][$key]['idx'] ?></div> -->
                                        <div class="tlt"><?= $data['randomInfo'][$key]['com_name'] ?></div>
                                        <div class="product_desc"><?= $data['randomInfo'][$key]['rec_title'] ?></div>

                                        <div class="gtxt">
                                            <?= $data['randomInfo'][$key]['area_depth_text_1'] ?> . <?= $data['randomInfo'][$key]['area_depth_text_2'] ?>
                                            <span> | </span>
                                            <?php if ($data['randomInfo'][$key]['rec_career'] == 'A') : ?>
                                                경력무관
                                            <?php elseif ($data['randomInfo'][$key]['rec_career'] == 'C') : ?>
                                                경력
                                            <?php elseif ($data['randomInfo'][$key]['rec_career'] == 'N') : ?>
                                                신입
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!--e item-->
                        <?php
                        endforeach
                        ?>
                        <!--e 무한루프-->
                    </div>
                    <!--e acm_sl-->
                </div>
                <!--e acmBox-->

                <!--s BtnBox-->
                <div class="BtnBox">
                    <a href="javascript:void(0)" onclick="atOnce()" class="btn btn01 wps_100 interview_pr_pop_open"><span id="ckcnt">0</span>개 공고 한꺼번에 지원하기</a>
                </div>
                <!--e BtnBox-->

            <?php endif; ?>
        </div>
        <!--e cont-->
    </div>
    <!--e #scontent-->

    <?= csrf_field() ?>
    <input type="hidden" id="state" name="state" value="M">
    <div id="recIdxs"></div>

</form>

<script>
    let checkCnt = 0;
    const state = '<?= $data['aData']['get']['state'] ?>';
    const memIdx = '<?= $data['session']['idx'] ?>';

    $(document).ready(function() {
        if (state == "M") {
            $('#moreRec').show();
        }
    });

    function recCheck() {
        const query = 'input[name="recruitCheck"]:checked';
        const selectedEls = document.querySelectorAll(query);

        let result = '';
        selectedEls.forEach((el) => {
            result += el.value + ' ';
        });

        checkCnt = $('input:checkbox[name="recruitCheck"]:checked').length;

        document.getElementById('ckcnt').innerText = checkCnt;
        document.getElementById('result').innerText = result;
    }

    function atOnce() {
        let recidx = $('#result').text();
        let checkedRec = $('input:checkbox[name="recruitCheck"]:checked');

        if (checkCnt == 0) {
            alert2('공고를 1개이상 선택해주세요');
        } else {
            for (i = 0; i < checkedRec.length; i++) {
                $('#recIdxs').append(`<input type="text" name="recIdx[]" value="${checkedRec[i].value}">`);
            }
            $('#once').submit();
        }
    }

    function insertScrap(recIdx, key) {
        $.ajax({
            type: "GET",
            url: "/api/my/scrap/add/recruit/" + memIdx + "/" + recIdx,
            data: {
                'csrf_highbuff': $('input[name="csrf_highbuff"]').val(),
            },
            success: function(data) {
                if (data.status == 200) {
                    $('input[name="csrf_highbuff"]').val(data.code.token);
                    $('#favorite' + key).attr('onclick', 'deleteScrap(' + recIdx + ', ' + key + ')');
                    $('#favorite' + key).removeClass('off');
                    $('#favorite' + key).addClass('on');
                } else {
                    alert('정상적인 접근이 아닙니다.');
                    location.href = '/';
                }
            },
            beforeSend: function() {},
            complete: function() {},
            error: function(e) {
                alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 '하이버프'로 문의 부탁드립니다.");
                return;
            },
            timeout: 5000
        }) //ajax;  
    }

    function deleteScrap(recIdx, key) {
        $.ajax({
            type: "GET",
            url: "/api/my/scrap/delete/recruit/" + memIdx + "/" + recIdx,
            data: {
                'csrf_highbuff': $('input[name="csrf_highbuff"]').val(),
            },
            success: function(data) {
                if (data.status == 200) {
                    $('input[name="csrf_highbuff"]').val(data.code.token);
                    $('#favorite' + key).attr('onclick', 'insertScrap(' + recIdx + ', ' + key + ')');
                    $('#favorite' + key).removeClass('on');
                    $('#favorite' + key).addClass('off');
                } else {
                    alert('정상적인 접근이 아닙니다.');
                    location.href = '/';
                }
            },
            beforeSend: function() {},
            complete: function() {},
            error: function(e) {
                alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 '하이버프'로 문의 부탁드립니다.");
                return;
            },
            timeout: 5000
        }) //ajax;  
    }
</script>