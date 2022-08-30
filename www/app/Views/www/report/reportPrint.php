<!-- 아이콘 폰트 -->
<link rel="stylesheet" href="//maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= $data['url']['menu'] ?>/static/www/css/print.css?ver=<?= strtotime(date('Y-m-d H:i:s')); ?>">

<!--s print_page-->
<div class="print_page print_page01">
    <!--s print_cont-->
    <div class="print_cont">
        <div class="prt_top_btlt c">하이버프 A.I. 종합리포트</div>
        <div class="prt_grayBox_txt c">하이버프 A.I. 종합리포트는 면접자가 응시한 면접 영상 및 등록한 이력서를 기반으로 검증된 A.I. 알고리즘을 통해 분석한 리포트를 제공합니다. </div>

        <!--s prt_profileBox-->
        <div class="prt_profileBox">
            <!-- <div class="imgBox"><img src="/static/www/img/print/no_profile.jpg"></div> -->
            <div class="imgBox" style='height:auto'><img src="<?= $data['url']['media'] ?><?= $data['fileSaveName'] ?? '/static/www/img/sub/prf_no_img.jpg' ?>" style="width: 100%;"></div>
            <!--s prt_profileUl-->
            <ul class="prt_profileUl">
                <li><span class="tlt">이름</span><span class="txt"><?= $data['memName'] ?? '사용자' ?></span></li>
                <li><span class="tlt">검사일시</span><span class="txt"><?= $data['regDate'] ?></span></li>
                <?php if ($data['job']) : ?>
                    <li><span class="tlt">지원분야</span><span class="txt"><?= $data['job'] ? $data['job'] : ''  ?></span></li>
                <?php endif; ?>
            </ul>
            <!--e prt_profileUl-->
        </div>
        <!--e prt_profileBox-->

        <!--s prt_tltBox-->
        <div class="prt_tltBox">
            <div class="tlt">A.I. 종합결과</div>
            <div class="txt">
                A.I. 종합결과는 가중치가 적용된 종합점수, 등급 및 A.I. 면접동영상 및 이력서 등을 평가한 결과가 제공됩니다. A.I. 자연어 처리, 어휘 분석을 한 데이터와 응시자의 면접 태도를 안면 분석,
                음성분석을 한 데이터도 포함됩니다. 이러한 결과는 지원 분야와 전체에서의 등급으로 보여주며, 총 5등급으로 나뉘어집니다. 이러한 등급은 지원자 간의 상대평가에 따른 것입니다
            </div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_ratingBox-->
        <div class="prt_ratingBox">
            <!--s prt_rating_txtBox-->
            <div class="prt_rating_txtBox">
                <div class="tlt">종합등급</div>
                <div class="txt"><?= $data['T']['analysis']['grade'] ?> 등급</div>
            </div>

            <div class="prt_rating_txtBox">
                <div class="tlt">종합점수</div>
                <div class="txt"><?= $data['reportScore'] ?> <span class="small">/100점</span></div>
            </div>

            <div class="prt_rating_txtBox">
                <div class="tlt">응답 신뢰 가능성</div>
                <div class="txt"><?= $data['response'] ?></div>
            </div>
            <!--e prt_rating_txtBox-->
        </div>
        <!--e prt_ratingBox-->

        <?php if ($data['job']) : ?>
            <!--s prt_glineBox_two-->
            <div class="prt_glineBox_two">
                <!--s prt_glineBox-->
                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt"><span class="point"><?= $data['job'] ? '[' . $data['job'] . ']' : ''  ?></span> 지원자중
                            <span class="sp_back sp_back_cl01">
                                상위 <span class="rankPoint">10</span>%
                            </span> 에 위치해요
                        </div>
                    </div>

                    <div class="prt_graph">
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
                        </div>
                        <!-- <img src="/static/www/img/print/test_graph01.png"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <!--s prt_glineBox-->
                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt"><span class="point2">[전체]</span> 지원자중 <span class="sp_back sp_back_cl02">상위 <span class="rankPoint">10</span>%</span> 에 위치해요</div>
                    </div>

                    <div class="prt_graph">
                        <div class="jd_graphBox c mg_t30">
                            <div class='chartBox'>
                                <?php foreach ($data['T']['reportScoreRank']['T'] as $val) : ?>
                                    <?php if ($val['score_rank_grade'] === $data['T']['analysis']['grade']) : ?>
                                        <div class='chart_bar my'>
                                            <span class="score_point green_color">내등급</span>
                                            <span class='chartpoint'>
                                                <span><?= $val['score_rank_count_member'] ?></span>명
                                            </span>
                                            <div class='bluegreen bar'></div>
                                        </div>
                                    <?php else : ?>
                                        <div class='chart_bar'>
                                            <span class='chartpoint'>
                                                <span><?= $val['score_rank_count_member'] ?></span>명
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
                        </div>
                        <!-- <img src="/static/www/img/print/test_graph02.png"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->
            </div>
            <!--e prt_glineBox_two-->
        <?php endif; ?>

        <?php if ($data['mbtiData']) : ?>

            <!--s prt_tltBox-->
            <div class="prt_tltBox mt" style="margin: 30px 15px 10px 15px">
                <div class="tlt">MBTI 직무연관성</div>
                <div class="txt">
                    <?php if ($data['mbtiData']['stat']) : ?>
                        지원자의 MBTI를 분석하여 지원 직무와의 연관도를 나타냅니다.
                    <?php else : ?>
                        <a href='/my/interest/main' class='point'>MBTI를 입력하시면 본 리포트를 확인할 수 있습니다.​</a>
                    <?php endif; ?>
                </div>
            </div>
            <!--e prt_tltBox-->

            <div class='prt_glineBox_two prt_glineBox_mk2 posi_re'>
                <div class='fail_box <?= !$data['mbtiData']['stat'] ? 'on' : '' ?>'></div>
                <!--s prt_glineBox-->
                <div class="prt_glineBox">
                    <div class="tltBox">
                        <!-- <div class="tlt"><span class="tlt_rpd">심리적 성향</span> 우호적, 성실함, 우울함, 외향적, 내향적, 적대적</div> -->
                        <div class="tlt"><span class="tlt_rpd"><?= $data['job'] ? '[' . $data['job'] . ']' : ''  ?> 직무와 MBTI 연관도</span></div>
                    </div>
                    <div class="prt_graph mg_b10">
                        <div>
                            <div class="snsChart">
                                <div class="snsWidthTxt">연관도</div>
                                <div class="snsWidthChart">
                                    <span class="grayTxt">낮음</span>
                                    <div class="snsChartLeng">
                                        <div class="snsChartPer blue_color" style="width: <?= $data['mbtiData']['score']  ?>%;">
                                            <div><span class="snsPerTxt point"><?= $data['mbtiData']['score']  ?>%</span></div>
                                        </div>
                                    </div>
                                    <span class="grayTxt">높음</span>
                                </div>
                            </div>
                        </div>
                        <!-- <img src="/static/www/img/print/test_graph03.png"> -->
                    </div>

                    <div class="txt gray mg_b10"><?= $data['mbtiData']['mbti'] ?>의 <?= $data['mbtiData']['msg'] ?></div>
                    <!--e prt_glineBox-->

                </div>
                <!--s prt_glineBox-->
                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class='tlt'>A.I. 추천 직무</div>
                        <div class='div_list'>
                            <?php foreach ($data['mbtiData']['recommendJob'] as $val) : ?>
                                <div class="txt"><?= $val ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!--e prt_glineBox-->
            </div>
        <?php endif; ?>

        <div class="blindArea hide"></div>
        <div class="blindText hide">서비스 준비중입니다</div>

        <!--s prt_tltBox-->
        <!-- sns 기능개발 완료 후 style="" 지우기 (총 2개) -->
        <div class="prt_tltBox mt hide" style="margin: 30px 15px 10px 15px">
            <div class="tlt">SNS 스코어</div>
            <div class="txt">
                CNN 알고리즘을 중심으로 SNS 사진의 특성과 심리적 성향 간의 관계를 분석합니다
            </div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_glineBox-->
        <div class="prt_glineBox hide" style="margin: 0 15px;">
            <div class="tltBox">
                <!-- <div class="tlt"><span class="tlt_rpd">심리적 성향</span> 우호적, 성실함, 우울함, 외향적, 내향적, 적대적</div> -->
                <div class="tlt"><span class="tlt_rpd">심리적 성향</span> 우호적, 성실함, 외향적</div>
            </div>

            <div class="prt_graph">
                <div>
                    <div class="snsChart">
                        <div class="snsWidthTxt">대인관계</div>
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

                    <div class="snsChart">
                        <div class="snsWidthTxt">자존감</div>
                        <div class="snsWidthChart">
                            <span class="grayTxt">낮음</span>
                            <div class="snsChartLeng">
                                <div class="snsChartPer bluegreen" style="width: 75.2%;">
                                    <div><span class="snsPerTxt point2">75.2%</span></div>
                                </div>
                            </div>
                            <span class="grayTxt">높음</span>
                        </div>
                    </div>
                </div>
                <!-- <img src="/static/www/img/print/test_graph03.png"> -->
            </div>
        </div>
        <!--e prt_glineBox-->


        <!--s prt_tltBox-->
        <!-- <div class="prt_tltBox mt">
            <div class="tlt">직무연관성</div>
            <div class="txt">
                이력서를 기반으로 지원한 직무와의 연관도를 분석하여 결과를 나타내며 A.I. 추천 직무도 함께 제공됩니다.
            </div>
        </div> -->
        <!--e prt_tltBox-->

        <!--s prt_glineBox-->
        <!-- <div class="prt_glineBox prt_glineBox_two">
            <div class="prt_glineBox_cont prt_glineBox_cont01">
                <div class="tltBox">
                    <div class="tlt">[<? //= $data['job'] ? $data['job'] : ''  
                                        ?>] 직무와의 연관도</div>
                    <div class="txt">각 직무와 관련되는 학과, 활동내역, 자격증, 어학능력 등을 분석하여 지원한 직군과의 연관도를 나타냅니다. </div>
                </div>

                <div class="prt_graph">
                    <div class="snsWidthChart">
                        <span class="grayTxt">낮음</span>
                        <div class="snsChartLeng" style="width: 85%;">
                            <div class="snsChartPer blue_color" style="width: 81%;">
                                <div><span class="snsPerTxt point">81%</span></div>
                            </div>
                        </div>
                        <span class="grayTxt">높음</span>
                    </div>
                </div>
            </div>

            <div class="prt_glineBox_cont prt_glineBox_cont02">
                <div class="tltBox mbm">
                    <div class="tlt">A.I. 추천 직무 </div>
                </div>

                <ul class="bul01 txt">
                    <li>마케팅</li>
                    <li>광고분석</li>
                    <li>리서치, 통계, 조사분석</li>
                </ul>
            </div>
        </div> -->
        <!--e prt_glineBox-->
    </div>
    <!--e print_cont-->
</div>
<!--e print_page-->

<?php if ($data['isRes'] == true) : ?>
    <!--s print_page-->
    <div class="print_page print_page02 mt10">
        <!--s print_cont-->
        <div class="print_cont">
            <div class="prt_top_btlt c">A.I. 이력서 리포트</div>
            <div class="prt_grayBox_txt c">지원자의 이력서를 바탕으로 검증된 A.I. 알고리즘으로 분석하여 동일 지원 분야의 지원자 대비 등급과 점수를 나타냅니다.</div>

            <!--s prt_ratingBox-->
            <div class="prt_ratingBox">
                <!--s prt_rating_txtBox-->
                <div class="prt_rating_txtBox">
                    <div class="tlt">종합등급</div>
                    <div class="txt"><?= $data['resume']['atotal'][0]['rank'] ?> 등급</div>
                </div>

                <div class="prt_rating_txtBox">
                    <div class="tlt">종합점수</div>
                    <div class="txt"><?= $data['resumeScore'] ?> <span class="small">/100점</span></div>
                </div>
                <!--e prt_rating_txtBox-->
            </div>
            <!--e prt_ratingBox-->

            <!--s prt_glineBox_two40-->
            <div class="prt_glineBox_two prt_glineBox_two40">
                <!--s prt_glineBox-->
                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt"><span class="point">[<?= $data['job'] ? $data['job'] : ''  ?>]</span> 지원자중 <span class="sp_back sp_back_cl01">상위 10%</span> 에 위치해요</div>
                    </div>

                    <div class="prt_graph">
                        <div class="jd_graphBox c mg_t30">
                            <div class='resumeChartBox'>
                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['edu'] ?>%;"></div>
                                </div>
                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['edu'] ?>%;"></div>
                                </div>

                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['career'] ?>%;"></div>
                                </div>
                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['career'] ?>%;"></div>
                                </div>

                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['language'] ?>%;"></div>
                                </div>
                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='bluegreen bar res_mg_r' style="height:<?= $data['avgSpecScore'][0]['language'] ?>%;"></div>
                                </div>

                                <div class='chart_bar resumeChartBar'>
                                    <span class='chartpoint'>
                                        <span></span>
                                    </span>
                                    <div class='blue_color bar res_mg_l' style="height:<?= $data['mySpecScore'][0]['license'] ?>%;"></div>
                                </div>
                                <div class='chart_bar resumeChartBar'>
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

                        <!-- <img src="/static/www/img/print/test_graph05.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <!--s prt_tableBox-->
                <div class="prt_tableBox">
                    <div class="tlt">이력서 항목별 평가</div>
                    <table class="c wps_100">
                        <colgroup>
                            <col class="wps_20">
                            <col class="wps_80">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>구 분</th>
                                <th>내 용</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>학력</td>
                                <td class="l">
                                    <?= $data['resume']['text'][0]['edu'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>경력</td>
                                <td class="l">
                                    <?= $data['resume']['text'][0]['career'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>어학</td>
                                <td class="l">
                                    <?= $data['resume']['text'][0]['language'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>자격증</td>
                                <td class="l">
                                    <?= $data['resume']['text'][0]['license'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--e prt_tableBox-->
            </div>
            <!--e prt_glineBox_two40-->

            <!--s prt_tltBox-->
            <div class="prt_tltBox mt">
                <div class="tlt">나의 스펙</div>
                <div class="txt">
                    스펙 점수가 평균보다 낮다면, A.I. 면접을 통해 어필해 보세요.
                </div>
            </div>
            <!--e prt_tltBox-->

            <!--s prt_glineBox-->
            <div class="prt_glineBox overflow">
                <div class="spac_graph">
                    <canvas id="specChart" width="180" height="180" class="specChartWrap"></canvas>
                    <!-- <img src="/static/www/img/print/test_graph06.png"> -->
                </div>

                <!--s prt_tableBox-->
                <div class="prt_tableBox">
                    <table class="c wps_100">
                        <colgroup>
                            <col class="wps_30">
                            <col class="wps_35">
                            <col class="wps_35">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>구 분</th>
                                <th>본인 점수</th>
                                <th>평균 점수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>학력</td>
                                <td><?= $data['mySpecScore'][0]['edu'] ?></td>
                                <td><?= $data['avgSpecScore'][0]['edu'] ?></td>
                            </tr>
                            <tr>
                                <td>경력</td>
                                <td><?= $data['mySpecScore'][0]['career'] ?></td>
                                <td><?= $data['avgSpecScore'][0]['career'] ?></td>
                            </tr>
                            <tr>
                                <td>어학</td>
                                <td><?= $data['mySpecScore'][0]['language'] ?></td>
                                <td><?= $data['avgSpecScore'][0]['language'] ?></td>
                            </tr>
                            <tr>
                                <td>자격증</td>
                                <td><?= $data['mySpecScore'][0]['license'] ?></td>
                                <td><?= $data['avgSpecScore'][0]['license'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--e prt_tableBox-->
            </div>
            <!--e prt_glineBox-->

            <!--s prt_tltBox-->
            <div class="prt_tltBox mt">
                <div class="overflow">
                    <div class="tlt fl"><span class="b">지원자 현황 분석</span> ㅣ 지원자 수 <span class="point"><?= $data['resume']['total'] ?>명</span></div>
                    <div class="txt fr">2022.06.30기준 </div>
                </div>
                <div class="txt">
                    동일 직군에 지원한 지원자의 현황을 보여줍니다. 항목별 지원자와 나의 스펙을 비교해 볼 수 있는 지표이며 상위 10%에 해당하는 위치를 표시하여 해당직군에 합격할 수 있도록 참고할 수
                    있는 지표를 제공합니다.
                </div>
            </div>
            <!--e prt_tltBox-->

            <!--s prt_gline_six-->
            <div class="prt_gline_six c overflow">
                <!--s prt_glineBox-->
                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt">학력별 현황</div>
                    </div>

                    <div class="prt_graph">
                        <div class='chartBox an'>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a1 ?>%;">
                                    <?php if ($data['resume']['top']['edu']['a1']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a2 ?>%;">
                                    <?php if ($data['resume']['top']['edu']['a2']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a3 ?>%;">
                                    <?php if ($data['resume']['top']['edu']['a3']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a4 ?>%;">
                                    <?php if ($data['resume']['top']['edu']['a4']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalEdu'][0]->a5 ?>%;">
                                    <?php if ($data['resume']['top']['edu']['a5']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
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
                        <!-- <img src="/static/www/img/print/test_graph07_1.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt">경력별 현황</div>
                    </div>

                    <div class="prt_graph">
                        <div class='chartBox an'>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a1 ?>%;">
                                    <?php if ($data['resume']['top']['career']['a1']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a2 ?>%;">
                                    <?php if ($data['resume']['top']['career']['a2']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a3 ?>%;">
                                    <?php if ($data['resume']['top']['career']['a3']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a4 ?>%;">
                                    <?php if ($data['resume']['top']['career']['a4']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalCareer'][0]->a5 ?>%;">
                                    <?php if ($data['resume']['top']['career']['a5']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
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
                        <!-- <img src="/static/www/img/print/test_graph07_2.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt">외국어 현황</div>
                    </div>

                    <div class="prt_graph">
                        <div class='chartBox an'>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a1 ?>%;">
                                    <?php if ($data['resume']['top']['language']['a1']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a2 ?>%;">
                                    <?php if ($data['resume']['top']['language']['a2']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a3 ?>%;">
                                    <?php if ($data['resume']['top']['language']['a3']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a4 ?>%;">
                                    <?php if ($data['resume']['top']['language']['a4']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a5 ?>%;">
                                    <?php if ($data['resume']['top']['language']['a5']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSizeDivision6' style="height:<?= $data['resume']['totalLanguage'][0]->a6 ?>%;">
                                    <?php if ($data['resume']['top']['language']['a6']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>

                        <div class="chart_grade_txt">
                            <div class="anChartTxt anChartTxtDivision6">TOEIC</div>
                            <div class="anChartTxt anChartTxtDivision6">TOFEL</div>
                            <div class="anChartTxt anChartTxtDivision6">TEPS</div>
                            <div class="anChartTxt anChartTxtDivision6">OPIC</div>
                            <div class="anChartTxt anChartTxtDivision6">JPT</div>
                            <div class="anChartTxt anChartTxtDivision6">HSK</div>
                        </div>
                        <!-- <img src="/static/www/img/print/test_graph07_3.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt">TOEIC점수 현황</div>
                    </div>

                    <div class="prt_graph">
                        <div class='chartBox an'>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a1 ?>%;">
                                    <?php if ($data['resume']['top']['toeicscore']['a1']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a2 ?>%;">
                                    <?php if ($data['resume']['top']['toeicscore']['a2']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a3 ?>%;">
                                    <?php if ($data['resume']['top']['toeicscore']['a3']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a4 ?>%;">
                                    <?php if ($data['resume']['top']['toeicscore']['a4']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalToeicscore'][0]->a5 ?>%;">
                                    <?php if ($data['resume']['top']['toeicscore']['a5']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
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
                        <!-- <img src="/static/www/img/print/test_graph07_4.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt">자격증 개수</div>
                    </div>

                    <div class="prt_graph">
                        <div class='chartBox an'>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a1 ?>%;">
                                    <?php if ($data['resume']['top']['license']['a1']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a2 ?>%;">
                                    <?php if ($data['resume']['top']['license']['a2']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a3 ?>%;">
                                    <?php if ($data['resume']['top']['license']['a3']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a4 ?>%;">
                                    <?php if ($data['resume']['top']['license']['a4']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalLicense'][0]->a5 ?>%;">
                                    <?php if ($data['resume']['top']['license']['a5']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
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
                        <!-- <img src="/static/www/img/print/test_graph07_5.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->

                <div class="prt_glineBox">
                    <div class="tltBox">
                        <div class="tlt">활동 지수</div>
                    </div>

                    <div class="prt_graph">
                        <div class='chartBox an'>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a1 ?>%;">
                                    <?php if ($data['resume']['top']['activity']['a1']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a2 ?>%;">
                                    <?php if ($data['resume']['top']['activity']['a2']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a3 ?>%;">
                                    <?php if ($data['resume']['top']['activity']['a3']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='bluegreen bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a4 ?>%;">
                                    <?php if ($data['resume']['top']['activity']['a4']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class='chart_bar anChartBar'>
                                <span class='chartpoint'>
                                    <span></span>
                                </span>
                                <div class='blue_color bar anChartBarSize' style="height:<?= $data['resume']['totalActivity'][0]->a5 ?>%;">
                                    <?php if ($data['resume']['top']['activity']['a5']) : ?>
                                        <div class="anPerLocation">상위 10%</div>
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
                        <!-- <img src="/static/www/img/print/test_graph07_6.png" class="c"> -->
                    </div>
                </div>
                <!--e prt_glineBox-->
            </div>
            <!--e prt_gline_six-->
        </div>
        <!--e print_cont-->
    </div>
    <!--e print_page-->
<?php endif; ?>

<!--s print_page-->
<div class="print_page print_page03 mt10">
    <!--s print_cont-->
    <div class="print_cont">
        <!--s qrBox-->
        <div class="qrBox">
            <div class="img">
                <!-- <img src="/static/www/img/print/prt_qr.png"> -->
                <!-- <img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl=https%3A%2F%2Finterview.highbuff.com%2F&choe=UTF-8" title="Link to Google.com" /> -->
                <img src="https://chart.googleapis.com/chart?cht=qr&chs=70x70&chl=https://interview.highbuff.com/report/detail2/<?= $data['enAppIdx'] ?>" />
            </div>
            <p>면접 동영상 보기</p>
        </div>
        <!--e qrBox-->

        <div class="prt_top_btlt c">A.I. 면접 역량 분석</div>

        <!--s prt_tltBox-->
        <div class="prt_tltBox mt45">
            <div class="tlt">면접 종합 점수</div>
            <div class="txt">
                면접 내용에서 8가지의 성향을 점수화해서 표시를 해줍니다. 8가지의 성향은 면접자의 얼굴 근육 인식을 통해 표정 분석, 눈 떨림, 긴장감, 음성인식 , 음성합성 시스템을 통한 인공지능
                알고리즘으로 평가됩니다. 각 항목별 평가가 별도로 구분되어 제공되며 어떤 부분에 자신이 부족한지를 파악하여 대비할 수 있습니다.
            </div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_glineBox_two-->
        <div class="prt_glineBox_two prt_glineBox_two40">
            <!--s prt_videoBox-->
            <div class="prt_videoBox">
                <div class="play_btn"><img src="/static/www/img/print/play_btn.png"></div>
                <!-- <video class="videoContent" preload="metadata" id="v_pc_3" controls="" src="https://media.highbuff.com/data/uploads/5524-record_01-1-1630388117.mp4#t=0.001"></video> -->
                <video class="videoContent" preload="metadata" id="v_pc_3" controls="" src="<?= $data['url']['media'] . $data['videoPath'] . $data['S'][0]['video'] ?>"></video>
            </div>
            <!--e prt_videoBox-->

            <!--s prt_tableBox-->
            <div class="prt_tableBox">
                <table class="c wps_100">
                    <colgroup>
                        <col class="wps_30">
                        <col class="wps_30">
                        <col class="wps_30">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>구 분</th>
                            <th>본인 점수</th>
                            <th>평균 점수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>적극성 (initiative)</td>
                            <td><?= $data['T']['analysis']['aggressiveness'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['aggressiveness'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>안정성 (stability)</td>
                            <td><?= $data['T']['analysis']['stability'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['stability'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>신뢰성 (reliability)</td>
                            <td><?= $data['T']['analysis']['reliability'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['reliability'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>긍정성 (positivity)</td>
                            <td><?= $data['T']['analysis']['affirmative'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['affirmative'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>대응성 (responsiveness)</td>
                            <td><?= $data['T']['analysis']['alacrity'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['alacrity'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>의지력 (willpower)</td>
                            <td><?= $data['T']['analysis']['willpower'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['willpower'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>능동성 (activity)</td>
                            <td><?= $data['T']['analysis']['activity'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['activity'] * 2 ?></td>
                        </tr>
                        <tr>
                            <td>매력도 (attractiveness)</td>
                            <td><?= $data['T']['analysis']['attraction'] * 2 ?></td>
                            <td><?= $data['avgCapacity'][0]['attraction'] * 2 ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--e prt_tableBox-->
        </div>
        <!--e prt_glineBox_two-->

        <div class="prt_graph mt20">
            <!-- <img src="/static/www/img/print/test_graph08.png" class="c"> -->
            <canvas id="abilityChart" width="400" height="160"></canvas>
        </div>

        <!--s prt_tltBox-->
        <div class="prt_tltBox mt">
            <div class="tlt">면접 세부 점수</div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_tableBox-->
        <div class="prt_tableBox">
            <table class="c wps_100">
                <colgroup>
                    <col class="wps_20">
                    <col class="wps_16">
                    <col class="wps_16">
                    <col class="wps_16">
                    <col class="wps_16">
                    <col class="wps_16">
                </colgroup>
                <thead>
                    <tr>
                        <th>구 분</th>
                        <th>면접 영상 1</th>
                        <th>면접 영상 2</th>
                        <th>면접 영상 3</th>
                        <th>면접 영상 4</th>
                        <th>면접 영상 5</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>적극성 (initiative)</td>
                        <?php foreach ($data['S'] as $initKey => $initVal) : ?>
                            <td><?= $data['S'][$initKey]['analysis']['aggressiveness'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>안정성 (stability)</td>
                        <?php foreach ($data['S'] as $stabKey => $stabVal) : ?>
                            <td><?= $data['S'][$stabKey]['analysis']['stability'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>신뢰성 (reliability)</td>
                        <?php foreach ($data['S'] as $reliKey => $reliVal) : ?>
                            <td><?= $data['S'][$reliKey]['analysis']['reliability'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>긍정성 (positivity)</td>
                        <?php foreach ($data['S'] as $affKey => $affVal) : ?>
                            <td><?= $data['S'][$affKey]['analysis']['affirmative'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>대응성 (responsiveness)</td>
                        <?php foreach ($data['S'] as $alacKey => $alacVal) : ?>
                            <td><?= $data['S'][$alacKey]['analysis']['alacrity'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>의지력 (willpower)</td>
                        <?php foreach ($data['S'] as $willKey => $willVal) : ?>
                            <td><?= $data['S'][$willKey]['analysis']['willpower'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>능동성 (activity)</td>
                        <?php foreach ($data['S'] as $actKey => $actVal) : ?>
                            <td><?= $data['S'][$actKey]['analysis']['activity'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>매력도 (attractiveness)</td>
                        <?php foreach ($data['S'] as $attrKey => $attrVal) : ?>
                            <td><?= $data['S'][$attrKey]['analysis']['attraction'] * 2 ?></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--e prt_tableBox-->

    </div>
    <!--e print_cont-->
</div>
<!--e print_page-->

<!--s print_page-->
<div class="print_page print_page04 mt10">
    <!--s print_cont-->
    <div class="print_cont">
        <!--s prt_tltBox-->
        <div class="prt_tltBox">
            <div class="tlt">얼굴인식 및 음성 정밀분석</div>
            <div class="txt">
                대화에서 전달하는 메시지의 55%는 얼굴 표정으로 좌우됩니다. A.I. 얼굴인식 알고리즘이 얼굴을 감지하고 미소, 감정, 자세 등 27개의 특징을 정량화해서 분석합니다.
                또한 응시 중 시선처리와 움직임을 차트로 시각화해서 보여줍니다.
            </div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_glineBox_two-->
        <div class="prt_glineBox_two">
            <!--s prt_glineBox-->
            <div class="prt_glineBox bule_line">
                <div class="prt_gline_tlt c">전체 <span class="point">BEST 3</span></div>

                <!--s prt_glineUl-->
                <ul class="prt_glineUl" id='totalBest'></ul>
                <!--e prt_glineUl-->
            </div>
            <!--e prt_glineBox-->

            <!--s prt_glineBox-->
            <div class="prt_glineBox pink_line">
                <div class="prt_gline_tlt c">전체 <span class="point3">WORST 3</span></div>

                <!--s prt_glineUl-->
                <ul class="prt_glineUl" id='totalWorst'></ul>
                <!--e prt_glineUl-->
            </div>
            <!--e prt_glineBox-->
        </div>
        <!--e prt_glineBox_two-->

        <!--s prt_tltBox-->
        <div class="prt_tltBox mt">
            <div class="tlt">음성인식 분석</div>
            <div class="txt">
                지원자의 음성을 분석하여 나타냅니다.
            </div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_graph_two-->
        <div id='audio_chart_box' class="prt_graph_two posi_re">
            <div class='fail_box'>
                <div class='msg'>분석 진행 중 입니다. <br>분석완료 후 확인할수 있습니다.</div>
            </div>
            <div class="prt_graphBox">
                <div class="tlt">음성 높낮이(Hertz)</div>
                <p class='chart_des'>
                    음성 높낮이는 헤르츠(Hertz)로 나타냅니다.
                    일반적으로 남성은 110-150헤르츠, 여성은 210~250헤르츠가 듣기 좋은 목소리라고 합니다.
                    100헤르츠(Hz)는 성대가 초당 100번 진동한다는 의미인데 주파수가 높을수록 소리가 높아진다는 의미입니다.
                    본인의 음성이 어느 구간에 있는지 관찰해 보세요.
                </p>
                <div class="prt_graph">
                    <canvas id="hertzChart" width="350" height="240"></canvas>
                </div>
            </div>
            <div class="prt_graphBox">
                <div class="tlt">목소리 크기(dB)</div>
                <p class='chart_des'>
                    목소리 크기는 데시벨(dB)로 나타냅니다. 속삭임음 30데시벨, 일상대화는 60데시벨 정도 입니다. 보통 85데시벨 이상이면 상대방에게
                    불쾌감을 준다고 하니 본인의 목소리 크기를 관찰해 보세요.
                </p>
                <div class="prt_graph">
                    <canvas id="dBChart" width="350" height="240"></canvas>
                </div>
            </div>
        </div>
        <!--e prt_graph_two-->

        <!--s prt_tltBox-->
        <div class="prt_tltBox mt">
            <div class="tlt">표정 분석</div>
            <div class="txt">
                지원자와 전체 지원자의 표정을 분석하여 항목으로 나타냅니다
            </div>
        </div>
        <!--e prt_tltBox-->

        <div class="prt_graph">
            <canvas id="expressionChart" width="480" height="160"></canvas>

            <!-- <img src="/static/www/img/print/test_graph10.png" class="c"> -->
        </div>
    </div>
    <!--e print_cont-->
</div>
<!--e print_page-->

<!--s print_page-->
<div class="print_page print_page05 mt10">
    <!--s print_cont-->
    <div class="print_cont">
        <!--s prt_tltBox-->
        <div class="prt_tltBox">
            <div class="tlt">면접 영상 STT 분석</div>
            <div class="txt">
                지원자의 답변을 분석하여 사용하는 어휘가 어떤 성향을 가지고 있는지 보여줍니다. 긍정/부정/중립/복합단어 등 총 4개로 구분되어 제시됩니다.
                또한, 사용한 어휘 중에서 중복으로 사용하는 어휘가 어느 정도 차지하는지 보여줍니다. 이러한 어휘 분석을 통해 지원자의 어휘 사용 습관, 말의 뉘앙스 등을 알 수 있게 해줍니다.
            </div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_glineBox-->
        <div id='speech_chart_box' class="prt_glineBox c posi_re">
            <div class='fail_box'>
                <div class='msg'>분석 진행 중 입니다. <br>분석완료 후 확인할수 있습니다.</div>
            </div>
            <!--s sttBox-->
            <div class="sttBox">
                <div class="tlt">단어분포표</div>

                <div class="prt_graph">
                    <canvas id="sttChart" width="180" height="180"></canvas>
                    <!-- <img src="/static/www/img/print/test_graph11.png" class="c"> -->
                </div>
            </div>
            <!--e sttBox-->

            <!--s sttBox-->
            <div class="sttBox">
                <div class="tlt">응답내용 & 핵심어휘(워드 클라우드)</div>

                <div class="prt_graph">
                    <div class="chart-area" style="margin-top:30px;">
                        <div id="container" style="width:120%; height:auto;"></div>
                    </div>

                    <!-- <img src="/static/www/img/print/test_graph12.png" class="c"> -->
                </div>
            </div>
            <!--e sttBox-->
        </div>
        <!--e prt_glineBox-->

        <!--s prt_tltBox-->
        <div class="prt_tltBox mt">
            <div class="tlt">면접 영상 별 답변리스트</div>
        </div>
        <!--e prt_tltBox-->

        <!--s prt_qna-->
        <div class="prt_qna" id="answer_list"></div>
        <!--e prt_qna-->
    </div>
    <!--e print_cont-->
</div>
<!--e print_page-->

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- 워드클라우드 개발 할때 밑에 2개 스크립트 우리 js 파일로 저장하기 (기억안나면 대리님한테 물어보기) -->
<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
<!-- <script src="https://cdn.anychart.com/releases/7.0.0/js/anychart-base.min.js" type="text/javascript"></script> -->
<!-- <script src="https://cdn.anychart.com/releases/7.0.0/js/anychart-tag-cloud.min.js" type="text/javascript"></script> -->

<script>
    let temp = [];
    let aScore = [];
    let aAnalysis = [];
    let aQuestion = [];
    let aSpeech = [];
    let aAudio = [];
    let global_videoindex = 0;
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

    for (let i = 0; i < temp.length; i++) {
        aScore[i] = temp[i].score;
        aAnalysis[i] = temp[i].analysis;
        aQuestion[i] = temp[i].question;
        aSpeech[i] = temp[i].speech;
        aAudio[i] = temp[i].audio;
    }

    $(document).ready(function() {
        if ('<?= $data['isRes'] ?>' == true) {
            specChart(); //나의스펙차트
        }
        abilityChart(); //면접역랸분석차트   
        hertzChart(); //음성높낮이차트
        dBChart(); //목소리크기차트
        expressionChart(); //표정분석차트
        sttChart(); //STT차트
        // wordCloud(); //wordCloud차트
        answerList(); //면접영상별 답변 리스트

        if (arrayIsEmpty2D(aAudio)) {
            $('#audio_chart_box').children('.fail_box').addClass('on');
        }
        if (arrayIsEmpty2D(aSpeech)) {
            $('#speech_chart_box').children('.fail_box').addClass('on');
        }

        aScore['total'] = bestAndWorst(sortMethod(aScore['total']));

        for (let i = 0; i < aScore.length; i++) {
            aScore[i] = bestAndWorst(sortMethod(aScore[i]));
        }
        videoAction('total');

        $('.jd_graphBox').each(function() { // 전체 지원자, 직종 지원자 차트
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

        $('.male > .bar > .inBar').css('width', '<?= $data['T']['score']['gender'][0] ?? 0 ?>%');
        $('.female > .bar > .inBar').css('width', '<?= $data['T']['score']['gender'][1] ?? 0 ?>%');

        $('.id_video_sl').on('afterChange', function() {
            videoAction($(this).find('.slick-active').data('videoindex'));
        });

        $('.depth2 > li').on('click', function() {
            $('.depth2 > li').removeClass('on');
            $(this).addClass('on');
            let type = $(this).attr('id');
            if (type == 'total') {
                videoAction('total');
                $('.totalBox').show();
                $('.id_videoBox').hide();
            } else if (type == 'answer') {
                videoAction(global_videoindex);
                $('.totalBox').hide();
                $('.id_videoBox').show();
            }
        })

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
    });

    function answerList() {
        // for (i = 0; i < temp.length; i++) {
        //     let word = '';
        //     let answerTxt = '';

        //     for (let j = 0; j < aSpeech[i].length; j++) {
        //         if (aSpeech[i][j]['type'] != 'punctuation') {
        //             word = aSpeech[i][j]['alternatives'][0]['content'];
        //             word = decodeUnicode(word);
        //             if (Object.keys(aSpeech[i][j]['alternatives'][0]).includes('score') != false && aSpeech[i][j]['alternatives'][0]['score'] != "") {
        //                 let score = aSpeech[i][j]['alternatives'][0]['score'];
        //                 if (score > 0) { //total score 가 0보다 크면 긍정단어
        //                     word = '<span class="highlight-positive">' + word + '</span>';
        //                 } else if (score == 0) { //0은 중립단어
        //                     word = '<span class="highlight-neutral">' + word + '</span>';
        //                 } else if (score < 0) { //0보다 작으면 부정단어
        //                     word = '<span class="highlight-negative">' + word + '</span>';
        //                 }
        //             }
        //             answerTxt = answerTxt + ' ' + word;
        //         }
        //     }

        //     if (temp[i]['queBestAnswer'] == '' || temp[i]['queBestAnswer'] == null) {
        //         answerData = '';
        //     } else {
        //         answerData = '<div style="padding-top: 10px;"><p>모범답안</p><div class="txt" >' + temp[i]['queBestAnswer'] + '.</div></div>';
        //     }
        //     const failChk = !answerTxt ? 'on' : '';
        //     $('#answer_list').append('<dl><dt>질문내용 -' + temp[i]['question'] + '</dt><dd><div class="fail_box ' + failChk + '"><div class="msg">분석 진행 중 입니다.</div></div><p>답변</p><div class="txt" id="speech' + i + '">' + answerTxt + '</div>' + answerData + '</dd></dl>');
        // }

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
            $('#answer_list').append('<dl><dt>질문내용 -' + temp[i]['question'] + '</dt><dd><div class="fail_box ' + failChk + '"><div class="msg">' + failMsg + '</div></div><p>답변</p><div class="txt" id="speech' + i + '">' + answerTxt + '</div>' + answerData + '</dd></dl>');

        }
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
            circle.css('background', 'conic-gradient(' + thisColor + ' 0% ' + circlePoint + '% #ddd ' + circlePoint + '% 100%)');
        });
    }

    function apeendBestAndWorst(type, tlt, txt) {
        $('#total' + type).append('<li><div class="tlt">' + tlt + '</div><div class="txt">' + txt + '</div></li>');
    }

    function videoAction(videoindex) {
        $('#totalBest').empty();
        $('#totalWorst').empty();

        for (let i = 0; i < $('.videoContent').length; i++) {
            $('.videoContent').get(i).pause();
        }

        if (videoindex != 'total') {
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
        }

        for (let key in aAnalysis[videoindex]) { // 적극성 안정성 신뢰성 긍정성
            if (key == 'sum' || key == 'grade') {
                $('.' + key).text(aAnalysis[videoindex][key]);
            } else {
                $('[data-type=' + key + '] > div').text(aAnalysis[videoindex][key] / 5);
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
                    ticks: {
                        beginAtZero: true,
                        display: false,
                        max: 100,
                        min: 0,
                        stepSize: 50
                    }
                    // y: {
                    //     beginAtZero: true,
                    // }
                    // pointLabels: {
                    //     fontStyle: "bold"
                    // }
                },
                // plugins: {
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
                },
                // },
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

    function abilityChart() {
        const ctx = document.getElementById('abilityChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['적극성', '안정성', '신뢰성', '긍정성', '대응성', '의지력', '능동성', '매력도'],
                datasets: [{
                        label: '본인',
                        data: [
                            '<?= $data['T']['analysis']['aggressiveness'] * 2 ?>',
                            '<?= $data['T']['analysis']['stability'] * 2 ?>',
                            '<?= $data['T']['analysis']['reliability'] * 2 ?>',
                            '<?= $data['T']['analysis']['affirmative'] * 2 ?>',
                            '<?= $data['T']['analysis']['alacrity'] * 2 ?>',
                            '<?= $data['T']['analysis']['willpower'] * 2 ?>',
                            '<?= $data['T']['analysis']['activity'] * 2 ?>',
                            '<?= $data['T']['analysis']['attraction'] * 2 ?>',
                        ],
                        fill: false,
                        borderColor: '#525DF5',
                        tension: 0.1
                    },
                    {
                        label: '지원자 평균',
                        data: [
                            <?= $data['avgCapacity'][0]['aggressiveness'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['stability'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['reliability'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['affirmative'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['alacrity'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['willpower'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['activity'] * 2 ?>,
                            <?= $data['avgCapacity'][0]['attraction'] * 2 ?>
                        ],
                        fill: false,
                        borderColor: '#26BFC4',
                        tension: 0.1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    },
                },
                // plugins: {
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
                // },
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
        let dream = [];
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
                tension: 0.1
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
                // plugins: {
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
                // },
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
                // plugins: {
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
                // },
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

    function expressionChart() {
        const ctx = document.getElementById('expressionChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['자신감', '시선마주침', '안색', '태도', '눈깜빡임', '발음정확도'],
                datasets: [{
                        label: '본인',
                        data: [
                            <?= $data['facialAnalysis']['confidence'] ?>,
                            <?= $data['facialAnalysis']['eye_contact'] ?>,
                            <?= $data['facialAnalysis']['complexion'] ?>,
                            <?= $data['facialAnalysis']['Attitude'] ?>,
                            <?= $data['facialAnalysis']['blinking'] ?>,
                            <?= $data['facialAnalysis']['pronunciation'] ?>
                        ],
                        backgroundColor: '#525DF5',
                        borderRadius: 5,
                        borderWidth: 0,
                        barThickness: 20,
                    },
                    {
                        label: '지원자 평균',
                        data: [
                            <?= $data['facialAnalysisAvg']['confidence'] ?>,
                            <?= $data['facialAnalysisAvg']['eye_contact'] ?>,
                            <?= $data['facialAnalysisAvg']['complexion'] ?>,
                            <?= $data['facialAnalysisAvg']['Attitude'] ?>,
                            <?= $data['facialAnalysisAvg']['blinking'] ?>,
                            <?= $data['facialAnalysisAvg']['pronunciation'] ?>
                        ],
                        backgroundColor: '#26BFC4',
                        borderRadius: 5,
                        borderWidth: 0,
                        barThickness: 20,
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    },
                },
                // plugins: {
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
                // },
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
                // plugins: {
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
                // }
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
</script>

<style>
    .chartBox>div {
        height: 110px !important;
    }

    .chart_bar>div {
        border-top-right-radius: 5px !important;
        border-top-left-radius: 5px !important;
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
        width: 90%;
        display: flex;
        justify-content: space-between;
    }

    .snsChartUpDown {
        width: 10%;
    }

    .snsChartLeng {
        width: 90%;
        background-color: #efefef;
        position: relative;
    }

    .snsChartPer {
        position: absolute;
    }

    .grayTxt {
        color: #999999;
        font-weight: bold;
    }

    .snsPerTxt {
        position: relative;
        top: -15px;
        left: 96%;
        font-weight: bold;
    }

    .prt_glineBox .tltBox {
        margin-bottom: 20px !important;
    }

    .grayBar {
        background-color: #efefef;
    }

    .res_mg_l {
        margin-left: 15px !important;
    }

    .res_mg_r {
        margin-right: 15px !important;
    }

    .resChartTxt {
        width: 25%;
        font-weight: bold;
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
        font-size: 10px;
    }

    .anChartBar {
        height: 45px !important;
    }

    .an>div {
        height: 42px !important;
    }

    .anChartBarSize {
        width: 15% !important;
    }

    .anPerLocation {
        position: absolute;
        bottom: 75%;
        right: 5px;
        font-size: 7px;
        font-weight: bold;
    }

    .anChartTxtDivision6 {
        width: 24% !important;
    }

    .anChartBarSizeDivision6 {
        width: 20% !important;
    }

    .anChartTxtDivision7 {
        width: 14% !important;
    }

    .anChartBarSizeDivision7 {
        width: 20% !important;
    }

    .anychart-credits {
        display: none !important;
    }

    .highlight-positive {
        box-shadow: inset 0px -16px 0px rgb(255, 99, 132);
        color: #fff;
    }

    .highlight-neutral {
        box-shadow: inset 0px -16px 0px rgb(255, 205, 86);
        color: #fff;
    }

    .highlight-negative {
        box-shadow: inset 0px -16px 0px rgb(75, 192, 192);
        color: #fff;
    }

    .chart_des {
        margin-bottom: 0.25rem;
    }
</style>