<!--s #scontent-->
<div id="scontent">
    <input type="button" value="stopRecording" onclick="stopRecording()"/>
    <!--s face_vdoBox-->
    <div class="face_vdoBox">
        <!--s txtBox-->
        <div class="txtBox c">
            <div class="txt" id="text_">
                얼굴인식을 준비중입니다. <br /> 잠시만 기다려주세요.
            </div>
            <div class="txt" id="text_2" style="display:none">
                3
            </div>
        </div>
        <!--e txtBox-->

        <!--s fv_BtnBox-->
        <div class="fv_BtnBox">
            <!--s fv_Btncontx-->
            <div class="fv_Btncont">
                <!--s fv_back-->
                <div class="fv_iconBtn fv_back">
                    <a href="javascript:window.history.back();">
                        <div class="icon"><img src="/static/www/img/sub/fv_back_icon.png"></div>
                        <div class="txt">뒤로가기</div>
                    </a>
                </div>
                <!--e fv_back-->

                <!--s play_icon-->
                <div class="play_icon" id="btn_shot" style="display:none;">
                    <div class="play"></div><!-- 다시 찍어야할때 숨김처리 -->
                    <div class="play_txt" id="btn_reshot" style="display:none">다시<br />찍기</div> <!-- 다시 찍어야할때 나타나게 -->
                </div>
                <!--e play_icon-->

                <!--s fv_next-->
                <div class="fv_iconBtn fv_ok" id="btn_next" style="display:none">
                    <a href="javascript:">
                        <div class="icon"><img src="/static/www/img/sub/fv_ok_icon.png"></div>
                        <div class="txt">확인</div>
                    </a>
                </div>
                <!--e fv_back-->
            </div>
            <!--e fv_Btncontx-->
        </div>
        <!--e fv_BtnBox-->

        <!--s videoBox-->
        <div class="videoBox canvas-wrapper">
            <canvas id="_canvas" class="output_canvas" style="width:500px; height:500px"></canvas>
            <img id="photo" class="videoContent" style="display:none;" /> <!-- 사진이 찍힌 이미지 보여주기-->
            <video class="videoContent input_video" preload="metadata" id="v_pc_1" autoplay playsinline style="-webkit-transform: rotateY(180deg); width:unset; height:500px"></video>
        </div>
        <!--e videoBox-->
        <div id="btn-start-recording" style="display: none;">
            <button id="btn-start-recording">Start Recording</button>
        </div>
        <?= csrf_field() ?>
        <!-- <div id="scatter-gl-container"></div> -->
    </div>
    <!--e face_vdoBox-->
</div>

<script src="https://cdn.socket.io/4.2.0/socket.io.min.js" integrity="sha384-PiBR5S00EtOj2Lto9Uu81cmoyZqR57XcOna1oAuVuIEjzj0wpqDVfD0JA9eXlRsj" crossorigin="anonymous"></script>
<script src="https://www.webrtc-experiment.com/EBML.js"></script>
<script src="https://www.webrtc-experiment.com/DetectRTC.js"></script>
<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://www.webrtc-experiment.com/common.js"></script>

<!-- <script src="https://unpkg.com/@tensorflow/tfjs-core@2.4.0/dist/tf-core.js"></script> -->
<!-- <script src="https://unpkg.com/@tensorflow/tfjs-converter@2.4.0/dist/tf-converter.js"></script> -->
<!-- <script src="https://unpkg.com/@tensorflow/tfjs-backend-webgl@2.4.0/dist/tf-backend-webgl.js"></script> -->
<!-- <script src="https://unpkg.com/@tensorflow-models/face-landmarks-detection@0.0.1/dist/face-landmarks-detection.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/facemesh"></script> -->


<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-core@2.6.0/dist/tf-core.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/facemesh@0.0.5/dist/facemesh.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-backend-wasm@2.6.0/dist/tf-backend-wasm.min.js"></script>
<script src="https://unpkg.com/@tensorflow/tfjs-converter@2.6.0/dist/tf-converter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/stats.js@0.17.0/build/stats.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.7.3/dat.gui.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/triangulation@0.0.2/index.min.js"></script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script> -->

<!-- Load three.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/three@0.106.2/build/three.min.js"></script> -->
<!-- Load scatter-gl.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/scatter-gl@0.0.1/lib/scatter-gl.min.js"></script> -->

<script src="/plugins/tfjs/tf-triangulation.js"></script>
<script src="<?= $data['url']['menu'] ?>/plugins/bowser/bundled.js"></script>


<!-- <script>
    //jQuery 셀렉터는 이벤트를 가져오지 못합니다.
    const video = document.getElementById("v_pc_1");
    const canvas = document.getElementById("_canvas");
    const photo = document.querySelector('#photo'); //사진 이미지 변수
    let _winWidth = $("#v_pc_1").innerWidth();
    let _winHeight = $("#v_pc_1").innerHeight();
    let timer;
    let count = 3;
    let reshot = false;
    let shot_btn_ck = true;
    let changeImg = true;
    let info = bowser.parse(window.navigator.userAgent);

    let scaleSet = true;

    let constraints = { //화면 크기
        width: {
            ideal: _winWidth,
            min: 640,
            max: 1920
        },
        height: {
            ideal: _winHeight,
            min: 480,
            max: 1080
        },
        frameRate: {
            ideal: 30,
            max: 30
        },
        facingMode: {
            ideal: 'user'
        }
    };

    checkDevice();
    bizCheck();

    $(document).ready(function() {
        $("#btn-start-recording").trigger("click");
    });

    const setupCamera = () => {
        navigator.mediaDevices
            .getUserMedia({
                video: constraints,
                audio: false,
            })
            .then((stream) => {
                video.srcObject = stream;
                initSocket();
            })

            .catch((e) => {
                if (e) {
                    if (e.name == 'OverconstrainedError') {
                        alert('지원하지 않는 카메라의 해상도입니다.\n\n사용하고 계신 카메라를 확인하시거나 고객센터로 문의바랍니다.')
                    } else {
                        console.log(e);
                        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
                        $.ajax({ //db에 에러로그 쌓고 텔레그램 보내는 ajax
                            type: 'POST',
                            url: '/api/error/page/photo/add',
                            data: {
                                '<?= csrf_token() ?>': emlCsrf.val(),
                                applierIdx: <?= $data['applyIdx'] ?>,
                                errorTxt: e,
                                pullPage: '/Views/interview/photo',
                            },
                            success: function(data) {
                                emlCsrf.val(data.code.token);
                                if (data.status == 200) {
                                    alert("서버 연결에 실패하였습니다. 잠시후에 시도해주세요. \n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");

                                    location.reload();
                                } else {
                                    alert(data.messages);
                                    return false;
                                }
                                return true;
                            },
                            error: function(e) {
                                console.log(e);
                                alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                                return;
                            }
                        }) //ajax;
                    }
                    // location.href = "/";
                    return;
                }
            });
    };

    document.getElementById('btn-start-recording').onclick = function() {
        setupCamera(function(camera) {
            video.muted = true;
            video.volume = 0;
            video.srcObject = camera;
            let recordingHints = {
                type: 'video',
                mimeType: 'video/webm;codecs=vp8',
                frameRate: 15
            };
        });
    };

    function initSocket() {

        socket = io.connect('<?= $data['url']['mediaFull'] ?>', {
            cors: {
                origin: '*'
            }
        });

        socket.on('connect', function() {
            console.log("socket connected");

        });

        socket.on('connect_error', function() {
            alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
            return false;
        });

        socket.on('complete_thumb', (data) => {
            let aParam = {
                'type': 'complete_thumb',
                'method': 'POST',
                'url': '/api/applier/file/upload/thumb/add',
                'fileData': data
            };
            getAjax(aParam);
        });
        socket.on('disconnect', function() {
            alert("서버 연결이 끊어졌습니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
            return false;
        });
    }

    const detectFaces = async () => { //미소인식 함수

        const prediction = await model.estimateFaces({
            input: video,
            returnTensors: false,
            flipHorizontal: false,
            predictIrises: false
        });

        let w = video.videoWidth;
        let h = video.videoHeight;

        //face detect
        if (prediction.length > 0) {
            let mesh = prediction[0].scaledMesh;
            $('#text_').html("프로필 저장을 위해 촬영을 진행합니다. <br /> 프로필 촬영 전 한번 웃어 볼까요?");
            //smile check
            let d1 = distance(prediction[0].annotations["noseBottom"][0], prediction[0].annotations["lipsUpperOuter"][5]); //인중거리
            let d2 = distance(prediction[0].annotations["lipsUpperInner"][5], prediction[0].annotations["lipsLowerInner"][5]); //입벌리는거리
            let p1 = (d2 / (2 * d1)) * 0.2; //입벌리는거 체크 가중치 20%

            let result = [];
            let left_upper_lip = prediction[0].annotations["lipsUpperOuter"][0][1];
            let right_upper_lip = prediction[0].annotations["lipsUpperOuter"][10][1];
            for (i = 0; i < prediction[0].annotations["lipsUpperOuter"].length; i++) {
                if (prediction[0].annotations["lipsUpperOuter"][i][1] > left_upper_lip && prediction[0].annotations["lipsUpperOuter"][i][1] > right_upper_lip) {
                    result.push(i);
                }
            }
            for (i = 0; i < prediction[0].annotations["lipsUpperInner"].length; i++) {
                if (prediction[0].annotations["lipsUpperInner"][i][1] > left_upper_lip && prediction[0].annotations["lipsUpperInner"][i][1] > right_upper_lip) {
                    result.push(i);
                }
            }
            for (i = 0; i < prediction[0].annotations["lipsLowerInner"].length; i++) {
                if (prediction[0].annotations["lipsLowerInner"][i][1] > left_upper_lip && prediction[0].annotations["lipsLowerInner"][i][1] > right_upper_lip) {
                    result.push(i);
                }
            }
            for (i = 0; i < prediction[0].annotations["lipsLowerOuter"].length; i++) {
                if (prediction[0].annotations["lipsLowerOuter"][i][1] > left_upper_lip && prediction[0].annotations["lipsLowerOuter"][i][1] > right_upper_lip) {
                    result.push(i);
                }
            }
            let lips_sum = prediction[0].annotations["lipsLowerOuter"].length + prediction[0].annotations["lipsLowerInner"].length + prediction[0].annotations["lipsUpperInner"].length + prediction[0].annotations["lipsUpperOuter"].length;
            let p2 = (result.length / lips_sum) * 0.4; //입의 방향 체크 가중치 40% 

            let dlc = distance(prediction[0].annotations["lipsUpperOuter"][0], mesh[58]); //왼쪽입과 볼사이의 거리
            let drc = distance(prediction[0].annotations["lipsUpperOuter"][10], mesh[288]); //오른쪽입과 볼사이의 거리
            let dlj = distance(prediction[0].annotations["lipsUpperOuter"][0], mesh[149]); //왼쪽입과 턱사이의 거리
            let drj = distance(prediction[0].annotations["lipsUpperOuter"][10], mesh[378]); //오른쪽입과 턱사이의 거리
            let p3 = ((dlj + drj) / (dlj + drj + dlc + drc)) * 0.4; //입의 위치 체크 가중치 40%

            if (shot_btn_ck) {
                $('#btn_shot').show();
                shot_btn_ck = false;
            }

            if (p1 + p2 + p3 > 0.5) {
                // clearInterval(timer);
                // $('#btn_shot').click();
            }
        } else {
            $('#text_').html("프로필 저장을 위해 촬영을 진행합니다. <br /> 얼굴을 화면 중앙에 인식 시켜주세요.");
            if (shot_btn_ck) {
                $('#btn_shot').show();
                shot_btn_ck = false;
            }
        }
        await tf.nextFrame();
    };

    //얼굴인식 함수 실행시키는 함수
    video.addEventListener("loadeddata", async () => {
        model = await faceLandmarksDetection.load(faceLandmarksDetection.SupportedPackages.mediapipeFacemesh);
        try {
            timer = setInterval(detectFaces, 50);
        } catch (error) {
            alert('얼굴 인식 기능이 작동하지 않습니다. \n\n고객센터로 문의바랍니다.\n\n');
        }
    });

    function distance(a, b) {
        return Math.sqrt(Math.pow(a[0] - b[0], 2) + Math.pow(a[1] - b[1], 2));
    }

    function setup() { //카운터가 돌아가는 함수
        count--;
        $('#text_2').text(count);
        if (count < 1) {
            if (changeImg == true) {
                takePicture();
                scaleSet = false;
            }
            clearInterval(setupInterval);

            $('#btn_shot').show();
            $('#btn_reshot').show();
            $('#btn_next').show();
            $('#v_pc_1').hide();
            $('#photo').show();
            $('#text_2').text("프로필 촬영이 완료되었습니다.");

        }
    }

    function takePicture() {
        changeImg = false;
        let context = canvas.getContext('2d');
        if (scaleSet != false) {
            $('#_canvas').attr('width', $("#v_pc_1").width());
            $('#_canvas').attr('height', $("#v_pc_1").height());

            if (info.os.name == 'Android') {
                $('#_canvas').attr('width', window.innerWidth);
            } else if (info.os.name == "iOS") {
                $('#_canvas').attr('width', window.innerWidth);
            }

            context.scale(-1, 1);
            context.translate(-canvas.width, 0);
        }
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        let data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        photo.style.display = "";
    }


    function getFileName(fields, fileExtension) {
        let d = new Date();
        let index = "<?= $data['applyIdx'] ?>";
        let rand = Math.random().toString(36).substr(2, 11);
        let times = d.getTime();
        return index + "-" + fields + "-" + times + '-' + rand + '.' + fileExtension;
    }

    $('#btn_shot').on("click", function(ev) {
        ev.preventDefault();
        clearInterval(timer);
        if (reshot == false) {
            clearInterval(timer);
            if (count > 0) {
                setupInterval = setInterval(setup, 1500);
                $('#btn_shot').hide();
                $('#btn_next').hide();
                $('#text_').hide();
                $('#v_pc_1').show();
                $('#photo').hide();
                $('#text_2').show();

                reshot = true;
            }
        } else {
            clearInterval(timer);
            count = 3;
            changeImg = true;
            if (count > 0) {
                setupInterval = setInterval(setup, 1500);
                $('#btn_shot').hide();
                $('#btn_next').hide();
                $('#text_').hide();
                $('#v_pc_1').show();
                $('#photo').hide();
                $('#text_2').show();
                $('#text_2').text(count);

            }
        }
    })

    $('#btn_next').on("click", function(e) {
        e.preventDefault();
        const filename = getFileName("thumbnail", "png");
        fetch(photo.src)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], filename, {
                    type: 'image/png'
                });
                const data = {
                    source: file,
                    name: filename,
                    size: file.size,
                };
                socket.emit('thumbnail', data);
            });

    });

    function getAjax(params) {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        let data = {};
        if (!params['type']) {
            return false;
        }
        if (params['type'] == 'complete_thumb') {

            data = {
                '<?= csrf_token() ?>': emlCsrf.val(),
                'fileOrgName': params['fileData']['name'],
                'fileSaveName': params['fileData']['filePath'].substr(1),
                'fileSize': params['fileData']['size'],
                'fileType': 'A',
                'postCase': 'file_write',
                'memIdx': '<?= $data['session']['idx'] ?>',
                'applyIdx': '<?= $data['applyIdx'] ?>'
            };
        }
        $.ajax({
            type: params['method'],
            url: params['url'],
            data: data,
            success: function(data) {
                emlCsrf.val(data.code.token);
                if (data.status == 200) {
                    if (params['type'] = 'complete_thumb') {
                        location.href = "/interview/profile/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>?file=" + data.EnfileIdx;
                    }
                } else {
                    alert(data.messages);
                    return false;
                }
                return true;
            },
            error: function(e) {
                alert(`${e.responseJSON.messages} (${e.responseJSON.status})`);
                return;
            }
        }) //ajax;
    }

    function checkDevice() {
        if (info.platform.type == 'desktop') {
            if (info.os.name == 'Windows') {
                if (info.browser.name != "Chrome") {
                    alert('Windows 환경에서는 Chrome 브라우저를 이용해주세요.');
                    location.href = "/";
                }
            } else if (info.os.name == "macOS") {
                if (info.browser.name != "Safari") {
                    alert("Mac 환경에서는 Safari 브라우저를 이용해주세요.");
                    location.href = "/";
                }
            }
        } else { //모바일
            if (info.os.name == 'Android') {
                if (info.browser.name != "Chrome") {
                    // alert('ANDROID 환경에서는 Chrome 브라우저를 이용해주세요.');
                    // location.href = "/";
                }
            } else if (info.os.name == "iOS") {
                // if (info.browser.name != "Safari") {
                //     alert("IOS 환경에서는 Safari 브라우저를 이용해주세요.");
                //     location.href = "/";
                // }
            }

        }
    }

    function bizCheck() {
        if ("<?= $data['recIdx'] ?>" != 0 && "<?= $data['recIdx'] ?>" != null && "<?= $data['recIdx'] ?>" != "") {
            $('.fv_back').hide();
        }
    }

    let videoH = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--videoH', `${videoH}px`);
</script> -->

<script>
    let recorder;

    function isMobile() {
        const isAndroid = /Android/i.test(navigator.userAgent);
        const isiOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
        return isAndroid || isiOS;
    }

    function drawPath(ctx, points, closePath) {
        const region = new Path2D();
        region.moveTo(points[0][0], points[0][1]);
        for (let i = 1; i < points.length; i++) {
            const point = points[i];
            region.lineTo(point[0], point[1]);
        }

        if (closePath) {
            region.closePath();
        }
        ctx.stroke(region);
    }

    let model, ctx, videoWidth, videoHeight, video, canvas,
        scatterGLHasInitialized = false,
        scatterGL;

    const VIDEO_SIZE = 500;
    const mobile = isMobile();
    // Don't render the point cloud on mobile in order to maximize performance and
    // to avoid crowding limited screen space.
    const renderPointcloud = mobile === false;
    const stats = new Stats();
    const state = {
        backend: 'wasm',
        maxFaces: 1,
        triangulateMesh: true
    };

    if (renderPointcloud) {
        state.renderPointcloud = true;
    }

    function setupDatGui() {
        const gui = new dat.GUI();
        gui.add(state, 'backend', ['wasm', 'webgl', 'cpu'])
            .onChange(async backend => {
                await tf.setBackend(backend);
            });

        gui.add(state, 'maxFaces', 1, 20, 1).onChange(async val => {
            model = await facemesh.load({
                maxFaces: val
            });
        });

        gui.add(state, 'triangulateMesh');

        if (renderPointcloud) {
            // gui.add(state, 'renderPointcloud').onChange(render => {
            //     document.querySelector('#scatter-gl-container').style.display =
            //         render ? 'inline-block' : 'none';
            // });
        }
    }

    async function setupCamera() {
        
        video = document.getElementById('v_pc_1');

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
        });

        
        return new Promise((resolve) => {
            video.onloadedmetadata = () => {
                resolve(video);
            };
        });
    }

    function captureCamera(callback) { //카메라 연결확인 함수
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

    async function renderPrediction() {
        stats.begin();

        const predictions = await model.estimateFaces(video);
        ctx.drawImage(
            video, 0, 0, videoWidth, videoHeight, 0, 0, canvas.width, canvas.height);

        if (predictions.length > 0) {
            predictions.forEach(prediction => {
                const keypoints = prediction.scaledMesh;
                
                if (state.triangulateMesh) {
                    for (let i = 0; i < TRIANGULATION.length / 3; i++) {
                        const points = [
                            TRIANGULATION[i * 3], TRIANGULATION[i * 3 + 1],
                            TRIANGULATION[i * 3 + 2]
                        ].map(index => keypoints[index]);

                        drawPath(ctx, points, true);
                    }
                } else {
                    for (let i = 0; i < keypoints.length; i++) {
                        const x = keypoints[i][0];
                        const y = keypoints[i][1];

                        ctx.beginPath();
                        ctx.arc(x, y, 1 /* radius */ , 0, 2 * Math.PI);
                        ctx.fill();
                    }
                }
            });

            // if (renderPointcloud && state.renderPointcloud && scatterGL != null) {
            //     const pointsData = predictions.map(prediction => {
            //         let scaledMesh = prediction.scaledMesh;
            //         return scaledMesh.map(point => ([-point[0], -point[1], -point[2]]));
            //     });

            //     let flattenedPointsData = [];
            //     for (let i = 0; i < pointsData.length; i++) {
            //         flattenedPointsData = flattenedPointsData.concat(pointsData[i]);
            //     }
            //     const dataset = new ScatterGL.Dataset(flattenedPointsData);

            //     if (!scatterGLHasInitialized) {
            //         scatterGL.render(dataset);
            //     } else {
            //         scatterGL.updateDataset(dataset);
            //     }
            //     scatterGLHasInitialized = true;
            // }
        }

        stats.end();
        requestAnimationFrame(renderPrediction);
    };

    function stopRecording() {
        recorder.stopRecording(sr());
    }

    function sr() {
        recorder.stopRecording();
        video.pause();
        

        setTimeout(function() {
            let blob = recorder.getBlob();
            let fileObject = new File([blob], 'test.webm', {
                type: 'video/webm; codecs=vp9'
            });

            console.log(fileObject);

            let blobURL = URL.createObjectURL(fileObject);
            console.log(blobURL);
            
        }, 500);
        
        

    }

    async function main() {
        await tf.setBackend(state.backend);
        
        // setupDatGui();

        stats.showPanel(0); // 0: fps, 1: ms, 2: mb, 3+: custom
        document.getElementById('scontent').appendChild(stats.dom);

        await setupCamera();
        // video.play();
        videoWidth = video.videoWidth;
        videoHeight = video.videoHeight;
        video.width = videoWidth;
        video.height = videoHeight;

        canvas = document.getElementById('_canvas');
        canvas.width = videoWidth;
        canvas.height = videoHeight;
        const canvasContainer = document.querySelector('.canvas-wrapper');
        canvasContainer.style = `width: ${videoWidth}px; height: ${videoHeight}px`;

        ctx = canvas.getContext('2d');
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.fillStyle = '#32EEDB';
        ctx.strokeStyle = '#32EEDB';
        ctx.lineWidth = 0.5;

        model = await facemesh.load({
            maxFaces: state.maxFaces
        });
        renderPrediction();
        $('#text_').html("프로필 저장을 위해 촬영을 진행합니다. <br /> 프로필 촬영 전 한번 웃어 볼까요?");
        if (renderPointcloud) {
            // document.querySelector('#scatter-gl-container').style =
            //     `width: ${VIDEO_SIZE}px; height: ${VIDEO_SIZE}px;`;

            // scatterGL = new ScatterGL(
            //     document.querySelector('#scatter-gl-container'), {
            //         'rotateOnStart': false,
            //         'selectEnabled': false
            //     });
        }
    };

    main();
</script>

<!-- <script type="module">
    const videoElement = document.getElementsByClassName('input_video')[0];
    const canvasElement = document.getElementsByClassName('output_canvas')[0];
    const canvasCtx = canvasElement.getContext('2d');

    function onResults(results) {
        canvasCtx.save();
        canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
        canvasCtx.drawImage(
            results.image, 0, 0, canvasElement.width, canvasElement.height);
        if (results.multiFaceLandmarks) {
            for (const landmarks of results.multiFaceLandmarks) {
                drawConnectors(canvasCtx, landmarks, FACEMESH_TESSELATION, {
                    color: '#C0C0C070',
                    lineWidth: 1
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_RIGHT_EYE, {
                    color: '#FF3030'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_RIGHT_EYEBROW, {
                    color: '#FF3030'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_RIGHT_IRIS, {
                    color: '#FF3030'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_LEFT_EYE, {
                    color: '#30FF30'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_LEFT_EYEBROW, {
                    color: '#30FF30'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_LEFT_IRIS, {
                    color: '#30FF30'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_FACE_OVAL, {
                    color: '#E0E0E0'
                });
                drawConnectors(canvasCtx, landmarks, FACEMESH_LIPS, {
                    color: '#E0E0E0'
                });
            }
        }
        canvasCtx.restore();
    }

    const faceMesh = new FaceMesh({
        locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`;
        }
    });
    faceMesh.setOptions({
        maxNumFaces: 1,
        refineLandmarks: true,
        minDetectionConfidence: 0.5,
        minTrackingConfidence: 0.5
    });
    faceMesh.onResults(onResults);

    const camera = new Camera(videoElement, {
        onFrame: async () => {
            await faceMesh.send({
                image: videoElement
            });
        },
        width: 1280,
        height: 720
    });
    camera.start();
</script> -->

<style>
    .face_vdoBox {
        height: 100vh;
        /* Use vh as a fallback for browsers that do not support Custom Properties */
        height: calc(var(--videoH, 1vh) * 100);
    }

    .canvas-wrapper,
    #scatter-gl-container {
        display: inline-block;
        vertical-align: top;
    }

    #scatter-gl-container {
        border: solid 1px black;
        position: relative;
    }

    /* center the canvas within its wrapper */
    #scatter-gl-container canvas {
        transform: translate3d(-50%, -50%, 0);
        left: 50%;
        top: 50%;
        position: absolute;
    }
</style>