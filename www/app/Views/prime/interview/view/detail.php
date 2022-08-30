<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">인터뷰 상세</h3>
                <div>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="get" id="frm" target="_self">
                    <table class="table">
                        <colgroup>
                            <col style="width:50%">
                            <col style="width:50%">
                        </colgroup>
                        <tbody>
                            <tr class='title'>
                                <th>정보</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>
                                    <a href='/prime/member/write/m/<?= $data['totalList']['memIdx'] ?>'>회원 정보 보러가기</a>
                                </td>
                                <td>
                                    <?php if ($data['totalList']['recIdx']) : ?>
                                        <a href='/prime/recruit/write/<?= $data['totalList']['recIdx'] ?>'>공고 보러가기</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    인터뷰 상태 진행도:
                                    [ <span class="<?= $data['totalList']['appStat'] == 0 ? 'point' : '' ?>">카테고리 선택</span>->
                                    <span class="<?= $data['totalList']['appStat'] == 1 ? 'point' : '' ?>">프로필 촬영</span>->
                                    <span class="<?= $data['totalList']['appStat'] == 2 ? 'point' : '' ?>">마이크 테스트</span>->
                                    <span class="<?= $data['totalList']['appStat'] == 3 ? 'point' : '' ?>">면접완료</span>->
                                    <span class="<?= $data['totalList']['appStat'] == 4 ? 'point' : '' ?>">채점 완료</span> ]
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>썸네일</div>
                                    <div class="imgBox">
                                        <img src="<?= $data['url']['media'] ?><?= $data['totalList']['fileName'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                    </div>
                                </td>
                                <td>
                                    <p>인터뷰 상태: <?= $data['totalList']['appStatMsg'] ?></p>
                                    <p>인터뷰 타입: <?= $data['totalList']['appType'] ?></p>
                                    <p>공유상태: <?= $data['totalList']['appShare'] ? '공유 중' : '공유안함' ?></p>
                                    <p>직무: <?= $data['totalList']['jobText'] ?></p>
                                    <p>조회수: <?= $data['totalList']['appCount'] ?></p>
                                    <p>좋아요: <?= $data['totalList']['appLikeCount'] ?></p>
                                    <p>플랫폼: <?= $data['totalList']['appPlatForm'] ?></p>
                                    <p>브라우저: <?= $data['totalList']['appBrowserName'] ?></p>
                                    <p>브라우저 버전: <?= $data['totalList']['appBrowserVer'] ?></p>
                                    <p>OS: <?= $data['totalList']['appOs'] ?></p>
                                    <p>OS 버전: <?= $data['totalList']['appOsVer'] ?></p>
                                    <p>등록일: <?= $data['totalList']['appRegDate'] ?></p>
                                    <p><?= $data['totalList']['appReferer'] ?></p>

                                    <div>종합 점수 (가공후)</div>
                                    <p>
                                        <?php if ($data['totalList']['analysis']) : ?>
                                            <?php foreach ($data['totalList']['analysis'] as $key => $val) : ?>
                                                <span><?= $key ?>:</span> <span><?= $val ?></span>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            없음
                                        <?php endif; ?>
                                    </p>
                                    <div>종합 점수 (가공전)</div>
                                    <p>
                                        <?php if ($data['totalList']['score']) : ?>
                                            <?php foreach ($data['totalList']['score'] as $key => $val) : ?>
                                                <span><?= $key ?>:</span> <span><?= $val = is_array($val) ? max($val) : $val ?></span>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            없음
                                        <?php endif; ?>
                                    </p>
                                </td>
                            </tr>
                            <?php foreach ($data['scoreList'] as $videoNum => $row) : ?>
                                <tr>
                                    <td>
                                        <div><?= $videoNum + 1 ?>번 동영상</div>
                                        <video class='videoCon' data-videonum='<?= $videoNum ?>' controls playsinline src="<?= "{$data['url']['media']}{$data['videoPath']}{$row['video_record']}" ?>"></video>
                                    </td>
                                    <td>
                                        <p>질문: <?= $row['queText'] ?></p>

                                        <div>STT</div>
                                        <p>
                                            <?php if ($row['sttDetail']) : ?>
                                                <?php foreach ($row['sttDetail'] as $val) : ?>
                                                    <span class='word_timestamp' data-video='<?= $videoNum ?>' data-start='<?= $val['start_time'] ?? '' ?>' data-end='<?= $val['end_time'] ?? '' ?>'>
                                                        <?= $val['alternatives'][0]['content'] ?? '' ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                없음
                                            <?php endif; ?>
                                        </p>

                                        <div>점수 (가공후)</div>
                                        <p>
                                            <?php if ($row['analysis']) : ?>
                                                <?php foreach ($row['analysis'] as $key => $val) : ?>
                                                    <span><?= $key ?>:</span> <span><?= $val ?></span>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </p>
                                        <div>점수 (가공전)</div>
                                        <p>
                                            <?php if ($row['score']) : ?>
                                                <?php foreach ($row['score'] as $key => $val) : ?>
                                                    <span><?= $key ?>:</span> <span><?= $val ?></span>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                없음
                                            <?php endif; ?>
                                        </p>
                                        <div>오디오</div>
                                        <p>
                                            <?php if ($row['audio']) : ?>
                                                <?php foreach ($row['audio'] as $val) : ?>
                                                    <span></span> <span></span>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                없음
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<script>
    let global_videoindex = 0;

    $(document).on('click', '.word_timestamp', function() {
        const start = parseFloat($(this).attr("data-start"));
        global_videoindex = $(this).data('video');
        $('.videoCon')[global_videoindex].currentTime = start;
        $(".videoCon").get(global_videoindex).play();
    });

    $(".videoCon").on("play", function(event) {
        global_videoindex = $(this).data('videonum');
    });

    $(".videoCon").on("timeupdate", function(event) {
        if (!$(".videoCon").get(global_videoindex).paused) {
            const current = this.currentTime; //현재 video play time
            $(".word_timestamp").each(function(index, item) {
                if ($(this).data('video') == global_videoindex) {
                    const start = parseFloat($(item).attr("data-start"));
                    const end = parseFloat($(item).attr("data-end"));

                    if (current >= start && current <= end) {
                        $(this).css("color", "red");
                    } else {
                        $(this).css("color", "black");
                    }
                }
            });
        }
    });
</script>

<style>
    .imgBox {
        position: relative;
        width: 50%;
    }

    .imgBox>img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    video {
        height: 50vh;
    }

    .word_timestamp {
        border-bottom: 1px black solid;
    }
</style>