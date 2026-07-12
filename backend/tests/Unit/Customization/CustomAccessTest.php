<?php

declare(strict_types=1);

namespace App\Tests\Unit\Customization;

use App\Application\Customization\Access\CustomAccess;
use App\Application\Customization\Access\CustomRole;
use App\Application\Customization\Contract\AbstractCustomModule;
use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignment;
use App\Application\Customization\Entity\CustomRoleAssignment\CustomRoleAssignmentRepositoryInterface;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModule;
use App\Application\Customization\Entity\WorkspaceCustomModule\WorkspaceCustomModuleRepositoryInterface;
use App\Application\Customization\Registry\CustomModuleRegistry;
use App\Application\Workspace\Entity\Workspace\Workspace;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class CustomAccessTest extends TestCase
{
    public const WORKSPACE_ID = 7;
    public const OWNER_ID = 100;
    public const STAFF_ID = 200;
    public const ROLE = 'acme.reservation_manager';

    public function testOwnerHasEveryRoleOfActiveModule(): void
    {
        $access = $this->access(moduleActive: true, assignedTo: []);

        self::assertTrue($access->hasRole(self::WORKSPACE_ID, self::OWNER_ID, self::ROLE));
    }

    public function testAssignedStaffHasRole(): void
    {
        $access = $this->access(moduleActive: true, assignedTo: [self::STAFF_ID]);

        self::assertTrue($access->hasRole(self::WORKSPACE_ID, self::STAFF_ID, self::ROLE));
    }

    public function testUnassignedStaffHasNoRole(): void
    {
        $access = $this->access(moduleActive: true, assignedTo: []);

        self::assertFalse($access->hasRole(self::WORKSPACE_ID, self::STAFF_ID, self::ROLE));
    }

    public function testInactiveModuleGrantsNoRoleEvenToOwner(): void
    {
        $access = $this->access(moduleActive: false, assignedTo: [self::STAFF_ID]);

        self::assertFalse($access->hasRole(self::WORKSPACE_ID, self::OWNER_ID, self::ROLE));
        self::assertFalse($access->hasRole(self::WORKSPACE_ID, self::STAFF_ID, self::ROLE));
    }

    public function testUndeclaredRoleIsRejected(): void
    {
        $access = $this->access(moduleActive: true, assignedTo: [self::STAFF_ID]);

        self::assertFalse($access->hasRole(self::WORKSPACE_ID, self::STAFF_ID, 'acme.unknown'));
    }

    public function testAssertModuleActiveThrowsWhenInactive(): void
    {
        $access = $this->access(moduleActive: false, assignedTo: []);

        $this->expectException(\DomainException::class);
        $access->assertModuleActive(self::WORKSPACE_ID, 'acme');
    }

    /**
     * @param list<int> $assignedTo пользователи, которым назначена роль ROLE
     */
    private function access(bool $moduleActive, array $assignedTo): CustomAccess
    {
        return new CustomAccess(
            $this->registry($moduleActive),
            $this->assignments($assignedTo),
            $this->workspaces(),
        );
    }

    private function registry(bool $active): CustomModuleRegistry
    {
        $module = new class extends AbstractCustomModule {
            public function slug(): string
            {
                return 'acme';
            }

            public function title(): string
            {
                return 'Acme';
            }

            public function roles(): array
            {
                return [new CustomRole(CustomAccessTest::ROLE, 'Менеджер')];
            }
        };

        $activation = new class($active) implements WorkspaceCustomModuleRepositoryInterface {
            public function __construct(private readonly bool $active) {}

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
                return $this->active && $workspaceId === CustomAccessTest::WORKSPACE_ID ? ['acme'] : [];
            }
        };

        return new CustomModuleRegistry([$module], $activation);
    }

    /**
     * @param list<int> $assignedTo
     */
    private function assignments(array $assignedTo): CustomRoleAssignmentRepositoryInterface
    {
        return new class($assignedTo) implements CustomRoleAssignmentRepositoryInterface {
            /** @param list<int> $assignedTo */
            public function __construct(private readonly array $assignedTo) {}

            public function save(CustomRoleAssignment $assignment): int
            {
                return 0;
            }

            public function findByWorkspaceUserAndRole(int $workspaceId, int $userId, string $roleKey): ?CustomRoleAssignment
            {
                return null;
            }

            public function delete(int $assignmentId): void {}

            public function roleKeysFor(int $workspaceId, int $userId): array
            {
                return in_array($userId, $this->assignedTo, true) ? [CustomAccessTest::ROLE] : [];
            }
        };
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
                if ($id !== CustomAccessTest::WORKSPACE_ID) {
                    return null;
                }

                $now = new \DateTimeImmutable();

                return new Workspace(
                    id: $id,
                    name: 'Acme',
                    slug: 'acme',
                    description: '',
                    logo: null,
                    ownerId: CustomAccessTest::OWNER_ID,
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
}
