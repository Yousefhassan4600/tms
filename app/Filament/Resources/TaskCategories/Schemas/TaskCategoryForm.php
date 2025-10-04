<?php

namespace App\Filament\Resources\TaskCategories\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TaskCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم التصنيف')
                    ->required()
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->columnSpanFull()
                    ->label('نشط')
                    ->default(true),
            ]);
    }
}
