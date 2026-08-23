<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Sheets\Sheets;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[Signature('sitemap:generate')]
#[Description('Regenerate public/sitemap.xml from the site routes and published blog posts')]
class GenerateSitemap extends Command
{
    public function handle(Sheets $sheets): int
    {
        $sitemap = Sitemap::create()
            ->add(
                Url::create(url('/'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(1.0)
            )
            ->add(
                Url::create(url('/blog'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.9)
            )
            ->add(
                Url::create(url('/contact'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.5)
            );

        $posts = $sheets->all()->filter(fn ($post) => (bool) $post->published);

        foreach ($posts as $post) {
            $updatedAt = $post->updated_date instanceof Carbon
                ? $post->updated_date
                : Carbon::parse($post->updated_date);

            $sitemap->add(
                Url::create(url('/blog/'.$post->slug))
                    ->setLastModificationDate($updatedAt)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }

        $tagSlugs = $posts->flatMap(fn ($post) => $post->tags)
            ->map(fn (string $tag) => Str::slug($tag))
            ->unique()
            ->values();

        foreach ($tagSlugs as $tagSlug) {
            $sitemap->add(
                Url::create(url('/blog/tag/'.$tagSlug))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.6)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info(sprintf('Sitemap generated with %d URLs at public/sitemap.xml.', 3 + $posts->count() + $tagSlugs->count()));

        return self::SUCCESS;
    }
}
