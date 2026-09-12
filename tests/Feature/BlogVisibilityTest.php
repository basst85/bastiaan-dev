<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->fixtureSlug = 'pest-fixture-unpublished';
    $this->fixtureTag = 'pest-fixture-tag';
    $this->fixturePath = base_path("posts/{$this->fixtureSlug}.md");

    File::put($this->fixturePath, <<<MD
        ---
        title: Pest fixture (unpublished)
        published: false
        publish_date: 2024-01-01 00:00
        updated_date: 2024-01-01 00:00
        author: Pest
        intro: Fixture post used by BlogVisibilityTest, never meant to be listed.
        tags: {$this->fixtureTag}
        min_read: 1
        header_image: /images/hello-world.jpg
        ---
        <p>Fixture content.</p>
        MD);
});

afterEach(function () {
    File::delete($this->fixturePath);
});

it('keeps an unpublished post reachable by its direct url', function () {
    $this->get("/blog/{$this->fixtureSlug}")->assertOk();
});

it('hides an unpublished post from the blog index', function () {
    $this->get('/blog')
        ->assertOk()
        ->assertDontSee('Pest fixture (unpublished)');
});

it('still lists a published post on the blog index', function () {
    $this->get('/blog')
        ->assertOk()
        ->assertSee('Hello, world');
});

it('hides an unpublished post from its tag page', function () {
    $this->get("/blog/tag/{$this->fixtureTag}")->assertNotFound();
});

it('returns 404 for an unknown blog slug', function () {
    $this->get('/blog/this-slug-does-not-exist')->assertNotFound();
});

it('returns 404 for a tag with no published posts', function () {
    $this->get('/blog/tag/this-tag-does-not-exist')->assertNotFound();
});

it('excludes unpublished posts and their tags from the generated sitemap', function () {
    $sitemapPath = public_path('sitemap.xml');
    $original = File::get($sitemapPath);

    try {
        Artisan::call('sitemap:generate');
        $sitemap = File::get($sitemapPath);

        expect($sitemap)
            ->not->toContain($this->fixtureSlug)
            ->not->toContain($this->fixtureTag)
            ->toContain(url('/blog/test-blog-post'))
            ->toContain(url('/blog/tag/test'))
            ->toContain(url('/modern-css'));
    } finally {
        File::put($sitemapPath, $original);
    }
});
