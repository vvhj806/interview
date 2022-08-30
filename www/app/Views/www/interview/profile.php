<?php
isset($data['fileInfo']['file_save_name']) ? $data['fileInfo']['file_save_name'] = $data['url']['media'] . $data['fileInfo']['file_save_name'] : $data['fileInfo']['file_save_name'] = "/static/www/img/sub/prf_no_img.jpg";

isset($data['fileStyle']) ? $data['fileStyle'] : $data['fileStyle'] = "";

isset($data['noprofile']) ? $data['noprofile'] : $data['noprofile'] = "";
?>

<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <?php if ($data['recInterview']) : ?>
                <a href="/interview/ready?rec=<?= $data['recIdx'] ?>">
                <?php elseif ($data['nosInterview']) : ?>
                    <a href="/interview/ready?mock=<?= $data['recNosIdx'] ?>">
                    <?php elseif ($data['iInterview']) : ?>
                        <a href="/interview/ready?cmock=<?= $data['i_idx'] ?>">
                        <?php elseif ($data['linkInterview']) : ?>
                            <a href="/interview/ready?sug=<?= $data['sug_idx'] ?>">
                            <?php else : ?>
                                <a href="/interview/type">
                                <?php endif; ?>
                                <div class="backBtn"><span>뒤로가기</span></div>
                                </a>
                                <!-- <a href="javascript:" class="top_gray_txtlink gray_txtlink" id="SkipBtn">건너뛰기</a> -->
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s cont-->
    <div class="cont cont_pd_bottom c">
        <!--s bigtlt-->
        <div class="bigtlt mg_b20">
            인터뷰의 프로필 사진을<br />
            설정해주세요!
        </div>
        <!--e bigtlt-->
        <!--s itv_pr_gray_txt-->
        <div class="itv_pr_gray_txt">
            *인사담당자가 확인하게 됩니다 :)
        </div>
        <!--e itv_pr_gray_txt-->

        <!--s prf_img-->
        <div class="prf_imgFit mg_t30">
            <img id="changeImg" src="<?= $data['fileInfo']['file_save_name'] ?>" style="width:288px; height: 288px; object-fit: cover;"><!-- 사진 넣기전 이미지 첨부하고나면 사진 바뀌기-->
        </div>
        <!--e prf_img-->

        <!--s BtnBox-->
        <div class="BtnBox">
            <a href="javascript:" class="btn btn01 wps_100 mg_b10" id="btn_next" style="display:none">설정 완료</a>
            <a href="/interview/profile/photo/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>" class="btn btn02 wps_100 mg_b10">지금 촬영하기</a>

            <?php if (!($data['gsCk'] ?? false)) : ?>
                <a href="javascript:" id="albumSelect" class="btn btn02 wps_100 mg_b10">앨범에서 선택</a>
                <a href="/interview/profile/exist/<?= $data['applyIdx'] ?>/<?= $data['memIdx'] ?>" class="btn btn02 wps_100" id="existBtn">기존 프로필에서 선택</a>
            <?php endif; ?>

            <form action="/interview/profile/albumAction" method="POST" id="albumForm">
                <?= csrf_field() ?>
                <input type="file" accept="image/*" id="profileFile" name="profileFile" style="display:none">
                <input name="fileIdx" id="fileIdx" type="hidden" value="<?= $data['fileIdx'] ?>">
                <input name="filePath" id="filePath" type="hidden">
                <input name="fileSize" id="fileSize" type="hidden">
                <input name="applyIdx" value="<?= $data['applyIdx'] ?>" type="hidden">
                <input name="memIdx" value="<?= $data['memIdx'] ?>" type="hidden">
                <input name="postCase" id="postCase" value="albumFile" type="hidden">
                <input name="backUrl" value="/" type="hidden">
            </form>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e cont-->
</div>
<!--e #scontent-->


<script src="https://cdn.socket.io/4.2.0/socket.io.min.js" integrity="sha384-PiBR5S00EtOj2Lto9Uu81cmoyZqR57XcOna1oAuVuIEjzj0wpqDVfD0JA9eXlRsj" crossorigin="anonymous"></script>
<script>
    $(window).on('load',function() {
        const fileData = $('#profileFile').prop('files');
        if (fileData) {
            const reader = new FileReader()
            reader.onload = e => {
                const previewImage = document.getElementById("changeImg")
                previewImage.src = e.target.result
            }

            if(fileData[0]){
                reader.readAsDataURL(fileData[0]);
                $('#btn_next').show();
            }
        }
        
    });
    setBtn();
    try {
        initSocket();
    } catch (error) {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        $.ajax({ //db에 에러로그 쌓고 텔레그램 보내는 ajax
            type: 'POST',
            url: '/api/error/page/photo/add',
            data: {
                '<?= csrf_token() ?>': emlCsrf.val(),
                errorTxt: error,
                pullPage: '/Views/interview/profile',
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
    // setBtn();

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
            alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
            return false;
        });

        socket.on('complete_thumb', (data) => {
            $('#filePath').val(data.filePath.substr(1));
            $('#fileSize').val(data.size);

            $('#albumForm').submit();
        });
        socket.on('disconnect', function() {
            alert("서버 연결이 끊어졌습니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 [하이버프 인터뷰]로 문의바랍니다.");
            location.reload();
            return false;
        });
    }

    function getFileName(fields, fileExtension) {
        let d = new Date();
        let index = "<?= $data['applyIdx'] ?>";
        let rand = Math.random().toString(36).substr(2, 11);
        let times = d.getTime();
        return index + "-" + fields + "-" + times + '-' + rand + '.' + fileExtension;
    }

    $('#btn_next').on("click", function(e) {
        e.preventDefault();
        const file = $('#profileFile').prop('files');

        if (file[0] == "" || file[0] == null) {
            $('#albumForm').submit();
        } else {
            const filename = getFileName('thumbnail', 'png');
            const data = {
                source: file[0],
                name: filename,
                size: file[0].size,
            };
            socket.emit('thumbnail', data);
        }
    });

    $('#albumSelect').on('click', function() {
        $('#profileFile').click();
    });

    $('#profileFile').on('input', function() {
        const file = $('#profileFile').prop('files');
        const reader = new FileReader()
        reader.onload = e => {
            const previewImage = document.getElementById("changeImg")
            previewImage.src = e.target.result
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(file[0]);
            $('#btn_next').show();
        }
    });

    function setBtn() {
        if ("<?= $data['setBtn'] ?>" == 1) {
            $('#btn_next').show();
        }

        if ("<?= $data['noprofile'] ?>" == 0) {
            $('#existBtn').attr('href', 'javascript:');
            $('#existBtn').attr('onclick', 'alert("기존 프로필 사진이 없어요")');
        }

        if ("<?= $data['recInterview'] ?>" == 1) {
            $('#SkipBtn').hide();
        }
    }

    $('#SkipBtn').on('click', function() {
        $('#postCase').val('skip');
        $('#albumForm').submit();
    })
</script>