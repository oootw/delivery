<?php

declare(strict_types=1);

namespace App\Application\License\Service;

use App\Application\Server\Entity\RegisteredServer\RegisteredServerRepositoryInterface;
use App\Application\Subscription\Entity\OwnerSubscription\OwnerSubscriptionRepositoryInterface;
use Delivery\Contracts\DTO\LicenseResponse;
use Delivery\Contracts\Enum\LicenseStatusEnum;

final class ResolveLicenseByServerToken
{
    public function __construct(
        private readonly RegisteredServerRepositoryInterface $servers,
        private readonly OwnerSubscriptionRepositoryInterface $subscriptions,
        private readonly TarifFeatureCatalog $tarifFeatureCatalog,
    ) {}

    public function resolve(string $serverToken): ?LicenseResponse
    {
        if ($serverToken === '') {
            return null;
        }

        $server = $this->servers->findByToken($serverToken);
        if ($server === null) {
            return null;
        }

        $subscription = $this->subscriptions->findCurrentByOwnerId($server->ownerId);
        if ($subscription === null) {
            return null;
        }

        $status = match ($subscription->status->value) {
            'active' => LicenseStatusEnum::ACTIVE,
            'past_due' => LicenseStatusEnum::PAST_DUE,
            'suspended' => LicenseStatusEnum::SUSPENDED,
            default => LicenseStatusEnum::EXPIRED,
        };

        return new LicenseResponse(
            tarif: $subscription->tarifCode,
            features: $this->tarifFeatureCatalog->byTarifCode($subscription->tarifCode),
            status: $status,
            validUntil: $subscription->validUntil,
        );
    }
}

