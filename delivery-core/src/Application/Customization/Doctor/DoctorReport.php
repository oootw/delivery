<?php

declare(strict_types=1);

namespace App\Application\Customization\Doctor;

final class DoctorReport
{
    /** @var list<DoctorIssue> */
    private array $issues = [];

    public function addError(string $code, string $message, ?string $path = null): void
    {
        $this->issues[] = new DoctorIssue('error', $code, $message, $path);
    }

    public function addWarning(string $code, string $message, ?string $path = null): void
    {
        $this->issues[] = new DoctorIssue('warning', $code, $message, $path);
    }

    /**
     * @return list<DoctorIssue>
     */
    public function all(): array
    {
        return $this->issues;
    }

    /**
     * @return list<DoctorIssue>
     */
    public function errors(): array
    {
        return array_values(array_filter(
            $this->issues,
            static fn (DoctorIssue $issue): bool => $issue->severity === 'error',
        ));
    }

    /**
     * @return list<DoctorIssue>
     */
    public function warnings(): array
    {
        return array_values(array_filter(
            $this->issues,
            static fn (DoctorIssue $issue): bool => $issue->severity === 'warning',
        ));
    }

    public function hasErrors(): bool
    {
        return $this->errors() !== [];
    }
}
