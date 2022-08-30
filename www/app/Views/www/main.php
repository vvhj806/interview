<div>
    <!--s headBox-->
    <div class="headBox">
        <!--s logoBox-->
        <?= csrf_field() ?>
        <div class="logoBox">
            <a href="/">
                <div class="logo"><img src="<?= $data['url']['menu'] ?>/static/www/img/inc/logo.png"></div>
                <!--s txtBox-->
                <div class="txtBox">
                    <?php if ($data['session']['idx']) : ?>
                        <div class="name">
                            <span class="logo_hi"><img src="<?= $data['url']['menu'] ?>/static/www/img/inc/logo_hi.png"></span>
                            <span class="logo_name">
                                <?php if ($data['session']['name'] == '' || $data['session']['name'] == null) : ?>
                                    사용자님
                                <?php else : ?>
                                    <?= $data['session']['name'] ?><?= $data['checkServer'] ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <div class="logo_txt"><img src="<?= $data['url']['menu'] ?>/static/www/img/inc/logo_txt.png"></div>
                </div>
                <!--e txtBox-->
            </a>
        </div>
        <!--e logoBox-->

        <!--s rBox-->
        <div class="rBox">
            <!--s hd_alarm-->
            <div class="hd_alarm">
                <a href="/my/alarm">
                    <span class="icon"><img src="<?= $data['url']['menu'] ?>/static/www/img/inc/hd_alarm_icon.png"></span>
                    <span class="new">N</span>
                </a>
            </div>
            <!--e hd_alarm-->

            <!--s hd_mypage-->
            <div class="hd_mypage">
                <a href="my/main"><span class="icon"><img src="<?= $data['url']['menu'] ?>/static/www/img/inc/hd_mypage_icon.png"></span></a>
            </div>
            <!--e hd_mypage-->
        </div>
        <!--e rBox-->
    </div>
    <!--e headBox-->

    <!--s main_slBox-->
    <div class="main_slBox">
        <!--s main_sl-->
        <div class="main_sl">
            <div class="item">
                <!-- <a href="/interview/ready"> -->
                <img src="<?= $data['url']['menu'] ?>/static/www/img/main/main_slimg01.jpg" usemap="#imagemap">
                <map name="imagemap">
                    <area shape="rect" coords="36,384,274,443" href="/interview/ready">
                </map>
                <!-- </a> -->
            </div>
            <!-- <div class="item"><a href="/interview/ready"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/main_slimg02.jpg"></a></div>
            <div class="item"><a href="/interview/ready"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/main_slimg01.jpg"></a></div>
            <div class="item"><a href="/interview/ready"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/main_slimg02.jpg"></a></div> -->
        </div>
        <!--e main_sl-->

        <!--s 도트버튼-->
        <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <span class="slider__label sr-only"></span>
        </div>
        <!--e 도트버튼-->
    </div>
    <!--e main_slBox-->

    <!--s #mcontent-->
    <div id="mcontent">
        <!--s cont-->
        <div class="cont">
            <!--s m_shBox-->
            <div class="m_shBox">
                <a href="/search">
                    <div class="iconBox"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/m_sh_icon.png"></div>
                    <div class="txtBox">공고명, 포지션, 기업명으로 검색해 보세요! </div>
                </a>
            </div>
            <!--e m_shBox-->

            <?php
            if (!$data['session']['idx']) :
            ?>
                <!--s position_bn-->
                <div class="position_bn">
                    <!-- 클릭시 로그인 팝업 -->
                    <a href="/my/interest/main" class="">
                        <img src="<?= $data['url']['menu'] ?>/static/www/img/main/position_bn.png">
                    </a>
                </div>
                <!--e position_bn-->
            <?php else : ?>
                <!--s mtltBox-->
                <div class="mtltBox mt_t70">
                    <div class="mtlt">어떤 포지션에서 일하고 싶나요?</div>
                    <div class="plus_more_btn"><a href="/my/interest/main">더보기 <i class="la la-plus"></i></a></div>
                </div>
                <!--e mtltBox-->

                <!--s position_ckBox-->
                <div class="position_ckBox">
                    <ul>
                        <?php foreach ($data['category'] as $row) : ?>
                            <li>
                                <div class="ck_radio">
                                    <input type="checkbox" id="a<?= $row['idx'] ?>" name="a<?= $row['idx'] ?>">
                                    <label for="a<?= $row['idx'] ?>" onclick="location.href='/my/interest/main'"><?= $row['job_depth_text'] ?></label>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!--e position_ckBox-->
            <?php endif; ?>

            <!--s alarmBox-->
            <?php if ($data['session']['idx']) : ?>
                <?php if ($data['notice']) : ?>
                    <div class="alarmBox">
                        <a href="/my/alarm">
                            <div class="tlt point"><span class="icon"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/m_alarm_icon.png"></span><?= $data['notice']['push_title'] ?></div>
                            <div class="product_desc">[ <?= $data['notice']['push_content'] ?> ]</div>
                            <span class="arrow_icon"></span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <!--e alarmBox-->
        </div>
        <!--e cont-->

        <?php if ($data['session']['idx']) : ?>
            <!--s mtltBox-->
            <div class="mtltBox mt_t70 cont <?= $data['jobAreaState'] == 'noRec' ? 'hide' : '' ?>">
                <div class="mtlt">
                    <?php if ($data['jobAreaState'] == 'none') : ?>
                        관심직무와 관심 지역을 선택해주세요.
                    <?php else : ?>
                        <?= $data['areaText'] ?>에서<br />
                        <?= $data['jobText'] ?> 찾는중
                    <?php endif; ?>
                </div>
                <div class="plus_more_btn"><a href="/my/interest/main">더보기 <i class="la la-plus"></i></a></div>
            </div>
            <!--e mtltBox-->

            <!--s lkfBox-->
            <div class="lkfBox cont <?= $data['jobAreaState'] == 'noRec' ? 'hide' : '' ?>">
                <!--s lkfUl-->
                <div class="lkfUl">
                    <!--s lkf_sl-->
                    <div class="lkf_sl">
                        <!--s 무한루프-->

                        <?php if ($data['jobAreaState'] == 'none') : ?>
                            관심직무와 관심지역을 선택해주세요.
                        <?php elseif ($data['jobAreaState'] == 'noRec') : ?>
                            일치하는 공고가 없습니다.
                        <?php else : ?>
                            <? foreach ($data['jobArea'][0] as $jobAreaKey => $jobAreaVal) : ?>
                                <!--s item-->
                                <div class="item">
                                    <!--s itemBox-->
                                    <div class="itemBox">
                                        <a href="/jobs/detail/<?= $jobAreaVal['idx'] ?>">
                                            <div class="img"><img src="<?= $data['url']['media'] ?><?= $jobAreaVal['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                        </a>

                                        <!--s txtBox-->
                                        <div class="txtBox">
                                            <a href="javascript:void(0)">
                                                <div class="tlt"><?= $jobAreaVal['com_name'] ?></div>
                                                <div class="product_desc"><?= $jobAreaVal['rec_title'] ?></div>
                                            </a>

                                            <!--s gtxtBox-->
                                            <div class="gtxtBox">
                                                <div class="gdata">D-13</div>

                                                <!--s gBtnBox-->
                                                <div class="gBtnBox">
                                                    <div class="gtxt">
                                                        <?= $jobAreaVal['area_depth_text_1'] ?>.<?= $jobAreaVal['area_depth_text_2'] ?> <span>|</span>
                                                        <?php if ($jobAreaVal['rec_career'] == 'A') : ?>
                                                            경력부관
                                                        <?php elseif ($jobAreaVal['rec_career'] == 'C') : ?>
                                                            경력
                                                        <?php elseif ($jobAreaVal['rec_career'] == 'N') : ?>
                                                            신입
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="gBtn"><a href="/jobs/detail/<?= $jobAreaVal['idx'] ?>">지원하기</a></div>
                                                </div>
                                                <!--e gBtnBox-->
                                            </div>
                                            <!--e gtxtBox-->
                                        </div>
                                        <!--e txtBox-->

                                        <!--s bookmark_iconBox-->
                                        <div class="bookmark_iconBox">
                                            <?php if ($data['session']['idx']) : ?>
                                                <?php if ($data['jobAreaScrap'][$jobAreaKey] == 1) : ?>
                                                    <button id="scrapJobArea<?= $jobAreaKey ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-section="jobarea" data-scrap="delete" data-state="recruit" data-idx="<?= $jobAreaVal['idx'] ?>" data-key="<?= $jobAreaKey ?>" data-rec-idx="<?= $jobAreaVal['idx'] ?>">
                                                        <span class="blind">스크랩</span>
                                                    </button>
                                                <?php else : ?>
                                                    <button id="scrapJobArea<?= $jobAreaKey ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-section="jobarea" data-scrap="add" data-state="recruit" data-idx="<?= $jobAreaVal['idx'] ?>" data-key="<?= $jobAreaKey ?>" data-rec-idx="<?= $jobAreaVal['idx'] ?>">
                                                        <span class="blind">스크랩</span>
                                                    </button>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <button class="bookmark_icon btn-scrap on" tabindex="0"><span class="blind">스크랩</span></button>
                                            <?php endif; ?>
                                        </div>
                                        <!--e bookmark_iconBox-->
                                    </div>
                                    <!--e itemBox-->
                                </div>
                                <!--e item-->
                            <? endforeach; ?>
                        <?php endif; ?>

                        <!--e 무한루프-->
                    </div>
                    <!--e lkf_sl-->
                </div>
                <!--e lkfUl-->
            </div>
            <!--e lkfBox-->
        <?php endif; ?>

        <?php if ($data['comTag']) : ?>
            <!--s company_fdBox-->
            <div class="company_fdBox">
                <!--s mtltBox-->
                <div class="mtltBox mt_t70">
                    <div class="mtlt cont">내 맘에 쏙 드는 회사 찾기</div>
                </div>
                <!--e mtltBox-->

                <!--s company_fdcont-->
                <div class="company_fdcont">
                    <!--s cont-->
                    <div class="cont">

                        <!--s company_fd_slBox-->
                        <div class="company_fd_slBox">
                            <!--s company_fd_sl-->
                            <div class="company_fd_sl">
                                <!--s 무한루프-->

                                <?php foreach ($data['comTag'] as $comTagKey => $comTagVal) : ?>
                                    <div class="item">
                                        <!--s company_fd_txtBox-->
                                        <div class="company_fd_txtBox">
                                            <!--s txtBox-->
                                            <div class="txtBox">
                                                <div class="tlt"><?= $comTagVal['tag_txt_content'] ?></div>
                                                <div class="tag"># <?= $comTagVal['tag_txt'] ?></div>
                                            </div>
                                            <!--e txtBox-->

                                            <div class="crcBox"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/cfd_crc01.png"></div>
                                        </div>
                                        <!--e company_fd_txtBox-->

                                        <!--s company_fd_wBox-->
                                        <div class="company_fd_wBox">
                                            <!--s ul-->
                                            <ul>
                                                <?php foreach ($data['tagInfo'][$comTagKey] as $tagInfoKey => $tagInfoVal) : ?>
                                                    <li>
                                                        <a href="/jobs/detail/<?= $tagInfoVal['recIdx'] ?>">
                                                            <div class="img"><img src="<?= $data['url']['media'] ?><?= $tagInfoVal['fileSave'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>

                                                            <?php if (count($tagInfoVal) != 0) : ?>
                                                                <!--s txtBox-->
                                                                <div class="txtBox">
                                                                    <div class="tlt"><?= $tagInfoVal['comName'] ?></div>
                                                                    <div class="product_desc"><?= $tagInfoVal['recTitle'] ?></div>
                                                                    <div class="gtxt"><?= $tagInfoVal['areaDepth1'] ?> <span>|</span> <?= $tagInfoVal['recCareer'] ?></div>
                                                                </div>
                                                                <!--e txtBox-->

                                                                <!--s bookmark_iconBox-->
                                                                <div class="bookmark_iconBox">
                                                                    <?php if ($data['session']['idx']) : ?>
                                                                        <?php if ($data['comTagScrap'][$comTagKey][$tagInfoKey] == 1) : ?>
                                                                            <button id="scrapTag<?= $comTagKey ?>_<?= $tagInfoKey ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-section="tag" data-scrap="delete" data-state="recruit" data-idx="<?= $tagInfoVal['recIdx'] ?>" data-key="<?= $comTagKey ?>_<?= $tagInfoKey ?>" data-rec-idx="<?= $tagInfoVal['recIdx'] ?>">
                                                                                <span class="blind">스크랩</span>
                                                                            </button>
                                                                        <?php else : ?>
                                                                            <button id="scrapTag<?= $comTagKey ?>_<?= $tagInfoKey ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-section="tag" data-scrap="add" data-state="recruit" data-idx="<?= $tagInfoVal['recIdx'] ?>" data-key="<?= $comTagKey ?>_<?= $tagInfoKey ?>" data-rec-idx="<?= $tagInfoVal['recIdx'] ?>">
                                                                                <span class="blind">스크랩</span>
                                                                            </button>
                                                                        <?php endif; ?>
                                                                    <?php else : ?>
                                                                        <button class="bookmark_icon btn-scrap off" tabindex="0">
                                                                            <span class="blind">스크랩</span>
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!--e bookmark_iconBox-->

                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <!--e ul-->

                                            <!--s more_btn-->
                                            <div class="more_btn">
                                                <a href="/company/tag?tagCheck%5B%5D=<?= $comTagVal['idx'] ?>"><?= $comTagVal['tag_txt'] ?> 더보기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
                                            </div>
                                            <!--e more_btn-->
                                        </div>
                                        <!--e company_fd_wBox-->
                                    </div>
                                <?php endforeach; ?>

                                <!--s 무한루프-->
                            </div>
                            <!--e company_fd_sl-->
                        </div>
                        <!--e company_fd_slBox-->
                    </div>
                    <!--e cont-->
                </div>
                <!--e company_fdcont-->
            </div>
            <!--s company_fdBox-->
        <?php endif; ?>

        <!--s gu_mvBox-->
        <div class="gu_mvBox cont">
            <a href="/help/guide/interview"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/gu_mv_bn.png"></a>
        </div>
        <!--e gu_mvBox-->

        <!--s mtltBox-->
        <div class="mtltBox mt_t70 cont">
            <div class="mtlt">요즘 뜨는 기업에서<br />팀원 모집 중</div>
        </div>
        <!--e mtltBox-->

        <!--s team_mbBox-->
        <div class="team_mbBox cont">
            <!--s team_mb_Ul-->
            <div class="team_mb_Ul">
                <!--s team_mb_sl-->
                <div class="team_mb_sl">
                    <!--s 무한루프-->

                    <?php foreach ($data['issue'] as $issueKey => $issueVal) : ?>
                        <!--s item-->
                        <div class="item">
                            <a href="/jobs/detail/<?= $issueVal['idx'] ?>">
                                <!--s itemBox-->
                                <div class="itemBox">
                                    <div class="img"><img src="<?= $data['url']['media'] ?><?= $issueVal['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>

                                    <!--s txtBox-->
                                    <div class="txtBox">
                                        <div class="tlt"><?= $issueVal['com_name'] ?></div>
                                        <div class="product_desc"><?= $issueVal['rec_title'] ?></div>
                                        <?php if ($issueVal['rec_apply'] == 'M' || $issueVal['rec_apply'] == 'A') : ?>
                                            <div class="stxt">내 인터뷰로 지원 가능</div>
                                        <?php endif; ?>

                                        <div class="gtxtBox">
                                            <div class="gtxt">
                                                <?= $issueVal['area_depth_text_1'] ?>.<?= $issueVal['area_depth_text_2'] ?> <span>|</span>
                                                <?php if ($issueVal['rec_career'] == 'A') : ?>
                                                    경력무관
                                                <?php elseif ($issueVal['rec_career'] == 'C') : ?>
                                                    경력
                                                <?php elseif ($issueVal['rec_career'] == 'N') : ?>
                                                    신입
                                                <?php endif; ?>
                                            </div>
                                            <!-- <div class="gdata">D-13</div> -->
                                            <div class="gdata"><?= $data['issueDday'][$issueKey] ?></div>
                                        </div>
                                    </div>
                                    <!--e txtBox-->

                                    <!--s bookmark_iconBox-->
                                    <div class="bookmark_iconBox">
                                        <?php if ($data['session']['idx']) : ?>
                                            <?php if ($data['issueScrap'][$issueKey] == 1) : ?>
                                                <button id="scrapIssue<?= $issueKey ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-section="issue" data-scrap="delete" data-state="recruit" data-idx="<?= $issueVal['idx'] ?>" data-key="<?= $issueKey ?>" data-rec-idx="<?= $issueVal['idx'] ?>">
                                                    <span class="blind">스크랩</span>
                                                </button>
                                            <?php else : ?>
                                                <button id="scrapIssue<?= $issueKey ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-section="issue" data-scrap="add" data-state="recruit" data-idx="<?= $issueVal['idx'] ?>" data-key="<?= $issueKey ?>" data-rec-idx="<?= $issueVal['idx'] ?>">
                                                    <span class="blind">스크랩</span>
                                                </button>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <button class="bookmark_icon btn-scrap off" tabindex="0">
                                                <span class="blind">스크랩</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <!--e bookmark_iconBox-->
                                </div>
                                <!--e itemBox-->
                            </a>
                        </div>
                        <!--e item-->
                    <?php endforeach; ?>

                    <!--e 무한루프-->
                </div>
                <!--e team_mb_sl-->
            </div>
            <!--e team_mb_Ul-->
        </div>
        <!--e team_mbBox-->

        <!--s mtltBox-->
        <div class="mtltBox mt_t70 cont">
            <div class="mtlt">실제 면접 질문 연습하기</div>
        </div>
        <!--e mtltBox-->

        <!--s qsBox-->
        <div class="qsBox">
            <!--s qs_sl-->
            <div class="qs_sl">
                <!--s 무한루프-->
                <?php foreach ($data['nos'] as $nosVal) : ?>
                    <!--s item-->
                    <div class="item">
                        <a href="/interview/preview/<?= $nosVal['idx'] ?>">
                            <div class="tlt">
                                <?= $nosVal['rec_nos_title'] ?>
                            </div>
                            <div class="Btn"><i class="la la-angle-right"></i></div>
                        </a>
                    </div>
                    <!--e item-->
                <?php endforeach; ?>
                <!--e 무한루프-->
            </div>
            <!--e qs_sl-->
        </div>
        <!--e qsBox-->

        <?php if ($data['session']['idx'] && $data['comInfo']) : ?>
            <!--s cont-->
            <div class="cont">
                <!--s mtltBox-->
                <div class="mtltBox mt_t70">
                    <div class="mtlt">
                        여기 추천해요 !<br />
                        <span class="point"><?= $data['session']['name'] ?></span>님과 핏이 잘 맞는 기업
                    </div>
                </div>
                <!--e mtltBox-->

                <!--s perfitUl-->
                <ul class="perfitUl">
                    <!--s 무한루프-->
                    <?php
                    foreach ($data['comInfo'] as $key => $val) :
                    ?>
                        <li>
                            <!--s itemBox-->
                            <div class="itemBox">
                                <a href="/company/detail/<?= $val[0]['idx'] ?>">
                                    <div class="img">
                                        <span class="ai_txt">A.I. 추천</span>
                                        <img src="<?= $data['url']['media'] ?><?= $val[0]['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                    </div>
                                </a>

                                <!--s txtBox-->
                                <div class="txtBox">
                                    <a href="/company/detail/<?= $val[0]['idx'] ?>">
                                        <div class="tlt"><?= $val[0]['com_name'] ?></div>
                                    </a>
                                    <div class="gtxt"><?= $val[0]['com_address'] ?></div>

                                    <!--s gBtn-->
                                    <div class="gBtn">
                                        <a href="/search/action?keyword=<?= $val[0]['com_name'] ?>&type=recruit">채용공고 <?= $val[0]['recCnt'] ?>건 보러가기</a>
                                    </div>
                                    <!--e gBtn-->
                                </div>
                                <!--e txtBox-->

                                <!--s bookmark_iconBox-->
                                <div class="bookmark_iconBox">
                                    <?php if ($data['scrapCom'][$key] == 1) : ?>
                                        <button id="scrapFit<?= $key ?>" class="bookmark_icon btn-scrap on" tabindex="0" data-section="fit" data-scrap="delete" data-state="company" data-idx="<?= $val[0]['idx'] ?>" data-key="<?= $key ?>">
                                            <span class="blind">스크랩</span>
                                        </button>
                                    <?php else : ?>
                                        <button id="scrapFit<?= $key ?>" class="bookmark_icon btn-scrap off" tabindex="0" data-section="fit" data-scrap="add" data-state="company" data-idx="<?= $val[0]['idx'] ?>" data-key="<?= $key ?>">
                                            <span class="blind">스크랩</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <!--e bookmark_iconBox-->
                            </div>
                            <!--e itemBox-->
                        </li>

                    <?php endforeach ?>
                    <!--e 무한루프-->
                </ul>
                <!--e perfitUl-->

                <!--s perfit_moreBtn-->
                <div class="perfit_moreBtn">
                    <a href="/my/perfit">기업 더보기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
                </div>
                <!--e perfit_moreBtn-->
            </div>
            <!--e cont-->
        <?php endif; ?>


        <!--s perfit_bn-->
        <div class="perfit_bn cont" style="margin-top: 30px;">
            <a href="/interview/ready"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/perfit_bn.png"></a>
        </div>
        <!--e perfit_bn-->

        <!--s mtltBox-->
        <!-- <div class="mtltBox mt_t70 cont">
            <div class="mtlt">
                <span class="tlt_span">다들 어떻게 인터뷰했을까?<br />A.I. 리포트 구경가기</span>
                <span class="toolp_span"><a href="javascript:void(0)" class="ai_report_pop_open">?</a></span>
            </div>
            <div class="plus_more_btn"><a href="javascript:void(0)">더보기 <i class="la la-plus"></i></a></div>
        </div> -->
        <!--e mtltBox-->

        <!--s ai_reportBox-->
        <!-- <div class="ai_reportBox">
            <div class="ai_report_sl c">
                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="img"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/pic_test.jpg"></div>
                        <div class="classBox"><span class="point">A</span>등급 / <span class="point">65</span>점</div>
                        <div class="jopBox">IT – 솔루션 영업</div>
                        <div class="psBox">상위 <span class="point">10%</span></div>
                    </a>
                </div>

                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="img"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/pic_test.jpg"></div>
                        <div class="classBox"><span class="point"></span>등급 / <span class="point"></span>점</div>
                        <div class="jopBox">직무</div>
                        <div class="psBox">전체 지원자 중 위치</div>
                    </a>
                </div>

                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="img"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/pic_test.jpg"></div>
                        <div class="classBox"><span class="point">A</span>등급 / <span class="point">65</span>점</div>
                        <div class="jopBox">IT – 솔루션 영업</div>
                        <div class="psBox">상위 <span class="point">10%</span></div>
                    </a>
                </div>

                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="img"><img src="<?= $data['url']['menu'] ?>/static/www/img/main/pic_test.jpg"></div>
                        <div class="classBox"><span class="point"></span>등급 / <span class="point"></span>점</div>
                        <div class="jopBox">직무</div>
                        <div class="psBox">전체 지원자 중 위치</div>
                    </a>
                </div>
            </div>
        </div> -->
        <!--e ai_reportBox-->

        <!--s cont-->
        <div class="cont">
            <!--s mtltBox-->
            <div class="mtltBox mt_t70">
                <div class="mtlt">쉬어가는 가벼운 글</div>
                <div class="plus_more_btn"><a href="/board/rest">더보기 <i class="la la-plus"></i></a></div>
            </div>
            <!--e mtltBox-->

            <!--s gbwBox-->
            <div class="gbwBox">
                <ul>
                    <?php foreach ($data['rest'] as $restVal) : ?>
                        <li>
                            <a href="/board/rest/detail/<?= $restVal['idx'] ?>">
                                <div class="img"><img src="<?= $data['url']['media'] ?><?= $restVal['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></div>
                                <div class="txt">
                                    <?= $restVal['bd_title'] ?>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!--e gbwBox-->

            <?php if (count($data['event']) != 0) : ?>
                <div class="mtltBox mt_t70">
                    <div class="mtlt">진행중인 이벤트</div>
                    <div class="plus_more_btn"><a href="/board/event">더보기 <i class="la la-plus"></i></a></div>
                </div>

                <!--s mbottom_bn_slBox-->
                <div class="mbottom_bn_slBox">
                    <!--s control_box-->
                    <div class="control_box">
                        <a href="javascript:void(0)">
                            <span class="pagingInfo mg_r_0"></span>
                            <!-- <span class="plus_more_btn"><i class="la la-plus"></i></span> -->
                        </a>
                    </div>
                    <!--e control_box-->

                    <!--s mbottom_bn_sl-->
                    <div class="mbottom_bn_sl">
                        <?php foreach ($data['event'] as $eventKey => $eventVal) : ?>
                            <div class="item">
                                <a href="/board/event/<?= $eventVal['idx'] ?>">
                                    <img src="<?= $data['url']['media'] ?><?= $eventVal['file_save_name'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!--e mbottom_bn_sl-->
                </div>
                <!--e mbottom_bn_slBox-->
            <?php endif; ?>

        </div>
        <!--e cont-->
    </div>
    <!--e #mcontent-->

    <!--s A.I. 리포트 구경가기 모달-->
    <div id="ai_report_mb" class="pop_modal">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="tlt">A.I. 리포트 구경하기</div>

                <div class="txt">
                    잘 나온 인터뷰의 AI리포트는<br />
                    공개설정 > [내 리포트 자랑하기] 를 통해<br />
                    공개할 수 있어요!
                </div>

                <div class="stxt">
                    *공개 설정 전인 리포트는 <br />
                    오직 나만 볼 수 있으니 안심하세요
                </div>
            </div>
            <!--e pop_cont-->
            <div class="okBox spop_close">확인</div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e A.I. 리포트 구경가기 모달-->

    <!--s 점검안내 모달-->
    <div id="notice_modal" class="pop_modal">
        <!--s pop_Box-->
        <div class="spop_Box" style="max-width: 440px;border-radius: 0px;">
            <!--s pop_cont-->
            <div class="spop_cont c" style="padding: 0px 0px;">
                <img src="https://highbuff.com/person/board/data/editor/2207/ad2c328638bc3b2aaac830d48fdb07c2_1657693484_0965.png" alt="">
                <!--s interview_pop_BtnBox-->
                <div class="interview_pop_BtnBox" style="display: flex;justify-content: flex-end;align-items: center;">
                    <div class="interview_pop_chk_setBox" style="margin-right: 10px;">
                        <label for="interview_pop_chk_set">
                            <input type="checkbox" class="interview_pop_chk" id="interview_pop_chk_set" style="position: relative;top: -2px;"> <span class="" style="position: relative;top: -1px;font-size: 15px;">다시보지않기</span>
                        </label>
                    </div>

                    <div class="interview_pop_close_btn" style="margin-right: 10px;position: relative;top: -2px;"><a href="javascript:void(0)"><img src="/static/www/img/sub/itv_pr_file_close.png" style="width: 13px;"></a></div>
                </div>
                <!--e interview_pop_BtnBox-->
            </div>
            <!--e pop_Box-->
        </div>
    </div>
    <!--e 점검안내 모달-->

    <!--s 비밀번호 변경 모달-->
    <div id="reset_pop" class="pop_modal">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont" style="padding: 40px 40px ">
                <div class="tlt">비밀번호를 변경해주세요 !</div>
                <div class="txt">
                    6개월 이상 비밀번호가 변경되지 않았습니다.<br />
                    마이페이지 > [내 정보 수정하기] 에서<br />
                    비밀번호를 변경하실 수 있습니다.
                </div>
            </div>
            <!--e pop_cont-->
            <div class="spopBtn radius_none">
                <a href="/my/resetPwd" class="spop_btn02">변경하러가기</a>
                <a href="javascript:void(0)" class="spop_btn01" id="nextTimeMonth">한달동안 보지 않기</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e 비밀번호 변경 모달-->

    <!--s 비밀번호 변경 모달 (1달)-->
    <div id="month_reset_pop" class="pop_modal">
        <!--s pop_Box-->
        <div class="spop_Box c">
            <!--s pop_cont-->
            <div class="spop_cont" style="padding: 40px 40px ">
                <div class="tlt">비밀번호를 변경해주세요 !</div>
                <div class="txt">
                    1개월 이상 비밀번호가 변경되지 않았습니다.<br />
                    마이페이지 > [내 정보 수정하기] 에서<br />
                    비밀번호를 변경하실 수 있습니다.
                </div>
            </div>
            <!--e pop_cont-->
            <div class="spopBtn radius_none">
                <a href="/my/resetPwd" class="spop_btn02">변경하러가기</a>
                <a href="javascript:void(0)" class="spop_btn01" id="nextTimeMonth">한달동안 보지 않기</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!--e 비밀번호 변경 모달-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-rwdImageMaps/1.6/jquery.rwdImageMaps.min.js"></script>

    <script>
        const memIdx = '<?= $data['memIdx'] ?>';
        const emlCsrf = $("input[name='csrf_highbuff']");
        $(document).ready(function() {
            //A.I. 리포트 구경가기 모달
            $('.ai_report_pop_open').modal({
                target: '#ai_report_mb',
                speed: 350,
                easing: 'easeInOutExpo',
                animation: 'bottom',
                //position: '5% auto',
                overlayClose: false,
                close: '.spop_close'
            });

            $('img[usemap]').rwdImageMaps();

            //점검 모달 띄우는 스크립트
            // if (getCookie('notice') != 'false') {
            //     $('#notice_modal').modal('view', {
            //         target: '#notice_modal',
            //         speed: 350,
            //         easing: 'easeInOutExpo',
            //         animation: 'bottom',
            //         //position: '5% auto',
            //         overlayClose: false,
            //         close: '.spop_close'
            //     });
            // }

            if (getCookie('pwdChange') != 'false') {
                if ('<?= $data["resetPwd"]['month6'] ?>' && !'<?= $data["sns"] ?>') { //sns 가 true 이면 sns 로그인
                    $('#reset_pop').modal('view', {
                        target: '#reset_pop',
                        speed: 350,
                        easing: 'easeInOutExpo',
                        animation: 'bottom',
                        //position: '5% auto',
                        overlayClose: false,
                        close: '.spop_close'
                    });
                }
            }

            if ('<?= $data["resetPwd"]['month1'] ?>' && !'<?= $data["sns"] ?>') { //sns 가 true 이면 sns 로그인
                $('#month_reset_pop').modal('view', {
                    target: '#month_reset_pop',
                    speed: 350,
                    easing: 'easeInOutExpo',
                    animation: 'bottom',
                    //position: '5% auto',
                    overlayClose: false,
                    close: '.spop_close'
                });
            }
        });

        $('.interview_pop_close_btn').on('click', function() {
            if ($('#interview_pop_chk_set').is(':checked')) {
                setCookie('notice', 'false', '1');
                $('#notice_modal').modal('close');
            } else {
                $('#notice_modal').modal('close');
            }
        })

        $('#nextTime').on('click', function() {
            setCookie('pwdChange', 'false', '1');
            $('#reset_pop').modal('close');
        })

        $('#nextTimeMonth').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/api/member/nextMonth',
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val()
                },
                success: function(data) {
                    $('#month_reset_pop').modal('close');
                    $('#reset_pop').modal('close');
                },
                error: function(e) {
                    alert(e.statusText);
                    return;
                },
            });
        })

        function setCookie(name, value, exp) {
            let date = new Date();
            date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
            document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
        };

        function getCookie(name) {
            let value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
            return value ? value[2] : null;
        };

        $('.btn-scrap').on('click', function() {
            event.preventDefault();

            if (!'<?= $data['memIdx'] ?>') {
                alert('로그인이 필요한 서비스 입니다.');
                location.href = '/login';
            } else {
                const emlThis = $(this);
                const section = emlThis.data('section');
                const strStrap = emlThis.data('scrap');
                const iState = emlThis.data('state');
                const iRecOrComIdx = emlThis.data('idx');
                const iKey = emlThis.data('key');

                scrap(section, iState, iRecOrComIdx, iKey, strStrap);

                // emlThis.data('scrap', strStrap == 'add' ? 'delete' : 'add');
                $('[data-rec-idx=' + iRecOrComIdx + ']').each(function() {
                    const thisEle = $(this);
                    if (thisEle.hasClass('on')) {
                        thisEle.removeClass('on');
                        thisEle.addClass('off');
                        emlThis.data('scrap', strStrap == 'add' ? 'delete' : 'add');
                    } else {
                        thisEle.removeClass('off');
                        thisEle.addClass('on');
                        emlThis.data('scrap', strStrap == 'add' ? 'delete' : 'add');
                    }
                });
            }
        });

        function scrap(section, state, recOrComIdx, key, strStrap) {
            $.ajax({
                type: "GET",
                url: `/api/my/scrap/${strStrap}/${state}/${memIdx}/${recOrComIdx}`,
                success: function(data) {
                    if (data.status == 200) {
                        if (strStrap == 'add') {
                            if (state == 'company') {
                                if (section = 'fit') {
                                    let scrapFit = $('#scrapFit' + key);
                                    scrapFit.removeClass('off');
                                    scrapFit.addClass('on');
                                }
                            } else if (state == 'recruit') {
                                if (section == 'issue') {
                                    let scrapIssue = $('#scrapIssue' + key);
                                    scrapIssue.removeClass('off');
                                    scrapIssue.addClass('on');
                                } else if (section == 'tag') {
                                    let scrapTag = $('#scrapTag' + key);
                                    scrapTag.removeClass('off');
                                    scrapTag.addClass('on');
                                } else if (section == 'jobarea') {
                                    let scrapJobArea = $('#scrapJobArea' + key);
                                    scrapJobArea.removeClass('off');
                                    scrapJobArea.addClass('on');
                                }
                            }
                        } else if (strStrap == 'delete') {
                            if (state == 'company') {
                                if (section = 'fit') {
                                    let scrapFit = $('#scrapFit' + key);
                                    scrapFit.removeClass('on');
                                    scrapFit.addClass('off');
                                }
                            } else if (state == 'recruit') {
                                if (section == 'issue') {
                                    let scrapIssue = $('#scrapIssue' + key);
                                    scrapIssue.removeClass('on');
                                    scrapIssue.addClass('off');
                                } else if (section == 'tag') {
                                    let scrapTag = $('#scrapTag' + key);
                                    scrapTag.removeClass('on');
                                    scrapTag.addClass('off');
                                } else if (section == 'jobarea') {
                                    let scrapJobArea = $('#scrapJobArea' + key);
                                    scrapJobArea.removeClass('on');
                                    scrapJobArea.addClass('off');
                                }
                            }
                        }
                    } else {
                        alert(data.messages);
                    }
                },
                error: function(e) {
                    alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 '하이버프'로 문의 부탁드립니다.");
                    return;
                },
            })
        }
    </script>