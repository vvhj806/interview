<?php if (0) : ?>
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">일반회원 제안 관리</h3>
                    <div>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="get" id="frm" target="_self">
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                                <col style="width:150px">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>검색 [결과수(<?= $data['suggestList'] ? $data['count'] : '0' ?>)]</th>
                                    <td>
                                        <input name="searchText" type="text" value="<?= $data['searchText'] ?>" placeholder="ID, 전화번호, 이름으로 검색">
                                        <button type="submit">검색</button>
                                        <label><input type='radio' name='userType' value='user' <?= $data['userType'] === 'user' ? 'checked' : '' ?>>회원 제안</label>
                                        <label><input type='radio' name='userType' value='notUser' <?= $data['userType'] === 'notUser' ? 'checked' : '' ?>>비회원 제안</label>
                                    </td>
                                </tr>
                                <?php if ($data['userType'] === 'user') : ?>
                                    <tr>
                                        <th>회원 번호 검색</th>
                                        <td>
                                            <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호">
                                            <button type="submit">검색</button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>정렬</th>
                                    <td>
                                        <select name='order'>
                                            <option value='idx' <?= $data['order']['column'] === 'idx' ? 'selected' : '' ?>>순번</option>
                                            <option value='mem_id' <?= $data['order']['column'] === 'mem_id' ? 'selected' : '' ?>>아이디</option>
                                            <option value='mem_name' <?= $data['order']['column'] === 'mem_name' ? 'selected' : '' ?>>이름</option>
                                            <option value='mem_reg_date' <?= $data['order']['column'] === 'mem_reg_date' ? 'selected' : '' ?>>발송일</option>
                                        </select>
                                        <label>오름차순<input type='radio' name='orderType' value='ASC' <?= $data['order']['type'] === 'ASC' ? 'checked' : '' ?>></label>
                                        <label>내림차순<input type='radio' name='orderType' value='DESC' <?= $data['order']['type'] === 'DESC' ? 'checked' : '' ?>></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <div class="box">
                        <p>리스트</p>
                        <div class="row">
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>
                                    <!-- <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%"> -->
                                </colgroup>
                                <thead>
                                    <th class="text-center">제안 번호</th>
                                    <th class="text-center">회원 번호</th>
                                    <th class="text-center">회원 아이디</th>
                                    <th class="text-center">회원 이름</th>
                                    <th class="text-center">회원 전화번호</th>
                                    <th class="text-center">회원 상태</th>
                                    <th class="text-center">재응시 요청 상태</th>
                                    <th class="text-center">제안발송일</th>
                                    <th class="text-center">수정</th>
                                </thead>
                                <tbody>
                                    <?php if ($data['suggestList']) : ?>
                                        <?php foreach ($data['suggestList'] as $row) : ?>
                                            <tr>
                                                <td class="text-center"><a href='/prime/suggest/c/write/<?= $row['sugIdx'] ?>'><?= $row['sugIdx'] ?></a></td>
                                                <td class="text-center">
                                                    <?php if (isset($row['memIdx'])) : ?>
                                                        <a href='/prime/member/write/m/<?= $row['memIdx'] ?>'><?= $row['memIdx'] ?></a>
                                                    <?php else : ?>
                                                        없음
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?= $row['memId'] ?? '없음' ?></td>
                                                <td class="text-center"><?= $row['memName'] ?></td>
                                                <td class="text-center"><?= $row['memTel'] ?></td>
                                                <td class="text-center"><?= $row['memStat'] ?></td>
                                                <td class="text-center"><?= $row['request'] ?></td>
                                                <td class="text-center"><?= $row['sugRegDate'] ?></td>
                                                <td class="text-center"><a href='write/<?= $data['userType'] ?>/<?= $row['lowSugIdx'] ?>'>수정</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <td colspan="7" class="text-center">해당하는 지원자가 없습니다 다시 검색해 주세요.</td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= $data['suggestList'] ? $data['pager']->links($data['userType'], 'front_full') : '' ?>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
<?php endif; ?>

<div class="content_title">
    <h3>일반회원 제안 관리</h3>
</div>

<!--s cont_searchBox-->
<div class="cont_searchBox mg_t50">
    <!--s sch_inp_borderBox-->
    <form method="get" id="frm" target="_self">
        <div class="sch_inp_borderBox spot_box">
            <div class='form-check form-check-inline'>
                <input id='user' class='form-check-input' type='radio' name='userType' value='user' <?= $data['userType'] === 'user' ? 'checked' : '' ?>>
                <label for='user' class='form-check-label'>회원 제안</label>
            </div>
            <div class='form-check form-check-inline'>
                <input id='not_user' class='form-check-input' type='radio' name='userType' value='notUser' <?= $data['userType'] === 'notUser' ? 'checked' : '' ?>>
                <label for='not_user' class='form-check-label'>비회원 제안</label>
            </div>
        </div>
        <div class="sch_inp_borderBox">
            <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
            <input type="text" name="searchText" value="<?= $data['searchText'] ?>" class="search_input" placeholder="아이디, 이름, 연락처로 검색하세요">
            <button type='submit' class="refresh_btn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
        </div>

        <div class="sch_inp_borderBox spot_box">
            <span class="searcTagTitle">정렬</span>
            <?php if ($data['userType'] === 'user') : ?>
                <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호 입력">
            <?php endif; ?>
            <select name='order'>
                <option value='idx' <?= $data['order']['column'] === 'idx' ? 'selected' : '' ?>>ID</option>
                <option value='mem_id' <?= $data['order']['column'] === 'mem_id' ? 'selected' : '' ?>>아이디</option>
                <option value='mem_name' <?= $data['order']['column'] === 'mem_name' ? 'selected' : '' ?>>이름</option>
                <option value='mem_reg_date' <?= $data['order']['column'] === 'mem_reg_date' ? 'selected' : '' ?>>등록일</option>
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
        <?php if ($data['userType'] === 'user') : ?>
            <div class="sch_inp_borderBox spot_box">
                <span class="searcTagTitle">회원 번호</span>
                <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호 입력">
            </div>
        <?php endif; ?>
    </form>
    <!--e sch_inp_borderBox-->
</div>
<!--e cont_searchBox-->

<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_20">
            <col class="wps_10">
            <col class="wps_15">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_15">
        </colgroup>
        <thead>
            <tr>
                <th>제안 번호</th>
                <th>회원 번호</th>
                <th>회원 아이디</th>
                <th>회원 이름</th>
                <th>회원 전화번호</th>
                <th>회원 상태</th>
                <th>재응시 요청 상태</th>
                <th>제안발송일</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['suggestList']) : ?>
                <?php foreach ($data['suggestList'] as $row) : ?>
                    <tr>
                        <td><a href='/prime/suggest/c/write/<?= $row['sugIdx'] ?>'><?= $row['sugIdx'] ?></a></td>
                        <td>
                            <?php if (isset($row['memIdx'])) : ?>
                                <a href='/prime/member/write/m/<?= $row['memIdx'] ?>'><?= $row['memIdx'] ?></a>
                            <?php else : ?>
                                없음
                            <?php endif; ?>
                        </td>
                        <td><?= $row['memId'] ?? '없음' ?></td>
                        <td><a href='write/<?= $data['userType'] ?>/<?= $row['lowSugIdx'] ?>' class="point"><?= $row['memName'] ?></a></td>
                        <td><?= $row['memTel'] ?></td>
                        <td><?= $row['memStat'] ?></td>
                        <td><?= $row['request'] ?></td>
                        <td><?= $row['sugRegDate'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan="8">해당하는 지원자가 없습니다 다시 검색해 주세요.</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<?= $data['suggestList'] ? $data['pager']->links($data['userType'], 'admin_page') : '' ?>

<script>
    $('input[name="userType"]').on('change', function() {
        $('#frm').submit();
    });
    $('select[name="order"]').on('change', function() {
        $('#frm').submit();
    });
    $('input[name="orderType"]').on('change', function() {
        $('#frm').submit();
    });
</script>