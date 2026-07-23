<?php

namespace App\Livewire\Tenant\KnowledgeBase;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KnowledgeBaseArticle;

class PublicIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = KnowledgeBaseArticle::where('published', true)->with('category');

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%');
        }

        return view('livewire.tenant.knowledge-base.public-index', [
            'articles' => $query->paginate(10)
        ])->layout('layouts.app');
    }
}
