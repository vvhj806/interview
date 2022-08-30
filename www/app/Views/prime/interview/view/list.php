<?php if (0) : ?>
    <form method="get" id="frm" target="_self">
        <div class="row">
            <div class="col-12">
                <!-- general form elements disabled -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">전체 인터뷰</h3>
                        <div>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table class="table" style="border-bottom: 1px solid #dee2e6;">
                            <colgroup>
                                <col style="width:150px">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>검색 [결과수(<?= $data['count'] ?>)]</th>
                                    <td>
                                        <input name="searchText" type="text" value="<?= $data['searchText'] ?>" placeholder="인터뷰 번호, ID, 전화번호, 이름으로 검색">
                                        <button type="submit">검색</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>회원 번호 검색</th>
                                    <td>
                                        <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호">
                                        <button type="submit">검색</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>정렬</th>
                                    <td>
                                        <select name='order'>
                                            <option value='appIdx' <?= $data['order']['column'] === 'appIdx' ? 'selected' : '' ?>>순번</option>
                                            <option value='appRegDate' <?= $data['order']['column'] === 'appRegDate' ? 'selected' : '' ?>>등록일</option>
                                            <option value='appCount' <?= $data['order']['column'] === 'appCount' ? 'selected' : '' ?>>조회수순</option>
                                            <option value='appLikeCount' <?= $data['order']['column'] === 'appLikeCount' ? 'selected' : '' ?>>좋아요순</option>
                                        </select>
                                        <label>오름차순<input type='radio' name='orderType' value='ASC' <?= $data['order']['type'] === 'ASC' ? 'checked' : '' ?>></label>
                                        <label>내림차순<input type='radio' name='orderType' value='DESC' <?= $data['order']['type'] === 'DESC' ? 'checked' : '' ?>></label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>필터</th>
                                    <td>
                                        <div>
                                            <label><input type='checkbox' name='interType[]' value='M' <?= in_array('M', $data['filter']['type']) ? 'checked' : '' ?>>인터뷰</label>
                                            <label><input type='checkbox' name='interType[]' value='C' <?= in_array('C', $data['filter']['type']) ? 'checked' : '' ?>>기업인터뷰</label>
                                            <label><input type='checkbox' name='interType[]' value='A' <?= in_array('A', $data['filter']['type']) ? 'checked' : '' ?>>모의인터뷰</label>
                                            <button type='button' onclick="$('#question').addClass('on')">직무</button>
                                        </div>
                                        <div>
                                            <label>
                                                <input id='checked' type='checkbox'>
                                                전체
                                            </label>
                                            <label>
                                                <input type='checkbox' name='iv_app_stat[]' value='0' <?= in_array(0, $data['filter']['stat']) ? 'checked' : '' ?>>
                                                카테고리 선택
                                            </label>
                                            <label>
                                                <input type='checkbox' name='iv_app_stat[]' value='1' <?= in_array(1, $data['filter']['stat']) ? 'checked' : '' ?>>
                                                프로필 촬영
                                            </label>
                                            <label>
                                                <input type='checkbox' name='iv_app_stat[]' value='2' <?= in_array(2, $data['filter']['stat']) ? 'checked' : '' ?>>
                                                마이크 테스트 완료
                                            </label>
                                            <label>
                                                <input type='checkbox' name='iv_app_stat[]' value='3' <?= in_array(3, $data['filter']['stat']) ? 'checked' : '' ?>>
                                                면접 완료
                                            </label>
                                            <label>
                                                <input type='checkbox' name='iv_app_stat[]' value='4' <?= in_array(4, $data['filter']['stat']) ? 'checked' : '' ?>>
                                                채점 완료
                                            </label>
                                            <label>
                                                <input type='checkbox' name='iv_app_stat[]' value='5' <?= in_array(5, $data['filter']['stat']) ? 'checked' : '' ?>>
                                                분석 불가
                                            </label>
                                            <button type='submit'>검색</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="box">
                            <p>리스트</p>
                            <div class="row">
                                <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                    <colgroup>
                                        <!-- <col style="width: 10%">
                                <col style="width: 10%"> -->
                                    </colgroup>
                                    <thead>
                                        <th class="text-center">번호</th>
                                        <th class="text-center">썸네일</th>
                                        <th class="text-center">직무</th>
                                        <th class="text-center">인터뷰 타입</th>
                                        <th class="text-center">인터뷰 상태</th>
                                        <th class="text-center">회원 아이디</th>
                                        <th class="text-center">회원 이름</th>
                                        <th class="text-center">회원 전화번호</th>
                                        <th class="text-center">공유상태</th>
                                        <th class="text-center">조회수</th>
                                        <th class="text-center">좋아요</th>
                                        <th class="text-center">등록일</th>
                                        <th class="text-center">자세히 보기</th>
                                    </thead>
                                    <tbody>
                                        <?php if ($data['applierList']) : ?>
                                            <?php foreach ($data['applierList'] as $row) : ?>
                                                <tr <?= $row['appDel'] === 'Y' ? 'style="background:#ddd"' : '' ?>>
                                                    <td class="text-center"><?= $row['appIdx'] ?></td>
                                                    <td class="text-center">
                                                        <div class="imgBox">
                                                            <img src="<?= $data['url']['media'] ?><?= $row['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?= $row['jobText'] ?></td>
                                                    <td class="text-center"><?= $row['appType'] ?></td>
                                                    <td class="text-center"><?= $row['appStat'] ?></td>
                                                    <td class="text-center"><?= $row['memId'] ?></td>
                                                    <td class="text-center"><?= $row['memName'] ?></td>
                                                    <td class="text-center"><?= $row['memTel'] ?></td>
                                                    <td class="text-center"><?= $row['appShare']  ? '공유 중' : '공유안함' ?></td>
                                                    <td class="text-center"><?= $row['appCount'] ?></td>
                                                    <td class="text-center"><?= $row['appLikeCount'] ?></td>
                                                    <td class="text-center"><?= $row['appRegDate'] ?></td>
                                                    <td class="text-center"><a href='view/detail/<?= $row['appIdx'] ?>'>보기</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <td colspan="7" class="text-center">해당하는 지원자가 없습니다.</td>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= $data['applierList'] ? $data['pager']->links('applier', 'front_full') : '' ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div id='question' class='pop_modal'>
            <div class='pop_full'>
                <div class='pop_con'>
                    <div>
                        직무
                        <button type='button' onclick="$('#question').removeClass('on')" style='float:right;'>저장</button>
                    </div>
                    <?= view_cell('\App\Libraries\CategoryLib::jobSearch') ?>

                    <div class='cate_search_pop'>
                        <ul class='cate_search_list'>

                        </ul>
                    </div>

                    <div id='jobGuide'>

                    </div>
                    <!--s ardBox-->
                    <div class="ardBox">
                        <?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'mutl', 'pageType' => '', 'checked' => $data['filter']['jobIdx']]) ?>
                    </div>
                    <!--e ardBox-->
                </div>
            </div>
        </div>
    </form>

<?php endif; ?>

<div class="content_title">
    <h3>인터뷰 보기</h3>
</div>

<!--s totalUl-->
<ul class="totalUl">
    <li>
        <span class="tlt">인터뷰 수</span>
        <span class="txt"><?= $data['count'] ?>개</span>
    </li>
</ul>
<!--e totalUl-->

<form method="get" id="frm" target="_self">
    <!--s cont_searchBox-->
    <div class="cont_searchBox mg_t50">

        <div class="sch_inp_borderBox">
            <span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
            <input name="searchText" class='search_input' type="text" value="<?= $data['search']['text'] ?? '' ?>" placeholder="아이디, 이름, 연락처로 검색하세요.">
            <button type="submit" class="refresh_btn searchBtn"><i class="fa fa-arrow-rotate-right"></i>검색</button>
        </div>

        <div class="sch_inp_borderBox spot_box">
            <span class="searcTagTitle">정렬</span>
            <select name='order'>
                <option value='appIdx' <?= $data['order']['column'] === 'appIdx' ? 'selected' : '' ?>>번호</option>
                <option value='appRegDate' <?= $data['order']['column'] === 'appRegDate' ? 'selected' : '' ?>>등록일</option>
                <option value='appCount' <?= $data['order']['column'] === 'appCount' ? 'selected' : '' ?>>조회수순</option>
                <option value='appLikeCount' <?= $data['order']['column'] === 'appLikeCount' ? 'selected' : '' ?>>좋아요순</option>
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
            <span class="searcTagTitle">회원번호</span>
            <input name="memIdx" type="text" value="<?= $data['getMemIdx'] ?? '' ?>" placeholder="회원 번호 입력">
        </div>
    </div>
    <!--e cont_searchBox-->

    <!--s filter_bigBox-->
    <div class="filter_bigBox mg_b15">
        <!--s overflow-->
        <div class="overflow">
            <!--s filterBox-->
            <div class="fl filterBox">
                <!--s iconBox-->
                <div class="iconBox inline mg_r5">
                    <a href="javascript:void(0)" class="filterBtn">
                        <?php if ($data['filter']['type'] || $data['filter']['stat']) : ?>
                            <span class="txt point">필터 적용중</span>
                        <?php else : ?>
                            <span class="txt">필터</span>
                        <?php endif; ?>
                        <span class="icon"><i class="la la-filter"></i></span>
                        <span class="arrow_down"><i class="la la-angle-down"></i></span>
                    </a>
                </div>
                <!--e iconBox-->
            </div>
            <!--e filterBox-->
            <div class="fl filterBox">
                <div class="iconBox inline mg_r5">
                    <a href="javascript:void(0)" class="" onclick="$('#question').addClass('on')">
                        <?php if ($data['filter']['jobIdx']) : ?>
                            <span class="txt point">직무 필터 적용중</span>
                        <?php else : ?>
                            <span class="txt">직무 필터</span>
                        <?php endif; ?>
                        <span class="icon"><i class="la la-filter"></i></span>
                        <span class="arrow_down"><i class="la la-angle-down"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <!--e overflow-->

        <!--s filter_cont-->
        <div class="filter_cont">
            <div class="filter_cont_srl">
                <div class="tlt">인터뷰 타입</div>
                <!--s inpBox-->
                <div class="inpBox">
                    <div class="chek_box checkbox mg_r10">
                        <input id='im' type='checkbox' name='interType[]' value='M' <?= in_array('M', $data['filter']['type']) ? 'checked' : '' ?>>
                        <label for="im" class="lbl black">인터뷰</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ic' type='checkbox' name='interType[]' value='C' <?= in_array('C', $data['filter']['type']) ? 'checked' : '' ?>>
                        <label for="ic" class="lbl black">기업인터뷰</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ia' type='checkbox' name='interType[]' value='A' <?= in_array('A', $data['filter']['type']) ? 'checked' : '' ?>>
                        <label for="ia" class="lbl black">모의인터뷰</label>
                    </div>
                </div>
                <!--e inpBox-->

                <div class="tlt">인터뷰 진행도</div>
                <!--s inpBox-->
                <div class="inpBox">
                    <div class="chek_box checkbox mg_r10">
                        <input id='checked' type='checkbox'>
                        <label for="checked" class="lbl black">전체</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ing0' type='checkbox' name='iv_app_stat[]' value='0' <?= in_array(0, $data['filter']['stat']) ? 'checked' : '' ?>>
                        <label for="ing0" class="lbl black">카테고리 선택</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ing1' type='checkbox' name='iv_app_stat[]' value='1' <?= in_array(1, $data['filter']['stat']) ? 'checked' : '' ?>>
                        <label for="ing1" class="lbl black">프로필 촬영</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ing2' type='checkbox' name='iv_app_stat[]' value='2' <?= in_array(2, $data['filter']['stat']) ? 'checked' : '' ?>>
                        <label for="ing2" class="lbl black">마이크 테스트 완료</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ing3' type='checkbox' name='iv_app_stat[]' value='3' <?= in_array(3, $data['filter']['stat']) ? 'checked' : '' ?>>
                        <label for="ing3" class="lbl black">면접 완료</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ing4' type='checkbox' name='iv_app_stat[]' value='4' <?= in_array(4, $data['filter']['stat']) ? 'checked' : '' ?>>
                        <label for="ing4" class="lbl black">채점 완료</label>
                    </div>
                    <div class="chek_box checkbox mg_r10">
                        <input id='ing5' type='checkbox' name='iv_app_stat[]' value='5' <?= in_array(5, $data['filter']['stat']) ? 'checked' : '' ?>>
                        <label for="ing5" class="lbl black">분석 불가</label>
                    </div>
                </div>
                <!--e inpBox-->
            </div>

            <div class="BtnBox abs wi_center">
                <a id='filter_reset' href="javascript:void(0)" class="btn btn02">초기화</a>
                <button type='submit' class="btn btn01">검색</button>
            </div>
        </div>
        <!--e filter_cont-->
    </div>
    <!--e filter_bigBox-->

    <div id='question' class='pop_modal'>
        <div class='pop_full'>
            <div class='pop_con'>
                <div>
                    직무
                    <button type='submit' onclick="$('#question').removeClass('on')" style='float:right;'>검색</button>
                </div>
                <?= view_cell('\App\Libraries\CategoryLib::jobSearch') ?>

                <div class='cate_search_pop'>
                    <ul class='cate_search_list'>

                    </ul>
                </div>

                <div id='jobGuide'>

                </div>
                <!--s ardBox-->
                <div class="ardBox">
                    <?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'mutl', 'pageType' => '', 'checked' => $data['filter']['jobIdx']]) ?>
                </div>
                <!--e ardBox-->
            </div>
        </div>
    </div>
</form>

<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_5">
            <col class="wps_10">
            <col class="wps_15">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_15">
            <col class="wps_15">
        </colgroup>
        <thead>
            <tr>
                <th>번호</th>
                <th>썸네일</th>
                <th>직무</th>
                <th>인터뷰 상태</th>
                <th>회원 아이디</th>
                <th>회원 이름</th>
                <th>인터뷰 타입</th>
                <th>등록일</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['applierList']) : ?>
                <?php foreach ($data['applierList'] as $row) : ?>
                    <tr class='<?= $row['appDel'] === 'Y' ? 'wtd' : '' ?>'>
                        <td><a href='view/detail/<?= $row['appIdx'] ?>'><?= $row['appIdx'] ?></a></td>
                        <td>
                            <div class="img_box">
                                <img src="<?= $data['url']['media'] ?><?= $row['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                            </div>
                        </td>
                        <td><?= $row['jobText'] ?></td>
                        <td><?= $row['appStat'] ?></td>
                        <td><a href='view/detail/<?= $row['appIdx'] ?>'><?= $row['memId'] ?></a></td>
                        <td><?= $row['memName'] ?></td>
                        <td><?= $row['appType'] ?></td>
                        <td><?= $row['appRegDate'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan="12">해당하는 지원자가 없습니다.</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<?= $data['applierList'] ? $data['pager']->links('applier', 'admin_page') : '' ?>

<script>
    $(document).ready(function() {
        $('input[name="depth3[]"]:checked').each(function() {
            const ul = $(this).closest('ul');
            const icon = ul.prev('label').find('i');
            const label = $(this).next('label').text();
            const id = $(this).attr('id');
            const value = $(this).val();
            $('#jobGuide').append(`<span id="j${value}">${label}<label for='${id}'>삭제</label></span>`);
            ul.prev('.depth2').prev('input').prop('checked', true);
            ul.slideDown();
            icon.removeClass('la-plus');
            icon.addClass('la-minus');
        });
    });
    $('.filterBtn').on('click', function() {
        $('.filter_cont').toggleClass('open');
    });
    $('#checked').on('change', function() {
        $('input[name="iv_app_stat[]"]').prop('checked', $(this).is(':checked'));
    })
    $('input[name="userType"]').on('change', function() {
        $('#frm').submit();
    });
    $('select[name="order"]').on('change', function() {
        $('#frm').submit();
    });
    $('input[name="orderType"]').on('change', function() {
        $('#frm').submit();
    });

    $('.img_box > img').on('click', function() {
        const thisImg = $(this);
        if (thisImg.hasClass('big_img')) {
            $('img').removeClass('big_img');
            thisImg.removeClass('big_img');
        } else {
            $('img').removeClass('big_img');
            thisImg.addClass('big_img');
        }
    });

    $('#filter_reset').on('click', function() {
        $('.inpBox').find('input[type="checkbox"]').prop('checked', false);
    });

    $('input[name="depth3[]"]').on('change', function() {
        const checekd = $(this).is(':checked');
        const value = $(this).val();
        if (checekd) {
            const label = $(this).next('label').text();
            const id = $(this).attr('id');
            $('#jobGuide').append(`<span id="j${value}">${label}<label for='${id}'>삭제</label></span>`);
        } else {
            $(`#j${value}`).remove();
        }
    });
</script>

<style>
    .img_box {
        position: relative;
    }

    .img_box>img {
        max-height: 70px;
    }

    .big_img {
        top: -20vh;
        left: 0;
        position: absolute;
        width: auto !important;
        max-height: 60vh !important;
        z-index: 2;
    }
</style>