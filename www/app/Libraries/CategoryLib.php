<?php

namespace App\Libraries;

use App\Models\{
    JobCategoryModel,
};

class CategoryLib
{
    public $aCategory;
    private $aJobIdx; //질문 없는 카테고리 idx
    public function __construct()
    {
        $jobCategoryModel = new JobCategoryModel();
        if (!$this->aCategory = cache("job.category")) {
            $this->aCategory = $jobCategoryModel->getJobCategory('admin');
            cache()->save("job.category", $this->aCategory, 86400);
        }
        $this->aJobIdx = [
            314, 247, 362, 223, 190, 315, 250, 374, 224, 191, 318, 251, 423, 225,
            192, 319, 253, 434, 226, 193, 320, 254, 435, 236, 194, 321, 264, 436, 237,
            200, 331, 291, 438, 238, 201, 332, 292, 439, 239, 202, 346, 307, 440, 240,
            204, 347, 308, 442, 241, 206, 348, 309, 443, 242, 210, 349, 310, 444, 243,
            211, 351, 311, 445, 245, 215, 354, 312, 246, 222, 361, 313,
        ];
    }

    // aParams ex 
    // ['option' =>  'only' || 'mutl']  //*필수
    // ['pageType' => 'left' || 'right' || 'search'] //선택
    // ['checked' => ''] jobidx를 담은 배열 //선택
    // view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'muti']) 

    public function jobCategory(array $aParams = [])
    {
        $aJobsCategory = [];
        foreach ($this->aCategory as $val) {
            if (!$val['job_depth_2']) {
                $aJobsCategory['job_depth_1'][$val['job_depth_1']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx'], 'count' => 0];
            } else if (!$val['job_depth_3']) {
                $aJobsCategory['job_depth_2'][$val['job_depth_1']][$val['job_depth_2']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx'], 'count' => 0];
                ++$aJobsCategory['job_depth_1'][$val['job_depth_1']]['count'];
            } else {
                if (in_array($val['idx'], $this->aJobIdx)) {
                    continue;
                }
                $aJobsCategory['job_depth_3'][$val['job_depth_1']][$val['job_depth_2']][$val['job_depth_3']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx']];
                ++$aJobsCategory['job_depth_2'][$val['job_depth_1']][$val['job_depth_2']]['count'];
            }
        }

        foreach ($aJobsCategory['job_depth_2'] as $key => $val) {
            foreach ($val as $key2 => $val2) {
                if ($val2['count'] === 0) {
                    unset($aJobsCategory['job_depth_2'][$key][$key2]);
                    --$aJobsCategory['job_depth_1'][$key]['count'];

                    if ($aJobsCategory['job_depth_1'][$key]['count'] === 0) {
                        unset($aJobsCategory['job_depth_1'][$key]);
                    }
                }
            }
        }

        $aData['data'] = [
            'job' => $aJobsCategory,
            'option' => $aParams['option'],
            'pageType' => $aParams['pageType'] ?? '',
            'checked' =>  $aParams['checked'] ?? []
        ];
        return view("www/templates/category", $aData);
    }

    public function jobSearch()
    {
        $aJobsCategory = [];
        $aOriginalCategory = [];
        foreach ($this->aCategory as $val) {
            if (!$val['job_depth_2']) {
                $aJobsCategory['job_depth_1'][$val['job_depth_1']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx']];
            } else if (!$val['job_depth_3']) {
                $aJobsCategory['job_depth_2'][$val['job_depth_1']][$val['job_depth_2']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx']];
            } else {
                if (in_array($val['idx'], $this->aJobIdx)) {
                    continue;
                }
                $aJobsCategory['job_depth_3'][$val['job_depth_1']][$val['job_depth_2']][$val['job_depth_3']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx']];
            }
            $aOriginalCategory[$val['idx']] = $val;
        }

        $aData['data'] = ['original' => $aOriginalCategory, 'job' => $aJobsCategory];
        return view("www/templates/categorySearch", $aData);
    }
}
