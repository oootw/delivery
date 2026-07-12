<?php

declare(strict_types=1);

namespace App\Application\Menu\Nutrition;

/**
 * БЖУ и калорийность для одного базиса (на 100 г либо на порцию). Значения в целых
 * единицах: калории — ккал, белки/жиры/углеводы — граммы. Все поля nullable.
 */
final class NutritionFacts
{
    public function __construct(
        public readonly ?int $kcal,
        public readonly ?int $proteins,
        public readonly ?int $fats,
        public readonly ?int $carbs,
    ) {}

    public function isEmpty(): bool
    {
        return $this->kcal === null
            && $this->proteins === null
            && $this->fats === null
            && $this->carbs === null;
    }

    public static function merge(?self $base, ?self $override): ?self
    {
        if ($base === null && $override === null) {
            return null;
        }

        $base ??= new self(null, null, null, null);
        $override ??= new self(null, null, null, null);

        $merged = new self(
            kcal: $override->kcal ?? $base->kcal,
            proteins: $override->proteins ?? $base->proteins,
            fats: $override->fats ?? $base->fats,
            carbs: $override->carbs ?? $base->carbs,
        );

        return $merged->isEmpty() ? null : $merged;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'kcal' => $this->kcal,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
        ];
    }

    /**
     * @param array<string, mixed>|null $data
     */
    public static function fromArray(?array $data): ?self
    {
        if ($data === null) {
            return null;
        }

        $facts = new self(
            kcal: isset($data['kcal']) ? (int) $data['kcal'] : null,
            proteins: isset($data['proteins']) ? (int) $data['proteins'] : null,
            fats: isset($data['fats']) ? (int) $data['fats'] : null,
            carbs: isset($data['carbs']) ? (int) $data['carbs'] : null,
        );

        return $facts->isEmpty() ? null : $facts;
    }
}
