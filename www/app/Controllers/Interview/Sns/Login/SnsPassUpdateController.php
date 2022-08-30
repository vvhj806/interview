<?php

namespace App\Controllers\Interview\Sns\Login;

use CodeIgniter\I18n\Time;
use App\Controllers\Interview\WwwController;
use App\Libraries\EncryptLib;
use Config\Services;

class SnsPassUpdateController extends WwwController
{
    public function sns()
    {
        $this->commonData();

        return;

        date_default_timezone_set("Asia/Seoul");

        $conn = mysqli_connect("14.63.218.88", "rootInterview", "CoMcOm7878bUff", "new_interview", '11000') or die('error');
        mysqli_query($conn, "set names utf8;");

        // return;

        $encryptLib = new EncryptLib();
        $strPassword = $encryptLib->makePassword('1234');
        print_r($strPassword);
        echo '<br><br>';

        // 각각 sns 하나씩 돌리기(30초 지났다고 에러남)
        $sql = "SELECT *
                FROM iv_member_copy_hj
                WHERE (mem_id LIKE 'apple_%') AND (mem_password = '' OR mem_password IS NULL)";
        // WHERE (mem_id LIKE 'kakao_%' OR mem_id LIKE 'naver_%' OR mem_id LIKE 'google_%' OR mem_id LIKE 'apple_%') AND (mem_password = '' OR mem_password IS NULL)";
        $rst = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($rst)) {
            print_r($row['mem_id']);
            echo '<br>';
            print_r($row['mem_sns_object_sha']);
            echo '<br>';
            $strPassword = $encryptLib->makePassword($row['mem_sns_object_sha']);
            print_r($strPassword);
            echo '<br><br>';

            //UPDATE
            $sql2 = "UPDATE iv_member_copy_hj 
                    SET mem_password = '" . $strPassword . "'
                    WHERE mem_id = '" . $row['mem_id'] . "'
                    ";
            $rst2 = mysqli_query($conn, $sql2);
        }
    }
}
