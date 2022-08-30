<?php

namespace App\Controllers\API\Search;

use App\Controllers\API\APIController;
use App\Libraries\ShortUrlLib;
use Config\Services;

class SearchController extends APIController
{
    private $aResponse = [];

    public function deleteKeyword(string $type, string $keyword)
    {
        helper('cookie');
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => [
                    'stat' => 'fail',
                ],
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }

        $cookie = get_cookie('keyword');

        if ($cookie && $keyword) {
            $aCookie = json_decode($cookie);

            if (count($aCookie) === 1 || $type === 'all') {
                setcookie('keyword', '', time() - 1, '/');
                $this->aResponse = [
                    'status'   => 201,
                    'code'     => [
                        'stat' => 'success',
                    ]
                ];
            } else if ($type === 'one') {

                foreach ($aCookie as $val) {
                    if ($val == $keyword) {
                        continue;
                    }
                    $aList[] = $val;
                }
                $aList = json_encode($aList);
                setcookie('keyword', $aList, time() + 2592000, '/');
                $cookie = get_cookie('keyword');

                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success'
                    ]
                ];
            }
        } else {
            $this->aResponse = [
                'status'   => 400,
                'code'     => [
                    'stat' => $cookie,
                    'a' => $type,
                    'dd' => $keyword,
                ],
                'messages' => $this->globalvar->aApiMsg['error20'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }
}
