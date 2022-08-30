<?php

namespace App\Controllers\API\My\alarm;

use App\Controllers\API\APIController;

use App\Models\AlarmModel;
use Config\Services;
use App\Libraries\GlobalvarLib;
use App\Libraries\SendLib;

class AlarmController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function push()
    {

        // helper('file');
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error3'],
            ], 403);
        }
        $session = session();
        $memIdx = $session->get('idx');





        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $idx)
    {
    }
}
