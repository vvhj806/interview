<?php

namespace App\Controllers\API\Auth;

use App\Controllers\API\APIController;
use App\Models\{
    MemberModel,
    MemberTokenModel
};
use CodeIgniter\I18n\Time;
use App\Libraries\SendLib;

class TokenController extends APIController
{
    private $aResponse = [];

    public function index()
    {
        // $this->config->set_item('csrf_highbuff', false);

        $dates = date("Y-m-d H:i:s");
        $addr = $_SERVER["REMOTE_ADDR"];
        $userToken = $this->request->getPost('user_token');
        // $userToken = $_POST['user_token'];
        // $userToken = $this->request->getGet('user_token');
        $userId = $this->request->getPost('user_id');
        // $userId = $_POST['user_id'];
        // $userId = $this->request->getGet('user_id');
        $SendLib = new SendLib();
        $MemberModel = new MemberModel();
        $MemberTokenModel = new MemberTokenModel();

        if (!$userToken || !$userId) {
            $str = "[IV_ERROR]\n경로 : /app/get_token.php\n에러 : 비정상접근 토큰 혹은 id 없음\n#user_token=" . $userToken . "#user_id=" . $userId;
            $SendLib->telegramSend($str, "DEV");

            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("status" => "400", "error" => "비정상접근 토큰 혹은 id11 없음", "user_token" => $userToken, "user_id" => $userId), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
            echo $json;
            return;
        }
        $aMember = $MemberModel->getMember($userId);

        if (!$aMember) {
            $str = "[IV_ERROR]\n경로 : /app/get_token.php\n에러 : 유저 정보 없음\nuser_id=" . $userId;
            $SendLib->telegramSend($str, "DEV");

            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("status" => "400", "error" => "유저 정보 없음", "nuser_id" => $userId), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
            echo $json;
            return;
        }

        $aMemToken = $MemberTokenModel->getToken($userToken, $aMember['idx']);
        if (!$aMemToken) {
            $this->masterDB->transBegin();
            $result = $this->masterDB->table('iv_member_token')
                ->set([
                    'mem_idx' => $aMember['idx'],
                    'token' => $userToken,
                    'mem_token_reg_date' => $dates,
                    'mem_token_mod_date' => $dates
                ])
                ->insert();

            $this->masterDB->table('iv_member')
                ->set([
                    'mem_token' => $userToken
                ])
                ->where([
                    'idx' => $aMember['idx']
                ])
                ->update();

            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
            } else {
                $this->masterDB->transCommit();
            }

            // 트랜잭션 검사
            if ($this->masterDB->transStatus()) {
                header('Content-Type: application/json; charset=utf8');
                $json = json_encode(array("status" => "200", "name" => $aMember["mem_name"]), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
                echo $json;
            } else {
                header('Content-Type: application/json; charset=utf8');
                $json = json_encode(array("status" => "400", "error" => 'insert 또는 update 가 안됨'), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
                echo $json;
            }
        } else {
            $this->masterDB->table('iv_member')
                ->set([
                    'mem_token' => $userToken
                ])
                ->where([
                    'idx' => $aMember['idx']
                ])
                ->update();

            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("status" => "200", "name" => $aMember["mem_name"]), JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    }

    public function create()
    {
    }

    public function show($id = null)
    {
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }
}
