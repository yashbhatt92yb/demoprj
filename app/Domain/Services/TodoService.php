<?php

namespace App\Domain\Services;

use App\Models\Todo;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TodoService
{
    public function createTask(User $creator, StaffProfile $assignee, string $title, string $description, string $priority, ?\DateTime $dueDate): Todo
    {
        if (!$creator->isAdmin() && !$creator->isStaff()) {
            throw ValidationException::withMessages(['role' => 'Only admins or staff can create tasks.']);
        }

        $todo = new Todo();
        $todo->asn_to = $assignee->cab_staff_prfl_uin;
        $todo->tzk_ttl = $title;
        $todo->tzk_desp = $description;
        $todo->prio = $priority;
        $todo->due_dt = $dueDate;
        $todo->curr_stau = 'pending';
        $todo->save();

        return $todo;
    }

    public function completeTask(User $actor, Todo $todo): Todo
    {
        if ($actor->isStaff() && $todo->asn_to !== $actor->staffProfile->cab_staff_prfl_uin) {
             throw ValidationException::withMessages(['authorization' => 'You are not assigned to this task.']);
        }

        $todo->curr_stau = 'done';
        $todo->save();

        return $todo;
    }
}
