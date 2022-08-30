<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">경력</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <div class="formall">
            <?php
            if (!empty($data['postData']['career']['resumeSub'])) :
                foreach ($data['postData']['career']['resumeSub'] as $key => $val) :
            ?>
                    <!--s inp_dlBox-->
                    <div class="inp_dlBox">
                        <dl class="inp_dl del_btn">
                            <dd>
                                <div class="pl_btn r mg_t35"><a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete/career?type=career&key=<?= $key ?>" class='formadd'>삭제하기</a></div>
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>회사명 <span class="point">*</span></dt>
                            <dd>
                                <input type="text" name="cName[]" id="" class="wps_100" value="<?= $data['postData']['career']['resumeSub'][$key]['cName'] ?? '' ?>" placeholder="">
                            </dd>
                        </dl>

                        <div class="wd50Box_dl">
                            <dl class="inp_dl">
                                <dt>입사</dt>
                                <dd><input type="month" name="sDate[]" id="" class="wps_100" value="<?= $data['postData']['career']['resumeSub'][$key]['sDate'] ? substr($data['postData']['career']['resumeSub'][$key]['sDate'], 0, 4) . '-' . substr($data['postData']['career']['resumeSub'][$key]['sDate'], 4, 2) : '' ?>" placeholder="YYYY.MM"></dd>
                            </dl>

                            <dl class="inp_dl">
                                <dt>퇴사</dt>
                                <dd><input type="month" name="eDate[]" id="" class="wps_100" value="<?= $data['postData']['career']['resumeSub'][$key]['eDate'] ? substr($data['postData']['career']['resumeSub'][$key]['eDate'], 0, 4) . '-' . substr($data['postData']['career']['resumeSub'][$key]['eDate'], 4, 2) : '' ?>" placeholder="YYYY.MM"></dd>
                            </dl>
                        </div>


                        <dl class="inp_dl">
                            <dt>부서명/직책</dt>
                            <dd><input type="text" name="depName[]" id="" class="wps_100" value="<?= $data['postData']['career']['resumeSub'][$key]['depName'] ?>" placeholder="부서명과 직책을 입력해주세요"></dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>연봉</dt>
                            <dd><input type="number" name="cpay[]" id="" class="wps_100" value="<?= $data['postData']['career']['resumeSub'][$key]['cpay'] ?? '' ?>" placeholder="연봉을 입력해주세요"></dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>주요업무 <span class="point">*</span></dt>
                            <dd><input type="text" name="business[]" id="" class="wps_100" value="<?= $data['postData']['career']['resumeSub'][$key]['business'] ?? '' ?>" placeholder="주요업무를 입력해주세요"></dd>
                        </dl>
                    </div>
                    <!--e inp_dlBox-->
                <?php
                endforeach;
            else :
                ?>
                <!--s inp_dlBox-->
                <div class="inp_dlBox">
                    <dl class="inp_dl del_btn hide">
                        <dd>
                            <div class="pl_btn r mg_t35">
                                <a href="" class='formadd'>삭제하기</a>
                            </div>
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>회사명 <span class="point">*</span></dt>
                        <dd>
                            <input type="text" name="cName[]" id="" class="wps_100" placeholder="">
                        </dd>
                    </dl>

                    <div class="wd50Box_dl">
                        <dl class="inp_dl">
                            <dt>입사</dt>
                            <dd><input type="month" name="sDate[]" id="" class="wps_100" placeholder="YYYYMM"></dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>퇴사</dt>
                            <dd><input type="month" name="eDate[]" id="" class="wps_100" placeholder="YYYYMM"></dd>
                        </dl>
                    </div>


                    <dl class="inp_dl">
                        <dt>부서명/직책</dt>
                        <dd><input type="text" name="depName[]" id="" class="wps_100" placeholder="부서명과 직책을 입력해주세요"></dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>연봉</dt>
                        <dd><input type="number" name="cpay[]" id="" class="wps_100" value="" placeholder="연봉을 입력해주세요(ex:5000)"></dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>주요업무 <span class="point">*</span></dt>
                        <dd><input type="text" name="business[]" id="" class="wps_100" placeholder="주요업무를 입력해주세요"></dd>
                    </dl>
                </div>
                <!--e inp_dlBox-->
            <?php
            endif;
            ?>
        </div>

        <div class="pl_btn c mg_t35 formadd"><a href="javascript:void(0);">+ 경력 추가</a></div>

        <!--s BtnBox-->
        <div class="BtnBox">
            <button type="button" id="savebtn" class="btn btn01 wps_100">저장</button>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e cont-->
    <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/career" method="POST" id="next_form">
        <?= csrf_field() ?>
    </form>

</div>
<!--e #scontent-->

<script>
    $(".formadd").on("click", function(e) {
        var newForm = $(".inp_dlBox").last().clone().appendTo(".formall");
        resumeDelBtnSet(newForm);
        newForm.find("input").val("");
    });

    $(document).on('click', '.remove_btn', function() {
        $(this).closest('.inp_dlBox').remove();
    });

    $("#savebtn").on("click", function() {
        var eDList = new Array();
        for (let i = 0; i < $("input[name='cName[]']").length; i++) {
            if (!$("input[name='cName[]']").eq(i).val()) {
                alert('회사명을 입력해 주세요.');
                return false;
            }
            if (!$("input[name='business[]']").eq(i).val()) {
                alert('주요업무를 입력해 주세요.');
                return false;
            }

            var eData = new Object();
            eData.num = i;
            eData.cName = $("input[name='cName[]']").eq(i).val();
            eData.sDate = $("input[name='sDate[]']").eq(i).val();
            eData.eDate = $("input[name='eDate[]']").eq(i).val();
            eData.depName = $("input[name='depName[]']").eq(i).val();
            eData.business = $("input[name='business[]']").eq(i).val();
            eData.cpay = $("input[name='cpay[]']").eq(i).val();

            eDList.push(eData);
        }
        var jsonData = JSON.stringify(eDList);

        var addInput = document.createElement('input');
        //addInput.setAttribute("type", "hidden"); 
        addInput.setAttribute("name", 'resumeSub');
        addInput.setAttribute("value", jsonData);
        $("#next_form").append(addInput);


        $("#next_form").submit();
    });
</script>