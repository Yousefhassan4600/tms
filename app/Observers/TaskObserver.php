<?php

namespace App\Observers;

use App\Models\Task;
use Filament\Notifications\Notification;
use App\Support\TaskStatusLabel;

class TaskObserver
{
    public function updated(Task $task): void
    {
//        if ($task->wasChanged('status')) {
//            Notification::make()
//                ->title('تم تعديل حالة مهمتك')
//                ->body("({$task->id}) أصبحت: " . TaskStatusLabel::fromValue((int) $task->status->value))
//                ->success()
//                ->sendToDatabase($task->user);
//        }
    }
}
