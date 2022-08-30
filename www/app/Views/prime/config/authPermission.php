<div class="content_title">
    <h3>아이디 권한 설정</h3>
    <form method="post" id="authSave" action="/prime/config/idauth/action">
        <?= csrf_field() ?>
        <input type="hidden" name="memIdxAuth[]" id="memIdxAuth" value="">
        <!-- <input type="hidden" name="permissionType" id="permissionType" value="">
        <input type="hidden" name="permissionLevel" id="permissionLevel" value=""> -->
        <div class="top_btnBox">
            <button class="btn btn01" id="save" type="button">저장</button>
        </div>
    </form>
</div>
<!--s cont_searchBox-->
<div class="cont_searchBox mg_t50">
    <form method="get" id="frm" target="_self">
        <div class="sch_inp_borderBox">
            <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
            <input name="searchText" class='search_input searchBar' type="text" value="<?= $data['getSearchText'] ?? "" ?>" placeholder="아이디, 이름, 연락처로 검색하세요." style="width:60%">
            <button type='submit' class="refresh_btn searchBtn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
        </div>
    </form>
</div>
<!--e cont_searchBox-->
<div style="margin-bottom:15px">
    <input type="checkbox" id="allCheck">
    <label for="allCheck" style="margin-bottom: 0;"><span>전체 선택</span></label>
</div>

<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_5">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_20">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_15">
        </colgroup>
        <thead>
            <tr>
                <th>선택</th>
                <th>ID</th>
                <th>TYPE(memType)</th>
                <th>LEVEL(memLevel)</th>
                <th>아이디</th>
                <th>이름</th>
                <th>연락처</th>
                <th>가입일</th>

            </tr>
        </thead>
        <tbody>
            <?php if ($data['getMemberInfo']) : ?>
                <?php foreach ($data['getMemberInfo'] as $key => $val) : ?>
                    <tr class=''>
                        <td><input type="checkbox" id='select<?= $val['idx'] ?>' name="selectId" value="<?= $val['idx'] ?>"></td>
                        <td><a href='javascript:void(0)'><?= $val['idx'] ?></a></td>
                        <td><a href='javascript:void(0)'>
                                <select name="typeSelect" id="typeSelect<?= $val['idx'] ?>">
                                    <option value="M" id="M_<?= $key ?>">개인</option>
                                    <option value="C" id="C_<?= $key ?>">기업</option>
                                    <option value="L" id="L_<?= $key ?>">라벨러</option>
                                    <option value="S" id="S_<?= $key ?>">사이트관리자</option>
                                    <option value="B" id="B_<?= $key ?>">중간관리자</option>
                                </select></a></td>
                        <td><a href='javascript:void(0)'>
                                <select name="levelSelect" id="levelSelect<?= $val['idx'] ?>">
                                    <?php for ($i = 0; $i < 11; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $val['mem_level'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select></a></td>
                        <td><a href='javascript:void(0)'><?= $val['mem_id'] ?></a></td>
                        <td><a href='javascript:void(0)'><?= $val['mem_name'] ?></a></td>
                        <td><a href='javascript:void(0)'><?= $val['mem_tel'] ?></a></td>
                        <td><a href='javascript:void(0)'><?= $val['mem_reg_date'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php elseif ($data['getSearchText']) : ?>
                <tr>
                    <td colspan="20">회원이 없습니다.</td>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="20">회원을 검색해주세요!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<script>
    let getMemberInfo = <?php echo json_encode($data['getMemberInfo']) ?>;
    $(document).ready(function() {
        if (getMemberInfo != '' && getMemberInfo != null) {
            for (i = 0; i < getMemberInfo.length; i++) {
                $('#' + getMemberInfo[i]['mem_type'] + '_' + i).attr('selected', true);
            }
        }
    });

    $('#allCheck').on('click', function() {
        if ($('#allCheck').prop('checked')) {
            $("input[name='selectId'").prop('checked', true);
        } else {
            $("input[name='selectId'").prop('checked', false);
        }
    });

    $("input[name='selectId'").on('click', function() {
        if ($("input[name='selectId']:checked").length == $("input[name='selectId'").length) {
            $('#allCheck').prop('checked', true);
        } else {
            $('#allCheck').prop('checked', false);
        }
    });

    $('#save').on('click', function() {
        let idxArr = [];
        $('input:checkbox[name="selectId"]').each(function() {
            if ($(this).is(':checked')) {
                idxArr.push({
                    "idx": $(this).val(),
                    "type": $('#typeSelect' + $(this).val() + ' option:selected').val(),
                    "level": $('#levelSelect' + $(this).val() + ' option:selected').val()
                });
            }
        });

        if (idxArr == "" || idxArr == null) {
            alert('변경할 아이디를 선택해주세요.');
            return;
        }

        $('#memIdxAuth').val(JSON.stringify(idxArr));
        $('#authSave').submit();
    });
</script>