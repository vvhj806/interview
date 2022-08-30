<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class SetAdminMenuModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $code = 'set_admin_menu';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                }
            }
        }
    }

    public function getMenu() //전체 메뉴 가져오기
    {
        $aMenu = [];
        $result = $this
            ->where([
                'menu_depth_2' => NULL,
                'delyn' => 'N',
            ])
            ->orderBy('menu_priority', 'ASC')
            ->findAll();
        for ($i = 0, $max = count($result); $i < $max; $i++) {
            $aRow = $this->select('*')
                ->where([
                    'menu_depth_1' => $result[$i]['menu_depth_1'],
                    'delyn' => 'N',
                    'menu_depth_2 is not' => null,
                ])
                ->orderBy('menu_priority', 'ASC')
                ->findAll();
            array_unshift($aRow, $result[$i]);
            $aMenu[] = $aRow;
        }
        return $aMenu ?? [];
    }

    public function getMemMenu(array $menuIdxs) //type과 level 에 맞는 큰 카테고리 가져오기
    {
        $aResult = [];
        if (!$menuIdxs) {
            return [];
        }

        $aRow = $this
            ->select('menu_depth_1')
            ->whereIn('idx', $menuIdxs)
            ->where([
                'delyn' => 'N',
            ])
            ->groupBy('menu_depth_1')
            ->findAll();

        foreach ($aRow as $val) {
            $aRow2 = $this
                ->select('idx')
                ->where([
                    'menu_depth_1' => $val['menu_depth_1'],
                    'delyn' => 'N',
                    'menu_depth_2' => null,
                ])
                ->first();
            $aResult[] = $aRow2['idx'];
        }

        return $aResult ?? [];
    }

    public function getMenuDepth(int $idx)
    {
        if (!$idx) {
            return [];
        }

        $result = $this
            ->select('menu_depth_1')
            ->where([
                'idx' => $idx,
                'delyn' => 'N'
            ])
            ->first();

        return $result ?? [];
    }

    public function maxDepthPriority(string $DP, int $menuDepth1 = null)
    {

        if (!$DP) {
            return false;
        }

        if ($DP == 'depth1') {
            $result = $this->select('max(menu_depth_1) as maxDepth ')->first();
        } else if ($DP == 'priority1') {
            $result = $this->select('max(menu_priority) as maxPriority')->where('menu_depth_2', null)->first();
        } else if ($DP == 'depth2') {
            $result = $this->select('max(menu_depth_2) as maxDepth2')->where(['menu_depth_1' => $menuDepth1, 'menu_depth_2 is not' => null])->first();
        } else if ($DP == 'priority2') {
            $result = $this->select('max(menu_priority) as maxPriority2')->where(['menu_depth_1' => $menuDepth1, 'menu_depth_2 is not' => null])->first();
        }

        return $result ?? [];
    }
}
