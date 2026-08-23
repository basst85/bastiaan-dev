<?php

namespace App\Sheets;

use Illuminate\Support\Collection;
use Spatie\Sheets\Sheet;

class BlogPost extends Sheet
{
    /**
     * @return array<int, string>
     */
    public function getTagsAttribute(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return Collection::make(explode(',', $value))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
