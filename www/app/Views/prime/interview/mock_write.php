<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">새 공고 업로드</h3>
                <?= csrf_field() ?>
            </div>
        </div>

        <div class="card-header">
            <?php if ($data['comList'] ?? false) : ?>
                기업
                <select name='com_idx' required>
                    <?php foreach ($data['comList'] as $val) : ?>
                        <option value='<?= $val['comIdx'] ?>'><?= $val['comName'] ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>

        <div>
            <?= view_cell('\App\Libraries\CategoryLib::jobSearch') ?>

            <div class='cate_search_pop'>
                <ul class='cate_search_list'>

                </ul>
            </div>

            <!--s ardBox-->
            <div class="ardBox">
                <?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'only', 'checked' => []]) ?>
            </div>
            <!--e ardBox-->
        </div>

        <!-- /.card-header -->
        <div class="card-body main">
            <table class="table">
                <colgroup>
                    <col style="width:50%">
                    <col style="width:50%">
                </colgroup>
                <tbody>
                    <div id='inter_box'>
                        <h3>인터뷰 만들기</h3>
                        <div>
                            <a href='javascript:void(0)'>자동 생성하기</a>
                            <button type='button' value='' class='inter_btn'>질문중에 선택하기</button>
                            <li data-que-idx='1'>자기소개를 부탁드립니다.</li>
                            <ul class='sortable'></ul>
                        </div>
                        <div>
                            <div>각 질문당 답변 시간
                                <select id='inter_time'>
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
                        <input id='input' name='rec_inter[]' disabled>
                        <button value='' type='button' class='inter_save'>인터뷰 저장하기</button>
                        <hr>
                    </div>

                </tbody>
            </table>

        </div>
        <!-- /.card-body -->


        <div class='card-body'>
            <div class="box">
                <div class="">
                    <button type='button' class="btn btn-success">취소</button>
                    <button type='submit' class="btn btn-success">등록하기</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.row -->

<div id='question' class='pop_modal'>
    <div class='pop_full'>
        <div class='pop_con'>
            <div>질문<button onclick="$('#question').removeClass('on')">닫기</button></div>
            <ul style='height: 95vh; overflow-y:scroll;'>
            </ul>
        </div>
    </div>
</div>

<script>
    const emlCsrf = $("input[name='csrf_highbuff']");
    let ajaxFlag = true;

    $(document).on('click', '.inter_btn', function() {
        const thisIdx = $('input[name="depth3[]"]:checked').val();
        if (ajaxFlag && thisIdx) {
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
                                ul.append(`<li><label>[${type}] ${item[idx]['que_question']}<input type='checkbox' value='${item[idx]}' checked></label></li>`);
                            } else {
                                ul.append(`<li><label>[${type}] ${item[idx]['que_question']}<input type='checkbox' value='${item[idx]}'></label></li>`);
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

    $(document).on('click', '.inter_save', function() {
        const thisEle = $(this);
        const thisDiv = thisEle.closest('div');
        const comIdx = $('input[name="com_idx"]').val();
        const jobIdx = thisEle.val();
        const interTime = thisDiv.find('select').val();
        let aQueIdx = [];
        thisDiv.find('li').each(function() {
            aQueIdx.push($(this).data('que-idx'));
        });

        if(!jobIdx || aQueIdx.length < 3){
            alert('조건');
            return;
        }

        if (ajaxFlag) {
            ajaxFlag = false;
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
                    alert(textStatus);
                }
            });
        }
    });
</script>