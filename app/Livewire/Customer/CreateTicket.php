<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CreateTicket extends Component
{
    use WithFileUploads;

    public $subject = '';
    public $description = '';
    public $category_id = '';
    public $priority = 'medium';
    public $attachment;
    public $categories;

    public function mount()
    {
        $org = app(\App\Models\Organization::class);
        $this->categories = Category::where('organization_id', $org->id)->get();
        
        if (request()->has('category')) {
            $this->category_id = request()->query('category');
        }
    }

    public function save()
    {
        $org = app(\App\Models\Organization::class);
        $plan = \App\Models\Plan::find($org->plan_id);

        if ($plan && $plan->ticket_limit_per_month !== null) {
            $ticketCount = \App\Models\Ticket::where('organization_id', $org->id)
                ->whereMonth('created_at', \Carbon\Carbon::now()->month)
                ->whereYear('created_at', \Carbon\Carbon::now()->year)
                ->count();

            if ($ticketCount >= $plan->ticket_limit_per_month) {
                $this->addError('limit', 'Your workspace has reached its monthly ticket limit. Please contact support or upgrade your plan.');
                return;
            }
        }

        $validated = $this->validate([
            'subject' => 'required|min:5',
            'description' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|max:10240', // 10MB Max
        ]);

        $path = null;
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
        }

        $ticket = Ticket::create([
            'subject' => $this->subject,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'priority' => $this->priority,
            'customer_id' => Auth::id(),
        ]);

        if ($path) {
            $ticket->messages()->create([
                'sender_id' => Auth::id(),
                'message' => 'Attached a file to the ticket.',
                'attachment_path' => $path,
            ]);
        }

        session()->flash('status', 'Ticket successfully created.');
        return $this->redirectRoute('tickets.index', ['tenant' => $org->slug], navigate: true);
    }

    public function render()
    {
        return view('livewire.customer.create-ticket', [
            'categories' => Category::all()
        ])->layout('layouts.app');
    }
}
