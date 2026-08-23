<?php

namespace App\Support;

class PersonSchema
{
    public const NAME = 'Bastiaan Steinmeier';

    /**
     * @return array<string, mixed>
     */
    public static function asArray(): array
    {
        return [
            '@type' => 'Person',
            'name' => self::NAME,
            'url' => url('/'),
            'sameAs' => [
                'https://github.com/basst85',
                'https://www.linkedin.com/in/bastiaan-steinmeier-6391a328',
            ],
        ];
    }
}
