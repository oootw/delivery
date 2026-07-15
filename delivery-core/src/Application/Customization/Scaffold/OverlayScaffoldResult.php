<?php

declare(strict_types=1);

namespace App\Application\Customization\Scaffold;

final class OverlayScaffoldResult
{
    /**
     * @param list<string> $created
     * @param list<string> $updated
     * @param list<string> $unchanged
     */
    public function __construct(
        public readonly array $created,
        public readonly array $updated,
        public readonly array $unchanged,
    ) {
    }
}
