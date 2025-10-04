<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                        ->searchable(),
                 TextColumn::make('taskCategory.name')->label('التصنيف')->sortable()->searchable(),
                 TextColumn::make('user.name')->label('المستخدم')->sortable()->searchable(),
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
            ->filters([
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
