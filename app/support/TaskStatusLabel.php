<?php

namespace App\Support;

use App\Enums\TaskStatus;

class TaskStatusLabel
{
    public static function fromValue(int $value): string
    {
        return TaskStatus::from($value)->label(); // you already expose label()
    }
}
