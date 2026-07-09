<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Правило скидки или промокода воркспейса. Тип разделяет автоматическую акцию
 * (применяется сама при выполнении условий) и промокод (нужен ввод кода).
 * Скидка задаётся типом вознаграждения (процент в базисных пунктах или фикс в
 * копейках) и целью (пока только весь заказ). Стекинг управляется приоритетом и
 * флагом stackable — см. PromotionEngine.
 */
class Promotion
{
    public function __construct(
        public ?int $id,
        public int $workspaceId,
        public ?int $venueId,
        public string $name,
        public PromotionTypeEnum $type,
        public ?string $code,
        public RewardTypeEnum $rewardType,
        public int $rewardValue,
        public PromotionTargetEnum $target,
        public array $targetRefs,
        public PromotionConditions $conditions,
        public int $priority,
        public bool $stackable,
        public ?int $maxRedemptions,
        public ?int $maxRedemptionsPerCustomer,
        public int $redemptionsCount,
        public bool $isActive,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    /**
     * @param list<string> $targetRefs
     */
    public static function buildNew(
        int $workspaceId,
        ?int $venueId,
        string $name,
        PromotionTypeEnum $type,
        ?string $code,
        RewardTypeEnum $rewardType,
        int $rewardValue,
        PromotionTargetEnum $target,
        array $targetRefs,
        PromotionConditions $conditions,
        int $priority,
        bool $stackable,
        ?int $maxRedemptions,
        ?int $maxRedemptionsPerCustomer,
    ): self {
        $now = new \DateTimeImmutable();

        $promotion = new self(
            id: null,
            workspaceId: $workspaceId,
            venueId: $venueId,
            name: '',
            type: $type,
            code: null,
            rewardType: $rewardType,
            rewardValue: 0,
            target: PromotionTargetEnum::Order,
            targetRefs: [],
            conditions: $conditions,
            priority: $priority,
            stackable: $stackable,
            maxRedemptions: null,
            maxRedemptionsPerCustomer: null,
            redemptionsCount: 0,
            isActive: true,
            createdAt: $now,
            updatedAt: $now,
        );

        $promotion->apply($name, $type, $code, $rewardType, $rewardValue, $target, $targetRefs, $conditions, $priority, $stackable, $maxRedemptions, $maxRedemptionsPerCustomer);

        return $promotion;
    }

    /**
     * Полная замена изменяемых полей акции (для PUT).
     *
     * @param list<string> $targetRefs
     */
    public function update(
        string $name,
        PromotionTypeEnum $type,
        ?string $code,
        RewardTypeEnum $rewardType,
        int $rewardValue,
        PromotionTargetEnum $target,
        array $targetRefs,
        PromotionConditions $conditions,
        int $priority,
        bool $stackable,
        ?int $maxRedemptions,
        ?int $maxRedemptionsPerCustomer,
    ): void {
        $this->apply($name, $type, $code, $rewardType, $rewardValue, $target, $targetRefs, $conditions, $priority, $stackable, $maxRedemptions, $maxRedemptionsPerCustomer);
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function changeActivity(bool $isActive): void
    {
        $this->isActive = $isActive;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * Скидка по этому правилу. База зависит от цели: весь заказ — сумма заказа;
     * позиция/категория — сумма подходящих строк. Фикс применяется один раз на
     * заказ и ограничен базой; процент — доля базы.
     */
    public function discountFor(PromotionContext $context): int
    {
        $base = $this->discountBase($context);

        $discount = match ($this->rewardType) {
            RewardTypeEnum::Percent => intdiv($base * $this->rewardValue, 10000),
            RewardTypeEnum::FixedAmount => $this->rewardValue,
        };

        return min($discount, $base);
    }

    private function discountBase(PromotionContext $context): int
    {
        if ($this->target === PromotionTargetEnum::Order) {
            return $context->subtotalKopecks;
        }

        $base = 0;

        foreach ($context->lines as $line) {
            $matches = $this->target === PromotionTargetEnum::Item
                ? in_array($line->menuItemExternalId, $this->targetRefs, true)
                : in_array($line->categoryExternalId, $this->targetRefs, true);

            if ($matches) {
                $base += $line->lineTotalKopecks;
            }
        }

        return $base;
    }

    public function isPromocode(): bool
    {
        return $this->type === PromotionTypeEnum::Promocode;
    }

    /** Достигнут ли общий лимит применений. */
    public function isExhausted(): bool
    {
        return $this->maxRedemptions !== null && $this->redemptionsCount >= $this->maxRedemptions;
    }

    public function registerRedemption(): void
    {
        $this->redemptionsCount++;
    }

    public function revertRedemption(): void
    {
        $this->redemptionsCount = max(0, $this->redemptionsCount - 1);
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    public static function normalizeCode(string $code): string
    {
        return mb_strtoupper(trim($code));
    }

    /**
     * @param list<string> $targetRefs
     */
    private function apply(
        string $name,
        PromotionTypeEnum $type,
        ?string $code,
        RewardTypeEnum $rewardType,
        int $rewardValue,
        PromotionTargetEnum $target,
        array $targetRefs,
        PromotionConditions $conditions,
        int $priority,
        bool $stackable,
        ?int $maxRedemptions,
        ?int $maxRedemptionsPerCustomer,
    ): void {
        $name = trim($name);

        if ($name === '') {
            throw new \DomainException('Укажите название акции');
        }

        if ($target === PromotionTargetEnum::Order) {
            $targetRefs = [];
        } else {
            $targetRefs = array_values(array_unique(array_map('strval', $targetRefs)));

            if ($targetRefs === []) {
                throw new \DomainException('Для скидки на позиции/категории укажите их идентификаторы');
            }
        }

        if ($rewardValue <= 0) {
            throw new \DomainException('Размер скидки должен быть больше нуля');
        }

        if ($rewardType === RewardTypeEnum::Percent && $rewardValue > 10000) {
            throw new \DomainException('Процент скидки не может превышать 100%');
        }

        if ($type === PromotionTypeEnum::Promocode) {
            if ($code === null || trim($code) === '') {
                throw new \DomainException('Для промокода нужно указать код');
            }

            $code = self::normalizeCode($code);
        } else {
            $code = null;
        }

        if ($maxRedemptions !== null && $maxRedemptions < 1) {
            throw new \DomainException('Лимит применений должен быть положительным');
        }

        if ($maxRedemptionsPerCustomer !== null && $maxRedemptionsPerCustomer < 1) {
            throw new \DomainException('Лимит применений на гостя должен быть положительным');
        }

        $this->name = $name;
        $this->type = $type;
        $this->code = $code;
        $this->rewardType = $rewardType;
        $this->rewardValue = $rewardValue;
        $this->target = $target;
        $this->targetRefs = $targetRefs;
        $this->conditions = $conditions;
        $this->priority = $priority;
        $this->stackable = $stackable;
        $this->maxRedemptions = $maxRedemptions;
        $this->maxRedemptionsPerCustomer = $maxRedemptionsPerCustomer;
    }
}
