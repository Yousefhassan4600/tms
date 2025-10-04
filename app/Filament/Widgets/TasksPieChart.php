<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;

class TasksPieChart extends ChartWidget
{

    public function getHeading(): string
    {
        return 'نسبة المهام حسب الحالة';
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $totalTasks = Task::query()->count();
        $newTasks = Task::query()->where('status', 1)->count();
        $reviewedTasks = Task::query()->where('status', 2)->count();
        $holdingTasks = Task::query()->where('status', 3)->count();
        $approvedTasks = Task::query()->where('status', 4)->count();
        $rejectedTasks = Task::query()->where('status', 5)->count();

        return [
            'labels' => ['جديد', 'قيد المراجعة', 'قيد الانتظار', 'تم الموافقة', 'تم الرفض'],
            'datasets' => [[
                'data' => [
                    $newTasks,
                    $reviewedTasks,
                    $holdingTasks,
                    $approvedTasks,
                    $rejectedTasks,
                ],
                'backgroundColor' => ['#3b82f6', '#8b5cf6', '#f59e0b', '#22c55e', '#ef4444'],
                'borderWidth' => 0,
            ]]
        ];
    }
}
