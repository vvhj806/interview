<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="main">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">받은 제안</div>
            <a href='restrictions' class="top_gray_txtlink gray_txtlink">차단기업</a>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_tab-->
    <div class="top_tab">
        <!--s depth-->
        <ul class="depth2 wd_2_2">
            <li class="on"><a href="">받은 제안 <?= $data['total'] ?></a></li>
            <li><a onclick="alert2('서비스 준비중입니다.')">리포트 조회</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s contBox-->
    <div class="contBox">

        <!--s 라디오 박스-->
        <form id="frm" method="GET" action="suggest">
            <div class="mg_b30 <?= $data['suggest'] ? '' : 'hide' ?>">
                <div class="chek_box radio mg_r15">
                    <input id="new" name="sort" type="radio" value="new" <?= (($data['sort'] ?? false) === 'new') ? 'checked' : '' ?>>
                    <label for="new" class="lbl black">최신순</label>
                </div>
                <div class="chek_box radio">
                    <input id="old" name="sort" type="radio" value="old" <?= (($data['sort'] ?? false) === 'old') ? 'checked' : '' ?>>
                    <label for="old" class="lbl black">기한 임박순</label>
                </div>
            </div>
        </form>
        <!--e 라디오 박스-->

        <!--s support_list-->
        <div class="support_list">
            <div>
                <ul>

                    <li class="no_list <?= $data['suggest'] ? 'hide' : '' ?>" style='height: auto'>
                        <!-- 리스트없을때 -->
                        <div class="ngp"><span>!</span></div>
                        받은 제안이 없어요!
                    </li>
                    <form id="frm" method="post" action="suggest/delete">
                        <?= csrf_field() ?>
                        <?php foreach ($data['suggest'] as $val) : ?>
                            <li>
                                <!--s sp_cont-->
                                <div class="sp_cont">
                                    <!--s txt_l-->
                                    <div class="txt_l">
                                        <a href="suggest/detail/<?= $val['idx'] ?>">
                                            <div class="tlt"><?= $val['com_name'] ?></div>
                                            <div class="product_desc"><?= $val['sug_end_date'] != '기간만료' ? "{$val['sug_end_date']} 까지" : '기간만료' ?></div>

                                            <div class="gtxtBox">
                                                <div class="gtxt"><?= $val['sug_type'] ?> 제안이 도착했습니다</div>
                                            </div>
                                        </a>
                                    </div>
                                    <!--e txt_l-->

                                    <button type='submit' name='suggestIdx' value='<?= $val['idx'] ?>' class="fix_data">삭제하기</button>

                                    <!--s support_btnBox-->
                                    <div class="support_btnBox support_btn_wd2 c">
                                        <a href="suggest/detail/<?= $val['idx'] ?>" class="sp_btn01 <?= $val['sug_type'] === '인터뷰' ?  '' : 'wps_100' ?>">내용 상세보기</a>
                                        <?= $val['sug_type'] === '인터뷰' ?  "<a href='javascript:' class='sp_btn02'>인터뷰 시작하기</a>" : '' ?>
                                    </div>
                                    <!--e support_btnBox-->
                                </div>
                                <!--e sp_cont-->
                            </li>
                        <?php endforeach; ?>
                    </form>
                </ul>
            </div>
        </div>
        <!--e support_list-->
        <?= $data['pager']->links('suggest', 'front_full') ?>
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->
<style>
    button {
        background: none;
    }
</style>
<script>
    $(document).ready(function() {
        $('input').on('change', function() {
            $('#frm').submit();
        });
    });
</script>