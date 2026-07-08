<?php

declare(strict_types=1);

namespace App\Shared\Service\Crypto;

/**
 * Симметричное шифрование секретов для хранения в БД (libsodium secretbox).
 * Ключ — 32 байта в base64 из переменной окружения. На выходе base64(nonce . cipher).
 */
final class SecretCipher
{
    private const NONCE_LENGTH = SODIUM_CRYPTO_SECRETBOX_NONCEBYTES;

    private readonly string $key;

    public function __construct(string $base64Key)
    {
        $key = base64_decode($base64Key, true);

        if ($key === false || strlen($key) !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
            throw new \RuntimeException('Некорректный ключ шифрования: нужен base64 от 32 байт');
        }

        $this->key = $key;
    }

    public function encrypt(string $plainText): string
    {
        $nonce = random_bytes(self::NONCE_LENGTH);
        $cipher = sodium_crypto_secretbox($plainText, $nonce, $this->key);

        return base64_encode($nonce . $cipher);
    }

    public function decrypt(string $encrypted): string
    {
        $decoded = base64_decode($encrypted, true);

        if ($decoded === false || strlen($decoded) <= self::NONCE_LENGTH) {
            throw new \RuntimeException('Повреждённые зашифрованные данные');
        }

        $nonce = substr($decoded, 0, self::NONCE_LENGTH);
        $cipher = substr($decoded, self::NONCE_LENGTH);

        $plainText = sodium_crypto_secretbox_open($cipher, $nonce, $this->key);

        if ($plainText === false) {
            throw new \RuntimeException('Не удалось расшифровать данные');
        }

        return $plainText;
    }
}
