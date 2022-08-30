<?php

namespace App\Controllers\API\Admin;

use App\Controllers\API\APIController;
use App\Models\MemberRecruitScrapModel;

use App\Models\{
    SetAdminMenuModel
};
use  App\Libraries\{
    GlobalvarLib
};
use App\Controllers\Admin\AdminController;

class MenuAddController extends APIController
{
    private $aResponse = [];

    public function modify()
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

        $this->commonData();

        $iMenuIdx = $this->request->getPost('menuIdx');
        $strMenuTxt = $this->request->getPost('menuTxt');
        $strMenuLink = $this->request->getPost('linkTxt');
        $iMenuPriority = $this->request->getPost('menuPriority');

        if (!$iMenuIdx || !$strMenuTxt) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        $result = $this->masterDB->table('set_admin_menu')
            ->set([
                'menu_depth_txt' => $strMenuTxt,
                'menu_link' => $strMenuLink,
                'menu_priority' => $iMenuPriority,
            ])
            ->where([
                'idx' => $iMenuIdx,
            ])
            ->set(['menu_mod_date' => 'NOW()'], '', false)
            ->update();

        if ($result) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash(),
                ],
                'messages' => '성공',
            ];
        } else {
            $this->aResponse = [
                'status'   => 500,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash(),
                ],
                'messages' => 'update 실패',
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete()
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

        $this->commonData();

        //model
        $SetAdminMenuModel = new SetAdminMenuModel();

        //post
        $iMenuIdx = $this->request->getPost('menuIdx');
        $strMenuDepth = $this->request->getPost('dstnc');

        if (!$iMenuIdx) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        if ($strMenuDepth == 'depth1') {
            $iDepth1 = $SetAdminMenuModel->getMenuDepth($iMenuIdx);

            $result = $this->masterDB->table('set_admin_menu')
                ->set([
                    'delyn' => 'Y',
                ])
                ->where([
                    'menu_depth_1' => $iDepth1['menu_depth_1'],
                ])
                ->set(['menu_del_date' => 'NOW()'], '', false)
                ->update();
        } else {
            $result = $this->masterDB->table('set_admin_menu')
                ->set([
                    'delyn' => 'Y',
                ])
                ->where([
                    'idx' => $iMenuIdx,
                ])
                ->set(['menu_del_date' => 'NOW()'], '', false)
                ->update();
        }

        if ($result) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash(),
                ],
                'messages' => '성공',
            ];
        } else {
            $this->aResponse = [
                'status'   => 500,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash(),
                ],
                'messages' => 'update 실패',
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
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

        $this->commonData();

        //model
        $SetAdminMenuModel = new SetAdminMenuModel();

        //post
        $iMenuIdx = $this->request->getPost('menuIdx') ?? '';
        $strMenuTxt = $this->request->getPost('menuTxt');
        $strDstnc = $this->request->getPost('dstnc');  //link, depth1, depth2

        if (!$strMenuTxt || !$strDstnc) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        if ($strDstnc == 'depth1') { //큰 메뉴 추가
            $iMenuDepth1 = $SetAdminMenuModel->maxDepthPriority('depth1');
            $iMenuPriority = $SetAdminMenuModel->maxDepthPriority('priority1');

            $result = $this->masterDB->table('set_admin_menu')
                ->set([
                    'menu_depth_txt' => $strMenuTxt,
                    'menu_depth_1' => $iMenuDepth1['maxDepth'] + 1,
                    'menu_priority' => $iMenuPriority['maxPriority'] + 1,
                    'delyn' => 'N'
                ])
                ->set(['menu_reg_date' => 'NOW()'], '', false)
                ->insert();
        } else { //세부 메뉴 추가
            $menuDepth1 = $SetAdminMenuModel->getMenuDepth($iMenuIdx);
            $menuDepth2 = $SetAdminMenuModel->maxDepthPriority('depth2', $menuDepth1['menu_depth_1']);
            $menuPriority2 = $SetAdminMenuModel->maxDepthPriority('priority2', $menuDepth1['menu_depth_1']);

            $result = $this->masterDB->table('set_admin_menu')
                ->set([
                    'menu_depth_txt' => $strMenuTxt,
                    'menu_depth_1' => $menuDepth1['menu_depth_1'],
                    'menu_depth_2' => $menuDepth2['maxDepth2'] + 1,
                    'menu_priority' => $menuPriority2['maxPriority2'] + 1,
                ])
                ->set(['menu_reg_date' => 'NOW()'], '', false)
                ->insert();
        }

        if ($result) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash(),
                ],
                'messages' => '성공',
            ];
        } else {
            $this->aResponse = [
                'status'   => 500,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash(),
                ],
                'messages' => 'update 실패',
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }
}
