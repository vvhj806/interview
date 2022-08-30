<?php

namespace App\Controllers\API\Applier\Upload\Thumb;

use App\Controllers\API\APIController;

use App\Models\ApplierModel;
use Config\Services;

class FileController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function create()
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

        $session = session();
        $iMemIdx = $this->request->getPost('memIdx');
        $iApplyIdx = $this->request->getPost('applyIdx');
        $strFileOrgName = $this->request->getPost('fileOrgName');
        $strFileSaveName = $this->request->getPost('fileSaveName');
        $strFileSize = $this->request->getPost('fileSize');
        $strFileType = $this->request->getPost('fileType');
        $strPostCase = $this->request->getPost('postCase');

        if (!$session->has('idx') || $session->get('idx') != $iMemIdx || $strPostCase != 'file_write' || !$strFileOrgName || !$strFileSaveName || !$strFileSize || !$strFileType || !$iApplyIdx) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }
        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_file')
            ->set([
                'file_type' => $strFileType,
                'file_org_name' => $strFileOrgName,
                'file_save_name' => $strFileSaveName,
                'file_size' => $strFileSize,
            ])
            ->set(['file_reg_date' => 'NOW()'], '', false)
            ->set(['file_mod_date' => 'NOW()'], '', false)
            ->insert();

        $fileIdx = $this->masterDB->insertID();

        $this->masterDB->table('iv_applier_profile')
            ->set([
                'app_idx' => $iApplyIdx,
                'mem_idx' => $iMemIdx,
                'file_idx' => $fileIdx,
            ])
            ->set(['app_pro_reg_date' => 'NOW()'], '', false)
            ->insert();


        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
        } else {
            $this->masterDB->transCommit();
        }

        // 트랜잭션 검사
        if ($this->masterDB->transStatus()) {
            //암호화
            $this->encrypter = Services::encrypter();

            $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($fileIdx)));

            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                'fileIdx' => $this->masterDB->insertID(),
                'EnfileIdx' => $encodeData,
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
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function mypageUpload()
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

        $session = session();
        $iMemIdx = $this->request->getPost('memIdx');
        $strFileOrgName = $this->request->getPost('fileOrgName');
        $strFileSaveName = $this->request->getPost('fileSaveName');
        $strFileSize = $this->request->getPost('fileSize');
        $strFileType = $this->request->getPost('fileType');
        $strPostCase = $this->request->getPost('postCase');

        if (!$session->has('idx') || $session->get('idx') != $iMemIdx || $strPostCase != 'file_write' || !$strFileOrgName || !$strFileSaveName || !$strFileSize || !$strFileType) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        $result = $this->masterDB->table('iv_file')
            ->set([
                'file_type' => $strFileType,
                'file_org_name' => $strFileOrgName,
                'file_save_name' => $strFileSaveName,
                'file_size' => $strFileSize,
            ])
            ->set(['file_reg_date' => 'NOW()'], '', false)
            ->set(['file_mod_date' => 'NOW()'], '', false)
            ->insert();

        $fileIdx = $this->masterDB->insertID();

        if ($result) {
            //암호화
            $this->encrypter = Services::encrypter();

            $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($fileIdx)));

            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                'fileIdx' => $this->masterDB->insertID(),
                'EnfileIdx' => $encodeData,
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
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function show($id = null)
    {
    }

    public function delete(int $idx)
    {
    }
}
