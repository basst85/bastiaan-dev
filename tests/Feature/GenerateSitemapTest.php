<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->sitemapPath = public_path('sitemap.xml');
    $this->originalSitemap = File::get($this->sitemapPath);
});

afterEach(function () {
    File::put($this->sitemapPath, $this->originalSitemap);
});

it('regenerates sitemap.xml with the fixed pages and published blog content', function () {
    Artisan::call('sitemap:generate');

    $xml = simplexml_load_string(File::get($this->sitemapPath));
    $xml->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    $urlFor = function (string $loc) use ($xml) {
        $matches = $xml->xpath("//s:url[s:loc='{$loc}']");

        return $matches[0] ?? null;
    };

    $home = $urlFor(url('/'));
    expect($home)->not->toBeNull();
    expect((string) $home->priority)->toBe('1.0');
    expect((string) $home->changefreq)->toBe('monthly');

    $blogIndex = $urlFor(url('/blog'));
    expect($blogIndex)->not->toBeNull();
    expect((string) $blogIndex->priority)->toBe('0.9');

    $contact = $urlFor(url('/contact'));
    expect($contact)->not->toBeNull();
    expect((string) $contact->priority)->toBe('0.5');

    $modernCss = $urlFor(url('/modern-css'));
    expect($modernCss)->not->toBeNull();
    expect((string) $modernCss->priority)->toBe('0.5');

    $post = $urlFor(url('/blog/test-blog-post'));
    expect($post)->not->toBeNull();
    expect((string) $post->priority)->toBe('0.8');
    expect((string) $post->lastmod)->not->toBeEmpty();

    $tag = $urlFor(url('/blog/tag/test'));
    expect($tag)->not->toBeNull();
    expect((string) $tag->priority)->toBe('0.6');
});

it('reports the number of URLs it wrote', function () {
    Artisan::call('sitemap:generate');

    $urlCount = simplexml_load_string(File::get($this->sitemapPath))->url->count();

    expect(Artisan::output())->toContain("Sitemap generated with {$urlCount} URLs");
});
