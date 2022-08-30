<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">외국어</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <div class="formall">
            <?php
            if (!empty($data['postData']['language']['resumeSub'])) :
                foreach ($data['postData']['language']['resumeSub'] as $key => $val) :
            ?>
                    <!--s inp_dlBox-->
                    <div class="inp_dlBox">
                        <dl class="inp_dl del_btn">
                            <dd>
                                <div class="pl_btn r mg_t35"><a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete/language?type=language&key=<?= $key ?>" class='formadd'>삭제하기</a></div>
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>시험종류 <span class="point">*</span></dt>
                            <dd>
                                <!--s position_ckBox-->
                                <div class="position_ckBox fl_wd3">
                                    <ul>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lName1<?= $key ?>" name="lName<?= $key ?>" value='TOEIC' <?= $data['postData']['language']['resumeSub'][$key]['lName']  == 'TOEIC' ? 'checked' : "" ?>>
                                                <label for="lName1<?= $key ?>">TOEIC</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lName2<?= $key ?>" name="lName<?= $key ?>" value='TOFEL' <?= $data['postData']['language']['resumeSub'][$key]['lName']  == 'TOFEL' ? 'checked' : "" ?>>
                                                <label for="lName2<?= $key ?>">TOFEL</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lName3<?= $key ?>" name="lName<?= $key ?>" value='TEPS' <?= $data['postData']['language']['resumeSub'][$key]['lName']  == 'TEPS' ? 'checked' : "" ?>>
                                                <label for="lName3<?= $key ?>">TEPS</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lName4<?= $key ?>" name="lName<?= $key ?>" value='OPIC' <?= $data['postData']['language']['resumeSub'][$key]['lName']  == 'OPIC' ? 'checked' : "" ?>>
                                                <label for="lName4<?= $key ?>">OPIC</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lName5<?= $key ?>" name="lName<?= $key ?>" value='JPT' <?= $data['postData']['language']['resumeSub'][$key]['lName']  == 'JPT' ? 'checked' : "" ?>>
                                                <label for="lName5<?= $key ?>">JPT</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="radio" id="lName6<?= $key ?>" name="lName<?= $key ?>" value='HSK' <?= $data['postData']['language']['resumeSub'][$key]['lName']  == 'HSK' ? 'checked' : "" ?>>
                                                <label for="lName6<?= $key ?>">HSK</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!--e position_ckBox-->
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>시험점수</dt>
                            <dd>
                                <input type="number" name="lScore[]" id="" class="wps_100" value="<?= $data['postData']['language']['resumeSub'][$key]['lScore'] ?>" placeholder="">
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>시험급수</dt>
                            <dd>
                                <input type="text" name="lLever[]" id="" class="wps_100" value="<?= $data['postData']['language']['resumeSub'][$key]['lLever'] ?>" placeholder="">
                            </dd>
                        </dl>
                        <dl class="inp_dl">
                            <dt>취득일</dt>
                            <dd>
                                <input type="month" name="lObtainDate[]" id="" class="wps_100" value="<?= $data['postData']['language']['resumeSub'][$key]['lObtainDate'] ? substr($data['postData']['language']['resumeSub'][$key]['lObtainDate'], 0, 4) . '-' . substr($data['postData']['language']['resumeSub'][$key]['lObtainDate'], 4, 2) : '' ?>" maxlength="6" placeholder="시작일(ex:YYYYMM)">
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
                        <dt>시험종류 <span class="point">*</span></dt>
                        <dd>
                            <div class="position_ckBox fl_wd3">
                                <ul>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lName10" name="lName0" value='TOEIC'>
                                            <label for="lName10">TOEIC</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lName20" name="lName0" value='TOFEL'>
                                            <label for="lName20">TOFEL</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lName30" name="lName0" value='TEPS'>
                                            <label for="lName30">TEPS</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lName40" name="lName0" value='OPIC'>
                                            <label for="lName40">OPIC</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lName50" name="lName0" value='JPT'>
                                            <label for="lName50">JPT</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ck_radio">
                                            <input type="radio" id="lName60" name="lName0" value='HSK'>
                                            <label for="lName60">HSK</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--e position_ckBox-->
                        </dd>
                    </dl>
                    <dl class="inp_dl">
                        <dt>시험점수</dt>
                        <dd>
                            <input type="number" name="lScore[]" id="" class="wps_100" placeholder="">
                        </dd>
                    </dl>
                    <dl class="inp_dl">
                        <dt>시험급수</dt>
                        <dd>
                            <input type="text" name="lLever[]" id="" class="wps_100" placeholder="">
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
    <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/language" method="POST" id="next_form">
        <?= csrf_field() ?>
    </form>
</div>
<!--e #scontent-->

<script>
    $(".formadd").on("click", function(e) {
        var newForm = $(".inp_dlBox").last().clone().appendTo(".formall");
        //newForm.find("input").val("");

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
        for (let i = 0; i < $("input[name='lScore[]']").length; i++) {


            var eData = new Object();
            eData.num = i;
            eData.lName = $("input[name ^='lName']:checked").eq(i).val();
            eData.lScore = $("input[name='lScore[]']").eq(i).val();
            eData.lLever = $("input[name='lLever[]']").eq(i).val();
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