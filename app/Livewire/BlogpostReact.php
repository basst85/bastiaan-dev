<?php

namespace App\Livewire;

use App\Models\BlogReaction;
use App\Jobs\AddReactionToBlogpost;
use Livewire\Component;

class BlogpostReact extends Component
{
    public $slug;
    public $reactionCounts = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadReactionCounts();
    }

    public function loadReactionCounts()
    {
        $reactions = BlogReaction::where('blog_post_slug', $this->slug)
            ->selectRaw('reaction, COUNT(*) as count')
            ->groupBy('reaction')
            ->pluck('count', 'reaction')
            ->toArray();

        $this->reactionCounts = [
            'like' => $reactions['like'] ?? 0,
            'love' => $reactions['love'] ?? 0,
            'wow' => $reactions['wow'] ?? 0,
            'haha' => $reactions['haha'] ?? 0,
        ];
    }

    public function addReaction($reaction)
    {
        if (session()->has('reaction.' . $this->slug)) {
            return;
        }

        AddReactionToBlogpost::dispatch($this->slug, $reaction);

        session()->put('reaction.' . $this->slug, $reaction);
        session()->flash('message', 'Thanks!');

        // Update counts immediately for better UX
        $this->reactionCounts[$reaction] = ($this->reactionCounts[$reaction] ?? 0) + 1;
    }

    public function render()
    {
        return view('livewire.blogpost-react');
    }
}
