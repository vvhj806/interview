<?php

namespace App\Controllers\API\Auth\Find;

use App\Controllers\API\APIController;
use App\Libraries\ShortUrlLib;
use Config\Services;
use App\Libraries\SendLib;
use App\Models\MemberModel;
use App\Models\AuthTelModel;
use App\Models\LogSendEmailModel;
use CodeIgniter\I18n\Time;

class FindController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function create()
    {
    }

    public function findId(string $type)
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

        $strTel = $this->request->getPost('tel');
        $strCode = $this->request->getPost('code');
        $strPostCase = $this->request->getPost('postCase');
        if (!in_array($type, ['person', 'company']) || $strPostCase != 'find_id' || !$strTel || !$strCode) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat'     => 'fail',
                    'messages' => $this->globalvar->aApiMsg['error2'],
                    'token' => csrf_hash(),
                ]
            ], 400);
        }
        $authNum = $this->request->getPost('authNum');
        if ($authNum != '' && $authNum != $strCode) {
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
            $aAuthData = $authTelModel->where([
                'auth_tel' => $strTel,
                'auth_code' => $strCode,
                'auth_type' => 'I',
            ])->first();

            if ($aAuthData && $aAuthData['auth_tel']) {
                $memberModel = new MemberModel();
                $aMemberData = $memberModel->getMemberTel($strTel, $type == 'person' ? 'M' : 'C');

                if ($aMemberData && $aMemberData['mem_id']) {
                    $this->aResponse = [
                        'status'   => 200,
                        'code'     => [
                            'stat' => 'success',

                            'id' =>  $aMemberData['mem_id']
                        ],
                        'messages' => $this->globalvar->aApiMsg['success6'],
                    ];
                } else {
                    $this->aResponse = [
                        'status'   => 400,
                        'code'     => [
                            'stat' => 'fail',
                            'token' => csrf_hash(),
                            'id' => ''
                        ],
                        'messages' => $this->globalvar->aApiMsg['error17'],
                    ];
                }
            } else {
                $this->aResponse = [
                    'status'   => 400,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash(),
                        'id' => ''
                    ],
                    'messages' => $this->globalvar->aApiMsg['error12'],
                ];
            }
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function findPassword(string $type)
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

        $strToTel = $this->request->getPost('tel');
        $strCode = $this->request->getPost('code');
        $strId = $this->request->getPost('id');
        $strPostCase = $this->request->getPost('postCase');
        $page = $this->request->getPost('page');

        if (!in_array($type, ['person', 'company']) || !$strToTel || !$strCode || !$strId || $strPostCase != 'find_pwd') {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        $authNum = $this->request->getPost('authNum');
        if ($authNum != '' && $authNum != $strCode) {
            $this->aResponse = [
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error12'],
            ];
        } else {
            $memberModel = new MemberModel();
            $amemberData = $memberModel->where([
                'mem_id' => $strId,
                'mem_tel' => $strToTel,
                'mem_type' => $type == 'person' ? 'M' : 'C'
            ])->first();

            $aLeaveMemData = $memberModel->where([
                'mem_id' => $strId,
                'mem_tel' => $strToTel,
                'mem_type' => $type == 'person' ? 'M' : 'C',
                'delyn' => 'Y'
            ])->first();


            if (!$amemberData) {
                return $this->respond([
                    'status'   => 400,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error14'],
                ], 400);
            }

            if ($aLeaveMemData) {
                return $this->respond([
                    'status'   => 401,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error21'],
                ], 401);
            }

            $strToTel = str_replace("-", "", $strToTel);

            $authTelModel = new AuthTelModel();
            $logSendEmailModel = new LogSendEmailModel();

            $strBeforeDate = date("Y-m-d H:i:s", strtotime("-5 minutes"));

            $iCount = $logSendEmailModel->selectCount('idx')
                ->where([
                    'send_email_to' => $strId,
                    'send_email_reg_date >' => $strBeforeDate
                ])->first()['idx'];

            if ($iCount < 1) {

                $aAuthData = $authTelModel->where([
                    'auth_tel' => $strToTel,
                    'auth_code' => $strCode,
                    'auth_type' => 'P',
                ])->first();

                if ($aAuthData) {
                    $aUserData = [
                        'id' => $strId,
                        'phone' => $strToTel,
                        'auth' => $strCode
                    ];

                    //비밀번호 reset URL 생성    
                    $encrypter = Services::encrypter();
                    $ciphertext = base64url_encode($encrypter->encrypt(json_encode($aUserData)));

                    if ($type == 'person') {
                        $strResetUrl = "/login/reset/person/pwd?data=" . $ciphertext;
                    } else {
                        $strResetUrl = "/login/reset/company/pwd?data=" . $ciphertext;
                    }

                    $shortUrlLib = new ShortUrlLib();
                    $strShortUrl = $shortUrlLib->setShortUrl($strResetUrl, date('is'));
                    $strReseturl = $this->globalvar->getShortUrl() . '/' . $strShortUrl;

                    $strTitle = '하이버프 인터뷰 [비밀번호 변경 url] 입니다.';
                    $strMsg = '<img src="https://interview.highbuff.com/static/www/img/inc/logo_txt.png"><br><br><p>하이버프 인터뷰<br>비밀번호 변경 URL 입니다 <br><a href='.$strReseturl.'>'.$strReseturl;

                    // email 보내기
                    $email = Services::email();
                    $email->clear();
                    $email->setTo($strId);
                    $email->setFrom($this->globalvar->getEmailFromMail(), $this->globalvar->getEmailFromName());
                    $email->setSubject($strTitle);
                    $email->setMessage($strMsg);
                    $emailResult = $email->send();

                    // sendmail config 안쓰고 바로 보내는 방법
                    // $mailto = "vvhj_806@naver.com"; //받는사람
                    // $subject = $strTitle; //제목
                    // $content = $strMsg; //내용
                    // $headers = "From: help@highbuff.com"; //보내는 사람
                    // $emailResult = mail($mailto, $subject, $content, $headers); //메일전송

                    if ($emailResult) {
                        $result = $this->masterDB->table('log_send_email')
                            ->set([
                                'send_email_to' => $strId,
                                'send_email_page' => $page
                            ])
                            ->set(['send_email_reg_date' => 'NOW()'], '', false)
                            ->insert();

                        if ($result) {
                            $this->aResponse = [
                                'status'   => 200,
                                'code'     => [
                                    'stat' => 'success',
                                    'token' => csrf_hash()
                                ],
                                'messages' => $this->globalvar->aApiMsg['success7'],
                            ];
                        } else {
                            $this->aResponse = [
                                'status'   => 200,
                                'code'     => [
                                    'stat' => 'fail',
                                    'token' => csrf_hash()
                                ],
                                'messages' => $this->globalvar->aApiMsg['error3'],
                            ];
                        }
                    } else {
                        $this->aResponse = [
                            'status'   => 400,
                            'code'     => [
                                'stat' => 'fail',
                                'token' => csrf_hash()
                            ],
                            'messages' => $this->globalvar->aApiMsg['error15'],
                        ];
                    }
                } else {
                    $this->aResponse = [
                        'status'   => 400,
                        'code'     => [
                            'stat' => 'fail',
                            'token' => csrf_hash()
                        ],
                        'messages' => $this->globalvar->aApiMsg['error12'],
                    ];
                }
            } else {
                //5분이내 1번 요청
                $this->aResponse = [
                    'status'   => 403,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error16'],
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
