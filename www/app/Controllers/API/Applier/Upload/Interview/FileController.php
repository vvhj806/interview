<?php

namespace App\Controllers\API\Applier\Upload\Interview;

use App\Controllers\API\APIController;

use App\Models\{
    ApplierModel,
    JobCategoryModel,
    MemberModel
};
use App\Libraries\SendLib;

class FileController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function show($id = null)
    {
    }

    public function updateInterview()
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        $session = session();
        $iMemIdx = $this->request->getPost('memIdx');
        $strAppliyIdx = $this->request->getPost('index');
        $strCount = $this->request->getPost('count');
        $strQidx = $this->request->getPost('q_idx');
        $strTime = $this->request->getPost('time');
        $strRand = $this->request->getPost('rand');
        $iRepoIdx = $this->request->getPost('repoIdx');
        $strPostCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('BackUrl');
        $strSpeechText = $this->request->getPost('speech_text');

        if (!$session->has('idx') || $session->get('idx') != $iMemIdx || $strPostCase != 'video_upload' || !$strAppliyIdx || !$strCount || !$strQidx || !$strTime || !$strRand || !$strBackUrl || !$iRepoIdx) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        //s_22.04.29 igg 상호대화형 작업을 위해서 데이터 작업
        if ($strSpeechText != '') {
            $postfields = array(
                'method' => 'setInteraction',
                'speech_text' => $strSpeechText,
                'applier_idx' => $strAppliyIdx,
                'question_idx' => $strQidx,
                'question_count' => $strCount,
                'server' => $this->globalvar->getServerHost()
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.highbuff.com/interview/20/interaction.php');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $result = curl_exec($ch);
            curl_close($ch);
            //$json = json_decode($result, true);
        }
        //e_22.04.29 igg 상호대화형 작업을 위해서 데이터 작업

        //트랜잭션 start
        $this->masterDB->transBegin();

        $result = $this->masterDB->table('iv_video')
            ->set([
                'app_idx' => $strAppliyIdx,
                'que_idx' => $strQidx,
                'video_record' => $strAppliyIdx . '-record_' . $strCount . '-' . $strQidx . '-' . $strTime . '-' . $strRand . '.webm',
                'repo_res_idx' => $iRepoIdx,
            ])
            ->set(['video_reg_date' => 'NOW()'], '', false)
            ->set(['video_mod_date' => 'NOW()'], '', false)
            ->insert();

        $result2 =  $this->masterDB->table('iv_report_result')
            ->set([
                'repo_process' => 1,
            ])
            ->set(['repo_mod_date' => 'NOW()'], '', false)
            ->where([
                'applier_idx' => $strAppliyIdx,
                'que_idx' => $strQidx,
                'idx' => $iRepoIdx
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
            $ApplierModel = new ApplierModel();
            $aAllapplierInfo = $ApplierModel->startInterview($strAppliyIdx);
        } else {
            return $this->aResponse = [
                'status'   => 500,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error3'],
            ];
        }

        if ($aAllapplierInfo[0]['next_question'] == "" || $aAllapplierInfo[0]['next_question'] == null) {

            $result3 =  $this->masterDB->table('iv_applier')
                ->set([
                    'app_iv_stat' => 3,
                ])
                ->set(['app_mod_date' => 'NOW()'], '', false)
                ->where('idx', $strAppliyIdx)
                ->where('mem_idx', $iMemIdx)
                ->update();

            if ($result3) {
                $sendLib = new SendLib();
                $jobCategoryModel = new JobCategoryModel();
                $MemberModel = new MemberModel();
                $cache = \Config\Services::cache();


                $aMemberInfo = $MemberModel->MypageMem($iMemIdx);
                $strCode = "";

                $aAllCategory = $cache->get('aAlljobCate.each');
                if (!$aAllCategory) {
                    $aAllCategory = $jobCategoryModel->getAllcategory();
                }

                foreach ($aAllCategory as $val) {
                    foreach ($val as $key2 => $val2) {
                        if ($key2 != 0) {
                            if ($val2['idx'] == $aAllapplierInfo[0]['job_idx']) {
                                $strCode = $val2['job_depth_1'];
                                break;
                            }
                        }
                    }
                }

                if (strpos($strCode, '14')) {
                    $msg = "*영어면접*\n[하이버프인터뷰_완료_알림]\n유저명 : " . $aMemberInfo['mem_name'] . "(" . $aMemberInfo['mem_id'] . ")\n연락처 : " . $aMemberInfo['mem_tel'] . "\n<a href='https://" . $_SERVER['SERVER_NAME'] . "/lbquick'>[평가하러가기]</a>";
                } else {
                    $msg = "[하이버프인터뷰_완료_알림]\n유저명 : " . $aMemberInfo['mem_name'] . "(" . $aMemberInfo['mem_id'] . ")\n연락처 : " . $aMemberInfo['mem_tel'] . "\n<a href='https://" . $_SERVER['SERVER_NAME'] . "/lbquick'>[평가하러가기]</a>";
                }

                $sendLib->telegramSend($msg, "company");

                $this->aResponse = [
                    'status'   => 201,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['success2'],
                ];
            } else {
                $sendLib = new SendLib();
                $sendResult = $sendLib->telegramSend("[하이버프2.0_ERROR]<br>경로: /API/Applier/Upload/Interview/FileController.php<br>에러: iv_applier 테이블 app_iv_stat 3으로 update 오류", "DEV");

                $this->aResponse = [
                    'status'   => 501,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        } else {
            if ($result && $result2) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'All' => $aAllapplierInfo,
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            } else {
                $sendLib = new SendLib();
                $sendResult = $sendLib->telegramSend("[하이버프2.0_ERROR]<br>경로: /API/Applier/Upload/Interview/FileController.php<br>에러: iv_applier 테이블 update 오류", "DEV");

                $this->aResponse = [
                    'status'   => 500,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $idx)
    {
    }
}
