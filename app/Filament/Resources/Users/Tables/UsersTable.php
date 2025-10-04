<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('الدور')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->name ?? $state)
                    ->color(fn($state) => match ($state->name) {
                        'SuperVisor' => 'info',
                        'Manger' => 'success',
                        'Employee' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('رقم الجوال')
                    ->formatStateUsing(function ($state, $record) {
                        $dial = $record->dial_code?->value ?? $record->dial_code;
                        return trim($dial . ' ' . $state);
                    })
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('الحالة')
                    ->translateLabel()
                    ->boolean(),
            ])
            ->filters([
                //
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
