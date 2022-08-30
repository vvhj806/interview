<?php

use Google\Cloud\Storage\StorageClient;

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\SpeechContext;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

putenv('GOOGLE_APPLICATION_CREDENTIALS=/opt/www/twoPointZero/interview/public/plugins/google-api-key/interview-310505-08ef86b8f61b.json');

if (!function_exists('upload_object')) {
    function upload_object(string $bucketName, string $objectName, string $source): string
    {
        $storage = new StorageClient;
        $file = fopen($source, 'r');
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->upload($file, [
            'name' => $objectName
        ]);
        //printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
        $gs_uri = "gs://" . $bucketName . "/" . $objectName;
        return $gs_uri;
    }
}

if (!function_exists('recogAudio')) {
    function recogAudio(string $url, int $rate, string $fileDir, string $resultDir, string $strWord, int $sample_rate_index)
    {
        $sample_rate_list = array(8000, 12000, 16000, 22050, 24000, 25050, 44100, 48000);

        $audio = (new RecognitionAudio)->setUri($url);
        $config = new RecognitionConfig([
            'encoding' => AudioEncoding::FLAC,
            'sample_rate_hertz' => $rate,
            'language_code' => 'ko-KR'
        ]);

        $client = new SpeechClient();

        try {
            $response = $client->recognize($config, $audio);
        } catch (Exception $e) {

            $sample_rate_index++;
            $recog = recogAudio($url, $sample_rate_list[$sample_rate_index], $fileDir, $resultDir, $strWord, $sample_rate_index);
            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            return $recog;
        }

        try {
            $transcript = "";
            foreach ($response->getResults() as $result) {
                $alternatives = $result->getAlternatives();
                $mostLikely = $alternatives[0];
                $transcript .= $mostLikely->getTranscript();
            }
        } catch (Exception $e) {
            return ['result' => 503];
        } finally {
            $client->close();
            unlink($fileDir);
            unlink($resultDir);
        }

        $set_trans = preg_replace("/\s+/", "", $transcript); //공백제거
        $sentence = "안녕하세요" . $strWord . "입니다";
        if ($sentence == $set_trans) {
            return ['result' => 200];
        } else {
            return ['result' => 201, 'speech_to_text' => $transcript];
        }
    }
}
