<div class="content_title">
    <h3>이력서 관리</h3>
</div>

<!--s cont_searchBox-->
<div class="cont_searchBox mg_t50">
    <!--s sch_inp_borderBox-->
    <form method="get" id="frm" target="_self">
        <div class="sch_inp_borderBox">
            <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
            <input type="text" name="searchText" value="<?= $data['searchText'] ?>" class="search_input" placeholder="아이디, 이름, 연락처로 검색하세요">
            <button type='submit' class="refresh_btn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
        </div>

        <div class="sch_inp_borderBox spot_box">
            <span class="searcTagTitle">정렬</span>
            <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호 입력">
            <select name='order'>
                <option value='resIdx' <?= $data['order']['column'] === 'resIdx' ? 'selected' : '' ?>>순번</option>
                <option value='resTitle' <?= $data['order']['column'] === 'resTitle' ? 'selected' : '' ?>>제목</option>
                <option value='memId' <?= $data['order']['column'] === 'memId' ? 'selected' : '' ?>>아이디</option>
                <option value='memName' <?= $data['order']['column'] === 'memName' ? 'selected' : '' ?>>이름</option>
                <option value='res_reg_date' <?= $data['order']['column'] === 'res_reg_date' ? 'selected' : '' ?>>등록일</option>
            </select>
            <div class='form-check form-check-inline'>
                <input id='asc' type='radio' class='form-check-input' name='orderType' value='ASC' <?= $data['order']['type'] === 'ASC' ? 'checked' : '' ?>>
                <label for='asc' class='form-check-label'>오름차순</label>
            </div>
            <div class='form-check form-check-inline'>
                <input id='desc' type='radio' class='form-check-input' name='orderType' value='DESC' <?= $data['order']['type'] === 'DESC' ? 'checked' : '' ?>>
                <label for='desc' class='form-check-label'>내림차순</label>
            </div>
        </div>

        <div class="sch_inp_borderBox spot_box">
            <span class="searcTagTitle">회원 번호</span>
            <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호 입력">
        </div>
    </form>
    <!--e sch_inp_borderBox-->
</div>
<!--e cont_searchBox-->

<div class="overflow mg_b10">
    <div class="fl font16 gray"><i class="fa fa-layer-group"></i> 총 <span class="point"><?= $data['count'] ?></span>개가 있습니다.</div>
</div>

<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_20">
            <col class="wps_15">
            <col class="wps_15">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
        </colgroup>
        <thead>
            <tr>
                <th>이력서 번호</th>
                <th>회원 번호</th>
                <th>이력서 제목</th>
                <th>회원 아이디</th>
                <th>회원 이름</th>
                <th>회원 전화번호</th>
                <th>등록일</th>
                <th>확인</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resumeList']) : ?>
                <?php foreach ($data['resumeList'] as $row) : ?>
                    <tr>
                        <td><?= $row['resIdx'] ?></td>
                        <td><?= $row['memIdx'] ?></td>
                        <td><?= $row['resTitle'] ?></td>
                        <td><?= $row['memId'] ?></td>
                        <td><?= $row['memName'] ?></td>
                        <td><?= $row['memTel'] ?></td>
                        <td><?= $row['resRegDate'] ?></td>
                        <td><a href='write/<?= $row['resIdx'] ?>' class='point'>확인</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan="7">해당하는 지원자가 없습니다 다시 검색해 주세요.</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<?= $data['pager']->links('resume', 'admin_page') ?>

<script>
    $('select[name="order"]').on('change', function() {
        $('#frm').submit();
    });
    $('input[name="orderType"]').on('change', function() {
        $('#frm').submit();
    });
</script>