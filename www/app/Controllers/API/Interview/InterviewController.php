<?php

namespace App\Controllers\API\Interview;

use App\Controllers\API\APIController;
use Config\Services;

use App\Models\{
    InterviewModel,
};

use App\Libraries\SendLib;

class InterviewController extends APIController
{
    private $aResponse = [];

    public function create()
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
        $iMemIdx = $session->get('idx');
        $iComIdx = $this->request->getPost('comIdx');
        $iJobIdx = $this->request->getPost('jobIdx');
        $iInterTime = $this->request->getPost('interTime');
        $iInterType = $this->request->getPost('interType');
        $aQueIdx = $this->request->getPost('queIdx');
        $aQueIdx = implode(',', $aQueIdx);

        if ($iMemIdx && $iComIdx && $iJobIdx && $iInterTime && $aQueIdx && $iInterType) {
            //트랜잭션 start
            $this->masterDB->transBegin();

            $this->masterDB->table('iv_interview_info')
                ->set([
                    'com_idx' => $iComIdx,
                    'reg_mem_idx' => $iMemIdx,
                    'mod_mem_idx' => $iMemIdx,
                    'job_idx' => $iJobIdx,
                ])
                ->set(['info_reg_date' => 'NOW()'], '', false)
                ->set(['info_mod_date' => 'NOW()'], '', false)
                ->insert();
            $iInfoIdx = $this->masterDB->insertID();

            $this->masterDB->table('iv_interview')
                ->set([
                    'mem_idx' => $iMemIdx,
                    'info_idx' => $iInfoIdx,
                    'job_idx_position' => $iJobIdx,
                    'inter_answer_time' => $iInterTime,
                    'inter_type' => $iInterType,
                    'inter_repot_yn' => 'Y',
                    'inter_opportunity_yn' => 'Y',
                    'inter_question' => $aQueIdx
                ])
                ->set(['inter_reg_date' => 'NOW()'], '', false)
                ->set(['inter_mod_date' => 'NOW()'], '', false)
                ->insert();
            $iInterIdx = $this->masterDB->insertID();

            $this->masterDB->table('iv_interview_info')
                ->set([
                    'inter_idx' => $iInterIdx
                ])
                ->set(['info_mod_date' => 'NOW()'], '', false)
                ->where('idx', $iInfoIdx)
                ->update();

            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
                $this->aResponse = [
                    'status'   => 503,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            } else {
                $this->masterDB->transCommit();
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash(),
                        'idx' => $iInterIdx
                    ],
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            }
        } else {
            $this->aResponse = [
                'status'   => 404,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }
}
