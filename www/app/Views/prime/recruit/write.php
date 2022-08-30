<div class="row">
    <div class="col-12">
        <div class="content_title">
            <h3>새 공고 업로드</h3>
        </div>
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <form method="get" id="frm2" target="_self">
                <div class="sch_inp_borderBox">
                    <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
                    <input name="searchText" class='search_input searchBar' type="text" value="<?= $data['searchTxt'] ?? '' ?>" placeholder="기업명, 사업자번호, 대표 이름으로 검색하세요." style="width:80%">
                    <button type='button' id="searchBtn" class="refresh_btn searchBtn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
                </div>
            </form>
            <form method="post" id="frm" action="/prime/recruit/write/<?= $data['recIdx'] ? "{$data['recIdx']}/" : '' ?>action">
                <input type="hidden" name="filePath" id="filePath">
                <input type="hidden" name="fileSize" id="fileSize">
                <?= csrf_field() ?>
                <div class="card-header">

                    <?php if ($data['comList'] ?? false) : ?>
                        <select name='com_idx'>
                            <option value="" selected>기업을 선택해주세요.</option>
                            <?php foreach ($data['comList'] as $val) : ?>
                                <option value='<?= $val['comIdx'] ?>'><?= $val['comName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
                <!-- /.card-header -->
                <div class="card-body main">
                    <div class="box">
                        <!-- <input type="hidden" name="idx" value=""> -->
                        <!-- <input type="hidden" name="postCase" value="qna_write"> -->
                        <input type="hidden" name="backUrl" value="/prime/recruit/write/">
                        <!-- <input type="hidden" name="adminIdx" value=""> -->

                        <h4>기본정보</h4>

                        <table class="table">
                            <colgroup>
                                <col style="width:50%">
                                <col style="width:50%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        <label for='title'>공고 제목</label>
                                        <div><input id='title' name='rec_title' type="text" style="width:50%;" value='<?= $data['recList']['rec_title'] ?? '' ?>' required></div>
                                    </td>
                                    <td>
                                        <label>고용형태</label>
                                        <!-- <div class="position_ckBox fl_wd2">
                                            <input id='workTypeFullTime' name='rec_work_type[]' type='checkbox' value='0' <?= in_array(0, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                            <label for='workTypeFullTime' class="width50">정규직</label>

                                            <input id='workTypehalfTime' name='rec_work_type[]' type='checkbox' value='1' <?= in_array(1, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                            <label for="workTypehalfTime" class="width50">계약직</label>

                                            <input id='workTypeintern' name='rec_work_type[]' type='checkbox' value='3' <?= in_array(3, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                            <label for="workTypeintern" class="width50">인턴직</label>

                                            <input id='workTypeForeign' name='rec_work_type[]' type='checkbox' value='5' <?= in_array(5, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                            <label for="workTypeForeign" class="width50">해외취업</label>
                                        </div> -->

                                        <div style="display: flex;">
                                            <div class="position_ckBox fl_wd2 mg_r5">
                                                <input id='workTypeFullTime' name='rec_work_type[]' type='checkbox' value='0' <?= in_array(0, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                                <label for='workTypeFullTime'>정규직</label>
                                            </div>
                                            <div class="position_ckBox fl_wd2 mg_r5">
                                                <input id='workTypehalfTime' name='rec_work_type[]' type='checkbox' value='1' <?= in_array(1, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                                <label for="workTypehalfTime">계약직</label>
                                            </div>
                                            <div class="position_ckBox fl_wd2 mg_r5">
                                                <input id='workTypeintern' name='rec_work_type[]' type='checkbox' value='3' <?= in_array(3, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                                <label for="workTypeintern">인턴직</label>
                                            </div>
                                            <div class="position_ckBox fl_wd2 mg_r5">
                                                <input id='workTypeForeign' name='rec_work_type[]' type='checkbox' value='5' <?= in_array(5, $data['recList']['rec_work_type'] ?? []) ? 'checked' : '' ?> class="inputWorkType width50">
                                                <label for="workTypeForeign">해외취업</label>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>접수 마감일</label><br>
                                        <input type="date" name='rec_end_date' value='<?= $data['recList']['rec_end_date'] ?? '' ?>' required>
                                        <!-- <input id='end_date' type='checkbox'><label for='end_date'>상시모집</label> -->
                                    </td>
                                    <td>
                                        <label>학력</label><br>
                                        <input id='edu0' name='rec_education' type='radio' value='0' <?= ($data['recList']['rec_education'] ?? '') == '0' ? 'checked' : '' ?> checked><label for='edu0' class="radioLabel">무관</label>
                                        <input id='edu1' name='rec_education' type='radio' value='1' <?= ($data['recList']['rec_education'] ?? '') == '1' ? 'checked' : '' ?>><label for='edu1' class="radioLabel">고졸 이하</label>
                                        <input id='edu2' name='rec_education' type='radio' value='2' <?= ($data['recList']['rec_education'] ?? '') == '2' ? 'checked' : '' ?>><label for='edu2' class="radioLabel">고등학교</label>
                                        <input id='edu3' name='rec_education' type='radio' value='3' <?= ($data['recList']['rec_education'] ?? '') == '3' ? 'checked' : '' ?>><label for='edu3' class="radioLabel">2,3년제 대학</label>
                                        <input id='edu4' name='rec_education' type='radio' value='4' <?= ($data['recList']['rec_education'] ?? '') == '4' ? 'checked' : '' ?>><label for='edu4' class="radioLabel">4년제 대학</label>
                                        <input id='edu5' name='rec_education' type='radio' value='5' <?= ($data['recList']['rec_education'] ?? '') == '5' ? 'checked' : '' ?>><label for='edu5' class="radioLabel">석사</label>
                                        <input id='edu6' name='rec_education' type='radio' value='6' <?= ($data['recList']['rec_education'] ?? '')  == '6' ? 'checked' : '' ?>><label for='edu6' class="radioLabel">박사</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>경력</label><br>
                                        <input id='careerA' name='rec_career' type='radio' value='A' checked <?= ($data['recList']['rec_career'] ?? '')  === 'A' ? 'checked' : '' ?>><label for='careerA' class="radioLabel">무관</label>
                                        <input id='careerN' name='rec_career' type='radio' value='N' <?= ($data['recList']['rec_career'] ?? '')  === 'N' ? 'checked' : '' ?>><label for='careerN' class="radioLabel">신입</label>
                                        <input id='careerC' name='rec_career' type='radio' value='C' <?= ($data['recList']['rec_career'] ?? '')  === 'C' ? 'checked' : '' ?>><label for='careerC' class="radioLabel">경력</label>
                                        <input id='careerM' name='rec_career_month' type="number" value='<?= $data['recList']['rec_career_month'] ?? '' ?>'><label for='careerM'>개월 이상</label>
                                    </td>
                                    <td>
                                        <label>급여</label><br>
                                        <input id='payM' name='rec_pay_type' type='radio' value='M' checked <?= ($data['recList']['rec_pay_type'] ?? '')  === 'M' ? 'checked' : '' ?>><label for='payM' class="radioLabel">월급</label>
                                        <input id='payY' name='rec_pay_type' type='radio' value='Y' <?= ($data['recList']['rec_pay_type'] ?? '')  === 'Y' ? 'checked' : '' ?>><label for='payY' class="radioLabel">연봉</label>
                                        <input id='payN' name='rec_pay_type' type='radio' value='N' <?= ($data['recList']['rec_pay_type'] ?? '')  === 'N' ? 'checked' : '' ?>><label for='payN' class="radioLabel">협의 후 결정</label>
                                        <input id='payU' name='rec_pay_unit' type="number" value='<?= $data['recList']['rec_pay_unit'] ?? '' ?>'><label for='payU' class="radioLabel">원 이상</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>지역선택</label><br>
                                        <div class="recSelectArea" style="position: relative;">
                                            <label for="title">선택된 지역</label>
                                            <div class="selectAreaBtn" id="selectArea">지역선택하기</div>
                                            <div id='area_list' class='checked_circle'></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="areaCheck" style="display: none;">
                                    <td>
                                        <label>지역 선택 (시/도)</label><br>
                                        <!--s ard_1th-->
                                        <div class="ard_1th">
                                            <div class="ard_tlt c fontBold recruitBoxTlt">시/도</div>

                                            <!--s ard_list-->
                                            <ul class="ard_list areaDepth1 c">
                                                <?php for ($i = 1, $max = count($data['areaList']); $i <= $max; $i++) : ?>
                                                    <li class='<?= $i === 1 ? 'on' : '' ?> recruitBoxLi' value='<?= $i ?>'>
                                                        <a><?= $data['areaList'][$i]['all']['areaName'] ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                            <!--e ard_list-->
                                        </div>
                                        <!--e ard_1th-->
                                    </td>
                                    <td>
                                        <label>지역 선택 (시/구/군)</label><br>
                                        <!--s ard_2th-->
                                        <div class="ard_2th">
                                            <div class="ard_tlt c fontBold recruitBoxTlt">시/구/군</div>

                                            <!--s ard_list-->
                                            <?php for ($i = 1, $max = count($data['areaList']); $i <= $max; $i++) : ?>
                                                <ul id='areaLists<?= $i ?>' class="ard_list areaDepth2" style='display:none'>
                                                    <?php foreach ($data['areaList'][$i] as $key => $val) : ?>
                                                        <?php if (is_numeric($key)) : ?>
                                                            <li>
                                                                <input id='A<?= $val['idx'] ?>' type='checkBox' name='rec_area[]' value='<?= $val['idx'] ?>' style='display:' <?= in_array($val['idx'], $data['recList']['kor_area_idx'] ?? []) ? 'checked' : '' ?>>

                                                                <label for='A<?= $val['idx'] ?>'>
                                                                    <?= $val['areaName'] ?><?= $key === 'all' ? ' 전체' : '' ?>
                                                                </label>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endfor; ?>
                                            <!--e ard_list-->
                                        </div>
                                        <!--e ard_2th-->
                                        <div id='area_list' class='checked_circle'></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>직무선택</label><br>
                                        <div class="recSelectArea" style="position: relative;">
                                            <label for="title">선택된 직무</label>
                                            <div class="selectAreaBtn" id="selectJob">직무선택하기</div>
                                            <div id='jobs_list' class='checked_circle'></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="jobCheck" style="display: none;">
                                    <td>
                                        <!--s ardBox-->
                                        <div class="ardBox">
                                            <?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'mutl', 'checked' => $data['recList']['job_idx'] ?? []]) ?>
                                        </div>
                                        <!--e ardBox-->
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>지원방식</h4>

                        <table class="table">
                            <colgroup>
                                <col style="width:100%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        <label>지원받을 인터뷰 선택</label>
                                        <div class="mg_b5 b">선택된 직무 : <span id='job_category' class="selectedJob"></span></div>

                                        <input id='rec_apply_M' name='rec_apply' value='M' type='radio' checked <?= ($data['recList']['rec_apply'] ?? '')  === 'M' ? 'checked' : '' ?>>
                                        <label for="rec_apply_M" class="radioLabel">지원자 개인 인터뷰</label>
                                        <input id='rec_apply_C' name='rec_apply' value='C' type='radio' <?= ($data['recList']['rec_apply'] ?? '')  === 'C' ? 'checked' : '' ?>>
                                        <label for="rec_apply_C" class="radioLabel">기업 인터뷰</label>
                                        <input id='rec_apply_A' name='rec_apply' value='A' type='radio' <?= ($data['recList']['rec_apply'] ?? '')  === 'A' ? 'checked' : '' ?>>
                                        <label for="rec_apply_A" class="radioLabel">둘다 가능</label>

                                        <div id='inter_box' style='display:none;' class="howToApply">
                                            <?php foreach ($data['interList'] as $row) : ?>
                                                <div id='inter_box<?= $row['jobIdx'] ?>'>
                                                    <h3>[<?= $row['jobText'] ?>] 인터뷰 만들기</h3>
                                                    <div>
                                                        <a href='javascript:void(0)'>자동 생성하기</a>
                                                        <button type='button' value='<?= $row['jobIdx'] ?>' class='inter_btn'>질문중에 선택하기</button>
                                                        <li data-que-idx='1'>자기소개를 부탁드립니다.</li>
                                                        <ul class='sortable'>
                                                            <?php foreach ($row['question'] as $que) : ?>
                                                                <?php if ($que['queIdx'] != 1) : ?>
                                                                    <li data-que-idx='<?= $que['queIdx'] ?>'><?= $que['queText'] ?></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <div>각 질문당 답변 시간
                                                            <select id='inter_time<?= $row['jobIdx'] ?>'>
                                                                <option value='30'>30초</option>
                                                                <option value='45'>45초</option>
                                                                <option value='60'>60초</option>
                                                                <option value='90'>90초</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label>A.I. 돌발질문 생성</label><input type='checkbox' disabled>
                                                        </div>
                                                    </div>
                                                    <input id='input<?= $row['jobIdx'] ?>' value='<?= $row['interIdx'] ?>' name='rec_inter[]' readonly>
                                                    <button value='<?= $row['jobIdx'] ?>' type='button' class='inter_save'>인터뷰 저장하기</button>
                                                    <hr>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label>응시가능 횟수</label><br>
                                            <input type='number' name='rec_apply_count' value='<?= $data['recList']['rec_apply_count'] ?? '' ?>'>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label>이력서</label><br>
                                            <input id='rec_resume_C' name='rec_resume' value='C' type='radio' checked <?= ($data['recList']['rec_resume'] ?? '')  === 'C' ? 'checked' : '' ?>>
                                            <label for="rec_resume_C" class="radioLabel">무관</label>
                                            <input id='rec_resume_R' name='rec_resume' value='R' type='radio' <?= ($data['recList']['rec_resume'] ?? '')  === 'R' ? 'checked' : '' ?>>
                                            <label for="rec_resume_R" class="radioLabel">이력서 첨부 필수</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>상세내용</h4>

                        <table class="table">
                            <colgroup>
                                <col style="width:100%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea name="rec_info" id="bd-content"><?= ($data['recList']['rec_info'] ?? '') ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>사진</div>
                                        <!-- 사진 등록하는 기능 나중에 작업해야함 -->
                                        <!-- <input type="hidden" id="thumbID" name="profileIdx" value='<? //= $data['recList']['fileIdx'] ?? '' 
                                                                                                        ?>'>
                                        <input type="file" accept="image/*" id="thumb" name="profileFile"> -->
                                        <img src='<?= $data['url']['media'] ?><?= $data['recList']['com_logo_img']['file_save_name'] ?? '/data/no_img.png' ?>' onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                        <!-- <button id='test' type='button'>테스트</button> -->
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>
                                        <div>태그</div>
                                        <button type="button">+ 추가하기</button>

                                    </td>
                                </tr> -->
                                <!-- <tr class='title'>
                                    <th>근무지 정보</th>
                                </tr>
                                <tr>
                                    <td>
                                        <div>근무지 주소 </div>
                                        <div class="wd50Box">
                                            <input type="hidden" id="input_extraAddress" name="input_extraAddress" value="" />
                                            <input type="text" name="input_postcode" id="input_postcode" class="wd50Box_inp" placeholder="" value="">
                                            <a href="javascript:void(0)" class="dnBtn" id="searchAddr">주소 검색</a>
                                        </div>
                                        <div id="addressLayer"></div>

                                        <input type="text" name="input_address" id="input_address" class="wps_100" placeholder="" value="">
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class='card-body'>
                    <div class="box">
                        <div class="">
                            <button type='button' class="btn btn-success">취소</button>
                            <button type='submit' class="btn btn-success">등록하기</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.row -->

<div id='question' class='pop_modal'>
    <div class='pop_full' style="border-radius:5px;">
        <div class='pop_con recQueWrap'>
            <div class="recQueTitle">질문리스트</div>
            <button onclick="$('#question').removeClass('on')">닫기</button>
            <ul class="recQueList" style='height: 95vh; overflow-y:auto;'></ul>
        </div>
    </div>
</div>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<!-- <script src="https://cdn.socket.io/4.2.0/socket.io.min.js" integrity="sha384-PiBR5S00EtOj2Lto9Uu81cmoyZqR57XcOna1oAuVuIEjzj0wpqDVfD0JA9eXlRsj" crossorigin="anonymous"></script> -->
<!-- <script src="<? //= $data['url']['menu'] 
                    ?>/plugins/fileupload/fileupload.js"></script> -->
<script>
    const emlCsrf = $("input[name='csrf_highbuff']");
    let objCheckedArea = {};
    let objCheckedJobs = {};
    let queType = {
        'B': '비즈',
        'G': '일반', //옛날 질문들의 일반 질문
        'C': '공통',
        'A': '모의',
        'S': '샘플',
        'J': '일반' //3depth로 변경하고 난 이후의 추가한 질문
    }
    let ajaxFlag = true;
    $(document).ready(function() {
        careerChk();
        payChk();
        // try {
        //     initSocket();
        // } catch (error) {
        //     const emlCsrf = $("input[name='<? //= csrf_token() 
                                                ?>']");
        //     $.ajax({ //db에 에러로그 쌓고 텔레그램 보내는 ajax
        //         type: 'POST',
        //         url: '/api/error/page/write/add',
        //         data: {
        //             '<? //= csrf_token() 
                        ?>': emlCsrf.val(),
        //             errorTxt: error,
        //             pullPage: '/Views/prime/recruit/write',
        //         },
        //         success: function(data) {
        //             emlCsrf.val(data.code.token);
        //             if (data.status == 200) {
        //                 alert("서버 연결에 실패하였습니다. 잠시후에 시도해주세요. \n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");

        //                 location.reload();
        //             } else {
        //                 alert(data.messages);
        //                 return false;
        //             }
        //             return true;
        //         },
        //         error: function(e) {
        //             console.log(e);
        //             alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
        //             return;
        //         }
        //     }) //ajax;
        // }
        applyChk();
        jobsChk();
        areaChk();
        $(".sortable").sortable({
            placeholder: "itemBoxHighlight"
        });
    });

    $('#searchBtn').on('click', function() {
        $('#frm2').submit();
    });

    $("#frm").validate({
        ignore: [],
        rules: {
            rec_apply_count: {
                required: true,
                range: [1, 99]
            },
            rec_info: {
                required: true,
            }
        },
        messages: {
            rec_apply_count: {
                required: "응시 가능 횟수를 입력해 주세요",
                range: '1회~99회'
            },
            rec_info: {
                required: "본문을 입력해 주세요."
            }
        },
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때

            if (!$('input[name="rec_work_type[]"]:checked').length) {
                alert('고용현태를 선택해주세요.');
                return false;
            }
            if (!$('input[name="rec_area[]"]:checked').length) {
                alert('지역을 선택해주세요.');
                return false;
            }
            if (!$('input[name="depth3[]"]:checked').length) {
                alert('직군을 선택해주세요.');
                return false;
            }

            form.submit();
        }
    });

    $('.areaDepth1').children('li').on('click', function() {
        $('.areaDepth1').children('li').removeClass('on');
        $(this).addClass('on');
        const id = $(this).val();
        $('.areaDepth2').hide();
        $(`#areaLists${id}`).show();
    });

    $('input[name="rec_career"]').on('change', function() {
        careerChk();
    });

    $('input[name="rec_pay_type"]').on('change', function() {
        payChk();
    });

    $('input[name="rec_apply"]').on('change', function() {
        applyChk();
    });

    $('input[name="rec_area[]"]').on('change', function() {
        areaChk($(this));
    });

    $('input[name="depth3[]"]').on('change', function() {
        jobsChk($(this));
    });

    $('#selectArea').on('click', function() {
        $('#areaCheck').show();
    });

    $('#selectJob').on('click', function() {
        $('#jobCheck').show();
    });

    $(document).on('click', '.inter_btn', function() {
        const thisIdx = $(this).val();
        if (ajaxFlag) {
            ajaxFlag = false;
            $.ajax({
                url: `/api/question/read/${thisIdx}`,
                type: 'post',
                dataType: "json",
                cache: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val()
                },
                success: function(res) {
                    ajaxFlag = true;
                    emlCsrf.val(res.code.token);
                    if (res.status === 200) {
                        const modal = $('#question');
                        const item = res.code.item;
                        const ul = modal.find('ul');
                        modal.addClass('on');
                        ul.empty();
                        for (let idx in item) {
                            const type = queType[item[idx]['que_type']];
                            if (in_array(item[idx], objCheckedJobs[thisIdx])) {
                                ul.append(`<li><label>[${type}] ${item[idx]['que_question']}<input type='checkbox' value='${idx}' checked></label></li>`);
                            } else {
                                ul.append(`<li><label>[${type}] ${item[idx]['que_question']}<input type='checkbox' value='${idx}'></label></li>`);
                            }
                        }
                        ul.append(`<button id='que_save' 'type='button' value='${thisIdx}'>저장</button>`);
                    } else {
                        alert(res.messages)
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    });

    $(document).on('click', '#que_save', function() {
        const thisEle = $(this);
        const thisIdx = thisEle.val();
        const thisUl = thisEle.closest('ul');
        const interBox = $(`#inter_box${thisIdx}`);
        const interBoxUl = interBox.find('ul');
        objCheckedJobs[thisIdx] = [];
        interBoxUl.empty();
        thisUl.find('input:checked').each(function() {
            objCheckedJobs[thisIdx].push($(this).val());
            interBoxUl.append(`<li data-que-idx="${$(this).val()}">${$(this).closest('label').text()}</li>`);
        });

        $('#question').removeClass('on');
    });

    $(document).on('click', '.inter_save', function() {
        const thisEle = $(this);
        const thisDiv = thisEle.closest('div');
        const comIdx = $('select[name="com_idx"]').val();
        const jobIdx = thisEle.val();
        const interTime = thisDiv.find('select').val();
        let aQueIdx = [];
        thisDiv.find('li').each(function() {
            aQueIdx.push($(this).data('que-idx'));
        });
        if (comIdx == "" || comIdx == null) {
            alert('기업을 선택해주세요.');
            return;
        }
        // console.log(comIdx);
        // return;
        $.ajax({
            url: `/api/interview/create`,
            type: 'post',
            dataType: "json",
            cache: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                '<?= csrf_token() ?>': emlCsrf.val(),
                'comIdx': comIdx,
                'jobIdx': jobIdx,
                'interTime': interTime,
                'interType': 'C',
                'queIdx': aQueIdx
            },
            success: function(res) {
                ajaxFlag = true;
                emlCsrf.val(res.code.token);
                if (res.status === 200) {
                    alert(res.messages)
                    $(`#input${jobIdx}`).prop('disabled', false);
                    $(`#input${jobIdx}`).prop('readonly', true);
                    $(`#input${jobIdx}`).val(res.code.idx);
                } else {
                    alert(res.messages)
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                alert(textStatus);
            }
        });
    });

    function jobsChk(ele = null) {
        const jobsLength = $('input[name="depth3[]"]:checked').length;

        if (ele) {
            if (jobsLength > 1) {
                ele.prop('checked', false);
                alert('최대 1개까지 선택 가능합니다.');
                return;
            }

            const value = ele.val();
            const label = ele.next('label').text();
            if (ele.is(':checked')) {
                if (!objCheckedJobs[value]) {
                    objCheckedJobs[value] = [];
                }
                $('#job_category').append(`<span id='I${value}'>${label}</span>`);
                $('#jobs_list').append(`<span id='F${value}'>${label} <label for=${ele.attr('id')} class="noVerAlign">삭제</label></span>`);
                $('#inter_box').append(html(value, label));
                $(".sortable").sortable({
                    placeholder: "itemBoxHighlight"
                });
            } else {
                $(`#F${value}`).remove();
                $(`#I${value}`).remove();
                $(`#inter_box${value}`).remove();
            }
        } else {
            $('input[name="depth3[]"]:checked').each(function() {
                const value = $(this).val();
                const label = $(this).next('label');
                objCheckedJobs[value] = [];
                $('#job_category').append(`<span id='I${value}'>${label.text()}</span>`);
                $('#jobs_list').append(`<span id='F${value}'>${label.text()} <label for=J${value} class="noVerAlign">삭제</label></span>`);
            })
        }
    }

    function areaChk(ele = null) {
        const areaLength = $('input[name="rec_area[]"]:checked').length;

        if (ele) {
            if (areaLength > 1) {
                ele.prop('checked', false);
                alert('최대 1개까지 선택 가능합니다.');
                return;
            }

            const value = ele.val();
            const label = ele.next('label').text();
            if (ele.is(':checked')) {
                // if (!objCheckedarea[value]) {
                //     objCheckedarea[value] = [];
                // }
                // $('#job_category').append(`<span id='I${value}'>${label}</span>`);
                $('#area_list').append(`<span id='AF${value}'>${label} <label for=A${value} class="noVerAlign pointer">삭제</label></span>`);
                // $('#inter_box').append(html(value, label));
                // $(".sortable").sortable({
                //     placeholder: "itemBoxHighlight"
                // });
            } else {
                $(`#AF${value}`).remove();
                // $(`#A${value}`).remove(); //INPUT박스를 없애서 주석침
            }
        } else {
            $('input[name="rec_area[]"]:checked').each(function() {
                const value = $(this).val();
                const label = $(this).next('label');
                $('#area_list').append(`<span id='AF${value}'>${label.text()} <label for=A${value} class="noVerAlign pointer">삭제</label></span>`);
            })
        }
    }

    function careerChk() {
        $('#careerM').attr('disabled', !$('#careerC').is(':checked'));
    }

    function payChk() {
        $('#payU').attr('disabled', $('#payN').is(':checked'));
    }

    function applyChk() {
        const boolChecked = !$('#rec_apply_M').is(':checked');
        if (boolChecked) {
            $('#inter_box').css('display', 'block');
        } else {
            $('#inter_box').css('display', 'none');
        }
        $('input[name="rec_inter[]"]').prop('disabled', !boolChecked);
    }

    function html(idx, label) {
        const html =
            `<div id='inter_box${idx}'>
            <h3 style="font-weight:bold;">[${label}] 인터뷰 만들기</h3>
            <div class="emphasis mg_b5">인터뷰가 필수로 필요합니다.</div>
            <div>
                <div>
                    <button type='button' class="applyWayBtn" onclick="alert('현재 지원하지 않는 기능입니다.')">자동 생성하기</button>
                    <button type='button' value='${idx}'class='inter_btn applyWayBtn'>질문중에 선택하기</button>
                </div>
                <br>
                <div class="b">*질문리스트* <span class="explain">(1번은 '자기소개를 부탁드립니다.'로 고정입니다.)</span></div>
                <li data-que-idx='1' class="mg_l5">자기소개를 부탁드립니다.</li>
                <ul class='sortable mg_l5'></ul>
            </div>
            <div>
                <div><span class="b">답변시간 선택<span> <br>
                    <select id='inter_time${idx}'>
                        <option value='30'>30초</option>
                        <option value='45'>45초</option>
                        <option value='60'>60초</option>
                        <option value='90'>90초</option>
                    </select>
                </div>
                <br>
                <div>
                    <label style="margin-bottom:0;">A.I. 돌발질문 생성 </label> <input type='checkbox' disabled>
                    <div class="explain">(현재 지원하지 않는 기능입니다.)</div>
                </div>
            </div>
            <br>
            <input type="text" id='input${idx}'name='rec_inter[]' disabled>
            <button value='${idx}' type='button' class='inter_save applyWayBtn'>인터뷰 저장하기</button>
            <hr>
        </div>`;
        return html;
    }

    $('#thumb').on('change', function() {
        const file = $(this).prop('files');

        const reader = new FileReader()
        // reader.onload = e => {
        //     const previewImage = document.getElementById("changeImg")
        //     previewImage.src = e.target.result
        // }

        reader.readAsDataURL(file[0]);
    });

    // $("#test").on("click", function() {
    //     const file = $('#thumb').prop('files');
    //     console.log('작동');
    //     if (!file[0]) {
    //         // this.submit();
    //         console.log(1);
    //     } else {
    //         const filename = getFileName('recruit', 'png');

    //         const data = {
    //             source: file[0],
    //             name: filename,
    //             size: file[0].size,
    //             page: "recruit",
    //             path: "recruit", //file upload 경로(/data/webtest/uploads/아래) - 없는 경우 생성 - defult : dummy
    //         };

    //         socket.emit('thumbnail', data);
    //     }
    // });

    // function initSocket() {
    //     socket = io.connect('<? //= $data['url']['mediaFull'] 
                                ?>', {
    //         cors: {
    //             origin: '*'
    //         },
    //         transports: ["websocket"]
    //     });

    //     socket.on('connect', function() {
    //         console.log("socket connected");
    //     });

    //     socket.on('connect_error', function() {
    //         alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
    //         location.reload();
    //         return false;
    //     });

    //     socket.on('complete_thumb', (data) => {
    //         console.log(data);
    //         $('#filePath').val(data.filePath.substr(1));
    //         $('#fileSize').val(data.size);

    //         $('#modifyData').submit();

    //     });
    //     socket.on('disconnect', function() {
    //         alert("서버 연결이 끊어졌습니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
    //         location.reload();
    //         return false;
    //     });
    // }

    function getFileName(fields, fileExtension) {
        let d = new Date();
        let index = 2;
        let rand = Math.random().toString(36).substr(2, 11);
        let times = d.getTime();
        return index + "-" + fields + "-" + times + '-' + rand + '.' + fileExtension;
    }

    admin_editor_param = {
        customConfig: '/plugins/ckeditor/config.js',
        filebrowserUploadUrl: '/data/editor-upload',
        fileTools_requestHeaders: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        }
    };
    CKEDITOR.replace('bd-content', admin_editor_param);
    CKEDITOR.on('dialogDefinition', function(ev) {
        editor_img_chek(ev);
    });
</script>

<style>
    .main {
        overflow-y: scroll;
        height: 70vh;
    }

    .bottomBtn {
        height: 5vh;
    }

    th {
        background: #ddd;
        color: #505bf0;
    }

    .ard_list>li {
        cursor: pointer;
    }

    /* .checked_circle>span {
        border: 1px black solid;
    } */

    /* #job_category>span {
        border: 1px black solid;
    } */

    .itemBoxHighlight {
        background: #ddd;
    }

    .inputWorkType {
        top: unset !important;
        height: 34px !important;
    }
</style>