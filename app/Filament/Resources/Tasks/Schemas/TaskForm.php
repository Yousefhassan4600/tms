<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('desc')
                    ->label('وصف المهمة')
                    ->required()
                    ->maxLength(255),

                Select::make('task_category_id')
                    ->label('تصنيف المهمة')
                    ->relationship('taskCategory', 'name')
                    ->required(),

                Select::make('status')
                    ->label('حالة المهمة')
                    ->options(function () {
                        return collect([
                            TaskStatus::New,
                            TaskStatus::Reviewed,
                            TaskStatus::Holding,
                            TaskStatus::Approved,
                            TaskStatus::Rejected,
                        ])->mapWithKeys(fn($r) => [$r->value => $r->label()]);
                    })
                    ->default( TaskStatus::New)
                    ->required(),

                Hidden::make('user_id')
                    ->default(fn () => auth()->id()),

                FileUpload::make('file')
                    ->label('ملف المهمة')
                    ->nullable()
                    ->maxSize(10240) // 10 MB
                    ->directory('tasks')
                    ->visibility('private'),
            ]);
    }
}
