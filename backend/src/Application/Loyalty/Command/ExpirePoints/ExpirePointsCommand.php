<?php

declare(strict_types=1);

namespace App\Application\Loyalty\Command\ExpirePoints;

/**
 * Сгорание баллов по сроку жизни. Срок берётся из каждой программы лояльности
 * (pointsLifetimeDays), поэтому у команды нет параметров.
 */
class ExpirePointsCommand
{
}
