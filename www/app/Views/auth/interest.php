<?php
isset($data['my']['mem_pay_left']) ? $data['my']['mem_pay_left'] : $data['my']['mem_pay_left'] = 24;
isset($data['my']['mem_pay_right']) ? $data['my']['mem_pay_right'] : $data['my']['mem_pay_right'] = 100;

// print_r($data['my']['area']);
// return;
?>
<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <?php
            if ($data['code'] == 'join') :
            ?>
                <a id="btnTab" data-type="join" href="/" class="top_gray_txtlink gray_txtlink">다음에 하기</a>
            <?php
            elseif ($data['code'] == 'main') :
            ?>
                <a id="btnTab" data-type="main" href="/my/main">
                    <div class="backBtn"><span>뒤로가기</span></div>
                </a>
                <div class="tlt">내 관심사 저장하기</div>
            <?php
            endif;
            ?>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont_pd-->
    <div class="cont_pd cont_pd_bottom">
        <!--s contBox-->
        <div class="contBox">
            <!--s bigtlt-->
            <div class="bigtlt">
                <span class="point b"><?= $data['session']['name'] ?></span>님에 대해 조금 더 알려주세요!
            </div>
            <!--e bigtlt-->
        </div>
        <!--e contBox-->

        <form id="frm" method="post" action="/my/interest/<?= $data['code'] ?>/action">
            <?= csrf_field() ?>
            <input type="hidden" name="postCase" value="interest_write">
            <input type="hidden" name="backUrl" value="/interest">
            <!--s gray_bline_first-->
            <div class="gray_bline_first">
                <!--s contBox-->
                <div class="contBox">
                    <div class="stlt">어떤 포지션에서 일하고 싶나요?</div>
                    <!--s position_ckBox-->
                    <div class="position_ckBox">
                        <ul>
                            <?php
                            // $data['category'] : 전체 카테고리
                            // $data['my']['category'] : 내가 선택한 카테고리
                            // checked
                            foreach ($data['category'] as $key => $val) :
                            ?>
                                <li>
                                    <div class="ck_radio">
                                        <input type="checkbox" id="position_<?= $val['idx'] ?>" name="rec[]" value='<?= $val['idx'] ?>' <?= in_array($val['job_depth_1'], $data['my']['category']) ? 'checked' : ''; ?>>
                                        <label for="position_<?= $val['idx'] ?>"><?= $val['job_depth_text'] ?></label>
                                    </div>
                                </li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <!--e position_ckBox-->
                </div>
                <!--s contBox-->
            </div>
            <!--e gray_bline_first-->

            <!--s gray_bline_first-->
            <div class="gray_bline_first gray_bline_top">
                <!--s contBox-->
                <div class="contBox">
                    <div class="stlt">일하고 싶은 지역은 어디인가요?</div>
                    <!--s position_ckBox-->
                    <div class="position_ckBox">
                        <ul>
                            <?php
                            foreach ($data['area'] as $key => $val) :
                            ?>
                                <li>
                                    <div class="ck_radio">
                                        <input type="checkbox" id="area_<?= $val['idx'] ?>" name="area[]" value="<?= $val['idx'] ?>" <?= in_array($val['area_depth_text_1'], $data['my']['area']) ? 'checked' : ''; ?>>
                                        <label for="area_<?= $val['idx'] ?>"><?= $val['area_depth_text_1'] ?></label>
                                    </div>
                                </li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <!--e position_ckBox-->
                </div>
                <!--s contBox-->
            </div>
            <!--e gray_bline_first-->

            <!--s gray_bline_first-->
            <div class="gray_bline_first gray_bline_top">
                <!--s contBox-->
                <div class="contBox">
                    <div class="stlt">MBTI를 알려주세요!</div>
                    <div class='mbti_box'>
                        <input name='m' class='mbti_input' placeholder='M' value='<?= $data['my']['mbti']['m'] ?>'>
                        <input name='b' class='mbti_input' placeholder='B' value='<?= $data['my']['mbti']['b'] ?>'>
                        <input name='t' class='mbti_input' placeholder='T' value='<?= $data['my']['mbti']['t'] ?>'>
                        <input name='i' class='mbti_input' placeholder='I' value='<?= $data['my']['mbti']['i'] ?>'>
                    </div>
                </div>
                <!--s contBox-->
            </div>
            <!--e gray_bline_first-->

            <!--s gray_bline_pd-->
            <div class="gray_bline_pd">
                <!--s contBox-->
                <div class="contBox">
                    <div class="stlt">희망하는 연봉을 알려주세요!</div>

                    <!--s aninBox-->
                    <div class="aninBox">
                        <div id="dreamPay" class="txt point fl">2,400만원~10,000만원 </div>
                        <div class="chek_box checkbox fr">
                            <input id="topPay" name="topPay" type="checkbox" value="999" <?= $data['my']['payCheck'] ?>>
                            <label for="topPay" class="lbl">1억 이상</label>
                        </div>
                    </div>
                    <!--e aninBox-->

                    <!--s graph-box-price-->
                    <div class="graph-box-price">
                        <!-- 진짜 슬라이더 -->
                        <input type="range" id="input-left" name="leftPay" min="24" max="100" value="<?= $data['my']['mem_pay_left'] ?? 24 ?>" />
                        <input type="range" id="input-right" name="rightPay" min="24" max="100" value="<?= $data['my']['mem_pay_right'] ?? 100 ?>" />

                        <!-- 커스텀 슬라이더 -->
                        <div class="multi-range-slider">
                            <div class="point-line"></div>
                            <div class="gray-line"></div>
                            <div class="chiBtn">
                                <div class="chiBtnIn min_btn"></div>
                                <div class="chiBtnIn max_btn"></div>
                            </div>
                        </div>
                    </div>
                    <!--e graph-box-price-->

                    <div class="gray_txt c">저장하신 관심사 기반으로 더욱 알맞은 맞춤 정보를 보여드릴게요</div>

                    <!--s BtnBox-->
                    <div class="BtnBox">
                        <button type="submit" class="btn btn01 wps_100">저장</button>
                    </div>
                    <!--e BtnBox-->
                </div>
                <!--s contBox-->
            </div>
            <!--e gray_bline_pd-->

        </form>
    </div>
    <!--s cont_pd-->
</div>
<!--e #scontent-->
<script>
    const inputLeft = $("#input-left");
    const inputRight = $("#input-right");
    const emlDreamPay = $("#dreamPay");
    const thumbLeft = $(".min_btn");
    const thumbRight = $(".max_btn");
    const range = $(".point-line");
    const maxV = Math.max(inputLeft.val(), inputRight.val());
    const minV = Math.min(inputLeft.val(), inputRight.val());
    const mbtiEng = {
        'm': ['I', 'E'],
        'b': ['N', 'S'],
        't': ['F', 'T'],
        'i': ['J', 'P']
    };

    const mbtiKor = {
        'm': {
            'ㅑ': 'I',
            'ㄷ': 'E'
        },
        'b': {
            'ㅜ': 'N',
            'ㄴ': 'S'
        },
        't': {
            'ㄹ': 'F',
            'ㅅ': 'T'
        },
        'i': {
            'ㅓ': 'J',
            'ㅔ': 'P'
        }
    };

    $(document).ready(function() {
        inputLeft.val(minV);
        inputRight.val(maxV);

        leftSlide();
        rightSlide();
        setDreamPay();
    });

    inputLeft.on('input', function() {
        leftSlide();
        setDreamPay();
    });

    inputRight.on('input', function() {
        rightSlide();
        setDreamPay();
    });

    $('.mbti_input').on('keydown', function(event) {
        const thisEle = $(this);
        if (event.keyCode === 8 && !thisEle.val()) {
            thisEle.prev('input').focus();
        }
    });

    $('.mbti_input').on('input', function(event) {
        const thisEle = $(this);
        const thisMbti = thisEle.attr('name');
        const onkey = event['originalEvent']['data'] ? event['originalEvent']['data'].toUpperCase() : event['originalEvent']['data'];

        thisEle.val(onkey);
        if (onkey === null) {
            thisEle.prev('input').focus();
            return false;
        }

        if (!in_array(onkey, mbtiEng[thisMbti])) {
            if (mbtiKor[thisMbti][onkey]) {
                thisEle.val(mbtiKor[thisMbti][onkey]);
            } else {
                const randomValue = Math.round(Math.random());
                thisEle.val(mbtiEng[thisMbti][randomValue]);
            }
        }
        if (thisMbti != 'i') {
            thisEle.next('input').focus();
        }
    });

    function getPercent(ele) {
        const [attrMin, attrMax] = [parseInt(ele.attr("min")), parseInt(ele.attr("max"))];
        return (ele.val() - attrMin) / (attrMax - attrMin) * 100;
    }

    function leftSlide() {
        inputLeft.val(Math.min(parseInt(inputRight.val() - 1), parseInt(inputLeft.val())));

        const leftpercent = getPercent(inputLeft);
        thumbLeft.css('left', leftpercent + "%");
        range.css('left', leftpercent + "%");
    }

    function rightSlide() {
        inputRight.val(Math.max(parseInt(inputRight.val()), parseInt(inputLeft.val()) + 1));

        const rightpercent = getPercent(inputRight);
        thumbRight.css('left', rightpercent + "%");
        range.css('right', 100 - rightpercent + "%");
        $('#topPay').prop('checked', parseInt(inputRight.val()) == 100);
    }

    function setDreamPay() {
        let leftPay = $.numberWithCommas(Math.min(parseInt(inputLeft.val()), parseInt(inputRight.val())) * 100) + '만원';
        let rightPay = $.numberWithCommas(Math.max(parseInt(inputRight.val()), parseInt(inputLeft.val())) * 100) + '만원';

        emlDreamPay.text(`${leftPay}~${rightPay}`);
    }

    $.numberWithCommas = function(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    //validate
    $.validator.setDefaults({
        onkeyup: false,
        onclick: false,
        onfocusout: false,
        showErrors: function(errorMap, errorList) {
            if (this.numberOfInvalids()) {
                // 에러가 있으면
                alert(errorList[0].message); // 경고창으로 띄움
            }
        }
    });

    <?php
    // required : 필수 입력 엘리먼트입니다.
    // remote : 엘리먼트의 검증을 지정된 다른 자원에 ajax 로 요청합니다.
    // minlength : 최소 길이를 지정합니다.
    // maxlength : 최대 길이를 지정합니다.
    // rangelength : 길이의 범위를 지정합니다.
    // min : 최소값을 지정합니다.
    // max : 최대값을 지정합니다.
    // range : 값의 범위를 지정합니다.
    // step : 주어진 단계의 값을 가지도록 합니다.
    // email : 이메일 주소형식으 가지도록 합니다.
    // url : url 형식을 가지도록 합니다.
    // date : 날짜 형식을 가지도록 합니다.
    // dateISO : ISO 날짜 형식을 가지도록 합니다.
    // number : 10진수를 가지도록 합니다.
    // digits : 숫자 형식을 가지도록 합니다.
    // equalTo : 엘리먼트가 다른 엘리먼트와 동일해야 합니다.
    ?>

    $("#frm").validate({
        ignore: [],
        rules: {
            'rec[]': {
                required: true
            },
            'area[]': {
                required: true
            },
        },
        messages: {
            'rec[]': {
                required: "포지션은 최소 1개이상 선택해주세요.",
            },
            'area[]': {
                required: "지역은 최소 1개이상 선택해주세요.",
            },
        },
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때

            const m = $('input[name="m"]').val();
            const b = $('input[name="b"]').val();
            const t = $('input[name="t"]').val();
            const i = $('input[name="i"]').val();
            if (m || b || t || i) {
                if (!(m && b && t && i)) {
                    alert('MBTI를 완성해 주세요.');
                    return false;
                }
            }
            form.submit();
        }
    });

    $('input[name="rec[]"]:checkbox').on('click', () => {
        if ($('input[name="rec[]"]:checkbox:checked').length > 4) {
            $(this).prop("checked", false);
            alert2('최대 4개까지 선택 가능합니다.');
            return false;
        }
    })


    $('input[name="area[]"]:checkbox').on('click', () => {
        if ($('input[name="area[]"]:checkbox:checked').length > 4) {
            $(this).prop("checked", false);
            alert2('최대 4개까지 선택 가능합니다.');
            return false;
        }
    })

    // 탭
    const emlTab = $("#btnTab");
    emlTab.on('click', () => {
        if ($(this).data('type') == 'join') {
            window.location.href = '/';
        } else if ($(this).data('type') == 'back') {
            window.history.back();
        }

    })
</script>