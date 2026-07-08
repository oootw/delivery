<?php

declare(strict_types=1);

namespace App\Application\Workspace\Service;

/**
 * Правила slug воркспейса. slug становится поддоменом (slug.app.com),
 * поэтому формат ограничен и часть имён зарезервирована за инфраструктурой.
 */
final class WorkspaceSlugRule
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 63;
    private const FORMAT = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';

    private const RESERVED = [
        'www', 'api', 'admin', 'app', 'mail', 'ftp', 'cdn', 'assets', 'static',
        'help', 'support', 'status', 'blog', 'dev', 'test', 'staging',
    ];

    public function validate(string $slug): void
    {
        $length = strlen($slug);

        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            throw new \DomainException('Slug должен быть от 3 до 63 символов');
        }

        if (preg_match(self::FORMAT, $slug) !== 1) {
            throw new \DomainException('Slug может содержать только строчные латинские буквы, цифры и дефис между ними');
        }

        if (in_array($slug, self::RESERVED, true)) {
            throw new \DomainException('Этот slug зарезервирован');
        }
    }
}
