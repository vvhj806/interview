<?php

namespace App\Models;

class DatabaseInterview
{
    public function getTable($name)
    {
        return self::$name();
    }

    public static function iv_member()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'file_idx_profile' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_file idx 개인 프로필'],
            'mem_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '기업/개인/관리자/라벨러 타입(C/M/A/L)'],
            'mem_id' => ['type' => 'varchar', 'constraint' => 100, 'comment' => '아이디'],
            'mem_password' => ['type' => 'varchar', 'constraint' => 255, 'comment' => '패스워드'],
            'mem_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '이름'],
            'mem_level' => ['type' => 'varchar', 'constraint' => 2, 'null' => true, 'default' => '0', 'comment' => '등급'],
            'mem_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '전화번호'],
            'mem_age' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '나이'],
            'mem_gender' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '성별 남자:M, 여자:W'],
            'mem_career' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'comment' => '경력 개월'],
            'mem_work_state' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '재직여부(YN)'],
            'mem_pay' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '희망연봉 config_job_pay idx'],
            'mem_education' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '학력'],
            'mem_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '주소'],
            'mem_address_postcode' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '우편번호'],
            'mem_address_detail' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '주소상세'],
            'mem_major' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '전공'],
            'mem_personal_type_1' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '이용약관(YN)'],
            'mem_personal_type_2' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '맞춤채용(YN)'],
            'mem_personal_type_3' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '푸시알림(YN)'],
            'mem_personal_type_4' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '튜토리얼 보기 동의(YN)'],
            'mem_personal_type_5' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '취업연계 동의(YN)'],
            'mem_personal_type_6' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '미사용 (YN)'],
            'mem_personal_type_7' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '미사용 (YN)'],
            'mem_visit_count' => ['type' => 'int', 'constraint' => 11, 'null' => true, 'comment' => '방문횟수'],
            'mem_token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '토큰'],
            'mem_join_path' => ['type' => 'varchar', 'constraint' => 100, 'null' => true, 'comment' => '가입경로'],
            'mem_next_password_date' => ['type' => 'datetime', 'null' => true, 'comment' => '비밀번호 변경하기 팝업 뜨는 날짜'],
            'mem_last_password_date' => ['type' => 'datetime', 'null' => true, 'comment' => '마지막 비밀번호 변경일'],
            'mem_visit_date' => ['type' => 'datetime', 'null' => true, 'comment' => '마지막 방문일'],
            'mem_reg_date' => ['type' => 'datetime', 'comment' => '가입일'],
            'mem_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'mem_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'mem_ex_1' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '학교'],
            'mem_ex_2' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '학과'],
            'mem_ex_3' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '학번'],
            'mem_ex_4' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => ''],
            'mem_ex_5' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => ''],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_member_leave()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'mem_leave_reason' => ['type' => 'int', 'constraint' => 2, 'null' => true],
            'mem_leave_reason_memo' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'mem_leave_reg_date' => ['type' => 'datetime', 'null' => true],
        ];
        return $fields;
    }

    public static function iv_member_recruit_category()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_recruit idx'],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_job_categofy idx'],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_resume idx'],
            'mem_rec_type' => ['type' => 'char', 'constraint' => 1, 'comment' => 'type R:recruit, M:member'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_member_recruit_kor()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_recruit idx'],
            'kor_area_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_korea_area idx'],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_resume idx'],
            'mem_rec_type' => ['type' => 'char', 'constraint' => 1, 'comment' => 'type R:recruit, M:member'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_member_restrictions_company()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'mem_res_reg_date' => ['type' => 'datetime'],
            'mem_res_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_labeler_stat()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'lab_stat' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '0:오프라인, 1:온라인, 9:탈퇴'],
            'app_reg_date' => ['type' => 'datetime', 'comment' => '가입일'],
            'app_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'app_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function log_member_login()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'log_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'login_status' => ['type' => 'varchar', 'constraint' => '255', 'null' => true, 'comment' => '로그인: login / 로그아웃: logout'],
            'login_result' => ['type' => 'varchar', 'constraint' => '255', 'null' => true, 'comment' => '성공: S / 실패: F'],
        ];
        return $fields;
    }

    public static function iv_attendance()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'att_date' => ['type' => 'char', 'constraint' => 14, 'null' => true, 'comment' => '출석 체크한 날'],
            'att_reg_date' => ['type' => 'datetime',  'comment' => '입력시간'],
            'att_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정시간'],
            'att_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제시간'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_korea_area()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'area_depth_1' => ['type' => 'int', 'constraint' => 2],
            'area_depth_2' => ['type' => 'int', 'constraint' => 2, 'null' => true],
            'area_depth_3' => ['type' => 'int', 'constraint' => 2, 'null' => true],
            'area_depth_text_1' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'area_depth_text_2' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'area_reg_date' => ['type' => 'datetime'],
            'area_mod_date' => ['type' => 'datetime', 'null' => true],
            'area_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_labeler_count()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'app_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_applier idx'],
            'lab_cnt_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'lab_cnt_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'lab_cnt_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_company()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'file_idx_logo' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_file idx 회사로고'],
            'com_tel' => ['type' => 'varchar', 'constraint' => 20, 'comment' => '회사 전화번호'],
            'com_name' => ['type' => 'varchar', 'constraint' => 50, 'comment' => '기업명'],
            'com_form' => ['type' => 'varchar', 'constraint' => 50, 'comment' => '기업형태'],
            'com_industry' => ['type' => 'varchar', 'constraint' => 50, 'comment' => '업종'],
            'com_head_count' => ['type' => 'int', 'constraint' => 10, 'comment' => '사원수'],
            'com_anniversary' => ['type' => 'char', 'constraint' => 14, 'comment' => '설립일, 20201010'],
            'com_introduce' => ['type' => 'text', 'comment' => '회사소개'],
            'com_url' => ['type' => 'varchar', 'constraint' => 255, 'comment' => '홈페이지 url'],
            'com_video_url' => ['type' => 'varchar', 'constraint' => 255, 'comment' => '회사소개 유튜브 url'],
            'com_reg_number' => ['type' => 'varchar', 'constraint' => 20, 'comment' => '사업자등록번호'],
            'com_address' => ['type' => 'varchar', 'constraint' => 255, 'comment' => '회사 주소'],
            'com_ceo_name' => ['type' => 'varchar', 'constraint' => 50, 'comment' => '대표 이름'],
            'com_manager_name' => ['type' => 'varchar', 'constraint' => 50, 'comment' => '인사담당자 이름'],
            'com_practice_interview' => ['type' => 'char', 'constraint' => 1, 'comment' => '모의인터뷰 Y:가능, N:불가'],
            'com_level' => ['type' => 'int', 'constraint' => 2, 'default' => '0', 'comment' => '등급'],
            'mem_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'mem_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'mem_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }



    public static function iv_company_tag()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'config_tag_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'config_company_tag idx'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_company_suggest()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'sug_type' => ['type' => 'char', 'constraint' => 1, 'unsigned' => true, 'null' => true, 'comment' => '제안타입 A:AI인터뷰제안, I:대면면접제안, O:이직 및 포지션 제안'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'sug_massage' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '메세지 내용'],
            'sug_manager' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => 'sms 안내 발송 O:공개 C:비공개'],
            'sug_manager_name' => ['type' => 'varchar', 'constraint' => 20, 'comment' => '채용담당자 이름'],
            'sug_manager_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '채용담당자 연락처'],
            'sug_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '채용담당자 연락처'],
            'sug_sms' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => 'sms 안내 발송 Y:발송 N:미발송'],
            'sug_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_company_question_category()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'com_que_category' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '카테고리 이름'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_job_category()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'job_depth_1' => ['type' => 'int', 'constraint' => 2, 'comment' => 'code 1뎁스'],
            'job_depth_2' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => 'code 2뎁스'],
            'job_depth_3' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => 'code 3뎁스'],
            'job_depth_text' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '뎁스 명'],
            'job_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'job_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'job_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_job_category_copy()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'job_depth_1' => ['type' => 'int', 'constraint' => 2, 'comment' => 'code 1뎁스'],
            'job_depth_2' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => 'code 2뎁스'],
            'job_depth_3' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => 'code 3뎁스'],
            'job_depth_text' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '뎁스 명'],
            'job_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'job_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'job_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_job_request()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_recruit idx'],
            'info_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_interview_info idx'],
            'req_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'req_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'req_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_applier()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_job_category idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_recruit idx'],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '이력서 idx'],
            'i_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_interview idx'],
            'info_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_interview_info idx'],
            'file_idx_thumb' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_file idx 썸네일'],
            'app_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '기업/개인 인터뷰 타입(CM)'],
            'app_iv_stat' => ['type' => 'int', 'constraint' => 2, 'default' => '0', 'comment' => '0:카테고리 선택, 1:프로필 촬영, 2:마이크테스트, 3:면접완료, 4:라벨러채점완료'],
            'app_stt_stat' => ['type' => 'int', 'constraint' => 2, 'default' => '1', 'comment' => 'STT 기본값:1, 1번완료:2, 2번완료:3...최종완료:0'],
            'app_share' => ['type' => 'int', 'constraint' => 2, 'default' => '0', 'comment' => '면접 공개여부 0:비공개, 1:공개'],
            'app_platform' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => 'pc, android, iphone..'],
            'app_browser_name' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '브라우저 종류'],
            'app_browser_version' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '브라우저 버전'],
            'app_referer' => ['type' => 'varchar', 'constraint' => 100, 'null' => true, 'comment' => '면접 들어온 방법'],
            'app_count' => ['type' => 'int', 'constraint' => 10, 'default' => '0', 'comment' => '조회수'],
            'app_like_count' => ['type' => 'int', 'constraint' => 10, 'default' => '0', 'comment' => '좋아요 카운트'],
            'app_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'app_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'app_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
            'app_share_company' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '0: 비공개 1: 연락처 제외 공개 2: 연락처와 레포트 모두 공개'],
            'app_comprehensive' => ['type' => 'int', 'constraint' => 2, 'comment' => '0:일반 1:종합레포트'],
        ];
        return $fields;
    }

    public static function iv_applier_share()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_applier idx'],
            'file_idx_resume' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_file idx 이력서'],
            'share_job_link' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '포트폴리오 link'],
            'share_job_age' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '구직희망 나이'],
            'kor_area_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '구직희망지역 iv_korea_area idx'],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_job_category idx 구직카테고리'],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'config_job_pay idx 구직희망연봉'],
            'share_career_yn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '구직 경력:Y,신입:N'],
            'config_career_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'config config_career_idx idx 구직 경력'],
            'share_pay_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '구직 급여:T, 월급:M, 연봉:Y'],
            'share_pay_unit' => ['type' => 'bigint', 'constraint' => 20, 'null' => true, 'comment' => '구직급여 수치화(원) 단위'],
            'share_education' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '학력 고졸이하:1,고등학교:2,대학(2,3년재):3,대학교(4년재):4,석사:5,박사:6,박사이상:7,무관:0'],
            'share_tenure' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '재직중:0, 구직중:1'],
            'share_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'share_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'share_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_config()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'cfg_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => 'T:이용약관,P:개인정보처리방침,A:개인정보수집/이용,R:개인정보처리/위탁,H:개인정보3자제공'],
            'cfg_useYN' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '사용여부(YN)'],
            'cfg_content' => ['type' => 'text', 'null' => true, 'comment' => '내용'],
            'cfg_reg_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '입력한 member idx'],
            'cfg_mod_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '수정한 member idx'],
            'cfg_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'cfg_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'cfg_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_auth_tel()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'auth_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'auth_code' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'auth_type' => ['type' => 'char', 'constraint' => 1, 'null' => true],
            'auth_start_date' => ['type' => 'datetime', 'null' => true],
        ];
        return $fields;
    }

    public static function iv_recruit()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '채용포지션(직군/직무) iv_job_category idx'],
            'rec_work_day' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '근무요일(,중복) 월:0,화:1...일:6,평일:8,주말:9'],
            'rec_work_type' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '고용형태(,중복) 정규직:0,계약직:1,인턴직:3,아르바이트:4,해외취업:5'],
            'rec_career' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '경력:C,신입:N,경력무관:A'],
            'rec_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '공고제목'],
            'rec_airecruit_yn' => ['type' => 'char', 'constraint' => 1, 'default' => 'Y', 'comment' => 'ai적극채용여부 (YN)'],
            'rec_resume' => ['type' => 'char', 'constraint' => 1, 'default' => 'S', 'comment' => '이력서 필수 선택 여부 R:필수 S:선택'],
            'rec_apply_count' => ['type' => 'int', 'constraint' => 2, 'default' => 0, 'comment' => '아이디 하나당 지원가능 횟수 0:무제한 최대:99'],
            'rec_career_month' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '경력 개월'],
            'rec_apply' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '지원방식 내인터뷰:M, 기업인터뷰:C'],
            'rec_pay_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '급여:T, 월급:M, 연봉:Y, 면접후결정:N'],
            'rec_pay_unit' => ['type' => 'bigint', 'constraint' => 20, 'null' => true, 'comment' => '급여 수치화(원) 단위'],
            'rec_period' => ['type' => 'int', 'constraint' => 4, 'null' => true, 'comment' => '근무기간(이상) 1개월:1, 3개월:3, 6개월:6, 1년:12'],
            'rec_education' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '학력 고졸이하:1,고등학교:2,대학(2,3년재):3,대학교(4년재):4,석사:5,박사:6,박사이상:7,무관:0'],
            'rec_gender' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '성별 남자:M, 여자:W'],
            'kor_area_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '근무위치 iv_korea_area idx'],
            'file_idx_recruit' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '채용정보 img file_idx'],
            'rec_info' => ['type' => 'text', 'null' => true, 'comment' => '채용정보(주요업무,자격요건 등 full html)'],
            'rec_hit' => ['type' => 'int', 'constraint' => 10, 'default' => 0, 'comment' => '조회수'],
            'rec_start_date' => ['type' => 'datetime', 'null' => true, 'comment' => '인터뷰 시작일'],
            'rec_end_date' => ['type' => 'datetime', 'null' => true, 'comment' => '인터뷰 종료일'],
            'rec_mail' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '채용담당자 메일'],
            'rec_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '채용담당자 이름'],
            'rec_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '채용담당자 연락처'],
            'rec_reg_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'unsigned' => true, 'comment' => '입력한 member idx'],
            'rec_mod_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'unsigned' => true, 'comment' => '수정한 member idx'],
            'rec_issue_com' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => 'Y:요즘뜨는기업의공고(메인) N:기본값'],
            'rec_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'rec_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'rec_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_member_recruit_scrap()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'src_type' => ['type' => 'char', 'constraint' => 1],
            'src_reg_date' => ['type' => 'datetime'],
            'src_mod_date' => ['type' => 'datetime', 'null' => true],
            'src_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_mbti_score()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'job_category_idx (depth3)'],
            'mbti_score_mbti' => ['type' => 'char', 'constraint' => 4, 'comment' => 'mbti'],
            'mbti_score_value' => ['type' => 'int', 'constraint' => 3, 'comment' => '점수'],
        ];
        return $fields;
    }

    public static function iv_recruit_info()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'rec_nos_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_1' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_2' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_3' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_4' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_5' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_info_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'res_info_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_info_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_recruit_nostradamus()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'rec_nos_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'rec_nos_percent' => ['type' => 'int', 'constraint' => 10, 'null' => true],
            'rec_nos_url' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'rec_nos_question' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '모의 인터뷰 질문'],
            'rec_nos_content' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '모의 인터뷰 컨텐츠'],
            'rec_nos_start_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'rec_nos_end_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'rec_nos_hit' => ['type' => 'int', 'constraint' => 10, 'null' => true],
            'rec_nos_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'rec_nos_mod_date' => ['type' => 'datetime', 'null' => true],
            'rec_nos_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_resume()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_profile' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_birth' => ['type' => 'char', 'constraint' => 14, 'null' => true],
            'res_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'res_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'res_email' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_gender' => ['type' => 'char', 'constraint' => 1, 'null' => true],
            'res_bohun_yn' => ['type' => 'char', 'constraint' => 1, 'null' => true],
            'res_military_type' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'res_military_start_date' => ['type' => 'char', 'constraint' => 14, 'null' => true],
            'res_military_end_date' => ['type' => 'char', 'constraint' => 14, 'null' => true],
            'res_address' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_address_postcode' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'res_address_detail' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_career_profile' => ['type' => 'MEDIUMTEXT', 'null' => true],
            'res_intro_contents' => ['type' => 'MEDIUMTEXT', 'null' => true],
            'res_reg_date' => ['type' => 'datetime'],
            'res_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_resume_career()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_career_company_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_career_join_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'res_career_leave_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'res_career_dept' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_career_contents' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'res_career_reg_date' => ['type' => 'datetime'],
            'res_career_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_career_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_resume_license()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_license_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_license_public_org' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_license_level' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_license_obtain_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'res_license_reg_date' => ['type' => 'datetime'],
            'res_license_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_license_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_resume_language()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_language_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_language_score' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'res_language_level' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'res_language_obtain_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'res_language_reg_date' => ['type' => 'datetime'],
            'res_language_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_language_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_resume_activity()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_activity_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'res_activity_score' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'res_activity_start_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'res_activity_end_date' => ['type' => 'char', 'constraint' => 12, 'null' => true],
            'res_activity_reg_date' => ['type' => 'datetime'],
            'res_activity_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_activity_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_resume_portfolio()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'res_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'res_portfolio_url' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'res_portfolio_type' => ['type' => 'char', 'constraint' => 1, 'null' => true],
            'res_portfolio_reg_date' => ['type' => 'datetime'],
            'res_portfolio_mod_date' => ['type' => 'datetime', 'null' => true],
            'res_portfolio_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function config_company_news()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'news_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'news_link' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'news_referance' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }


    public static function config_company_file()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }


    public static function config_job_grade()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'grade_txt' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '직급 직책 예:주임연구원'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_recruit_question()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_recruit idx'],
            'que_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_question idx'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_question()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_company idx'],
            'req_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_job_request idx'],
            'que_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '질문구분'],
            'que_wait_time' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '답변대기시간'],
            'que_answer_time' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '답변시간'],
            'que_lang_type' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '면접언어 타입 0:한국어, 1:영어'],
            'que_reg_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '입력한 member idx'],
            'que_mod_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '수정한 member idx'],
            'que_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'que_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'que_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_question_copy()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_company idx'],
            'req_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_job_request idx'],
            'que_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '질문구분'],
            'que_wait_time' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '답변대기시간'],
            'que_answer_time' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '답변시간'],
            'que_lang_type' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '면접언어 타입 0:한국어, 1:영어'],
            'que_reg_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '입력한 member idx'],
            'que_mod_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => '수정한 member idx'],
            'que_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'que_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'que_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_interview()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_recruit idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'mod_mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx 수정한 기업회원 idx'],
            'info_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_interview_info idx'],
            'job_idx_position' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '희망포지션 iv_job_category idx'],
            'inter_name' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => '인터뷰 제목'],
            'inter_repot_yn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => 'ai 리포트 생성여부(YN)'],
            'inter_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '인터뷰 타입 M:연습인터뷰, A:모의인터뷰, C:기업인터뷰'],
            'inter_opportunity_yn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '재응시 여부(YN)'],
            'inter_question' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '질문리스트(,구분)'],
            'inter_memo' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '메모'],
            'inter_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'inter_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'inter_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_interview_info()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_recruit idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'reg_mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'mod_mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx 수정한 기업회원 idx'],
            'inter_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_interview idx'],
            'job_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '렌덤질문을 위한 iv_job_category idx'],
            'info_name' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '인터뷰 요청자 이름'],
            'info_tel' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '인터뷰 제목'],
            'info_mail' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '인터뷰 제목'],
            'info_start_date' => ['type' => 'char', 'constraint' => 14, 'null' => true, 'comment' => '인터뷰 제목'],
            'info_end_date' => ['type' => 'char', 'constraint' => 14, 'null' => true, 'comment' => '인터뷰 제목'],
            'inter_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'inter_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'inter_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_phrase()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'phrase' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => 'word'],
            'complete' => ['type' => 'int', 'constraint' => 2, 'comment' => '0: 미완료 1: 완료'],
            'datetime' => ['type' => 'datetime', 'comment' => '등록일'],
        ];
        return $fields;
    }

    public static function iv_interactive_question()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'point_word' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => ''],
            'negative_word' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => ''],
            'question' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => '']
        ];
        return $fields;
    }

    public static function iv_report_result()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'applier_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_applier idx'],
            'que_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_question idx'],
            'que_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => 'iv_question type 전체:T, 개별:S'],
            'repo_process' => ['type' => 'varchar', 'constraint' => 20, 'default' => '0', 'comment' => '0:인터뷰X, 1:인터뷰완료, 2:채점완료'],
            'repo_score' => ['type' => 'text', 'null' => true, 'comment' => '스피치 점수'],
            'repo_analysis' => ['type' => 'text', 'null' => true, 'comment' => '스피치 점수를 바탕으로 구분 점수'],
            'repo_speech_txt' => ['type' => 'text', 'null' => true, 'comment' => '스피치 텍스트'],
            'repo_speech_txt_trans' => ['type' => 'text',  'null' => true, 'comment' => '스피치 텍스트 번역본'],
            'repo_speech_txt_detail' => ['type' => 'text', 'null' => true, 'comment' => '스피치 텍스트 형태소'],
            'repo_answer_time' => ['type' => 'int', 'constraint' => 3, 'null' => true, 'comment' => '답변시간'],
            'repo_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'repo_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'repo_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function config_company_tag()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'tag_txt' => ['type' => 'varchart', 'constraint' => 50, 'null' => true, 'comment' => '태그명 #자율복장'],
            'tag_txt_content' => ['type' => 'varchart', 'constraint' => 255, 'null' => true, 'comment' => '태그에 대한 보여질 한줄 설명'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function config_job_pay()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'pay_txt' => ['type' => 'varchart', 'constraint' => 50, 'null' => true, 'comment' => '4,000 이상'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function config_career()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'caree_txt' => ['type' => 'varchart', 'constraint' => 50, 'null' => true, 'comment' => '3년~5년, 7년이상 등'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function config_company_suggest()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'sug_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company_sug idx'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function config_faq_type()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'faq_txt' => ['type' => 'varchart', 'constraint' => 50, 'null' => true, 'comment' => '인터뷰, 리포트 등등 구분값'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];

        return $fields;
    }

    public static function config_board_rest()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'rest_txt' => ['type' => 'varchart', 'constraint' => 50, 'null' => true, 'comment' => '쉬어가는 글 카테고리'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_pay_service()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'pay_ser_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '타입 C:쿠폰, S:구독, E:건당'],
            'pay_ser_coupon' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment' => '쿠폰 번호'],
            'pay_ser_memo' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '메모'],
            'pay_ser_count' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'comment' => '쿠폰, 건당 총량'],
            'pay_ser_use_count' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'comment' => '쿠폰, 건당 사용량'],
            'pay_ser_use_date' => ['type' => 'char', 'constraint' => 14, 'null' => true, 'comment' => '구독, 쿠폰 사용기간(YYYYMMDD)'],
            'pay_ser_start_date' => ['type' => 'char', 'constraint' => 14, 'null' => true, 'comment' => '구독, 쿠폰 시작일(YYYYMMDD)'],
            'pay_ser_end_date' => ['type' => 'char', 'constraint' => 14, 'null' => true, 'comment' => '구독, 쿠폰 종료일(YYYYMMDD)'],
            'pay_ser_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'pay_ser_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'pay_ser_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_file()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'file_type' => ['type' => 'char', 'constraint' => 1, 'comment' => '타입 M:iv_member, C:iv_company, A:iv_applier ,S:iv_applier_share, B:iv_board'],
            'file_org_name' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => '원본 파일명'],
            'file_save_name' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => '저장 파일명'],
            'file_size' => ['type' => 'int', 'constraint' => 11, 'null' => true, 'comment' => '파일 사이즈'],
            'file_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'file_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'file_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_video()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'app_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_applier idx'],
            'que_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_question idx'],
            'video_record' => ['type' => 'varchar', 'constraint' => 200, 'null' => true, 'comment' => '레코드 이름'],
            'video_reg_date' => ['type' => 'datetime', 'comment' => '수정일'],
            'video_mod_date' => ['type' => 'datetime', 'null' => true, 'comment' => '수정일'],
            'video_del_date' => ['type' => 'datetime', 'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_board()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'bd_family' => ['type' => 'int', 'constraint' => 10, 'default' => 0],
            'bd_sort' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_depth' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_notice' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
            'bd_secret' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
            'bd_password' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'file_idx_thumb' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_1' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_2' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_3' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_4' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'file_idx_data_5' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'mem_idx_m' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'mem_idx_a' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'bd_hit' => ['type' => 'int', 'constraint' => 10, 'default' => 0],
            'bd_ip' => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'bd_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'bd_content' => ['type' => 'mediumtext', 'null' => true],
            'bd_start_date' => ['type' => 'date', 'null' => true],
            'bd_end_date' => ['type' => 'date', 'null' => true],
            'bd_reg_date' => ['type' => 'datetime', 'null' => true],
            'bd_mod_date' => ['type' => 'datetime', 'null' => true],
            'bd_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_comment()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'cmt_family' => ['type' => 'int', 'constraint' => 10, 'default' => 0],
            'cmt_sort' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'cmt_depth' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'cmt_bd_idx' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'cmt_comment' => ['type' => 'text', 'null' => true],
            'cmt_ip' => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'cmt_reg_date' => ['type' => 'datetime', 'null' => true],
            'cmt_mod_date' => ['type' => 'datetime', 'null' => true],
            'cmt_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function log_send_email()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'send_email_to' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'send_email_from_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true],
            'send_email_page' => ['type' => 'varchar', 'constraint' => 255,  'null' => true],
            'send_email_reg_date' => ['type' => 'DATETIME', 'null' => true],
        ];
        return $fields;
    }

    public static function iv_board_list()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'board_list_id' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'board_list_name' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'board_list_type' => ['type' => 'char', 'constraint' => 1, 'null' => true],
            'board_list_skin' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'board_list_basic' => ['type' => 'text', 'null' => true],
            'board_list_auth' => ['type' => 'text', 'null' => true],
            'board_list_list' => ['type' => 'text', 'null' => true],
            'board_list_outline' => ['type' => 'text', 'null' => true],
            'board_list_total' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'default' => 0],
            'board_list_reg_date' => ['type' => 'datetime', 'null' => true],
            'board_list_mod_date' => ['type' => 'datetime', 'null' => true],
            'board_list_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_board_event()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'bd_family' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_sort' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_depth' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_notice' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
            'bd_secret' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
            'bd_password' => ['type' => 'varchar', 'constraint' => 255],
            'file_idx_thumb' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_1' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_2' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_3' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_4' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_5' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'mem_idx_m' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'mem_idx_a' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'bd_content' => ['type' => 'mediumtext', 'null' => true],
            'bd_start_date' => ['type' => 'date', 'null' => true],
            'bd_end_date' => ['type' => 'date', 'null' => true],
            'bd_hit' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_ip' => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'bd_reg_date' => ['type' => 'datetime'],
            'bd_mod_date' => ['type' => 'datetime', 'null' => true],
            'bd_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_board_rest()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'bd_category_idx' => ['type' => 'int', 'constraint' => 10],
            'bd_family' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_sort' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_depth' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_notice' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
            'bd_secret' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
            'bd_password' => ['type' => 'varchar', 'constraint' => 255],
            'file_idx_thumb' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_1' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_2' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_3' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_4' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'file_idx_data_5' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'mem_idx_m' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'mem_idx_a' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'bd_content' => ['type' => 'mediumtext', 'null' => true],
            'bd_start_date' => ['type' => 'date', 'null' => true],
            'bd_end_date' => ['type' => 'date', 'null' => true],
            'bd_hit' => ['type' => 'int', 'constraint' => 10,  'default' => 0],
            'bd_ip' => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'bd_reg_date' => ['type' => 'datetime'],
            'bd_mod_date' => ['type' => 'datetime', 'null' => true],
            'bd_del_date' => ['type' => 'datetime', 'null' => true],
            'bd_reserve_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_faq()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'faq_sort' => ['type' => 'int', 'constraint' => 3, 'unsigned' => true, 'default' => 255],
            'faq_type' => ['type' => 'int', 'constraint' => 10],
            'faq_question' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'faq_answer' => ['type' => 'text', 'null' => true],
            'faq_reg_date' => ['type' => 'datetime', 'null' => true],
            'faq_mod_date' => ['type' => 'datetime', 'null' => true],
            'faq_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_qna()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx_m' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'mem_idx_a' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'qna_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'qna_question' => ['type' => 'mediumtext', 'null' => true],
            'qna_answer' => ['type' => 'mediumtext', 'null' => true],
            'qna_reg_date' => ['type' => 'datetime', 'null' => true],
            'qna_mod_date' => ['type' => 'datetime', 'null' => true],
            'qna_del_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_search_keyword()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'idx'],
            'index' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_company idx'],
            'text' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '카테고리 이름'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function set_shorten_url()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'shorten_url' => ['type' => 'varchar', 'constraint' => 50],
            'shorten_base_url' => ['type' => 'varchar', 'constraint' => 500],
            'shorten_reg_date' => ['type' => 'datetime'],
        ];
        return $fields;
    }

    public static function set_report_score_rank()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'score_rank_Type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => null, 'comment' => '전체:T, 직군별은:C'],
            'job_depth_1' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'default' => null, 'comment' => 'iv_job_category job_depth_1'],
            'score_rank_grade' => ['type' => 'char', 'constraint' => 5, 'null' => true, 'default' => null, 'comment' => 'S,A,B,C,D 등 등급'],
            'score_rand_count_member' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'default' => null, 'comment' => '점수등급에 따른 사람수'],
            'score_reg_date' => ['type' => 'datetime', 'comment' => '수정일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_applier_profile()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'app_idx' => ['type' => 'iny', 'constraint' => 10, 'null' => true, 'default' => null, 'comment' => 'iv_applier idx'],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'default' => null, 'comment' => 'iv_member idx'],
            'file_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'default' => null, 'comment' => 'iv_file idx'],
            'app_pro_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
        ];
        return $fields;
    }

    public static function iv_member_push()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'default' => null, 'comment' => 'iv_member idx'],
            'recommend' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '추천 채용정보'],
            'notice_event' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '공지사항/이벤트알림'],
            'report_read' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '내 리포트 기업이 열람'],
            'company_proposal' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '기업 제안 도착'],
            'retry_request_accept' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '재응시 요청 수락'],
            'scrap_deadline' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '즐겨찾기한 공고 마감 1일전'],
            'scrap_new_recurit' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'Y', 'comment' => '즐겨찾기한 기업의 신규 공고'],
            'push_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'push_mod_date' => ['type' => 'datetime', 'comment' => '수정일'],
            'push_del_date' => ['type' => 'datetime', 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_push()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'default' => null, 'comment' => 'iv_member idx'],
            'push_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => null, 'comment' => '푸시알림종류'],
            'push_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'default' => null, 'comment' => '푸시알림제목'],
            'push_content' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'default' => null, 'comment' => '푸시알림내용'],
            'push_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'push_mod_date' => ['type' => 'datetime', 'comment' => '수정일'],
            'push_del_date' => ['type' => 'datetime', 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_alarm()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_member idx'],
            'alarm_type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => null, 'comment' => '타입(A:제안,B:재응시,C:공지,D:이벤트)'],
            'alarm_page_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'default' => null, 'comment' => '기능 idx'],
            'alarm_link' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'default' => null, 'comment' => '알림 링크'],
            'alarm_title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'default' => null, 'comment' => '제목'],
            'reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'mod_date' => ['type' => 'datetime', 'comment' => '수정일'],
            'del_date' => ['type' => 'datetime', 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'N', 'comment' => '삭제여부(YN)'],
        ];
        return $fields;
    }

    public static function iv_company_suggest_applicant()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'inter_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_interview idx'],
            'app_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'comment' => 'iv_applier idx'],
            'sug_app_namne' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'default' => null, 'comment' => '지원자 이름'],
            'sug_app_phone' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'default' => null, 'comment' => '전화번호'],
            'sug_app_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'sug_app_mod_date' => ['type' => 'datetime', 'comment' => '수정일'],
            'sug_app_del_date' => ['type' => 'datetime', 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'N', 'comment' => '삭제여부(YN)'],
            'old_ap_idx' => ['type' => 'int', 'constraint' => '10', 'default' => null, 'comment' => '1.5 applicant idx'],
            'job_idx' => ['type' => 'int', 'constraint' => '10', 'default' => null, 'comment' => ''],
            'sug_app_personal_q_list' => ['type' => 'varchar', 'constraint' => '50', 'default' => null, 'comment' => '개별질문 리스트'],
        ];
        return $fields;
    }

    public static function config_again_request()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'rec_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'com_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'sug_app_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'config_sug_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'ag_req_stat' => ['type' => 'char', 'constraint' => 1, 'null' => true],
            'ag_req_com' => ['type' => 'char', 'constraint' => 1, 'default' => 'P'],
            'ag_req_reason' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'ag_req_reg_date' => ['type' => 'datetime', 'comment' => '등록일'],
            'ag_req_mode_date' => ['type' => 'datetime', 'null' => true],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_university()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'uni_name' => ['type' => 'char', 'constraint' => 255, 'null' => true, 'comment' => '대학교 이름'],
            'uni_code' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '학교 코드'],
            'uni_major_code' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => '학과 코드'],
            'uni_major' => ['type' => 'char', 'constraint' => 255, 'null' => true, 'comment' => '학과 이름'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_member_token()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'mem_idx' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true, 'comment' => 'iv_member idx'],
            'token' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => 'user 토큰'],
            'mem_token_reg_date' => ['type' => 'datetime', 'null' => true, 'comment' => '등록일'],
            'mem_token_mod_date' => ['type' => 'datetime',  'null' => true, 'comment' => '수정일'],
            'mem_token_del_date' => ['type' => 'datetime',  'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'default' => 'N'],
        ];
        return $fields;
    }

    public static function iv_sentiword()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 255, 'auto_increment' => true],
            'word' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '단어'],
            'word_root' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '어근'],
            'polarity' => ['type' => 'int', 'constraint' => 1, 'null' => true, 'comment' => '스코어(-2~2)'],
        ];
        return $fields;
    }

    public static function set_admin_menu()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'auto_increment' => true],
            'menu_depth_1' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '메뉴 큰 카테고리'],
            'menu_depth_2' => ['type' => 'int', 'constraint' => 2, 'null' => true, 'comment' => '메뉴 작은 카테고리'],
            'menu_depth_txt' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment' => '메뉴 이름'],
            'menu_level' => ['type' => 'int', 'constraint' => 1, 'null' => true, 'comment' => '메뉴를 사용하는 사용자의 권한'],
            'menu_priority' => ['type' => 'int', 'constraint' => 1, 'null' => true, 'comment' => '메뉴 출력 우선순위'],
            'menu_link' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '해당 메뉴 링크'],
            'menu_reg_date' => ['type' => 'datetime', 'null' => true, 'comment' => '생성일'],
            'menu_mod_date' => ['type' => 'datetime',  'null' => true, 'comment' => '수정일'],
            'menu_del_date' => ['type' => 'datetime',  'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'N', 'comment' => '삭제여부(Y/N)'],

        ];
        return $fields;
    }

    public static function set_admin_rule()
    {
        $fields = [
            'idx' => ['type' => 'int', 'constraint' => 10, 'auto_increment' => true],
            'type' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'comment' => '기업/개인/관리자/라벨러 타입(C/M/A/L)'],
            'level' => ['type' => 'int', 'constraint' => 1, 'null' => true, 'comment' => '등급'],
            'menu_idx' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment' => '메뉴 idx '],
            'type_name' => ['type' => 'int', 'constraint' => 1, 'null' => true, 'comment' => '타입 이름'],
            'rule_reg_date' => ['type' => 'datetime', 'null' => true, 'comment' => '생성일'],
            'rule_mod_date' => ['type' => 'datetime',  'null' => true, 'comment' => '수정일'],
            'rule_del_date' => ['type' => 'datetime',  'null' => true, 'comment' => '삭제일'],
            'delyn' => ['type' => 'char', 'constraint' => 1, 'null' => true, 'default' => 'N', 'comment' => '삭제여부(Y/N)'],
        ];
        return $fields;
    }
}
