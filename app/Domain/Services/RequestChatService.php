<?php

namespace App\Domain\Services;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\RequestMessage;
use Illuminate\Validation\ValidationException;

class RequestChatService
{
    public function sendMessage(User $sender, ServiceRequest $request, string $body, ?string $filePath = null, ?string $fileName = null): RequestMessage
    {
        // Permission check
        if ($sender->isCustomer()) {
            if ($request->customer_id !== $sender->customerProfile->cab_custmr_prfl_uin) {
                throw ValidationException::withMessages(['authorization' => 'You do not own this request.']);
            }
            if (!$request->is_chat_enabled) {
                throw ValidationException::withMessages(['chat' => 'Chat is not enabled for this request.']);
            }
        } elseif ($sender->isStaff()) {
            // Staff assigned? Or admin?
            if (!$sender->isAdmin() && $request->assigned_to !== $sender->staffProfile->cab_staff_prfl_uin) {
                throw ValidationException::withMessages(['authorization' => 'You are not assigned to this request.']);
            }
        } else {
            // Affiliate? Admin?
            if ($sender->isAdmin()) {
                // Admin can chat
            } else {
                throw ValidationException::withMessages(['authorization' => 'You are not authorized to chat on this request.']);
            }
        }

        $message = new RequestMessage();
        $message->req_id = $request->request_id;
        $message->sender_id = $sender->id;
        $message->sender_role = $sender->role;
        $message->body = $body;
        $message->file_path = $filePath;
        $message->file_name = $fileName;
        $message->save();

        // Broadcast event
        // event(new RequestMessageCreated($message));

        return $message;
    }

    public function toggleChat(ServiceRequest $request, User $actor, bool $enabled): ServiceRequest
    {
        if (!$actor->isStaff() && !$actor->isAdmin()) {
            throw ValidationException::withMessages(['authorization' => 'Only staff can toggle chat.']);
        }

        // If staff, must be assigned
        if ($actor->isStaff() && !$actor->isAdmin()) {
             if ($request->assigned_to !== $actor->staffProfile->cab_staff_prfl_uin) {
                throw ValidationException::withMessages(['authorization' => 'You are not assigned to this request.']);
             }
        }

        $request->is_chat_enabled = $enabled;
        $request->save();

        return $request;
    }
}
