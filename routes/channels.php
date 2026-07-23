<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Organization Ticket Channel
Broadcast::channel('organization.{orgId}.ticket.{ticketId}', function (User $user, $orgId, $ticketId) {
    if ($user->organization_id !== (int) $orgId) return false;
    
    $ticket = Ticket::find($ticketId);
    if (!$ticket) return false;
    
    // Only allow org_admins, the assigned agent, or the customer
    return $user->hasRole('org_admin') || $user->id === $ticket->customer_id || $user->id === $ticket->agent_id;
});

// Organization Ticket Presence Channel
Broadcast::channel('presence-organization.{orgId}.ticket.{ticketId}', function (User $user, $orgId, $ticketId) {
    if ($user->organization_id !== (int) $orgId) return false;
    
    $ticket = Ticket::find($ticketId);
    if (!$ticket) return false;
    
    if ($user->hasRole('org_admin') || $user->id === $ticket->customer_id || $user->id === $ticket->agent_id) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    return false;
});

// Organization Agent Channel
Broadcast::channel('organization.{orgId}.agent.{agentId}', function (User $user, $orgId, $agentId) {
    return $user->organization_id === (int) $orgId && $user->id === (int) $agentId;
});

// Organization Dashboard
Broadcast::channel('organization.{orgId}.dashboard', function (User $user, $orgId) {
    return $user->organization_id === (int) $orgId && $user->hasRole('org_admin');
});

// Super Admin Platform Channel
Broadcast::channel('platform.super-admin', function (User $user) {
    return $user->hasRole('super_admin');
});
