<div id="jy_interview_pr_mb2" class=" ani_top_pop2">
    <!--s popBox-->
    <div class="popBox pd_t10 c">
        <div class="top_tltBox c">
            <!--s top_tltcont-->
            <div class="top_tltcont">
                <a href="/">
                    <div class="backBtn"><span>뒤로가기</span></div>
                </a>
            </div>
            <!--e top_tltcont-->
        </div>
        <!--e top_tltBox-->

        <!--s pop_cont_scroll-->
        <div class="pop_cont_scroll">
            <!--s bigtlt-->
            <div class="bigtlt bigtlt_mg_b">
                수고하셨습니다!<br />
                <?= $data['session']['name'] ?> 님의<br />
                <span class="point b">A.I. 인터뷰가 완료되었어요</span>
            </div>
            <!--e bigtlt-->

            <!--s jy_interview_img-->
            <div class="jy_interview_img">
                <img src="/static/www/img/sub/jy_interview_img.png">
            </div>
            <!--e jy_interview_img-->

            <!--s stlt-->
            <div class="stlt">
                잠시만 기다려 주시면<br />
                AI가 열심히 인터뷰를 분석해 <br />
                점수를 알려드릴게요 !
                <div class="gray mg_t10">(최대 30분 소요)</div>
            </div>
            <!--e stlt-->

            <!--s 새 인터뷰(연습인터뷰) 완료/ 모의 인터뷰 완료 버튼-->
            <!--s line_btnBox-->
            <div class="line_btnBox" id="practiceIv" style="display:none">
                <a href="/report" class="wps_100 company_interview_pr_pop_open">
                    <div class="line_btn_tlt">어떻게 나왔을지 궁금해요!</div>
                    <div class="line_btn_txt">방금 찍은 인터뷰 확인하러 가기</div>
                </a>

                <a href="/" class="wps_100" id="main">
                    <div class="line_btn_tlt">기다리는 동안 둘러볼래요</div>
                    <div class="line_btn_txt">메인으로 돌아가기</div>
                </a>
            </div>
            <!--e line_btnBox-->
            <!--e 새 인터뷰(연습인터뷰) 완료/ 모의 인터뷰 완료 버튼-->

            <!--s 내 인터뷰로 지원하기 / 기업 인터뷰로지원하기 완료일때 버튼-->
            <!--s line_btnBox-->
            <div class="line_btnBox" id="companyIv" style="display:none">
                <a href="/jobs/apply?app=<?= $data['applyIdx'] ?>&data=<?= $data['enRecIdx'] ?>" class="wps_100 company_interview_pr_pop_open">
                    <div class="line_btn_tlt">바로 지원할래요!</div>
                    <div class="line_btn_txt">지원 페이지로 이동하기</div>
                </a>

                <a href="/jobs/list" class="wps_100">
                    <div class="line_btn_tlt">결과 확인 후 지원할래요!</div>
                    <div class="line_btn_txt">기다리는 동안 공고 둘러보기</div>
                </a>

                <a href="/report" class="wps_100" >
                    <div class="line_btn_tlt">어떻게 나왔을지 궁금해요!</div>
                    <div class="line_btn_txt">방금 찍은 인터뷰 확인하러 가기</div>
                </a>
            </div>
            <!--e line_btnBox-->
            <!--e 내 인터뷰로 지원하기 / 기업 인터뷰로지원하기 완료일때 버튼-->

        </div>
        <!--e pop_cont_scroll-->
    </div>
    <!--e pop_cont-->
</div>
<!--e popBox-->
</div>

<script>
    buttonSet();
    function buttonSet() {
        if ("<?= $data['endInterview']['rec_idx'] ?>" != null && "<?= $data['endInterview']['rec_idx'] ?>" != "" && " <?= $data['endInterview']['rec_idx'] ?>" != 0) {
            $('#companyIv').show();
        } else {
            $('#practiceIv').show();
        }
    }
</script>