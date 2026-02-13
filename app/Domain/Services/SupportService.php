<?php

namespace App\Domain\Services;

use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class SupportService
{
    public function createTicket(User $user, string $subject, string $message): SupportMessage
    {
        if (!$user->isCustomer()) {
            throw ValidationException::withMessages(['role' => 'Only customers can create support tickets.']);
        }

        $ticket = new SupportMessage();
        $ticket->user_id = $user->id;
        $ticket->customer_profile_uin = $user->customerProfile->cab_custmr_prfl_uin;
        $ticket->subject = $subject;
        $ticket->message = $message;
        $ticket->status = 'open';
        $ticket->save();

        return $ticket;
    }

    public function replyToTicket(SupportMessage $ticket, User $replier, string $message): SupportMessage
    {
        // For now support is single message. If we want conversation, we need a separate table.
        // Assuming SupportMessage is just the initial ticket.
        // Or maybe it's just "status update"

        $ticket->status = 'replied'; // Example
        $ticket->save();

        return $ticket;
    }
}
