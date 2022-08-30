<?php if (0) : ?>
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">지원 관리</h3>
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
                                    <th>
                                        검색어 [회원 ID / 이름 / 연락처]
                                    </th>
                                    <td>
                                        <input name="searchText" type="text" value="<?= $data['search'] ?>">
                                        <input type="submit" value="검색">
                                        <label><input type='radio' name='againType' value='noAgain' <?= $data['againType'] === 'noAgain' ? 'checked' : '' ?>>재응시요청 없음</label>
                                        <label><input type='radio' name='againType' value='again' <?= $data['againType'] === 'again' ? 'checked' : '' ?>>재응시 요청</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <div class="box">
                        <!-- <p>rec_info_idx</p> -->
                        <div class="row">
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>

                                </colgroup>
                                <thead>
                                    <th class="text-center">REC_INFO_IDX</th>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">이름</th>
                                    <th class="text-center">연락처</th>
                                    <th class="text-center">지원 회사명</th>
                                    <th class="text-center">지원 공고명</th>
                                    <th class="text-center">지원상태</th>
                                    <th class="text-center">등록일</th>
                                    <th class="text-center">재응시요청여부</th>
                                    <th class="text-center">재응시요확인여부</th>
                                    <th class="text-center">재응시요청수락여부</th>
                                    <th class="text-center">보기</th>
                                </thead>
                                <tbody style="font-size: 90%;">
                                    <?php foreach ($data['list'] as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $row['rec_info_idx'] ?></td>
                                            <td class="text-center"><?= $row['mem_id'] ?></td>
                                            <td class="text-center"><?= $row['mem_name'] ?></td>
                                            <td class="text-center"><?= $row['mem_tel'] ?></td>
                                            <td class="text-center"><?= $row['com_name'] ?></td>
                                            <td class="text-center"><?= $row['rec_title'] ?></td>
                                            <td class="text-center">
                                                <?php if ($row['app_type'] == "M") : ?>
                                                    내인터뷰
                                                <?php elseif ($row['app_type'] == "C") : ?>
                                                    기업인터뷰
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center"><?= $row['res_info_reg_date'] ?></td>
                                            <td class="text-center">
                                                <?php if ($row['ag_req_com']) : ?>
                                                    Y
                                                <?php else : ?>
                                                    N
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $row['ag_req_com'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($row['ag_req_stat'] == 'Y' && $row['ag_req_com'] == 'Y') : ?>
                                                    재응시요청 수락
                                                <?php elseif ($row['ag_req_stat'] == 'N' && $row['ag_req_com'] == 'Y') : ?>
                                                    재응시요청 거절
                                                <?php else : ?>
                                                    <?php if ($row['ag_req_com']) : ?>
                                                        재응시요청중
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center"><a href="/prime/recruit_info/m/detail/<?= $row['rec_info_idx'] ?>">보기</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= $data['pager']->links('recruitInfo', 'front_full') ?>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
<?php endif; ?>

<div class="content_title">
    <h3>지원 관리</h3>

    <div class="top_btnBox">
        <a href="write" class="btn btn01">지원하기</a>
    </div>
</div>

<!--s cont_searchBox-->
<div class="cont_searchBox mg_t30">
    <form method="get" id="frm" target="_self">
        <!--s sch_inp_borderBox-->
        <div class="sch_inp_borderBox">
            <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
            <input name="searchText" type="text" class="search_input" value="<?= $data['search'] ?>" placeholder="기업명, 공고명, 직무명으로 검색하세요">
            <button type='submit' class="refresh_btn searchBtn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
        </div>
        <!--e sch_inp_borderBox-->
        <div class="sch_inp_borderBox">
            <div class="chek_box radio">
                <input id='no' type='radio' name='againType' value='noAgain' <?= $data['againType'] === 'noAgain' ? 'checked' : '' ?>>
                <label for='no' class='lbl black'>재응시요청 없음</label>
            </div>
            <div class="chek_box radio">

                <input id='yes' type='radio' name='againType' value='again' <?= $data['againType'] === 'again' ? 'checked' : '' ?>>
                <label for='yes' class='lbl black'>재응시 요청</label>
            </div>
        </div>
    </form>
</div>
<!--e cont_searchBox-->

<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <!-- <col class="wps_3">
            <col class="wps_5">
            <col class="wps_8">
            <col class="wps_11">
            <col class="wps_11">
            <col class="wps_8">
            <col class="wps_8">
            <col class="wps_11">
            <col class="wps_11">
            <col class="wps_8">
            <col class="wps_8">
            <col class="wps_8"> -->
        </colgroup>
        <thead>
            <tr>
                <th>지원번호</th>
                <th>ID</th>
                <th>이름</th>
                <th>연락처</th>
                <th>지원 회사명</th>
                <th>지원 공고명</th>
                <th>지원상태</th>
                <th>등록일</th>
                <th>재응시요청여부</th>
                <th>재응시요확인여부</th>
                <th>재응시요청수락여부</th>
                <th>보기</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['list'] as $row) : ?>
                <tr>
                    <td><?= $row['rec_info_idx'] ?></td>
                    <td><?= $row['mem_id'] ?></td>
                    <td><?= $row['mem_name'] ?></td>
                    <td><?= $row['mem_tel'] ?></td>
                    <td><?= $row['com_name'] ?></td>
                    <td><?= $row['rec_title'] ?></td>
                    <td>
                        <?php if ($row['app_type'] == "M") : ?>
                            내인터뷰
                        <?php elseif ($row['app_type'] == "C") : ?>
                            기업인터뷰
                        <?php endif; ?>
                    </td>
                    <td><?= $row['res_info_reg_date'] ?></td>
                    <td>
                        <?php if ($row['ag_req_com']) : ?>
                            Y
                        <?php else : ?>
                            N
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $row['ag_req_com'] ?>
                    </td>
                    <td>
                        <?php if ($row['ag_req_stat'] == 'Y' && $row['ag_req_com'] == 'Y') : ?>
                            재응시요청 수락
                        <?php elseif ($row['ag_req_stat'] == 'N' && $row['ag_req_com'] == 'Y') : ?>
                            재응시요청 거절
                        <?php else : ?>
                            <?php if ($row['ag_req_com']) : ?>
                                재응시요청중
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>

                    <td><a href="/prime/recruit_info/m/detail/<?= $row['rec_info_idx'] ?>">보기</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<?= $data['pager']->links('recruitInfo', 'admin_page') ?>

<script>
    $('input[name="againType"]').on('change', function() {
        $('#frm').submit();
    });
</script>