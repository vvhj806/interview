<?php if (0) : ?>
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><?= $data['aData']['code'] === 'm' ? '일반 회원' : '비즈 회원' ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table" style="border-bottom: 1px solid #dee2e6;">
                        <colgroup>

                        </colgroup>
                        <thead>
                            <tr>
                                <th class="text-center">전체</th>
                                <th class="text-center">오늘</th>
                                <th class="text-center">이번 주</th>
                                <th class="text-center">이번 달</th>
                            </tr>
                            <tr>
                                <th class="text-center">가입자 / 탈퇴자</th>
                                <th class="text-center">가입자 / 탈퇴자</th>
                                <th class="text-center">가입자 / 탈퇴자</th>
                                <th class="text-center">가입자 / 탈퇴자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><?= $data['count']['alltime'] ?> / <?= $data['lcount']['alltime'] ?></td>
                                <td class="text-center"><?= $data['count']['day'] ?> / <?= $data['lcount']['day'] ?></td>
                                <td class="text-center"><?= $data['count']['week'] ?> / <?= $data['lcount']['week'] ?></td>
                                <td class="text-center"><?= $data['count']['month'] ?> / <?= $data['lcount']['month'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <form method="get" id="frm" target="_self">
                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                                <col style="width:150px">
                                <col>
                            </colgroup>
                            <tbody>
                                <!-- <tr>
                                <th>게시판</th>
                                <td>
                                    <select name="code" onchange="javascript:location.href='/prime/member/list/'+this.value">
                                        <option name="type" value="m" <?= $data['aData']['code'] == 'm' ? 'selected' : '' ?>>맴버</option>
                                        <option name="type" value="c" <?= $data['aData']['code'] == 'c' ? 'selected' : '' ?>>기업</option>
                                        <option name="type" value="a" <?= $data['aData']['code'] == 'a' ? 'selected' : '' ?>>관리자</option>
                                        <option name="type" value="l" <?= $data['aData']['code'] == 'l' ? 'selected' : '' ?>>라벨러</option>
                                    </select>
                                </td>
                            </tr> -->
                                <tr>
                                    <th>검색</th>
                                    <td>
                                        <span>
                                            <select name='mem'>
                                                <option value='all' <?= $data['mem']['column'] === 'all' ? 'selected' : '' ?>>전체</option>
                                                <?php if ($data['aData']['code'] === 'm') : ?>
                                                    <option value='mou' <?= $data['mem']['column'] === 'mou' ? 'selected' : '' ?>>MOU</option>
                                                <?php endif; ?>
                                                <option value='leave' <?= $data['mem']['column'] === 'leave' ? 'selected' : '' ?>>탈퇴</option>
                                            </select>
                                        </span>

                                        <input name="searchText" type="text" value="<?= $data['search']['text'] ?? '' ?>" placeholder="아이디, 이름, 연락처로 검색하세요.">
                                        <input type="submit" value="검색">
                                        <div class="btn float-right"><a href="/prime/member/write/<?= $data['aData']['code'] ?>/0">회원등록</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>정렬</th>
                                    <td>
                                        <select name='order'>
                                            <option value='idx' <?= $data['order']['column'] === 'idx' ? 'selected' : '' ?>>순번</option>
                                            <option value='mem_id' <?= $data['order']['column'] === 'mem_id' ? 'selected' : '' ?>>아이디</option>
                                            <option value='mem_name' <?= $data['order']['column'] === 'mem_name' ? 'selected' : '' ?>>이름</option>
                                            <option value='mem_reg_date' <?= $data['order']['column'] === 'mem_reg_date' ? 'selected' : '' ?>>등록일</option>
                                        </select>
                                        <label>오름차순<input type='radio' name='orderType' value='ASC' <?= $data['order']['type'] === 'ASC' ? 'checked' : '' ?>></label>
                                        <label>내림차순<input type='radio' name='orderType' value='DESC' <?= $data['order']['type'] === 'DESC' ? 'checked' : '' ?>></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <div class="box">
                        <div class="row">
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>

                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th class="text-center">순번</th>
                                        <th class="text-center">아이디</th>
                                        <th class="text-center">이름</th>
                                        <th class="text-center">전화</th>
                                        <?php if ($data['aData']['code']) : ?>
                                            <th class="text-center">보유 리포트 / 공개 리포트</th>
                                            <th class="text-center">지원 횟수 / 합격 횟수</th>
                                        <?php endif; ?>
                                        <th class="text-center">나이</th>
                                        <th class="text-center">등록일</th>
                                    </tr>
                                    <?php
                                    if (count($data['list'])) :
                                        foreach ($data['list'] as $row) :
                                    ?>
                                            <tr class='<?= $row['delyn'] === 'Y' ? 'leave' : '' ?>'>
                                                <td class="text-center"><?= $row['idx'] ?></td>
                                                <td class="text-center"><a href="/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>"><?= $row['mem_id'] ?></a></td>
                                                <td class="text-center"><?= $row['mem_name'] ?><?= $row['delyn'] === 'Y' ? '(탈퇴)' : '' ?></td>
                                                <td class="text-center"><?= $row['mem_tel'] ?></td>
                                                <?php if ($data['aData']['code']) : ?>
                                                    <td class="text-center"> <?= $row['report']['cnt1'] ?> / <?= $row['report']['cnt2'] ?> </td>
                                                    <td class="text-center"> <?= $row['recruit_info']['cnt1'] ?> / </td>
                                                <?php endif; ?>
                                                <td class="text-center"><?= $row['mem_age'] ?></td>
                                                <td class="text-center"><?= $row['mem_reg_date'] ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">회원이 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= $data['pager']->links('member', 'front_full') ?>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
<?php endif; ?>

<div class="content_title">
    <h3><?= $data['aData']['code'] === 'm' ? '일반 회원' : '비즈 회원' ?></h3>

    <div class="top_btnBox">
        <a href="/prime/member/write/<?=$data['aData']['code']?>" class="btn btn01">등록</a>
    </div>
</div>

<!--s mem_list_ttUl-->
<ul class="mem_list_ttUl">
    <li>총<div class="big point b"><?= number_format($data['count']['alltime']) ?>명</div>
    </li>
    <li>
        <div class="num point b"><?= number_format($data['count']['day']) ?>명</div>
        <div class="txt">오늘 가입 회원</div>
    </li>
    <li>
        <div class="num point b"><?= number_format($data['count']['week']) ?>명</div>
        <div class="txt">이번주 가입 회원</div>
    </li>
    <li>
        <div class="num point b"><?= number_format($data['count']['month']) ?>명</div>
        <div class="txt">이번 달 가입 회원</div>
    </li>
    <li>
        <div class="num point b"><?= number_format($data['lcount']['alltime']) ?>명</div>
        <div class="txt">총 탈퇴 회원</div>
    </li>
</ul>
<!--e mem_list_ttUl-->

<!--s cont_searchBox-->
<div class="cont_searchBox mg_t50">
    <form method="get" id="frm" target="_self">
        <div class="sch_inp_borderBox">
            <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
            <span style="width:35%">
                <input type="date" class="date_box" id="startDate" name="startDate" value="<?= $data['date']['startDate'] ?>">~
                <input type="date" class="date_box" id="endDate" name="endDate" value="<?= $data['date']['endDate'] ?>">
            </span>
            <input name="searchText" class='search_input searchBar' type="text" value="<?= $data['search']['text'] ?? '' ?>" placeholder="아이디, 이름, 연락처, 기업명으로 검색하세요." style="width:60%">
            <button type='submit' class="refresh_btn searchBtn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
        </div>

        <!--s sch_inp_borderBox-->
        <div class="sch_inp_borderBox">
            <span class="searcTagTitle">정렬</span>
            <select name='order' style="height:35px;" class="mg_r10">
                <option value='idx' <?= $data['order']['column'] === 'idx' ? 'selected' : '' ?>>순번</option>
                <option value='mem_id' <?= $data['order']['column'] === 'mem_id' ? 'selected' : '' ?>>아이디</option>
                <option value='mem_name' <?= $data['order']['column'] === 'mem_name' ? 'selected' : '' ?>>이름</option>
                <option value='mem_reg_date' <?= $data['order']['column'] === 'mem_reg_date' ? 'selected' : '' ?>>등록일</option>
            </select>
            <label class="mg0 mg_r10 shLabel">오름차순 <input type='radio' name='orderType' value='ASC' <?= $data['order']['type'] === 'ASC' ? 'checked' : '' ?>></label>
            <label class="mg0 mg_r10 shLabel">내림차순 <input type='radio' name='orderType' value='DESC' <?= $data['order']['type'] === 'DESC' ? 'checked' : '' ?>></label>

            <br><br>
            <span class="searcTagTitle">분류</span>
            <?php if ($data['aData']['code'] == 'm') : ?>
                <label class="mg0 mg_r10 shLabel">MOU <input type="checkbox" id="mou" name="mou" value="mou" <?= $data['sort']['mou'] === 'mou' ? 'checked' : '' ?>></label>
            <?php elseif ($data['aData']['code'] == 'c') : ?>
                <label class="mg0 mg_r10 shLabel">워크넷 <input type="checkbox" id="worknet" name="worknet" value="worknet" <?= $data['sort']['worknet'] === 'worknet' ? 'checked' : '' ?>></label>
            <?php endif; ?>
            <label class="mg0 shLabel">일반 <input type="checkbox" id="general" name="general" value="general" <?= $data['sort']['general'] === 'general' ? 'checked' : '' ?>></label>

        </div>
        <!--e sch_inp_borderBox-->
    </form>
</div>
<!--e cont_searchBox-->

<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_20">
            <?php if ($data['aData']['code'] === 'c') : ?>
                <col class="wps_10">
            <?php endif; ?>
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <!-- <col class="wps_10"> -->
            <col class="wps_15">
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>TYPE</th>
                <th>아이디</th>
                <?php if ($data['aData']['code'] === 'c') : ?>
                    <th>기업명</th>
                <?php endif; ?>
                <th>이름</th>
                <th>연락처</th>
                <?php if ($data['aData']['code']) : ?>
                    <th class="text-center">등록공고수</th>
                    <!-- <th class="text-center">지원 횟수 / 합격 횟수</th> -->
                <?php endif; ?>
                <th>가입일</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($data['list'])) :
                foreach ($data['list'] as $key => $row) :
            ?>
                    <tr class='<?= $row['delyn'] === 'Y' ? 'wtd' : '' ?>'>
                        <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['idx'] ?></a></td>
                        <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['mem_type'] ?></a></td>
                        <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['mem_id'] ?></a></td>
                        <?php if ($row['mem_type'] == 'C') : ?>
                            <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['com_name'] ?></a></td>
                        <?php endif; ?>
                        <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['mem_name'] ?></a></td>
                        <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['mem_tel'] ?></a></td>
                        <?php if ($data['aData']['code']) : ?>
                            <td class="text-center"><?= $data['recCnt'][$key] ?? 0 ?></td>
                            <!-- <td class="text-center"> <? //= $row['recruit_info']['cnt1'] 
                                                            ?> / </td> -->
                        <?php endif; ?>
                        <td><a href='/prime/member/write/<?= $data['aData']['code'] ?>/<?= $row['idx'] ?>'><?= $row['mem_reg_date'] ?></a></td>
                    </tr>
                <?php
                endforeach;
            else : ?>
                <tr>
                    <td colspan="20">회원이 없습니다.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<?= $data['pager']->links('member', 'admin_page') ?>

<script>
    $('select[name="order"]').on('change', function() {
        $('#frm').submit();
    });

    $('input[name="orderType"]').on('change', function() {
        $('#frm').submit();
    });

    $('input[name="mou"]').on('change', function() {
        $('#frm').submit();
    });

    $('input[name="worknet"]').on('change', function() {
        $('#frm').submit();
    });

    $('input[name="general"]').on('change', function() {
        $('#frm').submit();
    });
</script>