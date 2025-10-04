<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Task::create([
           'desc' => 'Sample Task 1',
           'file' => null,
           'status' => \App\Enums\TaskStatus::New,
            'task_category_id' => 1,
             'user_id' => 3,
           'approved_at' => null,
           'rejected_at' => null,
           'holding_at' => null,
        ]);
        Task::create([
            'desc' => 'Sample Task 2',
            'file' => null,
            'status' => \App\Enums\TaskStatus::Reviewed,
            'task_category_id' => 1,
            'user_id' => 3,
            'approved_at' => null,
            'rejected_at' => null,
            'holding_at' => null,
        ]);

        Task::create([
            'desc' => 'Sample Task 3',
            'file' => null,
            'status' => \App\Enums\TaskStatus::Holding,
            'task_category_id' => 1,
            'user_id' => 3,
            'approved_at' => null,
            'rejected_at' => null,
            'holding_at' => date('2024-01-01 10:00:00'),
        ]);
        Task::create([
            'desc' => 'Sample Task 4',
            'file' => null,
            'status' => \App\Enums\TaskStatus::Approved,
            'task_category_id' => 1,
            'user_id' => 3,
            'approved_at' => date('2024-01-01 10:00:00'),
            'rejected_at' => null,
            'holding_at' => date('2024-01-01 10:00:00'),
        ]);  Task::create([
        'desc' => 'Sample Task 5',
        'file' => null,
        'status' => \App\Enums\TaskStatus::Rejected,
        'task_category_id' => 1,
        'user_id' => 3,
        'approved_at' => null,
        'rejected_at' => date('2024-01-01 10:00:00'),
        'holding_at' => date('2024-01-01 10:00:00'),
    ]);
    }
}
