<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">학력</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <div class="formall">
            <?php
            if (!empty($data['postData']['education']['resumeSub'])) :
                foreach ($data['postData']['education']['resumeSub'] as $key => $val) :
            ?>
                    <!--s inp_dlBox-->
                    <div class="inp_dlBox">
                        <dl class="inp_dl del_btn">
                            <dd>
                                <div class="pl_btn r mg_t35"><a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete/education?type=education&key=<?= $key ?>" class='formadd'>삭제하기</a></div>
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <!--<dt>구분 <span class="point">*</span></dt>-->
                            <dd>
                                <!--s position_ckBox-->
                                <div class="position_ckBox fl_wd3">
                                    <ul>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eSchoolType1<?= $key ?>" name="eSchoolType<?= $key ?>" value='H' <?= $data['postData']['education']['resumeSub'][$key]['eSchoolType']  == 'H' ? 'checked' : "" ?>>
                                                <label for="eSchoolType1<?= $key ?>">고등학교</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eSchoolType2<?= $key ?>" name="eSchoolType<?= $key ?>" value='C' <?= $data['postData']['education']['resumeSub'][$key]['eSchoolType']  == 'C' ? 'checked' : "" ?>>
                                                <label for="eSchoolType2<?= $key ?>">대학교(2~3년)</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eSchoolType3<?= $key ?>" name="eSchoolType<?= $key ?>" value='U' <?= $data['postData']['education']['resumeSub'][$key]['eSchoolType']  == 'U' ? 'checked' : "" ?>>
                                                <label for="eSchoolType3<?= $key ?>">대학교(4년)</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eSchoolType4<?= $key ?>" name="eSchoolType<?= $key ?>" value='M' <?= $data['postData']['education']['resumeSub'][$key]['eSchoolType']  == 'M' ? 'checked' : "" ?>>
                                                <label for="eSchoolType4<?= $key ?>">석사</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eSchoolType5<?= $key ?>" name="eSchoolType<?= $key ?>" value='D' <?= $data['postData']['education']['resumeSub'][$key]['eSchoolType']  == 'D' ? 'checked' : "" ?>>
                                                <label for="eSchoolType5<?= $key ?>">박사</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!--e position_ckBox-->
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>학교명 <span class="point">*</span></dt>
                            <dd>
                                <input type="text" name="eName[]" id="" class="wps_100" value="<?= $data['postData']['education']['resumeSub'][$key]['eName'] ?>" placeholder="">
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>학과명</dt>
                            <dd>
                                <input type="text" name="cName[]" id="" class="wps_100" value="<?= $data['postData']['education']['resumeSub'][$key]['cName'] ?>" placeholder="">
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>재학년도 <span class="point">*</span></dt>
                            <dd>
                                <!--s position_ckBox-->
                                <div class="position_ckBox fl_wd3">
                                    <ul>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eGradType1<?= $key ?>" name="eGradType<?= $key ?>" value='A' <?= $data['postData']['education']['resumeSub'][$key]['eGradType']  == 'A' ? 'checked' : "" ?>>
                                                <label for="eGradType1<?= $key ?>">재학중</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eGradType2<?= $key ?>" name="eGradType<?= $key ?>" value='B' <?= $data['postData']['education']['resumeSub'][$key]['eGradType']  == 'B' ? 'checked' : "" ?>>
                                                <label for="eGradType2<?= $key ?>">졸업</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="eGradType3<?= $key ?>" name="eGradType<?= $key ?>" value='C' <?= $data['postData']['education']['resumeSub'][$key]['eGradType']  == 'C' ? 'checked' : "" ?>>
                                                <label for="eGradType3<?= $key ?>">휴학</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!--e position_ckBox-->
                                <div class="wd50Box2">
                                    <input type="month" name="sYearMonth[]" id="" class="" value="<?= $data['postData']['education']['resumeSub'][$key]['sYearMonth'] ? substr($data['postData']['education']['resumeSub'][$key]['sYearMonth'], 0, 4) . '-' . substr($data['postData']['education']['resumeSub'][$key]['sYearMonth'], 4, 2) : '' ?>" placeholder="입학년도(ex:YYYYMM)" maxlength="6">
                                    <input type="month" name="eYearMonth[]" id="" class="" value="<?= $data['postData']['education']['resumeSub'][$key]['eYearMonth'] ? substr($data['postData']['education']['resumeSub'][$key]['eYearMonth'], 0, 4) . '-' . substr($data['postData']['education']['resumeSub'][$key]['eYearMonth'], 4, 2) : '' ?>" placeholder="졸업 or 휴학년도(ex:YYYYMM)" maxlength="6">
                                </div>
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>학점</dt>
                            <dd>
                                <div class="wd50Box2">
                                    <input type="text" name="score[]" id="" class="" value="<?= $data['postData']['education']['resumeSub'][$key]['score'] ?>" placeholder="학점">
                                    <input type="text" name="tscore[]" id="" class="" value="<?= $data['postData']['education']['resumeSub'][$key]['tscore'] ?>" placeholder="학점">
                                </div>
                            </dd>
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
                        <!--<dt>구분 <span class="point">*</span></dt>-->
                        <dd>
                            <!--s position_ckBox-->
                            <div class="position_ckBox fl_wd3">
                                <ul>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eSchoolType10" name="eSchoolType0" value='H'>
                                            <label for="eSchoolType10">고등학교</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eSchoolType20" name="eSchoolType0" value='C'>
                                            <label for="eSchoolType20">대학교(2~3년)</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eSchoolType30" name="eSchoolType0" value='U'>
                                            <label for="eSchoolType30">대학교(4년)</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eSchoolType40" name="eSchoolType0" value='M'>
                                            <label for="eSchoolType40">석사</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eSchoolType50" name="eSchoolType0" value='D'>
                                            <label for="eSchoolType50">박사</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--e position_ckBox-->
                        </dd>
                    </dl>
                    <dl class="inp_dl">
                        <dt>학교명 <span class="point">*</span></dt>
                        <dd>
                            <input type="text" name="eName[]" id="" class="wps_100" value="" placeholder="">
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>학과명</dt>
                        <dd>
                            <input type="text" name="cName[]" id="" class="wps_100" value="" placeholder="">
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>재학년도 <span class="point">*</span></dt>
                        <dd>
                            <!--s position_ckBox-->
                            <div class="position_ckBox fl_wd3">
                                <ul>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eGradType10" name="eGradType0" value='A'>
                                            <label for="eGradType10">재학중</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eGradType20" name="eGradType0" value='B'>
                                            <label for="eGradType20">졸업</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="eGradType30" name="eGradType0" value='C'>
                                            <label for="eGradType30">휴학</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--e position_ckBox-->
                            <div class="wd50Box2">
                                <input type="month" name="sYearMonth[]" id="" class="" value="" placeholder="입학년도(ex:YYYYMM)" maxlength="6">
                                <input type="month" name="eYearMonth[]" id="" class="" value="" placeholder="졸업 or 휴학년도(ex:YYYYMM)" maxlength="6">
                            </div>
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>학점</dt>
                        <dd>
                            <div class="wd50Box2">
                                <input type="text" name="score[]" id="" class="" value="" placeholder="학점">
                                <input type="text" name="tscore[]" id="" class="" value="" placeholder="총학점">
                            </div>
                        </dd>
                    </dl>
                </div>
                <!--e inp_dlBox-->
            <?php
            endif;
            ?>
        </div>


        <div class="pl_btn c mg_t35"><a href="javascript:void(0);" class='formadd'>+ 학력 추가</a></div>

        <!--s BtnBox-->
        <div class="BtnBox">
            <button type="button" id="savebtn" class="btn btn01 wps_100">저장</button>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e cont-->
    <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/education" method="POST" id="next_form">
        <?= csrf_field() ?>
    </form>
</div>
<!--e #scontent-->

<script>
    $(".formadd").on("click", function(e) {
        var newForm = $(".inp_dlBox").last().clone();

        newForm.find('input:radio').each(function() {
            $(this).attr("name", $(this).attr("name").slice(0, -1) + (Number($(this).attr("name").slice(-1)) + 1));
            var thisid = $(this).attr("id");
            $(this).attr("id", $(this).attr("id").slice(0, -1) + (Number($(this).attr("id").slice(-1)) + 1));
            $(this).siblings("label").attr("for", $(this).attr("id"));

            //$(this).prop("checked", false);
        });

        resumeDelBtnSet(newForm);

        newForm.find("input:text").val("");
        newForm.find("input:radio").prop("checked", false);
        newForm.appendTo(".formall");
    });

    $(document).on('click', '.remove_btn', function() {
        $(this).closest('.inp_dlBox').remove();
    });

    $("#savebtn").on("click", function() {
        var eDList = new Array();
        for (let i = 0; i < $("input[name='eName[]']").length; i++) {
            if (!$("input[name='eName[]']").eq(i).val()) {
                alert('학교명을 입력해 주세요.');
                return false;
            }
            if(!$('input[name^="eSchoolType"]:checked').eq(i).length){
                alert('학교 유형을 입력해 주세요.');
                return false;
            }

            if(!$('input[name^="eGradType"]:checked').eq(i).length){
                alert('재학년도를 입력해 주세요.');
                return false;
            }

            var eData = new Object();
            eData.num = i;

            eData.eSchoolType = $("input[name ^='eSchoolType']:checked").eq(i).val();
            eData.eGradType = $("input[name ^='eGradType']:checked").eq(i).val();
            eData.eName = $("input[name='eName[]']").eq(i).val();
            eData.cName = $("input[name='cName[]']").eq(i).val();
            eData.sYearMonth = $("input[name='sYearMonth[]']").eq(i).val();
            eData.eYearMonth = $("input[name='eYearMonth[]']").eq(i).val();
            eData.score = $("input[name='score[]']").eq(i).val();
            eData.tscore = $("input[name='tscore[]']").eq(i).val();

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