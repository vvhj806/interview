<?php
isset($data['get']['fileIdx']) ? $data['get']['fileIdx'] : $data['get']['fileIdx'] = "";
// isset($data['file_save_name']) ? $data['file_save_name'] : $data['file_save_name']="/static/www/img/sub/prf_no_img.jpg";

// print_r($data['file']);
// return;
?>
<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/main">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">내 정보 수정하기</div>
            <a href="resetPwd" class="top_gray_txtlink gray_txtlink">비밀번호변경</a>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t20 c">
        <!--s contBox-->
        <div class="contBox">
            <!--s ai_rpv_imgBox-->
            <div class="ai_rpv_imgBox">
                <a href="javascript:void(0)" onclick="fnShowPop('profile_pop')">
                    <div class="camera_icon" style="z-index:1"><img src="/static/www/img/sub/ai_rpv_camera_icon.png"></div>
                </a>
                <div class="img"><img src="<?= $data['file']['file_save_name'] ?>" id="changeImg" style="object-fit: cover; height:100%"></div>
            </div>
            <!--e ai_rpv_imgBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <form action="/my/modifyAction" method="POST" id="modifyData">
        <input type="hidden" name="postCase" id="postCase" value="Mymodify">
        <input type="hidden" name="backUrl" id="backUrl" value="/my/main">
        <input type="hidden" name="profileIdx" id="profileIdx" value="<?= $data['get']['fileIdx'] ?>">
        <input type="file" accept="image/*" id="profileFile" name="profileFile" style="display:none">
        <input type="hidden" name="filePath" id="filePath">
        <input type="hidden" name="fileSize" id="fileSize">
        <!--s cont-->
        <div class="cont">
            <!--s inp_dlBox-->
            <div class="inp_dlBox">
                <dl class="inp_dl">
                    <dt>이름</dt>
                    <dd><input type="text" name="loginName" maxlength="10" class="wps_100" placeholder="정확한 정보 제공을 위해 실명을 권장합니다." value="<?= $data['member']['mem_name']  ?>"></dd>
                </dl>

                <dl class="inp_dl">
                    <dt>이메일</dt>
                    <dd>
                        <input type="text" name="loginId" id="loginId" class="wps_100" placeholder="example@highbuff.com" value="<?= $data['member']['mem_id']  ?>" disabled>
                        <div class="data_txt"><?= $data['loginType'] ?></div>
                    </dd>
                </dl>

                <dl class="inp_dl">
                    <dt>연락처</dt>
                    <dd>
                        <div class="wd50Box">
                            <input type="tel" name="ModifyPhone" maxlength="11" class="wd50Box_inp" placeholder="숫자만 입력" value="<?= $data['member']['mem_tel']  ?>">
                            <a href="javascript:;" id="getAuth" class="dnBtn">인증번호 받기</a>
                        </div>

                        <div id="authNumber" class="wd50Box hide">
                            <input type="hidden" name="telchk">
                            <input type="text" id="chkAuthInputTel" name="chkAuthInputTel" class="wd50Box_inp" placeholder="인증번호 입력" disabled>
                            <a href="javascript:;" id="chkAuth" class="dnBtn">인증하기</a>
                        </div>
                        <div id="authText" class="data_txt hide">유효시간 <span id="authTimer"></span></div>
                    </dd>
                </dl>

                <dl class="inp_dl">
                    <dt>나이</dt>
                    <dd><input type="number" name="ModifyAge" id="ModifyAge" class="wps_100" maxlength="3" placeholder="" value="<?= $data['member']['mem_age'] ?>"></dd>
                </dl>

                <dl class="inp_dl">
                    <dt>우편번호</dt>
                    <dd>
                        <div class="wd50Box">
                            <input type="hidden" id="input_extraAddress" name="input_extraAddress" value="" />
                            <input type="text" name="input_postcode" id="input_postcode" class="wd50Box_inp" placeholder="" value="<?= $data['member']['mem_address_postcode'] ?>">
                            <a href="javascript:void(0)" class="dnBtn" id="searchAddr">주소 검색</a>
                        </div>
                        <div id="addressLayer"></div>

                        <input type="text" name="input_address" id="input_address" class="wps_100" placeholder="" value="<?= $data['member']['mem_address'] ?>">
                    </dd>
                </dl>

                <dl class="inp_dl">
                    <dt>상세주소</dt>
                    <dd>
                        <input type="text" name="input_detailAddress" id="input_detailAddress" class="wps_100" placeholder="" value="<?= $data['member']['mem_address_detail'] ?>">
                        <div class="data_txt gray">상세주소는 공개되지 않아요 !</div>
                    </dd>
                </dl>

                <?php
                if ($data['wantCate'] == 0) { ?>
                    <!--s 밑에 항목3개 선택 안했을때-->
                    <div class="itv_pr_grayBox c">
                        <div class="font23 mg_b10 black">어떤 포지션에서 일하고 싶나요 ?</div>
                        <a href="/my/interest/main" class="point">내 관심사 입력하러 가기 <i class="la la-angle-right"></i></a>
                    </div>
                    <!--e 밑에 항목3개 선택 안했을때-->
                <?php } else { ?>

                    <dl class="inp_dl">
                        <dt class="overflow">
                            <div class="fl">관심 직무</div>
                            <div class="fr"><a href="/my/interest/main" class="a_line gray font20">수정하기</a></div>
                        </dt>
                        <dd>
                            <div class="etcBox">
                                <?php foreach ($data['category'] as $key => $val) :
                                    if ($key == 0) :
                                        echo $val['job_depth_text'];
                                    else :
                                        echo " / " . $val['job_depth_text'];
                                ?>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </div>
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>관심 지역</dt>
                        <dd>
                            <div class="etcBox">
                                <?php foreach ($data['kor'] as $key => $val) {
                                    if ($key == 0) {
                                        echo $val['area_depth_text_1'];
                                    } else {
                                        echo " / " . $val['area_depth_text_1'];
                                    }
                                }
                                ?>
                            </div>
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>희망 연봉</dt>
                        <dd>
                            <div class="etcBox"><?= $data['member']['mem_pay'] === '1억이상' ? $data['member']['mem_pay'] : "{$data['member']['mem_pay']} 만원"  ?></div>
                        </dd>
                    </dl>
                <?php } ?>
                <?php //} 
                ?>
            </div>
            <!--e inp_dlBox-->
            <?= csrf_field() ?>

            <!--s BtnBox-->
            <div class="BtnBox">
                <button id="submitData" type="button" class="btn btn01 wps_100">저장</button>
            </div>
    </form>
    <!--e BtnBox-->
</div>
<!--e cont-->
</div>
<!--e #scontent-->

<!--s 프로필 모달-->
<div id="profile_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont md_pop_content">
            <!--s spop_tltBox-->
            <div class="spop_tltBox mg_b15">
                <div class="spop_tlt">프로필 사진변경</div>
                <a href="javascript:void(0)" class="spop_close_btn" onclick="fnHidePop('profile_pop')"><img src="/static/www/img/sub/login_close.png"></a><!-- onclick 누르면 닫히 -->
            </div>
            <!--e spop_tltBox-->

            <!--s BtnBox-->
            <div class="BtnBox mg_t0">
                <a href="/my/profile" class="btn btn02 wps_100 mg_b10">지금 촬영하기</a>
                <a href="javascript:void(0)" id="albumSelect" class="btn btn02 wps_100 mg_b10">앨범에서 선택</a>
                <!-- <a href="/my/exist" class="btn btn02 wps_100 mg_b10">기존 프로필에서 선택</a> -->
            </div>
            <!--e BtnBox-->
        </div>
        <!--e pop_cont-->
    </div>
    <!--e pop_Box-->
</div>
<!--e 프로필 모달-->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://cdn.socket.io/4.2.0/socket.io.min.js" integrity="sha384-PiBR5S00EtOj2Lto9Uu81cmoyZqR57XcOna1oAuVuIEjzj0wpqDVfD0JA9eXlRsj" crossorigin="anonymous"></script>
<script>
    try {
        initSocket();
    } catch (error) {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $.ajax({ //db에 에러로그 쌓고 텔레그램 보내는 ajax
            type: 'POST',
            url: '/api/error/page/modify/add',
            data: {
                '<?= csrf_token() ?>': emlCsrf.val(),
                errorTxt: error,
                pullPage: '/Views/my/modify',
            },
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    alert("서버 연결에 실패하였습니다. 잠시후에 시도해주세요. \n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");

                    location.reload();
                } else {
                    alert(data.messages);
                    return false;
                }
                return true;
            },
            error: function(e) {
                console.log(e);
                alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                return;
            }
        }) //ajax;
    }
    var authNum = '';
    $('#getAuth').on("click", () => {
        let aParams = [];
        aParams['telBox'] = $('input[name="ModifyPhone"]').val();
        aParams['emlTelChk'] = $('#chkAuthInputTel');
        aParams['emlCsrf'] = $("input[name='csrf_highbuff']");
        aParams['type'] = 'getAuth';

        if (!$("#authNumber").hasClass("hide")) {
            aParams['emlTelChk'].focus();
            alert('인증번호를 입력해 주세요.');
            return false;
        }

        if (!aParams['telBox']) {
            alert('전화번호를 입력해 주세요.');
            return false;
        } else {
            if (aParams['telBox'] == "<?= $data['member']['mem_tel'] ?>") {
                alert('전화번호가 같습니다.');
                return false;
            }
        }

        const regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
        if (!regPhone.test(aParams['telBox'])) {
            alert('잘못된 전화번호 입니다.');
            return false;
        }
        getAjax('auth', aParams);
    });

    $('#chkAuth').on("click", () => {
        let aParams = [];
        aParams['telBox'] = $('input[name="ModifyPhone"]').val();
        aParams['emlTelChk'] = $('#chkAuthInputTel');
        aParams['authBox'] = $('#chkAuthInputTel').val();
        aParams['emlCsrf'] = $("input[name='csrf_highbuff']");
        aParams['type'] = 'chkAuth';
        if (!aParams['telBox']) {
            alert('전화번호를 입력해 주세요.');
            return false;
        }

        if (!aParams['authBox']) {
            alert('인증번호를 입력해 주세요.');
            return false;
        }

        const regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
        if (!regPhone.test(aParams['telBox'])) {
            alert('잘못된 전화번호 입니다.');
            return false;
        }
        // console.log(aParams);
        getAjax('chkAuth', aParams);
    });

    function startTimer(duration, emlAuthTimer) {
        let timer = duration
        let minutes, seconds;
        let interval = setInterval(() => {
            if (minutes == 0 && seconds == 0) {
                clearInterval(interval);
            } else {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                emlAuthTimer.text(minutes + ":" + seconds);

                if (--timer < 0) {
                    timer = duration;
                }
            }
        }, 1000);
    }

    function getAjax(type, params) {
        let strUrl = '';
        let objData = {};
        if (params['type'] == 'getAuth') {
            strUrl = "/api/auth/tel";
            objData = {
                'phone': params['telBox'],
                'type': 'M',
                '<?= csrf_token() ?>': params['emlCsrf'].val(),
            };
        } else if (params['type'] == 'chkAuth') {
            strUrl = `/api/auth/tel/modify/${params['telBox']}/${params['authBox']}`;
            objData = {
                '<?= csrf_token() ?>': params['emlCsrf'].val(),
                'authNum': authNum,
            };
        } else {
            alert('잘못된 접근 입니다.');
            return false;
        }

        $.ajax({
            async: false,
            type: 'post',
            url: strUrl,
            dataType: "json",
            cache: false,
            data: objData,
            success: function(res) {
                if (res.code.stat || res.code.stat == 'success') {
                    params['emlCsrf'].val(res.code.token);
                    if (params['type'] == 'getAuth') {
                        const timerMinutes = 60 * 3;
                        const emlAuthTimer = $('#authTimer');
                        startTimer(timerMinutes, emlAuthTimer);
                        params['emlTelChk'].removeAttr("disabled");
                        $('#authNumber,#authText').removeClass('hide');
                        authNum = res.code.iCertNumber;
                    } else if (params['type'] == 'chkAuth') {
                        $('#authNumber').addClass('hide');
                        $('#authNumber').addClass('hide');
                        $('input[name="telchk"]').val(params['authBox']);
                        $("#authText").html('<i class="la la-check"></i> 인증완료');
                    }
                    alert(res.messages);
                }
            },
            error: function(e) {
                params['emlCsrf'].val(e.responseJSON.code.token);
                alert(e.responseJSON.messages);
            },
        }); //end ajax
    } // end getAjax()

    $("#submitData").on('click', function() {
        if ($('input[name="ModifyPhone"]').val() == "" || $('input[name="ModifyPhone"]').val() == null) {
            alert('연락처를 작성해주세요.');
            return;
        } else {
            if ($('input[name="ModifyPhone"]').val() != "<?= $data['member']['mem_tel'] ?>") {
                if ($('#authText').text().replace(/ /g, "") != "인증완료") {
                    alert('연락처를 인증해주세요.');
                    return;
                }
            }
        }

        if ($('input[name="loginName"]').val() == "" || $('input[name="loginName"]').val() == null) {
            alert('이름을 작성해주세요.');
            return;
        }

        if ($('input[name="ModifyAge"]').val() == "" || $('input[name="ModifyAge"]').val() == null) {
            alert('생년월일을 작성해주세요.');
            return;
        }

        if ($('input[name="input_postcode"]').val() == "" || $('input[name="input_postcode"]').val() == null) {
            alert('우편번호를 작성해주세요.');
            return;
        }

        if ($('input[name="input_address"]').val() == "" || $('input[name="input_address"]').val() == null) {
            alert('주소를 작성해주세요.');
            return;
        }
        const file = $('#profileFile').prop('files');

        if (file[0] == null || file[0] == "") {
            $('#modifyData').submit();
        } else {
            const filename = getFileName('mypage', 'png');

            const data = {
                source: file[0],
                name: filename,
                size: file[0].size,
            };

            socket.emit('thumbnail', data);
        }

        //$('#modifyData').submit();
    })

    $('#searchAddr').on('click', function() {
        search_addr();
    });
    // 우편번호 찾기 화면을 넣을 element
    let element_layer = document.getElementById('addressLayer');

    function search_addr() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if (data.userSelectedType === 'R') {
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if (data.buildingName !== '' && data.apartment === 'Y') {
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if (extraAddr !== '') {
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("input_extraAddress").value = extraAddr;

                } else {
                    document.getElementById("input_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('input_postcode').value = data.zonecode;
                document.getElementById("input_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("input_detailAddress").focus();

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width: '100%',
            height: '100%',
            maxSuggestItems: 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition() {
        var width = '100%'; //우편번호서비스가 들어갈 element의 width
        var height = 400; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 8; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = ''; //값을 넣으니 너비가 이상해져서 제거
        element_layer.style.height = height + 'px';
        //element_layer.style.border = borderWidth + 'px solid #afafaf';
        element_layer.style.marginBottom = '10px';

        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        //element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
        //element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
    }

    $('#albumSelect').on('click', function() {
        $('#profileFile').click();
    });

    $('#profileFile').on('change', function() {
        const file = $('#profileFile').prop('files');

        const reader = new FileReader()
        reader.onload = e => {
            const previewImage = document.getElementById("changeImg")
            previewImage.src = e.target.result
        }

        reader.readAsDataURL(file[0]);
        fnHidePop('profile_pop');

    });

    function getFileName(fields, fileExtension) {
        let d = new Date();
        let index = "<?= $data['member']['idx'] ?>";
        let rand = Math.random().toString(36).substr(2, 11);
        let times = d.getTime();
        return index + "-" + fields + "-" + times + '-' + rand + '.' + fileExtension;
    }

    function initSocket() {
        socket = io.connect('<?= $data['url']['mediaFull'] ?>', {
            cors: {
                origin: '*'
            },
            transports: ["websocket"]
        });

        socket.on('connect', function() {
            console.log("socket connected");
        });

        socket.on('connect_error', function() {
            alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
            return false;
        });

        socket.on('complete_thumb', (data) => {
            $('#filePath').val(data.filePath.substr(1));
            $('#fileSize').val(data.size);

            $('#modifyData').submit();

        });
        socket.on('disconnect', function() {
            alert("서버 연결이 끊어졌습니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
            return false;
        });
    }
</script>