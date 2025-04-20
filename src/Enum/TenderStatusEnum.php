<?php

namespace App\Enum;


enum TenderStatusEnum: string
{
    case STATUS_CLOSE = 'Закрыто';

    case STATUS_CANCELED = 'Отменено';

    case STATUS_OPEN = 'Открыто';
    public const array VALUES = [
        'Закрыто',
        'Отменено',
        'Открыто',
    ];

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
