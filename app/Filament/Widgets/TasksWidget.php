<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TasksWidget extends BaseWidget
{
    protected function getStats(): array
    {

        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        $tasks_stats = DB::table('tasks as u')
            ->selectRaw('COUNT(*) AS total_tasks')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS tasks_new_this_month', [$start, $end])
            ->first();

        $new_tasks_stats = DB::table('tasks as u')
            ->where('u.status', \App\Enums\TaskStatus::New->value)
            ->selectRaw('COUNT(*) AS total_new_tasks')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS new_tasks_new_this_month', [$start, $end])
            ->first();

        $reviewed_tasks_stats = DB::table('tasks as u')
            ->where('u.status', \App\Enums\TaskStatus::Reviewed->value)
            ->selectRaw('COUNT(*) AS total_reviewed_tasks')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS reviewed_tasks_new_this_month', [$start, $end])
            ->first();

        $holding_tasks_stats = DB::table('tasks as u')
            ->where('u.status', \App\Enums\TaskStatus::Holding->value)
            ->selectRaw('COUNT(*) AS total_holding_tasks')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS holding_tasks_new_this_month', [$start, $end])
            ->first();

        $approved_tasks_stats = DB::table('tasks as u')
            ->where('u.status', \App\Enums\TaskStatus::Approved->value)
            ->selectRaw('COUNT(*) AS total_approved_tasks')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS approved_tasks_new_this_month', [$start, $end])
            ->first();

        $rejected_tasks_stats = DB::table('tasks as u')
            ->where('u.status', \App\Enums\TaskStatus::Rejected->value)
            ->selectRaw('COUNT(*) AS total_rejected_tasks')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS rejected_tasks_new_this_month', [$start, $end])
            ->first();


        $result = [
            'total_tasks' => $tasks_stats->total_tasks,
            'tasks_new_this_month' => $tasks_stats->tasks_new_this_month,
            'total_new_tasks' => $new_tasks_stats->total_new_tasks,
            'new_tasks_new_this_month' => $new_tasks_stats->new_tasks_new_this_month,
            'total_reviewed_tasks' => $reviewed_tasks_stats->total_reviewed_tasks,
            'reviewed_tasks_new_this_month' => $reviewed_tasks_stats->reviewed_tasks_new_this_month,
            'total_holding_tasks' => $holding_tasks_stats->total_holding_tasks,
            'holding_tasks_new_this_month' => $holding_tasks_stats->holding_tasks_new_this_month,
            'total_approved_tasks' => $approved_tasks_stats->total_approved_tasks,
            'approved_tasks_new_this_month' => $approved_tasks_stats->approved_tasks_new_this_month,
            'total_rejected_tasks' => $rejected_tasks_stats->total_rejected_tasks,
            'rejected_tasks_new_this_month' => $rejected_tasks_stats->rejected_tasks_new_this_month,
        ];

        return [
            Stat::make('المهام', $result['total_tasks'])
                ->description(
                    sprintf('%+d %s', $result['tasks_new_this_month'], 'مهمة' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('success'),

            Stat::make('جديد', $result['total_new_tasks'])
                ->description(
                    sprintf('%+d %s', $result['new_tasks_new_this_month'], 'مهمة' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('info'),

            Stat::make('تم المراجعة', $result['total_reviewed_tasks'])
                ->description(
                    sprintf('%+d %s', $result['reviewed_tasks_new_this_month'], 'مهمة' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('warning'),

            Stat::make('قيد الانتظار', $result['total_holding_tasks'])
                ->description(
                    sprintf('%+d %s', $result['holding_tasks_new_this_month'], 'مهمة' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('warning'),

            Stat::make('تم الموافقة', $result['total_approved_tasks'])
                ->description(
                    sprintf('%+d %s', $result['approved_tasks_new_this_month'], 'مهمة' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('success'),

            Stat::make('تم الرفض', $result['total_rejected_tasks'])
                ->description(
                    sprintf('%+d %s', $result['rejected_tasks_new_this_month'], 'مهمة' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('danger'),


        ];
    }
}
