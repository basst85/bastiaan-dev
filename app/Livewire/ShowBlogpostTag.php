<?php

namespace App\Livewire;

use App\Support\PersonSchema;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Sheets\Sheets;

class ShowBlogpostTag extends Component
{
    public function render(Sheets $sheets): View
    {
        $tagSlug = request()->tag;

        $posts = $sheets->all()
            ->filter(fn ($post) => (bool) $post->published)
            ->filter(fn ($post) => collect($post->tags)->contains(fn ($tag) => Str::slug($tag) === $tagSlug));

        abort_if($posts->isEmpty(), 404);

        $posts = $posts->sortByDesc(fn ($post) => $post->publish_date)->values();
        $tag = collect($posts->first()->tags)->first(fn ($t) => Str::slug($t) === $tagSlug);

        // Set SEO meta tags + JSON-LD structured data
        seo(new SEOData(
            title: 'Posts tagged "'.$tag.'" - '.config('app.name'),
            description: "Blog posts about {$tag}.",
            author: PersonSchema::NAME,
            schema: SchemaCollection::initialize()
                ->add(fn (SEOData $SEOData) => [
                    '@context' => 'https://schema.org',
                    '@type' => 'CollectionPage',
                    'name' => $SEOData->title,
                    'description' => $SEOData->description,
                    'url' => $SEOData->url,
                ])
                ->addBreadcrumbs(fn (BreadcrumbListSchema $breadcrumbListSchema): BreadcrumbListSchema => $breadcrumbListSchema->prependBreadcrumbs([
                    'Home' => url('/'),
                    'Blog' => url('/blog'),
                ])),
        ));

        return view('livewire.show-blogpost-tag', [
            'posts' => $posts,
            'tag' => $tag,
        ]);
    }
}
