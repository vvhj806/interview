<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume/modify/<?= $data['rIdx'] ?>">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">
                <!--s top_shBox-->
                <?= view_cell('\App\Libraries\CategoryLib::jobSearch') ?>
                <!--e top_shBox-->
            </div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <div class='cate_search_pop'>
        <ul class='cate_search_list'>

        </ul>
    </div>

    <!--s ardBox-->
    <div class="ardBox">
        <?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'mult', 'checked' => array_values($data['postData']['interest'] ?? [])]) ?>

        <!--s ard_btnBox-->
        <div class="ard_btnBox">
            <!--s ard_btn_cont-->
            <div class="ard_btn_cont">
                <!--s keywords_box-->
                <div class="keywords_box">
                    <!--s depth-->
                    <ul class="depth jobDepth">

                    </ul>
                    <!--e depth-->
                </div>
                <!--e keywords_box-->

                <!--s ard_btn-->
                <div class="BtnBox mg_t40">
                    <button type='button' class="btn btn02 jobBtn" value='no'>닫기</button>
                    <button type='button' class="btn btn01 jobBtn" value='ok'>저장</button>
                </div>
                <!--e ard_btn-->
            </div>
            <!--e ard_btn_cont-->
        </div>
        <!--e ard_btnBox-->

        <form action="/my/resume/modify/<?= $data['rIdx'] ?>/subaction/interest" method="POST" id="next_form">
            <?= csrf_field() ?>
            <!--<input name="resumeType" id="resumeType" value="Interest">-->
            <?php
            if (!empty($data['postData']['interest'])) :
                foreach ($data['postData']['interest'] as $key => $val) :
            ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $val ?>">
            <?php
                endforeach;
            endif;
            ?>


        </form>
        <!--s BtnBox-->
        <div class="BtnBox">
            <button type="button" id="savebtn" class="btn btn01 Btn_off wps_100">저장</button>
            <!--on 일때 Btn_off 클래스 없애주세요-->
        </div>
        <!--e BtnBox-->
    </div>

    <script>
        $(document).ready(function() {
            $('input[name="depth3[]"]:checked').each(function() {
                const ul = $(this).closest('ul');
                depth3IsOn(ul);
            });
        });
        $(document).on('change', 'input[name="depth3[]"]', function() { //depth3
            const iChecked = $('input[name="depth3[]"]:checked').length;

            if (iChecked > 4) {
                $(this).prop('checked', false);
                alert('최대 4개까지 선택 가능합니다.');
                return false;
            }
        });

        $('.jobBtn').on('click', function() {
            let thisValue = $(this).val();

            if (thisValue == 'ok') {
                const iChecked = $('input[name="depth3[]"]:checked').length;
                if (iChecked > 4) {
                    $(this).prop('checked', false);
                    alert('최대 4개까지 선택 가능합니다.');
                    return false;
                }

                if (!$("input:checkbox[name='depth3[]']:checked").length) {
                    alert('1개 이상 선택해 주세요');
                    return false;
                }

                $("input:checkbox[name='depth3[]']:checked").each(function() {
                    if (!$("input[name='" + $(this).val() + "']").length) {
                        var addInput = document.createElement('input');
                        addInput.setAttribute("type", "hidden");
                        addInput.setAttribute("name", $(this).next('label').text().trim());
                        addInput.setAttribute("value", $(this).val());

                        $("#next_form").append(addInput);
                    }
                });
                $("#next_form").submit();

            } else if (thisValue == 'no') {
                history.back();
                resetModal('duty');
            }

        });
    </script>

    <style>
        label::after {
            display: none !important;
        }
    </style>