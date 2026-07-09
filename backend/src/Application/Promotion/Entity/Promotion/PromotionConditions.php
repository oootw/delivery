<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Условия применения акции (VO, хранится в JSON). Полный набор: минимальная сумма,
 * тип заказа, дни недели и happy-hours (по таймзоне точки), «только первый заказ»,
 * срок действия. Проверка чистая — от PromotionContext.
 */
final class PromotionConditions
{
    private const ALLOWED_ORDER_TYPES = ['delivery', 'pickup'];

    /**
     * @param list<string> $orderTypes пустой список — любой тип заказа
     * @param list<int> $daysOfWeek 1 (Пн) … 7 (Вс); пустой — любой день
     */
    public function __construct(
        public readonly ?int $minTotalKopecks,
        public readonly array $orderTypes,
        public readonly array $daysOfWeek,
        public readonly ?string $timeFrom,
        public readonly ?string $timeTo,
        public readonly bool $firstOrderOnly,
        public readonly ?\DateTimeImmutable $validFrom,
        public readonly ?\DateTimeImmutable $validTo,
    ) {}

    /**
     * @param array<string, mixed> $raw
     */
    public static function fromArray(array $raw): self
    {
        $minTotal = $raw['min_total_kopecks'] ?? null;

        if ($minTotal !== null && (!is_int($minTotal) || $minTotal < 0)) {
            throw new \DomainException('Минимальная сумма должна быть неотрицательным числом в копейках');
        }

        $timeFrom = self::parseTime($raw['time_from'] ?? null, 'time_from');
        $timeTo = self::parseTime($raw['time_to'] ?? null, 'time_to');

        if (($timeFrom === null) !== ($timeTo === null)) {
            throw new \DomainException('Для happy-hours укажите оба времени: time_from и time_to');
        }

        return new self(
            minTotalKopecks: $minTotal,
            orderTypes: self::parseOrderTypes($raw['order_types'] ?? []),
            daysOfWeek: self::parseDaysOfWeek($raw['days_of_week'] ?? []),
            timeFrom: $timeFrom,
            timeTo: $timeTo,
            firstOrderOnly: (bool) ($raw['first_order_only'] ?? false),
            validFrom: self::parseDate($raw['valid_from'] ?? null, 'valid_from'),
            validTo: self::parseDate($raw['valid_to'] ?? null, 'valid_to'),
        );
    }

    public function isSatisfiedBy(PromotionContext $context): bool
    {
        if ($this->minTotalKopecks !== null && $context->subtotalKopecks < $this->minTotalKopecks) {
            return false;
        }

        if ($this->orderTypes !== [] && !in_array($context->orderType, $this->orderTypes, true)) {
            return false;
        }

        if ($this->firstOrderOnly && !$context->isFirstOrder) {
            return false;
        }

        if ($this->validFrom !== null && $context->now < $this->validFrom) {
            return false;
        }

        if ($this->validTo !== null && $context->now > $this->validTo) {
            return false;
        }

        return $this->isWithinSchedule($context);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'min_total_kopecks' => $this->minTotalKopecks,
            'order_types' => $this->orderTypes,
            'days_of_week' => $this->daysOfWeek,
            'time_from' => $this->timeFrom,
            'time_to' => $this->timeTo,
            'first_order_only' => $this->firstOrderOnly,
            'valid_from' => $this->validFrom?->format(\DateTimeInterface::ATOM),
            'valid_to' => $this->validTo?->format(\DateTimeInterface::ATOM),
        ];
    }

    /** Проверка дней недели и happy-hours по локальному времени точки. */
    private function isWithinSchedule(PromotionContext $context): bool
    {
        if ($this->daysOfWeek === [] && $this->timeFrom === null) {
            return true;
        }

        $local = $context->now->setTimezone(new \DateTimeZone($context->timezone));

        if ($this->daysOfWeek !== [] && !in_array((int) $local->format('N'), $this->daysOfWeek, true)) {
            return false;
        }

        if ($this->timeFrom !== null && $this->timeTo !== null) {
            $current = $local->format('H:i');

            $within = $this->timeFrom <= $this->timeTo
                ? ($current >= $this->timeFrom && $current <= $this->timeTo)
                : ($current >= $this->timeFrom || $current <= $this->timeTo); // окно через полночь

            if (!$within) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $raw
     * @return list<string>
     */
    private static function parseOrderTypes(mixed $raw): array
    {
        if (!is_array($raw)) {
            throw new \DomainException('Типы заказа должны быть списком');
        }

        $orderTypes = array_values(array_map('strval', $raw));

        foreach ($orderTypes as $orderType) {
            if (!in_array($orderType, self::ALLOWED_ORDER_TYPES, true)) {
                throw new \DomainException('Неизвестный тип заказа в условиях: ' . $orderType);
            }
        }

        return $orderTypes;
    }

    /**
     * @param mixed $raw
     * @return list<int>
     */
    private static function parseDaysOfWeek(mixed $raw): array
    {
        if (!is_array($raw)) {
            throw new \DomainException('Дни недели должны быть списком');
        }

        $days = [];

        foreach ($raw as $day) {
            if (!is_int($day) || $day < 1 || $day > 7) {
                throw new \DomainException('День недели должен быть числом от 1 (Пн) до 7 (Вс)');
            }

            $days[] = $day;
        }

        return array_values(array_unique($days));
    }

    private static function parseTime(mixed $value, string $field): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_string($value) || preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $value) !== 1) {
            throw new \DomainException('Время ' . $field . ' должно быть в формате ЧЧ:ММ');
        }

        return $value;
    }

    private static function parseDate(mixed $value, string $field): ?\DateTimeImmutable
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_string($value)) {
            throw new \DomainException('Дата ' . $field . ' должна быть строкой');
        }

        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception) {
            throw new \DomainException('Некорректная дата в условии ' . $field);
        }
    }
}
