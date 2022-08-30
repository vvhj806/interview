<?php

namespace App\Controllers\API\Applier\Upload\Mic;

use App\Controllers\API\APIController;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Flac;
use Google\Cloud\Storage\StorageClient;

use App\Libraries\SendLib;


class MicController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function check()
    {
        helper('interview');
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
        $strWord = $this->request->getPost('word');
        $strDevice = $this->request->getPost('checkDevice');
        $strApplyIdx = $this->request->getPost('applyIdx');
        $micFile = $this->request->getFile('file');
        $strPostCase = $this->request->getPost('postCase');
        $strFileName = time() . "-" . $strApplyIdx;

        $boolSuccess = true;

        if (!$session->has('idx') || $session->get('idx') != $iMemIdx || $strPostCase != 'mic_file' || !$strWord || !$strDevice || !$strApplyIdx || !$micFile) {
            $boolSuccess = false;
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        if ($boolSuccess) {
            if ($micFile->getName() != "" && $micFile->getSize() != 0) {
                if (!$micFile->hasMoved()) {

                    $uploadPath = 'uploads/audioCheck/' . date("Ymd");
                    $result = $micFile->move(WRITEPATH . $uploadPath, $strFileName . ".wav");
                    if ($result) {
                        $fileDir = WRITEPATH . $uploadPath . "/" . $strFileName . ".wav";
                        $resultDir = WRITEPATH . $uploadPath . "/" . $strFileName . ".flac";
                        try {
                            $ffmpeg = FFMpeg::create([
                                'ffmpeg.binaries' => '/usr/bin/ffmpeg',
                                'ffprobe.binaries' => '/usr/bin/ffprobe',
                                'timeout' => 3600,
                                'ffmpeg.threads' => 12
                            ]);

                            $video = $ffmpeg->open($fileDir);
                            $audio_format = new Flac;
                            $video->save($audio_format, $resultDir);
                            $gs_url = upload_object("audio_check", $strFileName . '.flac', $resultDir);

                            $sample_rate_list = array(8000, 12000, 16000, 22050, 24000, 25050, 44100, 48000);
                            $sample_rate_index = 0;
                            $recog = recogAudio($gs_url, $sample_rate_list[$sample_rate_index], $fileDir, $resultDir, $strWord, $sample_rate_index);

                            if ($recog['result'] == 503) {
                                $sendLib = new SendLib();
                                $sendResult = $sendLib->telegramSend("[하이버프2.0_ERROR]<br>경로: /API/Applier/Upload/Mic/MicController.php<br>에러: 음성 인식 실패 transcript를 못만듦 ", "DEV");

                                $this->aResponse = [
                                    'status' => 503,
                                    'code' => [
                                        'stat' => 'fail',
                                        'token' => csrf_hash()
                                    ],
                                    'recog' => $recog,
                                    'messages' => $this->globalvar->aApiMsg['error4'],
                                ];
                            } else if ($recog['result'] == 200) {
                                $result =  $this->masterDB->table('iv_applier')
                                    ->set([
                                        'app_iv_stat' => 2,
                                    ])
                                    ->set(['app_mod_date' => 'NOW()'], '', false)
                                    ->where([
                                        'idx' => $strApplyIdx,
                                        'mem_idx' => $iMemIdx,
                                    ])
                                    ->update();
                                if ($result) {
                                    $this->aResponse = [
                                        'status' => 200,
                                        'code' => [
                                            'stat' => 'success',
                                            'token' => csrf_hash()
                                        ],
                                        'messages' => $this->globalvar->aApiMsg['success3'],
                                    ];
                                } else {
                                    $sendLib = new SendLib();
                                    $sendResult = $sendLib->telegramSend("[하이버프2.0_ERROR]<br>경로: /API/Applier/Upload/Mic/MicController.php<br>에러: iv_applier 에 app_iv_stat 를 2로 update 못함", "DEV");

                                    $this->aResponse = [
                                        'status'   => 500,
                                        'code'     => [
                                            'stat' => 'fail',
                                            'token' => csrf_hash()
                                        ],
                                        'messages' => $this->globalvar->aApiMsg['error3'],
                                    ];
                                }
                            } else {
                                $this->aResponse = [
                                    'status' => 201,
                                    'code' => [
                                        'stat' => 'fail',
                                        'token' => csrf_hash()
                                    ],
                                    'recog' => $recog,
                                    'messages' => "{$this->globalvar->aApiMsg['error4']}<br>{$this->globalvar->aApiMsg['error5']}",
                                ];
                            }
                        } catch (\Exception $e) {
                            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                            $sendLib = new SendLib();
                            $sendResult = $sendLib->telegramSend("[하이버프2.0_ERROR]<br>경로: /API/Applier/Upload/Mic/MicController.php<br>에러: 파일 변환 실패 " . $s, "DEV");

                            $this->aResponse = [
                                'status' => 503,
                                'code' => [
                                    'stat' => 'fail',
                                    'token' => csrf_hash()
                                ],
                                'recog' => $s,
                                'messages' => $this->globalvar->aApiMsg['error6'],
                            ];
                        }
                    }
                }
            }
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function show($id = null)
    {
    }

    public function update($id = null)
    {
    }

    public function delete(int $idx)
    {
    }
}
