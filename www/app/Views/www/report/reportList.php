<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <div class="tlt">A.I. 리포트</div>
            <a href="/help/guide/interview" class="top_gray_txtlink gray_txtlink">가이드 보기</a>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s top_jbBox-->
    <div class="top_jbBox c">
        <div id='rTitle' class="txt">AI가 진단하는 내 면접 습관 완벽 분석</div>
    </div>
    <!--e top_jbBox-->

    <!--s contBox-->
    <div class="contBox">
        <!--s BtnBox-->
        <div class="BtnBox mg_t30">
            <?php if ($data['type'] === 'all') : ?>
                <a href="interview/ready" class="btn btn01" style="width:100%;">새 인터뷰 시작하기</a>
            <?php elseif ($data['type'] === 'open') : ?>
                <a style="width:100%;" href="<?= ($data['allCount'] === 0) ? 'javascript:void(0)' : 'report/comprehensive' ?>" class="btn <?= ($data['allCount'] === 0) ? 'btn03' : 'btn02' ?> public_ai_report_mb">종합 리포트 설정</a>
            <?php endif; ?>
        </div>
        <!--e BtnBox-->
    </div>
    <!--e contBox-->

    <!--s top_tab-->
    <div class="top_tab mg_t70">
        <!--s depth-->
        <ul class="depth2 wd_2_2">
            <li class="<?= $data['type'] === 'all' ? 'on' : '' ?>"><a href="?type=all">전체 리포트 <?= $data['allCount'] ?>개</a></li>
            <li class="<?= $data['type'] === 'open' ? 'on' : '' ?>"><a href="?type=open">종합 리포트 <?= $data['openCount'] ?>개</a></li>
        </ul>
        <!--e depth-->
    </div>
    <!--e top_tab-->

    <!--s contBox-->
    <div class="cont pd_t0">
        <!--s 전체리포트-->
        <?php if ($data['type'] === 'all') : ?>
            <?php if (count($data['list']) || $data['allCount'] > 0) : ?>
                <!--s ratingsBox-->
                <div class="ratingsBox">
                    <div class="name fl"><span class="point"><?= $data['session']['name'] ?></span>님</div>

                    <div class="ratings_box fr">
                        <span class="hh_score">최고점: <span id='max' class="point">...</span></span>
                        <span class="ratings">평균: <span id='avg' class="point">...</span></span>
                    </div>
                </div>
                <!--e ratingsBox-->

                <!--s 셀렉트박스-->
                <div class="r">
                    <!--s selBox-->
                    <div class="selBox l">
                        <!--s selectbox-->
                        <div class="selectbox">
                            <dl class="dropdown">
                                <dt><a href="javascript:void(0)" class="myclass">전체</a></dt>
                                <dd>
                                    <ul class="dropdown2">
                                        <li class="<?= $data['reportType'] === 'all' ? 'on' : '' ?>">
                                            <a href="?reportType=all&reportSort=<?= $data['reportSort'] ?>">전체</a>
                                        </li>
                                        <li class="<?= $data['reportType'] === '1' ? 'on' : '' ?>">
                                            <a href="?reportType=1&reportSort=<?= $data['reportSort'] ?>">공개</a>
                                        </li>
                                        <li class="<?= $data['reportType'] === '0' ? 'on' : '' ?>">
                                            <a href="?reportType=0&reportSort=<?= $data['reportSort'] ?>">비공개</a>
                                        </li>
                                        <li class="<?= $data['reportType'] === 'company' ? 'on' : '' ?>">
                                            <a href="?reportType=company&reportSort=<?= $data['reportSort'] ?>">기업용</a>
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                        <!--e selectbox-->

                        <!--s selectbox-->
                        <div class="selectbox">
                            <dl class="dropdown">
                                <dt><a href="javascript:void(0)" class="myclass">최신순</a></dt>
                                <dd>
                                    <ul class="dropdown2">
                                        <li class="<?= $data['reportSort'] === 'date' ? 'on' : '' ?>">
                                            <a href="?reportType=<?= $data['reportType'] ?>&reportSort=date">최신순</a>
                                        </li>
                                        <li class="<?= $data['reportSort'] === 'max' ? 'on' : '' ?>">
                                            <a href="?reportType=<?= $data['reportType'] ?>&reportSort=max">점수높은순</a>
                                        </li>
                                        <li class="<?= $data['reportSort'] === 'min' ? 'on' : '' ?>">
                                            <a href="?reportType=<?= $data['reportType'] ?>&reportSort=min">점수낮은순</a>
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                        <!--e selectbox-->
                    </div>
                    <!--e selBox-->
                </div>
                <!--e 셀렉트박스-->
            <?php endif; ?>

            <!--s big_itv_pr_report_list-->
            <div class="big_itv_pr_report_list">
                <form id="frm1" method="POST" action="/report/deleteAction">
                    <?= csrf_field() ?>

                    <?php foreach ($data['list'] as $val) : ?>
                        <?php if ($val['app_iv_stat'] == '4') : ?>
                            <!--s big_itv_pr_report-->
                            <div class="big_itv_pr_report2">
                                <!--s itv_pr_reportBox-->
                                <div class="itv_pr_reportBox">
                                    <div class="company_top_txt">
                                        <?= $val['app_type'] === 'C' ? ' <span class="ctt02">기업용</span>' : '' ?>
                                    </div>
                                    <a href="report/detail/<?= $val['idx'] ?>">
                                        <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                    </a>
                                    <a href="report/detail/<?= $val['idx'] ?>">
                                        <!--s txtBox-->
                                        <div class="txtBox">
                                            <div class="class"> <?= $val['repo_analysis'] ?></div>
                                            <div class="tlt">[<?= $val['job_depth_text'] ?>]</div>
                                            <div class="question">질문 <?= $val['queCount'] ?>개</div>

                                            <div class="data"><?= $val['app_reg_date'] ?></div>
                                        </div>
                                        <!--e txtBox-->
                                    </a>

                                    <!--s itv_pr_btnBox-->
                                    <div class="itv_pr_btnBox">
                                        <!--s itv_pr_btncont-->
                                        <div class="itv_pr_btncont">
                                            <a href="javascript:void(0)" class="itv_pr_btn_pop"><img src="/static/www/img/sub/int_settings_icon.png"></a>

                                            <ul class="itv_pr_btnUl">
                                                <li><button type='sumbit' name='deleteIdx' value='<?= $val['idx'] ?>'>삭제하기</button></li>
                                            </ul>
                                        </div>
                                        <!--e itv_pr_btncont-->
                                    </div>
                                    <!--seitv_pr_btnBox-->
                                </div>
                                <!--e itv_pr_reportBox-->
                            </div>
                            <!--e big_itv_pr_report-->
                        <?php elseif ($val['app_iv_stat'] == '3' || $val['app_iv_stat'] == '5') : ?>
                            <!--s big_itv_pr_report-->
                            <div class="big_itv_pr_report2">
                                <!--s itv_pr_reportBox-->
                                <div class="itv_pr_reportBox">
                                    <div class="company_top_txt">
                                        <?= $val['app_type'] === 'C' ? ' <span class="ctt02 fail01">기업용</span>' : '' ?>
                                    </div>
                                    <a href="report/fail/<?= $val['idx'] ?>">
                                        <div class="imgBox"><img src="<?= $data['url']['media'] ?><?= $val['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                    </a>
                                    <a href="report/fail/<?= $val['idx'] ?>">
                                        <!--s txtBox-->
                                        <div class="txtBox">
                                            <div class="class fail01"><?= $val['app_iv_stat'] == '3' ? '분석중' : '분석불가' ?></div>
                                            <div class="tlt">[<?= $val['job_depth_text'] ?>]</div>
                                            <div class="question">질문 <?= $val['queCount'] ?>개</div>

                                            <div class="data"><?= $val['app_reg_date'] ?></div>
                                        </div>
                                        <!--e txtBox-->
                                    </a>

                                    <!--s itv_pr_btnBox-->
                                    <div class="itv_pr_btnBox">
                                        <!--s itv_pr_btncont-->
                                        <div class="itv_pr_btncont">
                                            <li><button class='fail02' type='sumbit' name='deleteIdx' value='<?= $val['idx'] ?>'>삭제하기</button></li>
                                        </div>
                                        <!--e itv_pr_btncont-->
                                    </div>
                                    <!--seitv_pr_btnBox-->
                                </div>
                                <!--e itv_pr_reportBox-->

                                <!--s big_pr_btnBox-->
                                <!-- <div class="big_pr_btnBox fail_border">
                                    <a href="javascript:void(0)" class="bpb01 fail01">공유하기</a>
                                    <a class="bpb02 fail01">공개설정</a>
                                </div> -->
                                <!--e big_pr_btnBox-->
                            </div>
                            <!--e big_itv_pr_report-->
                        <?php endif; ?>
                    <?php endforeach; ?>
                </form>

                <?php if (!count($data['list']) && $data['allCount'] === 0) : ?>
                    <li class="no_list" style='height: auto'>
                        <!-- 리스트없을때 -->
                        아직 완료된 인터뷰가 없어요 <br />
                        인터뷰 완료하고 인공지능 리포트를 받아보세요!
                        <!--s BtnBox-->
                        <div class="BtnBox mg_t30">
                            <a href="/interview/ready" class="btn btn01 white fon24 wps_100">새 인터뷰 시작하기<span class="arrow"><i class="la la-angle-right"></i></span></a>
                        </div>
                        <!--e BtnBox-->
                    </li>
                <?php endif; ?>

            </div>
            <!--e big_itv_pr_report_list-->

            <!--e 전체리포트-->
        <?php elseif ($data['type'] === 'open') : ?>
            <!--s 공개중인 리포트-->

            <?php if (count($data['list'])) : ?>
                <!--s readingBox-->
                <div class="readingBox gray_fileBox c mg_b20">
                    총 열람 <span class="point"><?= $data['appCount'] ?>번</span>
                    <span class="line_r">|</span>
                    제안 <span class="point"><?= $data['suggestCount'] ?>건</span>
                </div>
                <!--e readingBox-->
            <?php endif; ?>

            <form id="frm2" method="POST" action="/report/updateAction">
                <?= csrf_field() ?>

                <?php foreach ($data['list'] as $val) : ?>
                    <?php if ($val['app_iv_stat'] >= '3') : ?>
                        <!--s big_itv_pr_report_list-->
                        <div class="big_itv_pr_report_list">
                            <!--s big_itv_pr_report-->
                            <div class="big_itv_pr_report">
                                <!--s itv_pr_reportBox-->
                                <div class="itv_pr_reportBox">
                                    <div class="company_top_txt">
                                        <span class="ctt01"><?= $val['app_share'] ? '공개' : '비공개' ?></span>
                                    </div>

                                    <a href="report/detail2/<?= $val['idx'] ?>">
                                        <!--s txtBox02-->
                                        <div class="txtBox02">
                                            <!--s classBox-->
                                            <div class="classBox">
                                                <span class="class_txt"><?= $val['repo_analysis'] ?></span>
                                                <span class="ifd_txt">[<?= $val['job_depth_text'] ?>]</span>
                                            </div>
                                            <!--e classBox-->

                                            <!--s fileBox-->
                                            <div class="fileBox">
                                                이력서 [<span class="point"><?= $val['res_title'] ?>]</span>
                                            </div>
                                            <!--e fileBox-->

                                            <!--s hd_Box-->
                                            <div class="hd_Box">
                                                <span class="hit fl">조회수 <span class="point"><?= $val['app_count'] ?>회</span> <span class="line_r">|</span> 제안 <span class="point"><?= $val['suggest'] ?>건</span></span>
                                                <span class="data02 fr">공개일 : <?= $val['app_mod_date'] ?></span>
                                            </div>
                                            <!--e hd_Box-->
                                        </div>
                                        <!--e txtBox02-->
                                    </a>

                                    <!--s itv_pr_btnBox-->
                                    <div class="itv_pr_btnBox">
                                        <!--s itv_pr_btncont-->
                                        <div class="itv_pr_btncont">
                                            <a href="javascript:void(0)" class="itv_pr_btn_pop"><img src="/static/www/img/sub/int_settings_icon.png"></a>

                                            <ul class="itv_pr_btnUl">
                                                <li><button type='submit' name='updateIdxMain' value='<?= $val['idx'] ?>'>삭제하기</button></li>
                                                <?php if ($val['suggest'] == '1') : ?>
                                                    <li><a href="/my/suggest/detail/<?= $val['sugIdx'] ?>">제안 보기</a></li>
                                                <?php elseif ($val['suggest'] > '1') : ?>
                                                    <li><a href="/my/suggest">제안 보기</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <!--e itv_pr_btncont-->
                                    </div>
                                    <!--seitv_pr_btnBox-->
                                </div>
                                <!--e itv_pr_reportBox-->

                                <!--s big_pr_btnBox-->
                                <div class="big_pr_btnBox">
                                    <a href='/report/print/<?= $val['idx'] ?>' target="_blank">다운로드</a>
                                    <a class="bpb02 shareOption" data-idx="<?= $val['idx'] ?>" data-jobidx="<?= $val['jobIdx'] ?>">공개설정</a>
                                </div>
                                <!--e big_pr_btnBox-->
                            </div>
                            <!--e big_itv_pr_report-->
                        </div>
                        <!--e big_itv_pr_report_list-->
                    <?php endif; ?>
                <?php endforeach; ?>

                <!--e 공개중인 리포트-->

            </form>

            <?php if (!count($data['list'])) : ?>
                <li class="no_list" style='height: auto'>
                    <!-- 리스트없을때 -->
                    <div class="ngp"><span>!</span></div>
                    공개중인 리포트가 없어요!
                </li>
            <?php endif; ?>

        <?php endif; ?>
        <?= $data['pager']->links('report', 'front_full') ?>
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<!--s 공개설정 모달-->
<div id="settings_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="txt mg_b20">
                이미 동일 직군의 리포트가<br />
                공개되어 있어요
            </div>

            <div id='modalJob' class="tlt mg_b20">
                [직군.직무]
            </div>

            <div class="txt mg_b0">
                이걸로 변경하시겠어요?
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('settings_pop')">아니요</a>
            <a id='shareLink' href="javascript:void(0)" class="spop_btn02">네</a>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 공개설정 모달-->

<script>
    //공개한 영상 중 링크복사를 누르면 인터뷰 세부사항을 볼 수 있는 링크가 복사되는 함수
    function modal_share_link(en) {
        let link = '<?= $data['url']['www'] ?>/report/detail/' + en;
        const t = document.createElement("textarea");
        document.body.appendChild(t);
        t.value = link;
        t.select();
        document.execCommand('copy');
        document.body.removeChild(t);
        alert('링크가 복사되었습니다.');
    }

    //공개한 영상을 페이스북으로 공유하는 함수
    function sns_share_facebook(en) {
        let broswerInfo = navigator.userAgent;
        let link = 'interview.highbuff.com/itv_view.php?index=' + en;
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1 || broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            location.href = "https://www.facebook.com/sharer/sharer.php?u=" + link;
        } else {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + link);
        }
    }

    //공개한 영상을 트위터로 공유하는 함수
    function sns_share_twitter(en) {
        let broswerInfo = navigator.userAgent;
        let link = 'interview.highbuff.com/itv_view.php?index=' + en;
        if (broswerInfo.indexOf("APP_Highbuff_Android") != -1 || broswerInfo.indexOf("APP_Highbuff_IOS") != -1) {
            location.href = "https://twitter.com/intent/tweet?url=" + link;
        } else {
            window.open("https://twitter.com/intent/tweet?url=" + link);
        }
    }

    //공개한 영상을 카카오톡으로 공유하는 함수
    function sns_share_kakao(img, name, en) {
        //Kakao.init('a2f74deda739622a9c80f1f0c6adb899');
        let link = 'interview.highbuff.com/itv_view.php?index=' + en;

        Kakao.Link.sendDefault({
            objectType: 'feed',
            content: {
                title: name + "님의 A.I. 종합분석을 공유합니다.", // 보여질 제목
                description: "링크를 누르고 " + name + "님의 A.I. 종합분석을 확인하세요.", // 보여질 설명
                imageUrl: "https://media.highbuff.com/data/uploads_thumbnail/" + img, // 콘텐츠 URL
                link: {
                    mobileWebUrl: link,
                    webUrl: link
                }
            }
        });
    }

    let aPoints = [];
    aPoints = '<?= json_encode($data['points']) ?>';
    aPoints = JSON.parse(aPoints);

    let jobIdx = [];
    jobIdx = '<?= json_encode($data['jobIdx']) ?>';
    jobIdx = JSON.parse(jobIdx);

    let iSumPoint = 0;
    const aTitle = ['AI가 진단하는 내 면접 습관 완벽 분석', '웃는 얼굴은 면접관에게 호감을 줍니다.', '오늘도 활기찬 하루를 시작해보아요', '오늘의 목표는 무엇인가요?', '편안한 마음으로 이야기해요.'];
    const iRandom = Math.floor(Math.random() * aTitle.length);
    $(document).ready(function() {
        if (aPoints.length == 0) {
            aPoints = [0];
        } else {
            for (let i = 0; i < aPoints.length; ++i) {
                aPoints[i] = Math.round(aPoints[i] * 100) / 100;
                iSumPoint += aPoints[i];
            }
        }

        const iMaxPoint = Math.max.apply(null, aPoints);

        $('#max').text((iMaxPoint).toFixed(2));
        $('#avg').text((iSumPoint / aPoints.length).toFixed(2));

        $('#rTitle').text(aTitle[iRandom]);
        $('select').change(function() {
            $('#frm').submit();
        });

        $('.dropdown2').find('.on').each(function() {
            let text = $(this).children('a').text();
            $(this).closest('dl').find('.myclass').text(text);
        });

        $('.shareOption').on('click', function() {
            const thisIdx = $(this).data('idx');
            const thisJobIdx = $(this).data('jobidx');
            const thisList = $(this).closest('.big_itv_pr_report');
            const url = `/report/comprehensive/share?report=${thisIdx}`;

            for (let i = 0; i < jobIdx.length; i++) {
                if (jobIdx[i] == thisJobIdx) {
                    $('#shareLink').attr('href', url)
                    $('#modalJob').text(thisList.find('.tlt').text());
                    fnShowPop('settings_pop');
                    return;
                }
            };
            location.href = url;
        });

        $(".itv_pr_btn_pop").click(function() {
            $(".itv_pr_btnUl").not($(this).next(".itv_pr_btnUl").toggleClass('open')); //각자 열고닫기 가능
        });

        $('.share_btn').on('click', function() {
            //alert2("서비스 준비중입니다.");
            let idx = $(this).data('shareidx');
            let arrthumb = $(this).data('arrthumb');
            //let broswerInfo = navigator.userAgent;

            let user_info = JSON.stringify({
                "user_name": "<?= $data['session']['name'] ?>",
                "user_thumbnail": "<?= $data['url']['media'] ?>" + arrthumb,
                "share_url": "<?= $data['url']['www'] ?>/report/detail/" + idx
            });

            if (window.navigator.userAgent.indexOf("APP_Highbuff_Android") != -1) {
                window.interview.share(user_info);
            } else if (window.navigator.userAgent.indexOf("APP_Highbuff_IOS") != -1) {
                webkit.messageHandlers.share.postMessage(user_info);
            } else {
                modal_share_link(idx);
            }
        });

        $(document).on('click', '.modalBtn', function() {
            // let thisId = $(this).attr('id');
            // let thisValue = $(this).val();
            // switch (thisId) {
            //     case 'link':
            //         modal_share_link(thisValue);
            //         break;
            //     case 'face':
            //         sns_share_facebook(thisValue);
            //         break;
            //     case 'twitter':
            //         sns_share_twitter(thisValue);
            //         break;
            //     case 'kakao':
            //         sns_share_kakao('dsd', 'name', thisValue);
            //         break;
            // }
        });

        $("#frm1").on("submit", function(event) {
            if (!confirm("정말 삭제하시겠습니까? (삭제하면 재응시가 불가능합니다.)")) {
                event.preventDefault();
                return;
            }
        });

        $("#frm2").on("submit", function(event) {
            if (!confirm("종합 리포트를 삭제하시겠습니까?")) {
                event.preventDefault();
                return;
            }
        });
    });
</script>