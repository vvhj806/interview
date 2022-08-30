<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}


/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Interview\MainController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// $routes->set404Override('App\Controllers\Interview\MainController::quick');
$routes->setAutoRoute(true);


//$routes->set404Override('App\Errors::show404');

// Will display a custom view
//$routes->set404Override(function()
//{
//    return redirect()->to('/');
//});

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */


// OAuth 2.0 이 필요할때 사용할것
// $routes->add('/oauth', 'Auth\AuthController::oAuth');
// $routes->group('/rest',  function ($routes) {
//     $routes->get('authorize', 'Rest\Authorization::authorize');
//     $routes->post('token', 'Rest\Authorization::token');
//     $routes->get('users', 'Rest\Users::getUsers');
// });


$routes->add('/link', 'Interview\MainController::link'); //임시
$routes->get('/test/{locale}', 'News::test');

// $routes->add('/snsupdate', 'Interview\Sns\Login\SnsPassUpdateController::sns'); //임시
// $routes->group('test', function ($routes) {
//     $routes->add('', 'News::index'); //임시
// });
$routes->get('storage/(:alpha)', 'Interview\File\ImageController::show/$1'); //이미지
$routes->add('lbquick', 'Admin\labeling\LabelingController::quick'); //라벨러 url

// interview
$routes->group('/', ['filter' => 'www-user'], function ($routes) {

    $routes->get('', 'Interview\MainController::main'); //메인

    $routes->group('short', function ($routes) {
        $routes->get('(:alphanum)', 'Both\ShortenUrlController::index/$1'); //단축uirl
    });

    $routes->get('yuhan', 'Interview\MainController::main'); //유한대학교
    $routes->get('seoil', 'Interview\MainController::main'); //서일대학교
    $routes->get('yongin', 'Interview\MainController::main'); //용인대학교
    $routes->get('bssm', 'Interview\MainController::main'); //부산소프트웨어마이스터고등학교
    $routes->get('chu', 'Interview\MainController::main'); //제주한라대학교
    $routes->get('osan', 'Interview\MainController::main'); //오산대학교
    $routes->get('gsm', 'Interview\MainController::main'); //광주소프트웨어고등학교
    $routes->get('ggm', 'Interview\MainController::main'); //경기게임마이스터고등학교
    $routes->get('busanedu', 'Interview\MainController::main'); //부산자동차고등학교
    $routes->get('cauai', 'Interview\MainController::main'); //w중앙대

    $routes->get('privacy', 'Interview\MainController::privacy'); //개인정보처리방침

    $routes->group('report', function ($routes) {
        $routes->add('/', 'Interview\Report\ReportController::index');
        $routes->add('detail2/(:any)', 'Interview\Report\ReportController::detail2/$1');
        $routes->add('detail/(:any)', 'Interview\Report\ReportController::detail/$1');
        $routes->add('print/(:any)', 'Interview\Report\ReportController::print/$1');
    });

    $routes->group('report', ['filter' => 'www-login'], function ($routes) {
        $routes->add('fail/(:any)', 'Interview\Report\ReportController::fail/$1');
        $routes->post('deleteAction', 'Interview\Report\ReportController::applierDeleteAction');
        $routes->post('updateAction', 'Interview\Report\ReportController::applierUpdateAction');
        $routes->group('comprehensive', function ($routes) {
            $routes->add('', 'Interview\Report\ReportController::applierShare');
            $routes->add('share', 'Interview\Report\ReportController::comprehensiveShare');
            $routes->Post('action/(:alpha)', 'Interview\Report\ReportController::applierShareAction/$1'); // comprehensive
        });
        $routes->group('share', function ($routes) {
            $routes->add('/', 'Interview\Report\ReportController::applierShare');
            // $routes->Post('action', 'Interview\Report\ReportController::applierShareAction');
            $routes->Post('action/(:alpha)', 'Interview\Report\ReportController::applierShareAction/$1'); // report
        });
        $routes->post('change', 'Interview\My\ChangeController::scroll');
    });

    $routes->group('help', function ($routes) {
        $routes->add('faq', 'Interview\Help\FaqController::list'); //faq
        $routes->group('qna', ['filter' => 'www-login'], function ($routes) {
            $routes->add('', 'Interview\Help\QnaController::list'); //qna list
            $routes->group('write', function ($routes) {
                $routes->add('', 'Interview\Help\QnaController::write'); //qna 글쓰기페이지
                $routes->post('action', 'Interview\Help\QnaController::writeAction'); //qna 글쓰기
            });
        });
        $routes->add('guide/interview', 'Interview\Help\GuideController::interview'); //guide
        $routes->add('guide/faq', 'Interview\Help\GuideController::faq'); //guide
        $routes->add('guide/sample', 'Interview\Help\GuideController::sampleInterview'); //guide
        // $routes->add('sample/list', 'Interview\Help\SampleController::list'); //샘플
    });

    $routes->group('jobs', function ($routes) {
        $routes->add('list', 'Interview\Jobs\JobsController::list'); //채용공고 리스트
        $routes->get('detail/(:num)', 'Interview\Jobs\JobsController::detail/$1'); //채용공고 디테일 (공고번호)
        $routes->post('detailAction', 'Interview\Jobs\JobsController::detailAction'); //인터뷰 디테일 내용 저장 페이지
        $routes->get('apply', 'Interview\Jobs\JobsController::apply', ['filter' => 'www-login']); //인터뷰 지원하기 (공고번호/내인터뷰지원인지,기업인터뷰지원인지)
        $routes->get('complete', 'Interview\Jobs\JobsController::complete', ['filter' => 'www-login']); //공고지원완료페이지
        $routes->post('jobApplyAction', 'Interview\Jobs\JobsController::jobApplyAction'); //공고지원완료 submit
        $routes->post('changeInterview', 'Interview\Jobs\JobsController::changeInterview'); //공고지원 (인터뷰변경 ajax)
        $routes->post('changeResume', 'Interview\Jobs\JobsController::changeResume'); //공고지원 (인터뷰변경 ajax)
        $routes->post('applyAtOnce', 'Interview\Jobs\JobsController::applyAtOnce'); //한번에 여러개 지원
    });
    $routes->group('search', function ($routes) {
        $routes->add('/', 'Interview\Search\SearchController::search'); //검색화면
        $routes->get('action', 'Interview\Search\SearchController::searchAction'); // 검색
        $routes->group('keyword', function ($routes) {
            $routes->get('', 'Interview\Search\SearchController::deleteKeyword'); //검색어 삭제
            $routes->get('delete/(:any)/(:any)', 'API\Search\SearchController::deleteKeyword/$1/$2');
        });
    });
    $routes->group('interview', function ($routes) {
        $routes->add('home', 'Interview\Interview\Guide\GuideController::homeGuideList'); //이용가이드
        $routes->add('preview/(:num)', 'Interview\Interview\InterviewController::preview/$1'); //실제 면접 질문 엿보기 디테일
        $routes->add('mock', 'Interview\Interview\InterviewController::mock'); //모의 인터뷰 응시하기
    });

    $routes->group('interview', ['filter' => 'www-temp-user'], function ($routes) {
        $routes->add('ready', 'Interview\Interview\InterviewController::ready'); //면접 시작 전 가이드
        $routes->add('type', 'Interview\Interview\InterviewController::type'); //면접 시작 전 카테고리 고르기
        $routes->post('typeAction', 'Interview\Interview\InterviewController::typeAction'); //면접 시작 전 카테고리 insert
        $routes->add('profile/(:num)/(:num)', 'Interview\Interview\InterviewController::profile/$1/$2'); //면접 시작 전 사진 찍는 방법 선택

        $routes->group('profile', function ($routes) {
            $routes->add('photo/(:num)/(:num)', 'Interview\Interview\InterviewController::photo/$1/$2'); //면접 시작 전 사진 찍기
            $routes->add('photo2/(:num)/(:num)', 'Interview\Interview\InterviewController::photo2/$1/$2'); //면접 시작 전 사진 찍기
            $routes->post('albumAction', 'Interview\Interview\InterviewController::albumAction'); // 면접 시작 전 앨범에서 사진 고르고 넘기기
            $routes->add('exist/(:num)/(:num)', 'Interview\Interview\InterviewController::exist/$1/$2'); //면접 시작 전 기존 프로필에서 고르기
        });

        $routes->add('mic/(:num)/(:num)', 'Interview\Interview\InterviewController::mic/$1/$2'); //면접 시작 전 음성인식
        $routes->post('skipMicAction', 'Interview\Interview\InterviewController::skipMicAction'); //면접 시작 전 음성인식 건너뛰기
        $routes->add('timer/(:num)/(:num)', 'Interview\Interview\InterviewController::timer/$1/$2'); //면접 시작 전 셀프 타이머 선택
        $routes->post('timerAction', 'Interview\Interview\InterviewController::timerAction'); //면접 시작 전 셀프 타이머 db update
        $routes->add('start/(:num)/(:num)', 'Interview\Interview\InterviewController::start/$1/$2'); //면접 시작
        $routes->add('end/(:num)/(:num)', 'Interview\Interview\InterviewController::end/$1/$2'); //면접 끝
    });

    $routes->group('my', ['filter' => 'www-login'], function ($routes) {
        $routes->get('scrap/(:alpha)', 'Interview\My\Scrap\ScrapListController::list/$1'); //스크랩(카트)

        $routes->add('leave', 'Interview\Member\MemberLeaveController::index'); //회원탈퇴
        $routes->add('leave/(:alphanum)', 'Interview\Member\MemberLeaveController::leave/$1'); //회원탈퇴
        $routes->post('leave/step2/action', 'Interview\Member\MemberLeaveController::memberLeaveAction');
        $routes->post('leave/password/action', 'Interview\Member\MemberLeaveController::memberLeavePwdCheckAction');

        $routes->add('perfit', 'Interview\My\Perfit\PerfitController::index'); //perfit한 기업

        $routes->group('suggest', ['filter' => 'www-login'], function ($routes) {
            $routes->add('/', 'Interview\My\Scrap\SuggestController::index'); //제안
            $routes->post('delete', 'Interview\My\Scrap\SuggestController::suggestDelete'); //제안 삭제 ()
            $routes->add('detail/(:any)', 'Interview\My\Scrap\SuggestController::detail/$1'); //제안
            $routes->post('accept/(:any)', 'Interview\My\Scrap\SuggestController::suggestAccept/$1'); //대면 인터뷰 제안 수락
            $routes->post('acceptInterview/(:any)', 'Interview\My\Scrap\SuggestController::suggestAcceptInterview/$1'); //인터뷰 제안 수락
            $routes->post('refuse/(:any)', 'Interview\My\Scrap\SuggestController::suggestRefuse/$1'); //제안 거절
        });

        // interview, 회원가입 관심사
        $routes->group('interest', function ($routes) {
            $routes->add('(:alpha)', 'Auth\AuthController::interest/$1');
            $routes->post('(:alpha)/action', 'Auth\AuthController::interestAction/$1');
        });

        // resume, 이력서
        $routes->add('resume', 'Interview\My\resume\ResumeController::resume');
        $routes->group('resume', function ($routes) {
            //$routes->add('modify', 'Interview\My\resume\ResumeController::resumeModify');
            $routes->add('modify/(:num)', 'Interview\My\resume\ResumeController::resumeModify/$1');
            $routes->add('modify/(:num)/(:alpha)', 'Interview\My\resume\ResumeController::resumeModify/$1/$2');
            $routes->post('modify/(:num)/subaction/(:alpha)', 'Interview\My\resume\ResumeController::resumeModifySubAction/$1/$2');
            $routes->get('modify/(:num)/subdelete', 'Interview\My\resume\ResumeController::resumeModifySubDelete/$1');
            $routes->get('modify/(:num)/subdelete/(:alpha)', 'Interview\My\resume\ResumeController::resumeModifySubDelete/$1/$2');
            $routes->post('modify/(:num)/saveaction', 'Interview\My\resume\ResumeController::resumeModifySave/$1');
            $routes->add('delete/(:num)', 'Interview\My\resume\ResumeController::resumeDelete/$1');
            $routes->add('profile/(:num)', 'Interview\My\resume\ResumeController::profile/$1');
            $routes->add('report/(:num)', 'Interview\My\resume\ResumeController::resumeReport/$1');
            $routes->post('jobportal', 'Interview\My\resume\ResumeController::resumeJobportal');
        });

        //메인페이지
        $routes->add('main', 'Interview\My\main\MypageController::main');
        $routes->add('modify', 'Interview\My\main\MypageController::modify');
        $routes->post('modifyAction', 'Interview\My\main\MypageController::modifyAction');
        $routes->add('profile', 'Interview\My\main\MypageController::profile');
        $routes->post('albumAction', 'Interview\My\main\MypageController::albumAction');
        $routes->add('exist', 'Interview\My\main\MypageController::exist');
        $routes->add('setting', 'Interview\My\main\MypageController::setting');
        $routes->group('setting', function ($routes) {
            $routes->add('push', 'Interview\My\main\MypageController::push');
        });
        $routes->add('resetPwd', 'Interview\My\main\MypageController::resetPwd');
        $routes->post('resetPwdAction', 'Interview\My\main\MypageController::resetAction');

        $routes->group('restrictions', function ($routes) {
            $routes->add('', 'Interview\My\main\MypageController::restrictionsList');
            $routes->add('search', 'Interview\My\main\MypageController::restrictionsSearch');
        });
        $routes->add('recently', 'Interview\My\main\MypageController::recentlyList');
        $routes->group('recently', function ($routes) {
            $routes->add('', 'Interview\My\main\MypageController::recentlyList');
            $routes->post('delete', 'Interview\My\main\MypageController::recentlyDelete');
        });
        $routes->group('recruit_info', function ($routes) {
            $routes->add('(:alpha)', 'Interview\My\recruit_info\RecruitInfoController::recruitInfoList/$1'); // completed OR again
            $routes->post('delete', 'Interview\My\recruit_info\RecruitInfoController::deleteAction');
            $routes->post('againAction', 'Interview\My\recruit_info\RecruitInfoController::againRequest');
        });

        $routes->group('alarm', function ($routes) { //알림
            $routes->add('', 'Interview\My\main\MypageController::alarm'); //   
            $routes->add('(:alpha)', 'Interview\My\main\MypageController::alarm/$1'); //
        });
    });

    $routes->group('board', function ($routes) {
        $routes->add('notice', 'Interview\Board\BoardController::noticeList'); //공지사항
        $routes->group('event', function ($routes) {
            $routes->get('', 'Interview\Board\BoardController::eventList'); //이벤트 리스트
            $routes->get('(:num)', 'Interview\Board\BoardController::eventDetail/$1'); //이벤트 디테일
        });
        $routes->group('rest', function ($routes) {
            $routes->add('', 'Interview\Board\BoardController::restList'); //쉬어가는 가벼운글 리스트
            $routes->get('detail/(:num)', 'Interview\Board\BoardController::restDetail/$1'); //쉬어가는 가벼운글 디테일
        });
    });

    $routes->group('company', function ($routes) {
        $routes->add('practice', 'Interview\Company\Practice\PracticeListController::list'); //모의면접
        $routes->get('tag', 'Interview\Company\Tag\TagListController::list'); // 태그별 기업        
        $routes->get('detail/(:num)', 'Interview\Company\CompanyController::detail/$1'); // 기업 상세
        $routes->get('explore', 'Interview\Company\CompanyController::explore');
    });

    $routes->group('sns', function ($routes) {
        $routes->add('(:alpha)/web/call', 'Interview\Sns\Login\CallActionController::web/$1'); //sns web 리다이렉트 페이지
        $routes->add('(:alpha)/app/call', 'Interview\Sns\Login\CallActionController::app/$1'); //sns app 리다이렉트 페이지

        $routes->add('(:alpha)/web/leave', 'Interview\Sns\Leave\SnsLeaveController::web/$1'); //sns web 탈퇴 리다이렉트 페이지 (본인확인)
        $routes->add('(:alpha)/web/leave/callback', 'Interview\Sns\Leave\SnsLeaveController::webLeave/$1'); //sns web 탈퇴 리다이렉트 페이지 (탈퇴)

        $routes->add('(:alpha)/app/leave', 'Interview\Sns\Leave\SnsLeaveController::app/$1'); //sns app 탈퇴 리다이렉트 페이지 (본인확인)
    });
});

//html 가이드
$routes->get('/html', 'HtmlGuideController::index'); //html 가이드 

// api
$routes->group('/api', ['filter' => 'throttle'], function ($routes) {
    $routes->group('auth', function ($routes) {
        $routes->post('tel', 'API\Auth\TelController::create');
        $routes->add('tel/(:any)/(:num)', 'API\Auth\TelController::inquire/$1/$2');

        $routes->post('tel/modify/(:any)/(:num)', 'API\Auth\TelController::inquireModify/$1/$2');
        $routes->post('find/(:alpha)/id', 'API\Auth\Find\FindController::findId/$1');
        $routes->post('find/(:alpha)/password', 'API\Auth\Find\FindController::findPassword/$1');
    });
    $routes->group('admin', function ($routes) {
        $routes->get('search/company', 'API\Admin\SearchCompanyController::list');
        $routes->post('menu/modify', 'API\Admin\MenuAddController::modify');
        $routes->post('menu/delete', 'API\Admin\MenuAddController::delete');
        $routes->post('menu/create', 'API\Admin\MenuAddController::create');
    });
    $routes->group('send', function ($routes) {
        $routes->post('message/(:alpha)', 'API\Send\MessageController::show/$1');
    });
    $routes->group('my', ['filter' => 'www-login'], function ($routes) {
        $routes->add('scrap/delete/(:alpha)/(:num)/(:num)', 'API\My\Scrap\ScrapController::delete/$1/$2/$3');
        $routes->add('scrap/add/(:alpha)/(:num)/(:num)', 'API\My\Scrap\ScrapController::create/$1/$2/$3');
        $routes->post('file/upload/thumb/mypage', 'API\Applier\Upload\Thumb\FileController::mypageUpload');
        $routes->post('push/alarm', 'API\My\Push\PushController::push');
        $routes->get('restrictions/add/(:num)/(:num)', 'API\My\restrictions\RestrictionsController::create/$1/$2'); // 제한기업 등록 memIdx, comidx
        $routes->get('restrictions/delete/(:num)/(:num)', 'API\My\restrictions\RestrictionsController::delete/$1/$2'); // 제한기업 해제.
    });
    $routes->group('applier', ['filter' => 'www-temp-user'], function ($routes) {
        $routes->post('file/upload/thumb/add', 'API\Applier\Upload\Thumb\FileController::create');
        $routes->post('mic/upload/check', 'API\Applier\Upload\Mic\MicController::check');
        $routes->post('file/upload/video', 'API\Applier\Upload\Interview\FileController::updateInterview');
        $routes->post('file/upload/navertts', 'API\Applier\Upload\Navertts\FileController::naverTTS');
    });
    $routes->group('recruit', function ($routes) {
        $routes->add('(:alpha)/apply/(:num)', 'API\Recruit\Apply\ApplyController::show/$1/$2');
    });
    $routes->group('interview', function ($routes) { //인터뷰
        $routes->group('', ['filter' => 'www-temp-user'], function ($routes) { //로그인 필터
            $routes->add('ready', 'API\Interview\SubmitController::submit');
            $routes->add('type', 'API\Interview\SubmitController::submit');
            $routes->post('create', 'API\Interview\InterviewController::create');
        });
        $routes->add('sample/list', 'API\Interview\SampleController::SampleInterview');
    });

    $routes->group('question', ['filter' => 'admin-main'], function ($routes) { //질문 crud
        $routes->post('create/(:num)', 'API\Question\QuestionController::create/$1');
        $routes->post('read/(:num)', 'API\Question\QuestionController::read/$1');
        $routes->post('delete/(:num)', 'API\Question\QuestionController::delete/$1');
        $routes->post('update/(:num)', 'API\Question\QuestionController::update/$1');
    });

    $routes->group('category', ['filter' => 'admin-main'], function ($routes) { // 카테고리 crud
        $routes->post('create/(:any)', 'API\Question\CategoryController::create/$1');
        $routes->post('update/(:num)', 'API\Question\CategoryController::update/$1');
        $routes->post('delete/(:num)', 'API\Question\CategoryController::delete/$1');
    });

    $routes->group('report', function ($routes) { //리포트 (라벨링)
        $routes->group('stt', function ($routes) { //STT
            $routes->post('update/(:num)', 'API\Report\ReportController::update/$1');
        });
    });

    $routes->group('search', function ($routes) {
        $routes->get('deleteKeyword(:any)', 'API\Search\SearchController::deleteKeyword/$1');
    });

    $routes->group('link', function ($routes) {
        $routes->post('requestAction', 'API\Link\AgainRequestController::request');
    });

    $routes->group('member', function ($routes) {
        $routes->post('nextMonth', 'API\Member\MemberController::nextMonth');
        $routes->get('read', 'API\Member\MemberController::read');
    });

    $routes->group('applier', function ($routes) {
        $routes->post('nextMonth', 'API\Member\MemberController::nextMonth');
        $routes->get('read', 'API\Applier\ApplierController::read');
    });

    $routes->group('recruit', function ($routes) {;
        $routes->get('read', 'API\Recruit\RecruitController::read');
    });
});

// api
$routes->group('/api', ['filter' => 'throttle-error'], function ($routes) {
    $routes->group('error', function ($routes) {
        $routes->post('page/(:alpha)/add', 'API\Error\Page\ErrorController::create/$1');
    });
});
//download
$routes->group('/', ['filter' => 'throttle'], function ($routes) {
    $routes->get('filedown', '\App\Models\File::download'); //다운로드
});
// interview, biz 로그아웃
$routes->group('/logout', function ($routes) {
    $routes->add('/', 'Auth\AuthController::logout');
});

// interview, biz 로그인 페이지
$routes->group('/login', function ($routes) {
    $routes->add('/', 'Auth\AuthController::login');
    $routes->post('action', 'Auth\AuthController::loginAction');
    $routes->add('sns/action/(:alpha)/(:any)', 'Auth\AuthController::snsLoginCheck/$1/$2');
    $routes->group('find', ['filter' => 'www-not-login'], function ($routes) {
        $routes->add('/', 'Auth\AuthController::find');
        $routes->add('(:alpha)/id', 'Auth\AuthController::findId/$1');
        $routes->add('(:alpha)/pwd', 'Auth\AuthController::findPwd/$1');
    });
    $routes->group('reset', function ($routes) {
        $routes->add('(:alpha)/pwd', 'Auth\AuthController::reset/$1');
        $routes->add('action', 'Auth\AuthController::resetAction');
    });
});
// interview, 회원가입페이지
$routes->group('/join', ['filter' => 'www-not-login'], function ($routes) {
    $routes->add('/', 'Auth\AuthController::join');
    $routes->get('sns', 'Auth\AuthController::snsJoin');
    $routes->post('action', 'Auth\AuthController::joinAction');
    $routes->post('sns/action/(:alpha)', 'Auth\AuthController::joinAction/$1');
});

// 링크 
$routes->group('linkInterview', function ($routes) {
    $routes->add('', 'Interview\Company\Urllink\LinkController::index');
    $routes->add('(:any)', 'Interview\Company\Urllink\LinkController::link/$1');
    $routes->post('linkAction', 'Interview\Company\Urllink\LinkController::linkAction');
    $routes->post('requestAction', 'Interview\Company\Urllink\LinkController::requestAction');
});

//1.5 링크 
$routes->group('company', function ($routes) {
    $routes->add('itv_view.php', 'Interview\Company\Urllink\LinkController::url_reload');
});

//1.5 getToken 링크
$routes->group('app', function ($routes) {
    $routes->post('get_token.php', 'API\Auth\TokenController::index');
});

// mou 학교 담당자 링크
$routes->group('linkSchool', function ($routes) {
    $routes->get('', 'Interview\Company\Urllink\LinkController::schoolLink');
});

$routes->group('jobs', function ($routes) {
    $routes->add('list', 'Interview\Jobs\JobsController::list'); //채용공고 리스트
    $routes->get('detail/(:num)', 'Interview\Jobs\JobsController::detail/$1'); //채용공고 디테일 (공고번호)
    $routes->post('detailAction', 'Interview\Jobs\JobsController::detailAction'); //인터뷰 디테일 내용 저장 페이지
    $routes->get('apply', 'Interview\Jobs\JobsController::apply', ['filter' => 'www-login']); //인터뷰 지원하기 (공고번호/내인터뷰지원인지,기업인터뷰지원인지)
    $routes->get('complete', 'Interview\Jobs\JobsController::complete', ['filter' => 'www-login']); //공고지원완료페이지
    $routes->post('jobApplyAction', 'Interview\Jobs\JobsController::jobApplyAction'); //공고지원완료 submit
    $routes->post('changeInterview', 'Interview\Jobs\JobsController::changeInterview'); //공고지원 (인터뷰변경 ajax)
    $routes->post('changeResume', 'Interview\Jobs\JobsController::changeResume'); //공고지원 (인터뷰변경 ajax)
    $routes->post('applyAtOnce', 'Interview\Jobs\JobsController::applyAtOnce'); //한번에 여러개 지원
});

// admin
$routes->group('/prime/login', ['filter' => 'admin-login'], function ($routes) {
    $routes->add('', 'Auth\AuthController::adminLogin');
    $routes->post('action', 'Auth\AuthController::adminLoginAction');
});

$routes->group('/prime', ['filter' => 'admin-main'], function ($routes) { // admin or labeler
    $routes->add('/', 'Auth\AuthController::adminMain');
    $routes->add('main', 'Admin\MainController::main');
    $routes->get('logout', 'Auth\AuthController::logout');

    $routes->group('', ['filter' => 'admin-only'], function ($routes) { // admin only
        //member
        $routes->group('member', function ($routes) {
            $routes->get('list/(:alpha)', 'Admin\Member\MemberListController::list/$1');
            $routes->add('write/(:alpha)', 'Admin\Member\MemberWriteController::write/$1');
            $routes->add('write/(:alpha)/(:num)', 'Admin\Member\MemberWriteController::write/$1/$2');
            $routes->post('write/action', 'Admin\Member\MemberActionController::memberAction');
            $routes->post('company/action', 'Admin\Member\MemberActionController::companyAction');
            $routes->post('delete/action', 'Admin\Member\MemberActionController::memberDeleteAction');
        });
        //recruit info 지원 관리
        $routes->group('recruit_info', function ($routes) {
            $routes->group('m', function ($routes) {
                $routes->get('list', 'Admin\RecruitInfo\RecruitInfoController::mList');
                $routes->get('detail/(:num)', 'Admin\RecruitInfo\RecruitInfoController::mDetail/$1');
                $routes->group('write', function ($routes) {
                    $routes->get('', 'Admin\RecruitInfo\RecruitInfoController::write');
                    $routes->post('action', 'Admin\RecruitInfo\RecruitInfoController::writeAction');
                });
            });

            $routes->group('c', function ($routes) {
                $routes->get('list', 'Admin\RecruitInfo\RecruitInfoController::cList');
                $routes->get('detail/(:num)', 'Admin\RecruitInfo\RecruitInfoController::cDetail/$1');
            });
        });
        //sugget 제안 관리
        $routes->group('suggest', function ($routes) {
            $routes->group('m', function ($routes) {
                $routes->get('list', 'Admin\Suggest\SuggestController::mList');
                $routes->add('write/(:alpha)/(:num)', 'Admin\Suggest\SuggestController::mWrite/$1/$2');
                $routes->post('action/(:alpha)/(:num)', 'Admin\Suggest\SuggestController::mAction/$1/$2');
                $routes->post('again/action/(:alpha)/(:num)', 'Admin\Suggest\SuggestController::mAgainAction/$1/$2');
            });
            $routes->group('c', function ($routes) {
                $routes->get('list', 'Admin\Suggest\SuggestController::cList');
                $routes->add('write/(:num)', 'Admin\Suggest\SuggestController::cWrite/$1'); //제안수정
                $routes->add('write', 'Admin\Suggest\SuggestController::cWrite'); //제안보내기
                $routes->post('action/(:num)', 'Admin\Suggest\SuggestController::cAction/$1');
                $routes->post('action', 'Admin\Suggest\SuggestController::cAction');
                $routes->post('again/action/(:alpha)', 'Admin\Suggest\SuggestController::cAgainAction/$1');
            });
        });
        //재응시 요청 관리
        $routes->group('again', function ($routes) {
            $routes->group('m', function ($routes) {
                $routes->get('list', 'Admin\Again\AgainController::mList');
                $routes->add('write/(:alpha)/(:num)', 'Admin\Again\AgainController::mWrite/$1/$2');
                // $routes->post('action/(:alpha)/(:num)', 'Admin\Again\AgainController::mAction/$1/$2');
            });
            $routes->group('c', function ($routes) {
                $routes->get('list', 'Admin\Again\AgainController::cList');
                $routes->add('write/(:num)', 'Admin\Again\AgainController::cWrite/$1');
                // $routes->post('action/(:num)', 'Admin\Again\AgainController::cAction/$1');
            });
        });
        //company기업 목록
        $routes->group('company', function ($routes) {
            $routes->get('list', 'Admin\Company\CompanyController::list');
            $routes->add('write', 'Admin\Company\CompanyController::write');
            $routes->add('write/(:num)', 'Admin\Company\CompanyController::write/$1');
            $routes->post('write/action', 'Admin\Company\CompanyController::create');
            $routes->post('write/(:num)/action', 'Admin\Company\CompanyController::action/$');
        });
        //recruit 공고 관리
        $routes->group('recruit', function ($routes) {
            $routes->get('list', 'Admin\Recruit\RecruitListController::list');
            $routes->add('write', 'Admin\Recruit\RecruitWriteController::write');
            $routes->add('write/(:num)', 'Admin\Recruit\RecruitWriteController::write/$1');
            $routes->post('accept', 'Admin\Recruit\RecruitActionController::accept');
            $routes->post('write/action', 'Admin\Recruit\RecruitActionController::write');
            $routes->post('write/(:num)/action', 'Admin\Recruit\RecruitActionController::update/$1');
        });
        //resume 이력서 관리
        $routes->group('resume', function ($routes) {
            $routes->get('list', 'Admin\Resume\ResumeController::resumeList');
            $routes->add('write/(:num)', 'Admin\Resume\ResumeController::write/$1'); //수정하기
        });
        //편리기능
        $routes->group('tool', function ($routes) {
            $routes->group('search', function ($routes) { //추천검색어
                $routes->get('list', 'Admin\Search\SearchController::list');
                $routes->post('write', 'Admin\Search\SearchController::write');
                $routes->post('update', 'Admin\Search\SearchController::update');
                $routes->post('delete', 'Admin\Search\SearchController::delete');
            });
            $routes->group('decrypt', function ($routes) { //추천검색어
                $routes->get('', 'Admin\Tool\ToolController::decrypt');
            });
        });
        //interview 관리
        $routes->group('interview', function ($routes) {
            $routes->group('view', function ($routes) {
                $routes->add('', 'Admin\Interview\InterviewController::viewList');
                $routes->add('detail/(:num)', 'Admin\Interview\InterviewController::viewDetail/$1');
                $routes->add('detail2/(:any)', 'Interview\Report\ReportController::detail/$1');
                $routes->add('print/(:any)', 'Interview\Report\ReportController::print/$1');
            });

            $routes->group('comprehensive', function ($routes) {
                $routes->add('', 'Admin\Interview\InterviewController::comprehensiveList');
                $routes->add('detail/(:num)', 'Admin\Interview\InterviewController::comprehensiveDetail/$1');
            });

            $routes->add('question', 'Admin\Interview\InterviewController::question');

            $routes->group('mock', function ($routes) {
                $routes->add('', 'Admin\Interview\InterviewController::mock');
                $routes->add('write', 'Admin\Interview\InterviewController::mockWrite');
            });

            $routes->group('sample', function ($routes) {
                $routes->add('', 'Admin\Interview\InterviewController::sample');
                $routes->post('/action', 'Admin\Interview\InterviewController::sampleAction');
            });
        });
        //config
        $routes->group('config', function ($routes) {
            //add rull
            // $routes->addPlaceholder('customConfig', '\bterms\b|\bagreement\b|\bprivate\b');
            // $routes->add('write/(:customConfig)', 'Admin\Config\ConfigWriteController::configWrite/$1');
            // $routes->add('write/action', 'Admin\Config\ConfigActionController::configAction');
            $routes->add('permission', 'Admin\Config\PermissionController::main');
            $routes->post('permission/action', 'Admin\Config\PermissionController::menuSaveAction');
            $routes->add('settings', 'Admin\Config\ConfigWriteController::configSettings');
            $routes->post('settings/action', 'Admin\Config\ConfigActionController::configAction');
            $routes->add('menu', 'Admin\Config\MenuController::main');
            $routes->add('push', 'Admin\Config\PushController::push');
            $routes->add('push/action', 'Admin\Config\PushController::sendPush');
            $routes->add('idauth', 'Admin\Config\PermissionController::authPermission');
            $routes->post('idauth/action', 'Admin\Config\PermissionController::authPermissionSaveAction');
        });
        //qna
        $routes->group('qna', function ($routes) {
            $routes->get('list', 'Admin\Qna\QnaListController::list');
            $routes->get('write/(:num)', 'Admin\Qna\QnaWriteController::write/$1');
            $routes->post('write/action', 'Admin\Qna\QnaActionController::qnaAction');
        });
        //faq
        $routes->group('faq', function ($routes) {
            $routes->get('list', 'Admin\Faq\FaqListController::list');
            $routes->post('write/action', 'Admin\Faq\FaqActionController::writeAction');
            $routes->post('del', 'Admin\Faq\FaqActionController::faqDel');
        });
        //board
        $routes->group('board', function ($routes) {
            //add rull
            $routes->addPlaceholder('customNumWord', '[0-9]|\ball\b'); //숫자,all
            //게시판설정 리스트
            //write
            $routes->get('(:alpha)/write', 'Admin\Board\BoardWriteController::index/$1');
            $routes->get('(:alpha)/write/(:num)', 'Admin\Board\BoardWriteController::index/$1/$2');
            //action
            $routes->post('(:alpha)/write/action', 'Admin\Board\BoardActionController::index/$1');
            $routes->post('(:alpha)/comment/action', 'Admin\Board\BoardActionController::commentAction/$1');
            $routes->add('(:alpha)/comment/del/(:num)', 'Admin\Board\BoardActionController::commentDel/$1/$2');
            //게시판 list
            $routes->get('list', 'Admin\Board\BoardListController::list');
            $routes->get('list/(:alpha)', 'Admin\Board\BoardListController::list/$1');
            $routes->get('set/list', 'Admin\Board\BoardListController::setList');
            //read
            $routes->get('read/(:any)', 'Admin\Board\BoardReadController::read/$1');
            //read
            $routes->get('(:alpha)/read/(:num)', 'Admin\Board\BoardReadController::read/$1/$2');
        });
    });

    //라벨링
    $routes->group('labeling', function ($routes) {
        $routes->group('list', function ($routes) {
            $routes->get('', 'Admin\labeling\LabelingController::list');
            $routes->post('action', 'Admin\labeling\LabelingController::statAction');
            // $routes->get('asd', 'Admin\labeling\LabelingController::asd');
            // $routes->get('asd2', 'Admin\labeling\LabelingController::asd2');
            // $routes->post('des', 'Admin\labeling\LabelingController::des');
        });
        $routes->group('detail', function ($routes) {
            $routes->get('(:num)', 'Admin\labeling\LabelingController::detail/$1');
            $routes->post('action/(:num)', 'Admin\labeling\LabelingController::detailAction/$1');
        });
        $routes->get('score/(:num)', 'Admin\labeling\LabelingController::score/$1');
        $routes->post('action/(:num)', 'Admin\labeling\LabelingController::scoreAction/$1');
    });

    //인터뷰 사전 추가 기능
    $routes->group('setinterview', function ($routes) {
        $routes->group('interactive', function ($routes) {
            $routes->get('', 'Admin\SetInterview\SetInterviewController::interactiveList');
            $routes->post('delete/action', 'Admin\SetInterview\SetInterviewController::interactiveDeleteAction');
            $routes->post('excel/action', 'Admin\SetInterview\SetInterviewController::interactiveExcelAction');
        });

        $routes->group('spell', function ($routes) {
            $routes->get('', 'Admin\SetInterview\SetInterviewController::spellList');
        });

        $routes->group('stt', function ($routes) {
            $routes->get('', 'Admin\SetInterview\SetInterviewController::sttList');
            $routes->post('insert/action', 'Admin\SetInterview\SetInterviewController::phraseInsertAction');
            $routes->post('delete/action', 'Admin\SetInterview\SetInterviewController::phraseDeleteAction');
        });
    });
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
