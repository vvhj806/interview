<?php

namespace App\Libraries;

class GlobalvarLib
{
    private $login = ''; // 로그인
    private $main = ''; // 메인
    private $wwwUrl = ''; // www url
    private $shortUrl = ''; // sort url
    private $menuUrl = ''; // menu url
    private $mediaUrl = ''; //media url
    private $mediaPort = ''; //media port
    private $videoPath = ''; //video 업로드 경로
    private $thumbPath = ''; //thumb 업로드 경로
    private $ttsPath = ''; //tts 가져오는 경로

    private $serverHost = ''; // serverHost
    private $aDevIp = []; // 개발자 아이피
    public $aMemberLeave = []; //탈퇴사유

    //admin
    private $adminLogin = ''; // admin 로그인
    private $adminMain = ''; // admin 메인
    private $smsAPIKey = ''; // sms api키
    private $comRegAPIKey = ''; // 사업자등록조회 api키

    private $emailFromMail = '';
    private $emailFromName = '';

    //sns
    public $aSnsInfo = []; //sns 정보

    //msg
    public $aMsg = [];
    // '근무(,중복) 월:0,화:1...일:6,평일:8,주말:9',
    // '고용형태(,중복) 정규직:0,계약직:1,인턴직:2,아르바이트:3,해외취업:4',
    // '학력 고졸이하:1,고등학교:2,대학(2,3년제):3,대학교(4년제):4,석사:5,박사:6,박사이상:7,무관:0',
    // config
    // private $aConfig = [];
    public function __construct()
    {
        // webtest 연결 테스트 2
        //controller 사용
        $this->login = '\App\Controllers\Auth\AuthController::login';
        $this->main = '\App\Controllers\Interview\MainController::main';
        $this->adminLogin = '\App\Controllers\Auth\AuthController::adminLogin';
        $this->adminMain = '\App\Controllers\Admin\MainController::main';
        $this->aDevIp = ['121.174.144.33', '61.75.117.195'];
        $this->aMsg = [
            'success1' => '저장하였습니다.',
            'success2' => '삭제하였습니다.',
            'success3' => '가입이 완료되었습니다.',
            'success4' => '변경을 완료하였습니다.',
            'success5' => '요청을 완료하였습니다.',
            'error1' => '잘못된 접근입니다.',
            'error2' => '문제가 발생하였습니다.',
            'error3' => '일시적인 오류입니다. 다시 시도해 주세요.',
            'error4' => '아이디와 패스워드를 확인해주세요.',
            'error5' => '이미 사용중인 아이디입니다.',
            'error6' => '변경한 이력이 있습니다.',
            'error7' => '같은 비밀번호로는 변경이 불가능합니다.',
            'error8' => '인증시간이 초과하였습니다.',
            'error9' => '현재 로그인 중입니다.',
            'error10' => '검색어를 입력해 주세요.',
            'error11' => '로그인이 필요한 서비스 입니다.',
            'error12' => '기간이 만료되었습니다.',
            'error13' => '잘못된 요청 입니다.',
            'error14' => '인터뷰가 존재하지 않습니다.',
            'error15' => '로그인에 실패하였습니다.',
            'error16' => '보유한 인터뷰가 없습니다.',
            'error17' => '가입후 이용해 주세요.',
            'error18' => '마스터 계정으로 접근해 주세요.',
            'error19' => '지원가능횟수가 초과된 공고가 포함되어 있습니다.',
            'error20' => '탈퇴가 정상적으로 이루어지지 않았습니다.',
            'error21' => '로그인 실패를 5번 이상하였습니다. 5분 뒤에 다시 시도해주세요.',
            'error22' => '중복 로그인으로 자동 로그아웃 되었습니다. 다시 로그인해주세요.',
            'error23' => '탈퇴한 회원입니다.',
            'error24' => '분석불가한 인터뷰입니다.',
            'error25' => 'SNS 연동해제가 정상적으로 이루어지지 않았습니다.',
        ];

        $this->aApiMsg = [
            'success1' => '저장하였습니다.',
            'success2' => '완료되었습니다.',
            'success3' => '음성 인식이 완료되었습니다.',
            'success4' => '문자메세지를 요청하였습니다.',
            'success5' => '인증되었습니다.',
            'success6' => '조회하였습니다.',
            'success7' => '이메일을 전송하였습니다.',
            'success8' => '차단하였습니다.',
            'success9' => '차단 해제 되었습니다.',
            'success10' => '삭제하였습니다.',
            'success11' => '해당하는 데이터가 없습니다.',
            'success12' => '텔레그램으로 메세지를 보냈습니다.',
            'error1' => '헤더 값 형식이 올바른지 확인하세요.',
            'error2' => '잘못된 접근입니다.',
            'error3' => '서버에 내부 오류가 발생했습니다. 요청을 다시 시도하세요.',
            'error4' => '음성 인식을 실패하였습니다.',
            'error5' => '좀 더 큰 목소리로 읽어주세요.',
            'error6' => '파일 변환을 실패하였습니다.',
            'error7' => '_tts 파일이 존재합니다.',
            'error8' => '_tts 파일 생성을 실패했습니다.',
            'error9' => '이미 가입된 번호입니다.',
            'error10' => '쓰기 작업은 허용되지 않습니다.',
            'error11' => '3분이내 동일한 번호로 3번 요청하였습니다.',
            'error12' => '인증번호를 확인해주세요.',
            'error13' => '인증시간을 초과하였습니다.',
            'error14' => '아이디와 핸드폰 정보를 다시 확인해 주세요.',
            'error15' => '이메일 전송에 실패하였습니다.',
            'error16' => '5분동안 한번만 요청 가능합니다.',
            'error17' => '데이터를 찾을수 없습니다.',
            'error18' => '마지막 샘플 인터뷰입니다.',
            'error19' => '이미 차단된 기업입니다.',
            'error20' => '키워드가 없습니다.',
            'error21' => '탈퇴한 회원입니다.',
        ];
        /**
         * error3 401 : 트랜젝션 에러, 롤백진행한경우
         */

        $this->aMemberLeave = [
            '0' => '하이버프로 직장을 구했어요.',
            '1' => '다른 서비스로 직장을 구했어요.',
            '2' => '채용공고가 부족해요.',
            '3' => '잘못된 접근입니다.',
            '4' => '앱 오류가 잦아요.',
            // '5' => '기타 (직접 입력).',
        ];
        //config
        $this->aConfig = [
            'recruit' => [
                'work_day' => ['일', '월', '화', '수', '목', '금', '토'],
                'work_type' => ['정규직', '계약직', '인턴직', '아르바이트', '해외취업'],
                'education' => ['무관', '고졸이하', '고등학교', '대학(2,3년제)', '대학교(4년제)', '석사', '박사', '박사이상'],

            ],
            'company' => [
                'company_form' => ['공기업', '대기업', '중견기업', '중소/스타트업'],
                'company_group' => ['IT컨텐츠', '판매, 유통', '제조', '기타 서비스업', '금융', '교육', '전문, 과학기술', '예술, 스포츠, 여가', ' 물류, 운송', '부동산', '건설', '사업지원', '숙박, 음식점', '보건, 사회복지', '농림어업', '전기, 가스', '광업', '상수도, 환경', '가사, 가정', '공공행정 국방', '국제 외국기관']
            ]
        ];

        //sns 로그인
        // 구글, 카카오, 네이버별 각 client _id, client_secret, redirect_uri 상수 설정
        // 하정님이 통합관리
        //GOOGLE 21.06.03 완료
        // 오픈 전 realinterviewr => interview 로 변경해야함
        $this->aSnsInfo = [
            'google' => [
                // 'clientId' => '265440924719-5a242gqtatmolvgino9l4vtr7jpnnq2u.apps.googleusercontent.com',
                'clientId' => '485316476575-4ocd3pbjtm27vgn7uma0u21b9lr054ig.apps.googleusercontent.com',
                // 'clientSecret' => 'lXPgmBWQO3QUuLcoddTK9ifp',
                'clientSecret' => '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',
                'redirectUrl' => 'https://interview.highbuff.com/sns/google/web/call',
            ],
            //KAKAO 21.06.02 완료
            'kakao' => [
                'clientId' => 'c622851e95a98fbe13ba6a94d0598a5b',
                'clientSecret' => '',
                'redirectUrl' => 'https://interview.highbuff.com/sns/kakao/web/call',
            ],
            //NAVER 21.06.03 완료
            'naver' => [
                'clientId' => 'xgw7omXoMTrWdMLU9cw2',
                'clientSecret' => 'Xd1WE28MgA',
                'redirectUrl' => 'https://interview.highbuff.com/sns/naver/web/call',
            ],
            //APPLE 21.06.02 완료
            'apple' => [
                'clientId' => 'interview.bluevisor.com',
                'clientSecret' => '6LFD4FPL6S',
                'redirectUrl' => 'https://interview.highbuff.com/sns/apple/web/call',
            ],
        ];

        // $this->emailFromMail = 'apply@highbuff.com';
        $this->emailFromMail = 'help@highbuff.com';
        $this->emailFromName = 'highbuff';

        //view 사용
        $this->serverHost = 'test';
        if (gethostname() == 'iv-real') {
            $this->serverHost = 'real';
        } else if (gethostname() == 'iv-test') {
            $this->serverHost = 'webtest';
        }
        $this->wwwUrl = 'https://interview.highbuff.com';
        $this->menuUrl = 'https://interview.highbuff.com';
        $this->shortUrl = 'https://interview.highbuff.com/short';
        $this->mediaUrl = 'https://media.highbuff.com';
        $this->mediaPort = '3005';
        $this->smsAPIKey = 'VTN6dXVKUlVWT2U4K1REZEJtZzhpYlN0WlFuOWxIM3dWVE8veE40Tk81T0czdGxTNTErVkhGb09BZGZseC9LdVJCS2F2cWVxMTVNR0tEa01zSThCWVE9PQ==';
        $this->comRegAPIKey = 'eS3qTAl87IOFNuQM2KVryrMuzs/PpQYs2xcopbCnhjstdDDqgFhk9f0TUlHaUZJSOyHMtCGjBfHcprVro41axw==';

        $this->videoPath = '/data/uploads/';
        $this->thumbPath = '/data/uploads_thumbnail/';
        $this->ttsPath = '/data/tts/';
        $this->sessionPath = '/var/lib/php/session';
        $this->checkServer = '';

        if ($this->serverHost == 'webtest') {
            $this->wwwUrl = 'https://webtestinterviewr.highbuff.com';
            $this->menuUrl = 'https://webtestinterviewr.highbuff.com';
            $this->shortUrl = 'https://webtestinterviewr.highbuff.com/short';
            $this->smsAPIKey = 'VTN6dXVKUlVWT2U4K1REZEJtZzhpYlN0WlFuOWxIM3dWVE8veE40Tk81T0czdGxTNTErVkhGb09BZGZseC9LdVJCS2F2cWVxMTVNR0tEa01zSThCWVE9PQ==';
            $this->mediaUrl = 'https://media.highbuff.com';
            $this->mediaPort = '2167';
            $this->videoPath = '/data/webtest/uploads/interview/video/';
            $this->thumbPath = '/data/webtest/uploads/interview/thumbnail/';
            $this->ttsPath = '/data/webtest/tts/';
            $this->sessionPath = '/var/lib/php/session';
            $this->checkServer = '_webtest';
            // 구글, 카카오, 네이버별 각 client _id, client_secret, redirect_uri 상수 설정
            // 하정님이 통합관리
            //GOOGLE 21.06.03 완료
            $this->aSnsInfo = [
                'google' => [
                    // 'clientId' => '265440924719-5a242gqtatmolvgino9l4vtr7jpnnq2u.apps.googleusercontent.com',
                    // 'clientSecret' => 'lXPgmBWQO3QUuLcoddTK9ifp',
                    'clientId' => '485316476575-4ocd3pbjtm27vgn7uma0u21b9lr054ig.apps.googleusercontent.com',
                    'clientSecret' => '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',
                    'redirectUrl' => 'https://webtestinterviewr.highbuff.com/sns/google/web/call',
                ],
                //KAKAO 21.06.02 완료
                'kakao' => [
                    'clientId' => 'c622851e95a98fbe13ba6a94d0598a5b',
                    'clientSecret' => '',
                    'redirectUrl' => 'https://webtestinterviewr.highbuff.com/sns/kakao/web/call',
                ],
                //NAVER 21.06.03 완료
                'naver' => [
                    'clientId' => 'xgw7omXoMTrWdMLU9cw2',
                    'clientSecret' => 'Xd1WE28MgA',
                    'redirectUrl' => 'https://webtestinterviewr.highbuff.com/sns/naver/web/call',
                ],
                //APPLE 21.06.02 완료
                'apple' => [
                    'clientId' => 'interview.bluevisor.com',
                    'clientSecret' => '6LFD4FPL6S',
                    'redirectUrl' => 'https://webtestinterviewr.highbuff.com/sns/apple/web/call',
                    // 'redirectUrl' => 'https://api.highbuff.com/interview/20/call_back.php',
                ],
            ];
        } else if ($this->serverHost == 'test') {
            $this->wwwUrl = 'https://localinterviewr.highbuff.com';
            $this->menuUrl = 'https://localinterviewr.highbuff.com';
            $this->sortUrl = 'https://localinterviewr.highbuff.com/sort';
            $this->smsAPIKey = 'TFhCMjdhR28yR210KzVtU1lHWVhIUEl3WmJSQXRucmlrdkxPZEFMdEhWakdyUjVJendzQlBWTkowNUF2N3ZneFRtK0lmbk0vaklVcmdCTFc0NytIRUE9PQ==';
            $this->mediaUrl = 'https://media.highbuff.com';
            $this->mediaPort = '2167';
            $this->videoPath = '/data/webtest/uploads/interview/video/';
            $this->thumbPath = '/data/webtest/uploads/interview/thumbnail/';
            $this->ttsPath = '/data/webtest/tts/';
            $this->sessionPath = '/var/lib/php/session';
            $this->checkServer = '_local';

            // 구글, 카카오, 네이버별 각 client _id, client_secret, redirect_uri 상수 설정
            // 하정님이 통합관리
            //GOOGLE 21.06.03 완료
            $this->aSnsInfo = [
                'google' => [
                    // 'clientId' => '265440924719-5a242gqtatmolvgino9l4vtr7jpnnq2u.apps.googleusercontent.com',
                    // 'clientSecret' => 'lXPgmBWQO3QUuLcoddTK9ifp',
                    'clientId' => '485316476575-4ocd3pbjtm27vgn7uma0u21b9lr054ig.apps.googleusercontent.com',
                    'clientSecret' => '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',
                    'redirectUrl' => 'https://localinterviewr.highbuff.com/sns/google/web/call',
                ],
                //KAKAO 21.06.02 완료
                'kakao' => [
                    'clientId' => 'c622851e95a98fbe13ba6a94d0598a5b',
                    'clientSecret' => '',
                    'redirectUrl' => 'https://localinterviewr.highbuff.com/sns/kakao/web/call',
                ],
                //NAVER 21.06.03 완료
                'naver' => [
                    'clientId' => 'xgw7omXoMTrWdMLU9cw2',
                    'clientSecret' => 'Xd1WE28MgA',
                    'redirectUrl' => 'https://localinterviewr.highbuff.com/sns/naver/web/call',
                ],
                //APPLE 21.06.02 완료
                'apple' => [
                    'clientId' => 'interview.bluevisor.com',
                    'clientSecret' => '6LFD4FPL6S',
                    'redirectUrl' => 'https://localinterviewr.highbuff.com/sns/apple/web/call',
                ],
            ];
        }
    }


    public function getConfig(): array
    {
        return $this->aConfig;
    }

    public function getEmailFromMail(): string
    {
        return $this->emailFromMail;
    }

    public function getEmailFromName(): string
    {
        return $this->emailFromName;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getMain(): string
    {
        return $this->main;
    }

    public function getWwwUrl(): string
    {
        return $this->wwwUrl;
    }

    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    public function getMediaUrl(): string
    {
        return $this->mediaUrl;
    }

    public function getMediaFullUrl(): string
    {
        return $this->mediaUrl . ':' . $this->mediaPort;
    }

    public function getVideoPath(): string
    {
        return $this->videoPath;
    }


    public function getThumbPath(): string
    {
        return $this->thumbPath;
    }

    public function getTtsPath(): string
    {
        return $this->ttsPath;
    }

    public function getMenuUrl(): string
    {
        return $this->menuUrl;
    }

    public function getServerHost(): string
    {
        return $this->serverHost;
    }

    public function getAdminLogin(): string
    {
        return $this->adminLogin;
    }

    public function getAdminMain(): string
    {
        return $this->adminMain;
    }

    public function getADevIp(): array
    {
        return $this->aDevIp;
    }

    public function getSmsAPIKey(): string
    {
        return $this->smsAPIKey;
    }

    public function getComRegAPIKey(): string
    {
        return $this->comRegAPIKey;
    }
}
