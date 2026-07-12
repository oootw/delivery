<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customization;

use App\Application\Customization\Contract\AbstractCustomModule;
use App\Application\Customization\Contract\CustomModuleInterface;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModule;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModuleRepositoryInterface;
use App\Application\Customization\Entity\WorkspaceFeatureGrant\WorkspaceFeatureGrant;
use App\Application\Customization\Entity\WorkspaceFeatureGrant\WorkspaceFeatureGrantRepositoryInterface;
use App\Application\Customization\Feature\FeatureGate;
use App\Application\Customization\Registry\CustomModuleRegistry;
use App\Application\Subscription\Entity\Subscription\Subscription;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Application\Subscription\Entity\Subscription\SubscriptionStatusEnum;
use App\Application\Tarif\Entity\Tarif\Tarif;
use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use App\Shared\Enum\Feature\FeatureCodeEnum;
use PHPUnit\Framework\TestCase;

final class FeatureGateTest extends TestCase
{
    public const WORKSPACE_ID = 7;
    public const OWNER_ID = 100;

    public function testCombinesTarifModuleAndGrantSources(): void
    {
        $gate = $this->gate(
            tarifFeatures: [FeatureCodeEnum::ANALYTICS],
            moduleFeatures: [FeatureCodeEnum::CRM],
            grantedFeatures: [FeatureCodeEnum::SUPPORT],
        );

        self::assertTrue($gate->has(self::WORKSPACE_ID, FeatureCodeEnum::ANALYTICS)); // тариф
        self::assertTrue($gate->has(self::WORKSPACE_ID, FeatureCodeEnum::CRM));       // модуль
        self::assertTrue($gate->has(self::WORKSPACE_ID, FeatureCodeEnum::SUPPORT));   // грант
        self::assertFalse($gate->has(self::WORKSPACE_ID, FeatureCodeEnum::POINTS));   // нигде

        self::assertEqualsCanonicalizing(
            [FeatureCodeEnum::ANALYTICS, FeatureCodeEnum::CRM, FeatureCodeEnum::SUPPORT],
            $gate->enabledFor(self::WORKSPACE_ID),
        );
    }

    public function testDeduplicatesFeaturesAcrossSources(): void
    {
        $gate = $this->gate(
            tarifFeatures: [FeatureCodeEnum::CRM],
            moduleFeatures: [FeatureCodeEnum::CRM],
            grantedFeatures: [FeatureCodeEnum::CRM],
        );

        self::assertSame([FeatureCodeEnum::CRM], $gate->enabledFor(self::WORKSPACE_ID));
    }

    public function testNoActiveSubscriptionMeansNoTarifFeatures(): void
    {
        $gate = $this->gate(
            tarifFeatures: [FeatureCodeEnum::ANALYTICS],
            moduleFeatures: [],
            grantedFeatures: [FeatureCodeEnum::SUPPORT],
            hasActiveSubscription: false,
        );

        self::assertFalse($gate->has(self::WORKSPACE_ID, FeatureCodeEnum::ANALYTICS));
        self::assertTrue($gate->has(self::WORKSPACE_ID, FeatureCodeEnum::SUPPORT)); // грант не зависит от тарифа
    }

    public function testUnknownWorkspaceHasNothing(): void
    {
        $gate = $this->gate(
            tarifFeatures: [FeatureCodeEnum::ANALYTICS],
            moduleFeatures: [FeatureCodeEnum::CRM],
            grantedFeatures: [],
        );

        self::assertFalse($gate->has(999, FeatureCodeEnum::ANALYTICS));
        self::assertSame([], $gate->enabledFor(999));
    }

    /**
     * @param list<FeatureCodeEnum> $tarifFeatures
     * @param list<FeatureCodeEnum> $moduleFeatures
     * @param list<FeatureCodeEnum> $grantedFeatures
     */
    private function gate(
        array $tarifFeatures,
        array $moduleFeatures,
        array $grantedFeatures,
        bool $hasActiveSubscription = true,
    ): FeatureGate {
        return new FeatureGate(
            $this->workspaces(),
            $this->subscriptions($hasActiveSubscription),
            $this->tarifs($tarifFeatures),
            $this->registry($moduleFeatures),
            $this->grants($grantedFeatures),
        );
    }

    private function workspaces(): WorkspaceRepositoryInterface
    {
        return new class implements WorkspaceRepositoryInterface {
            public function save(Workspace $workspace): int
            {
                return 0;
            }

            public function findById(int $id): ?Workspace
            {
                if ($id !== FeatureGateTest::WORKSPACE_ID) {
                    return null;
                }

                $now = new \DateTimeImmutable();

                return new Workspace(
                    id: $id,
                    name: 'Acme',
                    slug: 'acme',
                    description: '',
                    logo: null,
                    ownerId: FeatureGateTest::OWNER_ID,
                    createdAt: $now,
                    updatedAt: $now,
                );
            }

            public function findBySlug(string $slug): ?Workspace
            {
                return null;
            }

            public function findAllByIds(array $ids): array
            {
                return [];
            }

            public function countByOwner(int $ownerId): int
            {
                return 0;
            }
        };
    }

    private function subscriptions(bool $hasActive): SubscriptionRepositoryInterface
    {
        return new class($hasActive) implements SubscriptionRepositoryInterface {
            public function __construct(private readonly bool $hasActive) {}

            public function findActiveByUser(int $userId): ?Subscription
            {
                if (!$this->hasActive || $userId !== FeatureGateTest::OWNER_ID) {
                    return null;
                }

                $now = new \DateTimeImmutable();

                return new Subscription(
                    id: 1,
                    userId: $userId,
                    tarifCode: TarifCodeEnum::PRO,
                    status: SubscriptionStatusEnum::Active,
                    invoiceId: 'inv-1',
                    externalId: null,
                    currentPeriodEnd: $now,
                    createdAt: $now,
                    updatedAt: $now,
                );
            }

            public function save(Subscription $subscription): int
            {
                return 0;
            }

            public function findById(int $id): ?Subscription
            {
                return null;
            }

            public function findByInvoiceId(string $invoiceId): ?Subscription
            {
                return null;
            }

            public function findByExternalId(string $externalId): ?Subscription
            {
                return null;
            }

            public function findPendingByUser(int $userId): ?Subscription
            {
                return null;
            }

            public function findLatestByUser(int $userId): ?Subscription
            {
                return null;
            }

            public function findPastDueOlderThan(\DateTimeImmutable $updatedBefore): array
            {
                return [];
            }
        };
    }

    /**
     * @param list<FeatureCodeEnum> $features
     */
    private function tarifs(array $features): TarifRepositoryInterface
    {
        return new class($features) implements TarifRepositoryInterface {
            /** @param list<FeatureCodeEnum> $features */
            public function __construct(private readonly array $features) {}

            public function getAllTarifs(): array
            {
                return [];
            }

            public function getByTarifCode(TarifCodeEnum $tarifCode): ?Tarif
            {
                if ($tarifCode !== TarifCodeEnum::PRO) {
                    return null;
                }

                return Tarif::buildNew('Pro', TarifCodeEnum::PRO, '', 0, $this->features);
            }
        };
    }

    /**
     * @param list<FeatureCodeEnum> $moduleFeatures
     */
    private function registry(array $moduleFeatures): CustomModuleRegistry
    {
        $module = new class($moduleFeatures) extends AbstractCustomModule {
            /** @param list<FeatureCodeEnum> $features */
            public function __construct(private readonly array $features) {}

            public function slug(): string
            {
                return 'acme';
            }

            public function title(): string
            {
                return 'Acme';
            }

            public function capabilities(): array
            {
                return $this->features;
            }
        };

        $activation = new class implements WorkspaceCustomModuleRepositoryInterface {
            public function save(WorkspaceCustomModule $module): int
            {
                return 0;
            }

            public function findByWorkspaceAndSlug(int $workspaceId, string $slug): ?WorkspaceCustomModule
            {
                return null;
            }

            public function findByWorkspace(int $workspaceId): array
            {
                return [];
            }

            public function findEnabledSlugsByWorkspace(int $workspaceId): array
            {
                return $workspaceId === FeatureGateTest::WORKSPACE_ID ? ['acme'] : [];
            }
        };

        return new CustomModuleRegistry([$module], $activation);
    }

    /**
     * @param list<FeatureCodeEnum> $granted
     */
    private function grants(array $granted): WorkspaceFeatureGrantRepositoryInterface
    {
        return new class($granted) implements WorkspaceFeatureGrantRepositoryInterface {
            /** @param list<FeatureCodeEnum> $granted */
            public function __construct(private readonly array $granted) {}

            public function save(WorkspaceFeatureGrant $grant): int
            {
                return 0;
            }

            public function findByWorkspaceAndFeature(int $workspaceId, FeatureCodeEnum $feature): ?WorkspaceFeatureGrant
            {
                return null;
            }

            public function grantedFeatures(int $workspaceId): array
            {
                return $workspaceId === FeatureGateTest::WORKSPACE_ID ? $this->granted : [];
            }
        };
    }
}
