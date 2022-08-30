<?php
// print_r($data['decodeData']);
?>

<form action="/jobs/jobApplyAction" method="post" id="applyAction" enctype="multipart/form-data">
    <div id="interview_pr_mb" class="">
        <!--s top_tltBox-->
        <div class="top_tltBox c">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <a href="javascript:window.history.back();">
                    <div class="backBtn"><span>뒤로가기</span></div>
                </a>
                <?php if ($data['aData']['get']['state'] == 'C') : ?>
                    <div class="tlt">기업 인터뷰로 지원하기</div>
                <?php else : ?>
                    <div class="tlt">내 인터뷰로 지원하기</div>
                <?php endif; ?>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s popBox-->
        <div class="popBox pd_t10">
            <!--s pop_cont-->
            <div class="pop_cont wps_100">
                <!--s pop_cont_scroll-->
                <div class="pop_cont_scroll">
                    <!--s interview_pr_gytltBox-->
                    <div class="interview_pr_gytltBox">
                        <ul>
                            <?php
                            foreach ($data['job'] as $key => $val) :
                            ?>
                                <li id="applyRec<?= $key ?>">
                                    <a href="javascript:void(0)">
                                        <div class="tlt"><?= $data['job'][$key]['com_name'] ?></div>
                                        <div class="txt"><?= $data['job'][$key]['rec_title'] ?></div>
                                    </a>
                                    <input type="hidden" name="recIdx[]" value="<?= $data['job'][$key]['recIdx'] ?>">
                                    <?php if ($data['aData']['get']['state'] != 'C') : ?>
                                        <a href="javascript:void(0)" class="delet a_line deleteRec">삭제</a>
                                    <?php endif; ?>
                                </li>
                            <?php
                            endforeach
                            ?>
                        </ul>
                    </div>
                    <!--e interview_pr_gytltBox-->

                    <!--s 인터뷰(리포트) 선택-->
                    <div class="stltBox mg_t70">
                        <div class="stlt fl">인터뷰(리포트) 선택 <span class="point">*필수</span></div>
                        <?php if ($data['aData']['get']['state'] != 'C') : ?>
                            <div class="stlt_stxt fr" id="chInterview"><a href="javascript:void(0)" class="a_line">변경</a></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($data['compareCnt'] == '0') : ?>
                        <div class="red_txt mg_b15" id="notSame">! 직무가 일치하지 않습니다</div>
                    <?php endif; ?>

                    <div id="applyInterview">
                        <!--s itv_pr_reportBox-->
                        <div class="itv_pr_reportBox">
                            <?php if ($data['interviewInfo'] == 'N') : ?>

                            <?php else : ?>
                                <div class="top_txt"><?= $data['interviewInfo'][3] ?></div>
                                <a href="javascript:void(0)">
                                    <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $data['interviewInfo'][2] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                </a>
                                <a href="javascript:void(0)">
                                    <!--s txtBox-->
                                    <div class="txtBox">
                                        <div class="class"><?= $data['reportInfo'][1] ?></div>
                                        <div class="tlt">[ <?= $data['interviewInfo'][1] ?> ]</div>
                                        <div class="question">질문 <?= $data['reportInfo'][0] ?>개</div>
                                        <div class="data"><?= $data['interviewInfo'][0] ?></div>
                                    </div>
                                    <!--e txtBox-->
                                </a>
                                <?php if ($data['reportInfo'][1] != '-' && $data['reportInfo'][1] != null && $data['reportInfo'][1] != '') : ?>
                                    <a href="/report/detail/<?= $data['enIdx'] ?>" class="itv_btn"><img src="/static/www/img/sub/itv_pr_pop_arrow_r.png"></a>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                        <!--e itv_pr_reportBox-->
                    </div>

                    <?php if ($data['aData']['get']['state'] != 'C') : ?>
                        <div class="pl_btn c mg_t35"><a href="/interview/ready?type=A&rec=<?= $data['job'][$key]['recIdx'] ?>">+ 새 인터뷰 하기</a></div>
                    <?php endif; ?>
                    <!--e 인터뷰(리포트) 선택-->

                    <!--s 이력서 첨부-->
                    <div class="stltBox mg_t70">
                        <div class="stlt fl">
                            이력서 첨부
                            <?php if ($data['rCount'] == 0) : ?>
                                <span class="point">*선택</span>
                            <?php else : ?>
                                <span class="point">*필수</span>
                            <?php endif; ?>
                        </div>
                        <div class="stlt_stxt fr" id="chResume"><a href="javascript:void(0)" class="a_line">변경</a></div>
                    </div>

                    <!--s gray_fileBox-->
                    <div class="gray_fileBox resume_fileBox">
                        <ul>
                            <li id="applyResume">
                                <?php if ($data['resume'] == 'N') : ?>
                                    <div>등록된 이력서가 없습니다.</div>
                                <?php else : ?>
                                    <!-- <div class="tlt">(이력서idx) <?= $data['resume']['idx'] ?></div> -->
                                    <div class="tlt"><?= $data['resume']['res_title'] ?></div>
                                    <div class="txt"><?= $data['resume']['res_reg_date'] ?> 작성</div>

                                    <div class="arrow" id="seeResume"><img src="/static/www/img/sub/itv_pr_file_arrow.png"></div>
                                    <div class="close deleteResume" id="deleteResume"><img src="/static/www/img/sub/itv_pr_file_close.png"></div>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                    <!--e gray_fileBox-->

                    <div class="pl_btn c mg_t35"><a href="/my/resume/modify/0?app=<?= $data['getAppIdx'] ?>&data=<?= $data['getData'] ?>">+ 새로 작성하기</a></div>
                    <!--e 이력서 첨부-->

                    <!--s 첨부파일 업로드-->
                    <div class="stltBox mg_t70">
                        <div class="stlt fl">첨부파일 업로드 <span class="point">*선택</span></div>
                        <!-- <div class="stlt_stxt fr"><a href="javascript:void(0)" class="a_line">변경</a></div> -->
                    </div>

                    <!--s gray_fileBox-->
                    <div class="gray_fileBox upload_fileBox">
                        <ul id="fileList">
                            <!-- <li>
                                <div class="tlt">파일명 파일명.PDF</div>
                                <div class="close"><img src="/static/www/img/sub/itv_pr_file_close.png"></div>
                            </li> -->
                        </ul>
                    </div>
                    <!--e gray_fileBox-->

                    <!-- <div id="fileWrap">
                        <input type="file" name="file[]" id="" accept="" onchange="fileCount()">
                    </div>
                    <div class="pl_btn c mg_t35"><a href="javascript:void(0)">+ 첨부파일 추가하기</a></div> -->

                    <!-- --------------- 추가 s --------------- -->

                    <!-- <div id="submitFiles">
                        <label for="profileFile">
                            <div class="pl_btn c mg_t35"><a>+ 첨부파일 추가하기</a></div>
                        </label>
                        <input type="file" name="file[]" id="profileFile" class="hide" accept="" onchange="addFile(this)" onclick="alert(0)" multiple>
                    </div> -->

                    <div id="fileWrap">
                        <label for="profileFile">
                            <div class="pl_btn c mg_t35"><a>+ 첨부파일 추가하기</a></div>
                        </label>
                        <input type="file" name="file[]" id="profileFile" name="profileFile" data-filebox="#fileList" style="display:none">
                    </div>


                    <!-- <div class="more_btn fr">
                        <label for="profileFile"><img src="<?= $data['url']['menu'] ?>/static/www/img/sub/sm_plus_icon.png"></label>
                        <input type="file" id="profileFile" name="profileFile" data-filebox=".filebox" style="display:none">
                    </div> -->

                    <!-- --------------- 추가 e --------------- -->

                    <!--e 첨부파일 업로드-->

                    <!-- <div class="itv_pr_preview_btn r mg_t40 mg_b70"><a href="javascript:void(0)" class="a_line">미리보기</a></div> -->
                </div>
                <!--e pop_cont_scroll-->

                <!--s fix_btBtn2-->
                <div class="fix_btBtn2" id="submitApply">
                    <div class="fix_btBtn">
                        <a href="javascript:void(0)" class="fix_btn02 wps_100">(<span id="appCnt"><?= count($data['job']) ?></span>)건 지원하기</a>
                    </div>
                </div>
                <!--e fix_btBtn2-->
            </div>
            <!--e pop_cont-->
        </div>
        <!--e popBox-->
    </div>

    <!-- FORM -->
    <div>
        <?= csrf_field() ?>
        <!-- recState -->
        <input type="hidden" name="applyState" value="<?= $data['decodeData']['state'] ?>"><br>
        <!-- enData(암호회된 idx들)  -->
        <input type="hidden" name="enData" value="<?= $data['aData']['get']['recIdx'] ?>"><br>
        <!-- mem_idx(회원)  -->
        <input type="hidden" name="memIdx" value="<?= $data['session']['idx'] ?>"><br>
        <!-- app_idx(인터뷰)  -->
        <input type="hidden" name="appIdx" id="appIdx" value="<?= $data['appEnIdx'] ?>"><br>
        <!-- app_files(첨부파일)  -->
        <input type="hidden" name="appFiles" id="appFiles" value=""><br>

        <?php if ($data['resume'] != 'N') : ?>
            <!-- res_idx(이력서)  -->
            <input type="hidden" name="resIdx" id="resIdx" value="<?= $data['enResume'] ?>"><br>
        <?php endif; ?>

        <?php
        foreach ($data['job'] as $val) :
        ?>
            <!-- com_idx  -->
            <input type="hidden" name="comIdx[]" value="<?= $val['comIdx'] ?>"><br>
        <?php
        endforeach;
        ?>

        <!-- <?php
                foreach ($data['_idx'] as $val) :
                ?>
            rec_idx <input type="text" name="recIdx[]" value="<?= $val ?>"><br>
        <?php
                endforeach;
        ?> -->

        <div id="recIdxs"></div>
    </div>
</form>

<script src="<?= $data['url']['menu'] ?>/plugins/fileupload/fileupload.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.socket.io/4.2.0/socket.io.min.js" integrity="sha384-PiBR5S00EtOj2Lto9Uu81cmoyZqR57XcOna1oAuVuIEjzj0wpqDVfD0JA9eXlRsj" crossorigin="anonymous"></script>

<script>
    const applyState = '<?= $data['aData']['get']['state'] ?>';
    const jobIdx = '<?= json_encode($data['jobIdx']) ?>';
    const resumeState = '<?= $data['rCount'] ?>';
    let decodeData = JSON.parse('<?= json_encode($data['decodeData']) ?>');
    let interIdx = <?= json_encode($data['interviewInfo']) ?>;
    let resIdx = <?= json_encode($data['resume']) ?>;
    let selected = '';
    let selectedInfo = '';
    let selectedGrade = '';
    let selectedResume = '';
    let selectedResumeRadio = '';
    let appCnt = $('#appCnt').text();
    let decodeState = decodeData['state'];
    let decodeIdx = decodeData['idx'];
    let submitFlag = true;

    //첨부파일
    var fileDataName = new Array();
    var fileDataSize = new Array();

    $(document).ready(function() {
        // 리포트변경
        $('#reportBtnBox > button').on('click', function() {
            let rdoVal = selectIdx;

            if ($(this).val() == 'ok') {
                if (rdoVal == "" || rdoVal == undefined) {
                    alert('리포트를 선택해주세요.');
                } else {
                    $('#applyInterview').html(selectEle);
                    $('#appIdx').val(rdoVal);
                    $('.rs_chkBox ').addClass('hide');
                    $('javascript:void(0)otSame').hide();
                    alert('리포트가 변경되었습니다.');
                    fnHidePop('changeReport');
                }
            } else if ($(this).val() == 'no') {
                fnHidePop('changeReport');
            }
        });

        // 이력서변경
        $('#resumeBtnBox > button').on('click', function() {
            let resVal = selectResumeIdx;

            if ($(this).val() == 'ok') {
                if (resVal == "" || resVal == undefined) {
                    alert('이력서를 선택해주세요.');
                } else {
                    $('#applyResume').html(selectResumeEle);
                    $('#resIdx').val(resVal);
                    $('.rs_chkBox ').addClass('hide');
                    alert('이력서가 변경되었습니다.');
                    $('.resumeBtns').show();
                    fnHidePop('changeResume');
                }
            } else if ($(this).val() == 'no') {
                fnHidePop('changeResume');
            }
        });
    });


    $('#chInterview').on('click', function() {
        fnShowPop('changeReport');
    });

    $('#chResume').on('click', function() {
        fnShowPop('changeResume');
    });

    // 이력서삭제
    $(document).on('click', '.deleteResume', function() {
        alert('이력서가 삭제되었습니다.');
        $('#applyResume').empty();
        $('#applyResume').text('이력서를 첨부해주세요');
        $('#resIdx').val("");
    });

    $('.deleteRec').on('click', function() {
        const emlThis = $(this);
        const recCnt = $('.deleteRec').length;

        if (recCnt == 1) {
            alert('공고가 1개이상 있어야합니다.');
        } else {
            emlThis.closest('li').remove();
            alert('공고가 삭제되었습니다.');
            $('#appCnt').text(appCnt - 1);
        }
    });

    $('#submitApply').on('click', function() {
        fileUploadEmit();
    });

    $("#applyAction").validate({
        ignore: [],
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때

            if (interIdx == 'N' || $('#appIdx').val() == "") {
                alert('인터뷰를 선택해주세요.');
                return false;
            }
            if (resumeState != 0) {
                if (resIdx == 'N' || $('#resIdx').val() == "") {
                    alert('이력서를 선택해주세요.');
                    return false;
                }
            }

            if (submitFlag) {
                submitFlag = false;
                form.submit();
            }
        }
    });


    // 파일 목록 추가
    function fileHtml(selecter, file, fileNo) {
        let no = 0;
        let fileName = file.name;
        let fNo = 0;

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
        htmlData += '<li id="file' + fileNo + '">';
        htmlData += `<div class="tlt">${fileName}</div>`;
        htmlData += `<div class="close filedelete" data-value="${fileNo}" data-name="${file.name}"><img src="/static/www/img/sub/itv_pr_file_close.png"></div>`;
        htmlData += '</li>';

        $('#fileList').append(htmlData);
    }

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
                idx: $("#scontent").data('idx'), //기능 idx
                name: fileDataName, //file name - file data에서 전달되지않아 따로 전달
                size: fileDataSize, //file size - file data에서 전달되지않아 따로 전달
                linktype: linktype, //file upload 후 처리 link가 다른경우
            };
            socket.emit('upload', data);
        } else {
            $('#applyAction').submit();
        }
    }

    socket.on('complete', (data) => {
        console.log('complete');

        var eDList = new Array();
        let fileLen = $('#fileList > li').length - filesArr.length;
        let i = 0;
        $('#fileList > li').each(function() {
            var eData = new Object();
            eData.num = i;

            if (i >= fileLen) {
                eData.saveName = data[i - fileLen].filePath;
                eData.fileSize = fileDataSize[i - fileLen];
            } else {
                eData.saveName = $('#fileList > li:eq(' + i + ') > div:eq(1)').data('files');
                eData.fileSize = $('#fileList > li:eq(' + i + ') > div:eq(1)').data('size');
            }

            eData.originName = $('#fileList > li:eq(' + i + ') > div:eq(0)').html();

            eDList.push(eData);
            i++;
        })

        var jsonData = JSON.stringify(eDList);
        $('#appFiles').val(jsonData);
        $('#applyAction').submit();
    });

    function fileCount() {
        let fileCnt = $('input[name*=file]').length;

        if (fileCnt < 3) {
            $('#fileWrap').append('file' + (fileCnt + 1) + '<input type="file" name="file[]" id="" accept="" onchange="fileCount()"><br>');
        }
    }

    // function chInterview() {
    //     if (selected == "" || selected == null) {
    //         alert('인터뷰를 선택해주세요.');
    //     } else {
    //         var isSame = 0;
    //         for (i = 0; i < jobIdx.length; i++) {
    //             if (jobIdx[i] == selected) {
    //                 isSame++;
    //             }
    //         }

    //         if (isSame == '0') {
    //             $('#isSame').text('직무가 일치하지 않습니다.');
    //         } else {
    //             $('#isSame').text('직무가 일치합니다.');
    //         }

    //         $('#applyInterview').empty();

    //         let aInfo = selectedInfo['code']['info'][0]['itv'][selected];
    //         let aCnt = selectedInfo['code']['info'][0]['cnt'][selected]['cnt'];
    //         let shareState = aInfo['app_share'];

    //         if (shareState == 0) {
    //             shareState = '비공개';
    //         } else {
    //             shareState = '공게';
    //         }

    //         $('#applyInterview').html(
    //             `
    //             <div class="top_txt">${shareState}</div>
    //                 <a href="javascript:void(0)"><div class="imgBox"><img src="<?= $data['url']['menu'] ?>/storage/uploads?path=${aInfo['file_save_name']}"></div></a>
    //         		<a href="javascript:void(0)">
    //         			<div class="txtBox">
    //         				<div class="class">${selectedGrade[selected]} / (idx) ${aInfo['idx']}</div>
    //         				<div class="tlt">[ ${aInfo['job_depth_text']} ]</div>
    //         				<div class="question">질문 ${aCnt}개</div>

    //         				<div class="data">${aInfo['app_reg_date']}</div>
    //         			</div>
    //         		</a>
    //         		<a href="javascript:void(0)" class="itv_btn"><img src="/static/www/img/sub/itv_pr_pop_arrow_r.png"></a>
    //             `
    //         );

    //         $('#appIdx').val(`${aInfo['idx']}`);
    //         alert('인터뷰가 변경되었습니다.');
    //         swal.close();
    //     }
    // }
</script>