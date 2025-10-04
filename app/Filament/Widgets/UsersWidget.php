<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class UsersWidget extends BaseWidget
{
    protected function getStats(): array
    {

        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        $users_stats = DB::table('users as u')
            ->selectRaw('COUNT(*) AS total_users')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS users_new_this_month', [$start, $end])
            ->first();

        $supervisors_stats = DB::table('users as u')
            ->where('u.role', \App\Enums\UserRole::SuperVisor)
            ->selectRaw('COUNT(*) AS total_supervisors')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS supervisors_new_this_month', [$start, $end])
            ->first();

        $managers_stats = DB::table('users as u')
            ->where('u.role', \App\Enums\UserRole::Manager)
            ->selectRaw('COUNT(*) AS total_managers')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS managers_new_this_month', [$start, $end])
            ->first();

        $employees_stats = DB::table('users as u')
            ->where('u.role', \App\Enums\UserRole::Employee)
            ->selectRaw('COUNT(*) AS total_employees')
            ->selectRaw('SUM(CASE WHEN u.created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS employees_new_this_month', [$start, $end])
            ->first();

        $result = [
            'total_users'             => (int) $users_stats->total_users,
            'users_new_this_month'    => (int) $users_stats->users_new_this_month,
            'total_supervisors'         => (int) $supervisors_stats->total_supervisors,
            'supervisors_new_this_month' => (int) $supervisors_stats->supervisors_new_this_month,
            'total_managers'         => (int) $managers_stats->total_managers,
            'managers_new_this_month' => (int) $managers_stats->managers_new_this_month,
            'total_employees'         => (int) $employees_stats->total_employees,
            'employees_new_this_month' => (int) $employees_stats->employees_new_this_month,
        ];

        return [
            Stat::make('جميع المستخدمين', $result['total_users'])
                ->description(
                    sprintf('%+d %s', $result['users_new_this_month'], 'مستخدم' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-plus',
                    IconPosition::Before
                )
                ->chart([1, 3, 7, 13, 20])
                ->color('success'),

            Stat::make('المشرفين', $result['total_supervisors'])
                ->description(
                    sprintf('%+d %s', $result['supervisors_new_this_month'], 'مشرف' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('primary'),

            Stat::make('المدراء', $result['total_managers'])
                ->description(
                    sprintf('%+d %s', $result['managers_new_this_month'], 'مدير' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('info'),

            Stat::make('الموظفين', $result['total_employees'])
                ->description(
                    sprintf('%+d %s', $result['employees_new_this_month'], 'موظف' . ' ' . 'جديد هذا الشهر')
                )
                ->descriptionIcon(
                    'heroicon-m-user-group',
                    IconPosition::Before
                )
                ->chart([2, 6, 12, 18, 24])
                ->color('warning'),
        ];
    }
}
