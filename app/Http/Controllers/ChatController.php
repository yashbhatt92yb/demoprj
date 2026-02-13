<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ServiceRequest;
use App\Models\RequestMessage;
use App\Domain\Services\RequestChatService;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(RequestChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function sendMessage(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'body' => 'required|string',
            // 'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            $message = $this->chatService->sendMessage(
                $request->user(),
                $serviceRequest,
                $request->body,
                null, // Handle file upload later
                null
            );

            return response()->json($message);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function getMessages(Request $request, ServiceRequest $serviceRequest)
    {
        // Simple authorization check
        $user = $request->user();
        if ($user->isCustomer()) {
            if ($serviceRequest->customer_id !== $user->customerProfile->cab_custmr_prfl_uin) {
                abort(403);
            }
        } elseif ($user->isStaff()) {
            if (!$user->isAdmin() && $serviceRequest->assigned_to !== $user->staffProfile->cab_staff_prfl_uin) {
                abort(403);
            }
        }

        $messages = RequestMessage::with('sender')
            ->where('req_id', $serviceRequest->request_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
