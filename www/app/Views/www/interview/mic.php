<!--s #scontent-->
<div id="start_mic" class="ht100">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="/interview/profile/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>">
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
            <!--s bigtlt-->
            <div class="bigtlt mg_b40">
                인터뷰 시작 전,<br /><br />
                <span class="point b">목소리</span>가 잘 인식되는지<br />
                확인해 볼게요!
            </div>
            <!--e bigtlt-->
            <form action="/interview/skipMicAction" method="POST" id="skip">
                <input name="applyIdx" value="<?= $data['applyIdx'] ?>" type="hidden">
                <input name="memIdx" value="<?= $data['memIdx'] ?>" type="hidden">
                <input name="process" id="process" value="2" type="hidden">
                <input name="postCase" value="skipMic" type="hidden">
                <input name="backUrl" value="/" type="hidden">
                <?= csrf_field() ?>
            </form>
            <!--s itv_pr_gray_txt--><a href="javascript:" class="itv_pr_gray_txt a_line skipMic txtColorDgray">다음에 할게요</a>
            <!--e itv_pr_gray_txt-->

            <div class="icon mic_icon01_1"><img src="/static/www/img/sub/mic_ck01_icon.png"></div>

            <!--s BtnBox-->
            <div class="BtnBox" id="mic_start_btn">
                <a href="javascript:" class="btn btn01 wps_100"><span class="faq_mic_icon"><img src="/static/www/img/sub/mic_icon.png"></span> 음성인식 시작</a>
            </div>
            <!--e BtnBox-->
        </div>
        <!--e cntBpx-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<!--s #scontent-->
<div id="ck_mic" class="ht100" style="display:none">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <a href="javascript:" class="top_gray_txtlink gray_txtlink skipMic txtColorDgray">건너뛰기</a>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom c ht100">
        <!--s cntBpx-->
        <div class="cntBpx">
            <!--s bigtlt-->
            <div class="bigtlt mg_b40">
                큰소리로 따라해보세요<br />
                <span class="point b" id="micSen">“반갑습니다! 김세민입니다”</span>
            </div>
            <!--e bigtlt-->

            <div class="icon mic_icon02_1"><img src="/static/www/img/sub/mic_ck02_icon1.png"></div>
            <div class="mic_num point main-text">10</div>
            <svg preserveAspectRatio="none" id="visualizer" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100px" height="10px" style="background-color:#fff;">
                <defs>
                    <mask id="mask">
                        <g id="maskGroup"></g>
                    </mask>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#db6247;stop-opacity:1" />
                        <stop offset="40%" style="stop-color:#f6e5d1;stop-opacity:1" />
                        <stop offset="60%" style="stop-color:#5c79c7;stop-opacity:1" />
                        <stop offset="85%" style="stop-color:#b758c0;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect x="0" y="0" width="100px" height="100px" fill="url(#gradient)" mask="url(#mask)"></rect>
            </svg>
            <!--s icon-->
            <div class="icon mic_icon02_2">
                <div class="mic_icon02_2_1"><img src="/static/www/img/sub/mic_ck02_icon2_1.png"></div>
                <div class="mic_icon02_2_2"><img src="/static/www/img/sub/mic_ck02_icon2_2.png"></div>
                <div class="mic_icon02_2_3"><img src="/static/www/img/sub/mic_ck02_icon2_3.png"></div>
            </div>
            <!--e icon-->

            <!--s BtnBox-->
            <div class="BtnBox">
                <a href="javascript:" id="button" class="btn btn01 wps_100">다음</a>
            </div>
            <!--e BtnBox-->
        </div>
        <!--e cntBpx-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<!--s #scontent-->
<div id="mic_cont2" class="ht100" style="display:none">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:window.history.back();">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <a href="javascript:" class="top_gray_txtlink gray_txtlink skipMic txtColorDgray">건너뛰기</a>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom c ht100">
        <!--s cntBpx-->
        <div class="cntBpx">
            <!--s bigtlt-->
            <div class="bigtlt mg_b40" id="failed_speech">
                <span class="point b"></span>
                <br /><br />큰소리로 따라해보세요<br />
                <div class="b point">“ 안녕하세요! <?= $data['session']['name'] ?>입니다 ”</div>
            </div>
            <!--e bigtlt-->

            <div class="icon mic_icon02_1"><img src="/static/www/img/sub/mic_ck02_icon1.png"></div>

            <!--s BtnBox-->
            <div class="BtnBox">
                <a href="/interview/mic/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>" class="btn btn01 wps_100">재시도</a>
            </div>
            <!--e BtnBox-->
        </div>
        <!--e cntBpx-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->

<script>
    let timerInterval;
    let success = false;
    let base64AudioFormat;
    let permission = false;
    let audioStream;
    let chunks;
    let device_check = false;
    let mediaRecorder;
    $("#mic_start_btn").on('click', function() {
        deviceCheck();
    });

    $("#button").on('click', function() {
        if ($("#visualizer").css("visibility") == "hidden") {
            return false;
        }
        mediaRecorder.stop();
    });

    function deviceCheck() {
        if (navigator.mediaDevices) {
            const constraints = {
                audio: true
            }
            navigator.mediaDevices.getUserMedia(constraints)
                .then(stream => {
                    device_check = true;
                    let paths = document.getElementsByTagName('path');
                    let visualizer = document.getElementById('visualizer');
                    let mask = visualizer.getElementById('mask');
                    let AudioContext;
                    let audioContent;
                    let start = false;
                    let path;

                    let soundAllowed = function(stream) {
                        permission = true;
                        audioStream = audioContent.createMediaStreamSource(stream);
                        let analyser = audioContent.createAnalyser();
                        let fftSize = 1024;
                        analyser.fftSize = fftSize;
                        audioStream.connect(analyser);
                        let bufferLength = analyser.frequencyBinCount;
                        let frequencyArray = new Uint8Array(bufferLength);
                        visualizer.setAttribute('viewBox', '0 0 255 255');

                        for (let i = 0; i < 255; i++) {
                            path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                            path.setAttribute('stroke-dasharray', '4,1');
                            mask.appendChild(path);
                        }
                        let doDraw = function() {
                            requestAnimationFrame(doDraw);
                            if (start) {
                                analyser.getByteFrequencyData(frequencyArray);
                                let adjustedLength;
                                for (let i = 0; i < 255; i++) {
                                    adjustedLength = Math.floor(frequencyArray[i]) - (Math.floor(frequencyArray[i]) % 5);
                                    paths[i].setAttribute('d', 'M ' + (i) + ',255 l 0,-' + adjustedLength);
                                }
                            } else {
                                for (let i = 0; i < 255; i++) {
                                    paths[i].setAttribute('d', 'M ' + (i) + ',255 l 0,-' + 0);
                                }
                            }
                        }
                        doDraw();
                        //audio recording
                        mediaRecorder = new MediaRecorder(stream);
                        mediaRecorder.start();
                        chunks = [];
                        mediaRecorder.ondataavailable = function(e) {
                            chunks.push(e.data);
                            checkSentence();
                            clearInterval(timerInterval);
                        }
                    }

                    let soundNotAllowed = function(error) {
                        alert("마이크 연결을 확인해주세요.");
                    }

                    $('#start_mic').hide();
                    $('#ck_mic').show();
                    if (this.innerHTML == "제출하기") {
                        mediaRecorder.stop();
                    } else {
                        $(".main-text").text("10");
                        sentenceTimer();
                        if ("<?= $data['session']['name'] ?>" == "" || "<?= $data['session']['name'] ?>" == null) {
                            $("#micSen").html('<span>"안녕하세요. 마이크테스트입니다."</span>');
                        } else {
                            $("#micSen").html('<span>"안녕하세요. <?= $data['session']['name'] ?> 입니다."</span>');
                        }

                        if (screen.width > 768) {
                            $(".button-container").css("margin-top", "-450px");
                        } else {
                            $(".button-container").css("margin-top", "-450px");
                        }

                        if (!permission) {
                            navigator.mediaDevices.getUserMedia({
                                    audio: true
                                })
                                .then(soundAllowed)
                                .catch(soundNotAllowed);

                            AudioContext = window.AudioContext || window.webkitAudioContext;
                            audioContent = new AudioContext();
                        }
                        start = true;
                    }

                    $('#mic_start_btn').attr('src', '/share/img/sub/mic_icon01_able.png');
                })
                .catch(error => {
                    device_check = false;
                    console.log(error);
                    $('#mic_start_btn').attr('src', '/share/img/sub/mic_icon01_disable.png');
                })
        }
    }

    function sentenceTimer() {
        timerInterval = setInterval(() => {
            let countTime = parseInt($(".main-text").text());
            countTime--;
            $(".main-text").text(countTime);
            if (countTime <= 0) {
                clearInterval(timerInterval);
                mediaRecorder.stop();
            }
        }, 1000);
    }

    function getAjax(params) {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $.ajax({
            type: 'POST',
            url: "/api/applier/mic/upload/check",
            data: params,
            contentType: false,
            processData: false,
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    audioStream.disconnect(); //audio stream disconnect
                    permission = false;
                    alert2(data.messages);
                    setTimeout(function() {
                        if (("<?= $data['recIdx'] ?>" != "" && "<?= $data['recIdx'] ?>" != null)) {
                            location.href = '/interview/start/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>';
                        } else {
                            if("<?= $data['interIdx'] ?>" != "" && "<?= $data['interIdx'] ?>" != null){
                                location.href = '/interview/start/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>';
                            } else{
                                location.href = '/interview/timer/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>';
                            }
                        }
                    }, 2000);
                    return true;
                } else if (data.status == 503) {
                    alert(data.messages);
                    return false;
                } else if (data.status == 201) {
                    $("#mic_cont2").show();
                    $("#ck_mic").hide();
                    $(".mic_cont").hide();
                    if (data.recog.speech_to_text == "" || data.recog.speech_to_text == null) {
                        data.recog.speech_to_text = "아무 음성도 인식되지 않았습니다.";
                    }
                    $("#failed_speech span").text('테스트결과 : ' + data.recog.speech_to_text);
                    return false;
                } else if (data.status == 500) {
                    alert(data.messages);
                    location.reload();
                }
                return true;
            },
            error: function(e) {
                alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                return;
            },
            beforeSend: function() {
                // alert('잠시만 기다려주세요')
                // $('#button').attr('href','');
                $('#button').css('background', '#ddd');
                $('#button').css('border', '1px solid #ddd');
                $('.main-text').text('잠시만 기다려주세요');
                //messages:'<div class="loading"><span><img src="/static/www/img/sub/fv_loading_icon.png"></span></div>'
            }

        }) //ajax;
    }

    function checkSentence() {

        $("#visualizer").css("visibility", "hidden");
        let checkDevice;
        const blob = new Blob(chunks, {
            'type': 'audio/wav; codecs=0'
        });
        if (navigator.maxTouchPoints > 1) {
            checkDevice = 1;
        } else {
            checkDevice = 2;
        }
        chunks = [];
        let Micdata = new FormData();
        let micTest = "";
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");

        Micdata.append('file', blob);
        Micdata.append('postCase', "mic_file");
        Micdata.append('checkDevice', checkDevice);
        Micdata.append('applyIdx', "<?= $data['applyIdx']; ?>");
        Micdata.append('csrf_highbuff', emlCsrf.val());
        Micdata.append('memIdx', '<?= $data['session']['idx'] ?>');

        if ("<?= $data['session']["name"] ?>" == "" || "<?= $data['session']["name"] ?>" == null) {
            Micdata.append('word', "마이크테스트");
        } else {
            Micdata.append('word', "<?= $data['session']["name"] ?>");
        }
        getAjax(Micdata);
    }

    $('.skipMic').on('click', function() {
        $('#skip').submit();
    })
</script>