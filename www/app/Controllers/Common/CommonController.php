<?php

namespace App\Controllers\Common;

//use App\Controllers\BaseController;
//use App\Controllers\Interview\WwwController;

use App\Models\Common\CommonModel;
use App\Libraries\{SendLib, EncryptLib, GlobalvarLib};


use Config\Database;
use Config\Services;

class CommonController
{
    public $CommonModel;
    public $globalvar;
    public function __construct()
    {
        $this->CommonModel = new CommonModel();
        $this->globalvar = new GlobalvarLib();
    }
    //알림 처리
    public function setAlarm($type1, $type2, $linkType = 'I', $link = '', $title = '', $message = '', $memIdx = '')
    {
        //type1 : A(전체),  G(일반), B(기업), I(개별-안씀)
        //type2 : N(공지), E(이벤트), S(지원), P(제안), R(재응시) 
        //linkType : I(내부링크), O(외부링크) default : I
        //link : 내부링크일때 page idx 값 
        //ex)my/suggest/detail/ho0a5ZmALjccd5yqM47Nj6S0PxH5hoMovHmLRmaGq_1OzKCUYVD2Cd_suuQuTAPURqIC 에서 detail뒤 암호화 된 부분
        //title : 알림 제목( 공지, 이벤트 등에 사용)

        //전체 알림

        //공지(전체)
        //이벤트(전체)

        //지원자 알림
        //공고 제안(지원자)
        //재응시 요청 수락(지원자)
        //공지(지원자)
        //이벤트(지원자)

        //기업 알림
        //공고 지원(기업)  
        //재응시 요청(기업)
        //공지(기업)
        //이벤트(기업)

        $this->CommonModel->setAlarm($memIdx, $type1, $type2, $link, $title, $message, $linkType); //알림 DB 처리

        $push_link = '';
        //푸시 링크 처리
        if ($linkType == "I") {
            if ($type2 == 'N') { //공지
                $push_link = 'board/notice';
            } else if ($type2 == 'E') { //이벤트
                $push_link = 'board/event/' . $link;
            }

            if ($type1 == 'G') { //일반
                if ($type2 == 'S') { //지원
                    $push_link = 'my/recruit_info/completed';
                } else if ($type2 == 'P') { //제안
                    $push_link = 'my/suggest';
                } else if ($type2 == 'R') { //재응시
                    $push_link = 'my/recruit_info/again';
                }
            } else if ($type1 == 'B') { //기업
                if ($type2 == 'S') { //지원
                    $push_link = '';
                } else if ($type2 == 'P') { //제안
                    $push_link = '';
                } else if ($type2 == 'R') { //재응시
                    $push_link = '';
                }
            }
        } else if ($linkType == "O") {
            //입력 링크 그대로
            $push_link = $link;
        }
        $push_title = $title;
        $push_message = $message;
        $push_imgurl = '';
        $send_data = $memIdx;

        $type2_arr_in1 = ['S', 'P', 'R']; //지원, 제안, 재응시
        $type2_arr_in2 = ['N', 'E']; //공지, 이벤트
        if (in_array($type2, $type2_arr_in1)) {
            $send_data_type = 'I';
        } else if (in_array($type2, $type2_arr_in2)) {
            $send_data_type = $type1;
            $send_data_type = 'I';
        }

        //푸시 전송
        $result = $this->pushSendData('m', 'appopen', $push_link, $push_title, $push_message, $push_imgurl, $send_data, $send_data_type);

        if (in_array($type2, $type2_arr_in2)) {//공지,이벤트만 문자전송
            //문자 전송
            $sendLib = new SendLib();
            $sms_link = $this->globalvar->getWwwUrl().'/'.$push_link;
            $strMsg = "HIGHBUFF Interview\n\n".$title."\n\n".$message."\n\n URL : " . $sms_link . "\n\n수신거부.\n고객센터 : 1855-4549";
            $phone = "01051258016";
            $smsResult = $sendLib->sendSMS($phone, $strMsg);
        }
    }

    //푸시 전송
    public function pushSendData($send_type = 'm', $type = 'appopen', $push_link, $push_title, $push_message, $push_imgurl, $send_data, $send_data_type = 'I')
    {
        $url = "https://api.highbuff.com/interview/20/send_push.php";
        $post_data = array(
            'sendtype' => $send_type, //전송 토큰개수에 따라 처리 타입(개별, 멀티, 토픽:현재구현X)
            'type' => $type, //앱 처리 타입
            'link' => $push_link, //푸시 선택시 링크
            'title' => $push_title, //푸시 제목
            'message' => $push_message, //푸시 메시지
            'imgurl' => $push_imgurl, //이미지 저장 URL
            'send_data' => $send_data,  // 받는사람 mem_id ex ID1,ID2,ID3
            'send_data_type' => $send_data_type
        );
        $result = $this->restAPIcurl($url, $post_data);

        return $result;
    }

    //CURL 전송 처리
    public function restAPIcurl($url, $post_data = [])
    {
        //$url = "https://api.highbuff.com/interview/20/send_push.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
