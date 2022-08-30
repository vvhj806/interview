<!--s #scontent-->
<div id="scontent" data-idx="<?= $data['rIdx'] ?>" data-midx="<?= $data['memIdx'] ?>">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt"><?= $data['rIdx'] == 0 ? '새' : '' ?> 이력서 작성하기</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t20">
        <!--s contBox-->
        <div class="contBox">
            <!--s n_resume_info-->
            <div class="n_resume_info">
                <!--s imgBox-->
                <div class="imgBox"><img src="<?= isset($data['postData']['base']['file_save_name']) ?  $data['url']['media'] . $data['postData']['base']['file_save_name'] : "/static/www/img/sub/prf_no_img.jpg"  ?>" id="changeImg"></div>
                <!--e imgBox-->

                <!--s txtBox-->
                <div class="txtBox">
                    <ul>
                        <li>
                            <span class="tlt">이름</span>
                            <span class="txt"><?= $data['member']['mem_name'] ?></span>
                        </li>
                        <li>
                            <span class="tlt">이메일</span>
                            <span class="txt"><?= $data['member']['mem_email'] ?></span>
                        </li>
                        <li>
                            <span class="tlt">연락처</span>
                            <span class="txt"><?= $data['member']['mem_tel'] ?></span>
                        </li>
                        <li>
                            <span class="tlt">나이</span>
                            <span class="txt"><?= $data['member']['mem_age'] ?></span>
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="base">수정</a>
                </div>
                <!--e txtBox-->
            </div>
            <!--e n_resume_info-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <div class="mg_b40">
            <div class="stltBox">
                <div class="stlt fl">제목<span class="point">*</span></div>
            </div>

            <input type="text" name="rTitle" id="rTitle" class="wps_100" placeholder=" 제목을 입력해 주세요" value="<?= $data['postData']['res_title'] ?? '' ?>">
        </div>
        <div class="mg_b40">
            <div class="stltBox">
                <div class="stlt fl">자기소개</div>
                <div class="stlt_stxt fr"><?= isset($data['postData']['rIntro_contents']) ? strlen($data['postData']['rIntro_contents']) : '0' ?>자</div>
            </div>

            <textarea name="rIntro_contents" id="stltText" placeholder=" 내용을 입력해 주세요"><?= $data['postData']['rIntro_contents'] ?? '' ?></textarea>
        </div>

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">관심 직무</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="interest"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></a>
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt">
                    <!--s depth-->
                    <ul class="depth2">

                        <?php
                        if (!empty($data['postData']['interest'])) :
                            foreach ($data['postData']['interest'] as $key => $val) :
                        ?>
                                <li>
                                    <a href="#n" class="kwd"><?= $key ?></a>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=interest&key=<?= $key ?>" class="kwd_close"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">학력</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="education"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></a>
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt">
                    <!--s depth-->
                    <ul class="depth2">
                        <?php
                        if (!empty($data['postData']['education']['resumeSub'])) :
                            foreach ($data['postData']['education']['resumeSub'] as $key => $val) :
                                $eGradType = $data['postData']['education']['resumeSub'][$key]['eGradType'] == "A" ? "재학중" : ($data['postData']['education']['resumeSub'][$key]['eGradType'] == "B" ? "졸업" : "휴학");


                        ?>
                                <li>
                                    <a href="#n" class="kwd"><?= $data['postData']['education']['resumeSub'][$key]['eName'] ?> | <?= $data['postData']['education']['resumeSub'][$key]['cName'] ?> | <?= $data['postData']['education']['resumeSub'][$key]['eYearMonth'] ? $data['postData']['education']['resumeSub'][$key]['eYearMonth'] . " " . $eGradType : $data['postData']['education']['resumeSub'][$key]['sYearMonth'] . ' ~ ' . $eGradType ?> </a>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=education&key=<?= $key ?>" class="kwd_close"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">경력</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="career"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></a>
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt big_keywords_box">
                    <!--s depth-->
                    <ul class="depth2">
                        <?php
                        if (!empty($data['postData']['career']['resumeSub'])) :
                            foreach ($data['postData']['career']['resumeSub'] as $key => $val) :
                        ?>
                                <li>
                                    <div class="tlt"><?= $data['postData']['career']['resumeSub'][$key]['cName'] ?> | <?= $data['postData']['career']['resumeSub'][$key]['sDate'] ?>~<?= $data['postData']['career']['resumeSub'][$key]['eDate'] ? $data['postData']['career']['resumeSub'][$key]['eDate'] : '재직중' ?></div>
                                    <div class="txt">
                                        부서명/직책 : <?= $data['postData']['career']['resumeSub'][$key]['depName'] ?><br />
                                        주요업무 : <?= $data['postData']['career']['resumeSub'][$key]['business'] ?>
                                    </div>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=career&key=<?= $key ?>" class="kwd_close"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">외국어</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="language"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></a>
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt big_keywords_box inline">
                    <!--s depth-->
                    <ul class="depth2">

                        <?php
                        if (!empty($data['postData']['language']['resumeSub'])) :
                            foreach ($data['postData']['language']['resumeSub'] as $key => $val) :
                        ?>
                                <li>
                                    <div class="tlt"><?= $data['postData']['language']['resumeSub'][$key]['lName'] ?></div>
                                    <div class="txt">점수 <?= $data['postData']['language']['resumeSub'][$key]['lScore'] ?> | 급수 <?= $data['postData']['language']['resumeSub'][$key]['lLever'] ?> | 취득일 <?= substr($data['postData']['language']['resumeSub'][$key]['lObtainDate'], 0, 4) . '-' .substr($data['postData']['language']['resumeSub'][$key]['lObtainDate'], 4, 2) ?></div>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=language&key=<?= $key ?>" class="kwd_close"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">자격증</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="license"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></a>
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt big_keywords_box inline">
                    <!--s depth-->
                    <ul class="depth2">

                        <?php
                        if (!empty($data['postData']['license']['resumeSub'])) :
                            foreach ($data['postData']['license']['resumeSub'] as $key => $val) :
                        ?>
                                <li>
                                    <div class="tlt"><?= $data['postData']['license']['resumeSub'][$key]['lName'] ?></div>
                                    <div class="txt">발행처/기관 <?= $data['postData']['license']['resumeSub'][$key]['lPublicOrg'] ?> | <?= $data['postData']['license']['resumeSub'][$key]['lLevel'] ?> | 취득일 <?= substr($data['postData']['license']['resumeSub'][$key]['lObtainDate'], 0, 4) . '-' .substr($data['postData']['license']['resumeSub'][$key]['lObtainDate'], 4, 2) ?></div>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=license&key=<?= $key ?>" class="kwd_close"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">기타 활동</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <a href="javascript:void(0)" class="more_link" data-ridx="<?= $data['rIdx'] ?>" data-value="activity"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></a>
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt big_keywords_box">
                    <!--s depth-->
                    <ul class="depth2">
                        <?php
                        if (!empty($data['postData']['activity']['resumeSub'])) :
                            foreach ($data['postData']['activity']['resumeSub'] as $key => $val) :
                        ?>
                                <li>
                                    <div class="tlt"><?= $data['postData']['activity']['resumeSub'][$key]['actName'] ?> | <?= $data['postData']['activity']['resumeSub'][$key]['aStartDate'] ?> ~ <?= $data['postData']['activity']['resumeSub'][$key]['aEndDate'] ?></div>
                                    <div class="txt">
                                        세부사항 <?= $data['postData']['activity']['resumeSub'][$key]['detail'] ?>
                                    </div>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=activity&key=<?= $key ?>" class="kwd_close"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <!--s rm_list-->
        <div class="rm_list">
            <!--s tltBox-->
            <div class="tltBox overflow">
                <div class="tlt fl">첨부파일</div>

                <!--s more_btn-->
                <div class="more_btn fr">
                    <label for="profileFile"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></label>
                    <input type="file" id="profileFile" name="profileFile" data-filebox=".filebox" style="display:none">
                </div>
                <!--e more_btn-->
            </div>
            <!--e tltBox-->

            <!--s rm_cont-->
            <div class="rm_cont">
                <div class="keywords_box keywords_box2 gtxt">
                    <!--s depth-->
                    <ul class="depth2 filebox">
                        <?php
                        if (!empty($data['postData']['rPortfolio'])) :
                            foreach ($data['postData']['rPortfolio'] as $key => $val) :
                                $profileFile = $data['postData']['rPortfolio'][$key]['profileFile'];
                                //profileFile값 암호화 필요
                                $pFileSize = $data['postData']['rPortfolio'][$key]['fileSize'];
                        ?>
                                <li id="file<?= $key ?>">
                                    <a href="#n" class="kwd"><?= $data['postData']['rPortfolio'][$key]['file_save_name'] ?></a>
                                    <a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete?type=rPortfolio&key=<?= $key ?>" class="kwd_close filedelete" data-value="<?= $key ?>" data-files="<?= $profileFile ?>" data-size="<?= $pFileSize ?>"><i class="la la-times"></i></a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <!--e depth-->
                </div>
            </div>
            <!--e rm_cont-->
        </div>
        <!--e rm_list-->

        <div class="itv_pr_preview_btn r mg_t40 mg_b70"><a href="javascript:alert2('서비스 준비 중 입니다.')" class="a_line">미리보기</a></div>

        <!--s BtnBox-->
        <div class="BtnBox">
            <button type="button" id="saveBtn" class="btn btn01 wps_100">저장</button>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e cont-->
    <form action="" method="POST" id="next_form" enctype="multipart/form-data">
        <?= csrf_field() ?>
    </form>
</div>
<!--e #scontent-->

<!--s 저장 모달-->
<div id="write_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="txt mg_b0">
                저장하겠습니까?
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <a href="javascript:" class="spop_btn01" onclick="fnHidePop('write_pop')">더 쓸래요</a>
            <a href="javascript:" class="spop_btn02" onclick="saveAction()">네</a>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 저장 모달-->

<script>
    var fileDataName = new Array();
    var fileDataSize = new Array();

    $("#next_form").validate({
        ignore: [],
        rules: {
            rTitle: {
                required: true,
            }
        },
        messages: {
            rTitle: {
                required: "제목을 입력해 주세요.",
            }
        },
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때
            form.submit();
        }
    });

    $('#stltText').on('keyup', function(e) {
        let content = $(this).val(); // 글자수 세기 
        if (content.length == 0 || content == '') {
            $('.stlt_stxt').text('0자');
        } else {
            $('.stlt_stxt').text(content.length + '자');
        }

    });

    // 파일 목록 추가
    function fileHtml(selecter, file, fileNo) {
        let no = 0;
        let fileName = file.name;
        let fNo = 0;
        //DB or Cache에서 가져온 Data 있는경우 file no 설정
        if ($(selecter).children().length > 0) {
            no = $(selecter).children().length;

        } else {
            no = fileNo;
        }
        //동일 파일명 표시
        $(selecter + ' > li').each(function() {

            if ($(this).children('a:eq(1)').data('name') == file.name) {
                fNo++;
            }
        });
        if (fNo > 0) {
            let fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1, fileName.length);
            let fileRealName = fileName.substring(0, fileName.lastIndexOf('.'));
            fileName = fileRealName + '(' + fNo + ').' + fileExtension;
        }

        let htmlData = '';
        htmlData += '<li id="file' + no + '">';
        htmlData += '<a href="#n" class="kwd">' + fileName + '</a>'
        htmlData += '<a href="javascript:void(0);" class="kwd_close filedelete" data-value="' + no + '" data-name="' + file.name + '" ><i class="la la-times"></i></a>';
        htmlData += '</li>';
        $(selecter).append(htmlData);
    }

    //첨부파일 upload 후 처리
    socket.on('complete', (data) => {
        console.log('complete');

        if (data[0].linktype == 'morelink' || data[0].linktype == 'save') {
            var eDList = new Array();
            //for (let i = 0; i < filesArr.length; i++) {
            let fileLen = $('.filebox > li').length - filesArr.length;
            let i = 0;
            $('.filebox > li').each(function() {
                var eData = new Object();
                eData.num = i;

                //cache에 있는경우와 새로 파일을 선택한경우 
                if (i >= fileLen) {
                    eData.profileFile = data[i - fileLen].filePath.substr(1);
                    eData.fileSize = fileDataSize[i - fileLen];
                } else {
                    eData.profileFile = $('.filebox > li:eq(' + i + ') > a:eq(1)').data('files');
                    eData.fileSize = $('.filebox > li:eq(' + i + ') > a:eq(1)').data('size');
                }

                eData.file_save_name = $('.filebox > li:eq(' + i + ') > a:eq(0)').html();

                eDList.push(eData);
                i++;
            })
            var jsonData = JSON.stringify(eDList);

            var addInput = document.createElement('input');
            //addInput.setAttribute("type", "hidden"); 
            addInput.setAttribute("name", 'rPortfolio');
            addInput.setAttribute("value", jsonData);
            $("#next_form").append(addInput);

            $('#next_form').submit();
        } else {


            $('#next_form').submit();
        }
    });


    function fileUploadEmit(linktype = '') {
        //e.preventDefault(); //return 중지
        if (filesArr.length > 0) {
            //socket 통신시 file buffer가 전달되어 name, size 등을 알수없어 전달
            for (let i = 0; i < filesArr.length; i++) {
                fileDataName[i] = filesArr[i].name;
                fileDataSize[i] = filesArr[i].size;
            };

            const data = {
                type: "Y", //첨부파일인지 생성파일인지 여부 - default : N
                page: "resume", //사용 page(page에 따라 조건이 다른경우) - default : upload
                path: "resume", //file upload 경로(/data/webtest/uploads/아래) - 없는 경우 생성 - defult : dummy
                source: filesArr, //file data
                multi: "Y", //file multiple인지 여부(video?) - defult : N
                idx: $("#scontent").data('midx'), //기능 idx
                name: fileDataName, //file name - file data에서 전달되지않아 따로 전달
                size: fileDataSize, //file size - file data에서 전달되지않아 따로 전달
                linktype: linktype, //file upload 후 처리 link가 다른경우
            };
            socket.emit('upload', data);
        } else {

            $('#next_form').submit();
        }
    }

    $('#saveBtn').on("click", function(e) {

        fnShowPop('write_pop');
    });

    function saveAction() {
        $("#next_form").attr("action", "/my/resume/modify/" + $("#scontent").data('idx') + "/saveaction");
        //fileUploadEmit();
        var newForm = $("#stltText").clone();
        newForm.attr("id", "rIntro_contents");
        newForm.attr("style", "display:none;");
        newForm.appendTo("#next_form");

        var addInput = document.createElement('input');
        addInput.setAttribute("type", "hidden");
        addInput.setAttribute("name", 'res_title');
        addInput.setAttribute("value", $('#rTitle').val());

        $("#next_form").append(addInput);
        if (!$("#rTitle").val()) {
            fnHidePop('write_pop');
            alert('제목을 입력해 주세요.');

            $("#rTitle").focus();
            return false;
        }
        if (filesArr.length > 0) {
            fileUploadEmit('save');
        } else {
            $("#next_form").submit();
        }
    }

    $(".more_link").on("click", function() {
        $("#next_form").attr("action", "/my/resume/modify/" + this.dataset['ridx'] + "/" + this.dataset['value']);

        var newForm = $("#stltText").clone();
        newForm.attr("id", "rIntro_contents");
        newForm.attr("style", "display:none;");
        newForm.appendTo("#next_form");

        var addInput = document.createElement('input');
        addInput.setAttribute("type", "hidden");
        addInput.setAttribute("name", 'res_title');
        addInput.setAttribute("value", $('#rTitle').val());
        $("#next_form").append(addInput);

        if (filesArr.length > 0) {
            fileUploadEmit('morelink');
        } else {
            $("#next_form").submit();
        }
        // 
    });

    socket.on('delete_complete', (data) => {

        fileDeleteLink(num);
    });

    function fileDeleteLink(num) {
        location.fref = "/my/resume/modify/" + $('#scontent').data('idx') + "/subdelete?type=rPortfolio&key=" + num;
    }
</script>