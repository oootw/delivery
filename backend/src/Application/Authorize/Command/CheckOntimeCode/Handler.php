<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CheckOntimeCode;

use App\Application\Authorize\Entity\Code\Code;
use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use Webmozart\Assert\Assert;

class Handler
{
    public function __construct(
        private readonly CodeRepositoryInterface $codes,
    ) {}
    function handle(Command $command): void
    {
        Assert::true($this->codes->validateCode(
            Code::buildNew(
                phone: $command->phone,
                codeType: CodeTypeEnum::from($command->codeType),
                code: $command->code,
            )
        ), 'Код не прошёл проверку');
    }
}
