<?php

namespace App\Libraries;

class EncryptLib
{
    public function makePassword($password): string
    {
        $password = $password ?? false;
        if (!$password) {
            return '';
        }
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function checkPassword($post, $password): bool
    {
        if (isset($post) && isset($password)) {
            if (password_verify($post, $password)) {
                return true;
            }
        }
        return false;
    }

    public function getSha1($val): string
    {
        if(!$val){
            return '';
        }
        return sha1($val);
    }

    //1.5 암호화 / 복호화 함수
    public function setEncrypt($str, $secret_key = 'secret key') // secret key => bluevisorencrypt . . . . .
    {
        $key = substr(hash('sha256', $secret_key, true), 0, 32);
        $iv = substr(hash('sha256', $secret_key, true), 0, 16);
        return base64_encode(openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv));
    }

    public function setDecrypt($str, $secret_key = 'secret key')
    {
        $key = substr(hash('sha256', $secret_key, true), 0, 32);
        $iv = substr(hash('sha256', $secret_key, true), 0, 16);
        return openssl_decrypt(base64_decode($str), "AES-256-CBC", $key, 0, $iv);
    }
}
