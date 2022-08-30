<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">A.I. 리포트</div>
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
                <!-- <a href="javascript:" onclick="fnShowPop('profile_pop')">
                    <div class="camera_icon"><img src="/static/www/img/sub/ai_rpv_camera_icon.png"></div>
                </a> -->
                <div class="img"><img src="<?= $data['url']['media'] ?><?= $data['fileSaveName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
            </div>
            <!--e ai_rpv_imgBox-->

            <!--s ai_rpv_txt_bigBox-->
            <div class="ai_rpv_txt_bigBox">
                <div class="txt">
                    <?= $data['memName'] ?? '사용자' ?> 님의<br />
                    <span class="b point2"><?= $data['job'] ? '[' . $data['job'] . ']' : ''  ?></span> 인터뷰 점수
                </div>
                <div class="class b point">
                    <span><?= $data['T']['analysis']['grade'] ?></span>등급/
                    <span><?= $data['T']['analysis']['sum'] ?></span>점
                </div>
            </div>
            <!--e ai_rpv_txt_bigBox-->
        </div>
        <!--s contBox-->
    </div>
    <!--e gray_bline_first-->

    <!--s top_tab-->
    <div class="top_tab">
        <!--s depth-->
        <ul class="depth2 wd_2_2 mg_t20">
            <li id='total' class="on"><a>총점</a></li>
            <li id='answer'><a>답변별 점수</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->
    <!--s id_videoBox-->
    <div class="id_videoBox gray_back mg_b40 hide">
        <!--s contBox-->
        <div class="contBox">
            <!--s id_video_slBox-->
            <div class="id_video_slBox">
                <!--s id_video_sl-->
                <div class="id_video_sl">
                    <?php for ($i = 0, $max = count($data['S']); $i < $max; $i++) : ?>
                        <div class="item" data-videoIndex='<?= $i ?>'>
                            <div class="playBox" id="playBox" style="display: block;">
                                <div class="playBtn" id="playVideoBtn_<?= $i ?>" style=""><img src="/static/www/img/sub/id_video_play_btn.png"></div>
                                <div class="item">
                                    <video class="videoContent videoRotate" preload="metadata" src="<?= $data['url']['media'] . $data['videoPath'] . $data['S'][$i]['video'] ?>#t=0.5"></video>
                                </div>
                                <div class="playBox_bg"></div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <!--e id_video_sl-->
            </div>
            <!--e id_video_slBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox mg_t30">
                <!--s sel_lineb-->
                <div class="sel_lineb">
                <a href="javascript:" class="btn_syntaxnet" onclick="fnShowPop('ai_syntaxnet_tree')" style="float: right;">Syntaxnet</a>
                    <div class="stlt">
                        <span class="b point"><span class="order"></span> 질문</span>에 대한 답변이에요<br />
                        [<span id='question'></span>]
                    </div>
                </div>
                <!--e sel_lineb-->

                <!--s stxt-->
                <div id="speech" class="stxt gray">

                </div>
                <!--e stxt-->
            </div>
            <!--e wBox-->
        </div>
        <!--e contBox-->
    </div>
    <!--e id_videoBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom pd_t0">
        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox c">
            <!--s stltBox-->
            <div class="stltBox ovrflow">
                <div class="stlt">
                    <span class="b"><span class='order'></span> 답변의 점수는</span>
                    <span class="toolp_span abs"><a href="javascript:" onclick="fnShowPop('ai_rpv_synthesis_mb')">?</a></span>
                </div>
            </div>
            <!--e stltBox-->

            <!--s 종합 점수 데이터-->
            <div class="analysisUl">
                <li>
                    <div class="tlt">적극성</div>
                    <div class="graph" data-type='aggressiveness'>
                        <div class='circletlt'><?= $data['T']['analysis']['aggressiveness'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">안정성</div>
                    <div class="graph" data-type='stability'>
                        <div class='circletlt'><?= $data['T']['analysis']['stability'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">신뢰성</div>
                    <div class="graph" data-type='reliability'>
                        <div class='circletlt'><?= $data['T']['analysis']['reliability'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">긍정성</div>
                    <div class="graph" data-type='affirmative'>
                        <div class='circletlt'><?= $data['T']['analysis']['affirmative'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">대응성</div>
                    <div class="graph" data-type='alacrity'>
                        <div class='circletlt'><?= $data['T']['analysis']['alacrity'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">의지력</div>
                    <div class="graph" data-type='willpower'>
                        <div class='circletlt'><?= $data['T']['analysis']['willpower'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">능동성</div>
                    <div class="graph" data-type='activity'>
                        <div class='circletlt'><?= $data['T']['analysis']['activity'] / 5 ?></div>
                    </div>
                </li>
                <li>
                    <div class="tlt">매력도</div>
                    <div class="graph" data-type='attraction'>
                        <div class='circletlt'><?= $data['T']['analysis']['attraction'] / 5 ?></div>
                    </div>
                </li>
            </div>
            <!--e 종합 점수 데이터-->

            <div class="stlt mg_b0">훌륭한 인터뷰에요 멋있어요!</div>
        </div>
        <!--e wBox-->

        <!--s blueBox-->
        <div class="ai_rpv_txtBox blueBox">
            <div class="stlt b c"><span class='order'></span> <span class="point">BEST 3</span></div>

            <!--s bwUl-->
            <div class="bwUl">
                <ul id='totalBest'>

                </ul>
            </div>
            <!--e bwUl-->
        </div>
        <!--s blueBox-->

        <!--s blueBox-->
        <div class="ai_rpv_txtBox grayBox">
            <div class="stlt b c"><span class='order'></span><span class="point"> WORST 3</span></div>

            <!--s bwUl-->
            <div class="bwUl">
                <ul id='totalWorst'>

                </ul>
            </div>
            <!--e bwUl-->
        </div>
        <!--s blueBox-->

        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox totalBox">
            <!--s stlt-->
            <div class="stlt b">
                <span class="point">[전체]</span> 지원자중<br />
                <span class="txt_back txt_point_back">상위 <span class='rankPoint'></span>%</span>에 위치해요
            </div>
            <!--e stlt-->

            <div class="jd_graphBox c mg_t30">
                <div class='chartBox'>
                    <?php foreach ($data['T']['reportScoreRank']['T'] as $val) : ?>
                        <?php if ($val['score_rank_grade'] === $data['T']['analysis']['grade']) : ?>
                            <div class='chart_bar my'>
                                <span>내 점수</span>
                                <span class='chartpoint'><?= $val['score_rank_count_member'] ?></span>
                                <div class='blue bar'> <?= $val['score_rank_grade'] ?></div>
                            </div>
                        <?php else : ?>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $val['score_rank_count_member'] ?></span>
                                <div class='sky bar'> <?= $val['score_rank_grade'] ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class='chartLine blue'></div>
            </div>
        </div>
        <!--e wBox-->

        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox totalBox">
            <!--s stlt-->
            <div class="stlt b">
                <span class="point2">[<?= $data['job'] ?>]</span> 지원자중<br />
                <span class="txt_back txt_point2_back">상위 <span class='rankPoint'></span>%</span> 에 위치해요
            </div>
            <!--e stlt-->

            <div class="jd_graphBox c mg_t30">
                <div class='chartBox'>
                    <?php foreach ($data['T']['reportScoreRank']['C'] as $val) : ?>
                        <?php if ($val['score_rank_grade'] === $data['T']['analysis']['grade']) : ?>
                            <div class='chart_bar my'>
                                <span>내 점수</span>
                                <span class='chartpoint'><?= $val['score_rank_count_member'] ?></span>
                                <div class='bluegreen bar'> <?= $val['score_rank_grade'] ?></div>
                            </div>
                        <?php else : ?>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $val['score_rank_count_member'] ?></span>
                                <div class='lightbluegreen bar'> <?= $val['score_rank_grade'] ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class='chartLine bluegreen'></div>
            </div>
        </div>
        <!--e wBox-->

        <!--s ai_rpv_txtBox_wd2-->
        <div class="ai_rpv_txtBox_wd2 totalBox">
            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox">
                <div class="stlt b c">성별 예측</div>
                <?php if ($data['T']['score']['gender'] != 0) : ?>
                    <div class="jd_graphBox c mg_t30">
                        <div class='gender male'>
                            <span>남성</span>
                            <span class='bar'><span class='inBar'></span></span>
                            <span><?= $data['T']['score']['gender'][0] ?? 0 ?>%</span>
                        </div>
                        <div class='gender female'>
                            <span>여성</span>
                            <span class='bar'><span class='inBar'></span></span>
                            <span><?= $data['T']['score']['gender'][1] ?? 0 ?>%</span>
                        </div>
                    </div>
                <?php else : ?>
                    <div class='center'>분석 불가</div>
                <?php endif; ?>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox">
                <div class="stlt b c" style='margin-bottom: 0px'>나이 예측</div>
                <?php if ($data['T']['score']['age'] != 0) : ?>
                    <div id='age' class="jd_graphBox c">
                        <div class='chartBox'>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][0] ?></span>
                                <div class='lightbluegreen bar'></div>
                                10대
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][1] ?></span>
                                <div class='lightbluegreen bar'></div>
                                20대
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][2] ?></span>
                                <div class='lightbluegreen bar'></div>
                                30대
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][3] ?></span>
                                <div class='lightbluegreen bar'></div>
                                40대
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][4] ?></span>
                                <div class='lightbluegreen bar'></div>
                                50대
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][5] ?? 0 ?></span>
                                <div class='lightbluegreen bar'></div>
                                60대
                            </div>
                            <div class='chart_bar'>
                                <span class='chartpoint'><?= $data['T']['score']['age'][6] ?? 0 ?></span>
                                <div class='lightbluegreen bar'></div>
                                70대
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class='center' style='margin-top:24px;'>분석 불가</div>
                <?php endif; ?>
            </div>
            <!--e wBox-->
        </div>
        <!--e ai_rpv_txtBox_wd2-->

        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox">
            <div class="stlt mg_b10">리포트에 대해 <span class="point b">문의사항</span>이 있으신가요?</div>
            <div class="txt gray">
                궁금하신 점은 환경설정 > 고객센터나<br />
                카카오톡 채널 ‘인터뷰’로 말씀해주세요.
            </div>

            <div class="ai_rpv_iq_icon"><img src="/static/www/img/sub/ai_rpv_iq_icon.png"></div>
        </div>
        <!--e wBox-->

    </div>
    <!--e cont-->

</div>
<!--e #scontent-->

<!--s syntaxnet tree 모달-->
<div id="ai_syntaxnet_tree" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="tlt mg_b10">Syntaxnet Tree</div>
            <div class="txt">종속성 구분 분석 트리를 통해 문장의 단어 간의 구문 관계를 확인할 수 있습니다.</div>

            <div class="stxt pop_txt">
                <div id="container"></div>
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

<!--s 점수 산출기준 모달-->
<div id="ai_rpv_synthesis_mb" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="tlt mg_b10">점수 기준이 궁금해요</div>
            <div class="txt">하이버프점수는 이렇게 산출되어요</div>

            <div class="stxt pop_txt">
                <div>적극성</div>
                <p>적절한 제스처와 함께 발음이 정확할수록 점수가 UP</p>

                <div>안정성</div>
                <p>목소리의 크기가 적당하고 당황하지 않으면 점수가 UP</p>

                <div>신뢰성</div>
                <p>시선을 잘 마주치고 성실하게 답변하면 점수가 UP</p>

                <div>긍정성</div>
                <p>밝고 긍정적인 표정을 지으면 점수가 UP</p>

                <div>대응성</div>
                <p>질문의 이해도가 높고 답변 속도가 빠르면 점수가 UP</p>

                <div>의지력</div>
                <p>적절한 제스처와 함께 시선처리가 좋으면 점수가 UP</p>

                <div>능동성</div>
                <p>답변 속도가 빠르고 긍정적인 표정이 많으면 점수가 UP</p>

                <div>매력도</div>
                <p>목소리 톤이 좋고 긍정적인 표정이 많으면 점수가 UP</p>
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
    let aSyntaxnet = [];
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
            circleText.css('color', `${thisColor}`);
            circle.css('background', `conic-gradient(${thisColor} 0% ${circlePoint}%, #ddd ${circlePoint}% 100%`);
        });
    }

    function apeendBestAndWorst(type, tlt, txt) {
        $('#total' + type).append(`        
            <li>
                <div class="tlt">${tlt}</div>
                <div class="txt">${txt}</div>
            </li>
         `);
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
                        startTime = aSpeech[videoindex][i]['start_time'];
                        endTime = aSpeech[videoindex][i]['end_time'];
                        $('#speech').append(`
                            <span class='word_timestamp' data-start=${startTime} data-end=${endTime}>${word}</span>
                        `);
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

        for (let key in aAnalysis[videoindex]) { // 적극성 안정성 신뢰성 긍정성
            if (key == 'sum' || key == 'grade') {
                $(`.${key}`).text(aAnalysis[videoindex][key]);
            } else {
                $(`[data-type='${key}'] > div`).text(aAnalysis[videoindex][key] / 5);
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
        aSyntaxnet[i] = temp[i].syntaxnet;
    }

    $(document).ready(function() {
        aScore['total'] = bestAndWorst(sortMethod(aScore['total']));

        for (let i = 0; i < aScore.length; i++) {
            aScore[i] = bestAndWorst(sortMethod(aScore[i]));
        }
        videoAction('total');

        $('.jd_graphBox').each(function() { // 전체 지원자, 직종 지원자 차트
            let chartSum = 0;
            $(this).children('.chartBox').children('.chart_bar').each(function() {
                let num = $(this).children('.chartpoint').text();
                chartSum = chartSum + parseInt(num);
            });
            let persentSum = 0;
            $(this).children('.chartBox').children('.chart_bar').each(function() {
                let num = $(this).children('.chartpoint').text();
                if (num > 0) {
                    let persent = (parseFloat(num) / chartSum) * 100;
                    persentSum = persentSum + persent;
                    $(this).children('.bar').css('height', `${persent}%`);
                    if ($(this).hasClass('my')) {
                        $(this).closest('.rankPoint').text(persentSum);
                        $(this).closest('.ai_rpv_txtBox ').find('.rankPoint').text(parseInt(persentSum));
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

            // $(".playBox_bg").css("display", "none");
            // $("#playVideoBtn").css("display", "none");
        });

        // $(".videoContent").on("ended", function() {
        //     let playbtn = $(this).parents('div:eq(1)').children('div:eq(0)').children('div:eq(0)');
        //     playbtn.css("display", "");
        // });


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
        });

        $('.btn_syntaxnet').on('click', function() { //syntaxnet chart generate
            anychart.onDocumentReady(function () {
                $('#container').empty(); //chart init

                let data = [aSyntaxnet[global_videoindex]];
                let syntaxnetChart = anychart.wordtree(data, "as-tree");                

                let connectors = syntaxnetChart.connectors();
                connectors.curveFactor(0); //연결선의 곡률 지정
                connectors.length(3);
                connectors.offset(0);
                connectors.stroke("0.5 #1976d2");

                syntaxnetChart.container("container");
                syntaxnetChart.draw();

                syntaxnetChart.listen('chartDraw', function(e){
                    if (window.innerWidth > 768) { //화면 사이즈에 따라 font size 변경
                        syntaxnetChart.maxFontSize(15);
                    } else {
                        syntaxnetChart.maxFontSize(12);
                    }                    
                });
            });
        });
    });
        
</script>

<style>
    .pop_txt>div {
        color: black;
    }

    #container {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .anychart-credits {
        display: none !important;
    }
</style>