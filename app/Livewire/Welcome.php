<?php

namespace App\Livewire;

use App\Support\PersonSchema;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Welcome extends Component
{
    public function render()
    {
        // Set SEO meta tags + JSON-LD structured data
        seo(new SEOData(
            title: config('app.name'),
            description: 'Personal website of Bastiaan Steinmeier - Full Stack Developer',
            author: PersonSchema::NAME,
            schema: SchemaCollection::initialize()
                ->add(fn (SEOData $SEOData) => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebSite',
                    'name' => $SEOData->site_name ?? config('app.name'),
                    'url' => url('/'),
                ])
                ->add(fn () => array_merge(
                    ['@context' => 'https://schema.org'],
                    PersonSchema::asArray(),
                    ['jobTitle' => 'Full Stack Developer'],
                )),
        ));

        return view('livewire.welcome');
    }
}
