<?php

namespace App\Controllers\API\My\Scrap;

use App\Controllers\API\APIController;
use App\Models\MemberRecruitScrapModel;

class ScrapController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function create(string $scrapType, int $memIdx, int $idx)
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        if (!in_array($scrapType, ['recruit', 'company'])) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }
        $session = session();
        $boolSuccess = true;
        if (!$session->has('idx') || !$memIdx || $session->get('idx') != $memIdx || !$idx || $session->get('mem_type') != 'M') {
            $boolSuccess = false;
        }

        $memberRecruitScrapModel = new MemberRecruitScrapModel();
        $iCountScrap = $memberRecruitScrapModel->selectCount('idx')->where(['mem_idx' => $memIdx, 'delyn' => 'N']);
        if ($scrapType == 'recruit') {
            $iCountScrap = $iCountScrap->where(['rec_idx' => $idx])->first();
        } else {
            $iCountScrap = $iCountScrap->where(['com_idx' => $idx])->first();
        }

        if ($iCountScrap['idx'] == 0 && $boolSuccess) {
            $readyDB = $this->masterDB->table('iv_member_recruit_scrap')
                ->set([
                    'mem_idx' => $memIdx,
                ])
                ->set(['scr_reg_date' => 'NOW()'], '', false)
                ->set(['scr_mod_date' => 'NOW()'], '', false);
            if ($scrapType == 'recruit') {
                $result = $readyDB
                    ->set([
                        'rec_idx ' => $idx,
                        'scr_type' => 'R',
                    ])->insert();
            } else {
                $result = $readyDB
                    ->set([
                        'com_idx ' => $idx,
                        'scr_type' => 'C',
                    ])->insert();
            }

            if ($result) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            } else {
                $this->aResponse = [
                    'status'   => 500,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        } else {
            $this->aResponse = [
                'status'   => 404,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash(),
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function show($id = null)
    {
    }

    public function update($id = null)
    {
    }

    public function delete(string $scrapType, int $memIdx, int $idx)
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        if (!in_array($scrapType, ['recruit', 'company'])) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }
        $session = session();
        $boolSuccess = true;
        if (!$session->has('idx') || !$memIdx || $session->get('idx') != $memIdx || !$idx || $session->get('mem_type') != 'M') {
            $boolSuccess = false;
        }

        $memberRecruitScrapModel = new MemberRecruitScrapModel();

        $iCountScrap = $memberRecruitScrapModel->selectCount('idx')->where(['mem_idx' => $memIdx, 'delyn' => 'N']);
        if ($scrapType == 'recruit') {
            $iCountScrap = $iCountScrap->where(['rec_idx' => $idx])->first();
        } else {
            $iCountScrap = $iCountScrap->where(['com_idx' => $idx])->first();
        }

        if ($iCountScrap['idx'] > 0 && $boolSuccess) {
            $readyDB = $this->masterDB->table('iv_member_recruit_scrap')
                ->set(['delyn' => 'Y'])
                ->set(['scr_del_date' => 'NOW()'], '', false)
                ->where(['mem_idx' => $memIdx, 'delyn' => 'N']);
            if ($scrapType == 'recruit') {
                $result = $readyDB->where(['rec_idx' => $idx])->update();
            } else {
                $result = $readyDB->where(['com_idx' => $idx])->update();
            }
            if ($result) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['success10'],
                ];
            } else {
                $this->aResponse = [
                    'status'   => 500,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
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
