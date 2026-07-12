<?php

declare(strict_types=1);

namespace App\Application\Menu\Nutrition;

/**
 * Пищевая ценность товара: масса порции и БЖУ/калории на 100 г и на порцию.
 * Все поля nullable — данные приходят частично (из POS и/или ручного оверрайда).
 * merge() накладывает оверрайд на базу пофилдово: значение оверрайда важнее, где оно есть.
 */
final class Nutrition
{
    public function __construct(
        public readonly ?int $weightGrams,
        public readonly ?NutritionFacts $per100g,
        public readonly ?NutritionFacts $perPortion,
    ) {}

    public static function empty(): self
    {
        return new self(weightGrams: null, per100g: null, perPortion: null);
    }

    public function isEmpty(): bool
    {
        return $this->weightGrams === null
            && ($this->per100g === null || $this->per100g->isEmpty())
            && ($this->perPortion === null || $this->perPortion->isEmpty());
    }

    /** Накладывает оверрайд поверх базы: где у оверрайда есть значение — берём его. */
    public function merge(self $override): self
    {
        return new self(
            weightGrams: $override->weightGrams ?? $this->weightGrams,
            per100g: NutritionFacts::merge($this->per100g, $override->per100g),
            perPortion: NutritionFacts::merge($this->perPortion, $override->perPortion),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'weight_g' => $this->weightGrams,
            'per_100g' => $this->per100g?->toArray(),
            'per_portion' => $this->perPortion?->toArray(),
        ];
    }

    /**
     * @param array<string, mixed>|null $data
     */
    public static function fromArray(?array $data): self
    {
        if ($data === null) {
            return self::empty();
        }

        return new self(
            weightGrams: isset($data['weight_g']) ? (int) $data['weight_g'] : null,
            per100g: NutritionFacts::fromArray($data['per_100g'] ?? null),
            perPortion: NutritionFacts::fromArray($data['per_portion'] ?? null),
        );
    }
}
