<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $signupsToday = 0;
    public $totalOpenTickets = 0;
    public $mrr = 0;

    public function mount()
    {
        $this->loadMetrics();
    }

    #[On('echo-private:platform.super-admin,PlatformMetricsUpdated')]
    public function updateMetrics($event)
    {
        $this->signupsToday = $event['signupsToday'];
        $this->totalOpenTickets = $event['totalOpenTickets'];
        $this->mrr = $event['mrr'];
    }

    public function loadMetrics()
    {
        $this->signupsToday = Organization::whereDate('created_at', Carbon::today())->count();
        $this->totalOpenTickets = Ticket::where('status', 'open')->count();
        
        $this->mrr = Organization::where('status', 'active')
            ->join('plans', 'organizations.plan_id', '=', 'plans.id')
            ->sum('plans.price_cents') / 100;
            
        // Broadcast the update so other super admins see it live
        broadcast(new \App\Events\PlatformMetricsUpdated($this->signupsToday, $this->totalOpenTickets, $this->mrr))->toOthers();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function suspend($orgId)
    {
        Organization::where('id', $orgId)->update(['status' => 'suspended']);
        $this->loadMetrics();
    }

    public function reactivate($orgId)
    {
        Organization::where('id', $orgId)->update(['status' => 'active']);
        $this->loadMetrics();
    }

    public function impersonate($orgId)
    {
        $org = Organization::findOrFail($orgId);
        
        $orgAdmin = User::where('organization_id', $orgId)
            ->whereHas('roles', function($q) {
                $q->where('name', 'org_admin');
            })->first();

        if ($orgAdmin) {
            session(['impersonating' => auth()->id()]);
            Auth::login($orgAdmin);
            return redirect()->to('http://' . $org->slug . '.' . preg_replace('#^https?://#', '', env('APP_URL', 'pulsedesk.test')) . '/dashboard');
        }
    }

    public function render()
    {
        $query = Organization::withCount([
            'users as agent_count' => function ($query) {
                $query->whereHas('roles', function($q) {
                    $q->whereIn('name', ['agent', 'org_admin']);
                });
            },
            'tickets'
        ])->with('plan');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.dashboard', [
            'organizations' => $query->paginate(10)
        ])->layout('layouts.app');
    }
}
