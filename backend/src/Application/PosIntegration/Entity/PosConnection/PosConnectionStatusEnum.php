<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Entity\PosConnection;

enum PosConnectionStatusEnum: string
{
    /** Соединение создано, но меню ещё ни разу не импортировано успешно. */
    case Pending = 'pending';

    /** Последний импорт меню прошёл успешно. */
    case Connected = 'connected';

    /** Последний импорт завершился ошибкой. */
    case Error = 'error';
}
