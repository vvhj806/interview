<?php
// print_r($data['getRule']);
// exit;
?>
<!--s t1-->
<div class="t1">
    <div class="content_title">
        <h3>권한 설정</h3>
        <form method="post" id="menuSave" action="/prime/config/permission/action">
            <?= csrf_field() ?>
            <input type="hidden" name="menuIdxs" id="menuIdxs" value="">
            <input type="hidden" name="permissionType" id="permissionType" value="<?= $data['getType'] ?? '' ?>">
            <input type="hidden" name="permissionLevel" id="permissionLevel" value="<?= $data['getLevel'] ?? '' ?>">
            <input type="hidden" name="permissionName" id="permissionName" value="">
            <div class="top_btnBox">
                <button class="btn btn01" id="save" type="button">저장</button>
            </div>
        </form>
    </div>
    <form method="get" id="frm" target="_self">
        <div style="display: flex;align-items: center; margin-bottom:10px">
            <div>
                회원타입
                <select name="typeSelect" id="typeSelect">
                    <option value="M" id="M">개인</option>
                    <option value="C" id="C">기업</option>
                    <option value="L" id="L">라벨러</option>
                    <option value="S" id="S">사이트관리자</option>
                    <option value="B" id="B">중간관리자</option>
                </select>
            </div>
            <div>
                회원권한
                <select name="levelSelect" id="levelSelect">
                    <?php for ($i = 0; $i < 11; $i++) : ?>
                        <option value="<?= $i ?>" <?= $data['getLevel'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div style="margin-left:10px; margin-right:15px">
                <button class="btn btn01" type="submit">검색</button>
            </div>
    </form>
    <div>
        권한명
        <input type="text" name="typeName" id="typeName" value="<?php empty($data['getRule']) ? '' : print_r($data['getRule'][0]['type_name']) ?>">
    </div>

</div>

<div id="menuList" style="display:none">
    <?php foreach ($data['menuList'] as $key => $val) : ?>
        <div style="display:flex;align-items: flex-start;flex-direction: column;">
            <div style="font-size: 20px; background: bisque;">
                <?php foreach ($val as $key2 => $val2) : ?>
                    <?php if ($key2 == 0) : ?>
                        <h2><?= $val2['menu_depth_txt'] ?></h2>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div style="margin-bottom:15px">
                <?php foreach ($val as $key2 => $val2) : ?>
                    <?php if ($key2 != 0) : ?>
                        <input type="checkbox" id='depthCheck<?= $val2['idx'] ?>' name="selectMenu" value="<?= $val2['idx'] ?>">
                        <label for="depthCheck<?= $val2['idx'] ?>"><span style="margin-right: 10px;"><?= $val2['menu_depth_txt'] ?></span></label>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div id="emptyList" style="display:none">
    회원타입과 회원권한을 검색해주세요 !
</div>

</div>
<!--e t1-->

<script>
    let getRule = <?php echo json_encode($data['getRule']) ?>;
    $(document).ready(function() {
        if ('<?= $data['getType'] ?>' != '' && "<?= $data['getType'] ?>" != null) {
            $('#'+'<?= $data['getType'] ?>').attr('selected',true);
            if (getRule != "" && getRule != null) {
                if (getRule[0]['menu_idx']) {
                    for (i = 0; i < getRule[0]['menu_idx'].length; i++) {
                        $('#depthCheck' + getRule[0]['menu_idx'][i]).prop('checked', true); //선택되어있는 메뉴 목록 미리 체크해주기
                    }
                }
            }
            $('#menuList').show();
            $('#emptyList').hide();
        } else {
            $('#menuList').hide();
            $('#emptyList').show();
        }
    });

    $('#save').on('click', function() {
        let menuIdxs = '';
        $('input:checkbox[name="selectMenu"]').each(function() {
            if ($(this).is(':checked')) {
                menuIdxs = menuIdxs + $(this).val() + ',';
            }
        });
        menuIdxs = menuIdxs.replace(/,\s*$/, ''); //마지막 ,랑 공백제거
        $('#menuIdxs').val(menuIdxs);

        if ($('#typeName').val() == '' || $('#typeName').val() == null) {
            alert('권한명을 적어주세요.');
            return;
        } else {
            $('#permissionName').val($('#typeName').val());
        }

        $('#menuSave').submit();
    });
</script>