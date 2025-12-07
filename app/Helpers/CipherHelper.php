<?php

namespace App\Helpers;

class CipherHelper
{
    public function decrypt(array $data, string $password)
    {
        $cipher = $data['cipher'] ?? null;
        $iv     = $data['iv'] ?? null;
        $salt   = $data['salt'] ?? null;

        if( !$cipher || !$iv || !$salt || !$password) {
            return false;
        }

        $cipher = base64_decode($cipher);
        $iv     = base64_decode($iv);
        $salt   = base64_decode($salt);
        
        $key = hash_pbkdf2(
            "sha256",
            $password,
            $salt,
            200000,
            32,
            true
        );

        $tag = substr($cipher, -16);
        $cipherText = substr($cipher, 0, -16);
        
        $plaintext = openssl_decrypt(
            $cipherText,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($plaintext === false) {
            return false;
        }

        return $plaintext;
    }
}
