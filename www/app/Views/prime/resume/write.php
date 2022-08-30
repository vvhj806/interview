<div class="content_title">
    <h3>이력서 상세</h3>
</div>

<h4>기본정보</h4>
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
                <th>프로필 이미지</th>
                <td colspan="3"><img src="<?= isset($data['resume']['base']['file_save_name']) ?  $data['url']['media'] . $data['resume']['base']['file_save_name'] : "/static/www/img/sub/prf_no_img.jpg"  ?>" id="changeImg"></td>
            </tr>
            <tr>
                <th>제목</th>
                <td> <?= $data['resume']['base']['res_title'] ?></td>
                <th>이력서 번호</th>
                <td><?= $data['resIdx'] ?></td>
            </tr>
            <tr>
                <th>회원 정보</th>
                <td><a href='/prime/member/write/m/<?= $data['resume']['base']['mem_idx'] ?>' class='point'>회원 정보</a></td>
                <th>전화번호</th>
                <td><?= $data['resume']['base']['res_tel'] ?></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><?= $data['resume']['base']['res_name'] ?></td>
                <th>이메일</th>
                <td><?= $data['resume']['base']['res_email'] ?></td>
            </tr>
            <tr>
                <th>생년월일</th>
                <td><?= $data['resume']['base']['res_birth'] ?></td>
                <th>성별</th>
                <td><?= $data['resume']['base']['res_gender'] ?></td>
            </tr>
            <tr>
                <th>보훈대상</th>
                <td><?= $data['resume']['base']['res_bohun_yn'] ?></td>
                <th>병역대상</th>
                <td><?= $data['resume']['base']['res_military_type'] ?></td>
            </tr>
            <tr>
                <th>복무 시작일</th>
                <td><?= $data['resume']['base']['res_military_start_date'] ?></td>
                <th>복무 종료일</th>
                <td><?= $data['resume']['base']['res_military_end_date'] ?></td>
            </tr>
            <tr>
                <th>주소</th>
                <td><?= $data['resume']['base']['res_address'] ?><?= $data['resume']['base']['res_address_detail'] ?></td>
                <th>우편번호</th>
                <td><?= $data['resume']['base']['res_address_postcode'] ?></td>
            </tr>
            <tr>
                <th>자기소개서</th>
                <td colspan='3'><?= $data['resume']['base']['res_intro_contents'] ?></td>
            </tr>
            <tr>
                <th>경력기술서</th>
                <td colspan='3'><?= $data['resume']['base']['res_career_profile'] ?></td>
            </tr>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>관심 직무</h4>
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
                <th>관심직무</th>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>학력</h4>
<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
            <col class="wps_10">
        </colgroup>
        <thead>
            <tr>
                <th>학교명</th>
                <th>학점</th>
                <th>학과명</th>
                <th>입학년도</th>
                <th>졸업년도</th>
                <th>학교수준</th>
                <th>현재상태</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resume']['education']) : ?>
                <?php foreach ($data['resume']['education'] as $row) : ?>
                    <tr>
                        <td><?= $row['res_edu_school'] ?></td>
                        <td><?= $row['res_edu_score'] ?></td>
                        <td><?= $row['res_edu_department'] ?></td>
                        <td><?= $row['res_edu_admission'] ?></td>
                        <td><?= $row['res_edu_graduate'] ?></td>
                        <td><?= $row['res_edu_school_type'] ?></td>
                        <td><?= $row['res_edu_graduate_type'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan='7' class='text-center'>없음</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>경력</h4>
<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_20">
            <col class="wps_15">
            <col class="wps_15">
            <col class="wps_20">
            <col class="wps_30">
        </colgroup>
        <thead>
            <tr>
                <th>회사명</th>
                <th>입사일</th>
                <th>퇴사일</th>
                <th>부서명/직책</th>
                <th>주요업무</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resume']['career']) : ?>
                <?php foreach ($data['resume']['career'] as $row) : ?>
                    <tr>
                        <td><?= $row['res_career_company_name'] ?></td>
                        <td><?= $row['res_career_join_date'] ?></td>
                        <td><?= $row['res_career_leave_date'] ?></td>
                        <td><?= $row['res_career_dept'] ?></td>
                        <td><?= $row['res_career_contents'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan='7' class='text-center'>없음</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>외국어</h4>
<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_40">
            <col class="wps_15">
            <col class="wps_15">
            <col class="wps_30">
        </colgroup>
        <thead>
            <tr>
                <th>시험종류</th>
                <th>시험점수</th>
                <th>시험급수</th>
                <th>취득일</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resume']['language']) : ?>
                <?php foreach ($data['resume']['language'] as $row) : ?>
                    <tr>
                        <td><?= $row['res_language_name'] ?></td>
                        <td><?= $row['res_language_score'] ?></td>
                        <td><?= $row['res_language_level'] ?></td>
                        <td><?= $row['res_language_obtain_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan='7' class='text-center'>없음</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>자격증</h4>
<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_25">
            <col class="wps_25">
            <col class="wps_25">
            <col class="wps_25">
        </colgroup>
        <thead>
            <tr>
                <th>자격증명</th>
                <th>발행처/기관</th>
                <th>합격현황</th>
                <th>취득일</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resume']['license']) : ?>
                <?php foreach ($data['resume']['license'] as $row) : ?>
                    <tr>
                        <td><?= $row['res_license_name'] ?></td>
                        <td><?= $row['res_license_public_org'] ?></td>
                        <td><?= $row['res_license_level'] ?></td>
                        <td><?= $row['res_license_obtain_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan='7' class='text-center'>없음</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>기타 활동</h4>
<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_20">
            <col class="wps_50">
            <col class="wps_15">
            <col class="wps_15">
        </colgroup>
        <thead>
            <tr>
                <th>활동명</th>
                <th>세부사항</th>
                <th>활동시작일</th>
                <th>활동종료일</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resume']['activity']) : ?>
                <?php foreach ($data['resume']['activity'] as $row) : ?>
                    <tr>
                        <td><?= $row['res_activity_name'] ?></td>
                        <td><?= $row['res_activity_score'] ?></td>
                        <td><?= $row['res_activity_start_date'] ?></td>
                        <td><?= $row['res_activity_end_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan='7' class='text-center'>없음</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->

<h4>첨부파일</h4>
<!--s t1-->
<div class="t1 c">
    <table>
        <colgroup>
            <col class="wps_100">
        </colgroup>
        <thead>
            <tr>
                <th>새창에서 보기</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['resume']['portfolio']) : ?>
                <?php foreach ($data['resume']['portfolio'] as $row) : ?>
                    <tr>
                        <td><a href='<?= $data['url']['media'] . $row['file_save_name'] ?>' class='point' download target='_blank'><?= $row['file_org_name'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan='7' class='text-center'>없음</td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!--e t1-->