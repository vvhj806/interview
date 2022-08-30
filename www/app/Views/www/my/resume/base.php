<!--s #scontent-->
<div id="scontent" data-idx="<?= $data['rIdx'] ?>">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">기본정보</div>
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
                <div class="img"><img src="<?= isset($data['postData']['base']['file_save_name']) ?  $data['url']['media'] . $data['postData']['base']['file_save_name'] : "/static/www/img/sub/prf_no_img.jpg"  ?>" id="changeImg"></div>
            </div>
            <!--e ai_rpv_imgBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/base" method="POST" id="next_form">
        <input type="file" accept="image/*" id="profileFile2" name="profileFile2" data-filebox="#changeImg" style="display:none">
        <input type="hidden" name="profileFile" id="profileFile">
        <input type="hidden" name="file_save_name" id="file_save_name" value="<?= $data['postData']['base']['file_save_name'] ?? '' ?>">
        <input type="hidden" name="fileSize" id="fileSize">
        <input type="hidden" name="fileIdx" id="fileIdx" value="<?= $data['postData']['base']['fileIdx'] ?? '' ?>">

        <!--s cont-->
        <div class="cont cont_pd_bottom">
            <!--s inp_dlBox-->
            <div class="inp_dlBox">
                <dl class="inp_dl">
                    <dt>이름</dt>
                    <dd>
                        <input type="text" maxlength="10" class="wps_100" value="<?= $data['member']['mem_name']  ?>" disabled>
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>나이</dt>
                    <dd>
                        <input type="number" class="wps_100" value="<?= $data['member']['mem_age']  ?>" maxlength="3" disabled>
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>전화번호</dt>
                    <dd>
                        <input type="tel" class="wps_100" value="<?= $data['member']['mem_tel'] ?>" disabled>
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>이메일</dt>
                    <dd>
                        <input type="text" class="wps_100" value="<?= $data['member']['mem_email'] ?>" disabled>
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>성별</dt>
                    <dd>
                        <!--s position_ckBox-->
                        <div class="position_ckBox fl_wd2">
                            <ul>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bGender1" name="bGender" value='M' <?= ($data['postData']['base']['bGender'] ?? $data['member']['mem_gender']) == 'M' ? 'checked' : "" ?>>
                                        <label for="bGender1">남</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bGender2" name="bGender" value='W' <?= ($data['postData']['base']['bGender'] ?? $data['member']['mem_gender']) == 'W' ? 'checked' : "" ?>>
                                        <label for="bGender2">여</label>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!--e position_ckBox-->
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>보훈대상</dt>
                    <dd>
                        <!--s position_ckBox-->
                        <div class="position_ckBox fl_wd2">
                            <ul>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bBohun1" name="bBohun" value='Y' <?= ($data['postData']['base']['bBohun'] ?? '') == 'Y' ? 'checked' : "" ?>>
                                        <label for="bBohun1">Y</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bBohun2" name="bBohun" value='N' <?= ($data['postData']['base']['bBohun'] ?? '') == 'N' ? 'checked' : "" ?>>
                                        <label for="bBohun2">N</label>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!--e position_ckBox-->
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>병역대상</dt>
                    <dd>
                        <!--s position_ckBox-->
                        <div class="position_ckBox fl_wd2">
                            <ul>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bMilitaryType1" name="bMilitaryType" value='군필' <?= ($data['postData']['base']['bMilitaryType'] ?? '') == '군필' ? 'checked' : "" ?>>
                                        <label for="bMilitaryType1">군필</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bMilitaryType2" name="bMilitaryType" value='미필' <?= ($data['postData']['base']['bMilitaryType'] ?? '') == '미필' ? 'checked' : "" ?>>
                                        <label for="bMilitaryType2">미필</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bMilitaryType3" name="bMilitaryType" value='면제' <?= ($data['postData']['base']['bMilitaryType'] ?? '') == '면제' ? 'checked' : "" ?>>
                                        <label for="bMilitaryType3">면제</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="ck_radio">
                                        <input type="radio" id="bMilitaryType4" name="bMilitaryType" value='복무중' <?= ($data['postData']['base']['bMilitaryType'] ?? '') == '복무중' ? 'checked' : "" ?>>
                                        <label for="bMilitaryType4">복무중</label>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <!--e position_ckBox-->
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>복무 일자</dt>
                    <dd>
                        <div class="wd50Box2">
                            <input type="month" name="bMilitaryStartDate" value="" placeholder="복무시작일(ex:199901)">
                            <input type="month" name="bMilitaryEndDate" value="" placeholder="복무종료일(ex:199901)">
                        </div>
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>우편번호</dt>
                    <dd>
                        <div class="wd50Box">
                            <input type="text" name="input_postcode" id="input_postcode" class="wd50Box_inp" placeholder="" value="<?= $data['postData']['base']['input_postcode'] ?? $data['member']['mem_address_postcode'] ?>">
                            <a href="javascript:void(0)" class="dnBtn" id="searchAddr">주소 검색</a>
                        </div>
                        <div id="addressLayer"></div>

                        <input type="text" name="input_address" id="input_address" class="wps_100" placeholder="" value="<?= $data['postData']['base']['input_address'] ?? $data['member']['mem_address'] ?>">
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>상세주소</dt>
                    <dd>
                        <input type="text" name="input_detailAddress" id="input_detailAddress" class="wps_100" placeholder="" value="<?= $data['postData']['base']['input_detailAddress'] ?? $data['member']['mem_address_detail'] ?>">
                        <div class="data_txt gray">상세주소는 공개되지 않아요 !</div>
                    </dd>
                </dl>
                <dl class="inp_dl">
                    <dt>
                        <div class="stltBox">
                            <div class=" fl">경력기술서</div>
                            <div class="stlt_stxt fr"><?= isset($data['postData']['base']['careerProfile']) ? strlen($data['postData']['base']['careerProfile']) : '0' ?>자</div>
                        </div>
                    </dt>
                    <dd>
                        <div class="mg_b40">
                            <textarea name="careerProfile" id="stltText" placeholder=" 내용을 입력해 주세요"><?= $data['postData']['base']['careerProfile'] ?? '' ?></textarea>
                        </div>
                    </dd>
                </dl>
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
                <a href="/my/resume/profile/<?= $data['rIdx'] ?>" class="btn btn02 wps_100 mg_b10">지금 촬영하기</a>
                <a href="javascript:void(0)" id="albumSelect" class="btn btn02 wps_100 mg_b10">앨범에서 선택</a>

            </div>
            <!--e BtnBox-->
        </div>
        <!--e pop_cont-->
    </div>
    <!--e pop_Box-->
</div>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<!--e 프로필 모달-->
<script>
    $("#next_form").validate({
        ignore: [],
        rules: {
            // bName: {
            //     required: true
            // },
            // bBirth: {
            //     required: true
            // },
            // bTel: {
            //     required: true,
            //     // regex: "^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$",
            // },
            // bEmail: {
            //     required: true,
            //     email: true
            // },
        },
        messages: {
            // bName: {
            //     required: "이름을 입력해 주세요."
            // },
            // bBirth: {
            //     required: "나이를 입력해 주세요."
            // },
            // bTel: {
            //     required: "전화번호를 입력해 주세요.",
            //     // regex: "전화번호 형식에 맞지 않습니다."
            // },
            // bEmail: {
            //     required: "이메일을 입력해 주세요.",
            //     email: "이메일 형식에 맞지 않습니다."
            // },
        },
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때
            form.submit();
        }
    });

    $("#submitData").on('click', function() {
        //유효성 검사
        // if ($('input[name="bName"]').val() == "" || $('input[name="bName"]').val() == null) {
        //     alert('이름을 작성해주세요.');
        //     return;
        // }

        //const file = $('#profileFile').prop('files');

        if (filesArr[0] == null || filesArr[0] == "") {

            $('#next_form').submit();
        } else {
            var fileDataName = new Array();
            var fileDataSize = new Array();
            //socket 통신시 file buffer가 전달되어 name, size 등을 알수없어 전달
            for (let i = 0; i < filesArr.length; i++) {
                fileDataName[i] = filesArr[i].name;
                fileDataSize[i] = filesArr[i].size;
            };

            const data = {
                type: "Y", //첨부파일인지 생성파일인지 여부 - default : N
                page: "resumeprofile", //사용 page(page에 따라 조건이 다른경우) - default : upload
                path: "resumeprofile", //file upload 경로(/data/webtest/uploads/아래) - 없는 경우 생성 - defult : dummy
                source: filesArr, //file data
                multi: "N", //file multiple인지 여부(video?) - defult : N
                idx: $("#scontent").data('idx'), //기능 idx
                name: fileDataName,
                size: fileDataSize
            };
            socket.emit('upload', data);
        }

        //$('#next_form').submit();
    })




    $('#albumSelect').on('click', function() {
        $('#profileFile2').click();
    });

    function fileHtml(selecter, file, fileNo) {

        const reader = new FileReader()
        reader.onload = e => {
            $("#changeImg").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
        fnHidePop('profile_pop');
    }


    //첨부파일 upload 후 처리
    socket.on('complete', (data) => {
        console.log('complete');

        $('#profileFile').val(data[0].real_name + '.' + data[0].fileExtension);
        $('#file_save_name').val(data[0].filePath.substr(1));
        $('#fileSize').val(data[0].size);

        $('#next_form').submit();
    });

    $('#stltText').on('keyup', function(e) {
        let content = $(this).val(); // 글자수 세기 
        if (content.length == 0 || content == '') {
            $('.stlt_stxt').text('0자');
        } else {
            $('.stlt_stxt').text(content.length + '자');
        }

    });
</script>

<script>
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
                    //document.getElementById("input_extraAddress").value = extraAddr;

                } else {
                    //document.getElementById("input_extraAddress").value = '';
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
</script>