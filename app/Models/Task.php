<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'desc',
        'reject_reason',
        'file',
        'status',
        'task_category_id',
        'user_id',
        'approved_at',
        'rejected_at',
        'holding_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'holding_at' => 'datetime',
            'status' => \App\Enums\TaskStatus::class,
        ];
    }

    public function taskCategory()
    {
        return $this->belongsTo(TaskCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
