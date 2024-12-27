<?php
namespace App\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use Spatie\Sheets\Sheets;

class IndexBlogpost extends Component
{
    public function render(Sheets $blogposts): View
    {

        return view('livewire.index-blogpost', [
            'blogposts' => $blogposts->all()
        ]);
    }
}
