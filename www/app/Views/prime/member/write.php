<?php if (0) : ?>
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">지원자 회원정보</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="box">
                        <form id="frm" method="post" action="/prime/member/write/action">
                            <input type="hidden" name="memIdx" value="<?= $data['list']['memIdx'] ?? '' ?>" />
                            <input type="hidden" name="backUrl" value="/prime/member/write/<?= $data['list']['memIdx'] ?? '' ?>" />
                            <?php if ($data['state'] == 'write') : ?>
                                <input type="hidden" name="postCase" value="member_write" />
                            <?php else : ?>
                                <input type="hidden" name="postCase" value="member_update" />
                            <?php endif; ?>
                            <?= csrf_field() ?>
                            <table class="table" style="border-bottom: 1px solid #dee2e6;">
                                <colgroup>
                                    <col style="background-color: #ccc;width: 150px">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>회원타입 <span class='point'><?= ($data['list']['delyn'] ?? '') === 'Y' ? '탈퇴회원' : '' ?></span></td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memType" id="memType1" value="M" <?= ($data['list']['memType'] ?? '') == 'M' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memType1">회원</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memType" id="memType2" value="C" <?= ($data['list']['memType'] ?? '') == 'C' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memType2">기업</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memType" id="memType3" value="L" <?= ($data['list']['memType'] ?? '') == 'L' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memType3">라벨러</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memType" id="memType4" value="A" <?= ($data['list']['memType'] ?? '') == 'A' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memType4">관리자</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>프로필 사진</td>
                                        <td>
                                            <div class='img_box' style='width:100px'>
                                                <img style='width:100%' src='<?= $data['url']['media'] ?><?= $data['list']['fileSaveName'] ?? '/data/no_img.png' ?>' onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>아이디</td>
                                        <td>
                                            <?php if ($data['state'] == 'write') : ?>
                                                <input type="text" name="memId" value="">
                                            <?php else : ?>
                                                <?= $data['list']['memId'] ?? '' ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php if ($data['state'] == 'write') : ?>
                                        <tr>
                                            <td>비밀번호</td>
                                            <td>
                                                <input type="text" name="memPass" value="">
                                                * 비밀번호를 8자리이상 입력해주세요.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>이름</td>
                                        <td>
                                            <?php if ($data['state'] == 'write') : ?>
                                                <input type="text" name="memName" value="">
                                            <?php else : ?>
                                                <?= $data['list']['memName'] ?? '' ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>전화번호</td>
                                        <td>
                                            <?php if ($data['state'] == 'write') : ?>
                                                <input type="text" name="memTel" value="">
                                            <?php else : ?>
                                                <?= $data['list']['memTel'] ?? '' ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>나이</td>
                                        <td>
                                            <input type="text" name="memAge" value="<?= $data['list']['memAge'] ?? '' ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>재직여부</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memWorkState" id="memWorkState1" value="Y" <?= ($data['list']['memWorkState'] ?? '') == 'Y' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memWorkState1">재직중</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memWorkState" id="memWorkState2" value="N" <?= ($data['list']['memWorkState'] ?? '') == 'N' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memWorkState2">구직중</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>성별</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memGender" id="memGender1" value="Y" <?= ($data['list']['memGender'] ?? '') == 'M' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memGender1">남자</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memGender" id="memGender2" value="N" <?= ($data['list']['memGender'] ?? '') == 'W' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memGender2">여자</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>경력</td>
                                        <td>
                                            <input type="text" name="memCareer" value="<?= $data['list']['memCareer'] ?? '' ?>" />개월
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>학력</td>
                                        <td>
                                            <input type="text" name="memEducation" value="<?= $data['list']['memEducation'] ?? '' ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>주소</td>
                                        <td>
                                            <input type="hidden" id="input_extraAddress" name="" value="" />
                                            <input type="text" id="input_postcode" name="memAddressPostcode" value="<?= $data['list']['memAddressPostcode'] ?? '' ?>" />
                                            <input type="text" id="input_address" name="memAddress" value="<?= $data['list']['memAddress'] ?? '' ?>" />
                                            <input type="text" id="input_detailAddress" name="memAddressDetail" value="<?= $data['list']['memAddressDetail'] ?? '' ?>" />
                                            <button class="btn" type="button" onclick="search_addr();">주소 찾기</button>
                                            <div id="addressLayer"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>전공</td>
                                        <td>
                                            <input type="text" name="memMajor" id="input_address" value="<?= $data['list']['memMajor'] ?? '' ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>이용약관</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType1" id="memPersonalType1_1" value="Y" <?= ($data['list']['memPersonalType1'] ?? '') == 'Y' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType1_1">동의</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType1" id="memPersonalType1_2" value="N" <?= ($data['list']['memPersonalType1'] ?? '') == 'N' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType1_2">비동의</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>맞춤채용</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType2" id="memPersonalType2_1" value="Y" <?= ($data['list']['memPersonalType2'] ?? '') == 'Y' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType2_1">동의</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType2" id="memPersonalType2_2" value="N" <?= ($data['list']['memPersonalType2'] ?? '') == 'N' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType2_2">비동의</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>푸시알림</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType3" id="memPersonalType3_1" value="Y" <?= ($data['list']['memPersonalType3'] ?? '') == 'Y' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType3_1">동의</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType3" id="memPersonalType3_2" value="N" <?= ($data['list']['memPersonalType3'] ?? '') == 'N' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType3_2">비동의</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>튜토리얼 보기</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType4" id="memPersonalType4_1" value="Y" <?= ($data['list']['memPersonalType4'] ?? '') == 'Y' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType4_1">동의</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType4" id="memPersonalType4_2" value="N" <?= ($data['list']['memPersonalType4'] ?? '') == 'N' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType4_2">비동의</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>취엽연계</td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType5" id="memPersonalType5_1" value="Y" <?= ($data['list']['memPersonalType5'] ?? '') == 'Y' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType5_1">동의</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="memPersonalType5" id="memPersonalType5_2" value="N" <?= ($data['list']['memPersonalType5'] ?? '') == 'N' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="memPersonalType5_2">비동의</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>희망연봉</td>
                                        <td>
                                            <div>
                                                <input type='number' name='left' min='24000' max='100000' value='<?= $data['list']['memPay'][0] ?? '' ?>' placeholder="단위 : 천원">
                                                <input type='number' name='right' min='24000' max='100000' value='<?= $data['list']['memPay'][1] ?? '' ?>' placeholder="단위 : 천원">
                                                단위 : 천원
                                            </div>
                                            <div>
                                                <label>1억이상
                                                    <input type='checkbox' value='100M' <?= ($data['list']['memPay'][1] ?? '') == '100000' ? 'checked' : '' ?>>
                                                    </lable>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>희망포지션</td>
                                        <td>
                                            <?= view_cell('\App\Libraries\CategoryLib::jobCategory', [
                                                'option' => 'mutl',
                                                'pageType' => 'left',
                                                'checked' => ($data['category'] ?? [])
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>희망지역</td>
                                        <td>
                                            <div class="position_ckBox">
                                                <ul>
                                                    <?php
                                                    if (count(($data['area'] ?? []))) :
                                                        foreach ($data['area'] as $key => $val) :
                                                    ?>
                                                            <li>
                                                                <div class="ck_radio">
                                                                    <input type="checkbox" id="area_<?= $val['idx'] ?>" name="area[]" value="<?= $val['idx'] ?>" <?= in_array($val['idx'], $data['myArea'] ?? []) ? 'checked' : ''; ?>>
                                                                    <label for="area_<?= $val['idx'] ?>"><?= $val['area_depth_text_1'] ?></label>
                                                                </div>
                                                            </li>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>방문횟수</td>
                                        <td>
                                            <?= $data['list']['memVisitCount'] ?? '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>마지막 비밀번호 변경일</td>
                                        <td>
                                            <?= $data['list']['memLastPasswordDate'] ?? '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>마지막 방문일</td>
                                        <td>
                                            <?= $data['list']['memVisitDate'] ?? '' ?>
                                        </td>
                                    </tr>
                                    <?php if (($data['list']['memType'] ?? '') === 'M' || $data['code'] === 'm') : ?>
                                        <tr>
                                            <td>공고 지원</td>
                                            <td>
                                                <a href='/prime/suggest/m/list?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>합격 횟수</td>
                                            <td>
                                                구현중
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>불합격 횟수</td>
                                            <td>
                                                구현중
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>받은 제안</td>
                                            <td>
                                                <a href='/prime/suggest/m/list?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>인터뷰</td>
                                            <td>
                                                <a href='/prime/interview/view?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>이력서</td>
                                            <td>
                                                <a href='/prime/resume/list?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a>
                                            </td>
                                        </tr>
                                    <?php elseif (($data['list']['memType'] ?? '') === 'C' || $data['code'] === 'c') : ?>
                                        <tr>
                                            <td>기업정보</td>
                                            <td>
                                                <span id="comName"><?= $data['list']['com_name'] ?? '' ?></span>
                                                <input type="text" id="comIdx" name="comIdx" value="<?= $data['list']['comIdx'] ?? '' ?>">
                                                <?php if ($data['state'] != 'write') : ?>
                                                    <a href='/prime/company/write/<?= $data['list']['comIdx'] ?? '' ?>'>기업정보수정</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php if ($data['state'] == 'write') : ?>
                                                    기업등록
                                                <?php else : ?>
                                                    기업변경
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href='javascript:void(0)' onclick="fnShowPop('change_company')">기업검색</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <input type="submit" value="저장" class="btn btn-success float-right">
                        </form>

                        <form id="member_delete" method="post" action="/prime/member/delete/action">
                            <input type="hidden" name="memIdx" value="<?= $data['list']['memIdx'] ?? '' ?>" />
                            <input type="hidden" name="backUrl" value="/prime/member/write/<?= $data['list']['memIdx'] ?? '' ?>" />
                            <input type="hidden" name="postCase" value="member_delete" />
                            <?= csrf_field() ?>
                            <?php if ($data['state'] == 'update') : ?>
                                <input type="button" id="deleteBtn" value="삭제" class="btn btn-delete float-left">
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->

    <!-- s 기업 변경하기 팝업 -->
    <div id="change_company" class="pop_modal2">
        <!--s pop_Box-->
        <div class="spop_Box c" style="text-align: center;">
            <!--s pop_cont-->
            <div class="spop_cont">
                <div class="stxt black">
                    기업검색<br /><br />
                    <input name="searchText" id="searchText" type="text" value="" placeholder="아이디, 기업명, 연락처로 검색하세요." style="width:50%;">
                    <input type="submit" value="검색" onclick="seachCom()">
                </div>

                <div style="display: flex;justify-content: space-around;font-weight:bold;margin-top:30px;margin-bottom:10px;">
                    <div style="width: 30%;">기업명</div>
                    <div style="width: 30%;">대표명</div>
                    <div style="width: 30%;">변경</div>
                </div>
                <div id="searchCom" style="height: 100px;overflow:auto;"></div>
            </div>
            <!--e pop_cont-->

            <div class="spopBtn">
                <a href="#n" class="spop_btn01 wps_100 spop_close" style="width:100%;" onclick="fnHidePop('change_company')">취소</a>
            </div>
        </div>
        <!--e pop_Box-->
    </div>
    <!-- e 기업 변경하기 -->

<?php endif; ?>

<div class="content_title">
    <input type="submit" value="저장" id="submitBtn" class="btn btn-success float-right">
    <?php if (($data['list']['delyn'] ?? '') === 'N') : ?>
        <h3>회원 상세 <span class="point">[<?= $data['list']['memName'] ?? '' ?>] ID: <?= $data['list']['memIdx'] ?? '' ?></span></h3>

    <?php elseif (($data['list']['delyn'] ?? '') === 'Y') : ?>
        <h3>회원 상세 <span class="point3">[-] ID: <?= $data['list']['memIdx'] ?? '' ?> (탈퇴회원)</span></h3>
    <?php else : ?>
        <h3>회원 가입</h3>
    <?php endif; ?>
</div>

<h4>기본정보</h4>

<div class="t1 l">
    <form id="frm" method="post" action="/prime/member/write/action">
        <input type="hidden" name="memIdx" value="<?= $data['list']['memIdx'] ?? '' ?>" />
        <input type="hidden" name="backUrl" value="/prime/member/write/<?= $data['code'] ?>/<?= $data['list']['memIdx'] ?? '' ?>" />
        <?php if ($data['state'] == 'write') : ?>
            <input type="hidden" name="postCase" value="member_write" />
        <?php else : ?>
            <input type="hidden" name="postCase" value="member_update" />
        <?php endif; ?>
        <?= csrf_field() ?>
        <table>
            <colgroup>
                <col class="wps_20">
                <col class="wps_30">
                <col class="wps_20">
                <col class="wps_30">
            </colgroup>
            <tbody>
                <tr>
                    <th>회원유형</th>
                    <td colspan="3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memType" id="memType1" value="M" <?= ($data['list']['memType'] ?? '') == 'M' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memType1">회원</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memType" id="memType2" value="C" <?= ($data['list']['memType'] ?? '') == 'C' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memType2">기업</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memType" id="memType3" value="L" <?= ($data['list']['memType'] ?? '') == 'L' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memType3">라벨러</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memType" id="memType4" value="A" <?= ($data['list']['memType'] ?? '') == 'A' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memType4">관리자</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>프로필 이미지</th>
                    <td colspan="3"> <img src='<?= $data['url']['media'] ?><?= $data['list']['fileSaveName'] ?? '/data/no_img.png' ?>' onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'"></td>
                </tr>
                <tr>
                    <th>이메일</th>
                    <td><input type="text" name="memId" value="<?= $data['list']['memId'] ?? '' ?>"></td>
                    <th>비밀번호</th>
                    <td><?php if ($data['state'] === 'write') : ?><input type="text" name="memPass" value=""><?php endif; ?></td>
                </tr>
                <tr>
                    <th>이름</th>
                    <td><input type="text" name="memName" value="<?= $data['list']['memName'] ?? '' ?>"></td>
                    <th>연락처</th>
                    <td> <input type="text" name="memTel" value="<?= $data['list']['memTel'] ?? '' ?>" maxlength="11"></td>
                </tr>
                <tr>
                    <th>나이</th>
                    <td> <input type="text" name="memAge" value="<?= $data['list']['memAge'] ?? '' ?>" /></td>
                    <th></th>
                    <td></td>
                </tr>
                <tr>
                    <th>재직여부</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memWorkState" id="memWorkState1" value="Y" <?= ($data['list']['memWorkState'] ?? '') == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memWorkState1">재직중</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memWorkState" id="memWorkState2" value="N" <?= ($data['list']['memWorkState'] ?? '') == 'N' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memWorkState2">구직중</label>
                        </div>
                    </td>
                    <th>성별</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memGender" id="memGender1" value="M" <?= ($data['list']['memGender'] ?? '') == 'M' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memGender1">남자</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memGender" id="memGender2" value="W" <?= ($data['list']['memGender'] ?? '') == 'W' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memGender2">여자</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>경력</th>
                    <td> <input type="text" name="memCareer" value="<?= $data['list']['memCareer'] ?? '' ?>">개월</td>
                    <th>주소</th>
                    <td>
                        <input type="hidden" id="input_extraAddress" name="" value="" />
                        <input type="text" id="input_postcode" name="memAddressPostcode" value="<?= $data['list']['memAddressPostcode'] ?? '' ?>" />
                        <input type="text" id="input_address" name="memAddress" value="<?= $data['list']['memAddress'] ?? '' ?>" />
                        <input type="text" id="input_detailAddress" name="memAddressDetail" value="<?= $data['list']['memAddressDetail'] ?? '' ?>" />
                        <button class="btn" type="button" onclick="search_addr();">주소 찾기</button>
                        <div id="addressLayer"></div>
                    </td>
                </tr>
                <tr>
                    <th>학력</th>
                    <td>
                        <select name="memEducation" id="memEducation">
                            <?php foreach ($data['education'] as $val) : ?>
                                <option value="<?= $val ?>" <?= $data['list']['memEducation'] ?? '' == $val ? 'checked' : '' ?>><?= $val ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- <input type="text" name="memEducation" value="<? //= $data['list']['memEducation'] ?? '' 
                                                                            ?>" /> -->
                    </td>
                    <th>전공</th>
                    <td> <input type="text" name="memMajor" id="input_address" value="<?= $data['list']['memMajor'] ?? '' ?>" /></td>
                </tr>
                <tr>
                    <th>마지막 방문일</th>
                    <td> <?= $data['list']['memVisitDate'] ?? '' ?></td>
                    <th>마지막 비밀번호 변경일</th>
                    <td> <?= $data['list']['memLastPasswordDate'] ?? '' ?></td>
                </tr>
                <tr>
                    <th>방문횟수</th>
                    <td> <?= $data['list']['memVisitCount'] ?? '' ?></td>
                    <th></th>
                    <td></td>
                </tr>
                <tr>
                    <th>이용약관</th>
                    <td colspan='3'>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType1" id="memPersonalType1_1" value="Y" <?= ($data['list']['memPersonalType1'] ?? '') == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType1_1">동의</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType1" id="memPersonalType1_2" value="N" <?= ($data['list']['memPersonalType1'] ?? '') == 'N' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType1_2">비동의</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>맞춤채용</th>
                    <td colspan='3'>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType2" id="memPersonalType2_1" value="Y" <?= ($data['list']['memPersonalType2'] ?? '') == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType2_1">동의</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType2" id="memPersonalType2_2" value="N" <?= ($data['list']['memPersonalType2'] ?? '') == 'N' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType2_2">비동의</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>푸시알림</th>
                    <td colspan='3'>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType3" id="memPersonalType3_1" value="Y" <?= ($data['list']['memPersonalType3'] ?? '') == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType3_1">동의</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType3" id="memPersonalType3_2" value="N" <?= ($data['list']['memPersonalType3'] ?? '') == 'N' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType3_2">비동의</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>튜토리얼 보기</th>
                    <td colspan='3'>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType4" id="memPersonalType4_1" value="Y" <?= ($data['list']['memPersonalType4'] ?? '') == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType4_1">동의</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType4" id="memPersonalType4_2" value="N" <?= ($data['list']['memPersonalType4'] ?? '') == 'N' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType4_2">비동의</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>취업연계</th>
                    <td colspan='3'>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType5" id="memPersonalType5_1" value="Y" <?= ($data['list']['memPersonalType5'] ?? '') == 'Y' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType5_1">동의</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="memPersonalType5" id="memPersonalType5_2" value="N" <?= ($data['list']['memPersonalType5'] ?? '') == 'N' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="memPersonalType5_2">비동의</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>관심 직무</th>
                    <td>
                        <?= view_cell('\App\Libraries\CategoryLib::jobCategory', [
                            'option' => 'mutl',
                            'pageType' => 'left',
                            'checked' => ($data['category'] ?? [])
                        ]) ?>
                    </td>
                    <th>관심 지역</th>
                    <td>
                        <div class="position_ckBox">
                            <ul>
                                <?php
                                if (count(($data['area'] ?? []))) :
                                    foreach ($data['area'] as $key => $val) :
                                ?>
                                        <li>
                                            <div class="ck_radio">
                                                <input type="checkbox" id="area_<?= $val['idx'] ?>" name="area[]" value="<?= $val['idx'] ?>" <?= in_array($val['idx'], $data['myArea'] ?? []) ? 'checked' : ''; ?>>
                                                <label for="area_<?= $val['idx'] ?>"><?= $val['area_depth_text_1'] ?></label>
                                            </div>
                                        </li>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>희망 연봉</th>
                    <td colspan="3">
                        <div>
                            <input type='number' name='left' min='2400' max='10000' value='<?= $data['list']['memPay'][0] ?? '' ?>' placeholder="단위 : 만원">
                            <input type='number' name='right' min='2400' max='10000' value='<?= $data['list']['memPay'][1] ?? '' ?>' placeholder="단위 : 만원">
                            단위 : 만원

                            <label>
                                1억이상<input type='checkbox' value='100M' <?= ($data['list']['memPay'][1] ?? '') == '10000' ? 'checked' : '' ?>>
                                </lable>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<!--e t1-->

<?php if (($data['list']['memType'] ?? '') === 'M' || $data['code'] === 'm') : ?>
    <h4 class="mg_t40">활동정보</h4>
    <!--s t1-->
    <div class="t1 l">
        <table>
            <colgroup>
                <col class="wps_20">
                <col class="wps_30">
                <col class="wps_20">
                <col class="wps_30">
            </colgroup>
            <tbody>
                <tr>
                    <th>공고 지원</th>
                    <td> <a class='point' href='/prime/suggest/m/list?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a></td>
                    <th>받은 제안 횟수</th>
                    <td> <a class='point' href='/prime/suggest/m/list?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a></td>
                </tr>
                <tr>
                    <th>인터뷰</th>
                    <td> <a class='point' href='/prime/interview/view?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a></td>
                    <th>이력서</th>
                    <td> <a class='point' href='/prime/resume/list?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>보러가기</a></td>

                </tr>
            </tbody>
        </table>
    </div>
    <!--e t1-->
<?php elseif (($data['list']['memType'] ?? '') === 'C' || $data['code'] === 'c') : ?>
    <h4 class="mg_t40">기업정보</h4>
    <!--s t1-->
    <div class="t1 l">
        <table>
            <colgroup>
                <col class="wps_20">
                <col class="wps_30">
                <col class="wps_20">
                <col class="wps_30">
            </colgroup>
            <tbody>
                <tr>
                    <th>기업정보</th>
                    <td>
                        <span id="comName"><?= $data['list']['com_name'] ?? '' ?></span>
                        <input type="text" id="comIdx" name="comIdx" value="<?= $data['list']['comIdx'] ?? '' ?>">
                        <?php if ($data['state'] != 'write') : ?>
                            <a href='/prime/company/write/<?= $data['list']['comIdx'] ?? '' ?>?memIdx=<?= $data['list']['memIdx'] ?? '' ?>'>기업정보수정</a>
                        <?php endif; ?>
                    </td>
                    <th><?= $data['state'] === 'write' ? '기업등록' : '기업변경' ?></th>
                    <td> <a href='javascript:void(0)' onclick="fnShowPop('change_company')">기업검색</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!--e t1-->

    <h4 class="mg_t40">이용정보</h4>
    <!--s t1-->
    <div class="t1 l">
        <table>
            <colgroup>
                <col class="wps_20">
                <col class="wps_30">
                <col class="wps_20">
                <col class="wps_30">
            </colgroup>
            <tbody>
                <tr>
                    <th>등록공고수</th>
                    <td>
                        <?= $data['recCnt'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!-- s 기업 변경하기 팝업 -->
<div id="change_company" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c" style="text-align: center;">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="stxt black">
                기업검색<br /><br />
                <input name="searchText" id="searchText" type="text" value="" placeholder="아이디, 기업명, 연락처로 검색하세요." style="width:50%;">
                <input type="submit" value="검색" onclick="seachCom()">
            </div>

            <div style="display: flex;justify-content: space-around;font-weight:bold;margin-top:30px;margin-bottom:10px;">
                <div style="width: 30%;">기업명</div>
                <div style="width: 30%;">대표명</div>
                <div style="width: 30%;">변경</div>
            </div>
            <div id="searchCom" style="height: 100px;overflow:auto;"></div>
        </div>
        <!--e pop_cont-->

        <div class="spopBtn">
            <a href="#n" class="spop_btn01 wps_100 spop_close" style="width:100%;" onclick="fnHidePop('change_company')">취소</a>
        </div>
    </div>
    <!--e pop_Box-->
</div>
<!-- e 기업 변경하기 -->

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('addressLayer');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function search_addr() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if (data.userSelectedType === 'R') {
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if (data.buildingName !== '' && data.apartment === 'Y') {
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if (extraAddr !== '') {
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("input_extraAddress").value = extraAddr;

                } else {
                    document.getElementById("input_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('input_postcode').value = data.zonecode;
                document.getElementById("input_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("input_detailAddress").focus();

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';
            },
            width: '100%',
            height: '100%',
            maxSuggestItems: 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition() {
        var width = '100%'; //우편번호서비스가 들어갈 element의 width
        var height = 400; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 8; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = ''; //값을 넣으니 너비가 이상해져서 제거
        element_layer.style.height = height + 'px';
        //element_layer.style.border = borderWidth + 'px solid #afafaf';
        element_layer.style.marginBottom = '10px';

        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        //element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
        //element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
    }

    function fnShowPop(sGetName) {
        var $layer = $("#" + sGetName);
        var mHeight = $layer.find(".md_pop_content").height() / 2;
        $layer.addClass("on");
    }

    function fnHidePop(sGetName) {
        $("#" + sGetName).removeClass("on");
    }

    $('#submitBtn').on('click', function() {
        $('#frm').submit();
    });

    function seachCom() {
        const emlCsrf = $("input[name='<?= csrf_token() ?>']");
        let searchTxt = $('#searchText').val();

        if (searchTxt == "" || searchTxt == null) {
            alert('검색어를 입력해주세요.');
        } else {
            $.ajax({
                type: 'GET',
                url: '/api/admin/search/company?searchText=' + searchTxt,
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                },
                success: function(data) {
                    emlCsrf.val(data.code.token);
                    if (data.status == 200) {
                        console.log(data.code.list);
                        $('#searchCom').empty();
                        for (i = 0; i < data.code.list.length; i++) {
                            $('#searchCom').append(`
                            <div style="display: flex;justify-content: space-around;">
                                <div style="width: 30%;">${data.code.list[i].comName}</div>
                                <div style="width: 30%;">${data.code.list[i].memName}</div>
                                <div style="width: 30%;" onclick="changeCom(${data.code.list[i].comIdx}, '${data.code.list[i].comName}')"><u>변경하기</u></div>
                            </div>
                        `);
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


    }

    function changeCom(comIdx, comName) {
        if (confirm(comName + "(으)로 변경하시겠습니까?") == true) {
            // alert(comIdx);
            fnHidePop('change_company');
            $('#comIdx').val(comIdx);
            $('#comName').text(comName);
        } else {
            return false;
        }
    }

    $('#deleteBtn').on('click', function() {
        if (confirm("정말 삭제하시겠습니까?") == true) {
            $('#member_delete').submit();
        } else {
            return false;
        }
    });
</script>

<style>
    .ard_list {
        padding-bottom: 0px !important;
    }

    .ard_list>li {
        float: left;
        padding: 0.25rem;
    }

    .btn-delete {
        color: #fff;
        background-color: #aaa;
        border-color: #aaa;
        box-shadow: none;
    }

    /* 팝업 띄우는 CSS 가져오기 */
    .pop_modal {
        display: none;
        z-index: 11
    }

    .pop_modal2 {
        opacity: 0;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    .pop_modal2.on {
        opacity: 1;
        z-index: 100;
    }

    .pop_modal2.wi.on {
        z-index: 999999
    }

    .pop_Box {
        position: relative;
        max-width: 768px;
        width: 100%;
        margin: 60px auto 0;
    }

    .pop_cont {
        position: relative;
        border-radius: 20px;
        overflow: hidden
    }

    .pop_tlt {
        padding: 30px 0 6px;
        background: #fff;
        color: #505bf0;
        font-size: 30px;
        font-weight: 700;
        text-align: center;
    }

    .pop_txt {
        height: 480px;
        padding: 20px 20px 0;
        font-size: 16px;
        background: #fff;
        box-sizing: border-box
    }

    .pop_txt .tlt {
        font-size: 22px;
        margin-bottom: 30px;
        color: #222
    }

    .pop_scroll_box {
        padding: 20px;
        border: 1px solid #ccc;
        height: 420px;
        overflow: hidden;
        line-height: 1.8em;
        color: #6a6a6a;
        overflow-y: scroll
    }

    .pop_close {
        cursor: pointer;
        position: absolute;
        top: -60px;
        right: 0;
        background: #505bf0;
        color: #fff;
        display: block;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 20px;
        text-align: center;
        border-radius: 50%;
    }

    .spop_Box {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 560px;
        width: 100%;
        border-radius: 20px;
        margin: 0;
        overflow: hidden;
        box-sizing: border-box
    }

    .spop_Box .spop_cont {
        position: relative;
        background: #fff;
        padding: 60px 40px;
    }

    .spop_Box .spopBtn {
        overflow: hidden
    }

    .spop_Box .spopBtn a,
    .spop_Box .spopBtn button {
        float: left;
        display: inline-block;
        height: 70px;
        line-height: 65px;
        font-size: 25px;
        width: 50%;
        font-weight: 700
    }

    .spop_Box .spopBtn.radius_none a:nth-child(1),
    .spop_Box .spopBtn.radius_none button:nth-child(1) {
        border-radius: 0 0 0 20px
    }

    .spop_Box .spopBtn.radius_none a:nth-child(2),
    .spop_Box .spopBtn.radius_none button:nth-child(2) {
        border-radius: 0 0 20px 0
    }

    .spop_Box .spopBtn .spop_btn01 {
        background: #eaeaea;
        color: #343434;
    }

    .spop_Box .spopBtn .spop_btn02 {
        background: #505bf0;
        color: #fff;
    }
</style>