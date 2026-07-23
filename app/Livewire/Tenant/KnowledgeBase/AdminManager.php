<?php

namespace App\Livewire\Tenant\KnowledgeBase;

use Livewire\Component;
use App\Models\KnowledgeBaseArticle;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminManager extends Component
{
    public $articles;
    public $categories;
    
    public $isEditing = false;
    public $articleId;
    public $title = '';
    public $body = '';
    public $category_id = '';
    public $published = false;

    public function mount()
    {
        $this->loadArticles();
        $this->categories = Category::all();
    }

    public function loadArticles()
    {
        $this->articles = KnowledgeBaseArticle::with('category')->latest()->get();
    }

    public function create()
    {
        $this->resetFields();
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $article = KnowledgeBaseArticle::findOrFail($id);
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->body = $article->body;
        $this->category_id = $article->category_id;
        $this->published = $article->published;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'body' => $this->body,
            'category_id' => $this->category_id ?: null,
            'published' => $this->published,
        ];

        if ($this->articleId) {
            KnowledgeBaseArticle::where('id', $this->articleId)->update($data);
        } else {
            KnowledgeBaseArticle::create($data);
        }

        $this->resetFields();
        $this->loadArticles();
    }

    public function delete($id)
    {
        KnowledgeBaseArticle::findOrFail($id)->delete();
        $this->loadArticles();
    }

    public function cancel()
    {
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->isEditing = false;
        $this->articleId = null;
        $this->title = '';
        $this->body = '';
        $this->category_id = '';
        $this->published = false;
    }

    public function render()
    {
        return view('livewire.tenant.knowledge-base.admin-manager')->layout('layouts.app');
    }
}
