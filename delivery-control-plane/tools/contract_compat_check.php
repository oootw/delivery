<?php

declare(strict_types=1);

use Delivery\Contracts\Enum\FeatureCodeEnum;
use Delivery\Contracts\Enum\LicenseStatusEnum;
use Delivery\Contracts\Enum\TarifCodeEnum;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$expectedTarifs = ['basic', 'pro', 'enterprise'];
$expectedStatuses = ['active', 'past_due', 'suspended', 'expired'];
$expectedFeatures = ['points', 'crm', 'analytics', 'support', 'customization'];

assertEnumValues('TarifCodeEnum', TarifCodeEnum::cases(), $expectedTarifs);
assertEnumValues('LicenseStatusEnum', LicenseStatusEnum::cases(), $expectedStatuses);
assertEnumValues('FeatureCodeEnum', FeatureCodeEnum::cases(), $expectedFeatures);

echo "Контракт control-plane совместим с delivery-contracts\n";

/**
 * @param list<BackedEnum> $cases
 * @param list<string> $expected
 */
function assertEnumValues(string $enumName, array $cases, array $expected): void
{
    $actual = array_map(static fn (BackedEnum $case): string => (string) $case->value, $cases);
    sort($actual);
    sort($expected);

    if ($actual !== $expected) {
        fwrite(STDERR, sprintf(
            "Несовместимость контракта в %s: [%s] != [%s]\n",
            $enumName,
            implode(', ', $actual),
            implode(', ', $expected),
        ));
        exit(1);
    }
}

