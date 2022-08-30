<?php

namespace App\Controllers\API\Auth;

use App\Controllers\API\APIController;
use App\Models\{AuthTelModel, MemberModel};
use CodeIgniter\I18n\Time;
use App\Libraries\SendLib;

class TelController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

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

        $strToTel = $this->request->getPost('phone');
        $strToTel = str_replace("-", "", $strToTel);
        $strType = $this->request->getPost('type');
        if (!$strToTel || !in_array($strType, ['J', 'I', 'P', 'M'])) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }
        if ($strType === 'J') {
            $memberModel = new MemberModel();
            if ($memberModel->getMemberTel($strToTel, 'M')) {
                return $this->respond([
                    'status'   => 401,
                    'code'     => 'fail',
                    'messages' => $this->globalvar->aApiMsg['error9'],
                ], 401);
            }
        }

        $strBeforetime = new Time('now');
        $strBeforetime = $strBeforetime->subMinutes(3)->toLocalizedString('yyyy-MM-dd HH:mm:ss');

        $authTelModel = new AuthTelModel();
        $strBeforeDate = date("Y-m-d H:i:s", strtotime("-3 minutes"));
        $iCount = $authTelModel->selectCount('idx')
            ->where([
                'auth_tel' => $strToTel,
                'auth_start_date >' => $strBeforeDate,
                'auth_type' => $strType
            ])->first()['idx'];
        if ($iCount < 3) {
            $iCertNumber = rand(100000, 999999);

            if ($strType == "I") {
                $strMsg = "[인증번호:" . $iCertNumber . "] 하이버프 인터뷰\n아이디찾기 인증번호입니다.";
            } else if ($strType == "P") {
                $strMsg = "[인증번호:" . $iCertNumber . "] 하이버프 인터뷰\n패스워드찾기 인증번호입니다.";
            } else if ($strType == "M") {
                $strMsg = "[인증번호:" . $iCertNumber . "] 하이버프 인터뷰\n연락처변경 인증번호입니다.";
            } else {
                $strMsg = "[인증번호:" . $iCertNumber . "] 하이버프 인터뷰\n회원가입 인증번호입니다.";
            }

            $sendLib = new SendLib();
            $smsResult = $sendLib->sendSMS($strToTel, $strMsg);

            if ($smsResult == 200) {
                $result = $this->masterDB->table('iv_auth_tel')
                    ->set([
                        'auth_tel' => $strToTel,
                        'auth_code' => $iCertNumber,
                        'auth_type' => $strType
                    ])
                    ->set(['auth_start_date' => 'NOW()'], '', false)
                    ->insert();

                if ($result) {
                    $this->aResponse = [
                        'status'   => 201,
                        'code'     => [
                            'stat' => 'success',
                            'iCertNumber' => $iCertNumber,
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['success4'],
                    ];
                } else {
                    $this->aResponse = [
                        'status'   => 400,
                        'code'     => [
                            'stat' => 'fail',
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['error10'],
                    ];
                }
            } else {
                $this->aResponse = [
                    'status'   => $smsResult,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        } else {
            //3분이내 3번 요청
            $this->aResponse = [
                'status'   => 403,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error11'],
            ];
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function inquire(string $tel, int $code)
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }


        $tel = str_replace("-", "", $tel);

        $authNum = $this->request->getPost('authNum');
        if ($authNum != '' && $authNum != $code) {
            $this->aResponse = [
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error12'],
            ];
        } else {
            $authTelModel = new AuthTelModel();
            $aRowData = $authTelModel->where([
                'auth_tel' => $tel,
                'auth_code' => $code,
                'auth_type' => 'J',
            ])->first();
            $strBeforetime = new Time('now');
            $strBeforetime = $strBeforetime->subMinutes(3)->toLocalizedString('yyyy-MM-dd HH:mm:ss');
            if (isset($aRowData['idx']) && $aRowData['idx'] > 0) {
                if ($aRowData['auth_start_date'] > $strBeforetime) {
                    $this->aResponse = [
                        'status'   => 200,
                        'code'     => [
                            'stat' => 'success',
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['success5'],
                    ];
                } else {
                    $this->aResponse = [
                        'status'   => 200,
                        'code'     => [
                            'stat' => 'fail',
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['error13'],
                    ];
                }
            } else {
                $this->aResponse = [
                    'status'   => 400,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error2'],
                ];
            }
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function inquireModify(string $tel, int $code)
    {

        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        $authNum = $this->request->getPost('authNum');
        if ($authNum != '' && $authNum != $code) {
            $this->aResponse = [
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error12'],
            ];
        } else {
            $authTelModel = new AuthTelModel();
            $aRowData = $authTelModel->where([
                'auth_tel' => $tel,
                'auth_code' => $code,
                'auth_type' => 'M',
            ])->first();
            $strBeforetime = new Time('now');
            $strBeforetime = $strBeforetime->subMinutes(3)->toLocalizedString('yyyy-MM-dd HH:mm:ss');
            if (isset($aRowData['idx']) && $aRowData['idx'] > 0) {
                if ($aRowData['auth_start_date'] > $strBeforetime) {
                    $this->aResponse = [
                        'status'   => 200,
                        'code'     => [
                            'stat' => 'success',
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['success5'],
                    ];
                } else {
                    $this->aResponse = [
                        'status'   => 200,
                        'code'     => [
                            'stat' => 'fail',
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['error13'],
                    ];
                }
            } else {
                $this->aResponse = [
                    'status'   => 400,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error2'],
                ];
            }
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
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
