<?php

declare(strict_types=1);

use App\Sheets\BlogPost;

return [
    'collections' => [
        'posts' => [
            'sheet_class' => BlogPost::class,
        ],
    ],
];
