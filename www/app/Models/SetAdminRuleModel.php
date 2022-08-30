<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;
use PDO;
use Config\Database;

class SetAdminRuleModel extends Model
{
    private $backUrlList = '/prime/config/permission';
    public $masterDB;
    public function __construct()
    {
        parent::__construct();
        $code = 'set_admin_rule';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        $this->masterDB = Database::connect('master');
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                }
            }
        }
    }

    public function getRule($type = '', $level = '')
    {
        $result = $this
            ->where([
                'delyn' => 'N',
                'type !='=>'A',
            ]);

        if ($type && $level) {
            $result = $result->where([
                'type' => $type,
                'level' => $level,
            ]);
        }

        $result = $result->findAll();

        return $result ?? [];
    }

    public function updateRule($type, $level, $menuIdx, $name): bool
    {
        if (!$type || !$level || !$name) {
            return false;
        }
    
        $result =  $this->masterDB->table('set_admin_rule')
            ->set([
                'menu_idx' => $menuIdx,
                'type' => $type,
                'level' => $level,
                'type_name' => $name
            ])
            ->where([
                'type' => $type,
                'level' => $level,
            ]);


        $aRow = $this
            ->where([
                'type' => $type,
                'level' => $level
            ])
            ->first();

        if ($aRow) {
            $result = $result
                ->set(['rule_mod_date' => 'NOW()'], '', false)
                ->update();
        } else {
            $result = $result
                ->set(['rule_reg_date' => 'NOW()'], '', false)
                ->insert();
        }

        return $result;
    }
}
