<?php

namespace App\Livewire;

use App\Support\PersonSchema;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Schema\ArticleSchema;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\Schema\FaqPageSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Sheets\Sheets;

class ShowBlogpost extends Component
{
    public function render(Sheets $sheets): View
    {
        $blogpost = $sheets->get(request()->slug) ?? abort(404);

        // Set SEO meta tags + JSON-LD structured data
        $seoData = new SEOData(
            title: $blogpost->title,
            description: $blogpost->intro,
            author: $blogpost->author,
            image: $blogpost->header_image ? url($blogpost->header_image) : null,
            published_time: is_string($blogpost->publish_date) ? Carbon::parse($blogpost->publish_date) : $blogpost->publish_date,
            modified_time: is_string($blogpost->updated_date) ? Carbon::parse($blogpost->updated_date) : $blogpost->updated_date,
            schema: SchemaCollection::initialize()
                ->addArticle(function (ArticleSchema $articleSchema): ArticleSchema {
                    $articleSchema->type = 'BlogPosting';
                    $articleSchema->authors = PersonSchema::asArray();

                    return $articleSchema;
                })
                ->addBreadcrumbs(fn (BreadcrumbListSchema $breadcrumbs): BreadcrumbListSchema => $breadcrumbs->prependBreadcrumbs([
                    'Home' => url('/'),
                    'Blog' => url('/blog'),
                ]))
                ->when(! empty($blogpost->faq), fn (SchemaCollection $schema): SchemaCollection => $schema->addFaqPage(
                    function (FaqPageSchema $faqPageSchema) use ($blogpost): FaqPageSchema {
                        foreach ($blogpost->faq as $item) {
                            $faqPageSchema->addQuestion($item['question'], $item['answer']);
                        }

                        return $faqPageSchema;
                    }
                )),
            type: 'article',
        );

        seo($seoData);

        return view('livewire.show-blogpost', [
            'blogpost' => $blogpost,
        ]);
    }
}
