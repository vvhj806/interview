<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">자격증</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <div class="formall">
            <?php
            if (!empty($data['postData']['license']['resumeSub'])) :
                foreach ($data['postData']['license']['resumeSub'] as $key => $val) :
            ?>
                    <!--s inp_dlBox-->
                    <div class="inp_dlBox">
                        <dl class="inp_dl del_btn">
                            <dd>
                                <div class="pl_btn r mg_t35"><a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete/license?type=license&key=<?= $key ?>" class='formadd'>삭제하기</a></div>
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>자격증명</dt>
                            <dd>
                                <input type="text" name="lName[]" id="" class="wps_100" value="<?= $data['postData']['license']['resumeSub'][$key]['lName'] ?>" placeholder="">
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>발행처/기관</dt>
                            <dd>
                                <input type="text" name="lPublicOrg[]" id="" class="wps_100" value="<?= $data['postData']['license']['resumeSub'][$key]['lPublicOrg'] ?>" placeholder="발행처/기관을 입력해주세요">
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>합격여부</dt>
                            <dd>
                                <!--s position_ckBox-->
                                <div class="position_ckBox fl_wd2">
                                    <ul>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lLevel1<?= $key ?>" name="lLevel<?= $key ?>" value='1차합격' <?= $data['postData']['license']['resumeSub'][$key]['lLevel'] == '1차합격' ? 'checked' : "" ?>>
                                                <label for="lLevel1<?= $key ?>">1차합격</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lLevel2<?= $key ?>" name="lLevel<?= $key ?>" value='2차합격' <?= $data['postData']['license']['resumeSub'][$key]['lLevel'] == '2차합격' ? 'checked' : "" ?>>
                                                <label for="lLevel2<?= $key ?>">2차합격</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lLevel3<?= $key ?>" name="lLevel<?= $key ?>" value='필기합격' <?= $data['postData']['license']['resumeSub'][$key]['lLevel'] == '필기합격' ? 'checked' : "" ?>>
                                                <label for="lLevel3<?= $key ?>">필기합격</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lLevel4<?= $key ?>" name="lLevel<?= $key ?>" value='실기합격' <?= $data['postData']['license']['resumeSub'][$key]['lLevel'] == '실기합격' ? 'checked' : "" ?>>
                                                <label for="lLevel4<?= $key ?>">실기합격</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lLevel5<?= $key ?>" name="lLevel<?= $key ?>" value='최종합격' <?= $data['postData']['license']['resumeSub'][$key]['lLevel'] == '최종합격' ? 'checked' : "" ?>>
                                                <label for="lLevel5<?= $key ?>">최종합격</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!--e position_ckBox-->
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>취득일</dt>
                            <dd>
                                <input type="month" name="lObtainDate[]" id="" class="wps_100" value="<?= $data['postData']['license']['resumeSub'][$key]['lObtainDate'] ? substr($data['postData']['license']['resumeSub'][$key]['lObtainDate'], 0, 4) . '-' . substr($data['postData']['license']['resumeSub'][$key]['lObtainDate'], 4, 2) : '' ?>" maxlength="6" placeholder="시작일(ex:YYYYMM)">
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
                        <dt>자격증명 <span class="point">*</span></dt>
                        <dd>
                            <input type="text" name="lName[]" id="" class="wps_100" placeholder="">
                        </dd>
                    </dl>
                    <dl class="inp_dl">
                        <dt>발행처/기관 <span class="point">*</span></dt>
                        <dd>
                            <input type="text" name="lPublicOrg[]" id="" class="wps_100" placeholder="발행처/기관을 입력해주세요">
                        </dd>
                    </dl>
                    <dl class="inp_dl">
                        <dt>합격여부 <span class="point">*</span></dt>
                        <dd>
                            <!--s position_ckBox-->
                            <div class="position_ckBox fl_wd2">
                                <ul>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lLevel10" name="lLevel0" value='1차합격' checked>
                                            <label for="lLevel10">1차합격</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lLevel20" name="lLevel0" value='2차합격'>
                                            <label for="lLevel20">2차합격</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lLevel30" name="lLevel0" value='필기합격'>
                                            <label for="lLevel30">필기합격</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lLevel40" name="lLevel0" value='실기합격'>
                                            <label for="lLevel40">실기합격</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lLevel50" name="lLevel0" value='최종합격'>
                                            <label for="lLevel50">최종합격</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--e position_ckBox-->
                        </dd>
                    </dl>
                    <dl class="inp_dl">
                        <dt>취득일</dt>
                        <dd>
                            <input type="month" name="lObtainDate[]" id="" class="wps_100" maxlength="6" placeholder="YYYYMM">
                        </dd>
                    </dl>
                </div>
                <!--e inp_dlBox-->
            <?php
            endif;
            ?>
        </div>

        <div class="pl_btn c mg_t35 formadd"><a href="javascript:void(0);">+ 항목 추가</a></div>

        <!--s BtnBox-->
        <div class="BtnBox">
            <button type="button" id="savebtn" class="btn btn01 wps_100">저장</button>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e cont-->
    <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/license" method="POST" id="next_form">
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
        for (let i = 0; i < $("input[name='lName[]']").length; i++) {
            if (!$("input[name='lName[]']").eq(i).val()) {
                alert('자격증명을 입력해 주세요.');
                return false;
            }

            if (!$("input[name='lPublicOrg[]']").eq(i).val()) {
                alert('발행처/기관을 입력해 주세요.');
                return false;
            }

            if (!$("input[name='lPublicOrg[]']").eq(i).val()) {
                alert('발행처/기관을 입력해 주세요.');
                return false;
            }

            var eData = new Object();
            eData.num = i;
            eData.lName = $("input[name='lName[]']").eq(i).val();
            eData.lPublicOrg = $("input[name='lPublicOrg[]']").eq(i).val();
            eData.lLevel = $("input[name ^='lLevel']:checked").eq(i).val();
            eData.lObtainDate = $("input[name='lObtainDate[]']").eq(i).val();

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