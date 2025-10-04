<?php

namespace App\Filament\Resources\TaskCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TaskCategoriesTable
{


    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                 TextColumn::make('name')->label('اسم التصنيف')->sortable()->searchable(),
                 IconColumn::make('is_active')
                     ->boolean()
                     ->label('نشط')->sortable(),
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
