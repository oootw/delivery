<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetPromotionsByWorkspaceId;

class GetPromotionsByWorkspaceIdQuery
{
    public function __construct(
        public readonly int $userId,
        public readonly int $workspaceId,
    ) {}
}
