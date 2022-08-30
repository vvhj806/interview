<div class="ht100">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s scont-->
    <div class="cont ht100 c cont_pd_bottom">
        <form action="/interview/timerAction" method="POST" id="timer">
            <?= csrf_field() ?>
            <input name="applyIdx" value="<?= $data['applyIdx'] ?>" type="hidden">
            <input name="memIdx" value="<?= $data['memIdx'] ?>" type="hidden">
            <input name="answerTimer" id="answerTimer" value="45" type="hidden">
            <input name="postCase" value="selfTimer" type="hidden">
            <input name="backUrl" value="/" type="hidden">
        </form>
        <!--s cntBpx-->
        <div class="cntBpx_sub">
            <!--s bigtlt-->
            <div class="bigtlt bigtlt2">
                <div class="b point bigtxt">셀프 타이머</div>
                질문 당 응답 시간을 설정해 주세요
            </div>
            <!--e bigtlt-->
            <div class="knobBox">
                <div id="knob" style="z-index:999;"></div>
            </div>

            <!--s timerBox-->
            <div class="timerBox">
                <div class="timer_graphBox">
                </div>
                <!--s numBox-->
                <div class="numBox">
                    <div class="big point">45</div>
                    <div class="small">초</div>
                </div>
                <!--e numBox-->

            </div>
            <!--e timerBox-->

            <!--s BtnBox-->
            <div class="BtnBox" style="z-index:9999; position:relative">
                <div class="bigtlt mg_b40 b">좌우로 움직여 시간을 설정할 수 있습니다.</div>
                <a href="javascript:" class="btn btn01 wps_100" id="complete">시작하기</a>
            </div>
            <!--e BtnBox-->
        </div>
        <!--e cntBpx-->
    </div>
    <!--e scont-->
</div>


<script src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxcore.js"></script>
<script src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxdraw.js"></script>
<script src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxknob.js"></script>
<script src="https://www.jqwidgets.com/jquery-widgets-demo/jqwidgets/jqxinput.js"></script>
<script>
    $('.numBox > .point').text(45);

    $('#complete').on('click', function() {
        $('#timer').submit();
    });

    $('#knob').jqxKnob({
        value: 30,
        min: 0,
        max: 60,
        width: '100%',
        height: '100%',
        startAngle: 180,
        endAngle: 360,
        dragStartAngle: 180,
        dragEndAngle: 360,
        rotation: 'clockwise',
        marks: {
            colorRemaining: '#333',
            colorProgress: '#505bf0',
            type: 'circle',
            offset: '68%',
            drawAboveProgressBar: true,
            thickness: 1,
            size: '2%',
            majorSize: '2%',
            majorInterval: 15,
            minorInterval: 0
        },
        pointer: {
            type: 'circle',
            style: {
                fill: '#fff',
                stroke: '#505bf0'
            },
            size: '6%',
            offset: '60%',
            thickness: 25
        },
        step: 1,
        progressBar: {
            background: {
                fill: '#eeeeee'
            },
            style: {
                fill: "#505bf0"
            },
            ranges: [{
                    startValue: 0,
                    endValue: 15,
                    fill: "#e1e1e1"
                },
                {
                    startValue: 15,
                    endValue: 30,
                    fill: "#e1e1e1"
                },
                {
                    startValue: 30,
                    endValue: 45,
                    fill: "#e1e1e1"
                },
                {
                    startValue: 45,
                    endValue: 60,
                    fill: "#e1e1e1"
                },
            ],
            size: '7%',
            offset: '56%'
        },
    });

    $('#knob').on('change', function(event) {
        let value = event.args.value;

        if (value < 15) {
            $('#knob').val(15);
            $('#answerTimer').val(30);
            $('.numBox > .point').text(30);
        } else if (value >= 15 && value < 30) {
            $('#knob').val(15);
            $('#answerTimer').val(30);
            $('.numBox > .point').text(30);
        } else if (value >= 30 && value < 45) {
            $('#knob').val(30);
            $('#answerTimer').val(45);
            $('.numBox > .point').text(45);
        } else if (value >= 45 && value < 60) {
            $('#knob').val(45);
            $('#answerTimer').val(60);
            $('.numBox > .point').text(60);
        } else if (value >= 60) {
            $('#knob').val(60);
            $('#answerTimer').val(90);
            $('.numBox > .point').text(90);
        }
    });
</script>
<style>
    .cntBpx_sub {
        width: 100%;
    }
</style>