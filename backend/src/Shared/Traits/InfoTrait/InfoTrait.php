<?php

declare(strict_types=1);

namespace App\Shared\Traits\InfoTrait;

trait InfoTrait
{
    private readonly HelpInfo $helpInfo;
    public function __construct()
    {
        $this->helpInfo = new HelpInfo(
            new \DateTimeImmutable(),
        );
    }

    public function getHelpInfo(): HelpInfo
    {
        return $this->helpInfo;
    }
}
