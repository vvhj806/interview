<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/my/resume">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">이력서 AI리포트</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s gray_bline_first-->
    <div class="gray_bline_first mg_t20 c">
        <!--s contBox-->
        <div class="contBox">
            <!--s ai_rpv_imgBox-->
            <div class="ai_rpv_imgBox">
                <!--<a href="#n" onclick="fnShowPop('profile_pop')">
                    <div class="camera_icon"><img src="/static/www/img/sub/ai_rpv_camera_icon.png"></div>
                </a>-->
                <div class="img"><img src="<?= isset($data['report']['file_save_name']) ?  $data['url']['media'] . $data['report']['file_save_name'] : "/static/www/img/sub/prf_no_img.jpg"  ?>" id='changeImg'></div>
            </div>
            <!--e ai_rpv_imgBox-->

            <!--s ai_rpv_txt_bigBox-->
            <div class="ai_rpv_txt_bigBox">
                <div class="txt mg_b20">
                    <span class="b"><?= $data['report']['res_name'] ?></span> 님의 관심직무 <br />
                    <span class="b point2">

                        <?php
                        if (!empty($data['report']['interest'])) :
                            foreach ($data['report']['interest'] as $key => $val) :
                        ?>
                                [<?= $data['report']['interest'][$key]['job_depth_text'] ?>]
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </span>
                </div>

                이력서 점수<br />
                <div class="class b point mg_t5">B등급 / 65점</div>
            </div>
            <!--e ai_rpv_txt_bigBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s cont-->
    <div class="cont cont_pd_bottom">
        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox">
            <!--s stlt-->
            <div class="stlt b">
                나의 스펙분석
            </div>
            <!--e stlt-->

            <div class="rs_graphBox c mg_t30">
                <div class='chartBox rs_chartBox'>

                    <div class='chart_bar rs_chart_bar'>

                        <span class='chartpoint rs_chartpoint'>12</span>
                        <div class='rs_my bar'> </div>
                        <span class='chartpoint rs_chartpoint'>80</span>
                        <div class='rs_your bar'> </div>
                    </div>

                    <div class='chart_bar rs_chart_bar'>

                        <span class='chartpoint rs_chartpoint'>40</span>
                        <div class='rs_my bar'> </div>
                        <span class='chartpoint rs_chartpoint'>60</span>
                        <div class='rs_your bar'> </div>
                    </div>
                    <div class='chart_bar rs_chart_bar'>

                        <span class='chartpoint rs_chartpoint'>30</span>
                        <div class='rs_my bar'> </div>
                        <span class='chartpoint rs_chartpoint'>70</span>
                        <div class='rs_your bar'> </div>
                    </div>
                    <div class='chart_bar rs_chart_bar'>

                        <span class='chartpoint rs_chartpoint'>50</span>
                        <div class='rs_my bar'> </div>
                        <span class='chartpoint rs_chartpoint'>50</span>
                        <div class='rs_your bar'> </div>
                    </div>


                </div>

                <div class='chartLine rs_chartLine'></div>
                <div class="rs_chartText">
                    <span>학력</span>
                    <span>경력</span>
                    <span>어학</span>
                    <span>자격증</span>
                </div>
                <div class="rs_chartType">
                    <span>
                        <div class="rs_chartColor rs_my"></div>나의스펙
                    </span>
                    <span>
                        <div class="rs_chartColor rs_your"></div>지원자 평균 스펙
                    </span>
                </div>
            </div>
        </div>
        <!--e wBox-->

        <!--s wBox-->
        <div class="ai_rpv_txtBox grayBox">
            <!--s stlt-->
            <div class="stlt b">
                나의 스펙
                <div class="font18 gray b400">스펙점수가 평균보다 낮다면, A.I. 면접을 통해 어필해보세요! </div>
            </div>
            <!--e stlt-->

            <!--s qpBox-->
            <div class="qpBox">
                <!--s qp_txtBox-->
                <div class="qp_txtBox">
                    <div class="tpBox">
                        <ul>
                            <li class="fir">
                                <span class="tlt point">학력</span>
                                <span class="txt">
                                    4년제 졸업<br />
                                    서울대학교<br />
                                    3.5점
                                </span>
                            </li>
                            <li class="sd">
                                <span class="num"><span class="point">5.5점</span> <span class="gray">/ 10점</span></span>
                            </li>
                        </ul>

                        <!--s tp_over-->
                        <div class="tp_over">
                            최종학위,학교순위,학점을 <br />종합하여 점수가 측정됩니다.
                        </div>
                        <!--e tp_over-->
                    </div>

                    <div class="tpBox">
                        <ul>
                            <li class="fir">
                                <span class="tlt point">경력</span>
                                <span class="txt">
                                    포스코건설<br />
                                    4년 7개월
                                </span>
                            </li>
                            <li class="sd">
                                <span class="num"><span class="point">7점</span> <span class="gray">/ 10점</span></span>
                            </li>
                        </ul>

                        <!--s tp_over-->
                        <div class="tp_over">
                            관심 직무와 회사연관성, 근무년수에 대한 <br />기준으로 점수가 측정됩니다.

                        </div>
                        <!--e tp_over-->
                    </div>
                </div>
                <!--e qp_txtBox-->

                <!--s qp_txtBox-->
                <div class="qp_txtBox">
                    <div class="tpBox">
                        <ul>
                            <li class="fir">
                                <span class="tlt point">어학</span>
                                <span class="txt">
                                    TOEIC<br />
                                    850점
                                </span>
                            </li>
                            <li class="sd">
                                <span class="num"><span class="point">6점</span> <span class="gray">/ 10점</span></span>
                            </li>
                        </ul>

                        <!--s tp_over-->
                        <div class="tp_over">
                            어학 자격증 수, 점수 <br />기준으로 점수가 측정됩니다.
                        </div>
                        <!--e tp_over-->
                    </div>

                    <div class="tpBox">
                        <ul>
                            <li class="fir">
                                <span class="tlt point">자격증</span>
                                <span class="txt">
                                    운전면허1종<br />
                                    일식조리사
                                </span>
                            </li>
                            <li class="sd">
                                <span class="num"><span class="point">8점</span> <span class="gray">/ 10점</span></span>
                            </li>
                        </ul>

                        <!--s tp_over-->
                        <div class="tp_over">
                            자격증 보유 개수, 연관성 <br />기준으로 점수가 측정됩니다.
                        </div>
                        <!--e tp_over-->
                    </div>
                </div>
                <!--e qp_txtBox-->
            </div>
            <!--e qpBox-->
        </div>
        <!--e wBox-->


        <div class="stlt mg_t60">지원자 현황 분석 ㅣ 지원자 수 <span class="b point"><?= $data['reportTotal']['jobCnt'] ?></span> 명 </div>

        <!--s ai_rpv_txtBox_wd2-->
        <div class="ai_rpv_txtBox_wd2">
            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">성별 예측</div>

                <div class="jd_graphBox c mg_t30">
                    <div class='gender male'>
                        <span>남성</span>
                        <span class='bar'><span class='inBar' data-val="<?= $data['reportTotalGender']['M'] ?>"></span></span>
                        <span><?= $data['reportTotalGender']['M'] ?>%</span>
                    </div>
                    <div class='gender female'>
                        <span>여성</span>
                        <span class='bar'><span class='inBar' data-val="<?= $data['reportTotalGender']['W'] ?>"></span></span>
                        <span><?= $data['reportTotalGender']['W'] ?>%</span>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">연령별 현황</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?= $data['reportTotalAge']['age10'] ?? 0 ?></span>
                            <div class='<?= isset($data['reportAgeMy']['age10']) ? $data['reportAgeMy']['age10'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>10대</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?= $data['reportTotalAge']['age20'] ?? 0 ?></span>
                            <div class='<?= isset($data['reportAgeMy']['age20']) ? $data['reportAgeMy']['age20'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>20대</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?= $data['reportTotalAge']['age30'] ?? 0 ?></span>
                            <div class='<?= isset($data['reportAgeMy']['age30']) ? $data['reportAgeMy']['age30'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>30대</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?= $data['reportTotalAge']['age40'] ?? 0 ?></span>
                            <div class='<?= isset($data['reportAgeMy']['age40']) ? $data['reportAgeMy']['age40'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>40대</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?= $data['reportTotalAge']['age50'] ?? 0 ?></span>
                            <div class='<?= isset($data['reportAgeMy']['age50']) ? $data['reportAgeMy']['age50'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>50대이상</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">학력별 현황</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>0</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>고졸이하</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>1</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>2~3년제</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>16</span>
                            <div class='rs_my bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>4년제</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>1</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>석사</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>0</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>박사</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">경력별 현황</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalCareer']['car0'] ?? 0?></span>
                            <div class='<?= isset($data['reportCareerMy']['car0']) ? $data['reportCareerMy']['car0'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>신입</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalCareer']['car1'] ?? 0?></span>
                            <div class='<?= isset($data['reportCareerMy']['car1']) ? $data['reportCareerMy']['car1'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?>  bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>1년미만</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalCareer']['car3'] ?? 0?></span>
                            <div class='<?= isset($data['reportCareerMy']['car3']) ? $data['reportCareerMy']['car3'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?>  bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>1~3년</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalCareer']['car5'] ?? 0?></span>
                            <div class='<?= isset($data['reportCareerMy']['car5']) ? $data['reportCareerMy']['car5'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?>  bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>3~5년</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalCareer']['car10'] ?? 0?></span>
                            <div class='<?= isset($data['reportCareerMy']['car10']) ? $data['reportCareerMy']['car10'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?>  bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>5년이상</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">외국어 현황</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotallanguage']['TOEIC'] ?? 0?></span>
                            <div class='<?= isset($data['reportlanguageMy']['TOEIC']) ? $data['reportlanguageMy']['TOEIC'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>TOEIC</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotallanguage']['TOEFL'] ?? 0?></span>
                            <div class='<?= isset($data['reportlanguageMy']['TOEFL']) ? $data['reportlanguageMy']['TOEFL'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>TOEFL</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotallanguage']['TEPS'] ?? 0?></span>
                            <div class='<?= isset($data['reportlanguageMy']['TEPS']) ? $data['reportlanguageMy']['TEPS'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>TEPS</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotallanguage']['OPIC'] ?? 0?></span>
                            <div class='<?= isset($data['reportlanguageMy']['OPIC']) ? $data['reportlanguageMy']['OPIC'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>OPIC</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotallanguage']['JPT'] ?? 0?></span>
                            <div class='<?= isset($data['reportlanguageMy']['JPT']) ? $data['reportlanguageMy']['JPT'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>JPT</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotallanguage']['HSK'] ?? 0?></span>
                            <div class='<?= isset($data['reportlanguageMy']['HSK']) ? $data['reportlanguageMy']['HSK'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>HSK</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">TOEIC 점수</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalToeic']['T600'] ?? 0?></span>
                            <div class='<?= isset($data['reportToeicMy']['T600']) ? $data['reportToeicMy']['T600'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>600<br>미만</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalToeic']['T700'] ?? 0?></span>
                            <div class='<?= isset($data['reportToeicMy']['T700']) ? $data['reportToeicMy']['T700'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>700<br>미만</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalToeic']['T800'] ?? 0?></span>
                            <div class='<?= isset($data['reportToeicMy']['T800']) ? $data['reportToeicMy']['T800'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>800<br>미만</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalToeic']['T900'] ?? 0?></span>
                            <div class='<?= isset($data['reportToeicMy']['T900']) ? $data['reportToeicMy']['T900'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>900<br>미만</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalToeic']['T1000'] ?? 0?></span>
                            <div class='<?= isset($data['reportToeicMy']['T1000']) ? $data['reportToeicMy']['T1000'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>900<br>이상</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">자격증 개수</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalLicense']['L0'] ?? 0?></span>
                            <div class='<?= isset($data['reportLicenseMY']['L0']) ? $data['reportLicenseMY']['L0'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>미보유</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalLicense']['L1'] ?? 0?></span>
                            <div class='<?= isset($data['reportLicenseMY']['L1']) ? $data['reportLicenseMY']['L1'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>1개</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalLicense']['L2'] ?? 0?></span>
                            <div class='<?= isset($data['reportLicenseMY']['L2']) ? $data['reportLicenseMY']['L2'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>2개</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalLicense']['L3'] ?? 0?></span>
                            <div class='<?= isset($data['reportLicenseMY']['L3']) ? $data['reportLicenseMY']['L3'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>3개</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'><?=$data['reportTotalLicense']['L4'] ?? 0?></span>
                            <div class='<?= isset($data['reportLicenseMY']['L4']) ? $data['reportLicenseMY']['L4'] == true ? 'rs_my' : 'rs_your' : 'rs_your' ?> bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>4개이상</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">자격증 현황</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>8</span>
                            <div class='rs_my bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>1종보통<br>운전면허</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>3</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>2종보통<br>운전면허</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>6</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>컴퓨터<br>활용능력</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>1</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>MOS<br>Master</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>10</span>
                            <div class='rs_my bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>기타</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">기타활동 개수</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>2</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>없음</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>8</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>1건</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>6</span>
                            <div class='rs_my bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>2건</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>3</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>3건이상</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox rs_txtBox">
                <div class="stlt b c">기타문서 제출</div>

                <div class="jd_graphBox c rs_chart_height rs_m_margin">
                    <div class='chartBox rs_chart_height'>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>3</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>미첨부</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>10</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>1건</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>2</span>
                            <div class='rs_my bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>2건</div>
                        </div>
                        <div class='chart_bar rs_chart_height'>
                            <span class='chartpoint rs_chartpoint'>0</span>
                            <div class='rs_your bar rs_bar'></div>
                            <div class='rs_txt_subtitle'>3건이상</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--e wBox-->
        </div>
        <!--e ai_rpv_txtBox_wd2-->

        <ul class="rcm_vUl mg_t10">
            <li>이력서 리포트 기준 : 관심직무 등록일자</li>
            <li>이력서 리포트는 구직활동에 도움을 드리고자 제공되는 서비스로
                이력서/ 첨부파일 지원자의 데이터를 토대로 작성 되었습니다.
            </li>
        </ul>
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<script>
    $(document).ready(function() {
        let cSum = 0;

        $('.rs_chart_bar').each(function() {
            let n1 = $(this).children('.chartpoint:eq(0)').text();
            let n2 = $(this).children('.chartpoint:eq(1)').text();
            cSum = parseInt(n1) + parseInt(n2);

            let p1 = (parseFloat(n1) / cSum) * 100;
            let p2 = (parseFloat(n2) / cSum) * 100;

            $(this).children('.chartpoint:eq(0)').next().css('height', `${p1}%`);
            $(this).children('.chartpoint:eq(1)').next().css('height', `${p2}%`);
        });
        console.log(cSum);



        $('.jd_graphBox').each(function() { // 전체 지원자, 직종 지원자 차트
            let chartSum = 0;
            $(this).children('.chartBox').children('.chart_bar').children('.chartpoint').each(function() {
                let num = $(this).text();
                chartSum = chartSum + parseInt(num);
            });
            let persentSum = 0;
            $(this).children('.chartBox').children('.chart_bar').children('.chartpoint').each(function() {
                let num = $(this).text();

                if (num > 0) {
                    let persent = (parseFloat(num) / chartSum) * 100;
                    persentSum = persentSum + persent;

                    $(this).next().css('height', `${persent}%`);

                }
            });
        });

        $('.male > .bar > .inBar').css('width', $('.male > .bar > .inBar').data('val') + '%');
        $('.female > .bar > .inBar').css('width', $('.female > .bar > .inBar').data('val') + '%');
    });
</script>