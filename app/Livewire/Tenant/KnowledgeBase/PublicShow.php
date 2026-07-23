<?php

namespace App\Livewire\Tenant\KnowledgeBase;

use Livewire\Component;
use App\Models\KnowledgeBaseArticle;

class PublicShow extends Component
{
    public $article;

    public function mount($slug)
    {
        $this->article = KnowledgeBaseArticle::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        // Increment view count
        $this->article->increment('view_count');
    }

    public function render()
    {
        return view('livewire.tenant.knowledge-base.public-show')->layout('layouts.app');
    }
}
