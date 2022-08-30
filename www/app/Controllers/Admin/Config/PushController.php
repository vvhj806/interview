<?php

namespace App\Controllers\Admin\Config;

use App\Controllers\Admin\AdminController;

use Config\Database;
use App\Models\MemberModel;
use Config\Services;

class PushController extends AdminController
{

    public function index()
    {
        $this->push();
    }

    public function push()
    {

        $this->commonData();

        $searchKeyword = $this->request->getPost('search_keyword') ?? '';

        $memberModel = new MemberModel();
        $this->aData['memList'] = $memberModel->getMemberList($searchKeyword, 'push');

        // view
        $this->header();
        $this->nav();
        echo view('prime/config/push', $this->aData);
        $this->footer();
    }

    public function sendPush()
    {
        $send_data = $this->request->getPost('send_data') ?? '';
        $push_link = $this->request->getPost('push_link') ?? '';
        $push_title = $this->request->getPost('push_title') ?? '';
        $push_message = $this->request->getPost('push_message') ?? '';
        $push_imgurl = $this->request->getPost('push_imgurl') ?? '';

        $result = $this->commonClass->pushSendData('m', 'appopen', $push_link, $push_title, $push_message, $push_imgurl, $send_data, 'M');

           $data_result = json_decode($result);

        if ($data_result->success == 1) {
            return alert_url('전송완료되었습니다.', '/prime/config/push');
        } else {
            return alert_url('전송 중 오류 발생. 개발팀에 문의 해주세요', '/prime/config/push');
        }
    }
}
