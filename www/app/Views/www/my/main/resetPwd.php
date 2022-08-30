<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/main">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">비밀번호 변경</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->
    <!--s cont-->
    <div class="cont">
        <form id="frm" method="POST" action="/my/resetPwdAction" onsubmit="return false;">
            <?= csrf_field() ?>

            <!--s inp_dlBox-->
            <div class="inp_dlBox">
                <dl class="inp_dl">
                    <dt>새비밀번호</dt>
                    <dd><input type="password" name="newpassword" class="wps_100" maxlength="20" placeholder="새비밀번호"></dd>
                </dl>
                <dl class="inp_dl">
                    <dt>비밀번호 확인</dt>
                    <dd><input type="password" name="repassword" class="wps_100" maxlength="20" placeholder="비밀번호 확인"></dd>
                </dl>

            </div>
            <!--s BtnBox-->
            <div class="BtnBox">
                <button type="submit" class="btn btn01 Btn_off wps_100">완료</button>
                <!--on 일때 Btn_off 클래스 없애주세요-->
            </div>
            <!--e BtnBox-->

        </form>
    </div>
    <script>
        // let inputMustName = {

        //     'newpassword': {
        //         'msg': '비밀번호는 필수 입니다.'
        //     },
        //     'repassword': {
        //         'msg': '비밀번호는 확인은 필수 입니다.'
        //     },
        // };

        // $("form").on("submit", function(event) {
        //     event.preventDefault();
        //     let msg = [];
        //     let ck = false;
        //     let data = {};
        //     let telBox = $('input[name="newpassword"]').val().trim();
        //     let retelBox = $('input[name="repassword"]').val().trim();

        //     $.each(inputMustName, function(k, v) {
        //         if (!$('input[name="' + k + '"]').val() && msg.length == 0) {
        //             msg.push(v.msg);
        //             ck = true;
        //         } else {
        //             data[k] = $('input[name="' + k + '"]').val();
        //         }
        //     });
        //     if (ck) {
        //         alert(msg);
        //         return;
        //     }

        //     if (telBox != retelBox) {
        //         alert("재확인 비밀번호가 맞지 않습니다.");
        //         return;
        //     }

        //     this.submit();

        // });

        $.validator.addMethod("passwordCk", function(value, element) {
            return this.optional(element) || /^.*(?=.*\d)(?=.*[a-zA-Z]).*$/.test(value);
        });

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

        $("#frm").validate({
            ignore: [],
            rules: {
                newpassword: {
                    required: true,
                    minlength: 8,
                    passwordCk: true
                },
                repassword: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                newpassword: {
                    required: "비밀번호는 필수 입력입니다.",
                    minlength: "비밀번호는 8자리 이상 사용 가능합니다.",
                    passwordCk: "비밀번호는 최소 하나의 문자, 하나의 숫자를 포함시켜주세요",
                },
                repassword: {
                    required: "비밀번호 확인은 필수 입력입니다.",
                    equalTo: '비밀번호가 일치하지 않습니다',
                },
            },
            submitHandler: function(form) {
                // form 전송 이외에 ajax등 어떤 동작이 필요할 때
                form.submit();
            }
        });
    </script>