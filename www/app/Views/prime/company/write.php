<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<form id="frm" method="post" action="/prime/company/write/<?= $data['comIdx'] ? "{$data['comIdx']}/" : '' ?>action">
    <input type="hidden" name="memIdx" value="<?= $data['getMemIdx'] ?? '' ?>">
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">기업 정보</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="box">

                        <input type="hidden" name="backUrl" value="/prime/company/write/" />
                        <input type="hidden" name="postCase" value="company_write" />
                        <?= csrf_field() ?>
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>

                                <col>
                            </colgroup>
                            <tbody>
                                <?php if ($data['comIdx'] ?? false) : ?>
                                    <tr>
                                        <th>고유번호</th>
                                        <td>
                                            <?= $data['comIdx'] ?? '' ?>
                                        </td>
                                        <th>등록일</th>
                                        <td>
                                            <?= $data['comList']['comRegDate'] ?? '' ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>사진</th>
                                    <td colspan=3>
                                        <img id="changeImg" src='<?= $data['url']['media'] ?><?= $data['comList']['file_save_name'] ?? '/data/no_img.png' ?>' onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'" style="max-width: 300px;">
                                        <input type="file" accept="image/*" id="thumb" name="profileFile">
                                        <input name="filePath" id="filePath" type="hidden">
                                        <input name="fileSize" id="fileSize" type="hidden">
                                        <input name="fileRealName" id="fileRealName" type="hidden">
                                    </td>

                                </tr>
                                <tr>
                                    <th>기업명</th>
                                    <td>
                                        <span></span>
                                        <input id='' type='text' name='com_name' value='<?= $data['comList']['com_name'] ?? '' ?>'>
                                    </td>
                                    <th>사업자번호</th>
                                    <td>
                                        <input id='' type='text' name='com_reg_number' value='<?= $data['comList']['comRegNum'] ?? '' ?>'>
                                        <button id='chk' type='button'>인증</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>대표자명</th>
                                    <td>
                                        <span></span>
                                        <input id='' type='text' name='com_ceo_name' value='<?= $data['comList']['comCeoName'] ?? '' ?>'>
                                    </td>
                                    <th>직원수</th>
                                    <td><span></span>
                                        <input id='' type='number' name='com_head_count' value='<?= $data['comList']['comHeadCount'] ?? '' ?>'>
                                    </td>

                                </tr>
                                <tr>
                                    <th>설립년도</th>
                                    <td>
                                        <span></span>
                                        <input id='' type='date' name='com_anniversary' value='<?= $data['comList']['comAnniversary'] ?? '' ?>'>
                                    </td>
                                    <th>회사전화번호</th>
                                    <td>
                                        <span></span>
                                        <input id='' type='tel' name='com_tel' value='<?= $data['comList']['comTel'] ?? '' ?>'>
                                    </td>
                                </tr>
                                <tr>
                                    <th>산업군</th>
                                    <td>
                                        <span></span>
                                        <select name='com_industry'>
                                            <option>선택</option>
                                            <?php foreach ($data['companyInfo']['company_group'] as $val) : ?>
                                                <option value='<?= $val ?>' <?= ($data['comList']['com_introduce'] ?? false) === $val ? 'selected' : '' ?>><?= $val ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <th>주소</th>
                                    <td>
                                        <input type="hidden" id="input_extraAddress" name="" value="" />
                                        <input type="text" name="" id="input_postcode" class="wd50Box_inp" placeholder="" value="">

                                        <input type="text" name="com_address" id="input_address" class="wps_100" placeholder="" value="<?= $data['comList']['comAddress'] ?? '' ?>">
                                        <button id='searchAddr' class="btn" type="button">주소 찾기</button>
                                        <div id="addressLayer"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>기업형태</th>
                                    <td >
                                        <span></span>
                                        <select name='com_form'>
                                            <option>선택</option>
                                            <?php foreach ($data['companyInfo']['company_form'] as $val) : ?>
                                                <option value='<?= $val ?>' <?= ($data['comList']['comForm'] ?? false) === $val ? 'selected' : '' ?>><?= $val ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <th>기업태그</th>
                                    <td>
                                        <ul id='tag_ul'>

                                        </ul>
                                        <button id='modal_btn' type='button'>+추가하기</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>인재상</th>
                                    <td colspan=3>
                                        <input type='checkbox' name='injae'>
                                        <label>적극성</label>
                                        <input type='checkbox' name='injae'>
                                        <label>안정성</label>
                                        <input type='checkbox' name='injae'>
                                        <label>신뢰성</label>
                                        <input type='checkbox' name='injae'>
                                        <label>긍정성</label>
                                        <input type='checkbox' name='injae'>
                                        <label>대응성</label>
                                        <input type='checkbox' name='injae'>
                                        <label>의지력</label>
                                        <input type='checkbox' name='injae'>
                                        <label>능동성</label>
                                        <input type='checkbox' name='injae'>
                                        <label>매력도</label>
                                    </td>
                                </tr>

                                <tr>
                                    <th>기업태그</th>
                                    <td>
                                        <ul id='tag_ul'>

                                        </ul>
                                        <button id='modal_btn' type='button'>+추가하기</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>기업소개</th>
                                    <td colspan=3>
                                        <textarea name='com_introduce' placeholder="기업소개"><?= $data['comList']['comIntroduce'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" value="저장" id="submitBtn" class="btn btn-success float-right">

                    </div>
                </div>
                <!-- /.card-body -->

                <?php if ($data['comIdx'] ?? false) : ?>
                    <div class="card-body">
                        <div class="box">
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>
                                    <col style='width:15%;'>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>보낸 제안</th>
                                        <td>총 <?= $data['suggestList']['total'] ?>회 (수락 0 | 거절 0 | 미응답 0)</td>
                                    </tr>
                                    <tr>
                                        <th>A.I. 인터뷰 제안</th>
                                        <td>총 <?= $data['suggestList']['ai'] ?>회 (수락 0 | 거절 0 | 미응답 0)</td>
                                    </tr>
                                    <tr>
                                        <th>대면 면접 제안</th>
                                        <td>총 <?= $data['suggestList']['meet'] ?>회 (수락 0 | 거절 0 | 미응답 0)</td>
                                    </tr>
                                    <tr>
                                        <th>이직 및 포지션 제안</th>
                                        <td>총 <?= $data['suggestList']['position'] ?>회 (수락 0 | 거절 0 | 미응답 0)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="box">
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <thead>
                                    <th class="text-center">전체공고</th>
                                    <th class="text-center">진행중</th>
                                    <th class="text-center">승인 대기중</th>
                                    <th class="text-center">마감</th>
                                    <th class="text-center">승인 거부</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?= $data['recStat']['total'] ?>개</td>
                                        <td class="text-center"><?= $data['recStat']['ing'] ?>개</td>
                                        <td class="text-center"><?= $data['recStat']['wait'] ?>개</td>
                                        <td class="text-center"><?= $data['recStat']['end'] ?>개</td>
                                        <td class="text-center"><?= $data['recStat']['no'] ?>개</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>
                                    <col>
                                </colgroup>
                                <thead>
                                    <th class="text-center">순번</th>
                                    <th class="text-center">공고명</th>
                                    <th class="text-center">고유ID</th>
                                    <th class="text-center">직군/직무</th>
                                    <th class="text-center">지역</th>
                                    <th class="text-center">인터뷰분류</th>
                                    <th class="text-center">접수 마감일</th>
                                    <th class="text-center">상태</th>
                                    <th class="text-center">조회수</th>
                                    <th class="text-center">지원자 수</th>
                                    <th class="text-center">등록일</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['recList'] as $num => $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $num + 1 ?></td>
                                            <td class="text-center"><a href='/prime/recruit/write/<?= $row['recIdx'] ?>'><?= $row['recTitle'] ?></a></td>
                                            <td class="text-center"><?= $row['recIdx'] ?></td>
                                            <td class="text-center"><?= $row['job_depth_text'] ?></td>
                                            <td class="text-center"><?= $row['area_depth_text_1'] . $row['area_depth_text_2'] ?></td>
                                            <td class="text-center"><?= $row['recApply'] ?></td>
                                            <td class="text-center"><?= $row['recEndDate'] ?></td>
                                            <td class="text-center"><?= $row['recStat'] ?></td>
                                            <td class="text-center"><?= $row['recHit'] ?></td>
                                            <td class="text-center"><?= $row['recCnt'] ?></td>
                                            <td class="text-center"><?= $row['recRegDate'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <div id='tag' class='pop_modal'>
        <div class='pop_full'>
            <div class='pop_con'>
                <div>질문<button type='button' onclick="$('#tag').removeClass('on')">닫기</button></div>
                <ul>
                    <?php foreach ($data['tagCategory'] as $val) : ?>
                        <li>
                            <div class="ck_radio">
                                <input id="T<?= $val['idx'] ?>" type="checkbox" name="comTag[]" value='<?= $val['idx'] ?>' <?= in_array($val['idx'], $data['comList']['comTag'] ?? []) ? 'checked' : '' ?>>
                                <label for="T<?= $val['idx'] ?>">#<?= $val['tag_txt'] ?></label>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type='button'>[<span id='tagLeng'>0</span>]개 선택완료</button>
            </div>
        </div>
    </div>
</form>
<!-- socket io -->
<script src="<?= $data['url']['menu'] ?>/plugins/socketio/socket.io.min.js"></script>
<script src="<?= $data['url']['menu'] ?>/plugins/socketio/socketio_custom.js"></script>
<script>
    let fileDataName = new Array();
    let fileDataSize = new Array();


    $("#frm").validate({
        ignore: [],
        rules: {
            com_name: {
                required: true,
            },
            com_reg_number: {
                required: true,
            },
            com_ceo_name: {
                required: true,
            },
            com_head_count: {
                required: true,
            },
            com_anniversary: {
                required: true,
                date: true
            },
            com_industry: {
                required: true,
            },
            com_form: {
                required: true,
            },
        },
        messages: {
            com_name: {
                required: "기업명을 입력해 주세요.",
            },
            com_reg_number: {
                required: "사업자번호를 입력해 주세요.",
            },
            com_ceo_name: {
                required: "대표자명을 입력해 주세요.",
            },
            com_head_count: {
                required: "직원수를 입력해 주세요.",
            },
            com_anniversary: {
                required: "설립년도를 입력해 주세요.",
                date: "날짜형식"
            },
            com_industry: {
                required: "산업군을 입력해 주세요.",
            },
            com_form: {
                required: "기업형태를 입력해 주세요.",
            },
        },
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때

            form.submit();
        }
    });

    $(document).ready(function() {
        tagChk();
        $('input[name="comTag[]"]:checked').each(function() {
            const thisValue = $(this).val();
            const thisLabel = $(this).next('label').text();
            $('#tag_ul').append(`<li id='fakeT${thisValue}'>${thisLabel} <label for=T${thisValue}>삭제</lable></li>`);
        });


    });

    $('#submitBtn').on('click', function() {
        const file = $('#thumb').prop('files');
        if (file.length > 0) {
            //socket 통신시 file buffer가 전달되어 name, size 등을 알수없어 전달
            for (let i = 0; i < file.length; i++) {
                fileDataName[i] = file[i].name;
                fileDataSize[i] = file[i].size;
            };

            const data = {
                type: "Y", //첨부파일인지 생성파일인지 여부 - default : N
                page: "resume", //사용 page(page에 따라 조건이 다른경우) - default : upload
                path: "company", //file upload 경로(/data/webtest/uploads/아래) - 없는 경우 생성 - defult : dummy
                source: file, //file data
                multi: "N", //file multiple인지 여부(video?) - defult : N file이 한개 이면 N 
                idx: '<?= $data['getMemIdx'] ?>', //기능 idx 기업회원 idx 넣기
                name: fileDataName, //file name - file data에서 전달되지않아 따로 전달
                size: fileDataSize, //file size - file data에서 전달되지않아 따로 전달
                linktype: "", //file upload 후 처리 link가 다른경우
            };
            console.log(data);
            socket.emit('upload', data);
        } else {
            $('#frm').submit();
        }
    })
    //첨부파일 upload 후 처리
    socket.on('complete', (data) => {
        // console.log(data);
        // $('#filePath').val()
        $('#frm').submit();
    });

    $('input[name="comTag[]"]').on('change', function() {
        tagChk();
        const thisValue = $(this).val();
        const thisLabel = $(this).next('label').text();
        if ($(this).is(':checked')) {
            $('#tag_ul').append(`<li id='fakeT${thisValue}'>${thisLabel} <label for=T${thisValue}>삭제</lable></li>`);
        } else {
            $(`#fakeT${thisValue}`).remove();
        }
    });

    function tagChk(chk = false) {
        const iTagLength = $('input[name="comTag[]"]:checked').length;
        $('#tagLeng').text(iTagLength);
    }

    $('#modal_btn').on('click', function() {
        const modal = $('#tag');
        modal.addClass('on');
    })

    $('#chk').on('click', function() {
        comReg($('input[name="com_reg_number"]').val());
    });

    function comReg(comReg) {
        let objData = {
            "b_no": [comReg]
        };

        $.ajax({
            url: "https://api.odcloud.kr/api/nts-businessman/v1/status?serviceKey=<?= $data['comRegApiKey'] ?>",
            type: "POST",
            data: JSON.stringify(objData), // json 을 string으로 변환하여 전송
            dataType: "JSON",
            contentType: "application/json",
            accept: "application/json",
            success: function(result) {
                console.log(result);
            },
            error: function(result) {
                console.log(result.responseText); //responseText의 에러메세지 확인
            }
        });
    }

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

    $('#thumb').on('input', function() {
        const file = $('#thumb').prop('files');
        const reader = new FileReader()
        reader.onload = e => {
            const previewImage = document.getElementById("changeImg")
            previewImage.src = e.target.result
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(file[0]);
        }
    });
    // if (filesArr.length > 0) {
    //         //socket 통신시 file buffer가 전달되어 name, size 등을 알수없어 전달
    //         for (let i = 0; i < filesArr.length; i++) {
    //             fileDataName[i] = filesArr[i].name;
    //             fileDataSize[i] = filesArr[i].size;
    //         };

    //         const data = {
    //             type: "Y", //첨부파일인지 생성파일인지 여부 - default : N
    //             page: "resume", //사용 page(page에 따라 조건이 다른경우) - default : upload
    //             path: "resume", //file upload 경로(/data/webtest/uploads/아래) - 없는 경우 생성 - defult : dummy
    //             source: filesArr, //file data
    //             multi: "Y", //file multiple인지 여부(video?) - defult : N
    //             idx: $("#scontent").data('idx'), //기능 idx
    //             name: fileDataName, //file name - file data에서 전달되지않아 따로 전달
    //             size: fileDataSize, //file size - file data에서 전달되지않아 따로 전달
    //             linktype: linktype, //file upload 후 처리 link가 다른경우
    //         };
    //         socket.emit('upload', data);
    //     }
</script>