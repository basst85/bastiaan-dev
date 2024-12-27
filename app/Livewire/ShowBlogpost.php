<?php
namespace App\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use Spatie\Sheets\Sheets;

class ShowBlogpost extends Component
{
    public function render(Sheets $blogposts): View
    {
        $blogpost = $blogposts->get(request()->slug) ?? abort(404);

        return view('livewire.show-blogpost', [
            'blogpost' => $blogpost
        ]);
    }
}
