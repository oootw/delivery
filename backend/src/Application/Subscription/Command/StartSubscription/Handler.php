<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\StartSubscription;

use App\Application\Subscription\Entity\Subscription\Subscription;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class Handler
{
    private const CURRENCY = 'RUB';

    public function __construct(
        private readonly TarifRepositoryInterface $tarifs,
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function handle(Command $command): StartedSubscriptionDTO
    {
        $tarifCode = TarifCodeEnum::tryFrom($command->tarifCode);

        if ($tarifCode === null) {
            throw new \DomainException('Неизвестный тариф');
        }

        $tarif = $this->tarifs->getByTarifCode($tarifCode);

        if ($tarif === null) {
            throw new \DomainException('Тариф не найден');
        }

        $activeSubscription = $this->subscriptions->findActiveByUser($command->userId);

        if ($activeSubscription !== null) {
            throw new \DomainException('У вас уже есть активная подписка');
        }

        $subscription = Subscription::buildNew(
            userId: $command->userId,
            tarifCode: $tarifCode,
            invoiceId: Uuid::v4()->toRfc4122(),
        );

        $subscriptionId = $this->subscriptions->save($subscription);

        return new StartedSubscriptionDTO(
            subscriptionId: $subscriptionId,
            invoiceId: $subscription->invoiceId,
            accountId: $command->userId,
            tarifCode: $tarif->tarifCode->value,
            tarifName: $tarif->name,
            priceKopecks: $tarif->price,
            amountRubles: number_format($tarif->price / 100, 2, '.', ''),
            currency: self::CURRENCY,
        );
    }
}
