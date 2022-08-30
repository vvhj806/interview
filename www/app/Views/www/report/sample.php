<style>
    .graywrap {
        width: 100%;
        height: 100%;
        background-color: rgba(179, 174, 174, 0.7);
        position: absolute;
        z-index: 10;
    }

    .graywrap>div {
        color: white !important;
        position: fixed;
        left: 50%;
        top: 75%;
        transform: translate(-50%, -50%);
    }

    .graywrap>div>a {
        color: #505bf0 !important;
    }
</style>
<!--s #scontent-->
<div id="scontent" style="position: relative;">
    <div class='graywrap'>
        <div>
            지금 바로 <a href="login">로그인</a>하고,<br>
            첫 A.I. 리포트를 받아보세요!
        </div>
    </div>
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
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
                <div class="img repo_thumb"><img src="/static/www/img/sub/prf_no_img.jpg"></div>
            </div>
            <!--e ai_rpv_imgBox-->

            <!--s ai_rpv_txt_bigBox-->
            <div class="ai_rpv_txt_bigBox">
                <div class="txt">
                    지원자 님의<br />
                    <span class="b point2">[시스템개발]</span> 인터뷰 점수
                </div>
                <div class="class b point">
                    <span class='grade'>A</span>등급/
                    <span class='sum'>87</span>점
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

    <!--s cont-->
    <div class="cont cont_pd_bottom pd_t0">
        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox c">
            <!--s stltBox-->
            <div class="stltBox ovrflow">
                <div class="stlt">
                    <span class="b"><span class='order'></span> 답변의 점수는</span>
                    <span class="toolp_span abs"><a href="javascript:">?</a></span>
                </div>
            </div>
            <!--e stltBox-->

            <!--s 분석중일때-->
            <div class="ai_rpv_analyzing">
                <div class="img mg_b20"><img src="/static/www/img/sub/ai_rpv_analysis_icon.png"></div>
                <div class="stlt mg_b0">
                    AI가 열심히<br />
                    점수를 분석하고 있어요!
                </div>
            </div>
            <!--e 분석중일때-->

            <!--s 종합 점수 데이터-->
            <div class="analysisUl">
                <li>
                    <div class="tlt">적극성</div>
                    <div class="graph" data-type='aggressiveness'>
                        <div class='circletlt'>6</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">안정성</div>
                    <div class="graph" data-type='stability'>
                        <div class='circletlt'>7</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">신뢰성</div>
                    <div class="graph" data-type='reliability'>
                        <div class='circletlt'>5</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">긍정성</div>
                    <div class="graph" data-type='affirmative'>
                        <div class='circletlt'>8.3</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">대응성</div>
                    <div class="graph" data-type='alacrity'>
                        <div class='circletlt'>5.7</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">의지력</div>
                    <div class="graph" data-type='willpower'>
                        <div class='circletlt'>9.7</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">능동성</div>
                    <div class="graph" data-type='activity'>
                        <div class='circletlt'>7.2</div>
                    </div>
                </li>
                <li>
                    <div class="tlt">매력도</div>
                    <div class="graph" data-type='attraction'>
                        <div class='circletlt'>9.2</div>
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
                    <li>
                        <div class="tlt">눈 깜빡임</div>
                        <div class="txt">최소한의 눈깜빡임으로 안정적이게 인터뷰를 진행하였습니다.</div>
                    </li>
                    <li>
                        <div class="tlt">음성떨림</div>
                        <div class="txt">최소한의 떨린 목소리로 인터뷰를 안정되게 진행하였습니다.</div>
                    </li>
                    <li>
                        <div class="tlt">음성크기</div>
                        <div class="txt">적절한 성량으로 인터뷰를 안정적으로 진행하였습니다.</div>
                    </li>
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
                    <li>
                        <div class="tlt">머리 움직임</div>
                        <div class="txt">머리를 자주 움직여 집중력이 분산되고 다소 불안정해 보입니다.</div>
                    </li>
                    <li>
                        <div class="tlt">외국어 사용빈도</div>
                        <div class="txt">외국어를 너무 많이 사용하셨습니다</div>
                    </li>
                    <li>
                        <div class="tlt">제스처빈도</div>
                        <div class="txt">몸을 거의 움직이지 않고 인터뷰를 진행하였습니다.</div>
                    </li>
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

                    <div class='chart_bar'>
                        <span class='chartpoint'>10</span>
                        <div class='sky bar'>S</div>
                    </div>

                    <div class='chart_bar my'>
                        <span>내 점수</span>
                        <span class='chartpoint'>14</span>
                        <div class='blue bar'>A</div>
                    </div>

                    <div class='chart_bar'>
                        <span class='chartpoint'>20</span>
                        <div class='sky bar'>B</div>
                    </div>

                    <div class='chart_bar'>
                        <span class='chartpoint'>21</span>
                        <div class='sky bar'>C</div>
                    </div>


                    <div class='chart_bar'>
                        <span class='chartpoint'>11</span>
                        <div class='sky bar'>D</div>
                    </div>

                </div>
                <div class='chartLine blue'></div>
            </div>
        </div>
        <!--e wBox-->

        <!--s wBox-->
        <div class="ai_rpv_txtBox wBox totalBox">
            <!--s stlt-->
            <div class="stlt b">
                <span class="point2">[시스템개발]</span> 지원자중<br />
                <span class="txt_back txt_point2_back">상위 <span class='rankPoint'></span>%</span> 에 위치해요
            </div>
            <!--e stlt-->

            <div class="jd_graphBox c mg_t30">
                <div class='chartBox'>

                    <div class='chart_bar'>
                        <span class='chartpoint'>2</span>
                        <div class='lightbluegreen bar'>S</div>
                    </div>

                    <div class='chart_bar my'>
                        <span>내 점수</span>
                        <span class='chartpoint'>4</span>
                        <div class='bluegreen bar'>A</div>
                    </div>

                    <div class='chart_bar'>
                        <span class='chartpoint'>3</span>
                        <div class='lightbluegreen bar'>B</div>
                    </div>

                    <div class='chart_bar'>
                        <span class='chartpoint'>3</span>
                        <div class='lightbluegreen bar'>C</div>
                    </div>


                    <div class='chart_bar'>
                        <span class='chartpoint'>3</span>
                        <div class='lightbluegreen bar'>D</div>
                    </div>

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
                <div class="jd_graphBox c mg_t30">
                    <div class='gender male'>
                        <span>남성</span>
                        <span class='bar'><span class='inBar'></span></span>
                        <span>81%</span>
                    </div>
                    <div class='gender female'>
                        <span>여성</span>
                        <span class='bar'><span class='inBar'></span></span>
                        <span>19%</span>
                    </div>
                </div>
            </div>
            <!--e wBox-->

            <!--s wBox-->
            <div class="ai_rpv_txtBox wBox">
                <div class="stlt b c" style='margin-bottom: 0px'>나이 예측</div>
                <div id='age' class="jd_graphBox c">
                    <div class='chartBox'>
                        <div class='chart_bar'>
                            <span class='chartpoint'>0</span>
                            <div class='lightbluegreen bar'></div>
                            10대
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>70</span>
                            <div class='lightbluegreen bar'></div>
                            20대
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>30</span>
                            <div class='lightbluegreen bar'></div>
                            30대
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>0</span>
                            <div class='lightbluegreen bar'></div>
                            40대
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>0</span>
                            <div class='lightbluegreen bar'></div>
                            50대
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>0</span>
                            <div class='lightbluegreen bar'></div>
                            60대
                        </div>
                        <div class='chart_bar'>
                            <span class='chartpoint'>0</span>
                            <div class='lightbluegreen bar'></div>
                            70대
                        </div>
                    </div>
                </div>
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

<script>
    let temp = [];
    let aScore = [];
    let aAnalysis = [];
    let aQuestion = [];
    let aSpeech = [];
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

    $(document).ready(function() {

        circleGraph();

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

        $('.male > .bar > .inBar').css('width', '81%');
        $('.female > .bar > .inBar').css('width', '19%');

    });
</script>