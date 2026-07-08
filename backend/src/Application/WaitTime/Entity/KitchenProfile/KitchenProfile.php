<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Entity\KitchenProfile;

/**
 * Настройки кухни точки для оценки времени ожидания. Владелец задаёт их вручную;
 * пока настроек нет — берутся разумные значения по умолчанию (buildDefault).
 *
 * baseMinutes         — постоянная надбавка на заказ (приём, сборка, упаковка).
 * perUnitMinutes      — базовое время на одну единицу блюда (трудоёмкость).
 * parallelCapacity    — сколько заказов кухня готовит одновременно (влияет на очередь).
 * deliveryMinutes     — типичное время доставки до двери (логистическое плечо).
 */
class KitchenProfile
{
    private const DEFAULT_BASE_MINUTES = 10;
    private const DEFAULT_PER_UNIT_MINUTES = 4;
    private const DEFAULT_PARALLEL_CAPACITY = 3;
    private const DEFAULT_DELIVERY_MINUTES = 30;

    public function __construct(
        public ?int $id,
        public int $venueId,
        public int $baseMinutes,
        public int $perUnitMinutes,
        public int $parallelCapacity,
        public int $deliveryMinutes,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildDefault(int $venueId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            venueId: $venueId,
            baseMinutes: self::DEFAULT_BASE_MINUTES,
            perUnitMinutes: self::DEFAULT_PER_UNIT_MINUTES,
            parallelCapacity: self::DEFAULT_PARALLEL_CAPACITY,
            deliveryMinutes: self::DEFAULT_DELIVERY_MINUTES,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function update(int $baseMinutes, int $perUnitMinutes, int $parallelCapacity, int $deliveryMinutes): void
    {
        if ($baseMinutes < 0 || $perUnitMinutes < 0 || $deliveryMinutes < 0) {
            throw new \DomainException('Время не может быть отрицательным');
        }

        if ($parallelCapacity < 1) {
            throw new \DomainException('Кухня готовит минимум один заказ одновременно');
        }

        $this->baseMinutes = $baseMinutes;
        $this->perUnitMinutes = $perUnitMinutes;
        $this->parallelCapacity = $parallelCapacity;
        $this->deliveryMinutes = $deliveryMinutes;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
