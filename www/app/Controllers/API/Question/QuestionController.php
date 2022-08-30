<?php

namespace App\Controllers\API\Question;

use App\Controllers\API\APIController;
use Config\Services;

use App\Models\{
    ApplierModel,
    JobCategoryModel,
    SetReportScoreRankModel,
    QuestionModel,
    MemberModel
};

class QuestionController extends APIController
{
    private $aResponse = [];

    public function create(int $iJobIdx)
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

        $strQueType = $this->request->getPost('queType');
        $strLangType = $this->request->getPost('langType');
        $strQueText = $this->request->getPost('queText');
        $strQueBestAnswer = $this->request->getPost('queBestAnswer');

        if (!in_array($strQueType, ['G', 'A', 'C', 'J'])) {
            $strQueType = false;
        }

        if (!in_array($strLangType, ['kor', 'eng'])) {
            $strLangType = false;
        }

        if ($iJobIdx && $strQueType && $strLangType && $strQueText) {
            $result = $this->masterDB->table('iv_question')
                ->set([
                    'job_idx' => $iJobIdx,
                    'que_type' => $strQueType,
                    'que_question' => $strQueText,
                    'que_best_answer' => $strQueBestAnswer,
                    'que_lang_type' => $strLangType === 'kor' ? '0' : '1'
                ])
                ->set(['que_reg_date' => 'NOW()'], '', false)
                ->insert();
            $iQueIdx = $this->masterDB->insertID();

            if ($result) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash(),
                        'idx' => $iQueIdx,
                        'item' => ['que_question' => $strQueText, 'que_type' => $strQueType, 'que_best_answer' => $strQueBestAnswer]
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
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function read(int $iJobIdx)
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

        $strQueText = $this->request->getPost('queText') ?? '';

        if ($iJobIdx) {
            $questionModel = new QuestionModel('iv_question');

            // if ($strQueText) {
            //     $questionModel
            //         ->groupStart()
            //         ->like('que_question', $strQueText, 'both')
            //         ->groupEnd();
            // }

            if ($iJobIdx != 0) {
                $questionModel
                    ->where(['job_idx' => $iJobIdx]);
            }

            $aList = $questionModel->bizQuestion();

            $aResultList = [];
            foreach ($aList as $val) {
                $aResultList[$val['idx']] = ['que_question' => $val['que_question'], 'que_type' => $val['que_type'], 'que_best_answer' => $val['que_best_answer']];
            }

            if ($aList) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash(),
                        'item' => $aResultList
                    ]
                ];
            } else {
                $this->aResponse = [
                    'status'   => 201,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error17'],
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

    public function update(int $iQueIdx)
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

        $strQueText = $this->request->getPost('queText');
        $strQueType = $this->request->getPost('queType');
        $strQueBestAnswer = $this->request->getPost('queBestAnswer');

        if ($iQueIdx && $strQueText) {

            $readyQuery = $this->masterDB->table('iv_question')
                ->set([
                    'que_question' => $strQueText,
                    'que_best_answer' => $strQueBestAnswer,
                ])
                ->set(['que_mod_date' => 'NOW()'], '', false)
                ->where(['idx' => $iQueIdx]);

            if ($strQueType) {
                if (in_array($strQueType, ['G', 'A', 'J', 'C'])) {
                    $readyQuery->set(['que_type' => $strQueType]);
                } else if ($strQueType === 'spell') {
                    $readyQuery->set(['que_spell_check' => '{\"status\": 200}']);
                }
            }

            $result = $readyQuery->update();

            $iQueIdx = $this->masterDB->insertID();

            if ($result) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash(),
                        'item' => [$iQueIdx => ['que_question' => $strQueText, 'que_type' => $strQueType]]
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
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $iQueIdx)
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

        if ($iQueIdx) {
            $result = $this->masterDB->table('iv_question')
                ->set([
                    'delyn' => 'Y'
                ])
                ->set(['que_mod_date' => 'NOW()'], '', false)
                ->set(['que_del_date' => 'NOW()'], '', false)
                ->where(['idx' => $iQueIdx, 'delyn' => 'N'])
                ->update();
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
