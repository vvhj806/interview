<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">마이페이지</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t30">
        <!--s mypage_cont-->
        <div class="contBox mypage_cont">
            <!--s imgBox-->
            <div class="imgBox">
                <div class="img"><img src="<?= $data['file']['file_save_name'] ?>" id="changeImg"></div>

                <!--s txtBox-->
                <div class="txtBox">
                    <div class="name"><span class="b"><?= $data['Member']['mem_name'] ?? '사용자' ?></span> 님</div>
                    <a href="/my/modify">
                        <div class="modifyBtn a_line">내 정보 수정하기 <i class="la la-angle-right"></i></div>
                    </a>
                </div>
                <!--e txtBox-->

                <!--s mypage_alarm-->
                <div class="mypage_alarm">
                    <a href="/my/alarm">
                        <span class="icon"><img src="/static/www/img/inc/hd_alarm_icon.png"></span>
                        <?php if ($data['nIcon']['alarm']) : ?>
                            <span class="new">N</span>
                        <?php endif; ?>
                    </a>
                </div>
                <!--e mypage_alarm-->
            </div>
            <!--e imgBox-->

            <!--s alarmBox-->
            <div class="alarmBox">
                <a href="/my/interest/main">
                    <div class="tlt black">
                        <?php foreach ($data['category'] as $key => $val) :
                            if ($key == 0) :
                                echo $val['job_depth_text'];
                            else :
                                echo " / " . $val['job_depth_text'];
                        ?>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                    <div class="product_desc">
                        <?php foreach ($data['kor'] as $key => $val) :
                            if ($key == 0) :
                                echo $val['area_depth_text_1'];
                            else :
                                echo " / " . $val['area_depth_text_1'];
                        ?>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                    <span class="arrow_icon"></span>
                </a>
            </div>
            <!--e alarmBox-->

            <!--s alarmBox-->
            <!-- <div class="alarmBox">
                <a href="javascript:void(0)">
                    <div class="tlt black">어떤 포지션에서 일하고 싶나요?</div>
                    <div class="product_desc">관심 직무 입력하고, 맞춤 정보 추천받기</div>
                    <span class="arrow_icon"></span>
                </a>
            </div> -->
            <!--e alarmBox-->

            <!--s mypage_qUl-->
            <ul class="mypage_qUl c mg_t30">
                <li>
                    <a href="resume">
                        <div class="txt">
                            <p>내 이력서</p>
                            <?php if ($data['nIcon']['resume']) : ?>
                                <span class="new">N</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/report">
                        <div class="txt">
                            <p>내 리포트</p>
                            <?php if ($data['nIcon']['applier']) : ?>
                                <span class="new">N</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="recruit_info/completed">
                        <div class="txt">
                            <p>지원현황</p>
                            <?php if ($data['nIcon']['recruitInfo']) : ?>
                                <span class="new">N</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/my/suggest">
                        <div class="txt">
                            <p>받은 제안</p>
                            <?php if ($data['nIcon']['suggest']) : ?>
                                <span class="new">N</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
            </ul>
            <!--e mypage_qUl-->

            <!--s mypage_bnBox-->
            <div class="mypage_bnBox mg_t30">
                <a href="/report"><img src="/static/www/img/sub/mypage_bn.png"></a>
            </div>
            <!--e mypage_bnBox-->

            <!--s bookmark_ul-->
            <ul class="bookmark_ul c mg_t30">
                <li>
                    <a href="recently">최근본 공고</a>
                </li>
                <li>
                    <a href="scrap/recruit">즐겨찾는 공고</a>
                </li>
                <li>
                    <a href="scrap/company">즐겨찾는 기업</a>
                </li>
            </ul>
            <!--e bookmark_ul-->
        </div>
        <!--s mypage_cont-->
    </div>
    <!--e gray_bline_first-->

    <!--s mypageUl-->
    <ul class="mypageUl cont">
        <li>
            <a href="/board/notice">
                <div class="txt">공지사항</div>
            </a>
        </li>
        <li>
            <a href="/board/event">
                <div class="txt">이벤트</div>
            </a>
        </li>
        <li>
            <a href="restrictions">
                <div class="txt">차단기업</div>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="alert2('서비스 준비중 입니다.')">
                <div class="txt">취업증명서 발급</div>
            </a>
        </li>
        <li>
            <a href="/help/guide/interview">
                <div class="txt">이용가이드</div>
            </a>
        </li>
        <li>
            <a href="/help/faq">
                <div class="txt">고객센터 </div>
            </a>
        </li>
        <li>
            <a href="/my/setting">
                <div class="txt">환경설정</div>
            </a>
        </li>
    </ul>
    <!--e mypageUl-->
</div>
<!--e #scontent-->