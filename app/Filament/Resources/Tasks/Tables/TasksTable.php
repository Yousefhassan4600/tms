<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Facades\Storage;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('desc')->label('الوصف')->sortable()->searchable(),
                SelectColumn::make('status')
                    ->label('الحاله')
                    ->options(function () {
                        return collect([
                            \App\Enums\TaskStatus::New,
                            \App\Enums\TaskStatus::Reviewed,
                            \App\Enums\TaskStatus::Holding,
                            \App\Enums\TaskStatus::Approved,
                            \App\Enums\TaskStatus::Rejected,
                        ])->mapWithKeys(fn($r) => [$r->value => $r->label()]);
                    })
                    ->sortable()
                    ->searchable()
                    ->updateStateUsing(function ($state, $record, SelectColumn $column) {
                        // $state here is the newly selected value from the dropdown.
                        $new = (int) $state;
                        $old = (int) $record->status->value;

                        // If user picked "Rejected", open the modal and DO NOT persist yet.
                        if ($new === \App\Enums\TaskStatus::Rejected->value) {
                            // Trigger the row action modal:
                            $column->getLivewire()->mountTableAction('reject', (string) $record->getKey());

                            // Revert the visible select back to the old value until the modal completes.
                            return $old;
                        }

                        // Otherwise, save immediately and manage timestamps.
                        $payload = ['status' => $new];

                        if ($new === \App\Enums\TaskStatus::Approved->value) {
                            $payload['approved_at'] = now();
                            $payload['rejected_at'] = null;
                            $payload['reject_reason'] = null;
                        } else {
                            // Clear approval/rejection metadata for non-terminal statuses as you prefer
                            $payload['approved_at'] = null;
                            $payload['rejected_at'] = null;
                            $payload['reject_reason'] = null;
                        }

                        $record->update($payload);

                        // Tell Filament what to show in the cell after saving.
                        return $new;
                    })
                    ->disabled(fn($record) =>
                        in_array($record->status, [\App\Enums\TaskStatus::Approved, \App\Enums\TaskStatus::Rejected])
                        || auth()->user()->role->value === 3
                    ),
                TextColumn::make('taskCategory.name')->label('التصنيف')->sortable()->searchable(),
                TextColumn::make('user.name')->label('المستخدم')->sortable()->searchable(),
                TextColumn::make('reject_reason')->label('سبب الرفض')->sortable()->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y h:i A')
                    ->label('تاريخ الإنشاء')->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y h:i A')
                    ->label('تاريخ التحديث')->sortable(),
                TextColumn::make('approved_at')
                    ->dateTime('d/m/Y h:i A')
                    ->label('تاريخ الموافقة')->sortable(),
                TextColumn::make('rejected_at')
                    ->dateTime('d/m/Y h:i A')
                    ->label('تاريخ الرفض')->sortable(),

            ])
            ->recordUrl(
                fn($record) => auth()->user()->role->value !== 1 ? null : route('filament.admin.resources.tasks.edit', $record)
            )

            ->filters([])
            ->recordActions([
                ActionGroup::make([

                    ViewAction::make()
                        ->label('عرض')

                        ->icon('heroicon-m-eye'),
                    EditAction::make()
                        ->visible(fn($record) => auth()->user()->role->value === 1 )
                        ->disabled(fn($record) => auth()->user()->role->value !== 1 ),
                    Action::make('reject')                // 👈 this must exist for mountTableAction() to work
                        ->label('رفض')
                        ->icon('heroicon-m-x-circle')
                        ->modalHeading('سبب الرفض')
                        ->schema([
                            Textarea::make('reject_reason')
                                ->label('سبب الرفض')
                                ->required()
                                ->maxLength(500),
                        ])
                        ->modalSubmitActionLabel('تأكيد الرفض')
                        ->action(function ($record, array $data) {
                            $record->update([
                                'status'        => \App\Enums\TaskStatus::Rejected->value,
                                'rejected_at'   => now(),
                                'reject_reason' => $data['reject_reason'],
                                'approved_at'   => null,
                            ]);
                        })
                        ->color('danger')
                        ->hidden(fn($record) => ($record->status === \App\Enums\TaskStatus::Rejected || $record->status === \App\Enums\TaskStatus::Approved)),
                    Action::make('view_file')
                        ->label('عرض الملف')
                        ->icon('heroicon-m-eye')
                        ->openUrlInNewTab()
                        ->url(fn($record) => Storage::url($record->file))
                        ->hidden(fn($record) => !$record->file)
                        ->color('success'),

                ]),
            ])
            ->toolbarActions([]);
    }
}
