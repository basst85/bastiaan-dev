<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Sheets\Sheets;

class IndexBlogpost extends Component
{
    public function render(Sheets $sheets): View
    {

        $posts = $sheets->all()
            ->sortByDesc(fn ($post) => $post->publish_date)
            ->values()
            ->all();

        // Set SEO meta tags + JSON-LD structured data
        seo(new SEOData(
            title: 'Blogpost overview - '.config('app.name'),
            description: 'A collection of blogposts by Bastiaan Steinmeier',
            author: 'Bastiaan Steinmeier',
            schema: SchemaCollection::initialize()
                ->add(fn (SEOData $SEOData) => [
                    '@context' => 'https://schema.org',
                    '@type' => 'CollectionPage',
                    'name' => $SEOData->title,
                    'description' => $SEOData->description,
                    'url' => $SEOData->url,
                ])
                ->addBreadcrumbs(fn (BreadcrumbListSchema $breadcrumbs): BreadcrumbListSchema => $breadcrumbs->prependBreadcrumbs([
                    'Home' => url('/'),
                ])),
        ));

        return view('livewire.index-blogpost', [
            'blogposts' => $posts,
        ]);
    }
}
