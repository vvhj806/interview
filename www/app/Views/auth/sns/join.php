<?php
isset($data['stuCode']) ? $readOnly = "readonly" : $readOnly = "";
isset($data['uniCode']) ? $data['uniCode'] : $data['uniCode'] = "";
isset($data['stuCode']) ? $data['stuCode'] : $data['stuCode'] = "";
isset($data['uniType']) ? $data['uniType'] : $data['uniType'] = "";
isset($data['MajorList']) ? $data['MajorList'] : $data['MajorList'] = [];
$data['uniType'] == 'H' ? $height = "auto" : $height = "150px";
$data['uniCode'] == '10' ? $height = "auto" : $height = "150px";
?>
<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">회원가입</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont">
        <!--s bigtlt-->
        <div class="bigtlt b">
            <span class="point">하이버프에 오신 걸 환영합니다! </span><br />
            시작하기 전, 사용하실 이름만 알려주시겠어요?
        </div>
        <!--e bigtlt-->

        <form id="frm" method="post" action="/join/sns/action/<?= $data['sns']['cache']['snsType'] ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="loginId" value="<?= $data['sns']['cache']['id'] ?>" />
            <input type="hidden" name="loginKey" value="<?= $data['sns']['cache']['key'] ?>" />
            <input type="hidden" name="loginPassword" value="<?= $data['sns']['cache']['enc'] ?>" />
            <input type="hidden" name="loginProvider" value="<?= $data['sns']['cache']['provider'] ?>" />
            <input type="hidden" name="loginAccessToken" value="<?= $data['sns']['cache']['accessToken'] ?>">
            <input type="hidden" name="loginType" id="loginType" value=""> <!-- 애플을 위한 탈퇴한 회원 재가입 방지-->
            <input type="hidden" name="AppCheck" id="AppCheck" value="">
            <?php if ($data['sns']['cache']['provider'] == 'A') : ?>
                <input type="hidden" name="loginEmail" value="apple_login" />
            <?php else : ?>
                <input type="hidden" name="loginEmail" value="<?= $data['sns']['cache']['email'] ?>" />
            <?php endif; ?>
            <input type="hidden" name="postCase" value="join_write" />
            <input type="hidden" name="backUrl" value="/login" />
            <div class="inp_dlBox">
                <dl class="inp_dl">
                    <dt>이름</dt>
                    <dd><input type="text" name="loginName" maxlength="10" class="wps_100" placeholder="정확한 정보 제공을 위해 실명을 권장합니다."></dd>
                </dl>
                <!-- 조건문 걸어야함 -->
                <?php if ($data['uniCode']) : ?>
                    <?php if ($data['uniType'] == 'U') : ?>
                        <dl class="inp_dl">
                            <dt>학번</dt>
                            <dd><input type="text" name="stuCode" class="wps_100" placeholder="" value="<?= $data['stuCode'] ?>" <?= $readOnly ?>></dd>
                        </dl>
                    <?php else : ?>
                        <dl class="inp_dl">
                            <dt>학년</dt>
                            <dd>
                                <div class="sel_lineb" style="border-bottom: unset;">
                                    <!--s selBox-->
                                    <div class="selBox wps_100" style="z-index:15;">
                                        <!--s selectbox-->
                                        <div class="selectbox wps_100">
                                            <dl class="dropdown">
                                                <dt style="margin-bottom:0px"><a href="javascript:void(0)" class="wps_100" id="selectGrade">학년을 선택해주세요. </a></dt>
                                                <dd>
                                                    <ul class="dropdown2" style="height: 150px;overflow-y: scroll;border-bottom: solid 1px #dbdbdb;">
                                                        <!-- 반복문 -->
                                                        <?php for ($i = 1; $i <= 3; $i++) : ?>
                                                            <li class="liClick">
                                                                <label class=""><?= $i ?><input name="Grade" type="radio" value="<?= $i ?>" style="display:none"></label>
                                                            </li>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </dd>
                                            </dl>
                                        </div>
                                        <!--e selectbox-->
                                    </div>
                                    <!--e selBox-->
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>반</dt>
                            <dd>
                                <div class="sel_lineb" style="border-bottom: unset;">
                                    <!--s selBox-->
                                    <div class="selBox wps_100" style="z-index:14;">
                                        <!--s selectbox-->
                                        <div class="selectbox wps_100">
                                            <dl class="dropdown">
                                                <dt style="margin-bottom:0px"><a href="javascript:void(0)" class="wps_100" id="selectClass">반을 선택해주세요. </a></dt>
                                                <dd>
                                                    <ul class="dropdown2" style="height: 150px;overflow-y: scroll;border-bottom: solid 1px #dbdbdb;">
                                                        <!-- 반복문 -->
                                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                                            <li class="liClick">
                                                                <label class=""><?= $i ?><input name="Class" type="radio" value="<?= $i ?>" style="display:none"></label>
                                                            </li>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </dd>
                                            </dl>
                                        </div>
                                        <!--e selectbox-->
                                    </div>
                                    <!--e selBox-->
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>번호</dt>
                            <dd>
                                <div class="sel_lineb" style="border-bottom: unset;">
                                    <!--s selBox-->
                                    <div class="selBox wps_100" style="z-index:13;">
                                        <!--s selectbox-->
                                        <div class="selectbox wps_100">
                                            <dl class="dropdown">
                                                <dt style="margin-bottom:0px"><a href="javascript:void(0)" class="wps_100" id="selectNum">번호를 선택해주세요. </a></dt>
                                                <dd>
                                                    <ul class="dropdown2" style="height: 150px;overflow-y: scroll;border-bottom: solid 1px #dbdbdb;">
                                                        <!-- 반복문 -->
                                                        <?php for ($i = 1; $i <= 30; $i++) : ?>
                                                            <li class="liClick">
                                                                <label class=""><?= $i ?><input name="Number" type="radio" value="<?= $i ?>" style="display:none"></label>
                                                            </li>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </dd>
                                            </dl>
                                        </div>
                                        <!--e selectbox-->
                                    </div>
                                    <!--e selBox-->
                            </dd>
                        </dl>
                    <?php endif; ?>

                    <dl class="inp_dl">
                        <dt>학과</dt>
                        <dd>
                            <div class="sel_lineb" style="border-bottom: unset;">
                                <!--s selBox-->
                                <div class="selBox wps_100">
                                    <!--s selectbox-->
                                    <div class="selectbox wps_100">
                                        <dl class="dropdown">
                                            <dt style="margin-bottom:0px"><a href="javascript:void(0)" class="wps_100" id="majorSelect">학과를 선택해주세요. </a></dt>
                                            <dd>
                                                <ul class="dropdown2" style="height: <?= $height ?>;overflow-y: scroll;border-bottom: solid 1px #dbdbdb;">
                                                    <!-- 반복문 -->
                                                    <?php foreach ($data['MajorList'] as $key => $val) : ?>
                                                        <li class="liClick">
                                                            <label class=""><?= $val['uni_major'] ?><input name="major" type="radio" value="<?= $val['idx'] ?>" style="display:none"></label>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>
                                    <!--e selectbox-->
                                </div>
                                <!--e selBox-->
                            </div>
                        </dd>
                    </dl>
                <?php endif; ?>

            </div>
            <!--s join_agrBox-->
            <div class="join_agrBox">
                <!--s all_agrBox-->
                <div class="all_agrBox">
                    <div class="chek_box checkbox">
                        <input id="chk_all" name="mem_personal_type" type="checkbox">
                        <label for="chk_all" class="lbl">전체동의</label>
                    </div>
                </div>
                <!--e all_agrBox-->

                <!--s chek_cont-->
                <div class="chek_cont">
                    <div class="chek_box checkbox">
                        <input id="agree" class="chk-each" name="mem_personal_type_1" type="checkbox" value="Y">
                        <label for="agree" class="lbl"><a href="javascript:;" class="bline pop_chek02">이용약관</a> 및 <a href="javascript:;" class="bline pop_chek01">개인정보 처리방침</a>에 동의(필수)</label>
                    </div>

                    <div class="chek_box checkbox">
                        <input id="agree2" class="chk-each" name="mem_personal_type_2" type="checkbox" value="Y">
                        <label for="agree2" class="lbl">맞춤 채용정보 제공 및 알림 수신에 동의(선택)</label>
                    </div>
                </div>
                <!--e chek_cont-->

                <!--s BtnBox-->
                <div class="BtnBox">
                    <button type="submit" class="btn btn01 Btn_off wps_100">가입완료</button>
                    <!--on 일때 Btn_off 클래스 없애주세요-->
                </div>
                <!--e BtnBox-->
            </div>
            <!--e join_agrBox-->
            <input type="text" name="uniCode" value="<?= $data['uniCode'] ?>" style="display:none">
            <input type="text" name="uniType" value="<?= $data['uniType'] ?>" style="display:none">
        </form>
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->
<script>
    let broswerInfo = navigator.userAgent;
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
    $.validator.addMethod("regex", function(value, element, regexp) {
        let re = new RegExp(regexp);
        let res = re.test(value);
        return res;
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
            loginId: {
                required: true,
            },
            loginEmail: {
                required: true,
            },
            loginProvider: {
                required: true,
            },
            loginPassword: {
                required: true,
                minlength: 8
            },
            loginName: {
                required: true,
            },
            mem_personal_type_1: {
                required: true,
            },
            stuCode: {
                required: function() {
                    if ("<?= $data['uniCode'] ?>" == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            major: {
                required: function() {
                    if ("<?= $data['uniCode'] ?>" == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            Grade: {
                required: function() {
                    if ("<?= $data['uniCode'] ?>" == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            Class: {
                required: function() {
                    if ("<?= $data['uniCode'] ?>" == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            Number: {
                required: function() {
                    if ("<?= $data['uniCode'] ?>" == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
        },
        messages: {
            loginId: {
                required: "잘못된 접근 입니다.",
            },
            loginEmail: {
                required: "잘못된 접근 입니다.",
            },
            loginProvider: {
                required: "잘못된 접근 입니다.",
            },
            loginPassword: {
                required: "잘못된 접근 입니다.",
            },
            loginName: {
                required: "이름은 필수 입력입니다.",
            },
            mem_personal_type_1: {
                required: "이용약관 및 개인정보 처리 방침은 필수 선택입니다.",
            },
            stuCode: {
                required: "학번은 필수 입력입니다.",
            },
            major: {
                required: "학과는 필수 입력입니다.",
            },
            Grade: {
                required: "학년은 필수 입력입니다.",
            },
            Class: {
                required: "반은 필수 입력입니다.",
            },
            Number: {
                required: "번호는 필수 입력입니다.",
            }
        },
        submitHandler: function(form) {

            if (broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
                $('#loginType').val('apple');
                $('#AppCheck').val('ios');
            } else if(broswerInfo.indexOf("APP_Highbuff_Android") != -1){
                $('#AppCheck').val('Android');
            }
            
            form.submit();

        }
    });

    const emlChkAll = $("#chk_all");
    const emlChkEach = $(".chk-each");
    emlChkAll.on("click", () => {
        //전체 체크박스 선택
        if (emlChkAll.prop("checked")) {
            emlChkEach.prop("checked", true);
        } else {
            emlChkEach.prop("checked", false);
        }
    });
    emlChkEach.on("click", () => {
        //전체 체크박스 선택중 체크박스 하나를 풀었을때 "전체" 체크해제
        if ($(".chk-each:checked").length == emlChkEach.length) {
            emlChkAll.prop("checked", true);
        } else {
            emlChkAll.prop("checked", false);
        }
    });

    $('input:radio[name=major]').on('change', function() {
        let text = $(this).parents('label').text();
        $('#majorSelect').text(text);
        $('#majorSelect').removeClass('myclass');
        $('.dropdown2').hide();
    });

    $('input:radio[name=Grade]').on('change', function() {
        let text = $(this).parents('label').text();
        $('#selectGrade').text(text);
        $('#selectGrade').removeClass('myclass');
        $('.dropdown2').hide();
    })
    $('input:radio[name=Class]').on('change', function() {
        let text = $(this).parents('label').text();
        $('#selectClass').text(text);
        $('#selectClass').removeClass('myclass');
        $('.dropdown2').hide();
    })
    $('input:radio[name=Number]').on('change', function() {
        let text = $(this).parents('label').text();
        $('#selectNum').text(text);
        $('#selectNum').removeClass('myclass');
        $('.dropdown2').hide();
    })
</script>

</html>