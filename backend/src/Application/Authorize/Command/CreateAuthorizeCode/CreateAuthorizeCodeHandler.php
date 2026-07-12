<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CreateAuthorizeCode;

use App\Application\Authorize\Entity\Code\Code;
use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use App\Application\Authorize\Service\CreateUniqueCodeService\CreateUniqueCodeService;

class CreateAuthorizeCodeHandler
{
    public function __construct(
        private readonly CodeRepositoryInterface $codes,
        private readonly CreateUniqueCodeService $uniqueCodeService,
    ) {}
    public function handle(CreateAuthorizeCodeCommand $command)
    {
        $uniqueCode = $this->uniqueCodeService->createUniqueCode();

        $authorizeCode = Code::buildNew(
            phone: $command->phone,
            codeType: CodeTypeEnum::Authorize,
            code: $uniqueCode,
        );

        $authorizeCode->setId($this->codes->create($authorizeCode));

        return new AuthorizeCodeDTO(
            id: $authorizeCode->id,
            phone: $authorizeCode->phone,
            code: $authorizeCode->code,
            codeType: $authorizeCode->codeType->value,
        );
    }
}
