<?php
isset($data['applicantIdx']) ? $data['applicantIdx'] : $data['applicantIdx'] = "";
if (count($data['startInterview'][0]['video']) == count($data['startInterview'][0]['report_result'])) {
    if ($data['applicantIdx']) {
        $backurl = "/linkInterview/" . $data['applicantIdx'];
    } else {
        $backurl = '/';
    }
    alert_url("완료된 인터뷰입니다.", $backurl);
}

// print_r($data['startInterview']);

?>
<!--s #scontent-->
<div id="before_interview" class="ht100">
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

    <!--s cont-->
    <div class="cont cont_pd_bottom c ht100">
        <!--s cntBpx-->
        <div class="cntBpx">
            <div class="icon mic_icon01_1"><img src="/static/www/img/sub/mic_ck03_icon.png"></div>

            <!--s bigtlt-->
            <div class="bigtlt mg_t40 mg_b30">
                인터뷰 응시 준비가 완료되었어요!
            </div>
            <!--e bigtlt-->

            <div class="mg_b_50">
                아래 시작하기 버튼을 누를 시,<br />
                카메라가 켜지고<br />
                나의 모습을 확인할 수 있어요.<br /><br />

                질문에 대한 답변 준비가 완료되면<br />
                <span class="point b">‘바로대답하기’</span> 버튼을 눌러<br />
                촬영을 진행해 주세요!
            </div>

            <!--s bigtlt-->
            <div class="bigtlt point mg_t40">
                이제 첫 질문을 보러 가볼까요?
            </div>
            <!--e bigtlt-->

            <!--s BtnBox-->
            <div class="BtnBox" id="start">
                <a href="javascript:" class="btn btn01 wps_100"><span class="faq_mic_icon"><img src="/static/www/img/sub/mic_icon.png"></span> 시작하기</a>
            </div>
            <!--e BtnBox-->
        </div>
        <!--e cntBpx-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->
<!--s #scontent-->
<div id="interview_box" style="display:none;">
    <!--s face_vdoBox-->
    <div class="face_vdoBox">
        <!--s txtBox-->
        <div class="txtBox c">
            <div class="step">질문 <span id="total_step"> 0 / 0</div>
            <div class="txt" id="q_text">
                질문을 불러오는 중입니다. <br> 잠시만 기다려주세요

                <!-- <span class="ypoint">
				AI가 세민님의 답변을 듣고<br />
				다음 질문을 생각하고 있어요
				</span> -->
                <!-- 다음질문 로딩걸릴때 -->

                <!-- 마지막 질문입니다!<br />
				4P에 대해 설명하세요 -->
                <!-- 마지막 질문일대 -->
            </div>

            <div class="fv_close" id="cancleInterview" style="display:none"><img src="/static/www/img/sub/fv_close.png"></div>
        </div>
        <!--e txtBox-->

        <img src="/static/www/img/sub/listen.gif" class="listen_gif" alt="" style="display:none">

        <!--s fv_txtBox-->
        <div class="fv_txtBox">
            <div class="point_txt" id="WaitText"><span id="wait_text">30</span>초 뒤에 촬영이 시작됩니다!</div>

            <div class="onair" id="onairCheck" style="display:none"><span>ON-AIR</span></div>
            <div class="time" id="answer_text" style="display:none">남은 답변 시간 <span class="b" id="min_text">00:00</span></div>

            <div class="loading devloading" id="loadingIcon"><span><img src="/static/www/img/sub/fv_loading_icon.png"></span></div>
        </div>
        <!--e fv_txtBox-->

        <!--s fv_BtnBox-->
        <div class="fv_BtnBox">
            <!--s fv_Btncontx-->
            <div class="fv_Btncont">
                <!--s fv_retry-->
                <div class="fv_iconBtn fv_retry" id="popRetry" style="display:none">
                    <a href="javascript:">
                        <div class="icon"><img src="/static/www/img/sub/fv_retry_icon.png"></div>
                        <div class="txt">재촬영</div>
                    </a>
                </div>
                <!--e fv_retry-->

                <!--s fv_on-->
                <div class="fv_iconBtn fv_on" id="change_btn" style="z-index:11">
                    <!--s 화면on일때-->
                    <a href="javascript:" id="On_btn">
                        <div class="icon"><img src="/static/www/img/sub/fv_on_icon.png"></div>
                        <div class="txt point">화면ON</div>
                    </a>
                    <!--e 화면on일때-->

                    <!--s 화면off일때-->
                    <a href="javascript:" id="Off_btn" style="display:none">
                        <div class="icon"><img src="/static/www/img/sub/fv_off_icon.png"></div>
                        <div class="txt">화면OFF</div>
                    </a>
                    <!--e 화면off일때-->

                    <a href="javascript:void(0)" id="ai_btn" style="display:none">
                        <div class="icon"><img src="/static/www/img/sub/ai_icon.png"></div>
                    </a>
                </div>
                <!--e fv_on-->
                <!-- <div class="fv_iconBtn ai_icon" id="">
                    <div class="icon"><img src="/static/www/img/sub/ai_icon.png"></div>
                </div> -->

                <!--s answer_icon-->
                <div class="fv_iconBtn answer_icon">
                    <a href="javascript:">
                        <div class="answer_btn" id="answer_btn" style="display:none">바로 대답하기</div>
                    </a>
                    <a href="javascript:">
                        <div class="answer_btn on jy_interview_pr_pop_open2" id="next_btn" style="display:none">대답완료</div>
                    </a>
                </div>
                <!--e answer_icon-->
            </div>
            <!--e fv_Btncontx-->
        </div>
        <!--e fv_BtnBox-->

        <!--s videoBox-->
        <div class="videoBox" id="record_view">
            <video class="videoContent" preload="metadata" id="v_pc_1" style="-webkit-transform: rotateY(180deg); width:unset;" autoplay playsinline></video>
        </div>
        <?= csrf_field() ?>
    </div>
    <!--e #scontent-->

    <!--s 재촬영 모달-->
    <div id="retry_pop" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="big_num point b" id="five_sec">5</div>
                <div class="tlt mg_b20">재촬영하시겠습니까?</div>
                <div class="stxt">(남은횟수 <span id="remind_count">3</span>/3)</div>
            </div>
            <!--e pop_cont-->

            <!--s spopBtn-->
            <div class="spopBtn radius_none">
                <a href="javascript:" class="spop_btn01" id="retry_btn">재촬영</a>
                <a href="javascript:" class="spop_btn02 jy_interview_pr_pop_open2" id="send_btn">전송</a>
            </div>
            <!--e spopBtn-->
        </div>
        <!--e pop_Box-->
    </div>
    <!--s 재촬영 모달-->

    <!--s 인터뷰 모달-->
    <div class="interview_pop" id="tutorial_pop">
        <!--s interview_pop_cont-->
        <div class="interview_pop_cont">
            <!--s interview_pop_BtnBox-->
            <div class="interview_pop_BtnBox">
                <div class="interview_pop_chk_setBox">
                    <label for="interview_pop_chk_set">
                        <input type="checkbox" class="interview_pop_chk" id="interview_pop_chk_set"> <span class="white">다시보지않기</span>
                    </label>
                </div>

                <div class="interview_pop_close_btn"><a href="#n"><img src="/static/www/img/sub/fv_close.png"></a></div>
            </div>
            <!--e interview_pop_BtnBox-->
            <div class="img interview_tutorial"><img src="/static/www/img/sub/interview_pop.jpg"></div>
        </div>
        <!--e interview_pop_cont-->
    </div>
    <!--e 인터뷰 모달-->
</div>
<script src="https://www.webrtc-experiment.com/EBML.js"></script>
<script src="https://www.webrtc-experiment.com/DetectRTC.js"></script>
<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://www.webrtc-experiment.com/common.js"></script>
<script src="https://unpkg.com/@mattiasbuelens/web-streams-polyfill/dist/polyfill.min.js"></script>
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.869.0.min.js"></script>
<script src="https://cdn.socket.io/4.2.0/socket.io.min.js" integrity="sha384-PiBR5S00EtOj2Lto9Uu81cmoyZqR57XcOna1oAuVuIEjzj0wpqDVfD0JA9eXlRsj" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io-stream/0.8.0/socket.io-stream.js"></script>
<script type="text/javascript" src="/plugins/modal/moaModal.minified.js"></script>
<script type="text/javascript" src="/plugins/modal/Sweefty.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script>
    let audio_recorder;
    let speech_text = "";
    let audio = document.createElement('audio');
    let source = document.createElement('source');
    let video = document.querySelector('#v_pc_1');
    let question_list; //질문정보
    let now;
    let q_list_count = "";
    let com_q_list_count = 0;
    let device_check = false;
    let count = 30;
    let five_timer = "";
    let fiveCount_timer = "";
    let timer;
    let setSec = "<?= $data['startInterview'][0]['next_question']['repo_answer_time'] ?>";
    let re_count = 3;
    let app_type = "";
    let call_mode_on = 0;
    let nextBtnTimeout;
    let aParam = [];
    let repo_answer_time = <?= $data['startInterview'][0]['next_question']['repo_answer_time']?>;

    let constraints = {
        "audio": true,
        "video": {
            width: {
                ideal: $(window).width(),
                min: 640,
                max: 1920
            },
            height: {
                ideal: $(window).height(),
                min: 480,
                max: 1080
            },
            frameRate: {
                ideal: 24
            },
            facingMode: {
                ideal: 'user'
            }
        }
    };

    //인터뷰 시작전 허용버튼 클릭
    $("#start").on('click', function() {
        $('#interview_box').show();
        $('#before_interview').hide();
        if (getTutorial('tutorial') == 'false') {
            $('#tutorial_pop').hide();
        }
        deviceCheck();
        initAudio();
    });

    $('#On_btn').on('click', function() {
        $('#record_view').css('opacity', '0.2');
        $('#On_btn').hide();
        $('#Off_btn').show();
        $('#ai_btn').hide();
    });

    $('#Off_btn').on('click', function() {
        $('#record_view').css('opacity', 'unset');
        $('#Off_btn').hide();
        $('#On_btn').hide();
        $('#ai_btn').show();
        $('#v_pc_1').css('width', '90%');
        $('#v_pc_1').css('height', 'unset');
        $('#record_view').css('transform', 'none');
        $('#record_view').css('top', '20%');
        $('#record_view').draggable({
            'cancel': '.tbl',
            containment: 'parent',
            scroll: false,
            'disabled': false
        });
        $('.listen_gif').show();
    });

    $('#ai_btn').on('click', function() {
        $('#On_btn').show();
        $('#Off_btn').hide();
        $('#ai_btn').hide();
        $('#v_pc_1').css('width', 'unset');
        $('#v_pc_1').css('height', '100vh');
        $('#record_view').css('transform', 'translate(-50%,-50%)');
        $('#record_view').css('top', '50%');
        $('#record_view').css('inset', '');
        $('#record_view').css('width', '');
        $('#record_view').css('height', '');
        $('.listen_gif').hide();
        $('#record_view').draggable('disable');
    });
    $('#answer_btn').on('click', function() { //답변하기

        $('#answer_btn').hide();
        nextBtnTimeout = setTimeout(function() {
            $('#next_btn').show();
        }, 4000)

        $("#WaitText").hide();
        $("#onairCheck").show();
        $("#answer_text").show();
        if (app_type != "C" && app_type != "B") {
            $("#popRetry").show();
            $('#cancleInterview').show();
        }

        if (re_count < 1) {
            $('#popRetry').hide();
        }
        clearInterval(fiveCount_timer);

        setTimeout(function() {
            answerTimer("stop");
            answerTimer("start_n");
        });
        if (audio) audio.pause();

        recorder.stopRecording(video.pause());
        startRecording();
    });

    $('#next_btn').on('click', function() { //다음질문
        $('#popRetry').hide();
        $('#loadingIcon').show();
        if (app_type == "M" || app_type == "A") { //비즈가 아닐때
            $('#remind_count').text(re_count);
            if (re_count < 1) {
                audio_recorder.stopRecording();
                recorder.stopRecording(video.pause());
                answerTimer("stop");
                sendInterview();
            } else {
                fiveSec();
                answerTimer("stop");
                setTimeout(function() {
                    audio_recorder.stopRecording(stopAudioRecording(0));
                }, 500);
                setTimeout(function() {
                    recorder.stopRecording(stopRecording(0));
                }, 500);
                fnShowPop('retry_pop');
            }
        } else { //비즈이면,
            audio_recorder.stopRecording();
            recorder.stopRecording(video.pause());
            sendInterview();
        }
    });

    $('#popRetry').on('click', function() {
        audio_recorder.stopRecording();
        recorder.stopRecording(video.pause());
        clearTimeout(nextBtnTimeout);
        fnShowPop('retry_pop');
        fiveSec();
    });

    //팝업 5초카운트
    function fiveSec() {
        let five = 5;
        $('#five_sec').text(five);
        five_timer = setInterval(function() {
            five--;
            $('#five_sec').text(five);
            if (five == 0) {
                $('#five_sec').text(five);
                sendInterview();
                clearInterval(five_timer);
            }
        }, 1000);
    }

    //재촬영 5초카운트
    function fiveCount() {
        let five_cnt = 5;
        $('#wait_text').text(five_cnt);
        $('#WaitText').show();
        fiveCount_timer = setInterval(function() {
            five_cnt--;
            $('#wait_text').text(five_cnt);
            if (five_cnt == 0) {
                clearInterval(fiveCount_timer);
                $('#answer_btn').click();
                $('#WaitText').hide();
            }
        }, 1000);
    }

    //팝업 -> 재촬영버튼클릭
    $("#retry_btn").on('click', function() {
        fnHidePop('retry_pop');
        re_count--; // 재촬영 횟수
        clearInterval(five_timer);
        clearInterval(timer);
        clearTimeout(nextBtnTimeout);
        fiveCount();
        $('#remind_count').text(re_count);

        $("#onairCheck").hide();
        $("#answer_text").hide();
        $("#popRetry").hide();
        $('#next_btn').hide();
        $('#answer_btn').show();

        $('#loadingIcon').hide();

        speech_text = '';

        let question = "";
        let que_lang_type = "";
        let que_idx = "";

        for (i = 0; i < question_list.length; i++) {
            if (question_list[i]['idx'] == now) {
                question = question_list[i]["que_question"];
                que_lang_type = question_list[i]["que_lang_type"];
                que_idx = question_list[i]["que_idx"];
            }
        }
        naver_tts(question, que_idx, que_lang_type);

        if (com_q_list_count != 6) {
            $('#total_step').text(' ' + com_q_list_count + ' / ' + q_list_count);
        }

        startRecording();
    });

    $('#send_btn').on('click', function() {
        sendInterview();
        $('#loadingIcon').show();
    })


    function initAudio() { //오디오 권한 획득을 위해 동작하는 함수
        let playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(_ => {

                })
                .catch(error => {

                });
        }

        try {
            audio.appendChild(source);
            source.src = "";
            source.type = "audio/mp3";
            audio.load();
            audio.muted = false;
        } catch (error) {
            console.log(error);
        }
    }

    function deviceCheck() { //카메라와 마이크가 허용되었는지 확인하는 함수
        if (navigator.mediaDevices) {
            const setting = {
                audio: true,
                video: true,
            }
            navigator.mediaDevices.getUserMedia(setting)
                .then(stream => {
                    device_check = true;
                    audio.muted = false; //audio 권한 설정 해제
                    audio.play();
                    initSocket();
                    setTimeout(function() {
                        if (getTutorial('tutorial') == 'false') {
                            getQuestion();
                            $('#answer_btn').show();
                            startRecording();
                        }
                    }, 3000);
                })
                .catch((e) => {
                    if (e) {
                        if (e.name == 'OverconstrainedError') {
                            alert('지원하지 않는 카메라의 해상도입니다.\n\n사용하고 계신 카메라를 확인하시거나 고객센터로 문의바랍니다.')
                        } else {
                            console.log(e);
                            // alert('카메라, 마이크를 찾을수 없습니다.<br>기기를 확인해주세요. \n\n고객센터로 문의바랍니다.\n\n')
                            aParam['url'] = '/api/error/page/start/add';
                            aParam['applierIdx'] = <?= $data['startInterview'][0]['idx'] ?>;
                            aParam['errorTxt'] = e;
                            aParam['pullPage'] = '/Views/interview/start';
                            aParam['questionIdx'] = '0';
                            aParam['alertTxt'] = '서버 연결에 실패하였습니다. 잠시후에 시도해주세요. \n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.';
                            errorAjax(aParam);
                        }
                        // location.href = "/";
                        return;
                    }
                });
        }
    }

    function startRecording() { //동영상 녹화 함수
        captureCamera(function(camera) {
            video.muted = true;
            video.volume = 0;
            video.srcObject = camera;
            let recordingHints = {
                recorderType: MediaStreamRecorder,
                type: 'video',
                mimeType: 'video/webm; codecs=vp9',
                bitsPerSecond: 800000, //100KBbps
            };

            recorder = RecordRTC(camera, recordingHints);
            try {
                recorder.startRecording();
            } catch (error) {
                alert("사파리 버전이 맞지 않아 인터뷰 영상이 올바르게 저장되지 않습니다.\n버전 업데이트 후 진행해주세요.");
            }
            
            //s_22.04.29 igg 상호대화형기능을 위해 음성 녹음
            let audioRecordingHints = {
                mimeType: "audio/wav",
                recorderType: StereoAudioRecorder,
            };
            
            audio_recorder = RecordRTC(camera, audioRecordingHints);
            try {
                if ($('#onairCheck').css('display') !== 'none') {
                    audio_recorder.startRecording();
                }                
            } catch (error) {
                alert("인터뷰 음성이 올바르게 저장되지 않습니다.\n새로고침 후 다시 진행해주세요.");
            }
            //e_22.04.29 igg 상호대화형기능을 위해 음성 녹음
        });
    }

    function getQuestion() { //질문 가져오는 함수
        app_type = "<?= $data['startInterview'][0]['app_type']; ?>";
        question_list = $.parseJSON('<?= addslashes($data['reportResult']) ?>');
        q_list_count = "<?php echo count($data['startInterview'][0]['report_result']); ?>"
        com_q_list_count = "<?php echo (count($data['startInterview'][0]['video']) + 1) ?>";
        now = "<?= $data['startInterview'][0]['next_question']['idx']; ?>";
        $('#total_step').text(' ' + com_q_list_count + ' / ' + q_list_count);
        answerTimer("start_a");
        setWaitQuestion(now);
        $('#WaitText').css('top', $('#q_text').css('height'));
        $('#onairCheck').css('top', $('#q_text').css('height'));
        $('#answer_text').css('top', $('#q_text').css('height'));
    }


    function setWaitQuestion(idx) { //질문을 세팅하는 함수
        let question = "";
        let wait_time = "";
        let que_lang_type = "";
        let que_idx = "";
        let questionHtml = "";
        for (i = 0; i < question_list.length; i++) {
            if (question_list[i]['idx'] == idx) {
                question = question_list[i]["que_question"];
                wait_time = question_list[i]["repo_answer_time"];
                que_lang_type = question_list[i]["que_lang_type"];
                que_idx = question_list[i]["que_idx"];
                questionHtml = question_list[i]["que_question"];

                if (i == (question_list.length - 1)) {
                    question = question_list[i]["que_question"];
                    questionHtml = '마지막 질문입니다.<br>' + question_list[i]["que_question"];
                }
            }
        }
        $('#q_text').html(questionHtml);
        $('#loadingIcon').hide();
        naver_tts(question, que_idx, que_lang_type);
    }

    function naver_tts(questionText, questionIndex, que_lang_type) { //네이버 텍스트를 음성으로 읽어주는 함수
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $.ajax({
            type: 'POST',
            url: '/api/applier/file/upload/navertts',
            data: {
                '<?= csrf_token() ?>': emlCsrf.val(),
                ttsText: questionText,
                ttsIndex: questionIndex,
                ttsType: que_lang_type,
                'postCase': 'naver_tts',
                'memIdx': '<?= $data['session']['idx'] ?>',
                BackUrl: '/'
            },
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    source.src = "<?= $data['url']['media'] . $data['ttsPath'] ?>" + questionIndex + "_tts.mp3";
                    source.type = "audio/mp3" // or whatever
                    audio.load();
                    audio.muted = false;
                    audio.play();
                } else {
                    alert(data.messages);
                    return false;
                }
                return true;
            },
            error: function(e) {
                alert(e.responseJSON.messages +'('+e.responseJSON.status+')');
                return;
            }
        }); //ajax;
    }

    function sendInterview() {

        re_count = 3;
        let waitMin = parseInt((repo_answer_time % 3600) / 60).toString().padStart(2, '0');
        let waitSec = parseInt((repo_answer_time % 3600) % 60).toString().padStart(2, '0');

        clearInterval(five_timer);
        clearInterval(timer);
        $('#min_text').text(waitMin + ":" + waitSec);
        $('#remind_count').text(re_count);

        setTimeout(function() {
            audio_recorder.stopRecording(stopAudioRecording(1));
        }, 500);

        setTimeout(function() {
            recorder.stopRecording(stopRecording(1));
        }, 500);

        fnHidePop('retry_pop');

        com_q_list_count = Number(com_q_list_count) + 1;
        $('#next_btn').hide();

        if (com_q_list_count != Number(q_list_count) + 1) {
            $('#answer_text').hide();
            $('#onairCheck').hide();
            $('#popRetry').hide();
            $('#WaitText').show();
        } else {
            $('#WaitText').hide();
        }
        if (com_q_list_count != Number(q_list_count) + 1) {
            $('#total_step').text(' ' + com_q_list_count + ' / ' + q_list_count);
        }
    }

    function stopAudioRecording(state) {
        //0 -> 재시도 / 1 -> 영상전송
        if (state == 1) { //영상전송
            let index = "<?php echo $data['startInterview'][0]['idx'] ?>";
            let count;
            let qIdx;
            for (i = 0; i < question_list.length; i++) {
                if (question_list[i]['idx'] == now) {
                    qIdx = question_list[i]["que_idx"];
                    count = (i + 1);
                }
            }
            count = String(count).padStart(2, '0');
            let rand = Math.random().toString(36).substr(2, 11);
            let time = new Date().getTime();
            let fileName = index + '-record_' + count + '-' + qIdx + '-' + time + '-' + rand + '.wav';
            
            let blob = audio_recorder.getBlob();
            var nfile = new File([blob], fileName, {
                type: 'audio/wav'
            });

            var blobURL = URL.createObjectURL(nfile);
            console.log(blobURL);

            var stream = ss.createStream();
            ss(socket).emit('stream', stream, {
                name: fileName
            });
            ss.createBlobReadStream(nfile).pipe(stream);

        } else { //재시도
            //video.pause();
        }
    }

    function stopRecording(state) {
        //0 -> 재시도 / 1 -> 영상전송
        if (state == 1) { //영상전송
            video.pause();

            let blob = recorder.getBlob();
            let fileObject = new File([blob], {
                type: 'video/webm; codecs=vp9'
            });

            let index;
            let count;
            let qIdx;
            for (i = 0; i < question_list.length; i++) {
                if (question_list[i]['idx'] == now) {
                    qIdx = question_list[i]["que_idx"];
                    count = (i + 1);
                }
            }
            count = String(count).padStart(2, '0');
            index = "<?= $data['startInterview'][0]['idx'] ?>";
            let rand = Math.random().toString(36).substr(2, 11);
            let time = new Date().getTime();
            let fileName = index + '-record_' + count + '-' + qIdx + '-' + time + '-' + rand + '.webm';
            const emlCsrf = $("input[name='<?= csrf_token() ?>']");
            if (fileObject.size < 10) {
                aParam['url'] = '/api/error/page/applier/add';
                aParam['applierIdx'] = index;
                aParam['errorTxt'] = 'fileSize Error';
                aParam['pullPage'] = '/Views/interview/start';
                aParam['questionIdx'] = qIdx;
                aParam['alertTxt'] = "영상 업로드에 오류가 생겼습니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 '하이버프'로 문의 부탁드립니다.";
                errorAjax(aParam);

            } else {
                let data = {
                    source: fileObject,
                    name: fileName
                };

                socket.emit('upload', data);
            }

        } else { //재시도
            video.pause();
        }
    }

    function captureCamera(callback) { //카메라 연결확인 함수
        navigator.mediaDevices
            .getUserMedia({
                video: constraints,
                audio: true,
            })
            .then(function(camera) {
                callback(camera);
            })
            .catch(function(error) {
                alert('카메라를 인식할 수 없습니다.\n\n카메라 연결 상태를 확인해주세요.');
            });
    }

    function initSocket() {
        socket = io.connect('<?= $data['url']['mediaFull'] ?>', {
            cors: {
                origin: '*'
            },
            transports: ["websocket"]
        });

        socket.on('connect', function() {
            console.log("socket connected");
        });

        socket.on('connect_error', function() {
            if (audio) audio.pause();
            alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
        });

        socket.on('complete', (data) => {
            let count;
            let index;
            let qIdx;
            let repoIdx;
            for (i = 0; i < question_list.length; i++) {
                if (question_list[i]['idx'] == now) {
                    qIdx = question_list[i]["que_idx"];
                    count = (i + 1);
                    repoIdx = question_list[i]['idx'];
                }
            }
            count = String(count).padStart(2, '0');
            index = "<?= $data['startInterview'][0]['idx'] ?>";
            let time = data.split('-')[3].split('.')[0];
            let rand = data.split('-')[4].split('.')[0];
            const emlCsrf = $("input[name='<?= csrf_token() ?>']");

            if (data == null || data == "") {
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '/api/applier/file/upload/video',
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                    index: index,
                    count: count,
                    q_idx: qIdx,
                    time: time,
                    rand: rand,
                    repoIdx: repoIdx,
                    'postCase': 'video_upload',
                    'memIdx': '<?= $data['session']['idx'] ?>',
                    BackUrl: '/',
                    speech_text: speech_text
                },
                success: function(data) {
                    emlCsrf.val(data.code.token);
                    if (data.status == 200) {
                        now = data.All[0].next_question.idx;
                        setWaitQuestion(now);
                        startRecording();
                        speech_text = '';
                        setTimeout(function() {
                            answerTimer("stop");
                            answerTimer("start_a");
                        }, 500);
                        setTimeout(function() {
                            $('#answer_btn').show();
                        }, 4000);

                    } else if (data.status == 201) {
                        alert2(data.messages);
                        setTimeout(function() {
                            if ("<?= $data['applicantIdx'] ?>") {
                                location.href = '/linkInterview/<?= $data['applicantIdx'] ?>';
                            } else {
                                location.href = "/interview/end/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>";
                            }
                        }, 2000);
                    } else {
                        alert(data.messages);
                        return false;
                    }
                    return true;
                },
                error: function(e) {
                    alert(e.responseJSON.messages +'('+e.responseJSON.status+')');
                    return;
                }
            }); //ajax;
        });

        socket.on('recognize', (data) => {
            if (audio_recorder.state !== 'stopped') {
                speech_text = speech_text + ' ' + data;
                console.log(speech_text);
            }
        });

        socket.on('disconnect', function() {
            alert("서버 연결이 끊어졌습니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");

            location.reload();
        });
    }

    function errorAjax(param) {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $.ajax({
            type: 'POST',
            url: param['url'],
            data: {
                '<?= csrf_token() ?>': emlCsrf.val(),
                applierIdx: param['applierIdx'],
                errorTxt: param['errorTxt'],
                pullPage: param['pullPage'],
                questionIdx: param['questionIdx'],
            },
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    alert(param['alertTxt']);

                    location.reload();
                } else {
                    alert(data.messages);
                    return false;
                }
                return true;
            },
            error: function(e) {
                console.log(e);
                alert(e.responseJSON.messages +'('+e.responseJSON.status+')');
                return;
            }
        }); //ajax;
    }

    function answerTimer(time) {
        count = setSec;
        let waitMin = parseInt((count % 3600) / 60).toString().padStart(2, '0');
        let waitSec = parseInt((count % 3600) % 60).toString().padStart(2, '0');
        let praticeSec = 30;
        if (time == "stop") {
            $('#min_text').text(waitMin + ":" + waitSec);
            clearInterval(timer);
        } else {
            timer = setInterval(function() {
                $('#wait_text').text(praticeSec);
                $('#min_text').text(waitMin + ":" + waitSec.toString().padStart(2, '0'));
                let waitCss = $('#WaitText').css('display');
                if (waitCss == 'none') {
                    if (waitSec == 0) {
                        if (waitMin > 0) {
                            waitMin = parseInt(((waitMin - 1) % 3600) / 60).toString().padStart(2, '0');
                            waitSec = 60;
                            $('#min_text').text(waitMin + ":" + waitSec.toString().padStart(2, '0'));
                            $('#wait_text').text(praticeSec);
                        } else {
                            clearInterval(timer);
                            if (time == "start_a") {
                                $('#answer_btn').click();
                            } else if (time == "start_n") {
                                $('#next_btn').click();
                            }
                        }
                    }
                    waitSec--;
                } else {
                    if (praticeSec == 0) {
                        clearInterval(timer);
                        if (time == "start_a") {
                            $('#answer_btn').click();
                        } else if (time == "start_n") {
                            $('#next_btn').click();
                        }
                    }
                    praticeSec--;
                }
            }, 1000);
        }
    }

    $("#cancleInterview").on('click', function() {
        if (!confirm('면접을 종료 하시겠습니까?')) {
            return;
        } else {
            location.href = "/";
        }
    });

    function setTutorial(name, value, exp) {
        let date = new Date();
        date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
        document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
    };

    function getTutorial(name) {
        let value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return value ? value[2] : null;
    };

    $('.interview_pop_close_btn').on('click', function() {
        if ($('#interview_pop_chk_set').is(':checked')) {
            setTutorial('tutorial', 'false', '7');
            $('#tutorial_pop').hide();
            $('#answer_btn').show();
        } else {
            getQuestion();
            startRecording();
            $('#tutorial_pop').hide();
            $('#answer_btn').show();
        }
    });


    let videoH = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--videoH', videoH+'px');
</script>

<style>
    .face_vdoBox {
        height: 100vh;
        /* Use vh as a fallback for browsers that do not support Custom Properties */
        height: calc(var(--videoH, 1vh) * 100);
    }

    .face_vdoBox .fv_BtnBox:after {
        height: unset;
    }
</style>