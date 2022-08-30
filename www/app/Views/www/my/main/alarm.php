<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">알림</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom_none">
        <!--s sub_tab-->
        <div class="sub_tab">
            <!--s depth-->
            <ul class="depth">
                <li <?= $data['aType'] == '' ? 'class="on"' : ''; ?>><a href="<?= $data['aType'] == '' ? 'javascript:void(0)' : '/my/alarm'; ?>">전체</a></li>
                <li <?= $data['aType'] == 'company' ? 'class="on"' : ''; ?>><a href="<?= $data['aType'] == 'company' ? 'javascript:void(0)' : '/my/alarm/company'; ?>">기업 알림</a></li>
                <li <?= $data['aType'] == 'board' ? 'class="on"' : ''; ?>><a href="<?= $data['aType'] == 'board' ? 'javascript:void(0)' : '/my/alarm/board'; ?>">공지사항/이벤트</a></li>
            </ul>
            <!--e depth-->
        </div>
        <!--e sub_tab-->
    </div>
    <!--e cont-->

    <div class='cont'>
        <!--s nfc_list-->
        <div class="nfc_list">
            <ul>
                <?php
                if (empty($data['alarm'])) :
                ?>
                    <li class="no_list">
                        <!-- 리스트가 없을때 -->
                        <div class="tlt">아직 받은 알림이 없어요! </div>
                    </li>
                <?php
                else :
                ?>
                    <?php
                    foreach ($data['alarm'] as $key => $val) :
                    ?>
                        <li <?= $data['alarm'][$key]['reg_date'] == $data['alarm'][$key]['mod_date'] ? 'class="no_click"' : ''; ?>>
                            <a href="javascript:void(0)" class="list_a" data-value="<?= $data['alarm'][$key]['alarm_type2'] == 'N' ? $data['alarm'][$key]['alarm_page_idx'] : $data['alarm'][$key]['pageIdx']; ?>" data-type="<?= $data['alarm'][$key]['alarm_type2'] ?>">
                                <?php if ($data['alarm'][$key]['alarm_type2'] == 'N') : ?>
                                    <div class="noticeBox">
                                        <div class="tlt">

                                            <span class="notice_icon"><img src="/static/www/img/sub/notice_icon.png"></span>

                                            <?= $data['alarm'][$key]['alarm_title'] ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="tlt">
                                        <?= $data['alarm'][$key]['alarm_title'] ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($data['alarm'][$key]['alarm_type2'] == 'P') : ?>
                                    <div class="stxt">[기업명] [제안 종류]</div>
                                <?php endif; ?>
                                <?php if ($data['alarm'][$key]['alarm_link'] != '') :  ?>
                                    <div class="adBox">AD</div>
                                <?php endif; ?>

                                <div class="data"><?= $data['alarm'][$key]['aDateResult'] ?></div>
                            </a>

                            <!--s list_close-->
                            <div class="list_close">
                                <a href="#n"><img src="/static/www/img/sub/list_close.png"></a>
                            </div>
                            <!--e list_close-->
                        </li>
                    <?php
                    endforeach;
                    ?>
                <?php
                endif;
                ?>

            </ul>
        </div>
        <!--e nfc_list-->
    </div>
</div>
<!--e #scontent-->
<?= csrf_field() ?>

<script>
    $('.list_a').on('click', function() {
        if ($(this).data('type') == 'A') {
            $(this).attr('href', '/my/suggest/detail/' + $(this).data('value'));
        } else if ($(this).data('type') == 'C') {
            $(this).attr('href', '/board/notice');
        } else if ($(this).data('type') == 'D') {
            $(this).attr('href', '/board/event/' + $(this).data('value'));
        }
        /*
        $.ajax({
            type: 'POST',
            url: '/api/my/push/alarm',
            data: {
                'Recommend': $('#Recommend').val(),

                'csrf_highbuff': $('input[name=csrf_highbuff]').val(),
                'postCase': 'alarmCheck',
                'BackUrl': '/',
            },
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {

                } else {
                    alert(data.messages);
                    return false;
                }
                return true;
            },
            error: function(e) {
                alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                return;
            }
        }) //ajax;
        */
    });
</script>