<?php

namespace App\Livewire;

use App\Jobs\AddReactionToBlogpost;
use Livewire\Component;

class BlogpostReact extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function addReaction($reaction)
    {
        if (session()->has('reaction.' . $this->slug)) return;

        AddReactionToBlogpost::dispatch($this->slug, $reaction);

        session()->put('reaction.' . $this->slug, $reaction);
        session()->flash('message', 'Thanks!');
    }

    public function render()
    {
        return view('livewire.blogpost-react');
    }
}
