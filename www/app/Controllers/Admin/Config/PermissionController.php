<?php

namespace App\Controllers\Admin\Config;

use App\Models\{
    SetAdminRuleModel,
    SetAdminMenuModel,
    MemberModel,
};
use App\Controllers\Admin\AdminController;

class PermissionController extends AdminController
{
    private $backUrlList = '/prime/config/permission';

    public function index()
    {
        alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        exit;
    }

    public function main()
    {
        // data init
        $this->commonData();

        //model
        $SetAdminRuleModel = new SetAdminRuleModel();
        $SetAdminMenuModel = new SetAdminMenuModel();

        //get
        $getType = $this->request->getGet('typeSelect');
        $getLevel = $this->request->getGet('levelSelect');
        $getAllRule = $SetAdminRuleModel->getRule();
        $aMenuList = $SetAdminMenuModel->getMenu();

        if (($getType && $getLevel) || ($getType && $getLevel == 0)) {
            $getRule = $SetAdminRuleModel->getRule($getType, $getLevel);

            foreach ($getRule as $key => $val) {
                if ($val['menu_idx']) {
                    $aGetMenuIdxs = explode(',', $val['menu_idx']);
                    $getRule[$key]['menu_idx'] = $aGetMenuIdxs;
                }
            }
        }

        // view
        $this->aData['data']['permissionList'] = $getAllRule; //rule
        $this->aData['data']['getRule'] = $getRule ?? []; //rule
        $this->aData['data']['getMenuIdxs'] = $aGetMenuIdxs ?? []; //선택된 메뉴 idx 배열
        $this->aData['data']['menuList'] = $aMenuList; //menu
        $this->aData['data']['getType'] = $getType;
        $this->aData['data']['getLevel'] = $getLevel;

        $this->header();
        $this->nav();
        echo view('prime/config/permission', $this->aData);
        $this->footer();
    }

    public function menuSaveAction()
    {
        $getMenuIdxs = $this->request->getPost('menuIdxs');
        $permissionType = $this->request->getPost('permissionType');
        $permissionLevel = $this->request->getPost('permissionLevel');
        $permissionName = $this->request->getPost('permissionName');

        if (!$permissionType || !$permissionLevel || !$permissionName) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $SetAdminRuleModel = new SetAdminRuleModel();

        $result = $SetAdminRuleModel->updateRule($permissionType, $permissionLevel, $getMenuIdxs, $permissionName);

        if ($result) {
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        } else {
            alert_url($this->globalvar->aMsg['error2'], $this->backUrlList);
            exit;
        }
    }

    public function authPermission()
    {
        // data init
        $this->commonData();

        //get
        $getSearchText = $this->request->getGet('searchText') ?? '';

        //model
        $MemberModel = new MemberModel();

        $getMemberInfo = $MemberModel->getMemberAuthInfo($getSearchText);

        // view
        $this->aData['data']['getMemberInfo'] = $getMemberInfo; //검색된 멤버 정보
        $this->aData['data']['getSearchText'] = $getSearchText; //검색한 단어


        $this->header();
        $this->nav();
        echo view('prime/config/authPermission', $this->aData);
        $this->footer();
    }

    public function authPermissionSaveAction() //선택된 아이디에 type이랑 level update
    {
        //post
        $getMemIdxAuth = $this->request->getPost('memIdxAuth');
        if (!$getMemIdxAuth) {
            alert_url($this->globalvar->aMsg['error1'], '/prime/config/idauth');
            exit;
        }

        //model
        $MemberModel = new MemberModel();

        $getMemIdxAuth = json_decode($getMemIdxAuth[0], true);
        $result = $MemberModel->updateMemberAuth($getMemIdxAuth);

        if ($result) {
            alert_url($this->globalvar->aMsg['success1'], '/prime/config/idauth');
            exit;
        } else {
            alert_url($this->globalvar->aMsg['error2'], '/prime/config/idauth');
            exit;
        }
    }
}
