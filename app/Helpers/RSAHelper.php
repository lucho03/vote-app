<?php

namespace App\Helpers;

class RSAHelper
{
    static public function generateRSAKeys()
    {
        $res = openssl_pkey_new([
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);

        openssl_pkey_export($res, $privateKey);
        $publicKey = openssl_pkey_get_details($res)['key'];

        return [$publicKey, $privateKey];
    }

    static function decryptRSA(string $base64, string $privateKeyPem): string
    {
        $encrypted = base64_decode($base64);
        $privateKey = openssl_pkey_get_private($privateKeyPem);

        openssl_private_decrypt(
            $encrypted,
            $decrypted,
            $privateKey,
            OPENSSL_PKCS1_OAEP_PADDING
        );

        return $decrypted;
    }
}