<div class="content_title">
    <h3>리포트 보기</h3>
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
                        <?php if ($data['filter']['type']) : ?>
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
                <th>이력서</th>
                <th>리포트 상태</th>
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
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['appIdx'] ?></a></td>
                        <td>
                            <div class="img_box">
                                <img src="<?= $data['url']['media'] ?><?= $row['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                            </div>
                        </td>
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['jobText'] ?></a></td>
                        <?php if ($row['resIdx']) : ?>
                            <td><a href='/prime/resume/write/<?= $row['resIdx'] ?>'><?= $row['resTitle'] ?></a></td>
                        <?php else : ?>
                            <td>없음</td>
                        <?php endif; ?>
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['appComprehensive'] ? '종합 리포트' : '일반 리포트' ?></a></td>
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['memId'] ?></a></td>
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['memName'] ?></a></td>
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['appType'] ?></a></td>
                        <td><a href='view/<?= $row['address'] ?>/<?= $row['strAppIdx'] ?>'><?= $row['appRegDate'] ?></a></td>
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