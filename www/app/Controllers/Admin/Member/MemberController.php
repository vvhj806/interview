<?php

namespace App\Controllers\Admin\Member;

use App\Controllers\BaseController;
use App\Models\MemberModel;

use Config\Database;
use Config\Services;
use App\Libraries\EncryptLib;

class MemberController extends BaseController
{
    public $db;
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function commonData(): array
    {
        // data init
        $aData = [];
        $aData['data'] = $this->viewData;

        $session = session();
        $aData['data']['session'] = [
            'id' => $session->get('mem_id')
        ];
        return $aData;
    }

    public function header()
    {
        // data init
        $aData = $this->commonData();
        echo view('prime/templates/header', $aData);
    }
    public function nav()
    {
        // data init
        $aData = $this->commonData();
        echo view('prime/templates/topNav', $aData);
        echo view('prime/templates/leftNav', $aData);
        echo view('prime/templates/contentHeader.php', $aData);
    }

    public function footer()
    {
        // data init
        $aData = $this->commonData();
        echo view('prime/templates/contentFooter.php', $aData);
        echo view('prime/templates/footer.php', $aData);
    }


    public function view($slug = null)
    {
        $model = model(NewsModel::class);
        $data['news'] = $model->getNews($slug);
        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        echo view('templates/header', $data);
        echo view('news/view', $data);
        echo view('templates/footer', $data);
    }

    public function list($type = '')
    {
        if (!$type || !in_array($type, ['m', 'c', 'a', 'l'])) {
            return alert_back('잘못된접근입니다.');
        }
        // data init
        $aData = $this->commonData();
        $memberModel = new MemberModel('iv_member');
        $aRow = $memberModel->getList('all', strtoupper($type));
        $aData = [
            'member'=>$aRow->paginate(5),
            'pager' => $aRow->pager,
        ];
        var_dump($aData);
        exit;
        // $pager = \Config\Services::pager();
        // $data = [
        //     'member' => $memberModel->paginate(2),
        //     'pager' => $memberModel->pager,
        // ];

        // var_dump($data['member']);
        // view
        $this->header();
        $this->nav();
        echo view('prime/member/member', $aData);
        $this->footer();
    }

    public function add()
    {
        // data init
        $aData = $this->commonData();

        // view
        $this->header();
        $this->nav();
        echo view('prime/member/add', $aData);
        $this->footer();
    }

    public function addAction()
    {
        //action page
        $strType = $this->request->getPost('type');
        $strId = $this->request->getPost('id');
        $strPassword = $this->request->getPost('password');
        if (!$strType || !$strId || !$strPassword || !in_array($strType, ['M', 'C'])) {
            return alert_back('잘못된접근입니다.');
        }

        $encryptLib = new EncryptLib();
        $memberModel = new MemberModel('iv_member');
        $iCntId = $memberModel->checkMemberId($strId);
        if ($iCntId == 0) {
            $saveData = [
                'mem_type' => $strType,
                'mem_id' => $strId,
                'mem_password' => $encryptLib->makePassword($strPassword)
            ];
            $memberModel->save($saveData);
        } else {
            return alert_back('존재하는아이디입니다.');
        }
        return alert_url('저장하였습니다.', '/prime/member/add');
    }


    public function __destruct()
    {
        $this->db->close();
    }
}
