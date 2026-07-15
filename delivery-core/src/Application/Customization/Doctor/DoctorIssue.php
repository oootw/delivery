<?php

declare(strict_types=1);

namespace App\Application\Customization\Doctor;

final class DoctorIssue
{
    public function __construct(
        public readonly string $severity,
        public readonly string $code,
        public readonly string $message,
        public readonly ?string $path = null,
    ) {
    }
}
