<?php

namespace App\Controllers\Interview\File;

use App\Controllers\Interview\WwwController;

use Config\Services;

class ImageController extends WwwController
{
    public function index()
    {
    }

    public function show(string $code)
    {
        $this->commonData();
        //https://localinterviewr.highbuff.com/storage/uploads/?path=notice/20220228/1646040589_87b9db44122a975f68b8.jpg
        if (!in_array($code, ['uploads', 'tts'])) {
            $this->exceptionPage(404);
            exit;
        }
        $strPath = $this->request->getGet('path');
        $fullPath = WRITEPATH . $strPath;
        if(!file_exists($fullPath)){
            $this->exceptionPage(404);
            exit;
        }
        $mime = mime_content_type($fullPath);
        header('Content-Length: ' . filesize($fullPath));
        header("Content-Type: $mime");
        header('Content-Disposition: inline; filename="' . $fullPath . '";');
        readfile($fullPath);
        exit;
    }
}
