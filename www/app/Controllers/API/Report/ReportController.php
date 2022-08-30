<?php

namespace App\Controllers\API\Report;

use App\Controllers\API\APIController;
use Config\Services;

use App\Models\{
    ReportResultModel,
    SentiWordModel,
};

use App\Libraries\SendLib;

class ReportController extends APIController
{
    private $aResponse = [];

    public function update($iRepoResultIdx)
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

        $reportResultModel = new ReportResultModel();
        $SentiWordModel = new SentiWordModel();

        $session = session();
        $iMemIdx = $session->get('idx');
        $jsonSpeechAfter = $this->request->getPost('speechAfter');
        $emotionUpdate = $this->request->getPost('emotionUpdate');
        if ($jsonSpeechAfter && $iRepoResultIdx) {
            $jsonSpeechBefore = $reportResultModel->where(['idx' => $iRepoResultIdx])->findColumn('repo_speech_txt_detail');
            $aSpeechBefore = json_decode($jsonSpeechBefore[0], true);
            $aSpeechAfter = json_decode($jsonSpeechAfter, true);

            //트랜잭션 start
            $this->masterDB->transBegin();

            for ($i = 0, $max = count($aSpeechBefore); $i < $max; $i++) {
                if ($aSpeechBefore[$i]['alternatives']['0']['content'] != $aSpeechAfter[$i]['alternatives'][0]['content']) { //맞춤법 변경이 일어남(단어 변경)

                    $strAfterContent = $aSpeechAfter[$i]['alternatives'][0]['content'];
                    $url = "https://media.highbuff.com/crontab/interview20/get_okt_post.php"; //단어 분석 okt 실행시킴

                    $data = array(
                        'content' => $strAfterContent
                    );

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $result = json_decode($result, true);

                    if ($result['status'] == '200') {
                        $aAfterWords = $result['arr'];

                        $aSpeechAfter[$i]['alternatives'][0]['words'] = [];
                        foreach ($aAfterWords as $key => $val) {
                            $aWords = str_replace("'", '"', $val);
                            $aSpeechAfter[$i]['alternatives'][0]['words'][$key] = json_decode($aWords, true);
                        }
                    }

                    $this->masterDB->table('iv_labeler_stt_log')
                        ->set([
                            'mem_idx' => $iMemIdx,
                            'res_idx' => $iRepoResultIdx,
                            'stt_before' => $aSpeechBefore[$i]['alternatives'][0]['content'],
                            'stt_after' => $aSpeechAfter[$i]['alternatives'][0]['content']
                        ])
                        ->set(['stt_reg_date' => 'NOW()'], '', false)
                        ->insert();
                }

                if ($aSpeechBefore[$i]['alternatives']['0']['words'] != $aSpeechAfter[$i]['alternatives'][0]['words']) { // words 에 변경이 일어났음

                    $sumScore = 0;
                    $checkScore = true;
                    foreach ($aSpeechAfter[$i]['alternatives'][0]['words'] as $key => $val) { //iv_sentiword 에 있으면 update 없으면 insert
                        $aWord = $SentiWordModel->getSentiWord($val['word']);
                        if ($emotionUpdate == 'true') { //감정점수를 저장
                            if ($val['score'] != "" && $val['score'] != null) {  // val['score']값이 있으면 임의로 값을 넣은 것
                                $checkScore = false;
                                $result = $this->masterDB->table('iv_sentiword');
                                $aSpeechAfter[$i]['alternatives'][0]['words'][$key]['score'] = $val['score'];
                                $sumScore += $val['score'];
                                if (!$aWord) { //sentiword 에 있는지 확인해서 없으면 insert
                                    $result
                                        ->set([
                                            'word' => $val['word'],
                                            'word_root' => $val['word'],
                                            'polarity' => $val['score'],
                                        ])
                                        ->insert();
                                } else { //있으면 update
                                    $result
                                        ->set([
                                            'polarity' => $val['score'],
                                        ])
                                        ->where([
                                            'word' => $val['word']
                                        ])
                                        ->update();
                                }
                            } else {
                                $result = $this->masterDB->table('iv_sentiword');
                                if ($aWord) {
                                    $result
                                        ->where([
                                            'word' => $val['word'],
                                        ])
                                        ->delete();
                                }
                            }
                        } else { // stt를 교정해서 저장
                            if ($aWord) { //iv_sentiword 에 있음 
                                $checkScore = false;
                                $aSpeechAfter[$i]['alternatives'][0]['words'][$key]['score'] = $aWord[0]['polarity']; //score 에 점수 넣기
                                $sumScore += (int)$aWord[0]['polarity']; //sentiword 에 있으면 점수가 있는 것 따라서 총 점수가 생김
                            }
                        }
                    }
                    if ($checkScore) {
                        $sumScore = "";
                    }
                    $aSpeechAfter[$i]['alternatives'][0]['score'] = $sumScore;
                    $this->masterDB->table('iv_labeler_stt_log')
                        ->set([
                            'mem_idx' => $iMemIdx,
                            'res_idx' => $iRepoResultIdx,
                            'senti_before' => json_encode($aSpeechBefore[$i]['alternatives']['0']['words'], JSON_UNESCAPED_UNICODE),
                            'senti_after' => json_encode($aSpeechAfter[$i]['alternatives'][0]['words'], JSON_UNESCAPED_UNICODE)
                        ])
                        ->set(['stt_reg_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }

            $this->masterDB->table('iv_report_result')
                ->set([
                    'repo_speech_txt_detail' => json_encode($aSpeechAfter, JSON_UNESCAPED_UNICODE)
                ])
                ->set(['repo_mod_date' => 'NOW()'], '', false)
                ->where(['idx' => $iRepoResultIdx])
                ->update();


            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
                $this->aResponse = [
                    'status'   => 503,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            } else {
                $this->masterDB->transCommit();
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash(),
                        'result' => $aSpeechAfter
                    ],
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            }
        } else {
            $this->aResponse = [
                'status'   => 404,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }
}
