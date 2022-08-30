<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/main">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">내 이력서</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="contBox">
        <div class="pl_btn c"><a href="/my/resume/modify/0" class="wps_100">+ 새 이력서 작성하기</a></div>
        <!-- <div class="pl_btn mg_t7 c"><a href="javascript:void(0)" class="wps_100" onclick="fnShowPop('write_pop')">+ 취업사이트 이력서 불러오기</a></div> -->
        <div class="pl_btn mg_t7 c"><a href="javascript:void(0)" class="wps_100" onclick="alert('서비스 준비중입니다.')">+ 취업사이트 이력서 불러오기</a></div>
    </div>
    <!--e contBox-->

    <!--s top_jbBox-->
    <div class="top_jbBox c mg_t35">
        <div class="txt">
            <div class="font23 mg_b10 black">이력서는 AI리포트와 함께 공개할 수 있어요!</div>
            <a href="/report/share" class="point">AI리포트 공개설정 바로가기 <i class="la la-angle-right"></i></a>
        </div>
    </div>
    <!--e top_jbBox-->
    <?php $cntResume = count($data['resume']); ?>
    <!--s contBox-->
    <div class="cont">
        <div class="sel_lineb">
            <div class="mg_b10">총 <?= $cntResume ?>개</div>
        </div>

        <!--s resume_list-->
        <div class="resume_list">
            <ul>
                <!--s 무한루프-->
                <?php
                for ($i = 0; $i < $cntResume; $i++) :
                    $jobportal_info = explode('/', $data['resume'][$i]['res_jobportal']);
                    if (isset($jobportal_info[1])) : //취업사이트에서 불러온 이력서 경우 
                ?>
                        <li style="<?= ($jobportal_info[1] == 0) ? 'background-color: #f3f2f2' : '' ?>">
                            <a href="<?= ($jobportal_info[1] != 0) ? '/my/resume/modify/' . $data['resume'][$i]['idx'] : 'javascript:void(0)' ?>">
                                <div class="tlt">
                                    <?php
                                    if ($jobportal_info[1] == 0) {
                                        echo '[ (' . $jobportal_info[0] . ') 이력서 불러오는중 ]';
                                    } else if ($jobportal_info[1] == 1) { //불러오기 성공
                                        echo '[ (' . $jobportal_info[0] . ') ' . $data['resume'][$i]['res_title'] . ' ]';
                                    } else { //불러오기 실패
                                        echo '[ (' . $jobportal_info[0] . ') 이력서 불러오기 실패 ]';
                                    }
                                    ?>
                                </div>
                                <div class="data"><?= date("Y-m-d", strtotime($data['resume'][$i]['res_reg_date'])) ?> 작성</div>
                            </a>

                            <div class="btnBox">
                                <?php if ($jobportal_info[1] != 0) : ?>
                                    <a href="/my/resume/modify/<?= $data['resume'][$i]['idx'] ?>" class="rm_btn01">수정</a>
                                <?php endif; ?>
                                <a href="javascript:void(0)" class='delete_btn' data-idx='<?= $data['resume'][$i]['idx'] ?>'>삭제</a>
                            </div>
                        </li>
                    <?php else : //일반 이력서 경우 
                    ?>
                        <li>
                            <a href="/my/resume/modify/<?= $data['resume'][$i]['idx'] ?>">
                                <div class="tlt">[ <?= $data['resume'][$i]['res_title'] != '' ? $data['resume'][$i]['res_title'] : ($i + 1) . '번째 이력서' ?> ]</div>
                                <div class="data"><?= date("Y-m-d", strtotime($data['resume'][$i]['res_reg_date'])) ?> 작성</div>
                            </a>

                            <div class="btnBox">
                                <a href="/my/resume/modify/<?= $data['resume'][$i]['idx'] ?>" class="rm_btn01">수정</a>
                                <a href="javascript:void(0)" class='delete_btn' data-idx='<?= $data['resume'][$i]['idx'] ?>'>삭제</a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
                <!--e 무한루프-->
            </ul>
        </div>
        <!--e resume_list-->
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<!--s 기업 인터뷰로 클릭시 모달-->
<div id="write_pop" class="pop_modal2">
    <form id="jobportal_form" action="/my/resume/jobportal" method="POST">
        <input type="hidden" name="jobportal" value="사람인">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <!-- <a href="javascript:void(0)" style="float:right" onclick="fnHidePop('write_pop')">X</a> -->
                <!--s selBox-->
                <div class="selBox wps_100 mg_b30">
                    <div class="selectbox wps_100">
                        <ul class="logtab wd_4 mg_t0 mg_b10 c">
                            <li class="on" rel="saramin"><a href="javascript:void(0)">사람인</a></li>
                            <li rel="jobkorea"><a href="javascript:void(0)">잡코리아</a></li>
                            <li rel="incruit"><a href="javascript:void(0)">인크루트</a></li>
                            <li rel="worknet"><a href="javascript:void(0)">워크넷</a></li>
                        </ul>
                    </div>
                </div>
                <!--e selBox-->

                <!--s spop_lineBox-->
                <div class="login_inpBox">
                    <!--s #tab1 일반회원-->
                    <div id="tab1" class="tab_content fast">
                        <!--s login_inpBox-->
                        <div class="login_inp_box">
                            <div class="inp"><input type="text" id="jobportal_id" name="jobportal_id" class="frm_input wps_100 required" placeholder="사람인 아이디 입력" autocomplete="off"></div>
                            <div class="inp"><input type="password" id="jobportal_pw" name="jobportal_pw" class="frm_input wps_100 required" placeholder="사람인 패스워드 입력" autocomplete="off"></div>
                        </div>
                        <!--e login_inpBox-->

                        <div class="jptxt">취업사이트에 있는 저장되어있는 대표 이력서를 불러옵니다.</div>
                        <div class="jptxt">이력서를 불러오는데 최대 1시간이 소요될 수 있습니다.</div>
                    </div>
                    <!--e #tab1 일반회원-->

                    <button type="submit" class="btn_submit">불러오기</button>
                    <a href="javascript:void(0)" class="jp_cancel btn02 wps_100 mg_t10" onclick="fnHidePop('write_pop')">다음에 할께요</a>
                    <?= csrf_field() ?>
                </div>
                <!--e spop_lineBox-->
            </div>
            <!--e pop_cont-->
        </div>
        <!--e pop_Box-->
    </form>
</div>
<!--e 기업 인터뷰로 클릭시 모달-->

<script>
    $('.logtab li').click(function() {
        $('.logtab li').removeClass('on');
        $(this).addClass('on');
        $('#jobportal_id').attr('placeholder', $(this).text() + ' 아이디 입력');
        $('#jobportal_pw').attr('placeholder', $(this).text() + ' 패스워드 입력');
        $('input[name=jobportal]').val($(this).text());
    });

    $('.delete_btn').on('click', function() {
        if (!confirm("정말 이력서를 삭제 하시겠습니까?")) {
            return;
        }
        location.href = '/my/resume/delete/' + $(this).data('idx');
    });

    $('.btn_submit').click(function() {
        let id = $('#jobportal_id').val();
        let pw = $('#jobportal_pw').val();

        if (id == '') {
            alert('아이디를 입력해주세요.');
            $('#jobportal_id').focus();
            return false;
        }

        if (id.length < 4) {
            alert('아이디를 올바르게 입력해주세요.');
            $('#jobportal_id').focus();
            return false;
        }

        if (pw == '') {
            alert('패스워드를 입력해주세요.');
            $('#jobportal_pw').focus();
            return false;
        }

        if (pw.length < 4) {
            alert('패스워드를 올바르게 입력해주세요.');
            $('#jobportal_pw').focus();
            return false;
        }

        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $("#jobportal_form").submit();
    });
</script>