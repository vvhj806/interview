<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">기타 활동</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <div class="formall">
            <?php
            if (!empty($data['postData']['activity']['resumeSub'])) :
                foreach ($data['postData']['activity']['resumeSub'] as $key => $val) :
            ?>
                    <!--s inp_dlBox-->
                    <div class="inp_dlBox">
                        <dl class="inp_dl del_btn">
                            <dd>
                                <div class="pl_btn r mg_t35"><a href="/my/resume/modify/<?= $data['rIdx'] ?>/subdelete/activity?type=activity&key=<?= $key ?>" class='formadd'>삭제하기</a></div>
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>활동명<span class="point">*</span></dt>
                            <dd>
                                <input type="text" name="actName[]" id="" class="wps_100" value="<?= $data['postData']['activity']['resumeSub'][$key]['actName'] ?>" placeholder="활동명을 입력해주세요">
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>세부사항</dt>
                            <dd>
                                <input type="text" name="detail[]" id="" class="wps_100" value="<?= $data['postData']['activity']['resumeSub'][$key]['detail'] ?>" placeholder="내용과 의미를 간략히 적어주세요">
                            </dd>
                        </dl>

                        <dl class="inp_dl">
                            <dt>활동시기</dt>
                            <dd>
                                <div class="wd50Box2">
                                    <input type="month" name="aStartDate[]" id="" class="" value="<?= $data['postData']['activity']['resumeSub'][$key]['aStartDate'] ? substr($data['postData']['activity']['resumeSub'][$key]['aStartDate'], 0, 4) . '-' . substr($data['postData']['activity']['resumeSub'][$key]['aStartDate'], 4, 2) : '' ?>" placeholder="시작일(ex:YYYYMM)" maxlength="6">
                                    <input type="month" name="aEndDate[]" id="" class="" value="<?= $data['postData']['activity']['resumeSub'][$key]['aEndDate'] ? substr($data['postData']['activity']['resumeSub'][$key]['aEndDate'], 0, 4) . '-' . substr($data['postData']['activity']['resumeSub'][$key]['aEndDate'], 4, 2) : '' ?>" placeholder="종료일(ex:YYYYMM)" maxlength="6">
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
                        <dt>활동명<span class="point">*</span></dt>
                        <dd>
                            <input type="text" name="actName[]" id="" class="wps_100" placeholder="활동명을 입력해주세요">
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>세부사항</dt>
                        <dd>
                            <input type="text" name="detail[]" id="" class="wps_100" placeholder="내용과 의미를 간략히 적어주세요">
                        </dd>
                    </dl>

                    <dl class="inp_dl">
                        <dt>활동시기</dt>
                        <dd>
                            <div class="wd50Box2">
                                <input type="month" name="aStartDate[]" id="" class="" value="" placeholder="시작일(ex:YYYYMM)" maxlength="6">
                                <input type="month" name="aEndDate[]" id="" class="" value="" placeholder="종료일(ex:YYYYMM)" maxlength="6">
                            </div>
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
    <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/activity" method="POST" id="next_form">
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
        for (let i = 0; i < $("input[name='actName[]']").length; i++) {
            if (!$("input[name='actName[]']").eq(i).val()) {
                alert('활동명을 입력해 주세요.');
                return false;
            }

            var eData = new Object();
            eData.num = i;
            eData.actName = $("input[name='actName[]']").eq(i).val();
            eData.detail = $("input[name='detail[]']").eq(i).val();
            eData.aStartDate = $("input[name='aStartDate[]']").eq(i).val();
            eData.aEndDate = $("input[name='aEndDate[]']").eq(i).val();

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