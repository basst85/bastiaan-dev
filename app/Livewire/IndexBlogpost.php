<?php
namespace App\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use Spatie\Sheets\Sheets;

class IndexBlogpost extends Component
{
    public function render(Sheets $sheets): View
    {

        $posts = $sheets->all()
            ->sortByDesc(fn($post) => $post->publish_date)
            ->values()
            ->all();

        return view('livewire.index-blogpost', [
            'blogposts' => $posts
        ]);
    }
}
