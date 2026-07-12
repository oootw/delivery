<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Promotion;

use App\Application\Promotion\Entity\Promotion\Promotion as PromotionEntity;
use App\Application\Promotion\Entity\Promotion\PromotionConditions;
use App\Application\Promotion\Entity\Promotion\PromotionRedemption as PromotionRedemptionEntity;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;
use App\Application\Promotion\Entity\Promotion\PromotionTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Promotion>
 */
class PromotionRepository extends ServiceEntityRepository implements PromotionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function save(PromotionEntity $promotion): int
    {
        $record = $promotion->id !== null
            ? $this->find($promotion->id)
            : new Promotion();

        if ($record === null) {
            throw new \DomainException('Акция не найдена');
        }

        $record->setWorkspaceId($promotion->workspaceId);
        $record->setVenueId($promotion->venueId);
        $record->setName($promotion->name);
        $record->setType($promotion->type);
        $record->setCode($promotion->code);
        $record->setRewardType($promotion->rewardType);
        $record->setRewardValue($promotion->rewardValue);
        $record->setTarget($promotion->target);
        $record->setTargetRefs($promotion->targetRefs);
        $record->setConditions($promotion->conditions->toArray());
        $record->setPriority($promotion->priority);
        $record->setStackable($promotion->stackable);
        $record->setMaxRedemptions($promotion->maxRedemptions);
        $record->setMaxRedemptionsPerCustomer($promotion->maxRedemptionsPerCustomer);
        $record->setRedemptionsCount($promotion->redemptionsCount);
        $record->setIsActive($promotion->isActive);
        $record->setCreatedAt($promotion->createdAt);
        $record->setUpdatedAt($promotion->updatedAt);
        $record->setBannerTitle($promotion->bannerTitle);
        $record->setBannerText($promotion->bannerText);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $promotion->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?PromotionEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function delete(PromotionEntity $promotion): void
    {
        if ($promotion->id === null) {
            return;
        }

        $record = $this->find($promotion->id);

        if ($record === null) {
            return;
        }

        $this->getEntityManager()->remove($record);
        $this->getEntityManager()->flush();
    }

    public function findAllByWorkspace(int $workspaceId): array
    {
        return array_map(
            fn(Promotion $record): PromotionEntity => $this->toEntity($record),
            $this->findBy(['workspaceId' => $workspaceId], ['priority' => 'DESC', 'id' => 'DESC']),
        );
    }

    public function findActiveAutomaticByVenue(int $workspaceId, int $venueId): array
    {
        $records = $this->createQueryBuilder('p')
            ->where('p.workspaceId = :workspaceId')
            ->andWhere('p.type = :type')
            ->andWhere('p.isActive = true')
            ->andWhere('(p.venueId IS NULL OR p.venueId = :venueId)')
            ->setParameter('workspaceId', $workspaceId)
            ->setParameter('type', PromotionTypeEnum::Automatic->value)
            ->setParameter('venueId', $venueId)
            ->orderBy('p.priority', 'DESC')
            ->getQuery()
            ->getResult();

        return array_map(
            fn(Promotion $record): PromotionEntity => $this->toEntity($record),
            $records,
        );
    }

    public function findActivePromocode(int $workspaceId, string $code): ?PromotionEntity
    {
        $record = $this->findOneBy([
            'workspaceId' => $workspaceId,
            'code' => $code,
            'type' => PromotionTypeEnum::Promocode,
            'isActive' => true,
        ]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function saveRedemption(PromotionRedemptionEntity $redemption): void
    {
        $record = new PromotionRedemption();
        $record->setPromotionId($redemption->promotionId);
        $record->setWorkspaceId($redemption->workspaceId);
        $record->setOrderId($redemption->orderId);
        $record->setCustomerId($redemption->customerId);
        $record->setDiscountKopecks($redemption->discountKopecks);
        $record->setCreatedAt($redemption->createdAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $redemption->assignId($record->getId());
    }

    public function countRedemptionsByCustomer(int $promotionId, int $customerId): int
    {
        return (int) $this->getEntityManager()
            ->createQueryBuilder()
            ->select('COUNT(r.id)')
            ->from(PromotionRedemption::class, 'r')
            ->where('r.promotionId = :promotionId')
            ->andWhere('r.customerId = :customerId')
            ->setParameter('promotionId', $promotionId)
            ->setParameter('customerId', $customerId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findRedemptionsByOrder(int $orderId): array
    {
        $records = $this->getEntityManager()
            ->getRepository(PromotionRedemption::class)
            ->findBy(['orderId' => $orderId]);

        return array_map(
            static fn(PromotionRedemption $record): PromotionRedemptionEntity => new PromotionRedemptionEntity(
                id: $record->getId(),
                promotionId: $record->getPromotionId(),
                workspaceId: $record->getWorkspaceId(),
                orderId: $record->getOrderId(),
                customerId: $record->getCustomerId(),
                discountKopecks: $record->getDiscountKopecks(),
                createdAt: $record->getCreatedAt(),
            ),
            $records,
        );
    }

    public function deleteRedemptionsByOrder(int $orderId): void
    {
        $this->getEntityManager()
            ->createQueryBuilder()
            ->delete(PromotionRedemption::class, 'r')
            ->where('r.orderId = :orderId')
            ->setParameter('orderId', $orderId)
            ->getQuery()
            ->execute();
    }

    private function toEntity(Promotion $record): PromotionEntity
    {
        return new PromotionEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            venueId: $record->getVenueId(),
            name: $record->getName(),
            type: $record->getType(),
            code: $record->getCode(),
            rewardType: $record->getRewardType(),
            rewardValue: $record->getRewardValue(),
            target: $record->getTarget(),
            targetRefs: $record->getTargetRefs(),
            conditions: PromotionConditions::fromArray($record->getConditions()),
            priority: $record->getPriority(),
            stackable: $record->isStackable(),
            maxRedemptions: $record->getMaxRedemptions(),
            maxRedemptionsPerCustomer: $record->getMaxRedemptionsPerCustomer(),
            redemptionsCount: $record->getRedemptionsCount(),
            isActive: $record->isActive(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
            bannerTitle: $record->getBannerTitle(),
            bannerText: $record->getBannerText(),
        );
    }
}
