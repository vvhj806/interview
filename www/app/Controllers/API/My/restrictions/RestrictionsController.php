<?php

namespace App\Controllers\API\My\Restrictions;

use App\Controllers\API\APIController;
use App\Models\MemberRecruitScrapModel;
use App\Models\MemberRestrictionsCompanyModel;

class RestrictionsController extends APIController
{
    private $aResponse = [];

    public function create(int $memIdx, int $comIdx)
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error3'],
            ], 403);
        }
        if (!$memIdx || !$comIdx) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }
        $session = session();
        $realIdx = $session->has('idx');
        $boolSuccess = true;
        if ((!$realIdx || !$memIdx) || ($realIdx != $memIdx)) {
            $boolSuccess = false;
        }

        $memberRestrictionsCompanyModel = new MemberRestrictionsCompanyModel();
        $check = $memberRestrictionsCompanyModel
            ->getRestrictionsList($memIdx)
            ->where(['iv_member_restrictions_company.com_idx' => $comIdx])
            ->first();
        if (!$check) {
            if ($boolSuccess) {
                $result = $this->masterDB->table('iv_member_restrictions_company')
                    ->set([
                        'mem_idx' => $memIdx,
                        'com_idx ' => $comIdx
                    ])
                    ->set(['mem_res_reg_date' => 'NOW()'], '', false)
                    ->insert();
                if ($result) {
                    $this->aResponse = [
                        'status'   => 200,
                        'code'     => [
                            'stat' => 'success'
                        ],
                        'messages' => $this->globalvar->aApiMsg['success8'],
                    ];
                } else {
                    $this->aResponse = [
                        'status'   => 500,
                        'code'     => [
                            'stat' => 'fail'
                        ],
                        'messages' => $this->globalvar->aApiMsg['error3'],
                    ];
                }
            } else {
                $this->aResponse = [
                    'status'   => 404,
                    'code'     => [
                        'stat' => 'fail'
                    ],
                    'messages' => $this->globalvar->aApiMsg['error2'],
                ];
            }
        } else {
            $this->aResponse = [
                'status'   => 404,
                'code'     => [
                    'stat' => 'fail'
                ],
                'messages' => $this->globalvar->aApiMsg['error19'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $memIdx, int $comIdx)
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        if (!$memIdx || !$comIdx) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }

        $session = session();
        $realIdx = $session->has('idx');
        $boolSuccess = true;
        if ((!$realIdx || !$memIdx) || ($realIdx != $memIdx)) {
            $boolSuccess = false;
        }

        $memberRestrictionsCompanyModel = new MemberRestrictionsCompanyModel();
        $aRestrictions = $memberRestrictionsCompanyModel
            ->getRestrictionsList($memIdx)
            ->where(['iv_member_restrictions_company.com_idx' => $comIdx])
            ->first();

        if ($aRestrictions && $boolSuccess) {
            $result = $this->masterDB->table('iv_member_restrictions_company')
                ->set(['delyn' => 'Y'])
                ->set(['mem_res_del_date' => 'NOW()'], '', false)
                ->where([
                    'mem_idx' => $memIdx,
                    'com_idx' => $comIdx,
                    'delyn' => 'N'
                ])
                ->update();
            if ($result) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success'
                    ],
                    'messages' => $this->globalvar->aApiMsg['success9'],
                ];
            } else {
                $this->aResponse = [
                    'status'   => 500,
                    'code'     => [
                        'stat' => 'fail'
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        } else {
            $this->aResponse = [
                'status'   => 404,
                'code'     => [
                    'stat' => 'fail'
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }
}
