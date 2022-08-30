<!-- 새롭게 리뉴얼된 report -->
<!-- 아이콘 폰트 -->
<link rel="stylesheet" href="//maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">A.I. 종합리포트</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t20">
        <!--s contBox-->
        <div class="contBox">
            <!--s n_resume_info-->
            <div class="n_resume_info">
                <!--s imgBox-->
                <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $data['fileSaveName'] ?? '/static/www/img/sub/prf_no_img.jpg' ?>"></div>
                <!--e imgBox-->

                <!--s txtBox-->
                <div class="txtBox">
                    <ul>
                        <li>
                            <span class="tlt">이름</span>
                            <span class="txt"><?= $data['memName'] ?></span>
                        </li>
                        <?php if ($data['job']) : ?>
                            <li>
                                <span class="tlt">지원분야</span>
                                <span class="txt"><?= $data['job'] ? $data['job'] : ''  ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!--e txtBox-->
            </div>
            <!--e n_resume_info-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t50">
        <!--s contBox-->
        <div class="contBox">
            <div class="mtltBox c b">
                <div class="mtlt">A.I. 종합리포트</div>
            </div>

            <div class="stltBox">
                <div class="stlt">
                    A.I. 종합결과
                    <span class="toolp_span"><a href="#n" onclick="fnShowPop('all_rep01')">?</a></span>
                </div>
            </div>

            <!--s ratingBox-->
            <div class="ratingBox">
                <div class="rating_txtBox">
                    <div class="tlt">종합등급</div>
                    <div class="txt"><?= $data['T']['analysis']['grade'] ?> 등급</div>
                </div>

                <div class="rating_txtBox">
                    <div class="tlt">종합점수</div>
                    <div class="txt"><?= $data['reportScore'] ?> <span class="small">/100점</span></div>
                </div>

                <div class="rating_txtBox">
                    <div class="tlt">응답 신뢰 가능성</div>
                    <div class="txt"><?= $data['response'] ?></div>
                </div>
            </div>
            <!--e ratingBox-->

            <?php if ($data['job']) : ?>
                <!--s all_tabsBox-->
                <div class="all_tabsBox mg_t20">
                    <!--s ard_btn-->
                    <ul class="all_tabs wd_2">
                        <li class="active"><a href="#n" rel="all_tab01_1">동일 직군 등급</a></li>
                        <li><a href="#n" rel="all_tab01_2">전체 지원자 등급</a></li>
                    </ul>
                    <!--e ard_btn-->

                    <!--s #all_tab01_1-->
                    <div id="all_tab01_1" class="all_tab_content fast">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <!--s stlt-->
                            <div class="stlt b">
                                <span class="point"><?= $data['job'] ? '[' . $data['job'] . ']' : ''  ?></span> 지원자중
                                <span class="sp_back sp_back_cl01">
                                    상위 <span class="rankPoint">10</span>%
                                </span> 에 위치해요
                            </div>
                            <!--e stlt-->

                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox'>
                                    <?php foreach ($data['T']['reportScoreRank']['C'] as $val) : ?>
                                        <?php if ($val['score_rank_grade'] === $data['T']['analysis']['grade']) : ?>
                                            <div class='chart_bar my'>
                                                <span class="score_point">내등급</span>
                                                <span class='chartpoint'>
                                                    <span><?= $val['score_rank_count_member'] ?></span>명
                                                </span>
                                                <div class='blue bar'></div>
                                            </div>
                                        <?php else : ?>
                                            <div class='chart_bar'>
                                                <span class='chartpoint'>
                                                    <span><?= $val['score_rank_count_member'] ?></span>명
                                                </span>
                                                <div class='sky bar'></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class='chartLine blue'></div>

                                <div class="chart_grade_txt">
                                    <?php foreach ($data['T']['reportScoreRank']['T'] as $val) : ?>
                                        <div style="width:20%;"><?= $val['score_rank_grade'] ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph01.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e all_tab01_1-->

                    <!--s #all_tab01_2-->
                    <div id="all_tab01_2" class="all_tab_content">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <!--s stlt-->
                            <div class="stlt b">
                                <span class="point2">[전체]</span> 지원자중 <span class="sp_back sp_back_cl02">상위 <span class="rankPoint">10</span>%</span> 에 위치해요
                            </div>
                            <!--e stlt-->

                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox'>
                                    <?php foreach ($data['T']['reportScoreRank']['T'] as $val) : ?>
                                        <?php if ($val['score_rank_grade'] === $data['T']['analysis']['grade']) : ?>
                                            <div class='chart_bar my'>
                                                <span class="score_point green_color">내등급</span>
                                                <span class='chartpoint'>
                                                    <span><?= $val['score_rank_count_member'] * 10 ?></span>명
                                                </span>
                                                <div class='bluegreen bar'></div>
                                            </div>
                                        <?php else : ?>
                                            <div class='chart_bar'>
                                                <span class='chartpoint'>
                                                    <span><?= $val['score_rank_count_member'] * 10 ?></span>명
                                                </span>
                                                <div class='lightbluegreen bar'></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class='chartLine bluegreen'></div>
                                <div class="chart_grade_txt">
                                    <?php foreach ($data['T']['reportScoreRank']['T'] as $val) : ?>
                                        <div style="width:20%;"><?= $val['score_rank_grade'] ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph02.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab01_2-->
                </div>
                <!--e all_tabsBox-->
            <?php endif; ?>

            <?php if ($data['mbtiData']) : ?>
                <div class="stltBox mg_t50 mg_b25" style="margin: 30px 15px 10px 15px">
                    <div class="stlt mg_b10 b">MBTI 직무연관성</div>
                    <div class="txt gray">
                        <?php if ($data['mbtiData']['stat']) : ?>
                            지원자의 MBTI를 분석하여 지원 직무와의 연관도를 나타냅니다.
                        <?php else : ?>
                            <a href='/my/interest/main' class='point'>MBTI를 입력하시면 본 리포트를 확인할 수 있습니다.​</a>
                        <?php endif; ?>
                    </div>
                </div>
                <!--s ai_rpv_txtBox-->
                <div class="ai_rpv_txtBox wBox">
                    <div class='fail_box <?= !$data['mbtiData']['stat'] ? 'on' : '' ?>'></div>
                    <div class="tlt mg_b50 b"><?= $data['job'] ? '[' . $data['job'] . ']' : ''  ?> 직무와 MBTI 연관도</div>
                    <div class="snsChart">
                        <div class="snsWidthChart">
                            <span class="grayTxt">낮음</span>
                            <div class="snsChartLeng">
                                <div class="snsChartPer blue_color" style="width: <?= $data['mbtiData']['score'] ?>%;">
                                    <div><span class="snsPerTxt point"><?= $data['mbtiData']['score']  ?>%</span></div>
                                </div>
                            </div>
                            <span class="grayTxt">높음</span>
                        </div>
                    </div>
                    <div class="txt gray mg_t10"><?= $data['mbtiData']['mbti'] ?>의 <?= $data['mbtiData']['msg'] ?></div>

                    <div class="tlt mg_b10 mg_t30 b">A.I. 추천 직무</div>
                    <div class='div_list'>
                        <?php foreach ($data['mbtiData']['recommendJob'] as $val) : ?>
                            <div class="txt gray"><?= $val ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->
            <?php endif; ?>

            <div id="serviceReady" class="blindDetailArea hide"></div>
            <div id="serviceReadyTxt" class="blindDeatilText hide">서비스 준비중입니다</div>

            <!--s stltBox-->
            <div class="stltBox mg_t50 mg_b25 hide" style="margin: 30px 15px 10px 15px">
                <div class="stlt mg_b10">SNS 스코어</div>
                <div class="txt gray">
                    CNN 알고리즘을 중심으로 SNS 사진의 특성과 심리적 성향 간의 관계를 분석합니다
                </div>
            </div>
            <!--e stltBox-->

            <!--s ai_rpv_txtBox-->
            <div class="ai_rpv_txtBox wBox hide">
                <div class="stlt mg_b10">심리적 성향</div>
                <div class="txt gray">우호적, 성실함, 외향적</div>
                <div class="stlt mg_b10 mg_t30">대인관계</div>
                <div class="snsChart">
                    <div class="snsWidthChart">
                        <span class="grayTxt">낮음</span>
                        <div class="snsChartLeng">
                            <div class="snsChartPer blue_color" style="width: 78.8%;">
                                <div><span class="snsPerTxt point">78.8%</span></div>
                            </div>
                        </div>
                        <span class="grayTxt">높음</span>
                    </div>
                </div>

                <div class="stlt mg_b10 mg_t30">자존감</div>
                <div class="jd_graphBox">
                    <div class="snsWidthChart">
                        <span class="grayTxt">낮음</span>
                        <div class="snsChartLeng">
                            <div class="snsChartPer bluegreen" style="width: 75.2%;">
                                <div><span class="snsPerTxt point2">75.2%</span></div>
                            </div>
                        </div>
                        <span class="grayTxt">높음</span>
                    </div>
                    <!-- <img src="/static/www/img/sub/test_graph03_2.png"> -->
                </div>
            </div>
            <!--e ai_rpv_txtBox-->


            <!--s stltBox-->
            <!-- <div class="stltBox mg_t50 mg_b25">
                <div class="stlt mg_b10">직무연관성</div>
                <div class="txt gray">
                    이력서를 기반으로 지원한 직무와의 연관도를 분석하여 결과를 나타내며 A.I. 추천 직무도 함께 제공됩니다.
                </div>
            </div> -->
            <!--e stltBox-->

            <!--s ai_rpv_txtBox-->
            <!-- <div class="ai_rpv_txtBox wBox">
                <div class="stlt mg_b10">[<?= $data['job'] ? $data['job'] : ''  ?>] 직무와의 연관도</div>
                <div class="txt gray mg_b20">각 직무와 관련되는 학과, 활동내역, 자격증, 어학능력 등을 분석하여 지원한 직군과의 연관도를 나타냅니다. </div>

                <div class="jd_graphBox">
                    <div class="snsWidthChart" style="margin-top: 50px;">
                        <span class="grayTxt">낮음</span>
                        <div class="snsChartLeng" style="width: 85%;">
                            <div class="snsChartPer blue_color" style="width: 81%;">
                                <div><span class="snsPerTxt point">81%</span></div>
                            </div>
                        </div>
                        <span class="grayTxt">높음</span>
                    </div>
                </div>

                <div class="stlt mg_b10 mg_t50">A.I. 추천 직무</div>
                <ul class="rcm_vUl">
                    <li>마케팅</li>
                    <li>광고분석</li>
                    <li>리서치, 통계, 조사분석</li>
                </ul>
            </div> -->
            <!--e ai_rpv_txtBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <?php if ($data['isRes'] == true) : ?>
        <!--s gray_bline_first-->
        <div class="gray_bline_first mg_t50">
            <!--s contBox-->
            <div class="contBox">
                <div class="mtltBox mg_b0 c b">
                    <div class="mtlt">A.I. 이력서 리포트</div>
                </div>

                <!--s itv_pr_grayBox-->
                <div class="itv_pr_grayBox black c mg_t20">
                    지원자의 이력서를 바탕으로 검증된 A.I. 알고리즘으로 분석하여 동일 지원 분야의 지원자 대비 등급과 점수를 나타냅니다.<br />
                </div>
                <!--e itv_pr_grayBox-->

                <!--s ratingBox-->
                <div class="ratingBox mg_t20">
                    <div class="rating_txtBox">
                        <div class="tlt">종합등급</div>
                        <div class="txt"><?= $data['resume']['atotal'][0]['rank'] ?> 등급</div>
                    </div>

                    <div class="rating_txtBox">
                        <div class="tlt">종합점수</div>
                        <div class="txt"><?= $data['resumeScore'] ?> <span class="small">/100점</span></div>
                    </div>
                </div>
                <!--e ratingBox-->

                <!--s ai_rpv_txtBox-->
                <div class="ai_rpv_txtBox wBox mg_t20">
                    <!--s stlt-->
                    <div class="stlt b">
                        <span class="point">[<?= $data['job'] ? $data['job'] : ''  ?>]</span> 지원자중 <span class="sp_back sp_back_cl01">상위 10%</span> 에 위치해요
                    </div>
                    <!--e stlt-->

                    <div class="jd_graphBox c mg_t30">
                        <div class="jd_graphBox c mg_t30">
                            <div class='chartBox'>
                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['edu'] ?>%;"></div>
                                </div>
                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['edu'] ?>%;"></div>
                                </div>

                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['career'] ?>%;"></div>
                                </div>
                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['career'] ?>%;"></div>
                                </div>

                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['language'] ?>%;"></div>
                                </div>
                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['language'] ?>%;"></div>
                                </div>

                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['license'] ?>%;"></div>
                                </div>
                                <div class='chart_bar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['license'] ?>%;"></div>
                                </div>
                            </div>
                            <div class='chartLine grayBar'></div>

                            <div class="chart_grade_txt">
                                <div class="resChartTxt">학력</div>
                                <div class="resChartTxt">경력</div>
                                <div class="resChartTxt">어학</div>
                                <div class="resChartTxt">자격증</div>
                            </div>
                        </div>

                        <div class="resChartLabelWrap">
                            <div class="resLabelSq">
                                <div class="resChartLabelSq blue_color"></div>
                                <div>나의스펙</div>
                            </div>

                            <div class="resLabelSq">
                                <div class="resChartLabelSq bluegreen"></div>
                                <div>지원자 평균 스펙</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s stltBox-->
                <div class="stltBox mg_t50">
                    <div class="stlt">지원자 평균 스펙</div>
                </div>
                <!--e stltBox-->

                <!--s ai_rpv_txtBox-->
                <div class="ai_rpv_txtBox grayBox">
                    <!--s bwUl-->
                    <div class="bwUl">
                        <ul>
                            <li>
                                <div class="tlt b">학력</div>
                                <div class="txt">
                                    <?= $data['resume']['text'][0]['edu'] ?>
                                </div>
                            </li>
                            <li>
                                <div class="tlt b">경력</div>
                                <div class="txt">
                                    <?= $data['resume']['text'][0]['career'] ?>
                                </div>
                            </li>
                            <li>
                                <div class="tlt b">어학</div>
                                <div class="txt">
                                    <?= $data['resume']['text'][0]['language'] ?>
                                </div>
                            </li>
                            <li>
                                <div class="tlt b">자격증</div>
                                <div class="txt">
                                    <?= $data['resume']['text'][0]['license'] ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--e bwUl-->
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s stltBox-->
                <div class="stltBox mg_t50 mg_b25">
                    <div class="stlt mg_b10">나의 스펙</div>
                    <div class="txt gray">
                        스펙 점수가 평균보다 낮다면, A.I. 면접을 통해 어필해 보세요.
                    </div>
                </div>
                <!--e stltBox-->

                <div class="jd_graphBox c mg_t30" style="display:flex;justify-content: center;">
                    <canvas id="specChart" class="specChartWrap specChartSize" width="300" height="300"></canvas>
                    <!-- <img src="/static/www/img/sub/test_graph05.png" class="wps_65"> -->
                </div>


                <!--s stltBox-->
                <div class="stltBox mg_t100 mg_b25">
                    <div class="stlt mg_b10">
                        지원자 현황 분석
                        <span class="toolp_span"><a href="#n" onclick="fnShowPop('all_rep02')">?</a></span>
                    </div>
                    <div class="txt overflow">
                        <span class="fl">지원자 수 <span class="point"><?= $data['resume']['total'] ?>명</span></span>
                        <span class="fr gray">2022.07.01 기준</span>
                    </div>
                </div>
                <!--e stltBox-->

                <!--s all_tabsBox-->
                <div class="all_tabsBox mg_t20">
                    <!--s ard_btn-->
                    <ul class="all_tabs wd_6">
                        <li class="active"><a href="#n" rel="all_tab02_1">학력</a></li>
                        <li><a href="#n" rel="all_tab02_2">경력</a></li>
                        <li><a href="#n" rel="all_tab02_3">외국어</a></li>
                        <li><a href="#n" rel="all_tab02_4">TOEIC</a></li>
                        <li><a href="#n" rel="all_tab02_5">자격증</a></li>
                        <li><a href="#n" rel="all_tab02_6">활동 지수</a></li>
                    </ul>
                    <!--e ard_btn-->

                    <!--s #all_tab02_1-->
                    <div id="all_tab02_1" class="all_tab_content fast">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox an'>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a1 ?>%;">
                                            <?php if ($data['resume']['top']['edu']['a1']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalEdu'][0]->a1 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a2 ?>%;">
                                            <?php if ($data['resume']['top']['edu']['a2']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalEdu'][0]->a2 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a3 ?>%;">
                                            <?php if ($data['resume']['top']['edu']['a3']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalEdu'][0]->a3 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a4 ?>%;">
                                            <?php if ($data['resume']['top']['edu']['a4']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalEdu'][0]->a4 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a5 ?>%;">
                                            <?php if ($data['resume']['top']['edu']['a5']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalEdu'][0]->a5 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart_grade_txt">
                                    <div class="anChartTxt">고졸이하</div>
                                    <div class="anChartTxt">2~3년제</div>
                                    <div class="anChartTxt">4년제</div>
                                    <div class="anChartTxt">석사</div>
                                    <div class="anChartTxt">박사</div>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph06_1.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab02_1-->

                    <!--s #all_tab02_2-->
                    <div id="all_tab02_2" class="all_tab_content">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox an'>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a1 ?>%;">
                                            <?php if ($data['resume']['top']['career']['a1']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalCareer'][0]->a1 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a2 ?>%;">
                                            <?php if ($data['resume']['top']['career']['a2']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalCareer'][0]->a2 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a3 ?>%;">
                                            <?php if ($data['resume']['top']['career']['a3']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalCareer'][0]->a3 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a4 ?>%;">
                                            <?php if ($data['resume']['top']['career']['a4']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalCareer'][0]->a4 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a5 ?>%;">
                                            <?php if ($data['resume']['top']['career']['a5']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalCareer'][0]->a5 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart_grade_txt">
                                    <div class="anChartTxt">신입</div>
                                    <div class="anChartTxt">1년미만</div>
                                    <div class="anChartTxt">1~3년</div>
                                    <div class="anChartTxt">3~5년</div>
                                    <div class="anChartTxt">5년이상</div>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph06_2.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab02_2-->

                    <!--s #all_tab02_3-->
                    <div id="all_tab02_3" class="all_tab_content">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox an'>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a1 ?>%;">
                                            <?php if ($data['resume']['top']['language']['a1']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLanguage'][0]->a1 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a2 ?>%;">
                                            <?php if ($data['resume']['top']['language']['a2']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLanguage'][0]->a2 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a3 ?>%;">
                                            <?php if ($data['resume']['top']['language']['a3']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLanguage'][0]->a3 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a4 ?>%;">
                                            <?php if ($data['resume']['top']['language']['a4']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLanguage'][0]->a4 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a5 ?>%;">
                                            <?php if ($data['resume']['top']['language']['a5']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLanguage'][0]->a5 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a6 ?>%;">
                                            <?php if ($data['resume']['top']['language']['a6']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLanguage'][0]->a6 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart_grade_txt">
                                    <div class="anChartTxt anChartTxtDivision7">TOEIC</div>
                                    <div class="anChartTxt anChartTxtDivision7">TOFEL</div>
                                    <div class="anChartTxt anChartTxtDivision7">TEPS</div>
                                    <div class="anChartTxt anChartTxtDivision7">OPIC</div>
                                    <div class="anChartTxt anChartTxtDivision7">JPT</div>
                                    <div class="anChartTxt anChartTxtDivision7">HSK</div>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph06_3.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab02_3-->

                    <!--s #all_tab02_4-->
                    <div id="all_tab02_4" class="all_tab_content">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox an'>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a1 ?>%;">
                                            <?php if ($data['resume']['top']['toeicscore']['a1']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalToeicscore'][0]->a1 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a2 ?>%;">
                                            <?php if ($data['resume']['top']['toeicscore']['a2']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalToeicscore'][0]->a2 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a3 ?>%;">
                                            <?php if ($data['resume']['top']['toeicscore']['a3']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalToeicscore'][0]->a3 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a4 ?>%;">
                                            <?php if ($data['resume']['top']['toeicscore']['a4']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalToeicscore'][0]->a4 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a5 ?>%;">
                                            <?php if ($data['resume']['top']['toeicscore']['a5']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalToeicscore'][0]->a5 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart_grade_txt">
                                    <div class="anChartTxt">600미만</div>
                                    <div class="anChartTxt">700미만</div>
                                    <div class="anChartTxt">800미만</div>
                                    <div class="anChartTxt">900미만</div>
                                    <div class="anChartTxt">900이상</div>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph06_4.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab02_4-->

                    <!--s #all_tab02_5-->
                    <div id="all_tab02_5" class="all_tab_content">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox an'>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a1 ?>%;">
                                            <?php if ($data['resume']['top']['license']['a1']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLicense'][0]->a1 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a2 ?>%;">
                                            <?php if ($data['resume']['top']['license']['a2']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLicense'][0]->a2 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a3 ?>%;">
                                            <?php if ($data['resume']['top']['license']['a3']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLicense'][0]->a3 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a4 ?>%;">
                                            <?php if ($data['resume']['top']['license']['a4']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLicense'][0]->a4 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a5 ?>%;">
                                            <?php if ($data['resume']['top']['license']['a5']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalLicense'][0]->a5 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart_grade_txt">
                                    <div class="anChartTxt">미보유</div>
                                    <div class="anChartTxt">1개</div>
                                    <div class="anChartTxt">2개</div>
                                    <div class="anChartTxt">3개</div>
                                    <div class="anChartTxt">4개이상</div>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph06_5.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab02_5-->

                    <!--s #all_tab02_6-->
                    <div id="all_tab02_6" class="all_tab_content">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border">
                            <div class="jd_graphBox c mg_t30">
                                <div class='chartBox an'>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a1 ?>%;">
                                            <?php if ($data['resume']['top']['activity']['a1']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalActivity'][0]->a1 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a2 ?>%;">
                                            <?php if ($data['resume']['top']['activity']['a2']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalActivity'][0]->a2 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a3 ?>%;">
                                            <?php if ($data['resume']['top']['activity']['a3']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalActivity'][0]->a3 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a4 ?>%;">
                                            <?php if ($data['resume']['top']['activity']['a4']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalActivity'][0]->a4 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class='chart_bar anChartBar'>
                                        <span class='chartpoint'>
                                            <span></span>
                                        </span>
                                        <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a5 ?>%;">
                                            <?php if ($data['resume']['top']['activity']['a5']) : ?>
                                                <div class="anPerLocation" style="height:<?= $data['resume']['totalActivity'][0]->a5 ?>%;">상위 10%</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart_grade_txt">
                                    <div class="anChartTxt">없음</div>
                                    <div class="anChartTxt">1개</div>
                                    <div class="anChartTxt">2개</div>
                                    <div class="anChartTxt">3개</div>
                                    <div class="anChartTxt">4개이상</div>
                                </div>
                                <!-- <img src="/static/www/img/sub/test_graph06_6.png"> -->
                            </div>
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                    <!--e #all_tab02_6-->
                </div>
                <!--e all_tabsBox-->

            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->
    <?php endif; ?>

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t50">
        <!--s contBox-->
        <div class="contBox">
            <!--s mtltBox-->
            <div class="mtltBox mg_b0 c b">
                <div class="mtlt">A.I. 면접 역량 분석</div>
            </div>
            <!--e mtltBox-->

            <div class="stltBox mg_t30">
                <div class="stlt">
                    면접 종합 점수
                    <span class="toolp_span"><a href="#n" onclick="fnShowPop('all_rep03')">?</a></span>
                </div>
            </div>

            <!--s ai_rpv_txtBox-->
            <div class="ai_rpv_txtBox wBox">
                <div class="jd_graphBox c">
                    <div class="jd_graphBox c mg_t30">
                        <div class='chartBox'>
                            <!-- 적극성 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['aggressiveness'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['aggressiveness'] * 2 ?>%"><?= $data['T']['analysis']['aggressiveness'] * 2 ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['aggressiveness'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['aggressiveness'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['aggressiveness'] * 2 ?></div>
                                </div>
                            </div>
                            <!-- 안정성 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['stability'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['stability'] * 2 ?>%"><?= $data['T']['analysis']['stability'] * 2 ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['stability'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['stability'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['stability'] * 2 ?></div>
                                </div>
                            </div>
                            <!-- 신뢰성 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['reliability'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['reliability'] * 2 ?>%"><?= $data['T']['analysis']['reliability'] * 2 ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['reliability'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['reliability'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['reliability'] * 2 ?></div>
                                </div>
                            </div>
                            <!-- 긍정성 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['affirmative'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['affirmative'] * 2 ?>%"><?= $data['T']['analysis']['affirmative'] * 2 ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['affirmative'] * 2 ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['affirmative'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['affirmative'] * 2 ?></div>
                                </div>
                            </div>
                        </div>
                        <div class='chartLine grayBar'></div>

                        <div class="chart_grade_txt">
                            <div class="resChartTxt">적극성</div>
                            <div class="resChartTxt">안정성</div>
                            <div class="resChartTxt">신뢰성</div>
                            <div class="resChartTxt">긍정성</div>
                        </div>
                    </div>

                    <div class="resChartLabelWrap">
                        <div class="resLabelSq">
                            <div class="resChartLabelSq blue_color"></div>
                            <div>본인 점수</div>
                        </div>

                        <div class="resLabelSq">
                            <div class="resChartLabelSq bluegreen"></div>
                            <div>평균 점수</div>
                        </div>
                    </div>
                    <!-- <img src="/static/www/img/sub/test_graph07_1.png"> -->
                </div>
            </div>
            <!--e ai_rpv_txtBox-->

            <!--s ai_rpv_txtBox-->
            <div class="ai_rpv_txtBox wBox">
                <div class="jd_graphBox c">
                    <div class='chartBox'>
                        <!-- 대응성 -->
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['alacrity'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['alacrity'] * 2 ?>%"><?= $data['T']['analysis']['alacrity'] * 2 ?></div>
                            </div>
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['alacrity'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['alacrity'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['alacrity'] * 2 ?></div>
                            </div>
                        </div>
                        <!-- 의지력 -->
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['willpower'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['willpower'] * 2 ?>%"><?= $data['T']['analysis']['willpower'] * 2 ?></div>
                            </div>
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['willpower'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['willpower'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['willpower'] * 2 ?></div>
                            </div>
                        </div>
                        <!-- 능동성 -->
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['activity'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['activity'] * 2 ?>%"><?= $data['T']['analysis']['activity'] * 2 ?></div>
                            </div>
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['activity'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['activity'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['activity'] * 2 ?></div>
                            </div>
                        </div>
                        <!-- 매력도 -->
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='blue_color bar res_mg_l' style="height:<?= $data['T']['analysis']['attraction'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['T']['analysis']['attraction'] * 2 ?>%"><?= $data['T']['analysis']['attraction'] * 2 ?></div>
                            </div>
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>
                                <span></span>
                            </span>
                            <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgCapacity'][0]['attraction'] * 2 ?>%;">
                                <div class="anPerLocation" style="bottom:<?= $data['avgCapacity'][0]['attraction'] * 2 ?>%;left: 0%;"><?= $data['avgCapacity'][0]['attraction'] * 2 ?></div>
                            </div>
                        </div>
                    </div>
                    <div class='chartLine grayBar'></div>

                    <div class="chart_grade_txt">
                        <div class="resChartTxt">대응성</div>
                        <div class="resChartTxt">의지력</div>
                        <div class="resChartTxt">능동성</div>
                        <div class="resChartTxt">매력도</div>
                    </div>
                    <div class="resChartLabelWrap">
                        <div class="resLabelSq">
                            <div class="resChartLabelSq blue_color"></div>
                            <div>본인 점수</div>
                        </div>

                        <div class="resLabelSq">
                            <div class="resChartLabelSq bluegreen"></div>
                            <div>평균 점수</div>
                        </div>
                    </div>
                    <!-- <img src="/static/www/img/sub/test_graph07_2.png"> -->
                </div>
            </div>
            <!--e ai_rpv_txtBox-->

            <!--s stltBox-->
            <div class="stltBox mg_t50 mg_b25">
                <div class="stlt mg_b10">면접 영상별 점수</div>
                <div class="txt gray">
                    플레이버튼을 누르시면 면접 영상이 재생 됩니다.
                </div>
            </div>
            <!--e stltBox-->

            <!--s all_tabsBox-->
            <div class="all_tabsBox mg_t20">
                <!--s ard_btn-->
                <ul class="all_tabs wd_5">
                    <?php foreach ($data['S'] as $key => $row) : ?>
                        <li class="<?= $key ? "" : "active" ?> video_button" value='<?= $key ?>'><a href="javascript:void(0)">면접 영상 <?= $key + 1 ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <!--e ard_btn-->

                <?php foreach ($data['S'] as $key => $row) : ?>
                    <div id="video<?= $key ?>" class="video_box all_tab_content fast <?= $key ? "hide" : "" ?>">
                        <!--s ai_rpv_txtBox-->
                        <div class="ai_rpv_txtBox wBox no_border pd0">
                            <!--s air_videoBox-->
                            <div class="air_videoBox">
                                <div class="play_btn"><img src="/static/www/img/sub/id_video_play_btn.png"></div>
                                <video class="videoContent" preload="metadata" id="v_pc_3" controls="" src="<?= $data['url']['media'] . $data['videoPath'] . $data['S'][$key]['video'] ?>#t=0.5"></video>
                            </div>
                            <!--e air_videoBox-->
                        </div>
                        <!--e ai_rpv_txtBox-->
                    </div>
                <?php endforeach; ?>
                <!--e all_tabsBox-->

                <div class="ai_rpv_txtBox wBox">
                    <div class="jd_graphBox c">
                        <div id='ana' class="jd_graphBox c mg_t30">
                            <div class='chartBox'>

                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='aggressiveness'></span>
                                    </span>
                                    <div class='blue bar'></div>
                                </div>

                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='stability'></span>
                                    </span>
                                    <div class='sky bar'></div>
                                </div>
                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='reliability'></span>
                                    </span>
                                    <div class='blue bar'></div>
                                </div>

                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='affirmative'></span>
                                    </span>
                                    <div class='sky bar'></div>
                                </div>
                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='alacrity'></span>
                                    </span>
                                    <div class='blue bar'></div>
                                </div>

                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='willpower'></span>
                                    </span>
                                    <div class='sky bar'></div>
                                </div>
                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='activity'></span>
                                    </span>
                                    <div class='blue bar'></div>
                                </div>

                                <div class='chart_bar my'>
                                    <span class='chartpoint'>
                                        <span data-type='attraction'></span>
                                    </span>
                                    <div class='sky bar'></div>
                                </div>

                            </div>
                            <div class='chartLine grayBar'></div>

                            <div class="chart_grade_txt">
                                <div class="resChartTxt rotateChartTxt">적극성</div>
                                <div class="resChartTxt rotateChartTxt">안정성</div>
                                <div class="resChartTxt rotateChartTxt">신뢰성</div>
                                <div class="resChartTxt rotateChartTxt">긍정성</div>
                                <div class="resChartTxt rotateChartTxt">대응성</div>
                                <div class="resChartTxt rotateChartTxt">의지력</div>
                                <div class="resChartTxt rotateChartTxt">능동성</div>
                                <div class="resChartTxt rotateChartTxt">매력도</div>
                            </div>
                        </div>
                        <!-- <img src="/static/www/img/sub/test_graph08.png"> -->
                    </div>
                </div>

                <!--s stltBox-->
                <div class="stltBox mg_t50 mg_b25">
                    <div class="stlt mg_b10">
                        얼굴인식 및 음성 정밀분석
                        <span class="toolp_span"><a href="#n" onclick="fnShowPop('all_rep04')">?</a></span>
                    </div>
                </div>
                <!--e stltBox-->

                <!--s blueBox-->
                <div class="ai_rpv_txtBox blueBox">
                    <div class="stlt b c"><span class="point">BEST 3</span></div>

                    <!--s bwUl-->
                    <div class="bwUl">
                        <ul class="prt_glineUl" id='totalBest'></ul>
                    </div>
                    <!--e bwUl-->
                </div>
                <!--e blueBox-->

                <!--s grayBox-->
                <div class="ai_rpv_txtBox pinkBox">
                    <div class="stlt b c"><span class="point3">WORST 3</span></div>

                    <!--s bwUl-->
                    <div class="bwUl">
                        <ul class="prt_glineUl" id='totalWorst'></ul>
                    </div>
                    <!--e bwUl-->
                </div>
                <!--e grayBox-->

                <!--s stltBox-->
                <div class="stltBox mg_t50 mg_b25">
                    <div class="stlt mg_b10">음성인식 분석</div>
                    <div class="txt gray">
                        지원자의 음성을 분석하여 나타냅니다.
                    </div>
                </div>
                <!--e stltBox-->

                <!--s ai_rpv_txtBox-->
                <div id='hertz_chart_box' class="ai_rpv_txtBox wBox mg_t20">
                    <div class='fail_box'>
                        <div class='msg'>분석 진행 중 입니다. <br>분석완료 후 확인할수 있습니다.</div>
                    </div>
                    <!--s stlt-->
                    <div class="stlt b">음성 높낮이(Hertz)</div>
                    <!--e stlt-->
                    <p class='chart_des'>
                        음성 높낮이는 헤르츠(Hertz)로 나타냅니다.
                        일반적으로 남성은 110-150헤르츠, 여성은 210~250헤르츠가 듣기 좋은 목소리라고 합니다.
                        100헤르츠(Hz)는 성대가 초당 100번 진동한다는 의미인데 주파수가 높을수록 소리가 높아진다는 의미입니다.
                        본인의 음성이 어느 구간에 있는지 관찰해 보세요.
                    </p>
                    <div class="jd_graphBox c mg_t30">
                        <canvas id="hertzChart" width="350" height="240"></canvas>
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s ai_rpv_txtBox-->
                <div id='dB_chart_box' class="ai_rpv_txtBox wBox mg_t20">
                    <div class='fail_box'>
                        <div class='msg'>분석 진행 중 입니다. <br>분석완료 후 확인할수 있습니다.</div>
                    </div>
                    <!--s stlt-->
                    <div class="stlt b">목소리 크기(dB)</div>
                    <!--e stlt-->
                    <p class='chart_des'>
                        목소리 크기는 데시벨(dB)로 나타냅니다. 속삭임음 30데시벨, 일상대화는 60데시벨 정도 입니다. 보통 85데시벨 이상이면 상대방에게
                        불쾌감을 준다고 하니 본인의 목소리 크기를 관찰해 보세요.
                    </p>
                    <div class="jd_graphBox c mg_t30">
                        <canvas id="dBChart" width="350" height="240"></canvas>
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s stltBox-->
                <div class="stltBox mg_t50 mg_b25">
                    <div class="stlt mg_b10">표정 분석</div>
                    <div class="txt gray">
                        지원자와 전체 남/녀 음성을 분석하여 평균을 나타냅니다.
                    </div>
                </div>
                <!--e stltBox-->

                <!--s ai_rpv_txtBox-->
                <div class="ai_rpv_txtBox wBox mg_t20">
                    <div class="jd_graphBox c">
                        <div class='chartBox'>
                            <!-- 자신감 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['facialAnalysis']['confidence'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysis']['confidence'] ?>%"><?= $data['facialAnalysis']['confidence'] ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['facialAnalysisAvg']['confidence'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysisAvg']['confidence'] ?>%;left: 0%;"><?= $data['facialAnalysisAvg']['confidence'] ?></div>
                                </div>
                            </div>
                            <!-- 시선마주침 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['facialAnalysis']['eye_contact'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysis']['eye_contact'] ?>%"><?= $data['facialAnalysis']['eye_contact'] ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['facialAnalysisAvg']['eye_contact'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysisAvg']['eye_contact'] ?>%;left: 0%;"><?= $data['facialAnalysisAvg']['eye_contact'] ?></div>
                                </div>
                            </div>
                            <!-- 안색 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['facialAnalysis']['complexion'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysis']['complexion'] ?>%"><?= $data['facialAnalysis']['complexion'] ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height: <?= $data['facialAnalysisAvg']['complexion'] ?>%;">
                                    <div class="anPerLocation" style="bottom: <?= $data['facialAnalysisAvg']['complexion'] ?>%;left: 0%;"><?= $data['facialAnalysisAvg']['complexion'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class='chartLine grayBar'></div>

                        <div class="chart_grade_txt">
                            <div class="resChartTxt" style="width:33.333%">자신감</div>
                            <div class="resChartTxt" style="width:33.333%">시선마주침</div>
                            <div class="resChartTxt" style="width:33.333%">안색</div>
                        </div>
                        <div class="resChartLabelWrap">
                            <div class="resLabelSq">
                                <div class="resChartLabelSq blue_color"></div>
                                <div>본인 점수</div>
                            </div>

                            <div class="resLabelSq">
                                <div class="resChartLabelSq bluegreen"></div>
                                <div>평균 점수</div>
                            </div>
                        </div>
                        <!-- <img src="/static/www/img/sub/test_graph10_1.png"> -->
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s ai_rpv_txtBox-->
                <div class="ai_rpv_txtBox wBox mg_t20">
                    <div class="jd_graphBox c">
                        <div class='chartBox'>
                            <!-- 태도 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['facialAnalysis']['Attitude'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysis']['Attitude'] ?>%"><?= $data['facialAnalysis']['Attitude'] ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['facialAnalysisAvg']['Attitude'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysisAvg']['Attitude'] ?>%;left: 0%;"><?= $data['facialAnalysisAvg']['Attitude'] ?></div>
                                </div>
                            </div>
                            <!-- 눈깜빡임 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['facialAnalysis']['blinking'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysis']['blinking'] ?>%"><?= $data['facialAnalysis']['blinking'] ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['facialAnalysisAvg']['blinking'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysisAvg']['blinking'] ?>%;left: 0%;"><?= $data['facialAnalysisAvg']['blinking'] ?></div>
                                </div>
                            </div>
                            <!-- 발음정확도 -->
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar res_mg_l' style="height:<?= $data['facialAnalysis']['pronunciation'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysis']['pronunciation'] ?>%"><?= $data['facialAnalysis']['pronunciation'] ?></div>
                                </div>
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar res_mg_r' style="height:<?= $data['facialAnalysisAvg']['pronunciation'] ?>%;">
                                    <div class="anPerLocation" style="bottom:<?= $data['facialAnalysisAvg']['pronunciation'] ?>%;left: 0%;"><?= $data['facialAnalysisAvg']['pronunciation'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class='chartLine grayBar'></div>

                        <div class="chart_grade_txt">
                            <div class="resChartTxt" style="width:33.333%">태도</div>
                            <div class="resChartTxt" style="width:33.333%">눈깜빡임</div>
                            <div class="resChartTxt" style="width:33.333%">발음정확도</div>
                        </div>
                        <div class="resChartLabelWrap">
                            <div class="resLabelSq">
                                <div class="resChartLabelSq blue_color"></div>
                                <div>본인 점수</div>
                            </div>

                            <div class="resLabelSq">
                                <div class="resChartLabelSq bluegreen"></div>
                                <div>평균 점수</div>
                            </div>
                        </div>
                        <!-- <img src="/static/www/img/sub/test_graph10_2.png"> -->
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s stltBox-->
                <div class="stltBox mg_t50">
                    <div class="stlt">
                        면접 영상 STT 분석
                        <span class="toolp_span"><a href="#n" onclick="fnShowPop('all_rep05')">?</a></span>
                    </div>
                </div>
                <!--e stltBox-->

                <!--s ai_rpv_txtBox-->
                <div id='stt_chart_box' class="ai_rpv_txtBox wBox">
                    <div class='fail_box'>
                        <div class='msg'>분석 진행 중 입니다. <br>분석완료 후 확인할수 있습니다.</div>
                    </div>
                    <!--s stlt-->
                    <div class="stlt b">단어분포표</div>
                    <!--e stlt-->

                    <div class="jd_graphBox c mg_t30" style="display: flex;justify-content:center;">
                        <canvas id="sttChart" class="specChartSize"></canvas>
                        <!-- <img src="/static/www/img/sub/test_graph11_1.png" class="wps_70"> -->
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s ai_rpv_txtBox-->
                <div id='word_cloud_box' class="ai_rpv_txtBox wBox mg_t20">
                    <div class='fail_box'>
                        <div class='msg'>분석 진행 중 입니다. <br>분석완료 후 확인할수 있습니다.</div>
                    </div>
                    <!--s stlt-->
                    <div class="stlt b">응답내용 & 핵심어휘(워드 클라우드)</div>
                    <!--e stlt-->

                    <div class="jd_graphBox c mg_t30">
                        <div class="chart-area" style="margin-top:30px;">
                            <div id="container" style="width:100%; height:auto;"></div>
                        </div>

                        <!-- <img src="/static/www/img/sub/test_graph11_2.png" class="wps_70"> -->
                    </div>
                </div>
                <!--e ai_rpv_txtBox-->

                <!--s stltBox-->
                <div class="stltBox mg_t50">
                    <div class="stlt">면접 영상 별 답변리스트</div>
                </div>
                <!--e stltBox-->

                <div class="prt_qna">
                    <div class="prt_qna" id="answer_list"></div>
                </div>
            </div>
            <!--s contBox-->
        </div>
        <!--e gray_bline_first-->
    </div>
    <!--e #scontent-->

    <!-- ------------------------------------------------------------------------------------- -->

    <!--s A.I. 종합결과-->
    <div id="all_rep01" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="stxt black">
                    A.I. 종합결과는 가중치가 적용된 종합점수, 등급 및 A.I. 면접동영상 및 이력서 등을 평가한 결과가 제공됩니다. A.I. 자연어 처리, 어휘 분석을 한 데이터와 응시자의 면접 태도를 안면 분석,음성분석을 한 데이터도 포함됩니다. 이러한 결과는 지원 분야와 전체에서의 등급으로 보여주며, 총 5등급으로 나뉘어집니다. 이러한 등급은 지원자 간의 상대평가에 따른 것입니다
                </div>
                <!--e pop_cont-->

                <div class="spopBtn">
                    <a href="#n" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('all_rep01')">확인</a>
                </div>
            </div>
            <!--e pop_Box-->
        </div>
        <!--e A.I. 종합결과-->
    </div>
    <!--s A.I. 지원자 현황분석-->
    <div id="all_rep02" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="stxt black">
                    동일 직군에 지원한 지원자의 현황을 보여줍니다. 항목별 지원자와 나의 스펙을 비교해 볼 수 있는 지표이며 상위 10%에 해당하는 위치를 표시하여 해당직군에 합격할 수 있도록 참고할 수 있는 지표를 제공합니다.
                </div>
            </div>
            <!--e pop_cont-->

            <div class="spopBtn">
                <a href="#n" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('all_rep02')">확인</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e A.I. 지원자 현황분석-->

    <!--s A.I. 면접 종합점수-->
    <div id="all_rep03" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="stxt black">
                    면접 내용에서 8가지의 성향을 점수화해서 표시를 해줍니다. 8가지의 성향은 면접자의 얼굴 근육 인식을 통해 표정 분석, 눈 떨림, 긴장감, 음성인식 , 음성합성 시스템을 통한 인공지능 알고리즘으로 평가됩니다. 각 항목별 평가가 별도로 구분되어 제공되며 어떤 부분에 자신이 부족한지를 파악하여 대비할 수 있습니다.
                </div>
            </div>
            <!--e pop_cont-->

            <div class="spopBtn">
                <a href="#n" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('all_rep03')">확인</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e A.I. 면접 종합점수-->

    <!--s 얼굴인식 및 음성 정밀분석-->
    <div id="all_rep04" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="stxt black">
                    대화에서 전달하는 메시지의 55%는 얼굴 표정으로 좌우됩니다. A.I. 얼굴인식 알고리즘이 얼굴을 감지하고 미소, 감정, 자세 등 27개의 특징을 정량화해서 분석합니다. 또한 응시 중 시선처리와 움직임을 차트로 시각화해서 보여줍니다.
                </div>
            </div>
            <!--e pop_cont-->

            <div class="spopBtn">
                <a href="#n" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('all_rep04')">확인</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e 얼굴인식 및 음성 정밀분석-->

    <!--s 면접영상STT분석-->
    <div id="all_rep05" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="stxt black">
                    지원자의 답변을 분석하여 사용하는 어휘가 어떤 성향을 가지고 있는지 보여줍니다. 긍정/부정/중립/복합단어 등 총 4개로 구분되어 제시됩니다. 또한, 사용한 어휘 중에서 중복으로 사용하는 어휘가 어느 정도 차지하는지 보여줍니다. 이러한 어휘 분석을 통해 지원자의 어휘 사용 습관, 말의 뉘앙스 등을 알 수 있게 해줍니다.
                </div>
            </div>
            <!--e pop_cont-->

            <div class="spopBtn">
                <a href="#n" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('all_rep05')">확인</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e 면접영상STT분석-->

    <!--s 점수 산출기준 모달-->
    <div id="ai_rpv_synthesis_mb" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont ">
                <div class="tlt mg_b10">점수 기준이 궁금해요</div>
                <div class="txt">하이버프점수는 이렇게 산출되어요</div>

                <div class="stxt">
                    <div>적극성</div>
                    <p>목소리가 크고 제스쳐를 활용하면 점수가 UP</p>

                    <div>안정성</div>
                    <p>당황하지 않고 안정적이게 답변할수록 점수가 UP</p>

                    <div>신뢰성</div>
                    <p>발음이 정확하고 성실하게 답변하면 점수가 UP</p>

                    <div>긍정성</div>
                    <p>밝고 긍정적인 표정을 지으면 점수가 UP</p>

                    <div>대응성</div>
                    <p>질문을 이해하고 성실하게 답변하면 점수가 UP</p>

                    <div>의지력</div>
                    <p>제스처와 함께 성실히 답변할수록 점수가 UP</p>

                    <div>능동성</div>
                    <p>긍정적 표정을 지으며 성실하게 답변할수록 점수가 UP</p>

                    <div>매력도</div>
                    <p>다양한 표정으로 카메라 인식도가 올라가면 점수가 UP</p>
                </div>
            </div>
            <!--e pop_cont-->

            <div class="spopBtn">
                <a href="javascript:void(0)" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('ai_rpv_synthesis_mb')">확인</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e 점수 산출기준 모달-->
</div>

</div>

<!--s syntaxnet tree 모달-->
<div id="ai_syntaxnet_tree" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="tlt mg_b10">Syntaxnet Tree</div>
            <div class="txt">종속성 구분 분석 트리를 통해 문장의 단어 간의 구문 관계를 확인할 수 있습니다.</div>

            <div class="stxt pop_txt">
                <div id="syntaxnet"></div>
            </div>
        </div>
        <!--e pop_cont-->

        <div class="spopBtn">
            <a href="javascript:void(0)" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('ai_syntaxnet_tree')">확인</a>
        </div>
    </div>
    <!--e pop_Box-->
</div>
<!--e syntaxnet tree 모달-->

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- 워드클라우드 개발 할때 밑에 2개 스크립트 우리 js 파일로 저장하기 (기억안나면 대리님한테 물어보기) -->
<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>

<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-bundle.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>

<script>
    let temp = [];
    let aScore = [];
    let aAnalysis = [];
    let aQuestion = [];
    let aSpeech = [];
    let aAudio = [];
    let global_videoindex = 0;
    let aSyntaxnet = [];
    let order = {
        'total': '전체',
        '0': '첫번째',
        '1': '두번째',
        '2': '세번째',
        '3': '네번째',
        '4': '다섯번째',
        '5': '여섯번째',
        '6': '일곱번째',
        '7': '여덟번째',
        '8': '아홉번째',
        '9': '열번째',
    };
    let color = {
        'aggressiveness': '#FB4E40',
        'stability': '#02DFFE',
        'reliability': '#25E2D0',
        'affirmative': '#15E288',
        'alacrity': '#AD83D0',
        'willpower': '#F1C803',
        'activity': '#FE8183',
        'attraction': '#FE8D48',
    };
    let aTitle = {
        'dialect': "방언빈도",
        'quiver': "음성떨림",
        'volume': "음성크기",
        'tone': "목소리톤",
        'speed': "음성속도",
        'diction': "발음 정확도",
        'sincerity': "성실 답변률",
        'understanding': "질문이해도",
        'eyes': "시선처리",
        'smile': "긍정적표정",
        'mouth_motion': "입움직임",
        'blink': "눈 깜빡임",
        'gesture': "제스처빈도",
        'head_motion': "머리 움직임",
        'foreign': "외국어 사용빈도",
        'glow': "홍조현상",
    };

    let aBestText = {
        'dialect': "방언 사용률이 낮습니다.",
        'quiver': "최소한의 떨린 목소리로 인터뷰를 안정되게 진행하였습니다.",
        'volume': "적절한 성량으로 인터뷰를 안정적으로 진행하였습니다.",
        'tone': "일정한 목소리 톤으로 안정적이게 답변하였습니다.",
        'speed': "적절한 속도로 답변하여 인터뷰를 안정적으로 진행하였습니다.",
        'diction': "답변을 알아듣기 쉽게 정확한 발음으로 인터뷰를 진행하였습니다.",
        'sincerity': "답변시간을 충분히 활용하여 인터뷰를 진행하였습니다.",
        'understanding': "어려운 질문에도 머뭇거림 없이 즉각적인 답변을 하였습니다.",
        'eyes': "인터뷰를 진행하는 동안 최소한의 시선 흔들림을 보였습니다.",
        'smile': "밝은 표정으로 인터뷰를 진행하였습니다.",
        'mouth_motion': "입을 크게 움직이며 적극적으로 인터뷰를 진행하였습니다.",
        'blink': "최소한의 눈깜빡임으로 안정적이게 인터뷰를 진행하였습니다.",
        'gesture': "몸을 활발히 사용하여 질문에 적극적으로 답변하였습니다.",
        'head_motion': "최소한으로 머리를 움직이며 안정되게 인터뷰를 진행하였습니다.",
        'foreign': "외국어를 많이 사용하지 않습니다.",
        'glow': "얼굴색의 변화 없이 안정적으로 인터뷰를 진행하였습니다.",
    };

    let aWorstText = {
        'dialect': "방언 사용률이 높습니다.",
        'quiver': "떨리는 목소리로 인터뷰를 진행하여 긴장과 불안정함을 보였습니다.",
        'volume': "너무 크거나 작은 성량으로 인터뷰를 불안정하게 진행하였습니다.",
        'tone': "일정하지 않은 목소리 톤으로 불안정하게 답변하였습니다. ",
        'speed': "너무 빠르거나 느리게 답변하여 인터뷰를 불안정하게 진행하였습니다. ",
        'diction': "답변을 알아듣기 힘들 정도로 발음이 부정확합니다.",
        'sincerity': "답변시간을 충분히 활용하지 못한 채 인터뷰를 진행하였습니다. ",
        'understanding': "답변을 즉시 하지 못하거나 시작하기까지 시간이 소요되었습니다.",
        'eyes': "인터뷰를 진행하는 동안 시선이 불안정하게 흔들렸습니다.",
        'smile': "다소 어두운 표정으로 인터뷰를 진행하였습니다.",
        'mouth_motion': "입을 거의 움직이지 않으며 다소 소극적으로 인터뷰를 진행하였습니다.",
        'blink': "잦은 눈 깜빡임으로 불안정하게 인터뷰를 진행하였습니다. ",
        'gesture': "몸을 거의 움직이지 않고 인터뷰를 진행하였습니다.",
        'head_motion': "머리를 자주 움직여 집중력이 분산되고 다소 불안정해 보입니다.",
        'foreign': "외국어를 너무 많이 사용하셨습니다",
        'glow': "붉은 얼굴색을 띄며 긴장감과 불안정함을 보였습니다.",
    };

    temp = '<?= json_encode($data['T']) ?>';
    temp = JSON.parse(temp);

    aScore['total'] = temp.temp;
    aAnalysis['total'] = temp.analysis;

    temp = '<?= json_encode($data['S']) ?>';
    temp = JSON.parse(temp);

    for (let i = 0, max = temp.length; i < max; i++) {
        aScore[i] = temp[i].score;
        aAnalysis[i] = temp[i].analysis;
        aQuestion[i] = temp[i].question;
        aSpeech[i] = temp[i].speech;
        aAudio[i] = temp[i].audio;
        aSyntaxnet[i] = temp[i].syntaxnet;
    }

    $(document).ready(function() {
        let audioFlag = false;
        let speechFlag = false
        if ('<?= $data['isRes'] ?>' == true) {
            specChart(); //나의스펙차트
        } else {
            $('#serviceReady').removeClass('blindDetailArea');
            $('#serviceReady').addClass('blindDetailNoResArea');

            $('#serviceReadyTxt').removeClass('blindDeatilText');
            $('#serviceReadyTxt').addClass('blindDeatilNoResText');
        }
        hertzChart(); //음성높낮이차트
        dBChart(); //목소리크기차트
        sttChart(); //STT차트
        //wordCloud(); //wordCloud차트
        answerList(); //면접영상별 답변 리스트

        if (arrayIsEmpty2D(aAudio)) {
            $('#hertz_chart_box').children('.fail_box').addClass('on');
            $('#dB_chart_box').children('.fail_box').addClass('on');
        }
        if (arrayIsEmpty2D(aSpeech)) {
            $('#stt_chart_box').children('.fail_box').addClass('on');
            $('#word_cloud_box').children('.fail_box').addClass('on');
        }
    });

    function answerList() {
        for (i in aSpeech) {
            let word = '';
            let answerTxt = '';
            let failChk = '';
            let failMsg = '분석 진행 중 입니다.';
            if (Array.isArray(aSpeech[i])) {
                failMsg = '데이터가 부족하여 분석이 불가합니다.';
            }
            for (j in aSpeech[i]) {
                if (aSpeech[i][j]['type'] != 'punctuation') {
                    word = aSpeech[i][j]['alternatives'][0]['content'];
                    word = decodeUnicode(word);
                    if (Object.keys(aSpeech[i][j]['alternatives'][0]).includes('score') != false && aSpeech[i][j]['alternatives'][0]['score'] != "") {
                        let score = aSpeech[i][j]['alternatives'][0]['score'];
                        if (score > 0) { //total score 가 0보다 크면 긍정단어
                            word = '<span class="highlight-positive">' + word + '</span>';
                        } else if (score == 0) { //0은 중립단어
                            word = '<span class="highlight-neutral">' + word + '</span>';
                        } else if (score < 0) { //0보다 작으면 부정단어
                            word = '<span class="highlight-negative">' + word + '</span>';
                        }
                    }
                    answerTxt = answerTxt + ' ' + word;
                }
            }
            if (temp[i]['queBestAnswer'] == '' || temp[i]['queBestAnswer'] == null) {
                answerData = '';
            } else {
                answerData = '<div style="padding-top: 10px;"><p>모범답안</p><div class="txt" >' + temp[i]['queBestAnswer'] + '.</div></div>';
            }
            if (!answerTxt) {
                failChk = 'on';
            }


            $('#answer_list').append('<dl></div><dt>질문내용 - ' + temp[i]['question'] + '</dt><dd><div class="fail_box ' + failChk + '"><div class="msg">' + failMsg + '</div></div><a href="javascript:" class="btn_syntaxnet" onclick="systaxnet_ck(' + i + '); fnShowPop(\'ai_syntaxnet_tree\')" style="float: right;">Syntaxnet</a><p>답변</p><div class="txt" id="speech${i}">' + answerTxt + '</div>' + answerData + '</dd></dl>');

        }
    }

    function systaxnet_ck(idx) { //syntaxnet chart generate

        anychart.onDocumentReady(function() {
            $('#syntaxnet').empty(); //chart init

            let data = [aSyntaxnet[idx]];
            let syntaxnetChart = anychart.wordtree(data, "as-tree");
            console.log(data);
            let connectors = syntaxnetChart.connectors();
            connectors.curveFactor(0); //연결선의 곡률 지정
            connectors.length(3);
            connectors.offset(0);
            connectors.stroke("0.5 #1976d2");

            syntaxnetChart.container("syntaxnet");
            syntaxnetChart.draw();

            syntaxnetChart.listen('chartDraw', function(e) {
                if (window.innerWidth > 768) { //화면 사이즈에 따라 font size 변경
                    syntaxnetChart.maxFontSize(15);
                } else {
                    syntaxnetChart.maxFontSize(12);
                }
            });
        });
    }

    function sortMethod(aParam) {
        let sortable = [];
        for (let vehicle in aParam) {
            sortable.push([vehicle, aParam[vehicle]]);
        }

        sortable.sort(function(a, b) {
            return b[1] - a[1];
        });

        return sortable;
    }

    function bestAndWorst(aParam) {
        for (let i = 0; i < aParam.length; i++) {
            if (i < 3) {
                aParam[i][1] = aBestText[aParam[i][0]];
                aParam[i][0] = aTitle[aParam[i][0]];
            } else if (i >= aParam.length - 3) {
                aParam[i][1] = aWorstText[aParam[i][0]];
                aParam[i][0] = aTitle[aParam[i][0]];
            } else {
                delete aParam[i];
            }
        }
        return aParam;
    }

    function circleGraph() {
        $('.graph').each(function() {
            const circle = $(this);
            const circleText = circle.children('.circletlt');
            const circlePoint = circleText.text() * 10;
            const thisColor = color[circle.data('type')];
            circleText.css('color', thisColor);
            circle.css('background', 'conic-gradient(' + thisColor + ' 0% ' + circlePoint + '%, #ddd ' + circlePoint + '% 100%');
        });
    }

    function apeendBestAndWorst(type, tlt, txt) {
        $('#total' + type).append('<li><div class="tlt">' + tlt + '</div><div class="txt">' + txt + '</div></li>');
    }

    function videoAction(videoindex) {
        $('#totalBest').empty();
        $('#totalWorst').empty();

        if (videoindex == 'total') {
            setChart($('.jd_graphBox'));
            $('#totalBest').empty();
            $('#totalWorst').empty();
            for (let i = 0; i < aScore[videoindex].length; i++) { // best worst
                if (i < 3) {
                    apeendBestAndWorst('Best', aScore[videoindex][i][0], aScore[videoindex][i][1]);
                } else if (i >= aScore[videoindex].length - 3) {
                    apeendBestAndWorst('Worst', aScore[videoindex][i][0], aScore[videoindex][i][1]);
                }
            }
        } else {
            graph($('#ana'));
            global_videoindex = videoindex;
            $('#question').text(aQuestion[videoindex]);
            $('#speech').empty();
            if (aSpeech[videoindex]) {
                let word = '';
                let startTime = '';
                let endTime = '';
                for (let i = 0; i < aSpeech[videoindex].length; i++) {
                    if (aSpeech[videoindex][i]['type'] != 'punctuation') {
                        word = aSpeech[videoindex][i]['alternatives'][0]['content'];
                        word = decodeUnicode(word);
                        startTime = aSpeech[videoindex][i]['start_time'];
                        endTime = aSpeech[videoindex][i]['end_time'];
                        $('#speech').append('<span class="word_timestamp" data-start=' + startTime + ' data-end=' + endTime + '>' + word + '</span>');
                    }
                }
            } else {
                $('#speech').text('데이터가 없습니다');
            }

            if (aSyntaxnet[videoindex] == '') { //syntaxnet 데이터가 없을 경우에는
                $('.btn_syntaxnet').hide();
            } else {
                $('.btn_syntaxnet').show();
            }
        }

        for (let i = 0, max = $('.videoContent').length; i < max; i++) {
            $('.videoContent').get(i).pause();
        }

        for (let key in aAnalysis[videoindex]) { // 적극성 안정성 신뢰성 긍정성
            if (key == 'sum' || key == 'grade') {
                $('.' + key).text(aAnalysis[videoindex][key]);
            } else {
                $('[data-type=' + key + ']').text(aAnalysis[videoindex][key] * 2);
            }
        }

        circleGraph();

        for (let i = 0; i < aScore[videoindex].length; i++) { // best worst
            if (i < 3) {
                apeendBestAndWorst('Best', aScore[videoindex][i][0], aScore[videoindex][i][1]);
            } else if (i >= aScore[videoindex].length - 3) {
                apeendBestAndWorst('Worst', aScore[videoindex][i][0], aScore[videoindex][i][1]);
            }
        }

        $('.order').text(order[videoindex]);
    }

    $(document).ready(function() {
        aScore['total'] = bestAndWorst(sortMethod(aScore['total']));

        for (let i = 0; i < aScore.length; i++) {
            aScore[i] = bestAndWorst(sortMethod(aScore[i]));
        }
        videoAction('total');
        videoAction(0);

        $('.male > .bar > .inBar').css('width', '<?= $data['T']['score']['gender'][0] ?? 0 ?>%');
        $('.female > .bar > .inBar').css('width', '<?= $data['T']['score']['gender'][1] ?? 0 ?>%');

    });

    $(".video_button").on('click', function() {
        const thisEle = $(this);
        const videoIndex = thisEle.val();
        $('.video_button').removeClass('active');
        thisEle.addClass('active');
        videoAction(videoIndex);
        $('.video_box').hide();
        $("#video" + videoIndex).fadeIn();
    });

    //video time update_pc
    $(".videoContent").on("timeupdate", function(event) {
        if (!$(".videoContent").get(global_videoindex).paused) {
            let current = this.currentTime; //현재 video play time
            $(".word_timestamp").each(function(index, item) {
                let start = parseFloat($(item).attr("data-start"));
                let end = parseFloat($(item).attr("data-end"));
                if (current >= start && current <= end) {
                    $(this).css("color", "red");
                } else {
                    $(this).css("color", "black");
                }
            });
        }
    });

    $(document).on('click', '.word_timestamp', function() {
        let start = parseFloat($(this).attr("data-start"));
        $('.videoContent')[global_videoindex].currentTime = start;
        $(".videoContent").get(global_videoindex).play();

        // $(".playBox_bg").css("display", "none");
        // $("#playVideoBtn").css("display", "none");
    });

    $('.playBtn').on('click', function() {
        let videoPlay = $(this).parents().children('div:eq(1)').children('video');
        videoPlay.get(0).play();
        $(this).parents().children('div:eq(2)').css("display", "none");
        $(this).css("display", "none");
    });

    $('.videoContent').on('click', function() {
        let playbtn = $(this).parents('div:eq(1)').children('div:eq(0)');
        playbtn.css("display", "");
        $(this).get(0).pause();
    })

    function setChart(ele) {
        ele.each(function() { // 전체 지원자, 직종 지원자 차트
            let chartSum = 0;
            $(this).children('.chartBox').children('.chart_bar').each(function() {
                let num = $(this).children('.chartpoint').children('span').text();
                chartSum = chartSum + parseInt(num);
            });
            let persentSum = 0;
            $(this).children('.chartBox').children('.chart_bar').each(function() {
                let num = $(this).children('.chartpoint').children('span').text();
                if (num > 0) {
                    let persent = (parseFloat(num) / chartSum) * 100;
                    persentSum = persentSum + persent;
                    $(this).children('.bar').css('height', persent + '%');

                    if ($(this).hasClass('my')) {
                        $(this).closest('.prt_glineBox').find('.rankPoint').text(parseInt(persentSum));
                    }
                }
            });
        });
    }

    function graph(ele) {
        ele.each(function() { // 전체 지원자, 직종 지원자 차트
            $(this).children('.chartBox').children('.chart_bar').each(function() {
                let num = $(this).children('.chartpoint').children('span').text();
                if (num > 0) {
                    $(this).children('.bar').css('height', num + '%');
                }
            });
        });
    }

    function specChart() {
        const ctx = document.getElementById('specChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['학력', '경력', '어학', '자격증'],
                datasets: [{
                    label: '본인',
                    data: [
                        <?= $data['mySpecScore'][0]['edu'] ?? 0 ?>,
                        <?= $data['mySpecScore'][0]['career'] ?? 0 ?>,
                        <?= $data['mySpecScore'][0]['language'] ?? 0 ?>,
                        <?= $data['mySpecScore'][0]['license'] ?? 0 ?>
                    ],
                    fill: true,
                    backgroundColor: 'rgba(142, 202, 206, 0.2)',
                    borderColor: 'rgb(0, 156, 242)',
                    borderWidth: 1.5,
                }, {
                    label: '지원자 평균',
                    data: [
                        <?= $data['avgSpecScore'][0]['edu'] ?? 0 ?>,
                        <?= $data['avgSpecScore'][0]['career'] ?? 0 ?>,
                        <?= $data['avgSpecScore'][0]['language'] ?? 0 ?>,
                        <?= $data['avgSpecScore'][0]['license'] ?? 0 ?>
                    ],
                    fill: true,
                    backgroundColor: 'rgba(255, 247, 250, 0.2)',
                    borderColor: '#ec6691',
                    borderWidth: 1.5,
                }]
            },
            options: {
                responsive: false,
                indexAxis: 'y',
                scales: {
                    r: {
                        pointLabels: {
                            font: {
                                size: 15,
                                weight: 700
                            }
                        }
                    },
                    ticks: {
                        beginAtZero: true,
                        display: false,
                        max: 100,
                        min: 0,
                        stepSize: 50
                    },
                },
                //plugins: {
                legend: {
                    //  labels: {
                    //     boxWidth: 10,
                    //     boxHeight: 10,
                    //     fontSize: 30,
                    //     fontColor: '#263238',
                    //     font: {
                    //         size: 15,
                    //         weight: 100
                    //     },
                    // },
                    position: 'bottom',
                },
                //},
                elements: {
                    line: {
                        borderWidth: 3
                    },
                    point: {
                        radius: 0,
                    }
                }
            }
        });
    }

    function getAudioDataSet(type) {
        const maxLength = getAudioMaxLength().length;
        let dataSet = [];
        if (type == 'dB') {
            let dream = [];
            for (i = 0; i < maxLength; i++) {
                dream.push(65);
            }

            dataSet.push({
                label: "이상적인 목소리 크기",
                data: dream,
                fill: false,
                borderColor: chartColors[10],
                tension: 0.1,
                borderWidth: 5
            });
        } else if (type = 'hz') {
            let dream = [];
            for (i = 0; i < maxLength; i++) {
                dream.push(130);
            }

            dataSet.push({
                label: "이상적인 남성 목소리",
                data: dream,
                fill: false,
                borderColor: chartColors[11],
                tension: 0.1,
                borderWidth: 5
            });

            dream = [];
            for (i = 0; i < maxLength; i++) {
                dream.push(230);
            }

            dataSet.push({
                label: "이상적인 여성 목소리",
                data: dream,
                fill: false,
                borderColor: chartColors[12],
                tension: 0.1,
                borderWidth: 5
            });
        }

        for (videoNum in aAudio) {
            let a = [];
            for (i = 0; i < maxLength; i++) {
                if (aAudio[videoNum][i]) {
                    a.push(aAudio[videoNum][i][type]);
                } else {
                    a.push(0);
                }

            }
            num = parseInt(videoNum) + 1;
            dataSet.push({
                label: "면접 영상 " + num,
                data: a,
                fill: false,
                borderColor: chartColors[videoNum],
                tension: 0.1,
            });
        }

        return dataSet;
    }

    function getAudioMaxLength() {
        let maxIndex = 0;
        let maxLength = 0;
        let time = [];

        for (videoNum in aAudio) {
            if (aAudio[videoNum].length > maxLength) {
                maxLength = aAudio[videoNum].length;
                maxIndex = videoNum;
            }
        }

        for (i in aAudio[maxIndex]) {
            time.push(aAudio[maxIndex][i]['time']);
        }

        return time;
    }

    function hertzChart() {
        const ctx = document.getElementById('hertzChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: getAudioMaxLength(),
                datasets: getAudioDataSet('hz')
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            stepSize: 20
                        }
                    },
                },
                //plugins: {
                legend: {
                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        fontSize: 11,
                        fontColor: '#263238',
                        font: {
                            size: 10,
                            weight: 700
                        },
                    },
                    position: 'bottom',
                    align: 'end',
                },
                //},
                elements: {
                    line: {
                        borderWidth: 3
                    },
                    point: {
                        radius: 0,
                    }
                }
            }
        });
    }

    function dBChart() {
        const ctx = document.getElementById('dBChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: getAudioMaxLength(),
                datasets: getAudioDataSet('dB')
            },
            options: {
                scales: {
                    y: {
                        max: 120,
                        ticks: {
                            stepSize: 20
                        }
                    },
                },
                //plugins: {
                legend: {
                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        fontSize: 11,
                        fontColor: '#263238',
                        font: {
                            size: 10,
                            weight: 700
                        },
                    },
                    position: 'bottom',
                    align: 'end',
                },
                //},
                elements: {
                    line: {
                        borderWidth: 3
                    },
                    point: {
                        radius: 0,
                    }
                }
            }
        });
    }

    function sttChart() {
        //22.07.03 igg STT text 작업
        //모든 단어를 읽으면서 긍정,부정,복합,중립 단어로 구분하고 key(단어) value(등장횟수)으로 리스트에 저장
        let wordList = {}
        let positiveWord = 0; //긍정단어
        let negativeWord = 0; //부정단어
        let complexWord = 0; //복합단어
        let neutralWord = 0; //중립단어

        // for (i = 0; i < temp.length; i++) {
        //     for (let j = 0; j < aSpeech[i].length; j++) {
        //         words = aSpeech[i][j]['alternatives'][0]['words'];
        //         if (words.length > 1) { //단어 갯수가 1개 초과면 복합단어
        //             complexWord++;
        //         }

        //         for (let z = 0; z < words.length; z++) {
        //             const word = words[z].word;
        //             const pos = words[z].pos;
        //             const score = parseInt(words[z].score);

        //             if (score > 0) { //score가 0보다 크면 긍정단어
        //                 positiveWord++;
        //             } else if (score == 0) { //0이면 중립단어
        //                 neutralWord++;
        //             } else if (score < 0) { //0보다 작으면 부정단어
        //                 negativeWord++;
        //             }

        //             if (pos == 'Noun' || pos == 'Verb' || pos == 'Adjective') { //명사,동사,형용사만 넣기(조사, 구두점 제외)
        //                 if (Object.keys(wordList).includes(word)) { //이미 추가된 단어라면
        //                     wordList[word] = ++wordList[word];
        //                 } else { //처음 추가되는 단어라면
        //                     wordList[word] = 1;
        //                 }
        //             }
        //         }
        //     }
        // }

        for (i in aSpeech) {
            for (j in aSpeech[i]) {

                words = aSpeech[i][j]['alternatives'][0]['words'];
                if (words.length > 1) { //단어 갯수가 1개 초과면 복합단어
                    complexWord++;
                }

                for (let z = 0; z < words.length; z++) {
                    const word = words[z].word;
                    const pos = words[z].pos;
                    const score = parseInt(words[z].score);

                    if (score > 0) { //score가 0보다 크면 긍정단어
                        positiveWord++;
                    } else if (score == 0) { //0이면 중립단어
                        neutralWord++;
                    } else if (score < 0) { //0보다 작으면 부정단어
                        negativeWord++;
                    }

                    if (pos == 'Noun' || pos == 'Verb' || pos == 'Adjective') { //명사,동사,형용사만 넣기(조사, 구두점 제외)
                        if (Object.keys(wordList).includes(word)) { //이미 추가된 단어라면
                            wordList[word] = ++wordList[word];
                        } else { //처음 추가되는 단어라면
                            wordList[word] = 1;
                        }
                    }
                }
            }
        }

        createWordcloud(wordList) //wordCloud 생성

        const ctx = document.getElementById('sttChart').getContext('2d');
        const config = {
            type: 'pie',
            data: {
                labels: ['긍정단어', '복합단어', '중립단어', '부정단어'],
                datasets: [{
                    data: [positiveWord, complexWord, neutralWord, negativeWord],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)'],
                }]
            },
            options: {
                responsive: true,
                //plugins: {
                datalabels: {
                    display: true,
                    formatter: function(val, ctx) {
                        return ctx.chart.data.labels[ctx.dataIndex];
                    },
                    color: '#fff',
                    backgroundColor: '#404040'
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20
                    }
                },
                //}
            },
        };
        const myChart = new Chart(ctx, config);
    }

    function createWordcloud(data) {
        let content = new Array();
        for (key in data) {
            if (key != '하다') {
                content.push({
                    "x": key,
                    "value": data[key]
                })
            }
        }

        anychart.onDocumentReady(function() {
            var chart = anychart.tagCloud(content);
            chart.angles([0]);
            chart.container("container");
            // chart.getCredits().setEnabled(false);
            chart.draw();
        });
    }

    <?php
    //wordCloud 샘플 data
    // var data = [{
    //     "x": "마음",
    //     "value": 1,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 10,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 10,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 10,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 10,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 3,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 3,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 3,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 3,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 1,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 1,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 1,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 1,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 1,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 4,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 4,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 1,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 4,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 4,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 4,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 2,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 2,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 2,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 2,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "마음",
    //     "value": 2,
    //     category: "Sino-Tibetan"
    // },
    // {
    //     "x": "부서",
    //     "value": 2,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "서비스",
    //     "value": 2,
    //     category: "Indo-European"
    // },
    // {
    //     "x": "소통",
    //     "value": 2,
    //     category: "Indo-European"
    // },
    // ];
    ?>
</script>

<style>
    .chart_des {
        margin-bottom: 0.25rem;
    }

    .chartBox>div {
        /* height: 110px !important; */
    }

    .chart_bar>div {
        border-top-right-radius: 8px !important;
        border-top-left-radius: 8px !important;
    }

    .chart_grade_txt {
        display: flex;
        justify-content: end;
        flex-direction: row;
        flex-grow: 1;
        position: relative;
        margin-top: 5px;
    }

    .score_point {
        position: relative;
        background: #D8DAF3;
        border-radius: .4em;
        margin-bottom: 10px;
        margin: 10px;
        font-size: 90%;
        font-weight: bold
    }

    .score_point:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-top-color: #D8DAF3;
        border-bottom: 0;
        margin-left: -8px;
        margin-bottom: -8px;
    }

    .green_color {
        background-color: #CBEBEC !important;
    }

    .blue_color {
        background-color: #525DF5 !important;
    }

    .green_color:after {
        border-top-color: #CBEBEC !important;
    }

    .snsChart {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        margin-top: 20px;
    }

    .snsWidthTxt {
        width: 10%;
    }

    .snsWidthChart {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .snsChartUpDown {
        width: 10%;
    }

    .snsChartLeng {
        width: 80%;
        background-color: #efefef;
        position: relative;
        border-radius: 5px;
    }

    .snsChartPer {
        position: absolute;
        border-radius: 5px;
    }

    .grayTxt {
        color: #999999;
        font-weight: bold;
        width: 10%;
        text-align: center;
    }

    .snsPerTxt {
        position: relative;
        top: -30px;
        left: 95%;
        font-weight: bold;
    }

    .prt_glineBox .tltBox {
        margin-bottom: 20px !important;
    }

    .grayBar {
        background-color: #efefef;
    }

    .res_mg_l {
        margin-left: 40% !important;
    }

    .res_mg_r {
        margin-right: 40% !important;
    }

    .resChartTxt {
        width: 25%;
        font-weight: bold;
    }

    .rotateChartTxt {
        transform: rotate(-11deg);
    }

    .resChartLabelWrap {
        margin-top: 10px;
        display: flex;
        justify-content: space-evenly;
        font-weight: bold;
    }

    .resChartLabelSq {
        width: 10px;
        height: 10px;
        margin-right: 5px;
    }

    .resLabelSq {
        display: flex;
        align-items: center;
    }

    .specChartWrap {
        width: 180px;
        margin-bottom: -80px;
    }

    .anChartTxt {
        width: 20%;
        font-weight: bold;
        /* font-size: px; */
    }

    .anChartBar {
        height: 45px !important;
    }

    .an>div {
        height: 280px !important;
    }

    .anChartBarSize {
        width: 15% !important;
    }

    .anPerLocation {
        position: absolute;
        bottom: 15%;
        right: 25%;
        font-size: 80%;
        font-weight: bold;
    }

    .anChartTxtDivision7 {
        width: 17% !important;
    }

    .anChartBarSizeDivision6 {
        width: 20% !important;
    }

    .anychart-credits {
        display: none !important;
    }

    .specChartSize {
        width: 70%;
    }

    .highlight-positive {
        box-shadow: inset 0 -16px 0 rgb(255, 99, 132);
        color: #fff;
    }

    .highlight-neutral {
        box-shadow: inset 0 -16px 0 rgb(255, 205, 86);
        color: #fff;
    }

    .highlight-negative {
        box-shadow: inset 0 -16px 0 rgb(75, 192, 192);
        color: #fff;
    }

    @media only screen and (max-width:760px) {
        .chartBox>div {
            height: 300px;
        }

        .resChartTxt {
            font-size: 80%;
        }

        .resLabelSq {
            font-size: 80%;
        }

        .anChartTxt {
            font-size: 80%;
        }
    }

    @media only screen and (max-width:480px) {
        .specChartSize {
            width: 60%;
        }

        .mg_t100 {
            margin-top: 30% !important;
        }

        .an>div {
            height: 180px !important;
        }

        .anPerLocation {
            right: 25%;
            font-size: 60%;
        }

        .chartBox>div {
            height: 160px;
        }

        .resChartTxt {
            font-size: 70%;
        }

        .resLabelSq {
            font-size: 70%;
        }

        .anChartTxt {
            font-size: 70%;
        }
    }
</style>