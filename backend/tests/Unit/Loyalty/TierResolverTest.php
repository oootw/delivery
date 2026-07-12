<?php

declare(strict_types=1);

namespace App\Tests\Unit\Loyalty;

use App\Application\Loyalty\Entity\Tier\LoyaltyTier;
use App\Application\Loyalty\Service\TierResolver;
use PHPUnit\Framework\TestCase;

final class TierResolverTest extends TestCase
{
    private TierResolver $resolver;
    /** @var LoyaltyTier[] */
    private array $tiers;

    protected function setUp(): void
    {
        $this->resolver = new TierResolver();
        $this->tiers = [
            $this->tier('Серебро', 100_00),
            $this->tier('Золото', 500_00),
            $this->tier('Платина', 1000_00),
        ];
    }

    public function testResolveReturnsNullBelowLowestThreshold(): void
    {
        self::assertNull($this->resolver->resolve(50_00, $this->tiers));
    }

    public function testResolveReturnsHighestReachedTier(): void
    {
        $tier = $this->resolver->resolve(600_00, $this->tiers);

        self::assertNotNull($tier);
        self::assertSame('Золото', $tier->name);
    }

    public function testResolveIsInclusiveOfThreshold(): void
    {
        $tier = $this->resolver->resolve(500_00, $this->tiers);

        self::assertNotNull($tier);
        self::assertSame('Золото', $tier->name);
    }

    public function testResolveReturnsTopTierWhenSpendExceedsAll(): void
    {
        $tier = $this->resolver->resolve(5000_00, $this->tiers);

        self::assertNotNull($tier);
        self::assertSame('Платина', $tier->name);
    }

    public function testNextTierReturnsClosestAbove(): void
    {
        $next = $this->resolver->nextTier(600_00, $this->tiers);

        self::assertNotNull($next);
        self::assertSame('Платина', $next->name);
    }

    public function testNextTierIsNullWhenAtOrAboveTop(): void
    {
        self::assertNull($this->resolver->nextTier(1000_00, $this->tiers));
    }

    public function testNextTierFromZeroIsLowest(): void
    {
        $next = $this->resolver->nextTier(0, $this->tiers);

        self::assertNotNull($next);
        self::assertSame('Серебро', $next->name);
    }

    private function tier(string $name, int $thresholdKopecks): LoyaltyTier
    {
        return new LoyaltyTier(
            id: null,
            workspaceId: 1,
            name: $name,
            thresholdKopecks: $thresholdKopecks,
            earnRateBonusBasisPoints: 0,
            permanentDiscountBasisPoints: 0,
            sortOrder: 0,
        );
    }
}
