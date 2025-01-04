<?php

namespace App\Enums;

enum BlogReactionType: string
{
    case LIKE = 'like';
    case LOVE = 'love';
    case WOW = 'wow';
    case HAHA = 'haha';

    public static function getValues(): array
    {
        return [
            self::LIKE,
            self::LOVE,
            self::WOW,
            self::HAHA,
        ];
    }
}
