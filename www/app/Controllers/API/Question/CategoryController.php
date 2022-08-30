<?php

namespace App\Controllers\API\Question;

use App\Controllers\API\APIController;
use Config\Services;

use App\Models\{
    JobCategoryModel
};

class CategoryController extends APIController
{
    private $aResponse = [];

    public function create(string $strDepthType)
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

        $jobCategoryModel = new JobCategoryModel();

        $flag = false;

        $iDepth1 = $this->request->getPost('depth1');
        $iDepth2 = $this->request->getPost('depth2');
        $strJobText = $this->request->getPost('jobText');
        $jobCategoryModel->where('delyn', 'N');

        if ($strDepthType === 'depth1') {
            $aDepth1 = $jobCategoryModel->select('max(job_depth_1) as max', '', false)->first();
            $readyQuery = $this->masterDB->table('iv_job_category')
                ->set([
                    'job_depth_1' => $aDepth1['max'] + 1
                ]);
            $flag = true;
        } else if ($strDepthType === 'depth2') {
            if ($iDepth1) {
                $aDepth2 = $jobCategoryModel->select('max(job_depth_2) as max', '', false)->where('job_depth_1', $iDepth1)->first();
                $readyQuery = $this->masterDB->table('iv_job_category')
                    ->set([
                        'job_depth_1' => $iDepth1,
                        'job_depth_2' => $aDepth2['max'] + 1
                    ]);
                $flag = true;
            }
        } else if ($strDepthType === 'depth3') {
            if ($iDepth1 && $iDepth2) {
                $aDepth3 = $jobCategoryModel->select('max(job_depth_3) as max', '', false)->where(['job_depth_1' => $iDepth1, 'job_depth_2' => $iDepth2])->first();
                $readyQuery = $this->masterDB->table('iv_job_category')
                    ->set([
                        'job_depth_1' => $iDepth1,
                        'job_depth_2' => $iDepth2,
                        'job_depth_3' => $aDepth3['max'] + 1
                    ]);
                $flag = true;
            }
        }

        if ($flag && $strJobText) {
            $result = $readyQuery
                ->set([
                    'job_depth_text' => $strJobText
                ])
                ->set(['job_reg_date' => 'NOW()'], '', false)
                ->set(['job_mod_date' => 'NOW()'], '', false)
                ->insert();

            if ($result) {
                cache()->delete("job.category");
                cache()->delete("admin.job.category");
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
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function update(int $iCategoryIdx)
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
        $strJobText = $this->request->getPost('jobText');
        if ($iCategoryIdx && $strJobText) {
            $readyQuery = $this->masterDB->table('iv_job_category')
                ->set(['delyn' => 'N', 'job_del_date' => null])
                ->set(['job_mod_date' => 'NOW()'], '', false);
            if ($strJobText) {
                $readyQuery->set(['job_depth_text' => $strJobText]);
            }
            $result = $readyQuery
                ->where(['idx' => $iCategoryIdx])->update();
            if ($result) {
                cache()->delete("job.category");
                cache()->delete("admin.job.category");
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
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $iCategoryIdx)
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

        if ($iCategoryIdx) {
            $jobCategoryModel = new JobCategoryModel();

            $aCategory = $jobCategoryModel
                ->select(['job_depth_1 as depth1', 'job_depth_2 as depth2', 'job_depth_3 as depth3'])
                ->where(['idx' => $iCategoryIdx, 'delyn' => 'N'])->first();

            $readyQuery = $this->masterDB->table('iv_job_category');

            if ($aCategory['depth1']) {
                $readyQuery->where('job_depth_1', $aCategory['depth1']);
                if ($aCategory['depth2']) {
                    $readyQuery->where('job_depth_2', $aCategory['depth2']);
                    if ($aCategory['depth3']) {
                        $readyQuery->where('job_depth_3', $aCategory['depth3']);
                    }
                }
            }

            $result = $readyQuery
                ->set([
                    'delyn' => 'Y'
                ])
                ->set(['job_mod_date' => 'NOW()'], '', false)
                ->set(['job_del_date' => 'NOW()'], '', false)
                ->where(['delyn' => 'N'])
                ->update();
            if ($result) {
                cache()->delete("job.category");
                cache()->delete("admin.job.category");
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
