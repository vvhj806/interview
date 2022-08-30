<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class UniversityModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $code = 'iv_university';
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

    public function save($data): bool
    {
        if (is_array($data)) {
        }
        return parent::save($data);
    }

    public function getMajor(int $code)
    {
        $aMajor = [];

        if (!$code) {
            return $aMajor;
        }

        $aMajor = $this
            ->where([
                'uni_code' => $code,
                'delyn' => 'N'
            ])
            ->findAll();
        return $aMajor;
    }

    public function getUnicode(string $url)
    {
        $aCode = [];

        if (!$url) {
            return $aCode;
        }

        $aCode = $this
            ->select('uni_code')
            ->where([
                'uni_url' => $url,
                'delyn' => 'N'
            ])
            ->first();

        return $aCode['uni_code'];
    }

    public function getAllUniUrl()
    {
        $aUrl = [];

        $aUrl = $this
            ->select('uni_url')
            ->groupBy('uni_url')
            ->findAll();

        return $aUrl ?? [];
    }

    public function getUniType(int $code)
    {
        $aUrlType = [];

        if (!$code) {
            return $aUrlType;
        }
        $aUrlType = $this
            ->select('uni_type')
            ->where([
                'uni_code' => $code,
                'delyn' => 'N'
            ])
            ->first();

        return $aUrlType ?? [];
    }
}
