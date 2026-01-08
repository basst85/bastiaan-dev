<?php
namespace App\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use Spatie\Sheets\Sheets;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Carbon\Carbon;

class ShowBlogpost extends Component
{
    public function render(Sheets $sheets): View
    {
        $blogpost = $sheets->get(request()->slug) ?? abort(404);

        // Set SEO meta tags
        $seoData = new SEOData(
            title: $blogpost->title,
            description: $blogpost->intro,
            author: $blogpost->author,
            image: $blogpost->header_image ? url($blogpost->header_image) : null,
            published_time: is_string($blogpost->publish_date) ? Carbon::parse($blogpost->publish_date) : $blogpost->publish_date,
            modified_time: is_string($blogpost->updated_date) ? Carbon::parse($blogpost->updated_date) : $blogpost->updated_date,
            type: 'article',
        );

        seo($seoData);

        return view('livewire.show-blogpost', [
            'blogpost' => $blogpost
        ]);
    }
}
