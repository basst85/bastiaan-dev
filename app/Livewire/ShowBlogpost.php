<?php
namespace App\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use Spatie\Sheets\Sheets;

class ShowBlogpost extends Component
{
    public function render(Sheets $sheets): View
    {
        $blogpost = $sheets->get(request()->slug) ?? abort(404);

        return view('livewire.show-blogpost', [
            'blogpost' => $blogpost
        ]);
    }
}
