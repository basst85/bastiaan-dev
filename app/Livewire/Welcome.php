<?php

namespace App\Livewire;

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
            author: 'Bastiaan Steinmeier',
            schema: SchemaCollection::initialize()
                ->add(fn (SEOData $SEOData) => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebSite',
                    'name' => $SEOData->site_name ?? config('app.name'),
                    'url' => url('/'),
                ])
                ->add(fn () => [
                    '@context' => 'https://schema.org',
                    '@type' => 'Person',
                    'name' => 'Bastiaan Steinmeier',
                    'url' => url('/'),
                    'jobTitle' => 'Full Stack Developer',
                    'sameAs' => [
                        'https://github.com/basst85',
                        'https://www.linkedin.com/in/bastiaan-steinmeier-6391a328',
                    ],
                ]),
        ));

        return view('livewire.welcome');
    }
}
